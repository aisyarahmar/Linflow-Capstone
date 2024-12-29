<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komponen extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'bagian',
    ];

    public function stokKomponen()
    {
        return $this->hasOne(StokKomponen::class, 'id_komponen');
    }
}
