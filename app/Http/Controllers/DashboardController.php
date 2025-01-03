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

        $minProducts = PHP_INT_MAX; // Initialize with the maximum value

        foreach ($requiredComponents as $komponen => $jumlahDibutuhkan) {
            $stok = $stokKomponens->firstWhere('nama', $komponen)?->stok ?? 0; // Stock or 0 if not found
            $maxProductsByKomponen = intdiv($stok, $jumlahDibutuhkan);
            $minProducts = min($minProducts, $maxProductsByKomponen);
        }

        return $minProducts;
    }

    public function dashboard(Request $request)
    {
        // Get 'bagian' query parameter, default to 'Logam' if not present
        $bagian = $request->query('bagian', 'Logam');
        $sortBy = $request->query('sort', 'jumlah');  // Default to sorting by 'jumlah'


        // Fetch data for selected 'bagian'
        $komponenPlastik = DB::table('stok_komponens')
        ->join('komponens', 'stok_komponens.id_komponen', '=', 'komponens.id')
        ->where('komponens.bagian', 'Plastik')
        ->select('komponens.id', 'komponens.nama', 'stok_komponens.stok as jumlah')
        ->orderBy($sortBy, 'asc') // Sort based on the 'sort' parameter (jumlah or id)
        ->get();

        $komponenLogam = DB::table('stok_komponens')
        ->join('komponens', 'stok_komponens.id_komponen', '=', 'komponens.id')
        ->where('komponens.bagian', 'Logam')
        ->select('komponens.id', 'komponens.nama', 'stok_komponens.stok as jumlah')
        ->orderBy($sortBy, 'asc') // Sort based on the 'sort' parameter (jumlah or id)
        ->get();
    

        $jumlahProduk = $this->productPrediction(); // Calculate product prediction

        // Conditionally fetch logam or plastik data for the chart
        $chartData = [];
        $stokData = [];
        if ($bagian === 'Logam') {
            // Logam Data Query
            $logamData = DB::table('detail_laporans')
            ->join('stok_komponens', 'detail_laporans.id_stok_komponen', '=', 'stok_komponens.id')
            ->join('komponens', function($join) {
                $join->on('stok_komponens.id_komponen', '=', 'komponens.id')
                     ->where('komponens.bagian', '=', 'Logam');
            })
            ->join('laporan_harians', function($join) {
                $join->on('detail_laporans.id_laporan_harian', '=', 'laporan_harians.id')
                     ->where('laporan_harians.bagian', '=', 'Logam');
            })
            ->select(
                'komponens.nama as komponen',
                DB::raw('MAX(detail_laporans.stok_akhir) as stok_akhir')
            )
            ->groupBy('komponens.nama', 'komponens.id')  // Include komponen.id in the GROUP BY clause
            ->orderBy($sortBy === 'jumlah' ? 'stok_akhir' : 'komponens.id', $sortBy === 'jumlah' ? 'desc' : 'asc')
            ->get();        
        
            $chartData = [
                'categories' => $logamData->pluck('komponen')->toArray(),
                'values' => $logamData->pluck('stok_akhir')->toArray(),
            ];
        
            // Get Logam stok data for the table
            $stokData = DB::table('stok_komponens')
                ->join('komponens', 'stok_komponens.id_komponen', '=', 'komponens.id')
                ->where('komponens.bagian', 'Logam')
                ->select('komponens.nama', 'stok_komponens.stok')
                ->get();
        
        } elseif ($bagian === 'Plastik') {
            // Plastik Data Query
            $plastikData = DB::table('detail_laporans')
            ->join('stok_komponens', 'detail_laporans.id_stok_komponen', '=', 'stok_komponens.id')
            ->join('komponens', function($join) {
                $join->on('stok_komponens.id_komponen', '=', 'komponens.id')
                     ->where('komponens.bagian', '=', 'Plastik');
            })
            ->join('laporan_harians', function($join) {
                $join->on('detail_laporans.id_laporan_harian', '=', 'laporan_harians.id')
                     ->where('laporan_harians.bagian', '=', 'Plastik');
            })
            ->select(
                'komponens.nama as komponen',
                DB::raw('MAX(detail_laporans.stok_akhir) as stok_akhir')
            )
            ->groupBy('komponens.nama', 'komponens.id')  // Include komponen.id in the GROUP BY clause
            ->orderBy($sortBy === 'jumlah' ? 'stok_akhir' : 'komponens.id', $sortBy === 'jumlah' ? 'desc' : 'asc')
            ->get();
        
        
            $chartData = [
                'categories' => $plastikData->pluck('komponen')->toArray(),
                'values' => $plastikData->pluck('stok_akhir')->toArray(),
            ];
        
            // Get Plastik stok data for the table
            $stokData = DB::table('stok_komponens')
                ->join('komponens', 'stok_komponens.id_komponen', '=', 'komponens.id')
                ->where('komponens.bagian', 'Plastik')
                ->select('komponens.nama', 'stok_komponens.stok')
                ->get();
        }
        

        return view('layouts.components.pages.dashboard.index', [
            "komponenPlastik" => $komponenPlastik,
            "komponenLogam" => $komponenLogam,
            "bagian" => $bagian,  // Pass 'bagian' so it can be used in the view
            "jumlahProduk" => $jumlahProduk,
            "chartData" => $chartData,
            "stokData" => $stokData,  
        ]);
        
    }
}
