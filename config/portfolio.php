<?php

/*
|--------------------------------------------------------------------------
| Portfolio
|--------------------------------------------------------------------------
|
| Tags are the services used to filter the portfolio page, in display order.
| Projects are listed newest first. Keys are shared by all languages; client
| names, titles and summaries live in lang/{locale}/portfolio.php.
| 'image' is the cover in public/ (AI-generated for now); without it the views
| fall back to a picsum placeholder seeded by 'cover'.
| TODO: replace the sample projects and generated covers with real case studies.
|
*/

return [
    'tags' => ['website', 'social', 'video', 'ads', 'branding'],

    'projects' => [
        'bakery-launch' => ['tags' => ['website', 'social', 'branding'], 'year' => 2026, 'cover' => 'imust-work-bakery', 'image' => 'images/portfolio/bakery-launch.webp'],
        'dental-social' => ['tags' => ['social', 'ads'], 'year' => 2026, 'cover' => 'imust-work-dental', 'image' => 'images/portfolio/dental-social.webp'],
        'hotel-video' => ['tags' => ['video', 'social'], 'year' => 2026, 'cover' => 'imust-work-hotel', 'image' => 'images/portfolio/hotel-video.webp'],
        'cafe-website' => ['tags' => ['website'], 'year' => 2025, 'cover' => 'imust-work-cafe', 'image' => 'images/portfolio/cafe-website.webp'],
        'auto-ads' => ['tags' => ['ads'], 'year' => 2025, 'cover' => 'imust-work-auto', 'image' => 'images/portfolio/auto-ads.webp'],
        'fashion-brand' => ['tags' => ['branding', 'social'], 'year' => 2025, 'cover' => 'imust-work-fashion', 'image' => 'images/portfolio/fashion-brand.webp'],
        'clinic-website' => ['tags' => ['website'], 'year' => 2025, 'cover' => 'imust-work-clinic', 'image' => 'images/portfolio/clinic-website.webp'],
        'restaurant-reels' => ['tags' => ['video'], 'year' => 2024, 'cover' => 'imust-work-restaurant', 'image' => 'images/portfolio/restaurant-reels.webp'],
        'tour-campaign' => ['tags' => ['ads', 'video'], 'year' => 2024, 'cover' => 'imust-work-tours', 'image' => 'images/portfolio/tour-campaign.webp'],
    ],
];
