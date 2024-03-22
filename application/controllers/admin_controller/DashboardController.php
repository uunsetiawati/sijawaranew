<?php

defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(error_reporting() & ~E_DEPRECATED & ~E_USER_DEPRECATED);
class DashboardController extends InstructorMiddleware {
    public $session_data;
    function __construct()
    {
        parent::__construct();
        $this->load->model('Dashboard');
        $this->session_data = $this->session->userdata();
        // error_reporting(0);
    }

    public function index()
    {
        $data['title'] = "Dashboard";

        if ($this->session_data['ID_ROLE'] == 1) {
            $data['TOT_REVENUE'] = $this->Dashboard->total_revenue();
            $data['TOT_COURSE'] = $this->Dashboard->count_course();
            $data['TOT_EVENT'] = $this->Dashboard->count_event();
            $data['TOT_USER'] = $this->Dashboard->count_user();
        }else {
            $data['TOT_REVENUE'] = $this->Dashboard->total_revenue_in($this->session_data['ID_USER']);
            $data['TOT_COURSE'] = $this->Dashboard->count_course_in($this->session_data['ID_USER']);
            $data['TOT_EVENT'] = $this->Dashboard->count_event_in($this->session_data['ID_USER']);
        }
        

        $this->load->view('admin/template/v_header', $data);
        $this->load->view('admin/dashboard/v_dashboard');
        $this->load->view('admin/template/v_footer');
    }

    public function get_chart_revenue()
    {
        $raw_all_year_trans = $this->Dashboard->get_year_trans();
        $data = array();
        foreach($raw_all_year_trans as $main_item){
            $raw_data_revenue = $this->Dashboard->total_revenue_per_month($main_item['YEAR']);
            $revenue_month = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            foreach($raw_data_revenue as $item){
                $revenue_month[($item['MONTH'] - 1)] = (!empty(($item['TOTAL'])) ? (int)$item['TOTAL'] : 0);
            }
            array_push(
                $data,
                array(
                    'YEAR' => $main_item['YEAR'],
                    'REVENUE' => $revenue_month
                )
            );
        }
        echo json_encode($data);
    }
}
