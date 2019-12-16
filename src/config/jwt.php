<?php

use LaravelJwt\Options\SupportedAlgorithms;

return [
    'signature' => env('JWT_SIGNATURE'),
    'algorithm' => SupportedAlgorithms::HS256,
    'max_age'   => 3600,
    'leeway'    => 120,
];
