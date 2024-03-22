<?php

class Ebook extends CI_Model
{
    public function get_all_book()
    {
        $this->db->select('ebook.*');
        $this->db->select("(
            SELECT 
                COUNT(*)
            FROM
                payment p
            LEFT JOIN `order` o ON 
                o.ID_PAY  = p.ID_PAY 
            WHERE 
                o.ID_USER = '" . $this->session->userdata('ID_USER') . "'
                AND 
                o.ID_PRODUCT = `ebook`.ID_BUKU
                AND 
                p.DATE_PAY IS NOT NULL ) as DATA_CHECKING");
        return $this->db->get('ebook')->result_array();
    }

    public function get_all_book_in($id)
    {
        $this->db->select('ebook.*');
        $this->db->select("(
            SELECT 
                COUNT(*)
            FROM
                payment p
            LEFT JOIN `order` o ON 
                o.ID_PAY  = p.ID_PAY 
            WHERE 
                o.ID_USER = '" . $this->session->userdata('ID_USER') . "'
                AND 
                `order`.ID_PRODUCT = `ebook`.ID_BUKU
                AND 
                p.DATE_PAY IS NOT NULL ) as DATA_CHECKING");
        $this->db->where('ebook.ID_USER', $id);
        return $this->db->get('ebook')->result_array();
    }

    public function get_book($id_book)
    {
        if (!empty($this->session->userdata('ID_USER'))) {
            $this->db->select("(
                SELECT 
                    COUNT(*)
                FROM
                    payment p
                LEFT JOIN `order` o ON 
                    o.ID_PAY  = p.ID_PAY 
                WHERE 
                    o.ID_USER = '" . $this->session->userdata('ID_USER') . "'
                    AND 
                    `order`.ID_PRODUCT = `activity`.ID_ACTIVITY
                    AND 
                    p.DATE_PAY IS NOT NULL ) as DATA_CHECKING");
            return $this->db->get_where('activity', ['activity.TYPE_ACTIVITY' => 2, 'activity.ID_ACTIVITY' => $id_book])->row_array();
        } else {

            return $this->db->get_where('activity', ['activity.TYPE_ACTIVITY' => 2, 'activity.ID_ACTIVITY' => $id_book])->row_array();
        }
    }

    public function get_book_by_id($id)
    {
        $this->db->where('ID_BUKU', $id);
        return $this->db->get('ebook')->row_array();
    }

    public function InsertEbook($data)
    {
        $this->db->insert('ebook', $data);
        return $this->db->affected_rows();
    }

    public function UpdateEbook($data, $id_buku)
    {
        $this->db->where('ID_BUKU', $id_buku);
        $this->db->update('ebook', $data);
        return $this->db->query("SET foreign_key_checks = 1;");
    }

    public function DeleteEbook($id_buku)
    {
        $this->db->where('ID_BUKU', $id_buku);
        $this->db->delete('ebook');
        return $this->db->query("SET foreign_key_checks = 1;");
    }
}
