<?php


namespace App\Services;

use App\Utils\Response;

class Paystack
{



    public static function verifyPaystackPayment($reference)
    {


        $secretKey = "sk_test_0635b682702deeaa1d4ed2b29f5cf9647eb2a8c8";
        $url = "https://api.paystack.co/transaction/verify/" . rawurlencode($reference);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //Remove production

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . $secretKey,
            "Cache-Control: no-cache",
        ]);

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);



        if (curl_errno($ch)) {
            $error_msg = curl_error($ch); // capture error *before* closing
            curl_close($ch);
            return [
                "status" => false,
                "message" => "Curl error: " . $error_msg
            ];
        }

        curl_close($ch);

        if ($httpcode !== 200) {
            return [
                "status" => false,
                "message" => "HTTP error code: " . $httpcode,
                "response" => $response
            ];
        }

        $result = json_decode($response, true);



        if (!$result['status']) {
            return [
                "status" => false,
                "message" => $result['message'] ?? "Verification failed"
            ];
        }

        if (isset($result['data']['status']) && $result['data']['status'] === "success") {
            return [
                "status" => true,
                "data" => $result['data'] // includes amount, customer email, etc.
            ];
        } else {
            return [
                "status" => false,
                "message" => "Payment not successful",
                "data" => $result['data'] ?? []
            ];
        }
    }
}
