<?php

namespace App\Utils;


class Utility
{
    public static string $API_ROUTE = "/10over10cars/api";
    public static $siteName = '';
    public static $theft_tbl = 'theft_reports';
    public static $profile_tbl = 'users_tbl';
    public static $verification_tbl = 'verification_request';
    public static $vinDocs_tbl = 'vehicle_documents';
    public static $vinHistory_tbl = 'vehicle_history';
    public static $vinImages_tbl = 'vehicle_image';
    public static $vinInfo_tbl = 'vehicle_information';
    public static $vinOwnership_tbl = 'vehicle_ownerships';
    public static $vinSpec_tbl = 'vehicle_specs';
    public static $vinValuation_tbl = 'vehicle_valuation';
    public static $vinInspection_tbl = 'inspections';
    public static $dealers_tbl = 'dealers_tbl';

    public static function makeDirectory(string $userDir)
    {
        /**
         * Create a new directory
         */

        if (!file_exists($userDir)) {
            if (mkdir($userDir, 0777, true)) {
                chmod($userDir, 0777);
                return true;
            }
            return false;
        }
    }

    public static function generate_uniqueId($length = 10)
    {
        return bin2hex(random_bytes($length));
    }

    public static function site_url()
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443 ? "https" : "http";
        $domain = $_SERVER['HTTP_HOST'];
        $path = $_SERVER['REQUEST_URI'];

        return $protocol . "://" . $domain;
    }


    static function log(
        string $message,
        string $level = 'info',
        string $context = 'general',
        array $extra = [],
        ?\Throwable $exception = null
    ) {
        $logDir = __DIR__ . "/../../logs";

        if (!file_exists($logDir)) {
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
    }


    public static function uploadDocuments(string $inputName, string $targetDir): array
    {
        if (!isset($_FILES[$inputName]) || empty($_FILES[$inputName]['name'][0])) {
            Utility::log("No files uploaded via input: $inputName", 'error');
            return ['success' => false, 'error' => 'No files uploaded.'];
        }

        $uploadedPaths = [];
        $errors = [];

        // Normalize input
        $files = [];
        foreach ($_FILES[$inputName]['name'] as $i => $name) {
            $files[] = [
                'name' => $_FILES[$inputName]['name'][$i],
                'type' => $_FILES[$inputName]['type'][$i],
                'tmp_name' => $_FILES[$inputName]['tmp_name'][$i],
                'error' => $_FILES[$inputName]['error'][$i],
                'size' => $_FILES[$inputName]['size'][$i]
            ];
        }

        // Prepare absolute target path
        $absoluteTargetDir = rtrim(BASE_DIR, '/') . '/' . trim($targetDir, '/') . '/';
        if (!is_dir($absoluteTargetDir)) {
            mkdir($absoluteTargetDir, 0755, true);
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
                Utility::log("File upload error ($error) for $name", 'error');
                $errors[] = ['file' => $name, 'reason' => 'Upload error'];
                continue;
            }

            if (!in_array($extension, $allowedExtensions)) {
                Utility::log("Invalid file extension ($extension) for file: $name", 'error');
                $errors[] = ['file' => $name, 'reason' => 'Invalid file extension'];
                continue;
            }

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $tmpName);
            finfo_close($finfo);

            if (!in_array($mime, $allowedMimeTypes)) {
                Utility::log("Invalid MIME type ($mime) for file: $name", 'error');
                $errors[] = ['file' => $name, 'reason' => 'Invalid MIME type'];
                continue;
            }

            if ($size > 10 * 1024 * 1024) {
                Utility::log("File too large ($size bytes) for file: $name", 'error');
                $errors[] = ['file' => $name, 'reason' => 'File size exceeds 10MB'];
                continue;
            }

            $uniqueName = uniqid('', true) . '.' . $extension;
            $destinationPath = $absoluteTargetDir . $uniqueName;

            if (!move_uploaded_file($tmpName, $destinationPath)) {
                Utility::log("Failed to move file: $name to $destinationPath", 'error');
                $errors[] = ['file' => $name, 'reason' => 'Failed to move file'];
                continue;
            }

            // Construct full public URL
            $publicUrl = rtrim(BASE_URL, '/') . '/' . trim($targetDir, '/') . '/' . $uniqueName;
            $uploadedPaths[] = $publicUrl;
        }

        return [
            'success' => count($uploadedPaths) > 0,
            'files' => $uploadedPaths,
            'errors' => $errors
        ];
    }




    public static function verifySession()
    {
        session_start();
        if (!isset($_SESSION['role'], $_SESSION['token'])) {
            header("Location: " . BASE_URL . "auth/login?f-bk=UNAUTHORIZED");
            exit;
        }
        if (self::isJwtExpired($_SESSION['token']))
            header("Location: " . BASE_URL . "auth/login?f-bk=UNAUTHORIZED");
    }

    static function isJwtExpired($token)
    {
        $parts = explode(".", $token);
        if (count($parts) !== 3) return true;
        $payload = json_decode(base64_decode(strtr($parts[1], '-_', '+/')), true);
        if (!isset($payload['exp'])) return true;
        return $payload['exp'] < time();
    }

    public  static function requestClient($url)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $token = $_SESSION['token'] ?? null;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //set headers
        $headers = [];
        if ($token) {
            $headers[] = 'Authorization: Bearer ' . $token;
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ($httpCode === 200) ? json_decode($response, true) : false;
    }

    public static function truncateText(string $text, int $limit = 100): string
    {
        if (mb_strlen($text) <= $limit) {
            return $text;
        }
        return mb_substr($text, 0, $limit) . '...';
    }
}
