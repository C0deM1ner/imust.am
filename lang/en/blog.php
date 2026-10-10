<?php

return [
    'meta_title' => 'Blog',
    'meta_description' => 'Practical notes from the I MUST team on websites, social media, video and local search.',

    'eyebrow' => 'Blog',
    'title' => 'Notes from the team',
    'lead' => 'Practical advice on websites, social media, video and local search, from the people who do the work.',
    'image_alt' => 'Desk with a notebook and a laptop',

    'read_time' => ':minutes min read',
    'read_article' => 'Read article',
    'back' => 'All articles',
    'more' => 'More articles',
    'share' => 'Share',
    'copy_link' => 'Copy link',
    'copied' => 'Link copied',

    // TODO: sample articles. Replace with real posts (keys must match config/blog.php).
    'posts' => [
        'trilingual-website' => [
            'category' => 'Websites',
            'title' => 'Why your website should speak Armenian, Russian and English',
            'excerpt' => 'Your customers search in more than one language. Here is how a trilingual site helps them find you and trust you.',
            'body' => [
                ['p', 'In Armenia, people rarely search in just one language. A customer might look you up in Armenian, read reviews in Russian and compare prices in English. If your website answers in only one of them, part of your audience leaves before they read a word.'],
                ['h2', 'Search engines index each language separately'],
                ['p', 'Every language version of a page is a separate chance to appear in search results. A properly built trilingual site tells Google which page belongs to which language, so each visitor lands on the version they understand.'],
                ['h2', 'Translation is not enough'],
                ['p', 'Good multilingual content is adapted, not copied word for word. Headlines, examples and calls to action should sound natural to each audience.'],
                ['ul', [
                    'Write the main message in each language, do not only translate it',
                    'Keep prices, contacts and opening hours identical everywhere',
                    'Let visitors switch language without losing the page they are on',
                ]],
                ['h2', 'Where to start'],
                ['p', 'Start with the pages people visit most: home, services and contact. Add the rest as your content grows. A trilingual website is part of every I MUST Start package.'],
            ],
        ],
        'google-business-profile' => [
            'category' => 'Local search',
            'title' => 'Set up your Google Business Profile in an afternoon',
            'excerpt' => 'A complete profile helps people find you on Google Maps and in local search. These are the steps we follow for every client.',
            'body' => [
                ['p', 'When someone searches for a business nearby, Google often shows a map with a few profiles before any website. A complete, accurate profile is one of the fastest ways to become visible locally.'],
                ['h2', 'The essentials'],
                ['ul', [
                    'Choose the category that best describes your main service',
                    'Add your exact address, working hours and phone number',
                    'Upload real photos of your place, your team and your work',
                    'Write a short description in plain language',
                ]],
                ['h2', 'Keep it alive'],
                ['p', 'Profiles that are updated regularly look trustworthy. Post news, answer every review and update your hours on holidays.'],
                ['quote', 'A profile that answers questions before a customer calls saves time for both of you.'],
                ['p', 'Google Business Profile setup is included in I MUST Start, together with Facebook, Instagram, LinkedIn and YouTube.'],
            ],
        ],
        'reels-that-sell' => [
            'category' => 'Video',
            'title' => 'Reels that sell: what we plan before we press record',
            'excerpt' => 'Good short videos start long before the shoot. A simple plan keeps every reel focused on one message and one action.',
            'body' => [
                ['p', 'A reel has a few seconds to earn attention. Whether a video is scrolled past or brings in messages is usually decided at the planning stage, not in editing.'],
                ['h2', 'One reel, one message'],
                ['p', 'Decide what a viewer should remember and what they should do next. If a reel tries to say three things, it says none of them clearly.'],
                ['h2', 'Our pre-shoot checklist'],
                ['ul', [
                    'The hook: what happens in the first second',
                    'The proof: the product, the result or the person behind it',
                    'The action: what to tap, call or visit',
                    'The format: vertical, captions on, sound optional',
                ]],
                ['h2', 'Consistency beats perfection'],
                ['p', 'Regular videos that look like your brand build more trust than one expensive production a year. That is why video shooting and editing are part of I MUST Grow every month.'],
            ],
        ],
    ],
];
