<?php

namespace Modules\Order\Http\Controllers\WebService;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Apps\Entities\PickupWorkingTime;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;
use Modules\Apps\Repositories\Frontend\WorkingTimeRepository as WorkingTimeRepo;
use Modules\Catalog\Traits\ShoppingCartTrait;
use Modules\Company\Repositories\FrontEnd\DeliveryChargeRepository as DeliveryCharge;
use Modules\Order\Http\Requests\WebService\DeliveryDaysRequest;
use Modules\Order\Http\Requests\WebService\DeliveryInfoRequest;
use Modules\Order\Http\Requests\WebService\StartOrderValidationRequest;
use Modules\Order\Traits\OrderTrait;
use Modules\Order\Transformers\WebService\DeliveryChargeResource;
use Modules\Order\Transformers\WebService\OrderResource;
use Modules\User\Entities\Address;
use Modules\User\Repositories\WebService\AddressRepository;

class DeliveryChargeController extends WebServiceController
{
    use ShoppingCartTrait;
    use OrderTrait;

    protected $deliveryCharge;
    protected $workingTime;

    protected $address;
    protected $order;

    public function __construct(DeliveryCharge $deliveryCharge, WorkingTimeRepo $workingTime,AddressRepository  $address, \Modules\Order\Repositories\WebService\OrderRepository $order)
    {
        $this->deliveryCharge = $deliveryCharge;
        $this->workingTime = $workingTime;
        $this->address = $address;
        $this->order = $order;
    }

    public function getPickupInfo(DeliveryInfoRequest $request)
    {
        $addressObj = $this->address->findById($request->address_id);
        $deliveryCharge = $this->deliveryCharge->findByStateId($addressObj->state_id);
        $workingTimes = $this->buildWorkingTimes($request, $this->workingTime->getActivePickupWorkingDays(), $this->workingTime->getActiveDeliveryWorkingDays());
        $pickupWorkingDays = $this->removePreviousTimes($workingTimes['pickupWorkingDays'], 'pickup_working_times');

        $newPickUp = $this->checkDriverTimes($addressObj->state_id,$pickupWorkingDays,'pickup_working_times','pick_up_time_id');
        $defaultPickupDayTime = $this->buildDefaultTime($newPickUp, 'pickup_working_times', ['receiving_time', 'receiving_time_text']);
        $selectedPickupFirstDay = $defaultPickupDayTime['default_day'];

        $selectedPickupFirstTime['receiving_time'] = $defaultPickupDayTime['default_time']['receiving_time'];
        $selectedPickupFirstTime['receiving_time_text'] = $defaultPickupDayTime['default_time']['receiving_time_text'];
        $selectedPickupFirstTime['pickup_working_times_id'] = $defaultPickupDayTime['time_id'];

        return $this->response([
            'deliveryCharge' => new DeliveryChargeResource($deliveryCharge),
            'available_pick_up' => $newPickUp,
            'selectedPickupFirstTime' => $selectedPickupFirstTime,
        ]);
    }

    public function getDeliveryDays(DeliveryDaysRequest  $request)
    {
        $diff = null;
        $addressObj = $this->address->findById($request->address_id);
        $token = auth('api')->check() ? auth('api')->id() : ($addressObj->user_id ?? $request->user_token);

        $pickUpTimeObj = PickupWorkingTime::find($request->receiving_time_id);
        $request['pickUpDate'] = $request['receiving_date'];
        $request['pickUpTime'] = $pickUpTimeObj->from. ' - ' . $pickUpTimeObj->to;

        $pickUpDate = $request->pickUpDate ? Carbon::parse($request->pickUpDate) : null;
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

        $dayCode = lcfirst(substr(date('l',strtotime($pickUpDate)),0,3));
        if(!count($newPickUp) || $pickUpTimeObj->pickupWorkDay->day_code != $dayCode){
            return $this->error('Invalid pickup times for day '. $request->pickUpDate ?? '');
        }

        $defaultDayTime = $this->buildDefaultTime($deliveryTimes, 'delivery_working_times', ['delivery_time', 'delivery_time_text']);
        $selectedDeliveryFirstDay = $defaultDayTime['default_day'];
        $selectedDeliveryFirstTime['delivery_time'] = $defaultDayTime['default_time']['delivery_time'];
        $selectedDeliveryFirstTime['delivery_time_text'] = $defaultDayTime['default_time']['delivery_time_text'];
        $selectedDeliveryFirstTime['delivery_working_times_id'] = $defaultDayTime['time_id'];

        return $this->response([
            "workingDays" => $deliveryTimes,
            'selectedDeliveryFirstDay' => $selectedDeliveryFirstDay,
            'selectedDeliveryFirstTime' => $selectedDeliveryFirstTime,
        ]);
    }

    protected function setDeliveryCondition($stateId, $addressId, $userToken,$is_fast_delivery,$requestData)
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
        $data['receiving_date'] = $requestData['receiving_date'];
        $data['delivery_date'] = $requestData['delivery_date'];
        $data['pickup_working_times_id'] = $requestData['pickup_working_times_id'];
        $data['delivery_working_times_id'] = $requestData['delivery_working_times_id'];
        $data['order_type'] = $requestData['order_type'];
        $data['order_notes'] = $requestData['notes'];

        return $this->companyDeliveryChargeCondition($data, $userToken, $deliveryFeesObject->delivery_time);
    }

    public function startOrder(StartOrderValidationRequest $request)
    {
        $address = $this->address->findById($request->address_id);
        $userToken = auth('api')->check() ? auth('api')->id() : ($address->user_id ?? $request->user_token);
        $deliveryCharge = null;
        if ($address) {
            $deliveryCharge = $this->deliveryCharge->findByStateId($address->state_id);
        }

        if (is_null($deliveryCharge)) {
            return $this->error(__('order::frontend.orders.index.alerts.this_state_is_not_supported'));
        }

        $request->request->add(['state_id' => $address->state_id]);
        $pickUpDetails = $this->workingTime->getPickUpDayDetails($request->pickup_working_times_id);
        $deliveryDetails = $this->workingTime->getDeliveryDayDetails($request->delivery_working_times_id);

        $request->request->add(['receiving_time' => [
            $pickUpDetails->pickupWorkingTimes[0]->from,
            $pickUpDetails->pickupWorkingTimes[0]->to,
        ]]);

        $request->request->add(['delivery_time' => [
            $deliveryDetails->deliveryWorkingTimes[0]->from,
            $deliveryDetails->deliveryWorkingTimes[0]->to,
        ]]);

        //new conditions
        if (!is_null($request->receiving_date)) {
            if ($request->receiving_date < date('Y-m-d')) {
                return $this->error(__('Pick-up day is not available, choose another day'));
            }
        }

        if (!is_null($request->delivery_date)) {
            if ($request->delivery_date < date('Y-m-d')) {
                return $this->error(__('Delivery day is not available, choose another day'));
            }
        }

        if (!is_null($request->receiving_time)) {
            $timeFrom = $pickUpDetails->pickupWorkingTimes[0]->from;
            $timeTo = $pickUpDetails->pickupWorkingTimes[0]->to;
            $dayCode = lcfirst(substr(date('l',strtotime($request->receiving_date)),0,3));
            if ($dayCode != $pickUpDetails->pickupWorkingTimes[0]->pickupWorkDay->day_code) {
                return $this->error(__('Pick-up time is currently not available, choose another time'));
            }
        }

        if (!is_null($request->delivery_time)) {
            $timeFrom = $deliveryDetails->deliveryWorkingTimes[0]->from;
            $timeTo =  $deliveryDetails->deliveryWorkingTimes[0]->to;

            $dayCode = lcfirst(substr(date('l',strtotime($request->delivery_date)),0,3));
            if ($dayCode != $deliveryDetails->deliveryWorkingTimes[0]->deliveryWorkDay->day_code) {
                return $this->error(__('Delivery time is currently not available, choose another time'));
            }
        }

        $user = auth('api')->check() ? auth('api')->user() : $address->user;
        if($user->unPaidOrders->count() > 0){
            $this->error( __('Your are not place order due to previous order not paid.'));
        }


        if($address){
            $this->setDeliveryCondition($address->state_id,$address->id,$userToken,$request->is_fast_delivery,$request->validated());
        }
            //new conditions
        if ($request->order_type == 'direct_without_pieces') {
            $order = $this->order->createOrderDirectWithoutPieces($request, $address, $deliveryCharge->delivery);
            if (!$order) {
                return $this->error( __('order::frontend.orders.index.alerts.order_failed'));
            }

            return $this->response(new OrderResource($order),__('The request has been sent successfully!'));
        } else {
            return $this->response(__('order::api.orders.youCanOrderNow'));
        }
    }


}
