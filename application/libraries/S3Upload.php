<?php

defined('BASEPATH') or exit('No direct script access allowed');

require 'vendor/autoload.php';

use Aws\S3\S3Client;

class S3Upload
{
    public function UploadImage($Image)
    {
        if (isset($Image)) {
            $file_name = $Image['name'];
            $new_name = time() . '_' . $file_name;

            $client = S3Client::factory([
                'version' => 'latest',
                'region'  => 'id-jkt-1-default',
                'endpoint' => 'https://is3.cloudhost.id/',
                'credentials' => [
                    'key'    => "7WAT9UY96UHTANQU11XH",
                    'secret' => "BV7Brbcktxy561KWW5Syuf0kBGasK2CCwV6cefMo"
                ]
            ]);

            $client->putObject([
                'Bucket'        => 'tbh-v2',
                'Key'           => 'images/' . $new_name,
                'SourceFile'    => $Image['tmp_name'],
                'ContentType'   => $Image['type'],
                'ACL'           => 'public-read',
            ]);
            return "https://is3.cloudhost.id/tbh-v2/images/" . $new_name;
        } else {
            return "No Image";
        }
    }

    public function uploadFile($files_name, $file_tmp, $type, $folder)
    {
        if (isset($files_name, $file_tmp)) {
            $new_name = time() . '_' . $files_name;

            $client = S3Client::factory([
                'version'     => 'latest',
                'region'      => 'id-jkt-1-default',
                'endpoint'    => 'https://is3.cloudhost.id/',
                'credentials' => [
                    'key'    => "7WAT9UY96UHTANQU11XH",
                    'secret' => "BV7Brbcktxy561KWW5Syuf0kBGasK2CCwV6cefMo"
                ]
            ]);

            try {
                $client->putObject([
                    'Bucket'      => 'tbh-v2',
                    'Key'         => $folder . '/' . $new_name,
                    'SourceFile'  => $file_tmp,
                    'ContentType' => $type,
                    'ACL'         => 'public-read',
                ]);

                return "https://is3.cloudhost.id/tbh-v2/{$folder}/{$new_name}";
            } catch (Exception $e) {
                return "Error uploading file: " . $e->getMessage();
            }
        }
        return "Invalid input parameters.";
    }

    public function UploadFileBlob($files_name, $file_tmp, $folder)
    {
        if (isset($files_name) && isset($file_tmp)) {
            $new_name = time() . '_' . $files_name;

            $client = S3Client::factory([
                'version' => 'latest',
                'region'  => 'id-jkt-1-default',
                'endpoint' => 'https://is3.cloudhost.id/',
                'credentials' => [
                    'key'    => "7WAT9UY96UHTANQU11XH",
                    'secret' => "BV7Brbcktxy561KWW5Syuf0kBGasK2CCwV6cefMo"
                ]
            ]);
            try {
                $client->putObject([
                    'Bucket'        => 'tbh-v2',
                    'Key'           => $folder . '/' . $new_name,
                    'Body'          => $file_tmp,
                    'ContentType'   => 'application/pdf',
                    'ACL'           => 'public-read',
                ]);

                return "https://is3.cloudhost.id/tbh-v2/{$folder}/{$new_name}";
            } catch (Exception $e) {
                return "Error uploading file: " . $e->getMessage();
            }
        }
    }
}
