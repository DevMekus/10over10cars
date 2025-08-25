<?php

use App\Utils\Utility;

Utility::verifySession();

$role = $_SESSION['role'] == "1" ? "admin" : "user";
$userid = $_SESSION['userid'];

// Only fetch profile if not already in session
if (!isset($_SESSION['user_profile'])) {
    $url = BASE_URL . "api/user/profile/$userid";
    $getProfile = Utility::requestClient($url);
    $user = $getProfile['data'] ?? null;

    if (!$user) {
        header('location: ' . BASE_URL . 'auth/login?f-bk=UNAUTHORIZED');
        exit;
    }

    // Store in session for reuse
    $_SESSION['user_profile'] = $user;
} else {
    $user = $_SESSION['user_profile'];
}

$role = $_SESSION['role'];
