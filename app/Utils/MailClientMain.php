<?php

namespace App\Utils;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailClientMain
{
    /**
     * Send an email using SMTP
     *
     * @param string $toEmail Recipient email address
     * @param string $subject Email subject
     * @param string $templatePath Path to HTML template
     * @param array $templateData Associative array for template placeholders
     * @param string $toName Recipient name (optional)
     * @param bool $isHtml Whether email is HTML (default: true)
     * @return bool
     */
    public static function sendMail(
        string $toEmail,
        string $subject,
        string $templatePath,
        array $templateData = [],
        string $toName = '',
        bool $isHtml = true
    ): bool {
        $mail = new PHPMailer(true);

        try {
            // Load SMTP settings from environment variables
            $smtpHost = getenv('SMTP_HOST');
            $smtpPort = getenv('SMTP_PORT') ?: 587;
            $smtpUser = getenv('SMTP_USERNAME');
            $smtpPass = getenv('SMTP_PASSWORD');
            $smtpSecure = getenv('SMTP_SECURE') ?: 'tls'; // tls or ssl

            $fromEmail = getenv('EMAIL_ADDRESS');
            $fromName  = BRAND_NAME;

            if (!$smtpHost || !$fromEmail) {
                Utility::log('SMTP host or sender email not configured.', 'error', 'Mailer::sendMail');
                throw new \Exception('SMTP host or sender email not configured.');
            }

            // SMTP configuration
            $mail->isSMTP();
            $mail->Host       = $smtpHost;
            $mail->Port       = $smtpPort;
            $mail->SMTPAuth   = !empty($smtpUser);
            $mail->Username   = $smtpUser;
            $mail->Password   = $smtpPass;
            $mail->SMTPSecure = $smtpSecure;

            // Email headers
            $mail->setFrom($fromEmail, $fromName);
            $mail->addAddress($toEmail, $toName ?: $toEmail);
            $mail->isHTML($isHtml);
            $mail->Subject = $subject;

            // Load and parse HTML template
            if (!file_exists($templatePath)) {
                Utility::log('Email template not found.', 'error', 'Mailer::sendMail');
                throw new \Exception("Email template not found: $templatePath");
            }

            $template = file_get_contents($templatePath);
            $body = str_replace(array_keys($templateData), array_values($templateData), $template);
            $mail->Body = $body;

            // Optional: add a plain text fallback
            if ($isHtml) {
                $mail->AltBody = strip_tags($body);
            }

            $mail->send();
            return true;
        } catch (\Throwable $e) {
            // Log errors (you can replace with your logging system)
            error_log('Mailer error: ' . $e->getMessage());
            return false;
        }
    }
}
