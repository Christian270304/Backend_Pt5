<?php
require_once 'env.php';
return [
    'callback' => 'http://localhost/Backend-Pt05/authenticate.php',
    'providers' => [
        'GitHub' => [
            'enabled' => true,
            'keys' => [
                'id' => CLIENT_GIT_ID,
                'secret' => CLIENT_GIT_SECRET,
            ],
        ],
        // Add other providers here
    ],
];
?>