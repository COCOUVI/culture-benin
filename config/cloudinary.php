<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cloudinary Configuration
    |--------------------------------------------------------------------------
    */

    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),

    'api_key' => env('CLOUDINARY_API_KEY'),

    'api_secret' => env('CLOUDINARY_API_SECRET'),

    'upload_preset' => env('CLOUDINARY_UPLOAD_PRESET'),

    'notification_url' => env('CLOUDINARY_NOTIFICATION_URL'),

    'secure' => env('CLOUDINARY_SECURE_URL', true),

    'secure_distribution' => env('CLOUDINARY_SECURE_DISTRIBUTION'),

    'private_cdn' => env('CLOUDINARY_PRIVATE_CDN'),
];
