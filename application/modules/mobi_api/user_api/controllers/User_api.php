<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . '/libraries/CreatorJwt.php';

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
            $this->response(array('status' => 200, 'message'=>'Login Success','response' => $response), REST_Controller::HTTP_OK);
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
       $user_token=getAfield("token","app_usres","where app_user_id =$user_id");
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
          $this->response(array('status' => 200, 'message' => "Success" ,'response'=>$profile ), REST_Controller::HTTP_OK);
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
           $ins=  $this->user_api_model->update("user_address",$data);
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
         $where=array('address_id'=>$address_id,'user_id'=>$userid);
         $delete= $this->user_api_model->delete("user_address",$where);
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
     if($userid=$this->check_user())
     {
       $address_id=$this->input->post('address_id');
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
                'order_placed_date'=>$order_date
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
                      // CART DELETION///
                      $car_delete_where=array('user_id'=>$userid,'product_id'=>$product_id);
                      $deleteCart=$this->user_api_model->delete("cart",$car_delete_where);
                    }

                  } // foreach child tb insertion
                    if($ins_count>0)
                    {
                      /////////////////////////////////
                        $ups_data=array(
                          'order_total'=>$order_total,
                          'no_items'=>$ins_count
                        );
                        $where=array('order_master_id'=>$insrted_id);
                        $ups=update("order_master",$ups_data, $where);
                        //////////////////////////////////////


                        $this->response(array('status' => 200, 'message' => "Success" ,'response'=>'' ), REST_Controller::HTTP_OK);
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

}
