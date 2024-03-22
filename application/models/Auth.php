<?php

class Auth extends CI_Model
{
    public function get_user($condition)
    {
        return $this->db->get_where('user', $condition)->row();
    }
    public function get_token($key)
    {
        return $this->db->get_where('token', ['KEY' => $key])->row_array();
    }
    public function SaveToken($data)
    {
        $this->db->insert('token', $data);
    }
    public function UpdateToken($data)
    {
        $this->db->where('token.ID_USER', $data['ID_USER']);
        $this->db->where('token.TYPE', $data['TYPE']);
        $this->db->update('token', $data);
    }
    public function UpdatePass($data)
    {
        $this->db->where('user.ID_USER', $data['ID_USER']);
        $this->db->update('user', ['PASS' => $data['PASS']]);
    }
    public function UpdateStatus($token)
    {
        $userData = $this->get_token($token);

        $this->db->where('user.ID_USER', $userData['ID_USER']);
        $this->db->update('user', ['STATUS' => 1]);
    }
    public function cek_token($id_user, $type, $token)
    {
        $query = $this->db->query("
            SELECT * FROM token WHERE token.ID_USER = '$id_user' AND token.TYPE = $type AND token.STATUS = 0
        ");

        $data = array(
            'ID_USER' => $id_user,
            'KEY' => $token,
            'TYPE' => $type,
            'STATUS' => 0,
            'LOG_TIME' => date('Y-m-d H:i:s')
        );
        if ($query->num_rows() > 0) {
            $this->UpdateToken($data);
        } else {
            $this->SaveToken($data);
        }
        return TRUE;
    }
}
