<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Beranda;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminBerandaPpdbController extends Controller
{
    public function index()
    {
        $beranda = Beranda::firstOrCreate(['id' => 1], [
            'profil' => '',
            'tentang_kami' => '',
            'visi' => '',
            'misi' => ''
        ]);
        $ppdbStatus = Setting::get('ppdb_status', 'nonaktif');

        return view('admin.beranda.index', compact('beranda', 'ppdbStatus'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'profil' => 'nullable|string',
            'tentang_kami' => 'nullable|string',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'hero_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'about_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery_1' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery_2' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery_3' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $beranda = Beranda::firstOrCreate(['id' => 1]);
        $data = $request->except(['hero_image', 'about_image', 'gallery_1', 'gallery_2', 'gallery_3']);

        foreach (['hero_image', 'about_image', 'gallery_1', 'gallery_2', 'gallery_3'] as $field) {
            if ($request->hasFile($field)) {
                if ($beranda->$field) {
                    Storage::disk('public')->delete($beranda->$field);
                }
                $data[$field] = $request->file($field)->store('beranda', 'public');
            }
        }

        $beranda->update($data);

        return redirect()->route('admin.beranda.index')->with('success', 'Informasi Beranda berhasil diperbarui!');
    }

    public function updateStatus(Request $request)
    {
        $status = $request->status === 'aktif' ? 'aktif' : 'nonaktif';
        Setting::set('ppdb_status', $status);

        return redirect()->back()->with('success', 'Status PPDB berhasil diupdate!');
    }
}