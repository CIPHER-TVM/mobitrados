<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class States extends MY_Controller 
    {
        public function __construct()
        {
            parent::__construct();
        }

        public function index()
        {
            $data['page'] = 'states';
            $data['mainpage'] = '';
            $data['page_title'] = 'States';
            $data['cs']=120;
            $this->template->page_maker('states/home',$data);
        }

        public function GetAllStates()
        {
            $this->load->model('StatesModel');
            echo $this->StatesModel->GetAllStates();
        }
        public function GetAllStatesForDataTables()
        {
            $this->load->model('StatesModel');
            echo $this->StatesModel->GetAllStatesForDataTables();
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
?>