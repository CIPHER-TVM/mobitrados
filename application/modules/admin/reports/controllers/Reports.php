<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Reports extends MY_Controller {
  public function __construct()
  {
  	parent::__construct();
    	$this->load->model('Reports_m','reports');
  }
  public function current_stock()
  {
    $data['page'] = 'c_stock';
    $data['mainpage'] = 'c_stock';
    $data['page_title'] = 'Current Stock report';
    $this->template->page_maker('reports/current_stock',$data);
  }
  public function get_current_stock()
  {
    if (!$this->input->is_ajax_request()) { 	exit('No direct script access allowed');  }
    $data = array();
    $filldata = $this->reports->product_data();
    $output = array(
      "recordsTotal" => $filldata->num_rows(),
      "recordsFiltered" => $filldata->num_rows(),
      "data" => $filldata->result()
    );
    echo json_encode($output);
  }
  public function basic_sales_report()
  {
    $data['page'] = 'basic_sales';
    $data['mainpage'] = 'sales_report';
    $data['page_title'] = 'Basic sales report';
    $this->template->page_maker('reports/basic_sales_report',$data);
  }
  public function get_basic_sales()
  {
    if (!$this->input->is_ajax_request()) { 	exit('No direct script access allowed');  }
    $data = array();
    $filldata = $this->reports->basic_sales_data();
    $output = array(
      "recordsTotal" => $filldata->num_rows(),
      "recordsFiltered" => $filldata->num_rows(),
      "data" => $filldata->result()
    );
    echo json_encode($output);
  }
  public function product_sales_report()
  {
    $data['page'] = 'product_sales';
    $data['mainpage'] = 'sales_report';
    $data['page_title'] = 'Produt sales report';
    $this->template->page_maker('reports/product_sales_report',$data);
  }
  public function get_product_sales()
  {
    if (!$this->input->is_ajax_request()) { 	exit('No direct script access allowed');  }
    $data = array();
    $filldata = $this->reports->product_sales_data();
    // echo $this->db->last_query();
    // exit;
    $output = array(
      "recordsTotal" => $filldata->num_rows(),
      "recordsFiltered" => $filldata->num_rows(),
      "data" => $filldata->result()
    );
    echo json_encode($output);
  }

}
?>
