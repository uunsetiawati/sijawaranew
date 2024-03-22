<?php

class Category extends CI_Model
{
    public function getCategory($id_kategori = null)
    {
        if ($id_kategori === null) {
            return $this->db->get('kategori')->result_array();
        } else {
            return $this->db->get_where('kategori', ['id_kategori' => $id_kategori])->result_array();
        }
    }

    public function get_all_category()
    {
        return $this->db->get('kategori')->result_array();
    }

    public function deleteCategory($id_kategori)
    {
        $this->db->delete('kategori', ['id_kategori' => $id_kategori]);
        return $this->db->affected_rows();
    }

    public function createCategory($data)
    {
        $this->db->insert('kategori', $data);
        return $this->db->affected_rows();
    }

    public function updateCategory($data, $id_kategori)
    {
        $this->db->update('kategori', $data, ['id_kategori' => $id_kategori]);
        return $this->db->affected_rows();
    }
}
