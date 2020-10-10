<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Districts extends MY_Controller {
        public function __construct()
        {
            parent::__construct();
        }

        public function index()
        {
            $data['page'] = 'districts';
            $data['mainpage'] = '';
            $data['page_title'] = 'Districts';
            $data['cs']=120;
            $this->template->page_maker('districts/home',$data);
        }

        public function GetDistrictsByStateID()
        {
            $stateID = $this->input->post('stateID');
            $this->load->model('DistrictsModel');
            echo $this->DistrictsModel->GetDistrictsByStateID($stateID);
        }

        public function logout()
        {
            $user_data = $this->session->all_userdata();
            foreach ($user_data as $key => $value)
                $this->session->unset_userdata($key);
            $this->session->sess_destroy();
            $url=admin_url();
            $url.="home";
            redirect($url);

        }
    }