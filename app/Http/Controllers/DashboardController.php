<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Komponen;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{   
    public function productPrediction()
    {
        $requiredComponents = [
            'Center Gear' => 1,
            'Counter Wheel Left' => 1,
            'Counter Wheel Middle' => 5,
            'Counter Wheel Right' => 1,
            'Counter Wheel Shaft 1,5 mm' => 2,
            'Gear Case' => 1,
            'Head Washer LF - 1' => 1,
            'Lemping Segel' => 1,
            'Lid Plastik LF - 1' => 1,
            'Regulator' => 2,
            'Lower Casing' => 1,
            'Magnet Bearing' => 1,
            'Magnet Protection Ring' => 1,
            'Pilot Star' => 1,
            'Pivot' => 1,
            'Pivot + Nut' => 1,
            'Pointer' => 1,
            'Register Gear No. 1' => 1,
            'Register Gear No. 2' => 1,
            'Register Gear No. 3' => 1,
            'Register Gear No. 4' => 1,
            'Register Top Plate' => 1,
            'Sealed Case Alumunium' => 1,
            'Shaft Bush' => 2,
            'Shaft Center Gear 1 mm' => 1,
            'Strainer' => 1,
            'Transfer Pinion' => 6,
            'Upper Casing LF - 1' => 1,
            'Vane Wheel' => 1,
            'Register Bending Unit' => 1,
            'Ring Anti Magnet Upper Casing' => 1,
            'Fixed Coupling 15mm' => 2,
            'Body Casing LF - 1' => 1,
            'Head Casing LF - 1' => 1,
            'Baut Regulator' => 1,
        ];

        $stokKomponens = DB::table('stok_komponens')
            ->join('komponens', 'stok_komponens.id_komponen', '=', 'komponens.id')
            ->select('komponens.nama', 'stok_komponens.stok')
            ->get();

        $minProducts = PHP_INT_MAX; // Inisialisasi dengan nilai maksimum

        foreach ($requiredComponents as $komponen => $jumlahDibutuhkan) {
            $stok = $stokKomponens->firstWhere('nama', $komponen)?->stok ?? 0; // Stok komponen atau 0 jika tidak ditemukan
            $maxProductsByKomponen = intdiv($stok, $jumlahDibutuhkan);
            $minProducts = min($minProducts, $maxProductsByKomponen);
        }

        return $minProducts;
    }
    
    public function dashboard(Request $request)
{
    $sortOrder = $request->query('sort', 'asc'); // Default sort order is ascending

    $komponenPlastik = DB::table('stok_komponens')
        ->join('komponens', 'stok_komponens.id_komponen', '=', 'komponens.id')
        ->where('komponens.bagian', 'Plastik')
        ->orderBy('stok_komponens.stok', 'asc')
        ->select('komponens.id', 'komponens.nama', 'stok_komponens.stok as jumlah')
        ->get();

    $komponenLogam = DB::table('stok_komponens')
        ->join('komponens', 'stok_komponens.id_komponen', '=', 'komponens.id')
        ->where('komponens.bagian', 'Logam')
        ->orderBy('stok_komponens.stok', 'asc')
        ->select('komponens.id', 'komponens.nama', 'stok_komponens.stok as jumlah')
        ->get();

    $jumlahProduk = $this->productPrediction(); // Hitung prediksi produk

    return view('layouts.components.pages.dashboard.index', [
        "komponenPlastik" => $komponenPlastik,
        "komponenLogam" => $komponenLogam,
        "sortOrder" => $sortOrder,
        "jumlahProduk" => $jumlahProduk, // Kirim jumlah produk ke view
    ]);
}

}