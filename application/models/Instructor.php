<?php
class Instructor extends CI_Model
{
    public function get_all_instructor()
    {
        $query = $this->db->query("
            SELECT 
                u.NAME ,
                ud.* ,
                ir.STATUS 
            FROM 
                instructor_req ir 
            LEFT JOIN user_data ud ON
                ud.ID_USER = ir.ID_USER 
            LEFT JOIN `user` u ON 
                u.ID_USER = ir.ID_USER
            ORDER BY
                ir.STATUS ASC
        ");
        return $query->result_array();
    }

    public function request_instructor($data, $id_user)
    {
        $req = $this->db->get_where('instructor_req', ['ID_USER' => $id_user])->result_array();
        if (!empty($req)) {
            $this->db->where('instructor_req.ID_USER', $id_user);
            $this->db->update('instructor_req', $data);
        } else {
            $this->db->insert('instructor_req', $data);
        }
        return $this->db->affected_rows();
    }

    public function accept($id_user)
    {
        $this->db->where('ID_USER', $id_user);
        $this->db->update('instructor_req', ['STATUS' => 1]);
        
        $this->db->where('ID_USER', $id_user);
        $this->db->update('user', ['ID_ROLE' => 2]);

        return $this->db->affected_rows();
        
    }
    
    public function reject($id_user)
    {
        $this->db->where('ID_USER', $id_user);
        $this->db->update('instructor_req', ['STATUS' => 2]);
        
        $this->db->where('ID_USER', $id_user);
        $this->db->update('user', ['ID_ROLE' => 3]);

        return $this->db->affected_rows();
        
    }

    public function UpdateActivity($data, $id_activity)
    {
        $this->db->where('ID_ACTIVITY', $id_activity);
        $this->db->update('activity', $data);
        return $this->db->query("SET foreign_key_checks = 1;");
    }
}
