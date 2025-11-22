<?php

namespace App\Http\Controllers;

use App\Models\WebsiteSetting;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class AdminWebsiteController extends Controller
{
    /**
     * Show the admin website settings page
     */
    public function index()
    {
        $settings = WebsiteSetting::all()->keyBy('key');
        $stats = [
            'total_guru' => Guru::count(),
            'total_siswa' => Siswa::count(),
            'total_sekolah' => Sekolah::count(),
        ];

        return view('admin.website.index', compact('settings', 'stats'));
    }

    /**
     * Show the edit form for website settings
     */
    public function edit()
    {
        $settings = WebsiteSetting::all()->keyBy('key');

        return view('admin.website.edit', compact('settings'));
    }

    /**
     * Update website settings
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            // Branding Section
            'app_name' => 'required|string|max:255',
            'app_subtitle' => 'required|string|max:255',
            'app_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'app_favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg,ico|max:1024',

            // Hero Section
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'required|string|max:500',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',

            // Features Section
            'features_title' => 'required|string|max:255',
            'features_subtitle' => 'required|string|max:500',

            // Benefits Section
            'benefits_title' => 'required|string|max:255',

            // About Section
            'about_title' => 'required|string|max:255',
            'about_description' => 'required|string',
            'about_vision' => 'required|string',

            // CTA Section
            'cta_title' => 'required|string|max:255',
            'cta_description' => 'required|string',

            // Footer
            'footer_about' => 'required|string',
            'footer_email' => 'required|email',
            'footer_phone' => 'required|string|max:20',
            'footer_copyright' => 'required|string|max:255',
        ]);

        // Handle logo upload
        if ($request->hasFile('app_logo')) {
            $path = $request->file('app_logo')->store('website', 'public');
            $validated['app_logo'] = $path;
        }

        // Handle favicon upload
        if ($request->hasFile('app_favicon')) {
            $path = $request->file('app_favicon')->store('website', 'public');
            $validated['app_favicon'] = $path;
        }

        // Handle hero image upload
        if ($request->hasFile('hero_image')) {
            $path = $request->file('hero_image')->store('website', 'public');
            $validated['hero_image'] = $path;
        }

        // Save all settings
        foreach ($validated as $key => $value) {
            if ($value !== null) {
                WebsiteSetting::setSetting(
                    $key,
                    $value,
                    'text',
                    ucwords(str_replace('_', ' ', $key))
                );
            }
        }

        return redirect()->route('admin-website.index')
            ->with('success', 'Website settings updated successfully');
    }

    /**
     * Get statistics for the welcome page
     */
    public function getStatistics()
    {
        $stats = [
            'total_guru' => Guru::count(),
            'total_siswa' => Siswa::count(),
            'total_sekolah' => Sekolah::count(),
        ];

        return response()->json($stats);
    }
}
