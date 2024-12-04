<?php
require_once 'env.php';
return [
    'callback' => 'http://localhost/Backend_PT5/index.php?pagina=hybridauth',
    'providers' => [
        'GitHub' => [
            'enabled' => true,
            'keys' => [
                'id' => CLIENT_GIT_ID,
                'secret' => CLIENT_GIT_SECRET,
            ],
            'scope' => 'user:email',
        ],
        // Add other providers here
    ],
];
?>