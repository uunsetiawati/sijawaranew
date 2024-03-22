<?php

class Promo extends CI_Model
{
    public function get_all_promo()
    {
        return $this->db->get_where('promo')->result_array();
    }

    public function InsertPromo($data)
    {
        $this->db->insert('promo', $data);
        return $this->db->affected_rows();
    }

    public function UpdatePromo($data, $id_promo)
    {
        $this->db->update('promo', $data, ['ID_PROMO' => $id_promo]);
        return $this->db->affected_rows();
    }

    public function DeletePromo($id_promo)
    {
        $this->db->delete('promo', ['ID_PROMO' => $id_promo]);
        return $this->db->affected_rows();
    }

    public function getPromo($id_user)
    {
        $this->db->select('promo.ID_PROMO, promo.PROMO_NAME, promo.AMMOUNT, promo.EXP_DATE');
        $this->db->join('promo', 'promo.ID_PROMO = claimed_promo.ID_PROMO', 'left');        
        return $this->db->get_where('claimed_promo', ['ID_USER' => $id_user, 'claimed_promo.STATUS' => 0])->result_array();
    }
    
    public function getPromoById($id_promo)
    {
        $this->db->select('promo.ID_PROMO, promo.PROMO_NAME, promo.AMMOUNT, promo.EXP_DATE');
        $this->db->join('promo', 'promo.ID_PROMO = claimed_promo.ID_PROMO', 'left');        
        return $this->db->get_where('claimed_promo', ['claimed_promo.ID_PROMO' => $id_promo])->row_array();
    }

    public function usePromo($id_promo)
    {
        $this->db->where('claimed_promo.ID_PROMO', $id_promo);
        $this->db->where('claimed_promo.ID_USER', $this->session->userdata('ID_USER'));
        $this->db->update('claimed_promo', ['claimed_promo.STATUS' => 1]);
    }
}
