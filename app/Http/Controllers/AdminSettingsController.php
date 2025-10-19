<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class AdminSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    public function edit()
    {
        $office = Setting::get('office_name', 'Nama Kantor Anda');
        $address = Setting::get('office_address', 'Alamat kantor');
        return view('admin.settings', compact('office','address'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'office' => 'nullable|string|max:255',
            'address' => 'nullable|string',
        ]);

        Setting::set('office_name', $data['office'] ?? '');
        Setting::set('office_address', $data['address'] ?? '');

        return back()->with('success','Pengaturan kantor disimpan.');
    }
}
