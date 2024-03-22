<?php

class Dashboard extends CI_Model
{
    public function total_revenue()
    {
        $this->db->select("SUM(transaction.TOT_BAYAR) AS TOTAL");
        return $this->db->get('transaction')->row_array();
    }

    public function total_revenue_in($id)
    {
        $this->db->select("SUM(transaction.TOT_BAYAR) AS TOTAL");
        $this->db->where('transaction.ID_USER', $id);
        return $this->db->get('transaction')->row_array();
    }

    public function count_course()
    {
        $this->db->select("COUNT(activity.ID_ACTIVITY) AS TOTAL");
        $this->db->where('activity.TYPE_ACTIVITY', 1);
        return $this->db->get('activity')->row_array();
    }

    public function count_course_in($id)
    {
        $this->db->select("COUNT(activity.ID_ACTIVITY) AS TOTAL");
        $this->db->where(['activity.TYPE_ACTIVITY'=> 1, 'activity.ID_USER'=> $id]);
        return $this->db->get('activity')->row_array();
    }

    public function count_event()
    {
        $this->db->select("COUNT(activity.ID_ACTIVITY) AS TOTAL");
        return $this->db->get('activity')->row_array();
    }
    
    public function count_event_in($id)
    {
        $this->db->select("COUNT(activity.ID_ACTIVITY) AS TOTAL");
        $this->db->where('activity.ID_USER', $id);
        return $this->db->get('activity')->row_array();
    }

    public function count_user()
    {
        $this->db->select("COUNT(user.ID_USER) AS TOTAL");
        return $this->db->get('user')->row_array();
    }

    public function get_year_trans()
    {
        $sql = $this->db->query("
            SELECT
                YEAR(t.LOG_TIME) AS 'YEAR'
            FROM
                `transaction` t
            GROUP BY
                YEAR(t.LOG_TIME)
        ");
        return $sql->result_array();
    }

    public function total_revenue_per_month($year)
    {
        $sql = $this->db->query("
            SELECT
                MONTH(t.LOG_TIME) AS 'MONTH',
                YEAR(t.LOG_TIME) AS 'YEAR',
                SUM(t.TOT_BAYAR) AS 'TOTAL'
            FROM
                `transaction` t
            WHERE
                YEAR(t.LOG_TIME) = $year
            GROUP BY
                YEAR(t.LOG_TIME),
                MONTH(t.LOG_TIME)
        ");
        return $sql->result_array();
    }
}
