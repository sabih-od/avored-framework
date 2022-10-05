<?php

namespace AvoRed\Framework\System\Controllers;

use AvoRed\Framework\Database\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SettingsController extends Controller
{

    public function payments()
    {
        $setting = Setting::first();
        return view('avored::system.settings.payments', compact('setting'));
    }

    public function paymentsUpdate(Request $request)
    {
        $setting = Setting::first();
        $data = [
            'stripe_test_key' => $request->stripe_test_key,
            'stripe_public_key' => $request->stripe_public_key,
            'stripe_is_test_mode' => $request->stripe_is_test_mode
        ];

        if (is_null($setting)) {
            Setting::create($data);
        } else {
            $setting->update($data);
        }
        return redirect()->back();
    }

    public function contact()
    {
        $setting = Setting::first();
        return view('avored::system.settings.contact', compact('setting'));
    }

    public function contactUpdate(Request $request)
    {
        $setting = Setting::first();
        $data = [
            'location' => $request->location,
            'email' => $request->email,
            'phone' => $request->phone,
            'map_link' => $request->map_link
        ];

        if (is_null($setting)) {
            Setting::create($data);
        } else {
            $setting->update($data);
        }
        return redirect()->back();
    }
}
