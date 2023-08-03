<?php

use App\Models\OrderItem;

return [
    [
        'title' => 'Əsas'
    ],
    [
        'icon' => '<i class="fas fa-home"></i>',
        'title' => 'Əsas səhifə',
        'route' => 'admin.dashboard',
        'can'   => 'admin.dashboard',

    ],
    [
        'title' => 'İstifadəçilər',
        'icon'  => '<i class="fas fa-user"></i>',
        'inner' => [
            [
                'title' => 'İstifadəçilər',
                'route' => 'admin.users.index',
                'icon'  => '<i class="fas fa-columns"></i>',
                'can' => 'users.index',
            ],
            [
                'title' => 'Rollar',
                'route' => 'admin.roles.index',
                'icon'  => '<i class="fas fa-columns"></i>',
                'can' => 'roles.index',
            ]
        ],
    ],
    // [
    //     'title' => 'Ayarlar',
    //     'icon'  => '<i class="fas fa-cogs"></i>',
    //     'inner' => [
    //         [
    //             'title' => 'Sayt ayarları',
    //             'route' => 'admin.site-settings.index',
    //             'icon'  => '<i class="fas fa-columns"></i>',
    //             'can' => 'ite-settings.index',
    //         ],
    //         [
    //             'title' => 'Proqram ayarları',
    //             'route' => 'admin.settings.index',
    //             'params' => ['type' => 'program'],
    //             'icon'  => '<i class="fas fa-cogs"></i>',
    //             'can' => 'users.index'
    //         ],
    //         [
    //             'title' => 'DGK ayarları',
    //             'route' => 'admin.settings.dgk.index',
    //             'icon'  => '<i class="fas fa-arrows-alt-h"></i>',
    //             'can' => 'settings.dgk.index'
    //         ],
    //         [
    //             'title' => 'Ödəmə ayarları',
    //             'route' => 'admin.payment.settings',
    //             'icon'  => '<i class="far fa-credit-card"></i>',
    //             'can' => 'payment.settings'
    //         ],
    //         [
    //             'title' => 'Mobil Ayarlar',
    //             'route' => 'admin.settings.index',
    //             'params' => ['type' => 'mobile'],
    //             'icon'  => '<i class="fas fa-code"></i>',
    //             'can' => 'users.index'
    //         ],
    //         [
    //             'icon' => '<i class="fab fa-font-awesome"></i>',
    //             'title' => 'Ödəmə mərkəzləri',
    //             'route' => 'admin.payment-center.index',
    //             'can' => 'payment-center'
    //         ],
    //         [
    //             'icon' => '<i class="fas fa-sms"></i>',
    //             'title' => 'SMS Text',
    //             'route' => 'admin.sms-text.index',
    //             'can' => 'admin.sms-text.index'
    //         ],
    //         [
    //             'icon' => '<i class="fas fa-bell"></i>',
    //             'title' => 'Notification Text',
    //             'route' => 'admin.notification-text.index',
    //             'can' => 'admin.sms-text.index'
    //         ],
    //         [
    //             'icon' => '<i class="fas fa-file-signature"></i>',
    //             'title' => 'Content Text',
    //             'route' => 'admin.content-text.index',
    //             'can' => 'admin.content-text.index'
    //         ]
    //     ],
    // ],

];
