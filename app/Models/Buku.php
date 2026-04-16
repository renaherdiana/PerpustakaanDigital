<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'bukus';

    protected $fillable = [
        'photo',
        'judul',
        'penulis',
        'penerbit',
        'kategori',
        'stok',
        'status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($buku) {
            $buku->status = $buku->stok > 0 ? 'Tersedia' : 'Habis';
        });
    }

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'buku_id');
    }
}