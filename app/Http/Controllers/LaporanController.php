<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanHarian;
use App\Models\DetailLaporan;
use App\Models\StokKomponen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Mulai query dasar
        $query = DB::table('laporan_harians')
            ->join('users', 'laporan_harians.id_user', '=', 'users.id')
            ->select('laporan_harians.id', 'users.nama as user', 'laporan_harians.bagian', 'laporan_harians.created_at');

        // Tambahkan filter berdasarkan input
        if ($request->has('user_name') && $request->input('user_name') !== null) {
            $userName = $request->input('user_name');
            $query->where('users.nama', 'like', "%{$userName}%");
        }

        if ($request->has('bagian') && $request->input('bagian') !== null) {
            $bagian = $request->input('bagian');
            $query->where('laporan_harians.bagian', 'like', "%{$bagian}%");
        }

        if ($request->has('start_date') && $request->has('end_date') && $request->input('start_date') !== null && $request->input('end_date') !== null) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $query->whereBetween('laporan_harians.created_at', [$startDate, $endDate]);
        }

        // Ambil data hasil query
        $laporanHarians = $query->orderBy('laporan_harians.created_at', 'desc')->get();

        // Kirim ke view
        return view('layouts.components.pages.laporan.index', [
            'laporanHarians' => $laporanHarians
        ]);
    }


    public function view(Request $request, $id)
    {
        $query = DB::table('laporan_harians')
            ->join('users', 'laporan_harians.id_user', '=', 'users.id')
            ->select('laporan_harians.*', 'users.nama as user')
            ->where('laporan_harians.id', $id);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('users.nama', 'like', "%{$search}%")
                    ->orWhere('laporan_harians.bagian', 'like', "%{$search}%")
                    ->orWhere('laporan_harians.created_at', 'like', "%{$search}%");
            });
        }

        $laporanHarian = $query->first();

        $detailLaporans = DB::table('detail_laporans')
            ->join('stok_komponens', 'detail_laporans.id_stok_komponen', '=', 'stok_komponens.id')
            ->join('komponens', 'stok_komponens.id_komponen', '=', 'komponens.id')
            ->where('detail_laporans.id_laporan_harian', $id)
            ->select('komponens.nama as nama_komponen', 'detail_laporans.stok_awal', 'detail_laporans.stok_masuk', 'detail_laporans.stok_keluar', 'detail_laporans.stok_akhir')
            ->get();

        return view('layouts.components.pages.laporan.viewLaporan', [
            'laporanHarian' => $laporanHarian,
            'detailLaporans' => $detailLaporans
        ]);
    }

    public function export($id)
    {
        $detailLaporans = DB::table('detail_laporans')
            ->join('stok_komponens', 'detail_laporans.id_stok_komponen', '=', 'stok_komponens.id')
            ->join('komponens', 'stok_komponens.id_komponen', '=', 'komponens.id')
            ->where('detail_laporans.id_laporan_harian', $id)
            ->select('komponens.nama as nama_komponen', 'detail_laporans.stok_awal', 'detail_laporans.stok_masuk', 'detail_laporans.stok_keluar', 'detail_laporans.stok_akhir')
            ->get();

        $csvData = [];
        $csvData[] = ['Nama Komponen', 'Stok Awal', 'Stok Masuk', 'Stok Keluar', 'Stok Akhir'];

        foreach ($detailLaporans as $detail) {
            $csvData[] = [
                $detail->nama_komponen,
                $detail->stok_awal,
                $detail->stok_masuk,
                $detail->stok_keluar,
                $detail->stok_akhir,
            ];
        }

        $response = new StreamedResponse(function() use ($csvData) {
            $handle = fopen('php://output', 'w');
            foreach ($csvData as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="laporan_harian.csv"');

        return $response;
    }

    public function formPlastik(Request $request)
    {
        $komponenPlastik = DB::table('stok_komponens')
            ->join('komponens', 'stok_komponens.id_komponen', '=', 'komponens.id')
            ->where('komponens.bagian', 'Plastik')
            ->select('komponens.id', 'komponens.nama', 'stok_komponens.stok as jumlah')
            ->get();

        return view('layouts.components.pages.laporan.formPlastik', [
            'komponenPlastik' => $komponenPlastik,
            'bagian' => $request->query('bagian')
        ]);
    }

    public function formLogam(Request $request)
    {
        $komponenLogam = DB::table('stok_komponens')
            ->join('komponens', 'stok_komponens.id_komponen', '=', 'komponens.id')
            ->where('komponens.bagian', 'Logam')
            ->select('komponens.id', 'komponens.nama', 'stok_komponens.stok as jumlah')
            ->get();

        return view('layouts.components.pages.laporan.formLogam', [
            'komponenLogam' => $komponenLogam,
            'bagian' => $request->query('bagian')
        ]);
    }

    public function simpan(Request $request)
    {
        DB::transaction(function () use ($request) {
            $user = Auth::user();
            $tanggal = $request->input('tanggal');
            $bagian = $request->input('bagian');

            // Create Laporan Harian
            $laporanHarian = LaporanHarian::create([
                'id_user' => $user->id,
                'tanggal' => $tanggal,
                'bagian' => $bagian,
                'created_at' => now(),
            ]);

            foreach ($request->input('stok_awal') as $id_komponen => $stok_awal) {
                $stok_masuk = $request->input("masuk.$id_komponen");
                $stok_keluar = $request->input("keluar.$id_komponen");
                $stok_akhir = $stok_awal + $stok_masuk - $stok_keluar;

                // Update Stok Komponen
                $stokKomponen = StokKomponen::where('id_komponen', $id_komponen)->first();
                $stokKomponen->stok = $stok_akhir;
                $stokKomponen->save();

                // Create Detail Laporan
                DetailLaporan::create([
                    'id_laporan_harian' => $laporanHarian->id,
                    'id_stok_komponen' => $stokKomponen->id,
                    'stok_awal' => $stok_awal,
                    'stok_masuk' => $stok_masuk,
                    'stok_keluar' => $stok_keluar,
                    'stok_akhir' => $stok_akhir,
                ]);
            }
        });

        return redirect()->route('laporan')->with('success', 'Laporan harian berhasil disimpan.');
    }
    

}
