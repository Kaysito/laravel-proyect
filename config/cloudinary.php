<?php

/*
 * This file is part of the Laravel Cloudinary package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Cloudinary Notification URL
    |--------------------------------------------------------------------------
    */
    'notification_url' => env('CLOUDINARY_NOTIFICATION_URL'),

    /*
    |--------------------------------------------------------------------------
    | Cloudinary Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your Cloudinary settings.
    |
    */
    'cloud_url' => env(
        'CLOUDINARY_URL',
        'cloudinary://'
            . env('CLOUDINARY_API_KEY')
            . ':'
            . env('CLOUDINARY_API_SECRET')
            . '@'
            . env('CLOUDINARY_CLOUD_NAME')
    ),

    /*
    |--------------------------------------------------------------------------
    | Upload Preset
    |--------------------------------------------------------------------------
    */
    'upload_preset' => env('CLOUDINARY_UPLOAD_PRESET'),

    /*
    |--------------------------------------------------------------------------
    | Upload Route (optional)
    |--------------------------------------------------------------------------
    */
    'upload_route' => env('CLOUDINARY_UPLOAD_ROUTE'),

    /*
    |--------------------------------------------------------------------------
    | Upload Action (optional)
    |--------------------------------------------------------------------------
    */
    'upload_action' => env('CLOUDINARY_UPLOAD_ACTION'),
];
