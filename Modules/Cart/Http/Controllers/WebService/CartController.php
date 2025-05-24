<?php

namespace Modules\Cart\Http\Controllers\WebService;

use Cart;
use Illuminate\Http\Request;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;
use Modules\Cart\Http\Requests\Api\CompanyDeliveryFeesConditionRequest;
use Modules\Cart\Http\Requests\Api\CreateOrUpdateCartRequest;
use Modules\Cart\Traits\CartTrait;
use Modules\Cart\Transformers\WebService\CartResource;
use Modules\Catalog\Entities\ProductCustomAddon;
use Modules\Catalog\Repositories\WebService\CatalogRepository as Product;
use Modules\Catalog\Traits\ShoppingCartTrait;
use Modules\Company\Repositories\WebService\CompanyRepository as CompanyRepo;
use Modules\User\Repositories\WebService\AddressRepository as AddressRepo;

class CartController extends WebServiceController
{
    use ShoppingCartTrait;

    protected $product;
    protected $company;
    protected $userAddress;

    public function __construct(Product $product, CompanyRepo $company, AddressRepo $userAddress)
    {
        $this->product = $product;
        $this->company = $company;
        $this->userAddress = $userAddress;
    }

    public function index(Request $request)
    {
        if (is_null($request->user_token) && !auth('api')->check()) {
            return $this->error(__('apps::frontend.general.user_token_not_found'), [], 422);
        }
        $request['user_token'] = auth('api')->id() ?? $request->user_token;
        return $this->response($this->responseData($request));
    }

    public function createOrUpdate(CreateOrUpdateCartRequest $request)
    {
        $request['user_token'] = auth('api')->id() ?? $request->user_token;
        $userToken = $request->user_token;
        $request['customer_id'] = $userToken;
        $product = $this->product->findOneProduct($request->product_id);
        if (!$product) {
            return response()->json(["errors" => __('cart::api.cart.product.not_found')], 422);
        }

        $check = $this->getCondition($request,'company_delivery_fees');
        if(!$check){
            return $this->error(__('user::webservice.address.errors.invalid_company_delivery_fees_conditions'), [], 422);
        }

        $product->product_type = 'product';
        $productCartId = $product->id;
        $checkProduct = is_null(getCartItemById($productCartId));

        $allQty = $this->getTotalOfQtyAndPrices($productCartId, $request);
        if (gettype($allQty) == 'string') {
            return response()->json(["errors" => $allQty], 422);
        }

        $request->request->add(['all_qty' => $allQty]);
        $request->request->remove('qty');
        $errors = $this->addOrUpdateCart($product, $request);
        if ($errors) {
            return response()->json(["errors" => $errors], 422);
        }

        return $this->response($this->responseData($request));
    }

    public function remove(Request $request, $id)
    {
        $request['user_token'] = auth('api')->id() ?? $request->user_token;
        $this->removeItem($request, $id);
        return $this->response($this->responseData($request));
    }

    public function addCompanyDeliveryFeesCondition(CompanyDeliveryFeesConditionRequest $request)
    {
        /*if (getCartSubTotal($request->user_token) <= 0)
        return $this->error(__('coupon::api.coupons.validation.cart_is_empty'), [], 422);*/

        $userToken = $request->user_token;

        if (auth('api')->check()) {
            // Get user address and state by address_id
            $address = $this->userAddress->findById($request->address_id);
            if (!$address) {
                return $this->error(__('user::webservice.address.errors.address_not_found'));
            }

            $request->request->add(['state_id' => $address->state_id]);
        }

        if (config('setting.other.select_shipping_provider') == 'shipping_company') {
            $companyId = config('setting.other.shipping_company') ?? 0;
            $deliveryFeesObject = $this->company->getDeliveryPriceDetails($request->state_id, $companyId);
        } else {
            $deliveryFeesObject = null;
        }

        if ($deliveryFeesObject) {
            $this->removeConditionByName($request, 'company_delivery_fees');
            $this->companyDeliveryChargeCondition($request, floatval($deliveryFeesObject->delivery), $deliveryFeesObject->delivery_time);
        } else {
            $this->removeConditionByName($request, 'company_delivery_fees');
            return $this->error(__('catalog::frontend.checkout.validation.state_not_supported_by_company'), [], 422);
        }

        $result = $this->returnCustomResponse($request);
        return $this->response($result);
    }

    public function removeCondition(Request $request, $name)
    {
        $request['user_token'] = auth('api')->id() ?? $request->user_token;
        $this->removeConditionByName($name,$request['user_token']);
        return $this->response($this->responseData($request));
    }

    public function clear(Request $request)
    {
        $request['user_token'] = auth('api')->id() ?? $request->user_token;
        $this->clearCart($request->user_token);
        return $this->response($this->responseData($request));
    }

    public function responseData($request)
    {
        $collections = collect($this->cartDetails($request));
        $data = $this->returnCustomResponse($request);
        $data['items'] = CartResource::collection($collections);

        if (!is_null(getCartItemsCouponValue()) && getCartItemsCouponValue() > 0) {
            $data['coupon_value'] = number_format(getCartItemsCouponValue(), 2);
        } else {
            $couponDiscount = $this->getCondition($request, 'coupon_discount');
            $data['coupon_value'] = !is_null($couponDiscount) ? $couponDiscount->getValue() : null;
        }

        if (!is_null(getCartConditionByName($request['user_token'], 'company_delivery_fees'))) {
            $data['delivery_time_note'] = getCartConditionByName($request['user_token'], 'company_delivery_fees')->getAttributes()['delivery_time_note'] ?? null;
        } else {
            $data['delivery_time_note'] = null;
        }

        return $data;
    }

    protected function getVariationId($varId)
    {
        return substr($varId, strpos($varId, "-") + 1);
    }

    protected function returnCustomResponse($request)
    {
        $delivery_fees = 0;
        $delivery = getCartConditionByName($request->user_token ?? config('setting.order_default_customer_id'),'company_delivery_fees');
        if($delivery){
            $delivery_fees = $delivery->getValue();
        }

        $is_fast_delivery = $this->getFastDelivery($request->user_token);
        $subtotal = getCartSubTotal($request->user_token ?? config('setting.order_default_customer_id')) * ($is_fast_delivery ? 2:1);
        $discount = getCartItemsCouponValue($request->user_token ?? config('setting.order_default_customer_id'));
        $total = $subtotal + $delivery_fees - $discount;

        return [
            'conditions' => $this->getCartConditions($request),
            'subTotal' => number_format($subtotal,3),
            'total' => number_format($total,3),
            'count' => $this->cartCount($request),
        ];
    }

    private function getTotalOfQtyAndPrices($productId, $request)
    {
        $checkCondition = getCartConditionByName($request['user_token'], 'company_delivery_fees');
        if($checkCondition){
            $isFastDelivery = $checkCondition->getAttributes()['is_fast_delivery'] ?? 0;
        }

        $qty = $request->qty;
        $result = [];
        $totalQty = 0;
        $totalPrice = 0;
        foreach ($qty as $key => $value) {
            $requestQty = intval($value['qty']);
            if ($requestQty > 0 && $value['addon_id']) {
                $totalQty += $requestQty;
                $addonObject = ProductCustomAddon::with('addon')
                    ->whereHas('addon', function ($query) {
                        $query->active();
                    })
                    ->where('product_id', $productId)
                    ->where('custom_addon_id', $value['addon_id'])
                    ->first();

                if (is_null($addonObject)) {
                    return __('Addon is not found currently!');
                }

                if (!is_null($addonObject->qty) && $requestQty > $addonObject->qty) {
                    return __('The required quantity is greater than the current quantity of the addition!');
                }

                $addonPrice = floatval($addonObject->price);
//                if ($isFastDelivery == true) {
//                    $addonPrice = 2 * $addonPrice;
//                }

                $totalPrice += intval($value['qty']) * $addonPrice;
                $result['models'][$key] = $addonObject;
                $result['qty_details'][$key] = [
                    'qty' => $requestQty,
                    'price' => $addonPrice,
                    'addon_id' => $value['addon_id'],
                ];
            }
        }
        $result['total_qty'] = $totalQty;
        $result['total_price'] = $totalPrice;
        return $result;
    }

}
