<?php

namespace App\Utils;

use App\Utils\Response;

/**
 * Class RequestValidator
 *
 * Provides utility methods for validating and sanitizing request data.
 * Includes common validation rules, sanitization helpers, and format parsing.
 *
 * @package App\Utils
 */
class RequestValidator
{
    /**
     * Validate request data against defined rules.
     *
     * Rules can include:
     *  - required
     *  - email
     *  - min:<length>
     *  - max:<length>
     *  - json
     *
     * @param array      $rules  Validation rules (field => rules string).
     * @param array|null $data   Input data. Defaults to JSON from php://input.
     *
     * @return array Sanitized input data if validation passes.
     */
    public static function validate(array $rules, array $data = null)
    {
        try {
            $data = $data ?? json_decode(file_get_contents("php://input"), true);

            if (!is_array($data)) {
                Response::error(400, 'Invalid request payload. Expected JSON object.');
            }

            $errors = [];

            foreach ($rules as $field => $fieldRules) {
                $value = $data[$field] ?? null;

                foreach (explode('|', $fieldRules) as $rule) {
                    // Required field
                    if ($rule === 'required' && is_null($value)) {
                        $errors[$field][] = 'is required';
                        continue;
                    }

                    // Skip further checks if value is null (and not required)
                    if (is_null($value)) {
                        continue;
                    }

                    // Email format
                    if ($rule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $errors[$field][] = 'must be a valid email';
                    }

                    // Minimum length
                    if (str_starts_with($rule, 'min:')) {
                        $min = (int) explode(':', $rule)[1];
                        if (mb_strlen((string) $value) < $min) {
                            $errors[$field][] = "must be at least $min characters";
                        }
                    }

                    // Maximum length
                    if (str_starts_with($rule, 'max:')) {
                        $max = (int) explode(':', $rule)[1];
                        if (mb_strlen((string) $value) > $max) {
                            $errors[$field][] = "must not exceed $max characters";
                        }
                    }

                    // JSON validation
                    if ($rule === 'json' && is_string($value)) {
                        json_decode($value, true);
                        if (json_last_error() !== JSON_ERROR_NONE) {
                            $errors[$field][] = 'must be a valid JSON string';
                        }
                    }
                }
            }

            if (!empty($errors)) {
                Response::error(422, 'Validation failed', $errors);
            }

            return $data;
        } catch (\Throwable $e) {
            Response::error(500, 'Internal validation error occurred.');
        }
    }

    /**
     * Sanitize input data by trimming and escaping strings.
     *
     * @param array $data Input data.
     * @return array Sanitized data.
     */
    public static function sanitize(array $data): array
    {
        $clean = [];

        foreach ($data as $key => $value) {
            $clean[$key] = is_string($value)
                ? htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8')
                : $value;
        }

        return $clean;
    }

    /**
     * Validate and parse an ID.
     * Only allows alphanumeric, dash (-), and underscore (_).
     *
     * @param string $id
     * @return string
     */
    public static function parseId(string $id): string
    {
        if (!preg_match('/^[a-zA-Z0-9\-_]+$/', $id)) {
            Response::error(400, "Invalid ID format.");
        }

        return $id;
    }

    /**
     * Validate and parse a URL.
     * Only supports http and https schemes.
     *
     * @param string $url
     * @return string
     */
    public static function parseUrl(string $url): string
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            Response::error(400, "Invalid URL format.");
        }

        $parsed = parse_url($url);
        $scheme = strtolower($parsed['scheme'] ?? '');

        $allowedSchemes = ['http', 'https'];
        if (!in_array($scheme, $allowedSchemes, true)) {
            Response::error(400, "Unsupported URL scheme. Only http/https allowed.");
        }

        return $url;
    }
}
