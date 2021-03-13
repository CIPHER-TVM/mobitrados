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
		 // $response=array();
		 // $version=getAfield("version","app_version","where id=1");
		 // $response['app_version']=$version;
		 // $this->response(array('status' => 200, 'message' => "Success" ,'response'=>$response ), REST_Controller::HTTP_OK);
		 $response=array();
		 $qry="SELECT * FROM app_settings";
		 $qrry=$this->db->query($qry);
		 $response=$qrry->row();
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
		 $response=array();
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
	 public function get_categories_post()
	 {
		 	 $response=array();
			 $serach_item=$this->input->post("search_word");
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
	 public function get_state_get()
	 {
		  $response=array();
		  $state = $this->public_api_model->get_state();
			$response=$state->result();
			$rows=$state->num_rows();
			if($rows>0){
						$this->response(array('status' => 200, 'message' => "Success" ,'response'=>$response ), REST_Controller::HTTP_OK);
			}
			else {
					$this->response(array('status' => 204, 'message' => "No Data Found" ,'response'=>$response ), REST_Controller::HTTP_NO_CONTENT );
			}
	 }
	 public function get_district_get()
	 {
		  $response=array();
			$state_id=$this->input->get('StateID');
		  $district = $this->public_api_model->get_district($state_id);
			$response=$district->result();
			$rows=$district->num_rows();
			if($rows>0){
						$this->response(array('status' => 200, 'message' => "Success" ,'response'=>$response ), REST_Controller::HTTP_OK);
			}
			else {
					$this->response(array('status' => 204, 'message' => "No Data Found" ,'response'=>$response ), REST_Controller::HTTP_NO_CONTENT );
			}
	 }
	 public function get_place_get()
	 {
		 $response=array();
		 $district_id=$this->input->get('DistrictID'); if(!$district_id) $district_id=0;
 	 	 $place_id=$this->input->get('PlaceID');  if(!$place_id) $place_id=0;
		 $pincode=$this->input->get('pincode'); if(!$pincode) $pincode=0;
		 $place = $this->public_api_model->get_place($district_id,$place_id,$pincode);
		 $response=$place->result();
		 $rows=$place->num_rows();
		 if($rows>0){
					 $this->response(array('status' => 200, 'message' => "Success" ,'response'=>$response ), REST_Controller::HTTP_OK);
		 }
		 else {
				 $this->response(array('status' => 204, 'message' => "No Data Found" ,'response'=>$response ), REST_Controller::HTTP_NO_CONTENT );
		 }
	 }

	 public function get_app_settings_get()
	 {
		 $response=array();
		 $qry="SELECT * FROM app_settings";
		 $qrry=$this->db->query($qry);
		 $response=$qrry->row();
		 $this->response(array('status' => 200, 'message' => "Success" ,'response'=>$response ), REST_Controller::HTTP_OK);
	 }

	 public function get_product_review_get()
	 {
		 $response=array();
		 $product_id=$this->input->get('product_id');
		 $average_star=getAfield('AVG(star_rating)',"product_rating","where product_id=$product_id");
		 $list_rating = $this->public_api_model->get_rating($product_id);
		 $response=$list_rating->result();
		 $rows=$list_rating->num_rows();
		 if($rows>0){
					$this->response(array('status' => 200, 'message' => "Success" ,'avg_star'=>$average_star,'response'=>$response ), REST_Controller::HTTP_OK);
		}
		else {
				$this->response(array('status' => 204, 'message' => "No Data Found" ,'response'=>$response ), REST_Controller::HTTP_NO_CONTENT );
		}
	 }

	 public function kssm_sms_get()
	 {
		 $qry="SELECT * FROM  kssm_sms_data where pid >=76 AND pid <=100";
		 $qrry=$this->db->query($qry);
		 foreach($qrry->result() as $rs)
		 {
			 $sendsms=0;
			 $mobile_number=$rs->mobile_number;
			 $pname=$rs->pname;
			 $income=$rs->income;
			 $income_file=$rs->income_file;
			 $aadhar=$rs->aadhar;
			 $aadhar_file=$rs->aadhar_file;
			 $medical_certificate=$rs->medical_certificate;
			 $ap_bpl=$rs->ap_bpl;
			 $ap_bpl_file=$rs->ap_bpl_file;
			 $dept_id=$rs->dept_id;
			 $reg_number=$rs->reg_number;
			 $dpt="";
			 	if($dept_id==1){
					$dp="Multiple Sclerosis";
				}
				else{
					$dp="Ankylosing Spondylitis";
				}

			 $sms_text="Dear $pname, Thanks for registering for $dp, scheme of KSSM, Govt of Kerala.Your application number is $reg_number. While scrutinizing your application, we found that some details are missing.Can you please send the below documents to KSSMSID@gmail.com by 1 Feb 2021.";
		//	 $sms=sendSms($mobile_number,$sms_text);
		// Ration Card, Income Certificate, Aadhar Card, Medical Certificate.

			if(!$ap_bpl_file || $ap_bpl_file=="")
			{
				$sendsms=1;
				$sms_text.=" Ration Card,";
			}
			if($ap_bpl==1) // if apl
			{
				if(!$ap_bpl_file || $ap_bpl_file=="")
				{
					$sendsms=1;
					$sms_text.=" Income Certificate,";
				}
			}
			if(!$aadhar_file || $aadhar_file=="")
			{
				$sendsms=1;
				$sms_text.=" Aadhar Card,";
			}
			if(!$medical_certificate ||  $medical_certificate=="")
			{
				$sendsms=1;
				$sms_text.=" Medical Certificate";
			}

			$sms_text=rtrim($sms_text, ',');

			if($sendsms==1)
			{
				//$sms_text=urlencode($sms_text);
			//	$sms=sendSms($mobile_number,$sms_text);
				$sms=1;

				 if($sms)
				 {
					 echo "SMS SEND TO $mobile_number :  $sms_text <br />";
				 }
			}
			else{
				$sms="";
			}

		//	echo $sms_text;


		 }
	 }

	 public function get_terms_conditions_get()
   {
     $terms=getAfield('app_terms'," terms_conditions","where id >0 order by id desc limit 1");
     $response=array('terms_conditions'=>$terms);
     $this->response(array('status' => 200, 'message' => "Success" ,'response'=>$response ), REST_Controller::HTTP_OK);
   }


}
