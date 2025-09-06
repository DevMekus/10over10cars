<?php

use Dotenv\Dotenv;

require_once ROOT_PATH . "/vendor/autoload.php";

if (file_exists(ROOT_PATH . '/.env')) {
    $dotenv = Dotenv::createImmutable(ROOT_PATH);
    $dotenv->safeLoad(); // safeLoad ignores missing file
}
