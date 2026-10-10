<?php

return [
    'meta_title' => 'About I MUST',
    'meta_description' => 'Meet the founders, developers and partners behind I MUST Marketing Agency.',

    'eyebrow' => 'About us',
    'title' => "We didn't start from zero.",
    'lead' => 'Each of us built a career in our field before I MUST. Now we work under one name.',
    'image_alt' => 'The I MUST team at the office',
    'equation_hint' => 'Select a discipline to meet the founder who leads it.',

    'structure' => [
        'title' => 'A hybrid team, built around your project',
        'lead' => 'One brief, one team. No handoffs between agencies.',
        'roles' => [
            ['title' => 'Marketers', 'text' => 'Plan the strategy, write the content and run targeted campaigns.'],
            ['title' => 'Full-stack developer', 'text' => 'Designs and builds trilingual websites with basic SEO.'],
            ['title' => 'Reelmakers', 'text' => 'Shoot and edit reels, ads and brand videos.'],
        ],
    ],

    'founders' => [
        'eyebrow' => 'Founders',
        'title' => 'The people who lead the work',
        // TODO: replace with the founders' real names and positions.
        'people' => [
            'marketing' => [
                'discipline' => 'Marketing',
                'name' => 'Founder name',
                'position' => 'Co-founder, Marketing Director',
                'bio' => 'Leads strategy, social media and targeted advertising, from the first post to measurable sales.',
            ],
            'development' => [
                'discipline' => 'Development',
                'name' => 'Founder name',
                'position' => 'Co-founder, Lead Full-stack Developer',
                'bio' => 'Builds trilingual websites with clean design and an SEO foundation clients can grow on.',
            ],
            'video' => [
                'discipline' => 'Video',
                'name' => 'Founder name',
                'position' => 'Co-founder, Head of Video Production',
                'bio' => 'Shoots and edits reels, ads and brand stories that hold attention from the first second.',
            ],
        ],
        'view_portfolio' => 'View portfolio',
    ],

    'network' => [
        'title' => 'Developers and partners',
        'lead' => 'Specialists we bring in when a project needs more hands.',
        // TODO: replace with real names, roles and portfolio links.
        'people' => [
            ['name' => 'Developer name', 'role' => 'Developer'],
            ['name' => 'Developer name', 'role' => 'Developer'],
            ['name' => 'Partner name', 'role' => 'Partner'],
            ['name' => 'Partner name', 'role' => 'Partner'],
        ],
    ],

    'projects' => [
        'prev' => 'Previous projects',
        'next' => 'Next projects',
        'title' => 'Successful projects',
        'lead' => 'Websites, social media, video and advertising for our clients.',
        // TODO: replace with real case studies.
        'items' => [
            ['category' => 'Website', 'title' => 'Project name'],
            ['category' => 'Social media', 'title' => 'Project name'],
            ['category' => 'Video', 'title' => 'Project name'],
            ['category' => 'Google Ads', 'title' => 'Project name'],
            ['category' => 'Branding', 'title' => 'Project name'],
        ],
    ],

    'cta' => [
        'title' => 'Want to work with the whole team?',
    ],
];
