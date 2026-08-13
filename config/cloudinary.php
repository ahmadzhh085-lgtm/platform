<?php

return [
    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
    'api_key' => env('CLOUDINARY_API_KEY'),
    'api_secret' => env('CLOUDINARY_API_SECRET'),
    'url' => env('CLOUDINARY_URL'),
    
    // الإعدادات الافتراضية للرفع
    'upload' => [
        'folder' => 'investment-platform/properties', // مجلد التخزين
        'resource_type' => 'auto',
        'max_file_size' => 5 * 1024 * 1024, // 5MB
        'allowed_formats' => ['jpg', 'png', 'jpeg', 'webp', 'gif'],
        'transformation' => [
            'width' => 800,
            'height' => 800,
            'crop' => 'limit',
            'quality' => 'auto',
        ],
    ],
];
