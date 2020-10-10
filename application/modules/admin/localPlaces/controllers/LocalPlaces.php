<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class LocalPlaces extends MY_Controller {
        public function __construct()
        {
            parent::__construct();
        }

        public function index()
        {
            $data['page'] = 'localPlaces';
            $data['mainpage'] = 'places';
            $data['page_title'] = 'Places';
            $data['cs']=120;
            $this->template->page_maker('localPlaces/home',$data);
        }

        public function SavePlace() {

            $dataToSave['PlaceName'] = $this->input->post('place');
            $dataToSave['DistrictID'] = $this->input->post('district');
            $dataToSave['DisplayStatus'] = $this->input->post('displayStatus');
            $dataToSave['pincode'] = $this->input->post('pincode');
            $dataToSave['delivery_fee'] = $this->input->post('delivery_fee');

            $hour=$this->input->post("hour");
            if($hour<10) $hour="0".$hour;
            $minutes=$this->input->post("minutes");
            if($minutes<10) $hour="0".$minutes;
            $dataToSave['expected_delivery_time']=$hour.":".$minutes.":00";
        //    print_r($dataToSave); exit;
            $this->load->model('LocalPlacesModel');
            echo $this->LocalPlacesModel->SavePlace($dataToSave);
        }

        public function UpdatePlace() {

            $placeID = $this->input->post('hidPlaceid');
            $dataToUpdate['PlaceName'] = $this->input->post('place');
            $dataToUpdate['DistrictID'] = $this->input->post('district');
            $dataToUpdate['DisplayStatus'] = $this->input->post('displayStatus');
            $dataToUpdate['pincode'] = $this->input->post('pincode');
            $dataToUpdate['delivery_fee'] = $this->input->post('delivery_fee');

            $hour=$this->input->post("hour");
            if($hour<10) $hour="0".$hour;
            $minutes=$this->input->post("minutes");
            if($minutes<10) $minutes="0".$minutes;
            $dataToUpdate['expected_delivery_time']=$hour.":".$minutes.":00";
            $this->load->model('LocalPlacesModel');
            echo $this->LocalPlacesModel->UpdatePlace($dataToUpdate, $placeID);
        }

        public function DeletePlace() {
            $placeID = $this->input->post('placeID');
            $this->load->model('LocalPlacesModel');
            echo $this->LocalPlacesModel->DeletePlace($placeID);
        }

        public function GetPlacesByDistrictID()
        {
            $districtID = $this->input->post('districtID');
            $this->load->model('LocalPlacesModel');
          //  echo $this->db->last_query(); exit;
            echo $this->LocalPlacesModel->GetPlacesByDistrictID($districtID);
        }

        public function GetAllPlaceById() {
            $placeID = $this->input->post('placeID');
            $this->load->model('LocalPlacesModel');
            echo $this->LocalPlacesModel->GetAllPlaceById($placeID);
        }

        public function GetAllDistricts()
        {
            $this->load->model('LocalPlacesModel');
            echo $this->LocalPlacesModel->GetAllDistricts();
        }
        public function GetAllDistrictsForDT()
        {
            $this->load->model('LocalPlacesModel');
            echo $this->LocalPlacesModel->GetAllDistrictsForDT();
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
