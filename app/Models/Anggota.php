<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Anggota extends Authenticatable
{
    use Notifiable;

    protected $table = 'anggotas';
    protected $fillable = [
        'nama',
        'nis',
        'email',
        'kelas',
        'password',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}