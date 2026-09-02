<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first() ?? new Setting;

        return view('admin.setting', compact('setting'));
    }

    public function update(Request $request, $id)
    {
        $setting = Setting::findOrFail($id);

        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:100'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'whatsapp_number' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email'],
            'address' => ['nullable', 'string'],
            'opening_hours' => ['nullable', 'string'],
            'about_text' => ['nullable', 'string'],
            'instagram_usn' => ['nullable', 'string'],
            'facebook_usn' => ['nullable', 'string'],
        ]);

        $setting->update($data);

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
