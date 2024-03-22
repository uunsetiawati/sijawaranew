<?php

class Checkout extends CI_Model
{
    public function get_all_order($id_user)
    {
        $this->db->select('order.*, activity.TITLE_ACTIVITY, activity.IMAGE_ACTIVITY, ebook.JUDUL, ebook.IMAGE_EBOOK');
        $this->db->join('activity', 'activity.ID_ACTIVITY = order.ID_PRODUCT', 'left');
        $this->db->join('ebook', 'ebook.ID_BUKU = order.ID_PRODUCT', 'left');
        return $this->db->get_where('order', ['order.ID_USER' => $id_user, 'order.ID_PAY' => NULL])->result_array();
    }
    public function get_trans($id_user)
    {
        $sql = "
            SELECT 
                p.*,
                o.ID_ORDER ,
                o.ID_PRODUCT ,
                o.PRICE_ORDER ,
                a.IMAGE_ACTIVITY ,
                a.TITLE_ACTIVITY ,
                pm.STATUS,
                pm.ID_PAY_METHOD
            FROM 
                payment p
            LEFT JOIN `order` o ON 
                o.ID_PAY = p.ID_PAY 
            LEFT JOIN activity a ON 
                a.ID_ACTIVITY = o.ID_PRODUCT
            LEFT JOIN payment_method pm ON 
                pm.ID_PAY = p.ID_PAY 
            WHERE 
                pm.STATUS = 'pending'
                AND 
                p.KODE_USER = '$id_user'
        ";
        return $this->db->query($sql)->result_array();
    }
    public function get_detail_order($id_order, $id_activity)
    {
        $this->db->select('order.*, activity.TITLE_ACTIVITY, activity.IMAGE_ACTIVITY, ebook.JUDUL, ebook.IMAGE_EBOOK');
        $this->db->join('activity', 'activity.ID_ACTIVITY = order.ID_PRODUCT', 'left');
        $this->db->join('ebook', 'ebook.ID_BUKU = order.ID_PRODUCT', 'left');
        $this->db->where('order.ID_USER', (!empty($this->session->userdata('ID_USER'))) ? $this->session->userdata('ID_USER') : "");
        (!empty($id_order)) ? $this->db->where_in('order.ID_ORDER', $id_order) : "";
        (!empty($id_activity)) ? $this->db->where_in('order.ID_PRODUCT', $id_activity) : "";
        $query = $this->db->get('order');
        if ($query->num_rows() > 0) {
            return (!empty($id_activity)) ? $query->row_array() : $query->result_array();
        } else {
            return false;
        }
    }

    // INSERT FUNCTION
    public function insert_payment($data)
    {
        $this->db->insert('payment', $data);
    }
    public function insert_payment_method($data)
    {
        $this->db->insert('payment_method', $data);
    }
    public function insert_order($data)
    {
        $this->db->insert('order', $data);
    }
    public function insert_transaction($data)
    {
        $this->db->insert('transaction', $data);
    }
    public function insert_mapping($data)
    {
        $this->db->insert('mapping_course', $data);
    }

    // UPDATE FUNCTION
    public function update_payment_method($data, $id_pay_method)
    {
        $this->db->where('payment_method.ID_PAY_METHOD', $id_pay_method);
        $this->db->update('payment_method', $data);
    }
    public function update_payment($data, $id_pay)
    {
        $this->db->where('payment.ID_PAY', $id_pay);
        $this->db->update('payment', $data);
    }
    public function update_order($data, $id_activity, $id_user)
    {
        $this->db->where('order.ID_PRODUCT', $id_activity);
        $this->db->where('order.ID_USER', $id_user);
        $this->db->update('order', $data);
    }
    
    // DELETE FUNCTION
    public function delete_transaction($id_trans, $id_order)
    {
        $this->db->where('order.PRICE_ORDER <> 0');
        $this->db->where_in('order.ID_ORDER', $id_order);
        $this->db->update('order', ['ID_PAY' => NULL]);
        
        $this->db->where('payment_method.ID_PAY', $id_trans);
        $this->db->delete('payment_method');

        $this->db->where('payment.ID_PAY', $id_trans);
        $this->db->delete('payment');
    }
    public function delete_order($id_order)
    {
        $this->db->where('ID_ORDER', $id_order);
        $this->db->delete('order');
    }
}
