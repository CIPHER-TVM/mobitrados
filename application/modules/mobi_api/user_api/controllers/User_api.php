<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . '/libraries/CreatorJwt.php';
require_once(APPPATH."libraries/razorpay/Razorpay.php");

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

class User_api extends REST_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->database();
    $this->load->model('user_api_model');
    date_default_timezone_set('Asia/Calcutta');
    $headers=getallheaders();
    $cipher_key=$headers['cipher_key'];
    if($cipher_key!=CIPHER_KEY)
    {
      $this->response(array('status' => 103, 'result' => 'IN VALID REQUEST'), REST_Controller::HTTP_NOT_FOUND);
      exit;
    }

    $this->objOfJwt = new CreatorJwt();
    header('Content-Type: application/json');
  }

   public function index_get()
   {
      $this->response(array('status' => 103, 'result' => 'Unknown Method'), REST_Controller::HTTP_NOT_FOUND);
   }
   public function index_post()
   {
      $this->response(array('status' => 103, 'result' => 'Unknown Methodx'), REST_Controller::HTTP_NOT_FOUND);
   }
   public function user_registration_post()
   {
      $mobile_number=$this->input->post('mobile_number');
      $response=array();
      if($mobile_number){
          if(preg_match('/^[0-9]{10}+$/', $mobile_number))
          {

            $check_exist=checkexist("app_user_id","app_usres","where mobile_number='$mobile_number' AND is_deleted=0 AND account_verified=1");
            if($check_exist==0)
            {
              $exist_user=getAfield("app_user_id","app_usres","where mobile_number='$mobile_number' AND  is_deleted=0 AND account_verified=0");
              $otp= rand(100000, 999999);
            //  $otp="CI".$otp;
              $str=rand();
              $string = md5($str);
              $registration_token=secretkeyGneration("encrypt",$string,$key="CImsdYkmPHnsfruypojkeER",0);
              $ins_data=array(
                'mobile_number'=>$mobile_number,
                'account_verified'=>0,
                'name'=>'',
                'email'=>'',
                'password'=>'',
                'otp'=>$otp,
                'registration_token'=>$registration_token
              );
              $sms_text="Your One Time Verfication Code Is $otp";
              $sendotp=sendSms($mobile_number,$sms_text);
              if($exist_user>0)
              {
                  $where=array('app_user_id'=>$exist_user);
                  $ins=$this->user_api_model->update("app_usres",$ins_data,$where);
              }
              else{
                // create new user
                $ins=$this->user_api_model->insert("app_usres",$ins_data);
              }
                if($ins)
                {
                  $response['registration_token']=$registration_token;
                  $this->response(array('status' => 200, 'message'=>'Account Created, OTP sent','response' => $response), REST_Controller::HTTP_OK);
                }
                else{
                   $this->response(array('status' => 410, 'message' => "Failed to save" ,'response'=>'' ), REST_Controller::HTTP_GONE);
                }

            }
            else{

              	$this->response(array('status' => 409, 'message' => 'User Already exist','response'=>$response), REST_Controller::HTTP_CONFLICT );
            }

          }else{
            	$this->response(array('status' => 400, 'message' => 'Invalid Mobile Number','response'=>$response), REST_Controller::HTTP_BAD_REQUEST );
          }
      }
   }
   public function user_otp_verfication_post()
   {
     $response=array();
     $mobile_number=$this->input->post('mobile_number');
     $otp=$this->input->post('otp');
     $registration_token=$this->input->post('registration_token');
     if($mobile_number && $otp && $registration_token)
     {
        $exist_user=getAfield("app_user_id","app_usres","where mobile_number='$mobile_number' AND  is_deleted=0 AND otp!=''");
        if($exist_user>0)
        {
          $reg_get_token=getAfield("registration_token","app_usres","where app_user_id=$exist_user");

          if (strcmp($reg_get_token, $registration_token) != 0)
          {
              $this->response(array('status' => 203, 'message' => 'Invalid Attempt','response'=>$response), REST_Controller::HTTP_NON_AUTHORITATIVE_INFORMATION );
              exit;
          }

              $verfication=getAfield("otp_verified","app_usres","where app_user_id ='$exist_user'");
              if($verfication==0){
                  $ext_otp=getAfield("otp","app_usres","where app_user_id ='$exist_user'");
                  if($ext_otp==$otp)
                  {
                    $ins_data=array('otp_verified'=>1);
                    $where=array('app_user_id'=>$exist_user);
                    $ins=$this->user_api_model->update("app_usres",$ins_data,$where);
                      if($ins)
                      {
                          $this->response(array('status' => 200, 'message'=>'Otp Verification Success','response' => $response), REST_Controller::HTTP_OK);
                      }
                      else{
                         $this->response(array('status' => 410, 'message' => "Failed to verify" ,'response'=>'' ), REST_Controller::HTTP_GONE);
                      }
                  }else{
                      $this->response(array('status' => 203, 'message' => 'Invalid OTP','response'=>$response), REST_Controller::HTTP_NON_AUTHORITATIVE_INFORMATION);
                  }
              }
              else{
                   $this->response(array('status' => 409, 'message' => 'Otp Already Verified','response'=>''), REST_Controller::HTTP_CONFLICT );
              }
        }
        else{
            $this->response(array('status' => 204, 'message' => "No user found" ,'response'=>'' ), REST_Controller::HTTP_NO_CONTENT);
        }

     }
     else{
       $this->response(array('status' => 400, 'message' => 'Invalid Input','response'=>$response), REST_Controller::HTTP_BAD_REQUEST );
     }
   }
   public function complete_registration_post()
   {
      $response=array();
      $mobile_number=$this->input->post('mobile_number');
      $registration_token=$this->input->post('registration_token');
      $name=$this->input->post('name');
      $email=$this->input->post('email');
      $password=$this->input->post('password');
      if($mobile_number && $registration_token && $name && $email && $password)
      {
        $exist_user=getAfield("app_user_id","app_usres","where mobile_number='$mobile_number' AND  is_deleted=0 AND otp_verified=1 AND registration_token!=''");
        if($exist_user>0)
        {
          $reg_get_toekn=getAfield("registration_token","app_usres","where app_user_id=$exist_user");
          if (strcmp($reg_get_toekn, $registration_token) == 0)
          {
            $password=secretkeyGneration("encrypt",$password,$key="CImsdYkmPHnsfruypojkeER",$out=0);
            $dynamic_token= $this->user_api_model->random_num(12);
            $ins_data=array(
              'name'=>$name,
              'email'=>$email,
              'password'=>$password,
              'otp'=>'',
              'registration_token'=>'',
              'account_verified'=>1,
              'token'=>$dynamic_token
            );
            $where=array('app_user_id'=>$exist_user);
            $ins=$this->user_api_model->update("app_usres",$ins_data,$where);
            if($ins)
            {
               // generate login
               $tokenData['user_id'] = $exist_user;
               $tokenData['access_token'] = $dynamic_token;
               $jwtToken = $this->objOfJwt->GenerateToken($tokenData);
               $login['access_token']=$jwtToken;
               $response=$login;
               $this->response(array('status' => 200, 'message'=>'Registration  Success','response' => $response), REST_Controller::HTTP_OK);
            }
            else{
               $this->response(array('status' => 410, 'message' => "Failed to verify" ,'response'=>'' ), REST_Controller::HTTP_GONE);
            }

          }
          else{
            $this->response(array('status' => 203, 'message' => 'Invalid Attempt','response'=>$response), REST_Controller::HTTP_NON_AUTHORITATIVE_INFORMATION);
          }
        }
        else{
          $this->response(array('status' => 203, 'message' => 'Invalid request','response'=>$response), REST_Controller::HTTP_NON_AUTHORITATIVE_INFORMATION);
        }
      }
      else{
        $this->response(array('status' => 400, 'message' => 'Invalid Input','response'=>$response), REST_Controller::HTTP_BAD_REQUEST);
      }

   }
   public function login_post()
   {
     $mobile_number=$this->input->post('mobile_number');
     $password=$this->input->post('password');
     $response=array();
     if($mobile_number!="" && $password!="")
		 {
       $password= secretkeyGneration("encrypt",$password,$key="CImsdYkmPHnsfruypojkeER",$out=0);
       	$login = $this->user_api_model->loginUsr($mobile_number, $password);
        if($login)
        {
          $account_verified=$login['account_verified'];
          if($account_verified==1)
          {
            $dynamic_token= $this->user_api_model->random_num(12);
            $data=array('token'=>$dynamic_token );
            $where=array('app_user_id '=>$login['app_user_id']);
            $update = $this->user_api_model->update('app_usres', $data, $where);

            $tokenData['user_id'] = $login['app_user_id'];
            $tokenData['access_token'] = $dynamic_token;
            $jwtToken = $this->objOfJwt->GenerateToken($tokenData);
            $login['access_token']=$jwtToken;
          //  $response['user_details']=$login;
            $response=$login;

            // get wishlist
            $wish_user=$login['app_user_id'];
            $wish_qry="SELECT product_id FROM wish_list WHERE user_id=$wish_user";
            $wish_qry_exe=$this->db->query($wish_qry);
            $wish_resut=$wish_qry_exe->result();
            $wish_resut = array_column ( $wish_resut , 'product_id' );
            
            $this->response(array('status' => 200, 'message'=>'Login Success','response' => $response,'wishlist'=>$wish_resut), REST_Controller::HTTP_OK);
          }
          else
          {
            $this->response(array('status' => 203, 'message' => 'Your account is not verified','response'=>$response), REST_Controller::HTTP_NON_AUTHORITATIVE_INFORMATION );
          }

        }
        else
        {
          	$this->response(array('status' => 203, 'message' => 'Invalid username or password','response'=>$response), REST_Controller::HTTP_NON_AUTHORITATIVE_INFORMATION );
        }
     }
     else{
       	$this->response(array('status' => 400, 'message' => 'Invalid Parameters','response'=>$response), REST_Controller::HTTP_BAD_REQUEST );
     }
   }
   public function check_user()
   {
     $received_Token = $this->input->request_headers('access_token');
     if(isset($received_Token['access_token']))
     {
       $token=$received_Token['access_token'];
       $jwtData = $this->objOfJwt->DecodeToken($token);
       $user_id=$jwtData['user_id'];
       $access_token=$jwtData['access_token'];
       $user_token=getAfield("token","app_usres","where app_user_id =$user_id and is_deleted=0");
       	if (strcmp($user_token, $access_token) == 0)
        {
            return $user_id;
        }
        else
        {
          return false;
        }
     }
     else{
       return false;
     }


   }
   public function get_profile_get()
   {
      if($userid=$this->check_user())
      {
        $profile = $this->user_api_model->get_profile($userid);
        if($profile){
          
           $wish_qry="SELECT product_id FROM wish_list WHERE user_id=$userid";
            $wish_qry_exe=$this->db->query($wish_qry);
            $wish_resut=$wish_qry_exe->result();
            $wish_resut = array_column ( $wish_resut , 'product_id' );

          $this->response(array('status' => 200, 'message' => "Success" ,'response'=>$profile,'wishlist'=>$wish_resut ), REST_Controller::HTTP_OK);
        }
        else{
            $this->response(array('status' => 204, 'message' => "No data found" ,'response'=>'' ), REST_Controller::HTTP_NO_CONTENT);
        }
      }
      else{
          $this->response(array('status' => 203, 'message' => 'Authentication Failed','response'=>''), REST_Controller::HTTP_NON_AUTHORITATIVE_INFORMATION );
      }

   }

   public function add_wishlist_get()
   {
     if($userid=$this->check_user())
     {
       $pr_id=$this->input->get('pr_id');
       $check_exist=checkexist("id","wish_list","where product_id=$pr_id AND user_id=$userid");
       if($check_exist==0){
         $ins_data=array('product_id'=>$pr_id,'user_id'=>$userid);
         $ins=$this->user_api_model->insert("wish_list",$ins_data);
         if($ins){
            $this->response(array('status' => 200, 'message' => "Saved Successfully" ,'response'=>'' ), REST_Controller::HTTP_OK);
         }else{
           $this->response(array('status' => 410, 'message' => "Failed to save" ,'response'=>'' ), REST_Controller::HTTP_GONE);
         }
       }
       else{
         $where=array('product_id'=>$pr_id,'user_id'=>$userid);
         $delete=$this->user_api_model->delete("wish_list",$where);
         if($delete){
            $this->response(array('status' => 201, 'message' => "Removed Successfully" ,'response'=>'' ), REST_Controller::HTTP_OK);
         }else{
           $this->response(array('status' => 410, 'message' => "Failed to Remove" ,'response'=>'' ), REST_Controller::HTTP_GONE);
         }
          // $this->response(array('status' => 409, 'message' => 'Data already exist','response'=>''), REST_Controller::HTTP_CONFLICT );
       }
     }
     else{
       $this->response(array('status' => 203, 'message' => 'Authentication Failed','response'=>''), REST_Controller::HTTP_NON_AUTHORITATIVE_INFORMATION );
      }
   }
   public function remove_wishlist_get()
   {
     if($userid=$this->check_user())
     {
        $pr_id=$this->input->get('pr_id');
        $where=array('product_id'=>$pr_id,'user_id'=>$userid);
        $delete=$this->user_api_model->delete("wish_list",$where);
        if($delete){
           $this->response(array('status' => 201, 'message' => "Removed Successfully" ,'response'=>'' ), REST_Controller::HTTP_OK);
        }else{
          $this->response(array('status' => 410, 'message' => "Failed to Remove" ,'response'=>'' ), REST_Controller::HTTP_GONE);
        }
     }
     else{
       $this->response(array('status' => 203, 'message' => 'Authentication Failed','response'=>''), REST_Controller::HTTP_NON_AUTHORITATIVE_INFORMATION );
     }
   }
   public function get_wishlist_get()
   {
     if($userid=$this->check_user())
     {
       $products = $this->user_api_model->get_wishlist_products($userid);
       $response=$products->result();
       $rows=$products->num_rows();
       if($rows>0)
  		 {
  					 $this->response(array('status' => 200, 'message' => "Success" ,'response'=>$response ), REST_Controller::HTTP_OK);
  		 }
  		 else
  		 {
  				 $this->response(array('status' => 205, 'message' => "No items found" ,'response'=>$response ), REST_Controller::HTTP_RESET_CONTENT );
  		 }
     }
     else{
       $this->response(array('status' => 203, 'message' => 'Authentication Failed','response'=>''), REST_Controller::HTTP_NON_AUTHORITATIVE_INFORMATION );
     }
   }
   public function add_to_cart_post()
   {
     if($userid=$this->check_user())
     {
       $pr_id=$this->input->post('pr_id');
       $qty=$this->input->post('qty');
       $existing_stock=getAfield("available_stock","products","where pr_id =$pr_id AND is_deleted=0");
       if($existing_stock>=$qty)
       {
         $check_exist=getAfield("id","cart","where user_id =$userid AND product_id=$pr_id");
         $unit_rate=getAfield("selling_price","products","where pr_id =$pr_id");
         $total_amount=$unit_rate*$qty;
         $in_data=array(
           'user_id'=>$userid,
           'product_id'=>$pr_id,
           'qty'=>$qty,
           'unit_rate'=>$unit_rate,
           'total_amount'=>$total_amount
         );
         if($check_exist>0){
           $where=array('id'=>$check_exist);
           $ins=$this->user_api_model->update("cart",$in_data, $where);
         }
         else{
           $ins=$this->user_api_model->insert("cart",$in_data);
         }
          if($ins)
          {
            	 $this->response(array('status' => 200, 'message' => "Product Added to cart" ,'response'=>'' ), REST_Controller::HTTP_OK);
          }
          else{
             $this->response(array('status' => 410, 'message' => "Failed to add" ,'response'=>'' ), REST_Controller::HTTP_GONE);
          }
       }
       else{
           $this->response(array('status' => 409, 'message' => "No Stock available" ,'response'=>'' ), REST_Controller::HTTP_CONFLICT );
       }
     }
     else{
       $this->response(array('status' => 203, 'message' => 'Authentication Failed','response'=>''), REST_Controller::HTTP_NON_AUTHORITATIVE_INFORMATION );
     }
   }
   public function remove_from_cart_get()
   {
     if($userid=$this->check_user())
     {
        $pr_id=$this->input->get('pr_id');
        $where=array('product_id'=>$pr_id,'user_id'=>$userid);
        $ins=$this->user_api_model->delete("cart", $where);
        if($ins)
        {
             $this->response(array('status' => 200, 'message' => "Product Removed from cart" ,'response'=>'' ), REST_Controller::HTTP_OK);
        }
        else{
           $this->response(array('status' => 410, 'message' => "Failed to remove" ,'response'=>'' ), REST_Controller::HTTP_GONE);
        }
     }
     else{
       $this->response(array('status' => 203, 'message' => 'Authentication Failed','response'=>''), REST_Controller::HTTP_NON_AUTHORITATIVE_INFORMATION );
     }
   }
   public function get_from_cart_get()
   {
     if($userid=$this->check_user())
     {
        $products = $this->user_api_model->get_cart_products($userid);
        $response=$products->result();
        $rows=$products->num_rows();
        if($rows>0)
   		 {
   					 $this->response(array('status' => 200, 'message' => "Success" ,'response'=>$response ), REST_Controller::HTTP_OK);
   		 }
   		 else
   		 {
   				 $this->response(array('status' => 205, 'message' => "Cart Is Empty" ,'response'=>$response ), REST_Controller::HTTP_RESET_CONTENT );
   		 }
     }
     else{
        $this->response(array('status' => 203, 'message' => 'Authentication Failed','response'=>''), REST_Controller::HTTP_NON_AUTHORITATIVE_INFORMATION );
     }
   }
   public function add_address_post()
   {
     if($userid=$this->check_user())
     {
       $rawdata = file_get_contents("php://input");
       $content=json_decode($rawdata);
       if($content)
       {
         $count_address=getAfield("count(address_id)","user_address","where user_id=$userid");
         if($count_address==0)  $data['is_default']=1;
         $data['user_id']=$userid;
         $data['name'] =$content->name;
         $data['mobile_number'] =$content->mobile_number;
         $data['pincode'] =$content->pincode;
         $data['locality'] =$content->locality;
         $data['full_address'] =$content->full_address;
         $data['city_town'] =$content->city_town;
         $data['state_id'] =$content->state_id;
         $data['district_id'] =$content->district_id;
         $data['land_mark'] =$content->land_mark;
         $data['alternative_mobile'] =$content->alternative_mobile;
         $data['address_type'] =$content->address_type;

         $address_id=$content->address_id;
         $is_default=$content->is_default;
         if($is_default==1)
         {
           $data['is_default']=1;
           $updata=array('is_default'=>0);
           $where2=array('user_id'=>$userid);
           $ups= $this->user_api_model->update("user_address",$updata,$where2);
         }
         if($address_id>0)
         {
           $where=array('address_id'=>$address_id);
           $ins=  $this->user_api_model->update("user_address",$data,$where);
         }
         else{

            $ins=  $this->user_api_model->insert("user_address",$data);
         }

         if($ins)
         {
           $this->response(array('status' => 200, 'message' => "Success" ,'response'=>"" ), REST_Controller::HTTP_OK);
         }
         else{
              $this->response(array('status' => 410, 'message' => "Failed to add" ,'response'=>'' ), REST_Controller::HTTP_GONE);
         }
       }
       else{

       }

     }
     else{
       $this->response(array('status' => 203, 'message' => 'Authentication Failed','response'=>''), REST_Controller::HTTP_NON_AUTHORITATIVE_INFORMATION );
     }
   }
   public function get_address_get()
   {
     if($userid=$this->check_user())
     {
       $deafult_flag=$this->input->get("get_default");
       if(!$deafult_flag) $deafult_flag=0;
       $address = $this->user_api_model->get_address($userid,$deafult_flag);
       $response=$address->result();
       $rows=$address->num_rows();
       if($rows>0)
  		 {
  					 $this->response(array('status' => 200, 'message' => "Success" ,'response'=>$response ), REST_Controller::HTTP_OK);
  		 }
  		 else
  		 {
  				 $this->response(array('status' => 205, 'message' => "No items found" ,'response'=>$response ), REST_Controller::HTTP_RESET_CONTENT );
  		 }
     }
     else{
       $this->response(array('status' => 203, 'message' => 'Authentication Failed','response'=>''), REST_Controller::HTTP_NON_AUTHORITATIVE_INFORMATION );
     }
   }
   public function remove_address_get()
   {
     if($userid=$this->check_user())
     {
       $address_id=$this->input->get("address_id");
       if($address_id>0){
         $data=array('is_deleted'=>1);
         $where=array('address_id'=>$address_id,'user_id'=>$userid);
          $delete= $this->user_api_model->update("user_address",$data,$where);

          if($delete)
          {
            $count_of_default_address=getAfield("count(address_id)","user_address","where user_id=$userid AND is_default=1");
            if($count_of_default_address==0){
              // set a default
              $adres_id_update=getAfield("address_id","user_address","where user_id=$userid ORDER BY address_id  DESC LIMIT 1");
              if($adres_id_update>0){
                $updata=array('is_default'=>1);
                $where=array('address_id'=>$adres_id_update,'user_id'=>$userid);
                $ups= $this->user_api_model->update("user_address",$updata,$where);
              }
              $this->response(array('status' => 200, 'message' => "Success" ,'response'=>'' ), REST_Controller::HTTP_OK);
            }
            else{
              $this->response(array('status' => 200, 'message' => "Success" ,'response'=>'' ), REST_Controller::HTTP_OK);
            }
          }else{
              $this->response(array('status' => 410, 'message' => "Failed to delete" ,'response'=>'' ), REST_Controller::HTTP_GONE);
          }
       }
     }
     else{
       $this->response(array('status' => 203, 'message' => 'Authentication Failed','response'=>''), REST_Controller::HTTP_NON_AUTHORITATIVE_INFORMATION );
     }
   }
   public function set_default_address_get()
   {
     if($userid=$this->check_user())
     {
       $address_id=$this->input->get('address_id');
        if($address_id>0)
        {
          $updata=array('is_default'=>0);
          $where=array('user_id'=>$userid);
          $ups= $this->user_api_model->update("user_address",$updata,$where);
            if($ups)
            {
              $updata1=array('is_default'=>1);
              $where1=array('user_id'=>$userid,'address_id'=>$address_id,);
              $ups1= $this->user_api_model->update("user_address",$updata1,$where1);
                if($ups1)
                {
                  $this->response(array('status' => 200, 'message' => "Success" ,'response'=>'' ), REST_Controller::HTTP_OK);
                }
                else{
                    $this->response(array('status' => 410, 'message' => "Failed to add" ,'response'=>'' ), REST_Controller::HTTP_GONE);
                }
            }
        }
     }
     else{
        $this->response(array('status' => 203, 'message' => 'Authentication Failed','response'=>''), REST_Controller::HTTP_NON_AUTHORITATIVE_INFORMATION );
     }
   }
   public function place_order_post()
   {
    $response=array();
     if($userid=$this->check_user())
     {
       $address_id=$this->input->post('address_id');
       $payment_type=$this->input->post('payment_type');
       if(!$payment_type) $payment_type=1;
       // check is delivery available
       $pincode=getAfield("pincode","user_address","where address_id =$address_id");
       $chekDelivery=getAfield("PlaceID","places","where pincode ='$pincode' AND is_deleted=0 AND DisplayStatus=1");
        if($chekDelivery>0)
        {
          $state= getAfield("state_id","user_address","where address_id =$address_id");
          $cartRp= $this->user_api_model->get_cart_products($userid);
          $cart=$cartRp->result();
          $rows=$cartRp->num_rows();
            if($rows>0)
            {
              $ordercount=getAfield("count(order_master_id)","order_master","");
              $ordercount=$ordercount+1;
              $shipping_charge=getAfield("delivery_fee","places","where PlaceID  =$chekDelivery");
              $order_total=0;
              $order_date=date('Y-m-d');
              if($state!=1) $is_interstate=1; else $is_interstate=0;
              $orderNumber="MOBTRADOS-ORD-".$ordercount;
              $ins=array(
                'order_number'=>$orderNumber,
                'user_id'=>$userid,
                'address_id'=>$address_id,
                'place_id'=>$chekDelivery,
                'is_interstate'=>$is_interstate,
                'order_total'=>0,
                'discount'=>0,
                'shipping_charge'=>$shipping_charge,
                'order_placed_date'=>$order_date,
                'payment_type'=>$payment_type
              );
              $insrted_id=insertInDb("order_master",$ins);
                if($insrted_id)
                {
                  $ins_count=0;
                  foreach($cart as $key)
                  {
                    $product_id=$key->pr_id;
                    $unit_rate=$key->selling_price;
                    $qty=$key->cart_qty;
                    $total_amount=$unit_rate*$qty;
                    $tax_id=$key->tax_id;
                    /*************** TAX CALCULATION*************************/
                    $tax_value=getAfield("tax_value","tax_master","where id=$tax_id");
                    $taxable=$total_amount/(100+$tax_value);
                    $taxable_value=$taxable*100;
                    $tax_amnt=($tax_value/100)*$taxable_value;
                    if($is_interstate==1){
                        $igst=$tax_amnt;
                        $cgst=0;
                        $sgst=0;
                      }
                    else{
                      $igst=0;
                      $cgst=$tax_amnt/2;
                      $sgst=$cgst;
                    }
                  /***********************************************************/
                  $ins_child=array(
                    'order_master_id'=>$insrted_id,
                    'product_id'=>$product_id,
                    'unit_rate'=>$unit_rate,
                    'qty'=>$qty,
                    'total_amount'=>$total_amount,
                    'tax_id'=>$tax_id,
                    'tax_value'=>$tax_value,
                    'taxable_value'=>$taxable_value,
                    'tax_amount'=>$tax_amnt,
                    'cgst'=>$cgst,
                    'sgst'=>$sgst,
                    'igst'=>$igst
                  );
                    $insrted_child_id=insertInDb("order_child",$ins_child);
                    if($insrted_child_id)
                    {
                      $order_total=$order_total+$total_amount;
                      $ins_count++;
                       // stock decrease
                      $updateStock=$this->user_api_model->product_stock_updates('-',$qty,$product_id);

                    }

                  } // foreach child tb insertion
                    if($ins_count>0)
                    {
                      if($payment_type==2)
                      {
                        $razorpay_amount=$order_total+$shipping_charge;
                        $razorpay_amount=$razorpay_amount*100;
                        // razor pay
                        $razorApi = new Api(RAZOR_KEY, RAZOR_SECRET_KEY);
                         $razorpayOrder   = $razorApi->order->create([
                           'receipt'         => $insrted_id,
                           'amount'          => $razorpay_amount, // amount in the smallest currency unit
                           'currency'        => 'INR'// <a href="/docs/international-payments/#supported-currencies" target="_blank">See the list of supported currencies</a>.)
                           ]);

                          $razorpayOrderId = $razorpayOrder['id'];

                         // insert in transcation master
                         $tr_ins=array(
                           'order_master_id'=>$insrted_id,
                           'transaction_type'=>2,
                           'transcation_status'=>0,
                           'transaction_for'=>1,
                           'transaction_date'=>date('Y-m-d'),
                           'amount'=>$order_total,
                           'razor_pay_order_id'=>$razorpayOrderId
                         );
                         $ins_transcation=insertInDb("transactions",$tr_ins);
                      }
                      else{
                        // delete from cart
                        $car_delete_where=array('user_id'=>$userid);
                        $deleteCart=$this->user_api_model->delete("cart",$car_delete_where);
                      }
                      /////////////////////////////////
                        $ups_data=array(
                          'order_total'=>$order_total,
                          'no_items'=>$ins_count,
                          'transaction_id'=>$ins_transcation,
                          'payment_confirm'=>0,
                        );
                        $where=array('order_master_id'=>$insrted_id);
                        $ups=update("order_master",$ups_data, $where);
                        //////////////////////////////////////
                        $response=array(
                          'order_number'=>$orderNumber,
                          'transcation_id'=>$ins_transcation,
                          'order_master_id'=>$insrted_id,
                          'razorpay_order_id'=>$razorpayOrderId
                        );

                        $this->response(array('status' => 200, 'message' => "Your order will be arriving within 3 days" ,'response'=>$response,'razorpay_order_id'=>$razorpayOrderId ), REST_Controller::HTTP_OK);
                    }
                    else{
                        $this->response(array('status' => 410, 'message' => "Unable to save order child" ,'response'=>'' ), REST_Controller::HTTP_GONE);
                    }
                }
                else
                {
                    $this->response(array('status' => 410, 'message' => "Unable to save order master" ,'response'=>'' ), REST_Controller::HTTP_GONE);
                }
            }
            else{
               $this->response(array('status' => 205, 'message' => "Cart Is Empty" ,'response'=>$response ), REST_Controller::HTTP_RESET_CONTENT );
            }
        }
        else{
           $this->response(array('status' => 205, 'message' => "Unable to deliver in this undress" ,'response'=>$response ), REST_Controller::HTTP_RESET_CONTENT );
        }
     }
   }

   public function get_order_get()
   {
       if($userid=$this->check_user())
       {
         $order_list = $this->user_api_model->list_orders($userid);
         $response=$order_list->result();
         $rows=$order_list->num_rows();
         if($rows>0)
    		 {
    					 $this->response(array('status' => 200, 'message' => "Success" ,'response'=>$response ), REST_Controller::HTTP_OK);
    		 }
    		 else
    		 {
    				 $this->response(array('status' => 205, 'message' => "No items found" ,'response'=>$response ), REST_Controller::HTTP_RESET_CONTENT );
    		 }
       }
       else{
           $this->response(array('status' => 203, 'message' => 'Authentication Failed','response'=>''), REST_Controller::HTTP_NON_AUTHORITATIVE_INFORMATION );
       }
   }
   public function get_order_details_get()
   {
     if($userid=$this->check_user())
     {
       $order_master_id=$this->input->get("order_master_id");
       $order_list = $this->user_api_model->order_details($userid,$order_master_id);
       $rows=$order_list->num_rows();
       if($rows>0)
       {

         $cancel_flag=getAfield("order_cancel","order_master","where order_master_id = $order_master_id");
         if($cancel_flag==1)
         {
           $cancel_reason=getAfield("cancel_reason","order_cancellation","where order_master_id = $order_master_id");
         }
         else{
           $cancel_reason="";
           $cancel_flag=0;
         }

         $delivery_expected_time=getAfield("delivey_expected_time","order_master","where order_master_id = $order_master_id");
         $final_status=getAfield("order_status","order_master","where order_master_id = $order_master_id");
         $payment_confirm=getAfield("payment_confirm","order_master","where order_master_id = $order_master_id");
         $shipping_charge=getAfield("shipping_charge","order_master","where order_master_id = $order_master_id");

         $refund_status=getAfield("refund_status","order_master","where order_master_id = $order_master_id");
         if($refund_status==1) $refund_status_code="pending";
			  	else if($refund_status==2) $refund_status_code="processed";
		  		else if($refund_status==3) $refund_status_code="failed";
		  		else $refund_status_code="pending";

         $response['iscancelled']=$cancel_flag;
         $response['cancel_reason']=$cancel_reason;
         $response['refund_status']=$refund_status;
         $response['refund_status_code']=$refund_status_code;

         $response['delivey_expected_time']=$delivery_expected_time;
         $response['final_status']=$final_status;
         $response['payment_status']=$payment_confirm;
         $response['shipping_charge']=$shipping_charge;

        $response['order_child_data']=$order_list->result();
        $address_id=getAfield("address_id","order_master","where order_master_id = $order_master_id");
        $track_details=$this->user_api_model->track_order($order_master_id);
        $response['track_details']=$track_details->result();
        $address = $this->user_api_model->get_address($userid,0,$address_id,1);
        $response['address_details']=$address->row();

              $this->response(array('status' => 200, 'message' => "Success" ,'response'=>$response ), REST_Controller::HTTP_OK);
       }
       else
       {
        $response=array();
           $this->response(array('status' => 205, 'message' => "No items found" ,'response'=>$response ), REST_Controller::HTTP_RESET_CONTENT );
       }
     }
     else{
       $this->response(array('status' => 203, 'message' => 'Authentication Failed','response'=>''), REST_Controller::HTTP_NON_AUTHORITATIVE_INFORMATION );
     }
   }
   public function update_profile_post()
   {
     if($userid=$this->check_user())
     {
       $name=$this->input->post('name');
       $mobile_number=$this->input->post('mobile_number');
       $email=$this->input->post('email');
       $check_exit=getAfield("app_user_id","app_usres","where mobile_number='$mobile_number' AND app_user_id!=$userid");
       if($check_exit==0)
       {
         $update=array(
           'name'=>$name,
           'mobile_number'=>$mobile_number,
           'email'=>$email
         );
         $where=array('app_user_id'=>$userid);
         $ins=$this->user_api_model->update("app_usres",$update,$where);
         if($ins)
         {
            $this->response(array('status' => 200, 'message' => "Success" ,'response'=>'' ), REST_Controller::HTTP_OK);
         }
         else{
           $this->response(array('status' => 410, 'message' => "Unable to update" ,'response'=>'' ), REST_Controller::HTTP_GONE);
         }
       }
       else{
          $this->response(array('status' => 409, 'message' => "Mobile number alredy have another account" ,'HTTP_CONFLICT'=>'' ), REST_Controller::HTTP_GONE);
       }

     }
     else{
       $this->response(array('status' => 203, 'message' => 'Authentication Failed','response'=>''), REST_Controller::HTTP_NON_AUTHORITATIVE_INFORMATION );
     }
   }
   public function update_password_post()
   {
     if($userid=$this->check_user())
     {
       $response=array();
       $password=$this->input->post('password');
       $password=secretkeyGneration("encrypt",$password,$key="CImsdYkmPHnsfruypojkeER",$out=0);

         $dynamic_token= $this->user_api_model->random_num(12);

       $update=array(
         'password'=>$password,
         'token'=>$dynamic_token
       );
       $where=array('app_user_id'=>$userid);
       $ins=$this->user_api_model->update("app_usres",$update,$where);
       if($ins)
       {
         $tokenData['user_id'] = $userid;
         $tokenData['access_token'] = $dynamic_token;
         $jwtToken = $this->objOfJwt->GenerateToken($tokenData);
         $response['access_token']=$jwtToken;
          $this->response(array('status' => 200, 'message' => "Success" ,'response'=>$response ), REST_Controller::HTTP_OK);
       }
       else{
         $this->response(array('status' => 410, 'message' => "Unable to update" ,'response'=>'' ), REST_Controller::HTTP_GONE);
       }
     }
     else{
        $this->response(array('status' => 203, 'message' => 'Authentication Failed','response'=>''), REST_Controller::HTTP_NON_AUTHORITATIVE_INFORMATION );
     }
   }
   public function delete_user_get()
   {
     if($userid=$this->check_user())
     {
       $data=array('is_deleted'=>1);
       $where=array('app_user_id'=>$userid);
       $ins=$this->user_api_model->update("app_usres",$data,$where);
       if($ins)
       {
          $this->response(array('status' => 200, 'message' => "Success" ,'response'=>'' ), REST_Controller::HTTP_OK);
       }
       else{
         $this->response(array('status' => 410, 'message' => "Unable to delete" ,'response'=>'' ), REST_Controller::HTTP_GONE);
       }
     }
     else
     {
       $this->response(array('status' => 203, 'message' => 'Authentication Failed','response'=>''), REST_Controller::HTTP_NON_AUTHORITATIVE_INFORMATION );
     }
   }
   public function forgot_password_request_post()
   {
     $mobile_number=$this->input->post('mobile_number');
     $app_user_id=getAfield("app_user_id","app_usres","where mobile_number='$mobile_number' AND is_deleted=0 AND account_verified=1");
     if($app_user_id>0)
     {
       $response=array();
       // delete existing requests
       $del_where=array('user_id'=>$app_user_id);
       $del=$this->user_api_model->delete("forgot_password",$del_where);
       $otp= rand(100000, 999999);
       $str=rand();
       $string = md5($str);
       $token=secretkeyGneration("encrypt",$string,$key="CImsdYkmPHnsfruypojkeER",0);
       $ins_data=array(
         'user_id'=>$app_user_id,
         'otp'=>$otp,
         'forgot_pwd_token'=>$token
       );
       $ins=$this->user_api_model->insert("forgot_password",$ins_data);
        if($ins)
        {
          $sms_text="Your One Time Verfication Code for reset password is $otp";
          $sendotp=sendSms($mobile_number,$sms_text);
          $response['reset_token']=$token;
          $this->response(array('status' => 200, 'message'=>'OTP sent','response' => $response), REST_Controller::HTTP_OK);
        }
        else{
           $this->response(array('status' => 410, 'message' => "Failed to save" ,'response'=>'' ), REST_Controller::HTTP_GONE);
        }
     }
     else{
       	$this->response(array('status' => 400, 'message' => 'Invalid Mobile Number','response'=>''), REST_Controller::HTTP_BAD_REQUEST );
     }
   }
   public function reset_forgot_password_post()
   {
     $mobile_number=$this->input->post('mobile_number');
     $reset_token=$this->input->post('reset_token');
     $otp=$this->input->post('otp');
     $password=$this->input->post('password');
     $app_user_id=getAfield("app_user_id","app_usres","where mobile_number='$mobile_number' AND is_deleted=0 AND account_verified=1");
     if($app_user_id>0)
     {
       $get_reste_oken=getAfield("forgot_pwd_token","forgot_password","where user_id=$app_user_id");
       if (strcmp($get_reste_oken, $reset_token) != 0)
       {
           $this->response(array('status' => 203, 'message' => 'Invalid Attempt','response'=>''), REST_Controller::HTTP_NON_AUTHORITATIVE_INFORMATION );
       }
       else{
         $ext_otp=getAfield("otp","forgot_password","where user_id ='$app_user_id'");
         if($ext_otp==$otp)
         {
           $password=secretkeyGneration("encrypt",$password,$key="CImsdYkmPHnsfruypojkeER",$out=0);
           $up_data=array('password'=>$password); $where=array('app_user_id'=>$app_user_id);
           $update=$this->user_api_model->update("app_usres",$up_data,$where);
           if($update)
           {
             $del_where=array('user_id'=>$app_user_id);
             $del=$this->user_api_model->delete("forgot_password",$del_where);
             $this->response(array('status' => 200, 'message'=>'Success , Now try re-login','response' => ''), REST_Controller::HTTP_OK);
           }
           else{
             $this->response(array('status' => 410, 'message' => "Failed to verify" ,'response'=>'' ), REST_Controller::HTTP_GONE);
           }
         }
         else{
            $this->response(array('status' => 203, 'message' => 'Invalid OTP','response'=>''), REST_Controller::HTTP_NON_AUTHORITATIVE_INFORMATION);
         }
       }
     }
     else{
       $this->response(array('status' => 400, 'message' => 'Invalid Mobile Number','response'=>''), REST_Controller::HTTP_BAD_REQUEST );
     }
   }
   public function cancel_order_post()
   {
     if($userid=$this->check_user())
     {
       $order_master_id=$this->input->post('order_master_id');
       $qry="SELECT order_status,order_cancel,address_id,order_number,payment_type,transaction_id,payment_confirm,razorpay_payment_id FROM order_master where order_master_id ='$order_master_id' AND user_id=$userid";
       $qrry=$this->db->query($qry);
       $order_data=$qrry->row();

       $order_current_status=$order_data->order_status;
       $current_cancel_flag=$order_data->order_cancel;
        if($current_cancel_flag==0)
        {
            $is_cancel_available=getAfield("cancelation_step","app_settings","where id=1");
            if($order_current_status<=$is_cancel_available)
            {
              $reason=$this->input->post('cancel_reason');
              $ins_data=array(
                'order_master_id'=>$order_master_id,
                'cancel_reason'=>$reason,
                'cancellation_date'=>date('Y-m-d')
              );
              $ins=$this->user_api_model->insert("order_cancellation",$ins_data);
              if($ins)
              {
                 $refund_started_flag=0;
                $up_data=array('order_cancel'=>1);
                $where=array('order_master_id'=>$order_master_id);
                $update=$this->user_api_model->update("order_master",$up_data,$where);
                  if($update)
                  {
                      /*************REFUND*******/
                     $payment_type=$order_data->payment_type;
                     if($payment_type==2)
                     {
                         // if online
                         // check paymentstatus
                         $pay_status=$order_data->payment_confirm;
                         if($pay_status==1)
                         {
                             $razorpay_payment_id=$order_data->razorpay_payment_id;
                             if($razorpay_payment_id)
                             {
                                 // process refund
                                  $api = new Api(RAZOR_KEY, RAZOR_SECRET_KEY);
                                   try
                                   {
                                      $payment = $api->payment->fetch($razorpay_payment_id);
                                      $refund = $payment->refund();
                                      $refund_id=$refund->id;
                                    //   print_r($refund);
                                    //   echo  json_encode($refund);
                                    //   echo $refund; exit;
                                    //print_r($payment);
                            
                                   }
                                   catch(SignatureVerificationError $e){
                                      $response = 'failure' ;
                                      $refund = 'Razorpay Error : ' . $e->getMessage();
                                      $refund_id=0;
                                      //echo $error;
                                   }

                                   $refund_status=$this->razor_get_refund_status($refund_id);
                                   if($refund_status=="pending") $refund_status_code=1;
                                   else if($refund_status=="processed") $refund_status_code=2;
                                   else if($refund_status=="failed") $refund_status_code=3;
                                   /************INSERT IN REFUND TRANSACTIONS*************/
                                          $refund_ins=array(
                                            'order_id'=>$order_master_id,
                                              'razorpay_payment_id'=>$razorpay_payment_id,
                                              'razorpay_refund_id'=>$refund_id,
                                              'refund_status'=>$refund_status_code
                                          );
                                    $insrt_refund=$this->user_api_model->insert("refund_transactions",$refund_ins);
                                         
                                          /***********************************/
                                                  $refund_trans_ins_data=array(
                                                    'order_master_id'=>$order_master_id,
                                                    'update_type'=>1,
                                                    'refund_status'=>$refund_status_code,
                                                    'refund_transcation_id'=>$insrt_refund,
                                                    'razorpay_refund_id'=>$refund_id
                                                  );
                                        
                                                  $insert= insertInDb("refund_status_update",$refund_trans_ins_data);
                                            /*************************/
                                   /****************************************************/

                                     $ref_update_data=array(
                                         'refund_status'=>$refund_status_code,
                                         'razor_refund_id'=>$refund_id,
                                         'refund_transaction_id'=>$insrt_refund
                                       );
                                       $where=array('order_master_id'=>$order_master_id);
                                     $update_refund=$this->user_api_model->update("order_master",$ref_update_data,$where);
                             }
                         }
                         
                     }
                     
                     
                     
                       /*************END REFUND*******/
                       // stock increase
                       
                  $qry="SELECT product_id,qty FROM order_child WHERE order_master_id=$order_master_id";
                  $qrry=$this->db->query($qry);
                  foreach($qrry->result() as $key)
                  {
                    $c_product_id=$key->product_id;
                    $c_qty=$key->qty;
                    $updateStock=$this->user_api_model->product_stock_updates('+',$c_qty,$c_product_id);
                  }
                  
                    // order number
                    $order_number=$order_data->order_number;
                    $address_id=$order_data->address_id;
                    $customer_number=getAfield("mobile_number","user_address","where address_id =$address_id");
                    $sms_text="Your Order #$order_number has been cancelled, refund will process soon, if any payment made";
                    $sendotp=sendSms($customer_number,$sms_text);
                    $owner_mobile=getAfield("sms_mobile","software_profile","where id =1");
                    $sms_text="Order  #$order_number has been cancelled,check admin panel for more details";
                    $sendotp=sendSms($owner_mobile,$sms_text);
                    $this->response(array('status' => 200, 'message'=>'Order Cancelled sucssfully','response' => ''), REST_Controller::HTTP_OK);
                  }
              }
              else{
                 $this->response(array('status' => 410, 'message' => "Failed to cancel" ,'response'=>'' ), REST_Controller::HTTP_GONE);
              }
            }
            else{
              $this->response(array('status' => 410, 'message' => "You are not allowed to cancel this order" ,'response'=>'' ), REST_Controller::HTTP_GONE);
            }

        }else{
          $this->response(array('status' => 205, 'message' => "Order already canceled" ,'response'=>'' ), REST_Controller::HTTP_RESET_CONTENT );
        }
     }
     else{
       $this->response(array('status' => 203, 'message' => 'Authentication Failed','response'=>''), REST_Controller::HTTP_NON_AUTHORITATIVE_INFORMATION );
     }
   }
   public function add_review_post()
   {
     if($userid=$this->check_user())
     {
        $review_id=$this->input->post('id');
        $star_rating=$this->input->post('star_rating');
        $review_details=$this->input->post('review_details');
        $product_id=$this->input->post('product_id');

        $in_data=array(
          'user_id'=>$userid,
          'product_id'=>$product_id,
          'star_rating'=>$star_rating,
          'review_details'=>$review_details
        );
        if($review_id>0)
        {
          $where=array('id'=>$review_id);
          $ins=$this->user_api_model->update("product_rating",$in_data, $where);
        }
        else{
          $ins=$this->user_api_model->insert("product_rating",$in_data);
        }

        if($ins)
        {
             $this->response(array('status' => 200, 'message' => "Review added" ,'response'=>'' ), REST_Controller::HTTP_OK);
        }
        else{
           $this->response(array('status' => 410, 'message' => "Failed to add" ,'response'=>'' ), REST_Controller::HTTP_GONE);
        }
     }
     else{
       $this->response(array('status' => 203, 'message' => 'Authentication Failed','response'=>''), REST_Controller::HTTP_NON_AUTHORITATIVE_INFORMATION );
     }
   }

   public function complete_transaction_post()
   {
      // used for transaction finish
      if($userid=$this->check_user())
      {
        $rawdata = file_get_contents("php://input");
        $content=json_decode($rawdata);
           if($content)
           {
             $order_master_id=$content->order_master_id;
             $transaction_id=$content->transcation_id;
             $transaction_status=$content->transaction_status;

             $razorpay_payment_id=$content->razorpay_payment_id;
             $razorpay_signature=$content->razorpay_signature;
             $razorpay_order_id=$content->razorpay_order_id;
             $errortext=$content->errortext;

             $trans_update=array(
               'razorpay_signature'=>$razorpay_signature,
               'razorpay_payment_id'=>$razorpay_payment_id,
               'errortext'=>$errortext
             );

             if($transaction_status==1)
              {
                $trans_update['transcation_status']=1;
                
                $api = new Api(RAZOR_KEY, RAZOR_SECRET_KEY);
                try
                {
                  $attributes  = array(
                    'razorpay_signature'  =>$razorpay_signature,
                    'razorpay_payment_id' =>$razorpay_payment_id,
                    'razorpay_order_id'  =>$razorpay_order_id
                  );
                   $order  = $api->utility->verifyPaymentSignature($attributes);
                   // success just update flags and other data
                    
                    $trans_update['razorpay_signature']=$razorpay_signature;
                     $trans_update['razorpay_payment_id']=$razorpay_payment_id;
                   
                   $where_trans=array('transaction_id'=>$transaction_id);
                   $trans_ins=$this->user_api_model->update("transactions",$trans_update,$where_trans);
                   // CART DELETION///
                   $car_delete_where=array('user_id'=>$userid);
                   $deleteCart=$this->user_api_model->delete("cart",$car_delete_where);

                   $up_data=array(
                     'payment_confirm'=>1,
                     'razorpay_payment_id'=>$razorpay_payment_id
                   );
                   $where=array('order_master_id'=>$order_master_id);
                   $update=$this->user_api_model->update("order_master",$up_data,$where);
                   if($update)
                   {
                     $this->response(array('status' => 200, 'message' => "Success" ,'response'=>'' ), REST_Controller::HTTP_OK);

                   }
                   else{
                     $this->response(array('status' => 410, 'message' => "order_master update failed" ,'response'=>'' ), REST_Controller::HTTP_GONE);
                   }
                 }
                catch(SignatureVerificationError $e)
                {
                   $response = 'failure' ;
                   $error = 'Razorpay Error : ' . $e->getMessage();
                   $this->response(array('status' => 204, 'message' => "failed" ,'response'=>$error ), REST_Controller::HTTP_NO_CONTENT);
                 }

               }
              else{
                $trans_update['transcation_status']=2;
                // cancel order
                $ins_data=array(
                  'order_master_id'=>$order_master_id,
                  'cancel_reason'=>"Online Payment Failed",
                  'cancellation_date'=>date('Y-m-d')
                );
                $ins=$this->user_api_model->insert("order_cancellation",$ins_data);
                if($ins)
                {
                    $up_data=array(
                      'order_cancel'=>1,
                      'payment_confirm'=>2,
                    );
                    $where=array('order_master_id'=>$order_master_id);
                    $update=$this->user_api_model->update("order_master",$up_data,$where);
                    if($update)
                    {
                      // decrease stock
                      $qry="SELECT product_id,qty FROM order_child WHERE order_master_id=$order_master_id";
                      $qrry=$this->db->query($qry);
                      foreach($qrry->result() as $key)
                      {
                        $c_product_id=$key->product_id;
                        $c_qty=$key->qty;
                        $updateStock=$this->user_api_model->product_stock_updates('+',$c_qty,$c_product_id);
                      }
                      //update transcation status
                        $trans_update['transcation_status']=1;
                        $where_trans=array('transaction_id'=>$transaction_id);
                        $trans_ins=$this->user_api_model->update("transactions",$trans_update,$where_trans);
                        if($trans_ins)
                        {
                          $this->response(array('status' => 204, 'message' => "Success" ,'response'=>''), REST_Controller::HTTP_NO_CONTENT);
                        }
                        else{
                          $this->response(array('status' => 410, 'message' => "failed" ,'response'=>''), REST_Controller::HTTP_OK);
                        }
                      }
                      else{
                        $this->response(array('status' => 410, 'message' => "order_master update failed" ,'response'=>'' ), REST_Controller::HTTP_GONE);

                      }
                }
                else{
                  $this->response(array('status' => 410, 'message' => "order cancel insertion failed" ,'response'=>'' ), REST_Controller::HTTP_GONE);

                }
              }
           }
      }
      else{
        $this->response(array('status' => 203, 'message' => 'Authentication Failed','response'=>''), REST_Controller::HTTP_NON_AUTHORITATIVE_INFORMATION );
      }
   }

   public function razor_post()
   {
      $razorApi = new Api(RAZOR_KEY, RAZOR_SECRET_KEY);
      $razorpayOrder   = $razorApi->order->create([
        'receipt'         => 1,
        'amount'          => 100, // amount in the smallest currency unit
        'currency'        => 'INR'// <a href="/docs/international-payments/#supported-currencies" target="_blank">See the list of supported currencies</a>.)
        ]);
        $razorpayOrderId=$razorpayOrder->id;
        echo $razorpayOrderId;
   }
   public function razorSign_post()
   {
       $api = new Api(RAZOR_KEY, RAZOR_SECRET_KEY);
       try
       {
         $attributes  = array(
           'razorpay_signature'  => 'asdasdasdas',
           'razorpay_payment_id'  => 'pay_GgWe4TcBJpZizi' ,
           'razorpay_order_id' => 'order_GgWdlF4m27zaYM'
         );
          $order  = $api->utility->verifyPaymentSignature($attributes);

       }
       catch(SignatureVerificationError $e){
          $response = 'failure' ;
          $error = 'Razorpay Error : ' . $e->getMessage();
          echo $error;
       }

   }
   
   public function razorRefund_post()
   {
        $api = new Api(RAZOR_KEY, RAZOR_SECRET_KEY);
       try
       {
         $payment = $api->payment->fetch('pay_GjPHcrWeJbodjW');
       // $refund = $payment->refund();
        print_r($payment);

       }
       catch(SignatureVerificationError $e){
          $response = 'failure' ;
          $error = 'Razorpay Error : ' . $e->getMessage();
          echo $error;
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
            catch(SignatureVerificationError $e)
            {
            
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

   public function get_product_review_get()
   {
     $userid=$this->check_user();
     if(!$userid) $userid=0;
     $response=array();
     $product_id=$this->input->get('product_id');
     $average_star=getAfield('AVG(star_rating)',"product_rating","where product_id=$product_id");
     $list_rating = $this->user_api_model->get_rating($product_id,$userid);
     $response=$list_rating->result();
     $rows=$list_rating->num_rows();
     if($rows>0){
          $this->response(array('status' => 200, 'message' => "Success" ,'avg_star'=>$average_star,'response'=>$response ), REST_Controller::HTTP_OK);
    }
    else {
        $this->response(array('status' => 204, 'message' => "No Data Found" ,'response'=>$response ), REST_Controller::HTTP_NO_CONTENT );
    }
    
   }



   
}
