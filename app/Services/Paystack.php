<?php


namespace App\Services;
use App\Utils\Response;

class Paystack
{

    public static function PaystackVerify($data)
    {
        $ref = $data['transaction_id'] ?? null;

        if ($ref) {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.paystack.co/transaction/verify/{$ref}",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer sk_test_xxxxxxx",
                    "Cache-Control: no-cache"
                ],
            ]);
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            if ($err || !$response) {
                Response::error(500, "Payment verification failed");
                exit;
            }

            $data = json_decode($response, true);
            if (!$data['status'] || $data['data']['status'] !== 'success') {
                return false;
            }

            $payment_verified = true;
        }
    }
}
