<?php

class Profile extends CI_Model
{
    public function get_detail_user($id_user)
    {
        $this->db->where('user.ID_USER', $id_user);
        return $this->db->get('user')->row_array();
    }

    public function get_my_product($condition)
    {
        $this->db->select('activity.*, kategori.KATEGORI, course.DESKRIPSI_COURSE');
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
                o.ID_PRODUCT = `activity`.ID_ACTIVITY
                AND 
                p.DATE_PAY IS NOT NULL ) as DATA_CHECKING");
        $this->db->select("( CEIL((
            SELECT
                COUNT(*)
            FROM
                `mapping_course`
            WHERE
                `mapping_course`.ID_USER = '" . $this->session->userdata('ID_USER') . "'
                AND `mapping_course`.ID_ACTIVITY = `activity`.ID_ACTIVITY
                AND `mapping_course`.STATUS = 1) /
            (
            SELECT
                COUNT(*)
            FROM
                `mapping_course`
            WHERE
                `mapping_course`.ID_USER = '" . $this->session->userdata('ID_USER') . "'
                AND `mapping_course`.ID_ACTIVITY = `activity`.ID_ACTIVITY) * 100)) as PROGRESS");
        $this->db->join('course', 'course.ID_ACTIVITY = activity.ID_ACTIVITY', 'left');
        $this->db->join('kategori', 'kategori.ID_KATEGORI = course.KATEGORI', 'left');
        return $this->db->get_where('activity', $condition)->result_array();     
    }
    
    public function get_user_academic($id)
    {
        $this->db->select('user_data.*, instructor_req.STATUS');
        $this->db->join('instructor_req', 'instructor_req.ID_USER = user_data.ID_USER', 'left');
        $this->db->where('user_data.ID_USER', $id);
        return $this->db->get('user_data')->row_array();
    }

    public function update_user($data, $id_user)
    {
        $this->db->query("SET foreign_key_checks = 0;");

        $this->db->where('ID_USER', $id_user);
        $this->db->update('user', $data);
        
        $this->db->query("SET foreign_key_checks = 1;");
        return $this->db->affected_rows();
    }

    public function update_user_academic($id, $param)
    {
        $user = $this->get_user_academic($id);
        if (empty($user)) {
            $this->db->insert('user_data', $param);
        }else{
            $this->db->where('user_data.ID_USER', $id);
            $this->db->update('user_data', $param);
        }
        return $this->db->affected_rows();
    }
}
