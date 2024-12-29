<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokKomponen extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_komponen',
        'stok',
    ];

    public function komponen()
    {
        return $this->belongsTo(Komponen::class, 'id_komponen');
    }

    public function detailLaporan()
    {
        return $this->hasMany(DetailLaporan::class, 'id_stok_komponen');
    }
}

