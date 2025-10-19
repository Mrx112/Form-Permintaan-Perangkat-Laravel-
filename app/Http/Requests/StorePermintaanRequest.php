<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePermintaanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'status' => 'nullable|in:draft,pending,approved,rejected',
            'meta' => 'nullable|array',
            'category' => 'nullable|string',
            'quantity' => 'nullable|integer|min:1',
            'hardware_type' => 'nullable|string|max:255',
            'asset_tag' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'estimated_completion' => 'nullable|date',
            'attachments.*' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ];
    }
}
