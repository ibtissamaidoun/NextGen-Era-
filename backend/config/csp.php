<?php

use Spatie\Csp\Keyword;
use Spatie\Csp\Nonce\RandomString;

return [

    'policy' => App\Policies\Basic::class,

    'report_only_policy' => '',

    'report_uri' => env('CSP_REPORT_URI', ''),

    'enabled' => env('CSP_ENABLED', true),
    
    'nonce' => [
    'class' => RandomString::class,
    'length' => 16,
],
    
];
