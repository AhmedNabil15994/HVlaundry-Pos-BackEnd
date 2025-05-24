<?php

namespace Modules\Baqat\Repositories\WebService;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Baqat\Entities\Baqat;
use Modules\Baqat\Entities\BaqatSubscription;
use Modules\Baqat\Traits\BaqatTrait;
use Modules\Order\Entities\PaymentStatus;

class PackageSubscriptionRepository
{
    use BaqatTrait;

    protected $baqatSubscription;
    protected $baqat;

    public function __construct(BaqatSubscription $baqatSubscription, Baqat $baqat)
    {
        $this->baqatSubscription = $baqatSubscription;
        $this->baqat = $baqat;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        return $this->baqatSubscription->orderBy($order, $sort)->get();
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        return $this->baqatSubscription->orderBy($order, $sort)->get();
    }

    public function findById($id, $with = [])
    {
        $query = $this->baqatSubscription->withDeleted();
        if (!empty($with)) {
            $query = $query->with($with);
        }
        return $query->find($id);
    }

    public function create($request)
    {
        DB::beginTransaction();
        $baqa = $this->baqat->find($request->baqat_id);
        if (!$baqa) {
            return false;
        }

        $baqaPrice = floatval($baqa->price);
        if (!is_null($baqa->offer)) {
            if (!is_null($baqa->offer->offer_price)) {
                $baqaPrice = $baqa->offer->offer_price;
            } else {
                $baqaPrice = calculateOfferAmountByPercentage($baqaPrice, $baqa->offer->percentage);
            }
        }

        $startDate = Carbon::now()->format('Y-m-d');
        $lastUserSubscription = $this->getUserLastSubscription($request->user_id);
        if (!is_null($lastUserSubscription)) {
            $subscriptionStartDate = Carbon::createFromFormat('Y-m-d', $lastUserSubscription->start_at);
            $subscriptionEndDate = Carbon::createFromFormat('Y-m-d', $lastUserSubscription->end_at);
            $checkDate = Carbon::now()->between($subscriptionStartDate, $subscriptionEndDate);

            if ($subscriptionStartDate->gt(Carbon::now()) == true) {
                return __('You have current active subscription');
            }

            if ($checkDate == true) {
                // there is active subscription
                $endDate = $subscriptionEndDate->addDays(intval($baqa->duration_by_days))->format('Y-m-d');
                $subscriptionNewPrice = floatval($lastUserSubscription->price) + $baqaPrice;
            } else {
                $endDate = Carbon::now()->addDays(intval($baqa->duration_by_days))->format('Y-m-d');
                $subscriptionNewPrice = $baqaPrice;
            }

            $lastUserSubscription->update(['end_at' => $startDate, 'new_end_at' => $lastUserSubscription->end_at]);
        } else {
            $endDate = Carbon::now()->addDays(intval($baqa->duration_by_days))->format('Y-m-d');
            $subscriptionNewPrice = $baqaPrice;
        }

        try {
            $baqatSubscription = $this->baqatSubscription->create([
                'baqat_id' => $request->baqat_id,
                'user_id' => $request->user_id,
                'start_at' => $startDate,
                'end_at' => $endDate,
                'price' => $subscriptionNewPrice,
                'type' => 'admin',
                'payment_status_id' => 4, // cash
                'payment_confirmed_at' => date('Y-m-d H:i:s'),
            ]);

            $baqatSubscription->transaction()->updateOrCreate(['baqat_subscription_id' => $baqatSubscription->id], [
                'method' => 'cash',
                'result' => 'CASH',
            ]);

            DB::commit();
            return $baqatSubscription;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update($request, $id)
    {
        DB::beginTransaction();

        $baqatSubscription = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelete($baqatSubscription) : null;
        try {

            $baqa = $this->baqat->find($request->baqat_id);
            if (!$baqa) {
                return false;
            }

            $startDate = $request->start_at ?? Carbon::now()->format('Y-m-d');
            $endDate = Carbon::parse($startDate)->addDays(intval($baqa->duration_by_days))->format('Y-m-d');

            $baqatSubscription->update([
                'baqat_id' => $baqatSubscription->baqat_id,
                'user_id' => $baqatSubscription->user_id,
                'start_at' => $startDate,
                'end_at' => $endDate,
                "price" => $baqa->price,
            ]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function restoreSoftDelete($baqat)
    {
        $baqat->restore();
        return true;
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $baqat = $this->findById($id);
            if ($baqat) {
                if ($baqat->trashed()):
                    $baqat->forceDelete();
                else:
                    $baqat->delete();
                endif;
            } else {
                return false;
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteSelected($request)
    {
        DB::beginTransaction();

        try {

            foreach ($request['ids'] as $id) {
                $model = $this->delete($id);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function QueryTable($request)
    {
        $query = $this->baqatSubscription->with(['baqa', 'user'])->where(function ($query) use ($request) {
            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere(function ($query) use ($request) {
                $query->where('start_at', 'like', '%' . $request->input('search.value') . '%');
                $query->orWhere('end_at', 'like', '%' . $request->input('search.value') . '%');
            });
        });

        if(isset($request->user_id) && !empty($request->user_id)){
            $query = $query->where('user_id',$request->user_id);
        }

        return $this->filterDataTable($query, $request);
    }

    public function successQueryTable($request)
    {
        $query = $this->baqatSubscription->with(['baqa', 'user'])->successSubscriptions()->where(function ($query) use ($request) {
            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere(function ($query) use ($request) {
                $query->where('start_at', 'like', '%' . $request->input('search.value') . '%');
                $query->orWhere('end_at', 'like', '%' . $request->input('search.value') . '%');
            });
        });
        return $this->filterDataTable($query, $request);
    }

    public function filterDataTable($query, $request)
    {
        // Search Countries by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '') {
            $query->whereDate('created_at', '>=', $request['req']['from']);
        }

        if (isset($request['req']['to']) && $request['req']['to'] != '') {
            $query->whereDate('created_at', '<=', $request['req']['to']);
        }

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'only') {
            $query->onlyDeleted();
        }

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'with') {
            $query->withDeleted();
        }

        if (isset($request['req']['status']) && $request['req']['status'] == '1') {
            $query->active();
        }

        if (isset($request['req']['status']) && $request['req']['status'] == '0') {
            $query->unactive();
        }

        if (isset($request['req']['user_id']) && !empty($request['req']['user_id'])) {
            $query->where('user_id', $request['req']['user_id']);
        }

        if (isset($request['req']['baqat_id']) && !empty($request['req']['baqat_id'])) {
            $query->where('baqat_id', $request['req']['baqat_id']);
        }

        return $query;
    }

    public function updateSubscriptionPayment($request)
    {
        DB::beginTransaction();
        try {
            $subscription = $this->findById($request['OrderID'], ['baqa', 'user']);
            if (!$subscription) {
                return false;
            }

            $endDate = null;
            $subscriptionNewPrice = null;
            $durationByDays = null;
            $subscriptionsBalance = null;
            $subscriptionEndDate= null;

            if ($request['Result'] == 'CAPTURED') {
                $newPaymentStatus = optional(PaymentStatus::where('flag', 'success')->first())->id ?? $subscription->payment_status_id;
                $paymentConfirmedAt = date('Y-m-d H:i:s');
                $startDate = Carbon::now()->format('Y-m-d');
                $lastUserSubscription = $this->getUserLastSubscription($subscription->user_id);
                if (!is_null($lastUserSubscription)) {
                    $subscriptionStartDate = Carbon::createFromFormat('Y-m-d', $lastUserSubscription->start_at);
                    $subscriptionEndDate = Carbon::createFromFormat('Y-m-d', $lastUserSubscription->new_end_at ?? $lastUserSubscription->end_at);
                    $checkDate = Carbon::now()->between($subscriptionStartDate, $subscriptionEndDate);

                    if ($subscriptionStartDate->gt(Carbon::now()) == true) {
                        return false;
                    }

                    if ($checkDate == true) {
                        // there is active subscription
                        $endDate = $subscriptionEndDate->addDays(intval($subscription->baqa->duration_by_days))->format('Y-m-d');
                        $subscriptionNewPrice = floatval($lastUserSubscription->price) + $subscription->price;
                        $durationByDays = intval($subscription->baqa->duration_by_days) + intval($lastUserSubscription->baqa->duration_by_days);
                    } else {
                        $endDate = Carbon::now()->addDays(intval($subscription->baqa->duration_by_days))->format('Y-m-d');
                        $subscriptionNewPrice = $subscription->price;
                    }

                    $subscriptionsBalance = floatval($subscription->baqa->client_price);
                    $lastUserSubscription->update(['end_at' => $startDate, 'new_end_at' => $lastUserSubscription->end_at]);
                } else {
                    $subscriptionsBalance = floatval($subscription->baqa->client_price);
                }

                $userPointsCount = calculateUserPointsCount($subscription->price);
                $subscription->user->increment('loyalty_points_count', $userPointsCount);
            } else {
                $newPaymentStatus = optional(PaymentStatus::where('flag', 'failed')->first())->id ?? $subscription->payment_status_id;
                $paymentConfirmedAt = null;
            }

            $subscriptionData = [
                'payment_status_id' => $newPaymentStatus,
                'payment_confirmed_at' => $paymentConfirmedAt,
            ];

            if (!is_null($endDate)) {
                $subscriptionData['end_at'] = $endDate;
            }
            if (!is_null($subscriptionNewPrice)) {
                $subscriptionData['price'] = $subscriptionNewPrice;
            }
            if (!is_null($durationByDays)) {
                $subscriptionData['duration_by_days'] = $durationByDays;
            }

            $subscription->update($subscriptionData);

            if (!is_null($subscriptionsBalance)) {
                if($subscriptionEndDate && $subscriptionEndDate->lt(Carbon::now()) == true){
                    $subscription->user->decrement('subscriptions_balance', floatval($subscription->user->subscriptions_balance));
                    $subscription->user->increment('subscriptions_balance', $subscriptionsBalance);
                }else{
                    $subscription->user->increment('subscriptions_balance', $subscriptionsBalance);
                }
            }

            $subscription->transaction()->updateOrCreate(
                [
                    'baqat_subscription_id' => $request['OrderID'],
                ],
                [
                    'auth' => $request['Auth'],
                    'tran_id' => $request['TranID'],
                    'result' => $request['Result'],
                    'post_date' => $request['PostDate'],
                    'ref' => $request['Ref'],
                    'track_id' => $request['TrackID'],
                    'payment_id' => $request['PaymentID'],
                ]
            );

            DB::commit();
            return ($request['Result'] == 'CAPTURED') ? true : false;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }
}
