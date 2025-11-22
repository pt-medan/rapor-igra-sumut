<?php

namespace App\Helpers;

use App\Models\WebsiteSetting;

class FaviconHelper
{
    /**
     * Get the favicon HTML tag
     * 
     * @return string The favicon link tag or empty string if none available
     */
    public static function getFaviconTag()
    {
        $favicon = WebsiteSetting::getSetting('app_favicon');

        if (!$favicon) {
            return '<link rel="icon" href="' . asset('favicon.svg') . '" type="image/svg+xml">';
        }

        $mimeType = self::getMimeTypeFromPath($favicon);
        return '<link rel="icon" href="' . asset('storage/' . $favicon) . '" type="' . $mimeType . '">';
    }

    /**
     * Get MIME type from file path/extension
     * 
     * @param string $path File path with extension
     * @return string The MIME type
     */
    public static function getMimeTypeFromPath($path)
    {
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        return match ($ext) {
            'svg' => 'image/svg+xml',
            'ico' => 'image/x-icon',
            'png' => 'image/png',
            'jpg', 'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            default => 'image/png'
        };
    }

    /**
     * Get favicon URL
     * 
     * @return string The favicon URL
     */
    public static function getFaviconUrl()
    {
        $favicon = WebsiteSetting::getSetting('app_favicon');

        if (!$favicon) {
            return asset('favicon.svg');
        }

        return asset('storage/' . $favicon);
    }
}
