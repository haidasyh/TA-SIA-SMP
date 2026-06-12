<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBerandaRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'profil'       => 'nullable|string',
            'tentang_kami' => 'nullable|string',
            'visi'         => 'nullable|string',
            'misi'         => 'nullable|string',
            'hero_image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'about_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery_1'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery_2'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery_3'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }
}