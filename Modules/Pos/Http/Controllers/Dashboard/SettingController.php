<?php

namespace Modules\Pos\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Setting\Repositories\Dashboard\SettingRepository as SettingRepo;
use Setting;

class SettingController extends Controller
{

    function __construct(SettingRepo $setting)
    {
        $this->setting = $setting;
    }

    public function index(Request $request)
    {
        return view('pos::dashboard.settings.index');
    }

    public function update(Request $request)
    {
        $oldSetting = config('setting.other');
        $new = $request->all();
        unset($new['_token']);
        foreach ($new['other'] as $key => $setting){
            $oldSetting[$key]   = $setting;
        }

        Setting::set('other', $oldSetting);
        Setting::set('order_default_customer_id', $new['order_default_customer_id']);

        return redirect()->back()->with(['msg' => __('setting::dashboard.settings.form.messages.settings_updated_successfully'), 'alert' => 'success']);
    }
}
