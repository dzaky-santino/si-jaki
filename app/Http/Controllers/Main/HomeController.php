<?php

namespace App\Http\Controllers\Main;

use App\Models\User;
use App\Models\PerguruanTinggiNegeri;
use App\Models\PerguruanTinggiSwasta;
use App\Models\LaporanPTN;
use App\Models\LaporanPTS;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        // Menghitung jumlah data pengguna, PTN, dan PTS
        $userCount = User::count();
        $swastaCount = PerguruanTinggiSwasta::count(); 
        $negeriCount = PerguruanTinggiNegeri::count(); 
    
        // Menghitung jumlah total laporan (PTN + PTS)
        $laporanPTNCount = LaporanPTN::count();
        $laporanPTSCount = LaporanPTS::count();
        $laporanCount = $laporanPTNCount + $laporanPTSCount;
    
        // Statistik laporan PTN
        $todayPTNCount = LaporanPTN::whereDate('created_at', Carbon::today())->count();
        $weeklyPTNCount = LaporanPTN::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $monthlyPTNCount = LaporanPTN::whereMonth('created_at', Carbon::now()->month)
                                     ->whereYear('created_at', Carbon::now()->year)
                                     ->count();
        $yearlyPTNCount = LaporanPTN::whereYear('created_at', Carbon::now()->year)->count();
    
        // Statistik laporan PTS
        $todayPTSCount = LaporanPTS::whereDate('created_at', Carbon::today())->count();
        $weeklyPTSCount = LaporanPTS::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $monthlyPTSCount = LaporanPTS::whereMonth('created_at', Carbon::now()->month)
                                     ->whereYear('created_at', Carbon::now()->year)
                                     ->count();
        $yearlyPTSCount = LaporanPTS::whereYear('created_at', Carbon::now()->year)->count();
    
        // Statistik total laporan
        $todayCount = $todayPTNCount + $todayPTSCount;
        $weeklyCount = $weeklyPTNCount + $weeklyPTSCount;
        $monthlyCount = $monthlyPTNCount + $monthlyPTSCount;
        $yearlyCount = $yearlyPTNCount + $yearlyPTSCount;
    
        // Statistik laporan berdasarkan akun user yang login
        $user = Auth::user();
        $userLaporanCount = LaporanPTN::where('user_id', $user->id)->count() + LaporanPTS::where('user_id', $user->id)->count();
    
        // Statistik laporan yang diunggah oleh semua user, kecuali admin
        $users = User::where('name', '!=', 'adminklk') // Filter username tertentu
                    ->where('akses', '!=', 'admin') // Opsional: Filter berdasarkan akses, jika ada
                    ->get();

        $userLaporanData = $users->map(function ($user) {
            $laporanPTNCount = LaporanPTN::where('user_id', $user->id)->count();
            $laporanPTSCount = LaporanPTS::where('user_id', $user->id)->count();
            return [
                'user_name' => $user->name ?? 'Pengguna Tidak Diketahui',
                'laporan_count' => $laporanPTNCount + $laporanPTSCount,
            ];
        })->values();

    
        return view('main.home', compact(
            'userCount',
            'swastaCount',
            'negeriCount',
            'laporanCount',
            'todayCount',
            'weeklyCount',
            'monthlyCount',
            'yearlyCount',
            'userLaporanCount',
            'userLaporanData'
        ));
    }
    
}
