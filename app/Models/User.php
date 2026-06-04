<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = ['nama', 'username', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];

    public function guru(): HasOne
    { 
        return $this->hasOne(Guru::class, 'users_id'); 
    }

    public function siswa(): HasOne
    { 
        return $this->hasOne(Siswa::class, 'users_id'); 
    }
}
