<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require_once(APPPATH."libraries/razorpay/Razorpay.php");

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
class Cipher_crone extends REST_Controller {

    public function __construct() {
		parent::__construct();
		$this->load->database();
		date_default_timezone_set('Asia/Calcutta');
	}

    public function index_get()
	 {
			$this->response(array('status' => 103, 'result' => 'Unknown Method'), REST_Controller::HTTP_NOT_FOUND);
	 }
	 public function index_post()
	 {
			$this->response(array('status' => 103, 'result' => 'Unknown Method'), REST_Controller::HTTP_NOT_FOUND);
	 }
     public function checkRazorPayStatus_get()
     {
		$qry="SELECT order_master_id,order_number,user_id,address_id,razor_refund_id,refund_transaction_id,refund_status FROM
			order_master WHERE refund_status!=2 AND  razor_refund_id!=''";
			//

		$qrry=$this->db->query($qry);
		foreach($qrry->result() as $row)
		{
			$order_master_id=$row->order_master_id;
			$user_id=$row->user_id;
			$razor_refund_id=$row->razor_refund_id;
			$refund_transaction_id=$row->refund_transaction_id;
			$refund_status=$row->refund_status;

			if($razor_refund_id)
			{
				$status=$this->razor_get_refund_status($razor_refund_id);
				if($status=="pending") $refund_status_code=1;
				else if($status=="processed") $refund_status_code=2;
				else if($status=="failed") $refund_status_code=3;
				else $refund_status_code=1;

				$ups_data=array('refund_status'=>$refund_status_code);
				$where=array('order_master_id'=>$order_master_id);
				$ups=update("order_master",$ups_data,$where);
				if($ups)
				{
					$ins_data=array(
						'order_master_id'=>$order_master_id,
						'update_type'=>3,
						'refund_status'=>$refund_status_code,
						'refund_transcation_id'=>$refund_transaction_id,
						'razorpay_refund_id'=>$razor_refund_id
					);

					$insert= insertInDb("refund_status_update",$ins_data);
					
					// update transcation table

					$tr_up_data=array('refund_status'=>$refund_status_code); 
					$where2=array('id'=>$refund_transaction_id,'order_id'=>$order_master_id);
					$ups_trans=update("refund_transactions",$tr_up_data,$where2);
				}
				
			}
		}

		
     }

	 public function razor_get_refund_status($refund_id)
	 {
	  
		$api = new Api(RAZOR_KEY, RAZOR_SECRET_KEY);
		try
		{
		$result = $api->refund->fetch($refund_id);
		return $result['status'];

		}
		catch(SignatureVerificationError $e){
		$response = 'failure' ;
		$refund = 'Razorpay Error : ' . $e->getMessage();
		$refund_id=0;
		return 0;
		//echo $error;
		}

		/*******
		 * pending=1
		 * processed=2
		 * failed=3
		 * 
		 * ********/
	 }
}