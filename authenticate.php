<?php

define('ADMIN_LOGIN', 'Admin');
define('ADMIN_PASSWORD', 'Pass');
define('CUSTOMER_LOGIN', 'Customer');
define('CUSTOMER_PASSWORD', 'Pass');

$authenticated = false;

if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
    $username = $_SERVER['PHP_AUTH_USER'];
    $password = $_SERVER['PHP_AUTH_PW'];

    // Check if credentials are for admin or customer
    if (($username === ADMIN_LOGIN && $password === ADMIN_PASSWORD) ||
        ($username === CUSTOMER_LOGIN && $password === CUSTOMER_PASSWORD)) {
        $authenticated = true;
    }
}

if (!$authenticated) {
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Basic realm="Drive2Fly Admin"');
    exit("Access Denied: Username and password required.");
}

// If authenticated, continue with the rest of the script
?>
