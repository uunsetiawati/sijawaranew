<?php

defined('BASEPATH') or exit('No direct script access allowed');

require 'vendor/autoload.php';

class Phpmailer
{
    public function SendMail($email_to, $email_sender, $subject, $name, $html)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.sendinblue.com/v3/smtp/email');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt(
            $ch,
            CURLOPT_POSTFIELDS,
            json_encode([
                "sender" => [
                    "name" => "AdminTBH",
                    "email" => $email_sender
                ],
                "to" => [
                    [
                        "email" => $email_to,
                        "name" => $name
                    ]
                ],
                "subject" => $subject,
                "htmlContent" => $html
            ])
        );

        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Api-Key: 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';
        $headers[] = 'Content-Type: text/html';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $server_output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);

        return $httpcode;
    }
}
