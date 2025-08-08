<?php


define("BRAND_NAME", "10over10Cars");
define("BRAND_PHONE", "+1 800 123 4567");
define("BRAND_EMAIL", "support@10over10cars.com");


// ===========================
// ROOT AND URL DEFINITIONS
// ===========================

// Physical rooth path (for require/ include)
define('ROOT_PATH', dirname(__FILE__));

// Public folder
define('PUBLIC_PATH', ROOT_PATH . '/public');

//Site base URL
$https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
    (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ||
    (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);

define('BASE_URL', ($https ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/10over10cars/');
define('BASE_DIR', $_SERVER['DOCUMENT_ROOT'] . '/10over10cars/');


//API
define("API_URL", BASE_URL . "api/");

// ===========================
// AUTOLOAD CORE FILES
// ===========================

if (file_exists(ROOT_PATH . '/app/Utils/Utility.php')) {
    require_once ROOT_PATH . '/app/Utils/Utility.php';
}

if (file_exists(ROOT_PATH . '/vendor/autoload.php')) {
    require_once ROOT_PATH . '/vendor/autoload.php';
}

// ===========================
// ENVIRONMENT DETECTION
// ===========================

if ($_SERVER['HTTP_HOST'] == 'localhost') {
    define("ENVIRONMENT", 'development');
} else {
    define('ENVIRONMENT', 'production');
}

if (ENVIRONMENT == 'development') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}
