<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanHarian extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'bagian',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function detailLaporan()
    {
        return $this->hasMany(DetailLaporan::class, 'id_laporan_harian');
    }
}
