<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH."libraries/razorpay/Razorpay.php");
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

class Customer_support extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('customer_support/Customer_support_m','support');
        $this->load->model('order_management/Order_management_m','orders');
       // $this->load->model('Direct_Billing_m','billing');
    }

    public function refund_status()
    {
        $data['page'] = 'refund_status';
        $data['mainpage'] = 'customer_support';
        $data['page_title'] = 'Refund Status';
        $this->template->page_maker('customer_support/refund_status',$data);
    }

    public function get_cancelled_orders()
    {
        $search_item=$this->input->post('search_item');
        if($search_item)
        {
            $qry="SELECT om.order_master_id,om.order_number,om.user_id,om.order_total,om.no_items,om.razor_refund_id,om.order_cancel,
                om.order_placed_date,oc.cancellation_date,oc.cancel_reason,
                au.name,au.mobile_number, au.email
                FROM order_master om  
                INNER JOIN app_usres au on au.app_user_id =om.user_id
                INNER JOIN order_cancellation oc on oc.order_master_id=om.order_master_id
                where om.payment_type=2 AND om.order_cancel=1 AND om.payment_confirm=1
                AND ( (om.order_number LIKE '%$search_item%') OR (au.mobile_number LIKE '%$search_item%') OR (au.email LIKE '%$search_item%') )
                ORDER BY om.order_master_id DESC LIMIT 15
            ";

            $qrry=$this->db->query($qry);
            $html="";
            foreach($qrry->result() as $key)
            {
                $name=$key->name;
				$mobile_number=$key->mobile_number;
                $order_number=$key->order_number;
				$email=$key->email;
                $order_master_id=$key->order_master_id;
				$sendname=urlencode(" Hai $name");
				$whastap_url="https://api.whatsapp.com/send?phone=+91$mobile_number&text=$sendname";
				$email_link="https://mail.google.com/mail/u/0/?view=cm&fs=1&to=$email&su=MOBI TRADOS WELCOMES YOU&body=Dear $name&tf=1";
				$html.='<li class="list-group-item d-flex align-items-center">
						<div class="media">
							<img src="'.base_url().'assets/admin_template/dist/img/user1.svg" alt="user" class="rounded-circle" width="40">
							<div class="media-body ml-2">
								<h6 class="font-size-sm mb-0">'.$name.' </h6>
                                <h6 class="font-size-sm mb-0"></h6> '.$order_number.'</h6><br>
								<span class="small text-muted">Mobile : '.$mobile_number.'</span>
							</div>
						</div>
						<div class="btn-group btn-group-sm ml-auto" role="group">
							<a href="javascript:void(0)" onclick="loadOrderDetails('.$order_master_id.')" class="btn btn-text-danger btn-icon rounded-circle shadow-none"><i class="material-icons">remove_red_eye</i></a>
							<a href="'.$email_link.'"  target="_blank" class="btn btn-text-primary btn-icon rounded-circle shadow-none"><i class="material-icons">mail_outline</i></a>
							<a href="'.$whastap_url.'" target="_blank" class="btn btn-text-danger btn-icon rounded-circle shadow-none"><i class="material-icons">call</i></a>
						</div>
					</li>';
            }
            echo $html;
        }
    }
    public function get_refund_details()
    {
        $ord_id=$this->input->post('ord_id');
        $qry="SELECT om.order_master_id,om.order_number,om.user_id,om.order_total,om.no_items,om.razor_refund_id,om.order_cancel,
        om.order_placed_date,om.refund_status,oc.cancellation_date,oc.cancel_reason,
        au.name,au.mobile_number, au.email
        FROM order_master om  
        INNER JOIN app_usres au on au.app_user_id =om.user_id
        INNER JOIN order_cancellation oc on oc.order_master_id=om.order_master_id
        where om.order_master_id=$ord_id
         ";

        $qrry=$this->db->query($qry);
        $html="<div style='padding:10px 10px 10px 10px'>";
        $result=$qrry->row();
        
        $date= $result->order_placed_date;
        $orddate = date("d-m-Y", strtotime($date));
        $html.="Ord No : $result->order_number <br>
                <span style='font-size:14px'>Ord Date :  $orddate </span> <br>
                <span style='font-size:11px'> Mob No  : $result->mobile_number </span><br>
                ";
        
        /*********************ORDER CHILD************************************* */
        $order_total=getAfield("order_total","order_master","where order_master_id=$ord_id");
        $shipping_charge=getAfield("shipping_charge","order_master","where order_master_id=$ord_id");
        $op='<table class="table table-borderd">
        <thead>
        <tr><td colspan="5" align="center">Order Items</td></tr>
          <tr>
            <th>Sl No</th>
            <th>Product</th>
            <th>qty</th>
            <th align="right">Unit Price</th>
            <th align="right">Total</th>
          </tr>
        </thead><tbody>';
        $o_child = $this->orders->get_order_child($ord_id);
        $o_child_data=$o_child->result();
    
        $i=0;
        foreach($o_child_data as $key)
        {
          $i++;
          $unit_rate=$key->unit_rate;
          $total_price=$key->total_amount;
          $product_id=$key->product_id;
          $product_name=getAfield("product_name","products","where pr_id=$product_id");
          $qty=$key->qty;
          $op.='
          <tr>
            <td>'.$i.' </td>
            <td><b>'.$product_name.'</b></td>
            <td>'.$qty.' </td>
            <td align="right">'.number_format("$unit_rate",2).' </td>
            <td align="right"><b>'.number_format($total_price,2).'</b> </td>
          </tr>
          ';
        }
        $final_amount=$shipping_charge+$order_total;
        $op.='
        <tr>
        <td colspan="4" align="right">Bill Amount</td>
        <td style="font-size:14px;font-weight:600;text-align:right;color:green">'.number_format($order_total,2).'</td>
        </tr>';
        if($shipping_charge>0)
        {
          $op.='<tr>
          <td colspan="4" align="right">Shipping Charge</td>
          <td style="font-size:14px;text-align:right">'.number_format($shipping_charge,2).'</td>
          </tr>
          <tr>
          <td colspan="4" align="right">Order Total</td>
          <td style="font-size:15px;font-weight:600;text-align:right">'.number_format($final_amount,2).'</td>
          </tr>
          ';
        }
        $op.='<tbody id="pr_child_data2">
            </tbody>
     </table>';

     $html.=$op;
        /***************************END**********************************************/
        $cancellation_date=$result->cancellation_date;
        $cancel_reason=$result->cancel_reason;
        $date= $result->cancellation_date;
        $cancellation_date = date("d-m-Y", strtotime($cancellation_date));

        $refund_status=$result->refund_status;
        $color="";
        $status="";
        if($refund_status==1) 
        {
         $color="blue";
         $status="Proccessing";
        }  
        else if($refund_status==2)
        {
            $color="green";  
            $status="Refund Success";
        } 
        else if($refund_status==3){
            $status="failed";
            $color="red"; 
        } 
       
        $html.="<hr>";
        $html.="<p style='color:red'>
            Cancel Date : <b>$cancellation_date</b> <br>
            Cancel Reason : <b>$cancel_reason</b> <br>
            Refund Status : <b style='color:$color'>$status</b>
        </p>";

        /**************REFUND STATUS UPDATES ******************* */
            $ref_tablle='<table class="table table-borderd">
            <thead>
            <tr><td colspan="5" align="center">Refund Status History</td></tr>
              <tr>
                <th>Sl No</th>
                <th>Refund Id</th>
                <th>Update Date</th>
                <th>Refund Status</th>
              </tr>
            </thead><tbody>';
            $ref_qry="SELECT * FROM refund_status_update WHERE order_master_id=$ord_id order by id asc";
            $ref_qrry=$this->db->query($ref_qry);
            $sl=0;
            foreach($ref_qrry->result() as $elem)
            {
                $sl++;
                $rez_refund_status=$elem->refund_status;
                $color="";
                $status="";
                if($rez_refund_status==1) 
                {
                 $color="blue";
                 $status="Proccessing";
                }  
                else if($rez_refund_status==2)
                {
                    $color="green";  
                    $status="Refund Success";
                } 
                else if($rez_refund_status==3){
                    $status="failed";
                    $color="red"; 
                } 

                $ref_tablle.="<tr>
                    <td>$sl</td>
                    <td>$elem->razorpay_refund_id</td>
                    <td>$elem->created_date</td>
                    <td><b style='color:$color'>$status</b></td>
                </tr>";
            }
            $ref_tablle.="</tbody></table>";
            $html.=$ref_tablle;
           /*****************************************************/ 
           if($refund_status!=2) // make it 1 if need to test
           {
            $html.="<button type='button' class='btn btn-warning' onclick='checkRefundupdate($ord_id)'>Check For Updates</button>";
           }
           
        $html.="</div>";
        echo $html;
    }

    public function update_refund_status()
    {
        $order_id=$this->input->post('ord_id');
        if($order_id)
        {
            $qry="SELECT order_master_id,order_number,user_id,address_id,razor_refund_id,refund_transaction_id,refund_status FROM
			order_master WHERE   razor_refund_id!='' AND order_master_id=$order_id";
            //refund_status!=2 AND
            $qrry=$this->db->query($qry);
            $row=$qrry->row();

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