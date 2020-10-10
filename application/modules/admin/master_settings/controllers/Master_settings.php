<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Master_settings extends MY_Controller {
  public function __construct()
  {
  	parent::__construct();
    	$this->load->model('Settings_m','settings');
  }
  public function tax_master()
  {
    $data['page'] = 'tax';
    $data['mainpage'] = 'master_settings';
    $data['page_title'] = 'Tax Master';
    $this->template->page_maker('master_settings/text_master',$data);
  }
  public function save_tax()
  {
    if (!$this->input->is_ajax_request()) { 	exit('No direct script access allowed');  }
    $createduser=$this->session->userdata('userid');
    $crude=$this->input->post('crude');
    $tax=$this->input->post('tax');
    $active=$this->input->post('display_status');
    if($active) $active=1; else $active=0;
    $id=$this->input->post('hidid');
    if($tax>0)
    {
      if($crude==1){ $chk=checkexist("id","tax_master","where is_deleted=0 and tax_value='$tax'"); }
      else if($crude==2) { $chk=checkexist("id","tax_master","where is_deleted=0 and tax_value='$tax' and id!=$id"); }
      if($chk==0)
      {
        $data=array(
          'tax_value'=>$tax,
          'display_status'=>$active,
          'created_by'=>$createduser
        );
        if($crude==1)
        {
          $ins=insertInDb("tax_master",$data);
          if($ins) echo 1; else echo "Unable to save, please try after some time!";
        }
        else if($crude==2)
        {
          $where=array('id'=>$id);
          $ins=update("tax_master",$data,$where);
          if($ins) echo 1; else echo "Unable to update, please try after some time!";
        }

      }
      else
      {
        echo "Unable to save, data already exist";
      }

    }
    else
    {
      echo "Please fill all mandatory feilds";
    }

  }
  public function delete_tax()
  {
    if (!$this->input->is_ajax_request()) { 	exit('No direct script access allowed');  }
    $id=$this->input->post('id');
    if($id>0){
      $where=array('id'=>$id);
      $data=array('is_deleted'=>1);
      $ins=update("tax_master",$data,$where);
      if($ins) echo 1; else echo "Unable to delete, please try after some time!";
    }
  }
  public function get_tax_data()
  {
    if (!$this->input->is_ajax_request()) { 	exit('No direct script access allowed');  }
    $data = array();
    $filldata = $this->settings->tax_data();
    $edit='<button id="edit" type="button" class="edit btn btn-success has-icon btn-xs"><i class="material-icons mr-1">create</i>Edit&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>';
    $delete='<button id="delete" type="button" class="delete btn btn-danger has-icon btn-xs"><i class="material-icons mr-1">delete</i>Delete</button>';
    $sl=0;
    foreach($filldata->result() as $row)
    {
      $sl++;
      if($row->display_status==1) $display="Active"; else $display="Inactive";
      $data[] = array(
  				'no' => $sl,
  				'id' => $row->id,
  				'tax_value' => $row->tax_value,
          'disp_tax'=>$row->tax_value." %",
  				'display_status' => $row->display_status,
  				'edit' => $edit,
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

}
