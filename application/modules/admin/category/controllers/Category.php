<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Category extends MY_Controller {
    public function __construct()
    {
        parent::__construct();
    }
    public function index() {
        $data['page'] = 'catagory';
        $data['mainpage'] = '';
        $data['page_title'] = 'Add Category';
        $data['cs']=120;
        $this->template->page_maker('category/home',$data);
    }
    public function GetAllCatagory() {
        $this->load->model('catagoryModel');
        echo $this->catagoryModel->GetAllCatagory();
    }
    public function GetAllCatagoryDT() {
        $this->load->model('catagoryModel');
        echo $this->catagoryModel->GetAllCatagoryDT();

    }
    public function GetCatagoryById() {
        $this->load->model('catagoryModel');
        echo $this->catagoryModel->GetCatagoryById($this->input->post('pcid'));
    }
    public function AddCatagory() {
        $dataToSave['product_catogory_name'] = $this->input->post('catagoryName');
        $dataToSave['display_status'] = $this->input->post('displayStatus');

        if (isset($_FILES['uploaded_file']) && is_uploaded_file($_FILES['uploaded_file']['tmp_name']))
             {
               $directory='./assets/category_icons/';
               $config['upload_path']          = $directory;
               $config['allowed_types']        = 'png';
               $config['max_size']             = 4000;
               $image_info = getimagesize($_FILES["uploaded_file"]["tmp_name"]);
               $image_width = $image_info[0];
               $image_height = $image_info[1];
               if(($image_width=="256" && $image_height=="256"))
               {
                 $name=rand(10000,1000000);
                 $name=md5($name);
                 $config['file_name'] =$name;
                 $this->load->library('upload', $config);
                 $this->upload->initialize($config);
                 $uplod_file=$this->upload->do_upload('uploaded_file');
                 if (!$uplod_file)
                  {
                    $error = array('error' => $this->upload->display_errors());
                    $error=implode(',',$error);
                    echo $error;
                  }else{
                    $upload_data = $this->upload->data();
                    $file_name = $upload_data['file_name'];
                    $uploadedfile=$directory."/".$file_name;
                    $dataToSave['icon'] =$uploadedfile;
                    $this->load->model('catagoryModel');

                    echo $this->catagoryModel->AddCatagory($dataToSave);
                  }
               }
               else{
                 echo "Please check your image's width and height";
               }
             }
             else{
               echo "Must select a image";
             }
             return false;


    }

    public function UpdateCatagory() {

        $dataToUpdate['product_catogory_name'] = $this->input->post('catagoryName');
        $dataToUpdate['display_status'] = $this->input->post('displayStatus');
        if (isset($_FILES['uploaded_file']) && is_uploaded_file($_FILES['uploaded_file']['tmp_name']))
             {

                 $directory='./assets/category_icons/';
                 $config['upload_path']          = $directory;
                 $config['allowed_types']        = 'png';
                 $config['max_size']             = 4000;
                 $image_info = getimagesize($_FILES["uploaded_file"]["tmp_name"]);
                 $image_width = $image_info[0];
                 $image_height = $image_info[1];
                 if(($image_width=="256" && $image_height=="256"))
                 {
                   $name=rand(10000,1000000);
                   $name=md5($name);
                   $config['file_name'] =$name;
                   $this->load->library('upload', $config);
                   $this->upload->initialize($config);
                   $uplod_file=$this->upload->do_upload('uploaded_file');
                   if (!$uplod_file)
                    {
                      $error = array('error' => $this->upload->display_errors());
                      $error=implode(',',$error);
                      echo $error;
                    }else{
                      $upload_data = $this->upload->data();
                      $file_name = $upload_data['file_name'];
                      $uploadedfile=$directory."/".$file_name;
                      $dataToUpdate['icon'] =$uploadedfile;
                    }
                 }
                 else{
                   echo "Please check your image's width and height";
                   exit;
                 }
             }
        $this->load->model('catagoryModel');
        echo $this->catagoryModel->UpdateCatagory($dataToUpdate, $this->input->post('hidscid'));
    }

    public function DeleteCatagory() {

        $this->load->model('catagoryModel');
        echo $this->catagoryModel->DeleteCatagory($this->input->post('pcid'));
    }

    public function logout() {
        $user_data = $this->session->all_userdata();
        foreach ($user_data as $key => $value)
            $this->session->unset_userdata($key);
        $this->session->sess_destroy();
        $url=admin_url();
        $url.="home";
        redirect($url);

    }
}
