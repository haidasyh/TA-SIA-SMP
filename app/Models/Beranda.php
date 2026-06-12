<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beranda extends Model
{
    protected $table = 'beranda';
    
    protected $fillable = [
    'profil', 
    'tentang_kami', 
    'visi', 
    'misi', 
    'hero_image', 
    'about_image', 
    'gallery_1', 
    'gallery_2', 
    'gallery_3'
    ];
}
