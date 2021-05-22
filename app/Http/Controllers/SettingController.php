<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::first();
        return view('admin.settings.index')->with('settings', $settings);
    }

    public function edit(Setting $setting)
    {
        $settings = Setting::first();
        return view('admin.settings.edit')->with('settings', $settings);
    }

    public function update(Request $request)
    {
        $request->validate([
            'setting_name' => 'required|string|max:100',
            'setting_address' => 'required|string|max:255',
            'setting_email' => 'required|string|max:255',
            'setting_contact' => 'required|string|max:100',
            'setting_minimum' => 'required|numeric',
            'setting_delivery_fee' => 'required|numeric',
        ]);

        Setting::first()
            ->update([
                'name' => $request->input('setting_name'),
                'address' => $request->input('setting_address'),
                'email' => $request->input('setting_email'),
                'contact' => $request->input('setting_contact'),
                'delivery_fee' => $request->input('setting_delivery_fee'),
                'minimum_order_cost' => $request->input('setting_minimum'),
            ]
        );

        return redirect()
            ->route('admin.setting.index')
            ->with('message', 'Settings has been updated.');
    }


}
