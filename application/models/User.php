<?php

class User extends CI_Model
{
    public function get_all_user()
    {
        return $this->db->get_where('user', ['IS_DELETE' => 0])->result_array();
    }

    public function hapus_user($id)
    {
        $this->db->query("SET foreign_key_checks = 0;");
        $this->db->where('ID_USER', $id);
        $this->db->update('user', ['IS_DELETE' => 1]);
        return $this->db->query("SET foreign_key_checks = 1;");
    }

    public function update_user($data, $id_user)
    {
        $this->db->query("SET foreign_key_checks = 0;");
        $this->db->where('ID_USER', $id_user);
        $this->db->update('user', $data);
        return $this->db->query("SET foreign_key_checks = 1;");
    }

    public function user_ini($id_user)
    {
        return $this->db->get_where('user', ['ID_USER' => $id_user])->row_array();
    }
}
