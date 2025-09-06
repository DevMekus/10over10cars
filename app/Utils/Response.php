<?php

namespace App\Utils;

/**
 * Class Response
 *
 * Handles standardized JSON HTTP responses for APIs.
 * Provides helpers for success, error, and validation responses.
 *
 * @package App\Utils
 */
class Response
{
    /**
     * Send a JSON response.
     *
     * @param int         $status  HTTP status code
     * @param mixed|null  $data    Response data
     * @param string|null $message Optional message
     *
     * @return void
     */
    public static function sendJson(int $status,  $data = null, ?string $message = null): void
    {
        try {
            // Set HTTP status code
            http_response_code($status);

            // Ensure headers can still be sent
            if (!headers_sent()) {
                header('Content-Type: application/json; charset=UTF-8');
            }

            // Prepare structured response
            $response = [
                'status'  => $status,
                'message' => $message ?? self::getStatusMessage($status),
                'data'    => $data,
            ];

            // Encode as JSON safely
            $json = json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

            if ($json === false) {
                // Fallback if encoding fails
                $json = json_encode([
                    'status'  => 500,
                    'message' => 'Failed to encode JSON response',
                ]);
                http_response_code(500);
            }

            echo $json;
            exit();
        } catch (\Throwable $e) {
            // Last-resort fallback if something goes wrong while sending response
            http_response_code(500);
            echo json_encode([
                'status'  => 500,
                'message' => 'Unexpected server error while sending response',
            ]);
            exit();
        }
    }

    /**
     * Send a success response.
     *
     * @param mixed|null  $data    Response data
     * @param string|null $message Optional message
     *
     * @return void
     */
    public static function success($data = null, ?string $message = null): void
    {
        self::sendJson(200, $data, $message ?? 'Success');
    }

    /**
     * Send an error response.
     *
     * @param int         $status  HTTP status code
     * @param string|null $message Optional error message
     * @param mixed|null  $data    Additional error details
     *
     * @return void
     */
    public static function error(int $status, ?string $message = null,  $data = null): void
    {
        self::sendJson($status, $data, $message ?? 'An error occurred');
    }

    /**
     * Send a validation error response.
     *
     * @param array       $errors  Validation errors
     * @param string|null $message Optional message
     *
     * @return void
     */
    public static function validationError(array $errors = [], ?string $message = 'Validation failed'): void
    {
        self::sendJson(422, $errors, $message);
    }

    /**
     * Get the default HTTP status message for a given status code.
     *
     * @param int $status HTTP status code
     *
     * @return string
     */
    private static function getStatusMessage(int $status): string
    {
        $statusMessages = [
            200 => 'OK',
            201 => 'Created',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            422 => 'Unprocessable Entity',
            500 => 'Internal Server Error',
        ];

        return $statusMessages[$status] ?? 'Unknown Status';
    }
}
