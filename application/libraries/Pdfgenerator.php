<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// panggil autoload dompdf nya
require 'vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;
class Pdfgenerator {
    public function generate($html, $filename='', $paper = '', $orientation = '', $stream=TRUE)
    {   
        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();
        $dompdf->setHttpContext(
            stream_context_create([
                'ssl' => [
                    'allow_self_signed'=> TRUE,
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                ]
            ])
        );
        if ($stream) {
            return $dompdf->output();
        }
    }
}