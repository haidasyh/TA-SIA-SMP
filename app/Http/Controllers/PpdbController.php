<?php

namespace App\Http\Controllers;

use App\Models\JadwalPelaksanaanPpdb;
use App\Models\PersyaratanPendaftaran;
use Illuminate\Http\Request;

class PpdbController extends Controller
{
    public function index()
    {

        $jadwal = JadwalPelaksanaanPpdb::all();
        $persyaratan = PersyaratanPendaftaran::first();

        return view('ppdb', compact('jadwal', 'persyaratan'));
    }
}