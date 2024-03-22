<?php

class Certificate extends CI_Model
{
    public function getCertificate($con)
    {
        $this->db->where($con);
        return $this->db->get('sertifikat_activity')->row_array();
    }
    public function createCertificate($data)
    {
        $this->db->insert('sertifikat_activity', $data);
        return $this->db->affected_rows();
    }

    public function generate($namaUser, $activity_name, $sertificate_no)
    {
        $this->load->library('S3Upload', NULL, 'S3');
        $this->load->library('pdfgenerator');
        $file_pdf = strtoupper($namaUser . "_CERTIFICATE_" . $activity_name) . ".pdf";

        $paper = 'A4';
        $orientation = 'landscape';

        $path = base_url('assets/images/certificate_template.jpg');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $getImage = file_get_contents($path);
        $data['IMAGE'] = 'data:image/' . $type . ';base64,' . base64_encode($getImage);

        $data['NO_SERTIF'] = $sertificate_no;
        $data['NAME'] = $namaUser;
        $data['ACTIVITY'] = $activity_name;
        $data['TYPE'] = explode("/", $sertificate_no)[1];

        $html = $this->load->view("pdf_template/sertifikat", $data, true);

        $resPdf = $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);

        $new_path = $this->S3->UploadFileBlob($file_pdf, $resPdf, 'certificate');

        return $new_path;
    }
}
