<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
class Public_api extends REST_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('public_api_model');
		date_default_timezone_set('Asia/Calcutta');
		$headers=getallheaders();
		$cipher_key=$headers['cipher_key'];
		if($cipher_key!=CIPHER_KEY)
		{
			$this->response(array('status' => 103, 'result' => 'IN VALID REQUEST'), REST_Controller::HTTP_NOT_FOUND);
			exit;
		}
	}

	public function index_get()
	 {
			$this->response(array('status' => 103, 'result' => 'Unknown Method'), REST_Controller::HTTP_NOT_FOUND);
	 }
	 public function index_post()
	 {
			$this->response(array('status' => 103, 'result' => 'Unknown Methodx'), REST_Controller::HTTP_NOT_FOUND);
	 }

	 public function app_version_get()
	 {
		 $response=array();
		 $version=getAfield("version","app_version","where id=1");
		 $response['app_version']=$version;
		 $this->response(array('status' => 200, 'message' => "Success" ,'response'=>$response ), REST_Controller::HTTP_OK);
	 }
	 public function get_banners_get()
	 {
		  $response=array();
			$banners = $this->public_api_model->get_banner();
			$response=$banners->result();
			$rows=$banners->num_rows();
			if($rows>0)
			{
						$this->response(array('status' => 200, 'message' => "Success" ,'response'=>$response ), REST_Controller::HTTP_OK);
			}
			else
			{
					$this->response(array('status' => 204, 'message' => "No Data Found" ,'response'=>$response ), REST_Controller::HTTP_NO_CONTENT );
			}

	 }
	 public function get_display_products_get()
	 {
		 $display_type=$this->input->get('disp_type');  //1-offer, 2, new arrival, 3-featured
		 $serach_item=$this->input->get('serach_item');
		 $products = $this->public_api_model->get_disp_products($display_type,$serach_item);
		 $response=$products->result();
		 $rows=$products->num_rows();

		 if($rows>0)
		 {
					 $this->response(array('status' => 200, 'message' => "Success" ,'response'=>$response ), REST_Controller::HTTP_OK);
		 }
		 else
		 {
				 $this->response(array('status' => 204, 'message' => "No Data Found" ,'response'=>$response ), REST_Controller::HTTP_NO_CONTENT );
		 }
	 }
	 public function product_single_get()
	 {
		 $pr_id=$this->input->get('pr_id');
		 $products=$this->public_api_model->get_product_details($pr_id);
		 $rows=$products->num_rows();
		 if($rows>0)
		 {
			 	   $tax_d=$products->row()->tax_id;
					 $tax_val=getAfield("tax_value","tax_master","where id=$tax_d");
					 $response['product_details']=$products->row();
					 $tax_aray=array('tax_id'=>$tax_d,'tax_value'=>$tax_val,'taxt_type'=>'inclusive');
					 $response['tax_details']=$tax_aray;
					 $response['product_images']=$this->public_api_model->get_product_images($pr_id);
					 $this->response(array('status' => 200, 'message' => "Success" ,'response'=>$response ), REST_Controller::HTTP_OK);
		 }
		 else
		 {
				 $this->response(array('status' => 204, 'message' => "No Data Found" ,'response'=>$response ), REST_Controller::HTTP_NO_CONTENT );
		 }
	 }
	 public function product_listing_post()
	 {
		 $data=array();
		 $data['serach_item']=$this->input->post('serach_item');
		 $data['category_id']=$this->input->post('category_id');
		 $data['lower_limit']=$this->input->post('lower_limit');
		 $data['upper_limit']=$this->input->post('upper_limit');
		 $data['order_by']=$this->input->post('order_by');
		 $data['order_by_type']=$this->input->post('order_by_type');

	 	$products=$this->public_api_model->get_product_list($data);
		 $response=$products->result();
		 $rows=$products->num_rows();

		 if($rows>0){
					 $this->response(array('status' => 200, 'message' => "Success" ,'response'=>$response ), REST_Controller::HTTP_OK);
		 }
		 else {
				 $this->response(array('status' => 204, 'message' => "No Data Found" ,'response'=>$response ), REST_Controller::HTTP_NO_CONTENT );
		 }

	 }
	 public function stock_check_get()
	 {
		 $pr_id=$this->input->get('pr_id');
		 if($pr_id>0)
		 {
			 $response=array();
			 $stock=getAfield("available_stock","products","where pr_id =$pr_id");
			 $response['stock']=$stock;
			 $this->response(array('status' => 200, 'message' => "Success" ,'response'=>$response ), REST_Controller::HTTP_OK);
		 }
	 }
	 public function get_homepage_data_get()
	 {
		 $response=array();
		 $s_item="";
		 $of_products = $this->public_api_model->get_disp_products(1,$s_item);
		 $response['offers']=$of_products->result();
		 $new_products = $this->public_api_model->get_disp_products(2,$s_item);
		 $response['new_arrivals']=$new_products->result();
		 $fet_products = $this->public_api_model->get_disp_products(3,$s_item);
		 $response['featured_products']=$fet_products->result();
		 	if($response)
			{
				 $this->response(array('status' => 200, 'message' => "Success" ,'response'=>$response ), REST_Controller::HTTP_OK);
			}
			else{
				$this->response(array('status' => 204, 'message' => "No Data Found" ,'response'=>$response ), REST_Controller::HTTP_NO_CONTENT );
			}
	 }
	 public function get_categories_get()
	 {
		 	 $response=array();
			 $serach_item=$this->input->get("search_word");
			 if(!$serach_item) $serach_item="";
			 $categories = $this->public_api_model->get_categories($serach_item);
			 $response=$categories->result();
			 $rows=$categories->num_rows();
			 if($rows>0){
						 $this->response(array('status' => 200, 'message' => "Success" ,'response'=>$response ), REST_Controller::HTTP_OK);
			 }
			 else {
					 $this->response(array('status' => 204, 'message' => "No Data Found" ,'response'=>$response ), REST_Controller::HTTP_NO_CONTENT );
			 }
	 }
}
