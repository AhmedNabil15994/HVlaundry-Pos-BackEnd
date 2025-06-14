<?php

use Carbon\Carbon;
use Illuminate\Support\Str;
use Modules\Baqat\Entities\BaqatSubscription;
use Modules\Cart\Entities\DatabaseStorageModel;
use Modules\Catalog\Entities\CustomAddon;
use Modules\Catalog\Entities\Product;
use Modules\Company\Entities\DeliveryCharge;
use Modules\Order\Entities\OrderCustomAddon;
use Modules\Order\Entities\OrderProduct;


if (!function_exists('getTimeGreeting')) {
    function getTimeGreeting()
    {
        $currentTime = date('H:i');
        $text = '';
        if($currentTime >= "06:00" && $currentTime <= "11:59"){
            $text = trans('apps::pos.morning');
        }elseif($currentTime >= "12:00" && $currentTime <= "17:59"){
            $text = trans('apps::pos.afternoon');
        }elseif($currentTime >= "18:00" || $currentTime >= "00:00" && $currentTime <= "05:59" ){
            $text = trans('apps::pos.evening');
        }
        return $text;
    }
}


// Active Dashboard Menu
if (!function_exists('active_menu')) {
    function active_menu($routeNames)
    {
        $routeNames = (array) $routeNames;
        return in_array(request()->segment(3), $routeNames) ? 'active' : '';
    }
}

if (!function_exists('active_slide_menu')) {
    function active_slide_menu($routeNames)
    {
        $response = [];
        foreach ((array) $routeNames as $name) {
            array_push($response, active_menu($name));
        }

        return in_array('active', $response) ? 'active open' : 'open';
    }
}

// GET THE CURRENT LOCALE
if (!function_exists('locale')) {

    function locale()
    {
        return app()->getLocale();
    }
}

// active header categories menu
if (!function_exists('activeCategoryTab')) {

    function activeCategoryTab($category, $index, $returnValue)
    {
        if (request()->has('category') && !empty(request()->get('category'))) {
            if (request()->get('category') == $category->slug) {
                return $returnValue;
            }
        } else {
            if ($index == 0) {
                return $returnValue;
            }
        }
        return is_bool($returnValue) === true ? false : '';
    }
}

// SAVE COOKIE with key and value
if (!function_exists('set_cookie_value')) {

    function set_cookie_value($key, $value, $expire = null)
    {
        $expire = $expire ?? time() + (2 * 365 * 24 * 60 * 60); // set a cookie that expires in 2 years
        setcookie($key, $value, $expire, '/');
        return true;
    }
}

// GET THE COOKIE value for Specific key
if (!function_exists('get_cookie_value')) {

    function get_cookie_value($key)
    {
        return isset($_COOKIE[$key]) && !empty($_COOKIE[$key]) ? $_COOKIE[$key] : null;
    }
}

// CHECK IF CURRENT LOCALE IS RTL
if (!function_exists('is_rtl')) {

    function is_rtl($locale = null)
    {
        $locale = ($locale == null) ? locale() : $locale;
        $rtlLocales = is_null(config('rtl_locales')) ? [] : config('rtl_locales');

        if (in_array($locale, $rtlLocales)) {
            return 'rtl';
        }

        return 'ltr';
    }
}

if (!function_exists('slugfy')) {
    /**
     * The Current dir
     *
     * @param string $locale
     */
    function slugfy($string, $separator = '-')
    {
        $url = trim($string);
        $url = strtolower($url);
        $url = preg_replace('|[^a-z-A-Z\p{Arabic}0-9 _]|iu', '', $url);
        $url = preg_replace('/\s+/', ' ', $url);
        $url = str_replace(' ', $separator, $url);

        return $url;
    }
}

if (!function_exists('slugArOld')) {
    /**
     * The Current dir
     *
     * @param string $locale
     */
    function slugArOld($string, $separator = '-')
    {
        if (is_null($string)) {
            return "";
        }

        // Remove spaces from the beginning and from the end of the string
        $string = trim($string);

        // Lower case everything
        // using mb_strtolower() function is important for non-Latin UTF-8 string | more info: https://www.php.net/manual/en/function.mb-strtolower.php
        $string = mb_strtolower($string, "UTF-8");

        // Make alphanumeric (removes all other characters)
        // this makes the string safe especially when used as a part of a URL
        // this keeps latin characters and arabic charactrs as well
        $string = preg_replace("/[^a-z0-9_\s\-ءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]#u/", "", $string);

        // Remove multiple dashes or whitespaces
        $string = preg_replace("/[\s-]+/", " ", $string);

        // Convert whitespaces and underscore to the given separator
        $string = preg_replace("/[\s_]/", $separator, $string);

        return $string;
    }
}

if (!function_exists('slugAr')) {

    function slugAr($string, $separator = '-')
    {
        if (is_null($string)) {
            return "";
        }
        $string = trim($string);
        $string = mb_strtolower($string, "UTF-8");
        // '/' and/or '\' if found and not removed it will change the get request route
        $string = str_replace('/', $separator, $string);
        $string = str_replace('\\', $separator, $string);
        $string = preg_replace("/[^a-z0-9_\sءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]/u", "", $string);
        $string = preg_replace("/[\s-]+/", " ", $string);
        $string = preg_replace("/[\s_]/", $separator, $string);
        $string = preg_replace("/[\s#]/", $separator, $string);
        return $string;
    }
}

if (!function_exists('path_without_domain')) {
    /**
     * Get Path Of File Without Domain URL
     *
     * @param string $locale
     */
    function path_without_domain($path)
    {
        $url = $path;
        $parts = explode("/", $url);
        array_shift($parts);
        array_shift($parts);
        array_shift($parts);
        $newurl = implode("/", $parts);

        return $newurl;
    }
}

if (!function_exists('int_to_array')) {
    /**
     * convert a comma separated string of numbers to an array
     *
     * @param string $integers
     */
    function int_to_array($integers)
    {
        return array_map("intval", explode(",", $integers));
    }
}

if (!function_exists('combinations')) {

    function combinations($arrays, $i = 0)
    {

        if (!isset($arrays[$i])) {
            return array();
        }

        if ($i == count($arrays) - 1) {
            return $arrays[$i];
        }

        // get combinations from subsequent arrays
        $tmp = combinations($arrays, $i + 1);

        $result = array();

        // concat each array from tmp with each element from $arrays[$i]
        foreach ($arrays[$i] as $v) {
            foreach ($tmp as $t) {
                $result[] = is_array($t) ?
                array_merge(array($v), $t) :
                array($v, $t);
            }
        }

        return $result;
    }
}

if (!function_exists('htmlView')) {
    /**
     * Access the OrderStatus helper.
     */
    function htmlView($content)
    {
        return
            '<!DOCTYPE html>
           <html lang="en">
             <head>
               <meta charset="utf-8">
               <meta http-equiv="X-UA-Compatible" content="IE=edge">
               <meta name="viewport" content="width=device-width, initial-scale=1">
               <link href="css/bootstrap.min.css" rel="stylesheet">
               <!--[if lt IE 9]>
                 <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
                 <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
               <![endif]-->
             </head>
             <body>
               ' . $content . '
               <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
               <script src="js/bootstrap.min.js"></script>
             </body>
           </html>';
    }
}

if (!function_exists('getDays')) {
    function getDays($dayCode = null)
    {
        if ($dayCode == null) {
            return [
                'sat' => __('company::dashboard.companies.availabilities.days.sat'),
                'sun' => __('company::dashboard.companies.availabilities.days.sun'),
                'mon' => __('company::dashboard.companies.availabilities.days.mon'),
                'tue' => __('company::dashboard.companies.availabilities.days.tue'),
                'wed' => __('company::dashboard.companies.availabilities.days.wed'),
                'thu' => __('company::dashboard.companies.availabilities.days.thu'),
                'fri' => __('company::dashboard.companies.availabilities.days.fri'),
            ];
        } else {
            switch ($dayCode) {
                case 'sat':
                    return __('company::dashboard.companies.availabilities.days.sat');
                    break;
                case 'sun':
                    return __('company::dashboard.companies.availabilities.days.sun');
                    break;
                case 'mon':
                    return __('company::dashboard.companies.availabilities.days.mon');
                case 'tue':
                    return __('company::dashboard.companies.availabilities.days.tue');
                    break;
                case 'wed':
                    return __('company::dashboard.companies.availabilities.days.wed');
                    break;
                case 'thu':
                    return __('company::dashboard.companies.availabilities.days.thu');
                    break;
                case 'fri':
                    return __('company::dashboard.companies.availabilities.days.fri');
                    break;
                default:
                    return 'not_exist';
            }
        }
    }
}

if (!function_exists('getFullDayByCode')) {
    function getFullDayByCode($dayCode)
    {
        switch ($dayCode) {
            case 'sat':
                return 'saturday';
                break;
            case 'sun':
                return 'sunday';
                break;
            case 'mon':
                return 'monday';
            case 'tue':
                return 'tuesday';
                break;
            case 'wed':
                return 'wednesday';
                break;
            case 'thu':
                return 'thursday';
                break;
            case 'fri':
                return 'friday';
                break;
            default:
                return null;
        }
    }
}

if (!function_exists('checkSelectedCartGiftProducts')) {
    function checkSelectedCartGiftProducts($prdId, $giftId)
    {
        $giftCondition = Cart::getCondition('gift');

        if ($giftCondition) {
            $giftsArray = $giftCondition->getAttributes()['gifts'];

            foreach ($giftsArray as $item) {
                if (in_array($prdId, $item['products']) && $item['id'] == $giftId) {
                    return true;
                }

            }
        }

        return false;
    }
}

if (!function_exists('checkSelectedCartCards')) {
    function checkSelectedCartCards($cardId)
    {
        $condition = Cart::getCondition('card');

        if ($condition && isset($condition->getAttributes()['cards'][$cardId])) {
            return $condition->getAttributes()['cards'][$cardId];
        }

        return null;
    }
}

if (!function_exists('checkSelectedCartAddons')) {
    function checkSelectedCartAddons($addonsId)
    {
        $condition = Cart::getCondition('addons');

        if ($condition && isset($condition->getAttributes()['addons'][$addonsId])) {
            return $condition->getAttributes()['addons'][$addonsId];
        }

        return null;
    }
}

if (!function_exists('checkSelectedVendorDeliveryCompany')) {
    function checkSelectedVendorDeliveryCompany($vendorId, $companyId)
    {
        $condition = Cart::getCondition('company_delivery_fees');

        if ($condition && isset($condition->getAttributes()['vendors'][$vendorId][$companyId])) {
            return 'checked';
        }

        return null;
    }
}

if (!function_exists('getDayByDayCode')) {
    function getDayByDayCode($dayCode)
    {
        if (strtotime(date('Y-m-d')) <= strtotime(date('Y-m-d', strtotime($dayCode)))) {
            return [
                'full_date' => date('Y-m-d', strtotime($dayCode)),
                'day' => date('d', strtotime($dayCode)),
            ];
        }

        return '';
    }
}

if (!function_exists('generateVariantProductData')) {
    function generateVariantProductData($product, $variantPrdId, $optionValues)
    {
        if (!empty($optionValues) && count($optionValues) > 0) {
            $generatedName = $product->title . ' - ';
            $generatedSlug = 'var=' . $variantPrdId . '&';
            foreach ($optionValues as $k => $value) {
                $optionValue = \Modules\Variation\Entities\OptionValue::with('option')->find($value);
                $generatedName .= $k == 0 ? $optionValue->title : ', ' . $optionValue->title;

                $valueSlug = Str::slug($optionValue->getTranslation('title', 'en'));
                $generatedSlug .= 'attr_' . Str::slug(Str::lower($optionValue->option->getTranslation('title', 'en'))) . '=';
                $generatedSlug .= $k === array_key_last($optionValues) ? $valueSlug : $valueSlug . '&';
            }
            return [
                'name' => $generatedName,
                'slug' => $generatedSlug,
            ];
        } else {
            return [
                'name' => '',
                'slug' => '',
            ];
        }
    }
}

if (!function_exists('getOptionQueryString')) {
    function getOptionQueryString($string)
    {
        $pieces = explode('_', $string);
        return $pieces[1];
    }
}

if (!function_exists('getOptionsAndValuesIds')) {
    function getOptionsAndValuesIds($request)
    {
        $selectedOptions = [];
        $selectedOptionsValue = [];

        foreach ($request->query() as $k => $query) {
            if (Str::startsWith($k, 'attr_')) {
                $optionTitle = Str::title(str_replace('-', ' ', getOptionQueryString($k)));
                $option = \Modules\Variation\Entities\Option::active()->anyTranslation('title', $optionTitle)->first();
                $selectedOptions[] = $option ? $option->id : "";

                $optionValTitle = Str::title(str_replace('-', ' ', $query));
                $optionVal = \Modules\Variation\Entities\OptionValue::active()->where('option_id', $option ? $option->id : 0)->anyTranslation('title', $optionValTitle)->first();
                $selectedOptionsValue[] = $optionVal ? $optionVal->id : "";
            }
        }

        return [
            'selectedOptions' => $selectedOptions,
            'selectedOptionsValue' => $selectedOptionsValue,
        ];
    }
}

if (!function_exists('generateRandomCode')) {
    function generateRandomCode($length = 8)
    {
        return Str::upper(Str::random($length));
    }
}

if (!function_exists('generateRandomNumericCode')) {
    function generateRandomNumericCode($length = 5)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (!function_exists('limitString')) {
    function limitString($string, $length = 50, $end = '...')
    {
        return Str::limit($string, $length, $end);
    }
}

if (!function_exists('toggleSideMenuItemsByVendorType')) {
    function toggleSideMenuItemsByVendorType()
    {
        return config('setting.other.is_multi_vendors') == 1 ? 'block' : 'none';
    }
}

/* if (!function_exists('getCartContent')) {
function getCartContent($userToken = null)
{
if (is_null($userToken)) {
if (auth()->check())
$userToken = auth()->user()->id ?? null;
else
$userToken = get_cookie_value(config('core.config.constants.CART_KEY')) ?? null;
}

if (!is_null($userToken))
$result = Cart::session($userToken)->getContent();
else
$result = Cart::getContent();

return $result;
}
} */

if (!function_exists('getCartContent')) {
    function getCartContent($userToken = null, $force = false)
    {
        if (!$force && session()->has('CartContent')) {
            return session()->get('CartContent');
        }

        if (is_null($userToken)) {
            if (auth()->check()) {
                $userToken = auth()->user()->id ?? null;
            } else {
                $userToken = get_cookie_value(config('core.config.constants.CART_KEY')) ?? null;
            }
        }

        if (!is_null($userToken)) {
            $query = Cart::session($userToken)->getContent();
        } else {
            $query = Cart::getContent();
        }

        $result = $query;
        $cartProductQuantity = $query->pluck('quantity', 'id');
        session()->flash('CartContent', $result);
        session()->flash('cartProductQuantity', $cartProductQuantity);
        return $result;
    }
}

if (!function_exists('getCartQuantityById')) {
    function getCartQuantityById($id, $userToken = null)
    {
        if (!session()->has('cartProductQuantity')) {
            getCartContent($userToken);
        }

        return session()->get('cartProductQuantity')[$id] ?? null;
    }
}

if (!function_exists('getCartItemById')) {
    function getCartItemById($id, $userToken = null)
    {
        if (is_null($userToken)) {
            if (auth()->check()) {
                $userToken = auth()->user()->id ?? null;
            } else {
                $userToken = get_cookie_value(config('core.config.constants.CART_KEY')) ?? null;
            }

        }

        if (!is_null($userToken)) {
            $result = Cart::session($userToken)->get($id);
        } else {
            $result = Cart::get($id);
        }

        return $result ?? null;
    }
}

if (!function_exists('getCartTotal')) {
    function getCartTotal($userToken = null)
    {
        if (is_null($userToken)) {
            if (auth()->check()) {
                $userToken = auth()->user()->id ?? null;
            } else {
                $userToken = get_cookie_value(config('core.config.constants.CART_KEY')) ?? null;
            }

        }

        if (!is_null($userToken)) {
            $result = Cart::session($userToken)->getTotal();
        } else {
            $result = Cart::getTotal();
        }

        return $result ?? null;
    }
}

if (!function_exists('getCartSubTotal')) {
    function getCartSubTotal($userToken = null)
    {
        if (is_null($userToken)) {
            if (auth()->check()) {
                $userToken = auth()->user()->id ?? null;
            } else {
                $userToken = get_cookie_value(config('core.config.constants.CART_KEY')) ?? null;
            }

        }

        if (!is_null($userToken)) {
            $result = Cart::session($userToken)->getSubTotal();
        } else {
            $result = Cart::getSubTotal();
        }

        return $result ?? null;
    }
}

if (!function_exists('getOrderShipping')) {
    function getOrderShipping($userToken = null)
    {
        if (is_null($userToken)) {
            if (auth()->check()) {
                $userToken = auth()->user()->id ?? null;
            } else {
                $userToken = get_cookie_value(config('core.config.constants.CART_KEY')) ?? null;
            }

        }

        if (!is_null($userToken)) {
            $result = Cart::session($userToken)->getCondition('company_delivery_fees') ?? null;
        } else {
            $result = Cart::getCondition('company_delivery_fees') ?? null;
        }

        return $result ? $result->getValue() : null;
    }
}

if (!function_exists('getCartConditionByName')) {
    function getCartConditionByName($userToken = null, $name = '')
    {
        if (is_null($userToken)) {
            if (auth()->check()) {
                $userToken = auth()->user()->id ?? null;
            } else {
                $userToken = get_cookie_value(config('core.config.constants.CART_KEY')) ?? null;
            }

        }

        if (!is_null($userToken)) {
            $result = Cart::session($userToken)->getCondition($name) ?? null;
        } else {
            $result = Cart::getCondition($name) ?? null;
        }

        return $result ?? null;
    }
}

if (!function_exists('addItemCondition')) {
    function addItemCondition($productId, $itemCondition, $userToken = null)
    {
        if (is_null($userToken)) {
            if (auth()->check()) {
                $userToken = auth()->user()->id ?? null;
            } else {
                $userToken = get_cookie_value(config('core.config.constants.CART_KEY')) ?? null;
            }

        }

        if (!is_null($userToken)) {
            $result = Cart::session($userToken)->addItemCondition($productId, $itemCondition);
        } else {
            $result = Cart::addItemCondition($productId, $itemCondition);
        }

        return $result ?? null;
    }
}

if (!function_exists('getCartItemsCouponValue')) {
    function getCartItemsCouponValue($userToken = null)
    {
        $value = 0;
        $items = getCartContent($userToken);
        if (!$items->isEmpty()) {
            $couponCondition = Cart::getCondition('coupon_discount');
            if ($couponCondition) {
                $value = abs($couponCondition->getValue());
            }
        }
        return $value;
    }
}

if (!function_exists('getProductCartCount')) {
    function getProductCartCount($id)
    {
        $result = DatabaseStorageModel::where('id', 'LIKE', '%cart_items%')->get()->reject(function ($item) {
            return count($item->cart_data) == 0;
        })->map(function ($item) use ($id) {
            return $item->cart_data->each(function ($collection, $key) use ($id) {
                if ($key == $id) {
                    return $collection;
                }

                //                dump($collection->toArray(), 'key::' . $key, ':::id:::' . $id);
            });
        });

        return array_values($result->toArray());
    }
}

if (!function_exists('getProductCartNotes')) {
    function getProductCartNotes($product, $variantPrd = null)
    {
        $cartPrdId = !is_null($variantPrd) ? 'var-' . $variantPrd->id : $product->id;
        if (getCartItemById($cartPrdId)) {
            return getCartItemById($cartPrdId)->attributes['notes'] ?? '';
        } else {
            return '';
        }

    }
}

if (!function_exists('calculateOfferAmountByPercentage')) {
    function calculateOfferAmountByPercentage($productPrice, $offerPercentage)
    {
        $percentageResult = (floatval($offerPercentage) * floatval($productPrice)) / 100;
        return floatval($productPrice) - $percentageResult;
    }
}

if (!function_exists('calculateOfferPercentageByAmount')) {
    function calculateOfferPercentageByAmount($productPrice, $offerAmount)
    {
        return ((floatval($productPrice) - floatval($offerAmount)) / floatval($productPrice)) * 100;
    }
}

if (!function_exists('selectedCartAddonsOption')) {
    function selectedCartAddonsOption($product, $addonsId, $optionId)
    {
        if (getCartItemById($product->id)->attributes->has('addonsOptions')) {
            $collection = collect(getCartItemById($product->id)->attributes->addonsOptions['data'])->where('id', $addonsId)->pluck('options')->toArray();
            $collection = array_first($collection);
            if (!is_null($collection) && in_array($optionId, $collection)) {
                return 'checked';
            }

        }
        return '';
    }
}

if (!function_exists('getAddonsTitle')) {
    function getAddonsTitle($id)
    {
        $item = \Modules\Catalog\Entities\AddonCategory::find($id);
        return $item ? $item->getTranslation('title', locale()) : '---';
    }
}

if (!function_exists('getAddonsOptionTitle')) {
    function getAddonsOptionTitle($id)
    {
        $item = \Modules\Catalog\Entities\AddonOption::find($id);
        return $item ? $item->getTranslation('title', locale()) : '---';
    }
}

if (!function_exists('checkIfAddonOptionIsDefault')) {
    function checkIfAddonOptionIsDefault($productId, $addonCategoryId, $addon_option_id)
    {
        $productAddon = \Modules\Catalog\Entities\ProductAddon::where('product_id', $productId)->where('addon_category_id', $addonCategoryId)->first();
        $item = $productAddon && $productAddon->addonOptions ? $productAddon->addonOptions->where('addon_option_id', $addon_option_id)->first() : null;
        return $item && $item->default == 1;
    }
}

if (!function_exists('getOrderAddonsOptionPrice')) {
    function getOrderAddonsOptionPrice($addOnsOptionIds, $optionId)
    {
        if (isset($addOnsOptionIds->addonsPriceObject)) {
            $index = array_search($optionId, array_column($addOnsOptionIds->addonsPriceObject, 'id'));
            return optional($addOnsOptionIds->addonsPriceObject[$index])->amount;
        }
        return '';
    }
}

if (!function_exists('CheckProductInUserFavourites')) {
    function CheckProductInUserFavourites($productId, $userId)
    {
        $favourite = \Modules\User\Entities\UserFavourite::where('product_id', $productId)
            ->where('user_id', $userId)->first();
        return !is_null($favourite);
    }
}

if (!function_exists('checkRouteLocale')) {
    function checkRouteLocale($model, $slug)
    {
        return $model->getTranslation("slug", locale()) == $slug;
    }
}

if (!function_exists('checkActivePayment')) {
    function checkActivePayment()
    {
        $activePaymentsCount = 0;
        foreach (array_keys(config('setting.supported_payments')) ?? [] as $key => $payment) {
            if (config('setting.supported_payments.' . $payment . '.status') == 'on') {
                $activePaymentsCount += 1;
            }
        }

        return $activePaymentsCount;
    }
}

if (!function_exists('ajaxSwitch')) {
    function ajaxSwitch($model, $url, $flag = 'dashboard', $switch = 'status', $open = 1, $close = 0)
    {
        $view = 'apps::dashboard.components.ajax-switch';
        if ($flag == 'vendor_dashboard') {
            $view = 'apps::vendor.components.ajax-switch';
        }
        return view(
            $view,
            compact('model', 'url', 'switch', 'open', 'close')
        )->render();
    }
}

if (!function_exists('getCustomDateFormat')) {
    function getCustomDateFormat($date, $format = 'Y-m-d')
    {
        return Carbon::parse($date)->isoFormat($format);
    }
}

if (!function_exists('getNextDays')) {
    function getNextDays($days = null)
    {
        $locale = locale() == 'ar' ? 'ar_KW' : 'en_US';
        if (is_null($days)) {
            return Carbon::now()->locale($locale);
        } else {
            return Carbon::now()->locale($locale)->addDays($days);
        }
    }
}

if (!function_exists('getDayByDayCodeV2')) {
    function getDayByDayCodeV2($dayCode,$diffInDays=0,$minDate = null)
    {
        $date = Carbon::createFromIsoFormat('ddd', $dayCode)->addDays($diffInDays);
        if($minDate && date('Y-m-d',strtotime($date)) < $minDate){
            $diff = getDiffInDays($minDate,$date);
            $date->addWeeks(1);
        }

        $monthNumber = $date->isoFormat('M');
        $dayNumber = date('d', strtotime($date));
        return [
            'year' => date('Y', strtotime($date)),
            'month_number' => $monthNumber,
            'day_number' => $dayNumber,
            'full_date' => $date->format('Y-m-d'),
            'shorted_translated_date' => translateDate($date, 'shorted'),
            'shorted_translated_month' => $dayNumber . ' ' . getTranslatedMonth()[$monthNumber],
            'translated_date' => translateDate($date),
            'translated_day' => getTranslatedDay()[$dayCode],
            'translated_month' => getTranslatedMonth()[$monthNumber],
        ];
    }
}

if (!function_exists('translateDate')) {
    function translateDate($date, $dateType = 'full')
    {
        $dayCode = strtolower($date->format('D'));
        $dayNumber = strtolower($date->format('d'));
        $month = $date->isoFormat('M');
        $year = date('Y', strtotime($date));

        if ($dateType == 'shorted') {
            return $dayNumber . ' ' . getTranslatedMonth()[$month] . ' ' . $year;
        } else {
            return getTranslatedDay()[$dayCode] . ' ' . $dayNumber . ' ' . getTranslatedMonth()[$month] . ' ' . $year;
        }
    }
}

if (!function_exists('getTranslatedMonth')) {
    function getTranslatedMonth()
    {
        return [
            1 => __('apps::frontend.months.january'),
            2 => __('apps::frontend.months.february'),
            3 => __('apps::frontend.months.march'),
            4 => __('apps::frontend.months.april'),
            5 => __('apps::frontend.months.may'),
            6 => __('apps::frontend.months.june'),
            7 => __('apps::frontend.months.july'),
            8 => __('apps::frontend.months.august'),
            9 => __('apps::frontend.months.september'),
            10 => __('apps::frontend.months.october'),
            11 => __('apps::frontend.months.november'),
            12 => __('apps::frontend.months.december'),
        ];
    }
}

if (!function_exists('getTranslatedDay')) {
    function getTranslatedDay()
    {
        return [
            'sat' => __('apps::frontend.days.sat'),
            'sun' => __('apps::frontend.days.sun'),
            'mon' => __('apps::frontend.days.mon'),
            'tue' => __('apps::frontend.days.tue'),
            'wed' => __('apps::frontend.days.wed'),
            'thu' => __('apps::frontend.days.thu'),
            'fri' => __('apps::frontend.days.fri'),
        ];
    }
}

if (!function_exists('getDeliveryInfoByState')) {
    function getDeliveryInfoByState($stateId)
    {
        return DeliveryCharge::active()->filterState($stateId)->first();
    }
}

if (!function_exists('buildAddressInfo')) {
    function buildAddressInfo($address)
    {
        $addressData = '';
        if ($address->state) {
            $addressData .= $address->state->title;
        }
        if ($address->street) {
            $addressData .= ' / ' . __('Street') . ': ' . $address->street;
        }
        if ($address->floor) {
            $addressData .= ' / ' . __('Floor') . ': ' . $address->floor;
        }
        if ($address->flat) {
            $addressData .= ' / ' . __('Flat') . ': ' . $address->flat;
        }
        return $addressData;
    }
}

if (!function_exists('returnDeliveryAndReceivingTimes')) {
    function returnDeliveryAndReceivingTimes()
    {
        return [
            '12:00 - 00:02',
            '00:02 - 00:04',
            '00:04 - 00:06',
            '00:06 - 00:08',
            '00:08 - 00:10',
            '00:10 - 00:12',
        ];
    }
}

if (!function_exists('getCartAddonQty')) {
    function getCartAddonQty($productId, $addonId)
    {
        $cartProduct = getCartItemById($productId);
        if (is_null($cartProduct)) {
            return null;
        }

        $allQty = $cartProduct->attributes['qty_details'];
        $key = array_search($addonId, array_column($allQty, 'addon_id'));
        if (gettype($key) == 'boolean' && $key == false) {
            return null;
        }
        return $allQty[$key] ?? null;
    }
}

if (!function_exists('getCartStarch')) {
    function getCartStarch($productId)
    {
        $cartProduct = getCartItemById($productId);
        if (is_null($cartProduct)) {
            return null;
        }
        return isset($cartProduct->starch)? $cartProduct->starch : null;
    }
}

if (!function_exists('displayOrderPaymentStatus')) {
    function displayOrderPaymentStatus($paymentStatus)
    {
        if (is_null($paymentStatus)) {
            return __('UnPaid');
        } elseif ($paymentStatus->flag == 'pending') {
            return __('Pending');
        } elseif ($paymentStatus->flag == 'success') {
            return __('Paid');
        } elseif ($paymentStatus->flag == 'failed') {
            return __('Failed Payment');
        } elseif ($paymentStatus->flag == 'cash') {
            return __('Cash');
        } elseif ($paymentStatus->flag == 'subscriptions_balance') {
            return __('Paid By Subscriptions Balance');
        } elseif ($paymentStatus->flag == 'loyalty_points') {
            return __('Paid By Loyalty Points');
        } else {
            return '---';
        }
    }
}

if (!function_exists('getPaymentType')) {
    function getPaymentType($order)
    {
        if (!is_null($order->paymentStatus)) {
            if ($order->paymentStatus->flag == 'cash') {
                return ['key' => 'cash', 'title' => __('Cash')];
            } elseif (in_array($order->paymentStatus->flag, ['success', 'pending'])) {
                return ['key' => 'knet', 'title' => __('Knet')];
            } elseif ($order->paymentStatus->flag == 'subscriptions_balance') {
                return ['key' => 'subscriptions_balance', 'title' => __('Paid By Subscriptions Balance')];
            } elseif ($order->paymentStatus->flag == 'loyalty_points') {
                return ['key' => 'loyalty_points', 'title' => __('Paid By Loyalty Points')];
            }
        }

        return null;
    }
}

if (!function_exists('checkPaidStatus')) {
    function checkPaidStatus($order)
    {
        if (!is_null($order->paymentStatus)) {
            if (in_array($order->paymentStatus->flag, ['cash', 'success', 'subscriptions_balance', 'loyalty_points']) && !is_null($order->payment_confirmed_at)) {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists('getUserActiveSubscription')) {
    function getUserActiveSubscription($userId)
    {
        return BaqatSubscription::where('user_id', $userId)->unexpired()->successSubscriptions()->first();
    }
}

if (!function_exists('displayCouponDiscount')) {
    function displayCouponDiscount($coupon, $withSign = false)
    {
        $discount = null;
        if ($coupon->discount_type == 'percentage') {
            $discount = $coupon->discount_percentage;
            $discount .= $withSign == true ? ' %' : '';
        } else {
            $discount = $coupon->discount_value;
            $discount .= $withSign == true ? ' ' . __('KD') : '';
        }
        return $discount;
    }
}

if (!function_exists('get_current_main_domain')) {
    function get_current_main_domain()
    {
        return get_main_domain(request()->getHost()) ?? null;
    }
}

if (!function_exists('get_main_domain')) {
    function get_main_domain($url)
    {
        $pieces = parse_url($url);
        $domain = isset($pieces['host']) ? $pieces['host'] : '';
        if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
            return $regs['domain'];
        }
        return $url;
    }
}

if (!function_exists('getCustomAddon')) {
    function getCustomAddon($id)
    {
        $item = \Modules\Catalog\Entities\CustomAddon::find($id);
        return $item;
    }
}

if (!function_exists('buildOrderSummaryFromCart')) {
    function buildOrderSummaryFromCart()
    {
        $items = [];
        $arr = [];
        $items = getCartContent(null, true);
        foreach ($items as $key => $item) {
            foreach ($item['attributes']['qty_details'] as $k => $value) {

                $addonModel = CustomAddon::find($value['addon_id']);
                $productModel = Product::find($key);

                if ($addonModel && $productModel) {
                    $arr[$value['addon_id']]['addon'] = [
                        'id' => $addonModel->id,
                        'title' => $addonModel->title,
                        'image' => $addonModel->image ? url($addonModel->image) : null,
                    ];
                    $productAttributes = [
                        'id' => $productModel->id,
                        'title' => $productModel->title,
                        'image' => $productModel->image ? url($productModel->image) : null,
                        'qty' => $value['qty'],
                        'price' => $value['price'],
                        'starch' => $item['attributes']['starch'],
                    ];
                    $arr[$value['addon_id']]['products'][] = $productAttributes;
                }
            }
        }

        return array_values($arr);
    }
}

if (!function_exists('getProductAddonQtyInOrder')) {
    function getProductAddonQtyInOrder($orderId, $productId, $addonId)
    {
        $orderAddon = OrderCustomAddon::where('order_id', $orderId)->where('addon_id', $addonId)->whereHas('orderProduct', function ($query) use ($productId) {
            $query->where('product_id', $productId);
        })->first();
        return !is_null($orderAddon) ? $orderAddon->qty : 0;
    }
}

if (!function_exists('getProductStarchInOrder')) {
    function getProductStarchInOrder($orderId, $productId)
    {
        $orderProduct = OrderProduct::where('order_id', $orderId)->where('product_id', $productId)->first();
        return !is_null($orderProduct) ? $orderProduct->starch : null;
    }
}


if (!function_exists('calculateUserPointsCount')) {
    function calculateUserPointsCount($amount)
    {
        $filsCount = intval(config('setting.other.loyalty_points.from.fils_count')) ?? 1;
        $pointsCount = intval(config('setting.other.loyalty_points.from.points_count')) ?? 1;
        return ((floatval($amount) * 1000 * $pointsCount) / $filsCount);
    }
}

if (!function_exists('calculateUserFilsFromPointsCount')) {
    function calculateUserFilsFromPointsCount($userPointsCount)
    {
        $filsCount = intval(config('setting.other.loyalty_points.to.fils_count')) ?? 1;
        $pointsCount = intval(config('setting.other.loyalty_points.to.points_count')) ?? 1;
        return ((intval($userPointsCount) * $filsCount) / $pointsCount);
    }
}

if (!function_exists('convertArabicToEnglish')) {
    function convertArabicToEnglish($string) {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

        $num = range(0, 9);
        $convertedPersianNums = str_replace($persian, $num, $string);
        $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);

        return $englishNumbersOnly;
    }
}

if (!function_exists('validatePhone')) {
    function validatePhone($number){
        $number = convertArabicToEnglish($number);
        return preg_replace("/[^0-9]/", "", $number);
    }
}

if (!function_exists('getDiffInDays')) {
    function getDiffInDays($date1,$date2){
        $date1 = strtotime(date('Y-m-d',strtotime($date1)));
        $date2 = strtotime(date('Y-m-d',strtotime($date2)));
        $diff =  round(($date1 - $date2 )/ 60 / 60 / 24 , 0);
        return  $diff ;
        return preg_replace("/[^0-9]/", "", $number);
    }
}
