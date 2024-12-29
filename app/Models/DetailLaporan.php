<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailLaporan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_laporan_harian',
        'id_stok_komponen',
        'stok_awal',
        'stok_masuk',
        'stok_keluar',
        'stok_akhir',
    ];

    public function laporanHarian()
    {
        return $this->belongsTo(LaporanHarian::class, 'id_laporan_harian');
    }

    public function stokKomponen()
    {
        return $this->belongsTo(StokKomponen::class, 'id_stok_komponen');
    }
}
