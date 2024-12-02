<?php
require_once '../libs/GitHub_HibrydAuth/vendor/autoload.php';

use Hybridauth\Hybridauth;
use Hybridauth\Hybridauth\SRC\HttpClient;

$config = require '../hybridauth.php';

try {
    $hybridauth = new Hybridauth($config);
    $adapter = $hybridauth->authenticate('GitHub');
    $userProfile = $adapter->getUserProfile();

    // Process user profile data
    echo 'Hi ' . $userProfile->displayName;

    // Logout
    $adapter->disconnect();
} catch (\Exception $e) {
    echo 'Oops, we ran into an issue! ' . $e->getMessage();
}
?>