<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Sekolah;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Display the welcome page with real-time statistics
     */
    public function index()
    {
        // Get real-time statistics from database
        $totalGuru = Guru::count();
        $totalSiswa = Siswa::count();
        $totalSekolah = Sekolah::count();

        // Get website settings
        $settings = WebsiteSetting::all()->keyBy('key');

        return view('welcome', compact(
            'totalGuru',
            'totalSiswa',
            'totalSekolah',
            'settings'
        ));
    }
}
