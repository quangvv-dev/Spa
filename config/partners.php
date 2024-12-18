<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services Logistics
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as GHH, GHTK ... logistic PINGGO supports.
    |
    */
    'zalo_zns' => [
        'url' => env('ZALO_ZNS_URL', 'https://business.openapi.zalo.me/message/template'),
        'url_oa' => env('ZALO_OA_URL', 'https://oauth.zaloapp.com/v4/oa/access_token'),
        'template_id' => env('ZALO_ZNS_TEMPLATE_ID'),
        'access_token' => env('ZALO_ZNS_TOKEN', 'NygC2t8q9s1Uo886SZ8hQb7AWm9pBrSAAR6T4KatI3yHkE8qCaC74cwwqG1BCpyFF8xx6qPnK2KsvQCxIKeBBcN5to41E2KnPCJx7WPb01DJd-aMDICw9tYnn1qcGc5qNxZ9KdanDtGXo_uOG3CI8cAD-WaVSLOaMU2aFnXcRL94nAPR6aXLLcVb-6OHQ11xK_FYIorIEsOEyivGKm0HHN-Dn5W07pW-BBwTDae4NoeJcwSvDpDJF7Mnh2e5Bm83HAFw7Hm4CWvRbjuc3IuKJ5QTpdSoOof1KlBxVpHADt5GtjfPVK45TGFEptfUSpvLS-YQQ3PdCLeHtDj2L3SKovrVVoyYRG'),
        'secret_key' => env('ZALO_ZNS_SECRET_KEY', 'nW7FDgWGFCL4HXt0T6Dy'),
        'app_id' => env('ZALO_ZNS_APP_ID', '3995648789814373576'),
    ]

];
