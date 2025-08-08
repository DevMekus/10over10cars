<?php

use App\Utils\Utility;

Utility::verifySession();

// if ($_SESSION['userid']) {
//     $userid = $_SESSION['userid'];
//     $url = API_URL  . "user/" . $userid;
//     $fetch = Utility::requestClient($url);
//     $user = $fetch['data'] ?? null;
// }
// if (!$user) header('location: ' . BASE_URL . 'auth/login?f-bk=UNAUTHORIZED');

$role = $_SESSION['role'];
