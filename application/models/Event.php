<?php

class Event extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->db->query("SET foreign_key_checks = 0;");
    }
    public function get_home_event()
    {
        $this->db->limit(3);
        $this->db->order_by('activity.LOG_TIME', 'desc');
        return $this->db->get_where('activity', ['TYPE_ACTIVITY' => 2])->result_array();
    }
    public function get_all_event()
    {
        return $this->db->get_where('activity', ['TYPE_ACTIVITY' => 2])->result_array();
    }
    public function get_all_event_in($id)
    {
        return $this->db->get_where('activity', ['TYPE_ACTIVITY' => 2, 'ID_USER' => $id])->result_array();
    }
    public function get_event_by_id($keyword, $type)
    {
        if (!empty($keyword)) {
            $this->db->like('TITLE_ACTIVITY', $keyword);
        }
        $this->db->where('TYPE_ACTIVITY', $type);
        return $this->db->get('activity')->result_array();
    }
    public function get_event_pagination($start = "", $limit = "")
    {
        $this->db->select('activity.*');
        $this->db->select("(
            DATEDIFF('" . date('Y-m-d') . "', `activity`.DATE_START) >= 1
        ) as EXPIRED"); 
        $this->db->limit($start, $limit);
        return $this->db->get_where('activity', ['TYPE_ACTIVITY' => 2])->result_array();
    }
    public function get_other_event($id_activity)
    {
        $this->db->select('activity.*');
        $this->db->select("(
            DATEDIFF('" . date('Y-m-d') . "', `activity`.DATE_START) >= 1
        ) as EXPIRED"); 
        $this->db->where('activity.ID_ACTIVITY <>', $id_activity);
        $this->db->limit(6);
        $this->db->order_by('activity.DATE_START', 'desc');
        return $this->db->get_where('activity', ['TYPE_ACTIVITY' => 2])->result_array();
    }
    public function get_event($id_activity)
    {
        if (!empty($this->session->userdata('ID_USER'))) {
            $this->db->select('activity.*, event.ID_EVENT, event.CATEGORY_EVENT, event.LOCATION, event.ORGANIZER, event.CONTACT_CUSTOMER');
            $this->db->select('event.DESKRIPSI_EVENT, event.LINK_ZOOM');
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
                    p.DATE_PAY IS NOT NULL ) as DATA_CHECKING,
                (
                    DATEDIFF('" . date('Y-m-d') . "', `activity`.DATE_START) >= 1
                ) as EXPIRED");
            $this->db->join('event', 'event.ID_ACTIVITY = activity.ID_ACTIVITY', 'LEFT OUTER');
            return $this->db->get_where('activity', ['activity.TYPE_ACTIVITY' => 2, 'activity.ID_ACTIVITY' => $id_activity])->row_array();
        } else {
            $this->db->select('activity.*, event.ID_EVENT, event.CATEGORY_EVENT, event.LOCATION, event.ORGANIZER, event.CONTACT_CUSTOMER');
            $this->db->select('event.DESKRIPSI_EVENT, event.LINK_ZOOM');
            $this->db->select("(
                DATEDIFF('" . date('Y-m-d') . "', `activity`.DATE_START) >= 1
            ) as EXPIRED");            
            $this->db->join('event', 'event.ID_ACTIVITY = activity.ID_ACTIVITY', 'LEFT OUTER');
            return $this->db->get_where('activity', ['activity.TYPE_ACTIVITY' => 2, 'activity.ID_ACTIVITY' => $id_activity])->row_array();
        }
    }
    public function InsertActivity($data)
    {
        $this->db->insert('activity', $data);
        return $this->db->affected_rows();
    }
    public function InsertEvent($data)
    {
        $this->db->insert('event', $data);
        return $this->db->affected_rows();
    }
    public function UpdateActivity($data, $id_activity)
    {
        $this->db->where('ID_ACTIVITY', $id_activity);
        $this->db->update('activity', $data);
        return $this->db->query("SET foreign_key_checks = 1;");
    }
    public function UpdateEvent($data, $id_activity)
    {
        $this->db->where('ID_ACTIVITY', $id_activity);
        $this->db->update('event', $data);
        return $this->db->query("SET foreign_key_checks = 1;");
    }
    public function DeleteActivity($id_activity)
    {
        $this->db->where('ID_ACTIVITY', $id_activity);
        $this->db->delete('activity');
        return $this->db->query("SET foreign_key_checks = 1;");
    }
    public function DeleteEvent($id_activity)
    {
        $this->db->where('ID_ACTIVITY', $id_activity);
        $this->db->delete('event');
        return $this->db->query("SET foreign_key_checks = 1;");
    }
}
