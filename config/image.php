<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */

    'driver' => 'gd',

    /*
     * Директория для сохранения изображений товаров.
     */
    'folder' => 'products/',

    /*
     * Настройка модификации изображений товаров и уменьшенных копий.
     */
    'modification' => [
        'original' => [
            'prefix' => '',
            'resize' => 1024
        ],
        'th' => [
            'prefix' => 'th_',
            'resize' => 100
        ],
        'fit' => [
            'prefix' => 'fit_',
            'resize' => 400
        ]
    ],

    /*
     * Настройка модификации изображений товаров и уменьшенных копий.
     */
    'defaultSrc' => 'no_image.jpg',
];
