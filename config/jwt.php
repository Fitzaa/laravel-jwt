<?php

use Floinay\LaravelJwt\Options\SupportedAlgorithms;

return [
    'signature'       => env('JWT_SIGNATURE'),
    'algorithm'       => SupportedAlgorithms::HS256,
    'max_age'         => 3600,
    'max_refresh_age' => 3600 * 30,
    'leeway'          => 120,
];
