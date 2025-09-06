<?php

namespace App\Utils;

/**
 * Class Utility
 * 
 * Provides helper methods for encryption, file uploads, session management,
 * logging, URL handling, and other general-purpose utilities.
 * 
 * @package App\Utils
 */
class Utility
{
    /** @var string Base API route */
    public static string $API_ROUTE = "/10over10cars/api"; //just /api in a live server

    /** @var string Site name */
    public static string $siteName = '';

    /** @var string Database table names */
    public static string $accounts_tbl = 'accounts_tbl';
    public static string $profile_tbl = 'profile_tbl';
    public static string $dealers_tbl = 'dealers_tbl';
    public static string $loginactivity = 'loginactivity';
    public static string $notification = 'notification';
    public static string $plans = 'plans';
    public static string $transaction_tbl = 'transaction_tbl';
    public static string $vehicles_tbl = 'vehicles_tbl';
    public static string $verifications_tbl = 'verifications_tbl';
    public static string $accident_tbl = 'accident';
    public static string $insurance_tbl = 'insurance';
    public static string $ownership_tbl = 'ownership';
    public static string $specifications_tbl = 'specifications';
    public static string $sessions_tbl = 'sessions';

    /** @var string Encryption method */
    private const ENCRYPTION_METHOD = 'AES-256-CBC';

    /** @var array Activity log mapping */
    public static array $activities = [
        '1' => 'login',
        '2' => 'register',
        '3' => 'logout',
        '4' => 'Dealer',
        '5' => 'Notification',
        '6' => 'Verification',
    ];

    /**
     * Retrieve the encryption key.
     * 
     * @return string
     */
    private static function getKey(): string
    {
        return hex2bin('0123456789abcdef0123456789abcdef0123456789abcdef0123456789abcdef');
    }

    /**
     * Encrypt a plaintext string.
     * 
     * @param string $plaintext
     * @return string
     * @throws \RuntimeException
     */
    public static function encrypt(string $plaintext): string
    {
        try {
            $key = self::getKey();
            $ivLength = openssl_cipher_iv_length(self::ENCRYPTION_METHOD);
            $iv = openssl_random_pseudo_bytes($ivLength);

            $cipherText = openssl_encrypt($plaintext, self::ENCRYPTION_METHOD, $key, 0, $iv);
            if ($cipherText === false) {
                throw new \RuntimeException("Encryption failed.");
            }

            return base64_encode($iv . $cipherText);
        } catch (\Throwable $e) {
            self::log($e->getMessage(), 'error', 'Utility::encrypt', [], $e);
            throw $e;
        }
    }

    /**
     * Decrypt a ciphertext string.
     * 
     * @param string $ciphertext
     * @return string
     * @throws \RuntimeException
     */
    public static function decrypt(string $ciphertext): string
    {
        try {
            $key = self::getKey();
            $data = base64_decode($ciphertext, true);

            if ($data === false) {
                throw new \RuntimeException("Invalid base64 ciphertext.");
            }

            $ivLength = openssl_cipher_iv_length(self::ENCRYPTION_METHOD);
            $iv = substr($data, 0, $ivLength);
            $encryptedData = substr($data, $ivLength);

            $plaintext = openssl_decrypt($encryptedData, self::ENCRYPTION_METHOD, $key, 0, $iv);
            if ($plaintext === false) {
                throw new \RuntimeException("Decryption failed.");
            }

            return $plaintext;
        } catch (\Throwable $e) {
            self::log($e->getMessage(), 'error', 'Utility::decrypt', [], $e);
            throw $e;
        }
    }

    /**
     * Create a directory if it does not exist.
     * 
     * @param string $userDir
     * @return bool
     */
    public static function makeDirectory(string $userDir): bool
    {
        try {
            if (!file_exists($userDir)) {
                if (!mkdir($userDir, 0777, true) && !is_dir($userDir)) {
                    throw new \RuntimeException("Failed to create directory: $userDir");
                }
                chmod($userDir, 0777);
            }
            return true;
        } catch (\Throwable $e) {
            self::log($e->getMessage(), 'error', 'Utility::makeDirectory', [], $e);
            return false;
        }
    }

    /**
     * Generate a unique ID.
     * 
     * @param int $length
     * @return string
     */
    public static function generate_uniqueId(int $length = 10): string
    {
        try {
            return bin2hex(random_bytes($length));
        } catch (\Throwable $e) {
            self::log($e->getMessage(), 'error', 'Utility::generate_uniqueId', [], $e);
            return '';
        }
    }

    /**
     * Get the base site URL.
     * 
     * @return string
     */
    public static function site_url(): string
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || ($_SERVER['SERVER_PORT'] ?? 80) == 443
            ? "https"
            : "http";
        $domain = $_SERVER['HTTP_HOST'] ?? 'localhost';
        return $protocol . "://" . $domain;
    }

    /**
     * Log messages to a file with optional exception data.
     * 
     * @param string $message
     * @param string $level
     * @param string $context
     * @param array $extra
     * @param \Throwable|null $exception
     * @return void
     */
    public static function log(
        string $message,
        string $level = 'info',
        string $context = 'general',
        array $extra = [],
        ?\Throwable $exception = null
    ): void {
        try {
            $logDir = __DIR__ . "/../../logs";
            if (!is_dir($logDir)) {
                mkdir($logDir, 0777, true);
            }

            $logFile = $logDir . '/' . date('Y-m-d') . '.log';
            $logEntry = [
                'timestamp' => date('c'),
                'level' => strtolower($level),
                'context' => $context,
                'message' => $message,
                'extra' => $extra
            ];

            if ($exception) {
                $logEntry['exception'] = [
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'code' => $exception->getCode(),
                    'trace' => $exception->getTraceAsString()
                ];
            }

            file_put_contents($logFile, json_encode($logEntry) . PHP_EOL, FILE_APPEND);
        } catch (\Throwable $e) {
            // If logging fails, silently ignore to avoid infinite loops
        }
    }

    /**
     * Upload one or multiple documents to the target directory.
     *
     * @param string $inputName The name of the file input field.
     * @param string $targetDir Target directory relative to BASE_DIR.
     * @return array Result with keys: success, files[], errors[]
     */
    public static function uploadDocuments(string $inputName, string $targetDir): array
    {
        try {
            if (!isset($_FILES[$inputName]) || empty($_FILES[$inputName]['name'][0])) {
                self::log("No files uploaded via input: $inputName", 'error');
                return ['success' => false, 'files' => [], 'errors' => ['No files uploaded.']];
            }

            $uploadedPaths = [];
            $errors = [];

            // Normalize single file to array format
            if (!is_array($_FILES[$inputName]['name'])) {
                $_FILES[$inputName] = [
                    'name' => [$_FILES[$inputName]['name']],
                    'type' => [$_FILES[$inputName]['type']],
                    'tmp_name' => [$_FILES[$inputName]['tmp_name']],
                    'error' => [$_FILES[$inputName]['error']],
                    'size' => [$_FILES[$inputName]['size']]
                ];
            }

            $files = [];
            foreach ($_FILES[$inputName]['name'] as $i => $name) {
                $files[] = [
                    'name' => $_FILES[$inputName]['name'][$i],
                    'type' => $_FILES[$inputName]['type'][$i],
                    'tmp_name' => $_FILES[$inputName]['tmp_name'][$i],
                    'error' => $_FILES[$inputName]['error'][$i],
                    'size' => $_FILES[$inputName]['size'][$i],
                ];
            }

            $absoluteTargetDir = rtrim(BASE_DIR, '/') . '/' . trim($targetDir, '/') . '/';
            if (!is_dir($absoluteTargetDir) && !mkdir($absoluteTargetDir, 0755, true) && !is_dir($absoluteTargetDir)) {
                throw new \RuntimeException("Failed to create target directory: $absoluteTargetDir");
            }

            foreach ($files as $file) {
                $name = $file['name'];
                $tmpName = $file['tmp_name'];
                $error = $file['error'];
                $size = $file['size'];

                $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                $allowedExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'jpeg', 'jpg', 'png'];
                $allowedMimeTypes = [
                    'application/pdf',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/vnd.ms-excel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'image/jpeg',
                    'image/png',
                ];

                if ($error !== UPLOAD_ERR_OK) {
                    self::log("File upload error ($error) for $name", 'error');
                    $errors[] = ['file' => $name, 'reason' => 'Upload error'];
                    continue;
                }

                if (!in_array($extension, $allowedExtensions, true)) {
                    self::log("Invalid file extension ($extension) for file: $name", 'error');
                    $errors[] = ['file' => $name, 'reason' => 'Invalid file extension'];
                    continue;
                }

                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime = finfo_file($finfo, $tmpName);
                finfo_close($finfo);

                if (!in_array($mime, $allowedMimeTypes, true)) {
                    self::log("Invalid MIME type ($mime) for file: $name", 'error');
                    $errors[] = ['file' => $name, 'reason' => 'Invalid MIME type'];
                    continue;
                }

                if ($size > 10 * 1024 * 1024) {
                    self::log("File too large ($size bytes) for file: $name", 'error');
                    $errors[] = ['file' => $name, 'reason' => 'File size exceeds 10MB'];
                    continue;
                }

                $uniqueName = uniqid('', true) . '.' . $extension;
                $destinationPath = $absoluteTargetDir . $uniqueName;

                if (!move_uploaded_file($tmpName, $destinationPath)) {
                    self::log("Failed to move file: $name to $destinationPath", 'error');
                    $errors[] = ['file' => $name, 'reason' => 'Failed to move file'];
                    continue;
                }

                $uploadedPaths[] = rtrim(BASE_URL, '/') . '/' . trim($targetDir, '/') . '/' . $uniqueName;
            }

            return [
                'success' => !empty($uploadedPaths),
                'files' => $uploadedPaths,
                'errors' => $errors,
            ];
        } catch (\Throwable $e) {
            self::log($e->getMessage(), 'error', 'Utility::uploadDocuments', [], $e);
            return ['success' => false, 'files' => [], 'errors' => ['An error occurred while uploading files.']];
        }
    }

    /**
     * Verify if a user session is active and valid.
     *
     * Redirects to login page if session is invalid or JWT expired.
     */
    public static function verifySession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['role'], $_SESSION['token']) || self::isJwtExpired($_SESSION['token'])) {
            header("Location: " . BASE_URL . "auth/login?f-bk=UNAUTHORIZED");
            exit;
        }
    }

    /**
     * Check if a JWT token has expired.
     *
     * @param string $token
     * @return bool
     */
    public static function isJwtExpired(string $token): bool
    {
        try {
            $parts = explode('.', $token);
            if (count($parts) !== 3) return true;

            $payload = json_decode(base64_decode(strtr($parts[1], '-_', '+/')), true);
            return !isset($payload['exp']) || $payload['exp'] < time();
        } catch (\Throwable $e) {
            self::log($e->getMessage(), 'error', 'Utility::isJwtExpired', [], $e);
            return true;
        }
    }

    /**
     * Make a GET request to a URL with optional JWT authentication.
     *
     * @param string $url
     * @return array|false
     */
    public static function requestClient(string $url)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $token = $_SESSION['token'] ?? null;

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $headers = ['Origin: ' . BASE_URL];
            if ($token) {
                $headers[] = 'Authorization: Bearer ' . $token;
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            return ($httpCode === 200) ? json_decode($response, true) : false;
        } catch (\Throwable $e) {
            self::log($e->getMessage(), 'error', 'Utility::requestClient', [], $e);
            return false;
        }
    }

    /**
     * Truncate text to a given length, appending ellipsis if needed.
     *
     * @param string $text
     * @param int $limit
     * @return string
     */
    public static function truncateText(string $text, int $limit = 100): string
    {
        return mb_strlen($text) <= $limit ? $text : mb_substr($text, 0, $limit) . '...';
    }

    /**
     * Get the current route relative to the base folder.
     *
     * @return string
     */
    public static function currentRoute(): string
    {
        $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
        $baseFolder = '/10over10cars';

        if (strpos($requestUri, $baseFolder) === 0) {
            $requestUri = substr($requestUri, strlen($baseFolder));
        }

        return trim(parse_url($requestUri, PHP_URL_PATH) ?? '', '/');
    }

    /**
     * Get the client's IP address.
     *
     * @return string
     */
    public static function getUserIP(): string
    {
        return $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }

    /**
     * Get the client's device user agent string.
     *
     * @return string
     */
    public static function getUserDevice(): string
    {
        return $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
    }
}
