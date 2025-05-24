<?php

namespace Modules\Baqat\Http\Controllers\WebService;

use Illuminate\Http\Request;
use Modules\Baqat\Entities\Baqat;
use Modules\Baqat\Http\Requests\WebService\PackageSubscriptionRequest;
use Modules\Baqat\Repositories\WebService\PackageRepository;
use Modules\Baqat\Repositories\WebService\PackageSubscriptionRepository;
use Modules\Baqat\Transformers\WebService\PackageResource;
use Modules\Catalog\Transformers\WebService\AutoCompleteProductResource;
use Modules\Catalog\Transformers\WebService\FilteredOptionsResource;
use Modules\Catalog\Transformers\WebService\ProductResource;
use Modules\Catalog\Transformers\WebService\CategoryResource;
use Modules\Catalog\Repositories\WebService\CatalogRepository as Catalog;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;

use Illuminate\Http\JsonResponse;
use Modules\Transaction\Services\UPaymentService;

class PackageController extends WebServiceController
{
    protected $package;
    protected $packageSubscription;
    protected $payment;

    function __construct(PackageRepository $package,PackageSubscriptionRepository $packageSubscription,UPaymentService $payment)
    {
        $this->package = $package;
        $this->packageSubscription = $packageSubscription;
        $this->payment = $payment;
    }

    public function index(Request $request)
    {
        $packages = $this->package->getAllActive();
        return $this->response(PackageResource::collection($packages));
    }

    public function show(Request $request,$id)
    {
        $package = $this->package->findById($id);
        if(!$package){
            return $this->error(__('baqat::dashboard.messages.invalid_package'));
        }
        return $this->response(new PackageResource($package));
    }

    public function subscribe(PackageSubscriptionRequest $request,$id)
    {
        $package = $this->package->findById($id);
        if(!$package){
            return $this->error(__('baqat::dashboard.messages.invalid_package'));
        }

        $packagePrice = floatval($package->price);
        if (!is_null($package->offer)) {
            if (!is_null($package->offer->offer_price)) {
                $packagePrice = $package->offer->offer_price;
            } else {
                $packagePrice = calculateOfferAmountByPercentage($packagePrice, $package->offer->percentage);
            }
        }

        $request['user_id'] = auth('api')->id();
        $request['baqat_id']    = $id;

        $subscription = $this->packageSubscription->create($request, $package, $packagePrice);
        if ($subscription) {
            if (in_array($request->payment_type, ['knet', 'cc'])) {
                $newSubscriptionObject = [
                    'id' => $subscription->id,
                    'total' => $packagePrice,
                ];
                $paymentUrl = $this->payment->send($newSubscriptionObject, $request->payment_type, 'create-subscription',['type'=>'create-subscription-api']);
                if (is_null($paymentUrl)) {
                    return $this->error(__('baqat::frontend.baqat_subscriptions.alerts.subscription_failed'));
                } else {
                    return $this->response([
                        'url' => $paymentUrl,
                        'subscription_id'   => $subscription->id
                    ]);
                }
            } else {
                return $this->error(__('baqat::frontend.baqat_subscriptions.alerts.payment_not_supported_now'));
            }
        }

        return $this->error(__('baqat::frontend.baqat_subscriptions.alerts.subscription_failed'));
    }

    public function subscriptionWebhooks(Request $request)
    {
        $this->packageSubscription->updateSubscriptionPayment($request);
    }

    public function subscriptionSuccess(Request $request)
    {
        $checkSubscription = $this->packageSubscription->updateSubscriptionPayment($request);
        $subscription = $this->packageSubscription->findById($request['OrderID'], ['baqa', 'user']);
        return $checkSubscription ? $this->redirectToPaymentOrOrderPage($subscription) : $this->redirectToFailedPayment();
    }

    public function subscriptionFailed(Request $request)
    {
        $this->packageSubscription->updateSubscriptionPayment($request);
        return $this->redirectToFailedPayment();
    }

    public function redirectToPaymentOrOrderPage($subscription)
    {
        return $this->response([
            'subscription' => $subscription
        ],  __('baqat::frontend.baqat_subscriptions.alerts.subscription_success'));
    }

    public function redirectToFailedPayment()
    {
        return $this->error(__('baqat::frontend.baqat_subscriptions.alerts.subscription_failed'));
    }
}
