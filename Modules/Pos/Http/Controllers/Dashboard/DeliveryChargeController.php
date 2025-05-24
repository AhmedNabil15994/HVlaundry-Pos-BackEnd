<?php

namespace Modules\Pos\Http\Controllers\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Apps\Repositories\Frontend\WorkingTimeRepository as WorkingTimeRepo;
use Modules\Catalog\Traits\ShoppingCartTrait;
use Modules\Company\Repositories\FrontEnd\DeliveryChargeRepository as DeliveryCharge;
use Modules\Order\Entities\OrderDriver;
use Modules\Order\Traits\OrderTrait;
use Modules\User\Entities\User;
use Cart;
class DeliveryChargeController extends Controller
{
    use ShoppingCartTrait;
    use OrderTrait;

    protected $deliveryCharge;
    protected $workingTime;

    public function __construct(DeliveryCharge $deliveryCharge, WorkingTimeRepo $workingTime)
    {
        $this->deliveryCharge = $deliveryCharge;
        $this->workingTime = $workingTime;
    }

    public function getPickUpWorkingTimes(Request  $request)
    {
        $deliveryCharge = $this->deliveryCharge->findByStateId($request->state_id);
        $pickUpDate = $request->pickUpDate ? Carbon::parse($request->pickUpDate) : null;

        $diff = null;
        if($pickUpDate){
            $diff = getDiffInDays($request->pickUpDate,Carbon::createFromIsoFormat('ddd', $pickUpDate->format('D')));
        }

        $workingTimes = $this->buildWorkingDateTimes($request,
            $this->workingTime->getActivePickupWorkingDays($pickUpDate ? lcfirst($pickUpDate->format('D')) : null),
            $this->workingTime->getActiveDeliveryWorkingDays(),
            $diff
        );


        $deliveryTimes = $workingTimes['deliveryWorkingDays'] ?? [];
        $pickupWorkingDays = $this->removePreviousTimes($workingTimes['pickupWorkingDays'], 'pickup_working_times');
        $newPickUp = $this->checkDriverTimes($request->state_id,$pickupWorkingDays,'pickup_working_times','pick_up_time_id','pickup_date',date('Y-m-d',strtotime($request->pickUpDate)));
        if(!$request->state_id){
            $newPickUp = $pickupWorkingDays;
        }

        $deliveryTime = null;
        $deliveryDay = null;
        $cartItems = null;
        $cartTotals = null;

        if(!count($newPickUp)){
            return response()->json([
                "message" => 'Invalid pickup times for day '. $request->pickUpDate ?? '',
                "status"    => 0,
            ],200);
        }

        $defaultPickupDayTime = $this->buildDefaultTime($newPickUp, 'pickup_working_times', ['receiving_time', 'receiving_time_text'],$diff);
        $selectedPickupFirstDay = $defaultPickupDayTime['default_day'];
        $selectedPickupFirstTime['receiving_time'] = $defaultPickupDayTime['default_time']['receiving_time'] ?? null;
        $selectedPickupFirstTime['receiving_time_text'] = $defaultPickupDayTime['default_time']['receiving_time_text'] ?? null;
        $selectedPickupFirstTime['pickup_working_times_id'] = $defaultPickupDayTime['time_id'];

        if(isset($selectedPickupFirstDay['full_date'])){
            $selectedPickupFirstDay['full_date_slash'] = date('d/m/Y',strtotime($selectedPickupFirstDay['full_date']));
        }

        if(count($deliveryTimes)){
            $deliveryTime = $deliveryTimes[0]['delivery_working_times'][0]['id'];
            $deliveryDay  = [
                'full_date_slash' => date('d/m/Y',strtotime($deliveryTimes[0]['full_date'])),
                'full_date' => $deliveryTimes[0]['full_date'],
            ];
        }

        if($pickUpDate){
            $customer_id = $request->customer_id ?? config('setting.order_default_customer_id');
            if($request->state_id && $request->address_id){
                $this->setDeliveryCondition($request->state_id,$request->address_id,$customer_id,$request->is_fast_delivery);
            }
            $condition = Cart::session($customer_id)->getCondition('company_delivery_fees') ?? null;
            $is_fast_delivery = 0;
            if($condition){
                $attrs =  $condition->getAttributes();
                $is_fast_delivery = isset($attrs['is_fast_delivery']) ? (int)$attrs['is_fast_delivery'] : 0;
            }
            $items = getCartContent($customer_id, true);
            $cartItems = view('pos::dashboard.orders.partials.cartItems',compact('items'))->render();
            $cartTotals = view('pos::dashboard.orders.partials.cartTotals',compact('customer_id','is_fast_delivery'))->render();
        }

        return response()->json([
            "message" => null,
            "status"    => 1,
            "data" => [
                'deliveryCharge' => $deliveryCharge,
                'fullData'  => [
                    'pickupWorkingDays' => $newPickUp,
                    'deliveryWorkingDays'   => $deliveryTimes,
                    'firstSelection'    => [
                        'pickup'=> [
                            'day'   => $selectedPickupFirstDay,
                            'time'  => $selectedPickupFirstTime,
                        ],
                        'delivery'  => [
                            'day'   => $deliveryDay,
                            'time'  => $deliveryTime,
                        ],
                    ],
                    'cartItems'     => $cartItems,
                    'cartTotals'   => $cartTotals,
                ],
            ],
        ], 200);
    }

    protected function setDeliveryCondition($stateId, $addressId, $userToken,$is_fast_delivery)
    {
        $companyId = 1;
        $deliveryFeesObject = $this->deliveryCharge->findByStateAndCompany($stateId, $companyId);
        if (is_null($deliveryFeesObject)) {
            return null;
        }
        $data['price'] = $deliveryFeesObject->delivery;
        $data['address_id'] = $addressId;
        $data['state_id'] = $stateId;
        $data['is_fast_delivery'] = $is_fast_delivery;

        return $this->companyDeliveryChargeCondition($data, $userToken, $deliveryFeesObject->delivery_time);
    }
    public function getDeliveryWorkingTimes(Request $request)
    {
        $pickUpDate = $request->pickUpDate ? Carbon::parse($request->pickUpDate) : null;
        $deliveryDate = $request->deliveryDate ? Carbon::parse($request->deliveryDate) : null;
        $firstDeliveryWorkingDay = null;

        if($pickUpDate){
//            $diff = getDiffInDays($request->pickUpDate,Carbon::createFromIsoFormat('ddd', $pickUpDate->format('D')));
//            if(!$diff){
                $diff = getDiffInDays($request->deliveryDate,Carbon::createFromIsoFormat('ddd', $deliveryDate->format('D')));
//            }
        }

        $workingTimes = $this->buildWorkingDateTimes($request,
            $this->workingTime->getActivePickupWorkingDays($pickUpDate ? lcfirst($pickUpDate->format('D')) : null),
            $this->workingTime->getActiveDeliveryWorkingDays($deliveryDate ? lcfirst($deliveryDate->format('D')) : null),
            $diff
        );

        $deliveryTimes = $workingTimes['deliveryWorkingDays'] ?? [];
        if(count($deliveryTimes)){
            $selectedDeliveryDay = $request->deliveryDate ? $request->deliveryDate : null;
            $firstDeliveryWorkingDay = $workingTimes['deliveryWorkingDays'][0];
            $deliveryDay  = $firstDeliveryWorkingDay['full_date'];
            if($selectedDeliveryDay >= $deliveryDay && $selectedDeliveryDay > $pickUpDate->format('Y-m-d')){
                $diffs = getDiffInDays($request->deliveryDate,Carbon::createFromIsoFormat('ddd', Carbon::parse($deliveryDay)->format('D')));
                $firstDeliveryWorkingDay['full_date'] = date('Y-m-d',strtotime($request->deliveryDate));//Carbon::parse($firstDeliveryWorkingDay['full_date'])->addDays($diffs)->format('Y-m-d');
            }else{
                $firstDeliveryWorkingDay = null;
            }
        }

        if(!$firstDeliveryWorkingDay || empty($firstDeliveryWorkingDay['delivery_working_times']) || empty($deliveryTimes)){
            return response()->json([
                "message" => 'Invalid delivery times for day '. $request->deliveryDate ?? '',
                "status"    => 0,
            ],200);
        }

        return response()->json([
            "message" => null,
            "status"    => 1,
            "data" => [
                'fullData'  => [
                    'deliveryWorkingDays'   => [$firstDeliveryWorkingDay],
                    'firstSelection'    => [
                        'delivery'  => [
                            'day'   => [
                                'full_date_slash' => date('d/m/Y',strtotime($firstDeliveryWorkingDay['full_date'])),
                                'full_date' => $firstDeliveryWorkingDay['full_date'],
                            ],
                            'time'  => $firstDeliveryWorkingDay['delivery_working_times'][0]['id'],
                        ],
                    ],
                ],
            ],
        ], 200);
    }
}
