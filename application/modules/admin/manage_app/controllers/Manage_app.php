<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Manage_app extends MY_Controller {

  public function __construct()
  {
    	parent::__construct();
      $this->load->model('Manage_app_m','app');
  }
  public function banner_upload()
  {
    $data['page'] = 'add_product';
    $data['mainpage'] = 'app_settings';
    $data['page_title'] = 'Banner Upload';
    $this->template->page_maker('manage_app/banner_upload',$data);
  }
  public function save_banner()
  {
    if (!$this->input->is_ajax_request()) { 	exit('No direct script access allowed');  }
     $createduser=$this->session->userdata('userid');
    $active=$this->input->post('display_status');
    if($active) $active=1; else $active=0;
    if (isset($_FILES['uploaded_file']) && is_uploaded_file($_FILES['uploaded_file']['tmp_name']))
         {
            $directory='./assets/banners/';
            $config['upload_path']          = $directory;
            $config['allowed_types']        = 'jpg|png|jpeg';
            $config['max_size']             = 6000;
            $image_info = getimagesize($_FILES["uploaded_file"]["tmp_name"]);
            $image_width = $image_info[0];
            $image_height = $image_info[1];
           if(($image_width=="1920" && $image_height=="720"))
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
              }
              else
              {
                $upload_data = $this->upload->data();
                $file_name = $upload_data['file_name'];
                $uploadedfile=$directory."/".$file_name;
                $data=array(
                  'image_path'=>$uploadedfile,
                  'display_status'=>$active,
                  'created_by'=>$createduser,
                  );
                   $ins=insertInDb("banner",$data);
                   if($ins) echo 1; else echo "Unable to upload , try again later";
              }
           }
           else
           {
             echo "Please check your image's width and height";
           }
         }
         else
         {
           echo "You must select a image for uploading";
         }

  }
  public function get_banner()
  {
    if (!$this->input->is_ajax_request()) { 	exit('No direct script access allowed');  }
    $data = array();
    $delete='<button id="delete" type="button" class="delete btn btn-danger has-icon btn-xs"><i class="material-icons mr-1">delete</i>Delete</button>';
    $sl=0;
    $filldata = $this->app->banner_data();
    foreach($filldata->result() as $row)
    {
      $sl++;
      if($row->display_status==1)
      {
        $display="Active";
        $btn='<input type="checkbox" class="tg"  checked/>';
      } else {
        $display="Inactive";
        $btn='<input type="checkbox" class="tg" />';
      }
      $image_path=$row->image_path;
      $image_path=base_url().$image_path;
      $img='<img src="'.$image_path.'" width="30%" />';
      $data[] = array(
  				'no' => $sl,
  				'id' => $row->bid,
  				'image' => $img,
        	'display_status' => $row->display_status,
  				'disp' => $btn,
  				'delete'=>$delete,
          'display'=>$display,
  			);
    }
    $output = array(
      "recordsTotal" => $filldata->num_rows(),
      "recordsFiltered" => $filldata->num_rows(),
      "data" => $data
    );
    echo json_encode($output);
  }
  public function change_banner_status()
  {
      if (!$this->input->is_ajax_request()) { 	exit('No direct script access allowed');  }
      $bid=$this->input->post('id');
      $dstatus=$this->input->post('dstatus');
      $data=array('display_status'=>$dstatus); $where=array('bid'=>$bid);
      $ins=update("banner",$data,$where);
      if($ins) echo 1;else echo "Unable to update, Please try again later";
  }
  public function delete_banner()
  {
    if (!$this->input->is_ajax_request()) { 	exit('No direct script access allowed');  }
    $bid=$this->input->post('id');
    $data=array('is_deleted'=>1); $where=array('bid'=>$bid);
    $ins=update("banner",$data,$where);
    if($ins) echo 1;else echo "Unable to delete, Please try again later";
  }

  public  function offers()
  {
    $data['page'] = 'offers';
    $data['mainpage'] = 'app_settings';
    $data['page_title'] = 'Offers';
    $this->template->page_maker('manage_app/offers',$data);
  }
  public function get_product_stock()
  {
      if (!$this->input->is_ajax_request()) { 	exit('No direct script access allowed');  }
      $pid=$this->input->post('pid');

      $availablestock=getAfield("available_stock","products","where pr_id=$pid");
      $mrp=getAfield("mrp","products","where pr_id=$pid");
      $sp=getAfield("selling_price","products","where pr_id=$pid");
      echo "$availablestock~$mrp~$sp";
  }
  public function save_offer()
  {
    if (!$this->input->is_ajax_request()) { 	exit('No direct script access allowed');  }
     $createduser=$this->session->userdata('userid');
     $active=$this->input->post('display_status');
     if($active) $active=1; else $active=0;
     if (isset($_FILES['uploaded_file']) && is_uploaded_file($_FILES['uploaded_file']['tmp_name']))
          {
            $prid=$this->input->post('pr_id');
            if(!$prid) {echo "Please select a product"; exit; }
            $mrp=$this->input->post('mrp');
            $sp=$this->input->post('sp');
            $stock=$this->input->post('stock');
              if($stock>0)
              {
                // check exist
                $check=getAfield("id","app_product_display","where product_id=$prid AND display_type=1 AND is_deleted=0");
                if($check>0) { echo "Product already exist in offer zone"; exit; }
                if($sp<$mrp)
                {
                  $directory='./assets/offer_banner/';
                  $config['upload_path']          = $directory;
                  $config['allowed_types']        = 'jpg|png|jpeg';
                  $config['max_size']             = 6000;
                  $image_info = getimagesize($_FILES["uploaded_file"]["tmp_name"]);
                  $image_width = $image_info[0];
                  $image_height = $image_info[1];
                  if(($image_width=="1920" && $image_height=="720"))
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
                     }
                     else
                     {
                       $upload_data = $this->upload->data();
                       $file_name = $upload_data['file_name'];
                       $uploadedfile=$directory."/".$file_name;
                       $data=array(
                         'product_id'=>$prid,
                         'display_type'=>1,
                         'banner_path'=>$uploadedfile,
                         'display_status'=>$active,
                         'created_by'=>$createduser,
                         );
                          $ins=insertInDb("app_product_display",$data);
                          if($ins) echo 1; else echo "Unable to upload , try again later";
                     }
                  }
                  else
                  {
                       echo "Please check your image's width and heigt";
                  }
                }else{
                  echo "Selling price must be less than  MRP";
                }
              }
              else{
                echo "Stock must be greater than zero";
              }

          }
          else
          {
            echo "You must select a banner";
          }
  }
  public function get_offers($type=1)
  {
      if (!$this->input->is_ajax_request()) { 	exit('No direct script access allowed');  }
      $data = array();
      $delete='<button id="delete" type="button" class="delete btn btn-danger has-icon btn-xs"><i class="material-icons mr-1">delete</i>Delete</button>';
      $sl=0;
      $filldata = $this->app->offer_data($type);
      foreach($filldata->result() as $row)
      {
        $sl++;
        if($row->display_status==1)
        {
          $display="Active";
          $btn='<input type="checkbox" class="tg"  checked/>';
        } else {
          $display="Inactive";
          $btn='<input type="checkbox" class="tg" />';
        }
        $image_path=$row->banner_path;
        $image_path=base_url().$image_path;
        $img='<img src="'.$image_path.'" width="30%" />';
        $data[] = array(
    				'no' => $sl,
    				'id' => $row->id,
    				'image' => $img,
          	'display_status' => $row->display_status,
    				'disp' => $btn,
    				'delete'=>$delete,
            'display'=>$display,
            'product_name'=>$row->product_name,
            'selling_price'=>$row->selling_price,
    			);
      }
      $output = array(
        "recordsTotal" => $filldata->num_rows(),
        "recordsFiltered" => $filldata->num_rows(),
        "data" => $data
      );
      echo json_encode($output);
  }
  public function change_offer_status()
  {
    if (!$this->input->is_ajax_request()) { 	exit('No direct script access allowed');  }
    $id=$this->input->post('id');
    $dstatus=$this->input->post('dstatus');
    $data=array('display_status'=>$dstatus); $where=array('id'=>$id);
    $ins=update("app_product_display",$data,$where);
    if($ins) echo 1;else echo "Unable to update, Please try again later";

  }
  public function new_arrivals()
  {
    $data['page'] = 'new_arrivals';
    $data['mainpage'] = 'app_settings';
    $data['page_title'] = 'New Arrivals';
    $this->template->page_maker('manage_app/new_arrivals',$data);
  }
  public function save_product_display()
  {

      if (!$this->input->is_ajax_request()) { 	exit('No direct script access allowed');  }
       $createduser=$this->session->userdata('userid');
       $active=$this->input->post('display_status');
       $d_type=$this->input->post('crude');
       if($active) $active=1; else $active=0;
       if ($d_type>0)
            {
              $prid=$this->input->post('pr_id');
              if(!$prid) {echo "Please select a product"; exit; }
                $stock=$this->input->post('stock');
                if($stock>0)
                {
                  // check exist
                  $check=getAfield("id","app_product_display","where product_id=$prid AND display_type=$d_type AND is_deleted=0");
                  if($check>0) { echo "Product already added"; exit; }

                    $data=array(
                      'product_id'=>$prid,
                      'display_type'=>$d_type,
                      'banner_path'=>'',
                      'display_status'=>$active,
                      'created_by'=>$createduser,
                      );
                       $ins=insertInDb("app_product_display",$data);
                       if($ins) echo 1; else echo "Unable to upload , try again later";

                }
                else{
                  echo "Stock must be greater than zero";
                }

            }
            else
            {
              echo "You must select a banner";
            }
  }
  public function delete_product_display()
  {
    if (!$this->input->is_ajax_request()) { 	exit('No direct script access allowed');  }
    $id=$this->input->post('id');
    $data=array('is_deleted'=>1); $where=array('id'=>$id);
    $ins=update("app_product_display",$data,$where);
    if($ins) echo 1;else echo "Unable to delete, Please try again later";
  }
  public function featured_products()
  {
    $data['page'] = 'featured_products';
    $data['mainpage'] = 'app_settings';
    $data['page_title'] = 'Featured Products';
    $this->template->page_maker('manage_app/featured_products',$data);
  }
}
