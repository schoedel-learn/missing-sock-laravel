<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Brand Colors
    |--------------------------------------------------------------------------
    |
    | Primary brand colors for The Missing Sock Photography.
    | These should match the colors defined in tailwind.config.js and
    | resources/css/app.css for consistency.
    |
    */

    'colors' => [
        'primary' => [
            // Coral Orange - Primary CTA buttons
            'coral' => env('BRAND_PRIMARY_CORAL', '#FF5E3F'),
            'coral_hover' => env('BRAND_PRIMARY_CORAL_HOVER', '#E84A2F'),
            'coral_light' => env('BRAND_PRIMARY_CORAL_LIGHT', '#FFE5E0'),
            'coral_dark' => env('BRAND_PRIMARY_CORAL_DARK', '#CC4B32'),
        ],
        'accent' => [
            // Golden Yellow - Accent color for sections, buttons, text
            'golden' => env('BRAND_ACCENT_GOLDEN', '#F1BF61'),
            'golden_hover' => env('BRAND_ACCENT_GOLDEN_HOVER', '#E5B04D'),
            'golden_light' => env('BRAND_ACCENT_GOLDEN_LIGHT', '#F9E8C0'),
            'golden_dark' => env('BRAND_ACCENT_GOLDEN_DARK', '#C99A4E'),
        ],
        'background' => [
            // Main background color - soft beige
            'main' => env('BRAND_BG_MAIN', '#ECE9E6'),
            'main_light' => env('BRAND_BG_MAIN_LIGHT', '#F5F3F1'),
            'main_dark' => env('BRAND_BG_MAIN_DARK', '#D9D5D0'),
        ],
        'success' => [
            'default' => env('BRAND_SUCCESS', '#27AE60'),
            'light' => env('BRAND_SUCCESS_LIGHT', '#E8F8F0'),
            'dark' => env('BRAND_SUCCESS_DARK', '#1E8449'),
        ],
        'warning' => [
            'default' => env('BRAND_WARNING', '#F39C12'),
            'light' => env('BRAND_WARNING_LIGHT', '#FEF5E7'),
            'dark' => env('BRAND_WARNING_DARK', '#D68910'),
        ],
        'error' => [
            'default' => env('BRAND_ERROR', '#E74C3C'),
            'light' => env('BRAND_ERROR_LIGHT', '#FADBD8'),
            'dark' => env('BRAND_ERROR_DARK', '#C0392B'),
        ],
        'info' => [
            'default' => env('BRAND_INFO', '#3498DB'),
            'light' => env('BRAND_INFO_LIGHT', '#EBF5FB'),
            'dark' => env('BRAND_INFO_DARK', '#2874A6'),
        ],
        'gray' => [
            900 => env('BRAND_GRAY_900', '#2C3E50'),
            800 => env('BRAND_GRAY_800', '#34495E'),
            700 => env('BRAND_GRAY_700', '#5A6C7D'),
            600 => env('BRAND_GRAY_600', '#7B8794'),
            500 => env('BRAND_GRAY_500', '#95A5A6'),
            400 => env('BRAND_GRAY_400', '#BDC3C7'),
            300 => env('BRAND_GRAY_300', '#D5DBDB'),
            200 => env('BRAND_GRAY_200', '#ECF0F1'),
            100 => env('BRAND_GRAY_100', '#F8F9FA'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Brand Assets
    |--------------------------------------------------------------------------
    |
    | Paths to brand assets (logos, images, graphics).
    | These paths are relative to the public directory or storage.
    |
    */

    'assets' => [
        'logos' => [
            'primary' => env('BRAND_LOGO_PRIMARY', '/images/logo.svg'),
            'primary_white' => env('BRAND_LOGO_PRIMARY_WHITE', '/images/logo-white.svg'),
            'primary_dark' => env('BRAND_LOGO_PRIMARY_DARK', '/images/logo-dark.svg'),
            'favicon' => env('BRAND_LOGO_FAVICON', '/favicon.ico'),
            'icon' => env('BRAND_LOGO_ICON', '/images/logo-icon.svg'),
        ],
        'images' => [
            'storage_path' => env('BRAND_IMAGES_STORAGE', 'public/assets/images'),
            'public_path' => env('BRAND_IMAGES_PUBLIC', '/assets/images'),
        ],
        'graphics' => [
            'storage_path' => env('BRAND_GRAPHICS_STORAGE', 'public/assets/graphics'),
            'public_path' => env('BRAND_GRAPHICS_PUBLIC', '/assets/graphics'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Typography
    |--------------------------------------------------------------------------
    |
    | Font families and typography settings.
    |
    */

    'typography' => [
        'primary' => env('BRAND_FONT_PRIMARY', 'Nunito'),
        'secondary' => env('BRAND_FONT_SECONDARY', 'Playfair Display'),
        'mono' => env('BRAND_FONT_MONO', 'Inter'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Brand Information
    |--------------------------------------------------------------------------
    |
    | Basic brand information.
    |
    */

    'name' => env('BRAND_NAME', 'The Missing Sock Photography'),
    'tagline' => env('BRAND_TAGLINE', 'Capturing Childhood Memories'),
    'website' => env('BRAND_WEBSITE', 'https://www.themissingsock.com'),
    'support_email' => env('BRAND_SUPPORT_EMAIL', 'support@themissingsock.com'),
];

