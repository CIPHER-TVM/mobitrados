<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Order_management extends MY_Controller {

  public function __construct()
  {
    	parent::__construct();
      $this->load->model('Order_management_m','orders');
  }

  public function index()
  {
    $data['page'] = 'order_management';
    $data['mainpage'] = 'order_management';
    $data['page_title'] = 'Manage Orders';
    $this->template->page_maker('order_management/home',$data);
  }
public function counts_of_pendings()
  {
    if (!$this->input->is_ajax_request()) { exit('No direct script access allowed');}
    $orders_verify_pending=getAfield('count(order_master_id)',"order_master","where order_status=0 and order_cancel=0"); // order verification pending
    $orders_packing_pending=getAfield('count(order_master_id)',"order_master","where order_status=1 and order_cancel=0"); //  packing pending
    $orders_shipping_pending=getAfield('count(order_master_id)',"order_master","where order_status=2 and order_cancel=0"); // shipping pending
    $orders_delivery_pending=getAfield('count(order_master_id)',"order_master","where order_status=3 and order_cancel=0"); // delivery confirmation pending
    $data=array(
      'orders_confirm_pending'=>$orders_verify_pending,
      'orders_packing_pending'=>$orders_packing_pending,
      'orders_shipping_pending'=>$orders_shipping_pending,
      'orders_delivery_pending'=>$orders_delivery_pending
    );

    echo json_encode($data);
  }
  public function get_orders()
  {
    if (!$this->input->is_ajax_request()) { exit('No direct script access allowed');}
    $lstype=$this->input->post('lstype');
    $filldata = $this->orders->get_manage_orders($lstype);
    $i=1;
    $data=array();
    $del='<i class="fa fa-trash" aria-hidden="true" id="delete_data" style="color:#FFF;cursor:pointer"></i>';
    $data=$filldata->result();
    $output = array(
      "recordsTotal" => $filldata->num_rows(),
      "recordsFiltered" => $filldata->num_rows(),
      "data" => $data
  );
    echo json_encode($output);
  }
  public function get_order_details_child()
  {
    if (!$this->input->is_ajax_request()) { exit('No direct script access allowed');}
    $order_id=$this->input->post('order_id');
    $order_total=getAfield("order_total","order_master","where order_master_id=$order_id");
    $shipping_charge=getAfield("shipping_charge","order_master","where order_master_id=$order_id");
    $op="";
    $o_child = $this->orders->get_order_child($order_id);
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
    <td style="font-size:16px;font-weight:600;text-align:right;color:green">'.number_format($order_total,2).'</td>
    </tr>';
    if($shipping_charge>0)
    {
      $op.='<tr>
      <td colspan="4" align="right">Shipping Charge</td>
      <td style="font-size:16px;text-align:right">'.number_format($shipping_charge,2).'</td>
      </tr>
      <tr>
      <td colspan="4" align="right">Order Total</td>
      <td style="font-size:18px;font-weight:600;text-align:right">'.number_format($final_amount,2).'</td>
      </tr>
      ';
    }

    print $op;
  }
  public function update_order_status()
  {

		if (!$this->input->is_ajax_request()) { exit('No direct script access allowed');}
		$order_id=$this->input->post('order_id');
		$next_order_status=$this->input->post('next_order_status');
    $data=array();
    if($next_order_status==1)
    {
      // generate Bill
      $bill_id= $this->orders->generate_bill_numer($order_id);
      $bill_number=getAfield("bill_text","bill_number","where id=$bill_id");
      $deliverytime=$this->input->post('deliverytime');
      $data['bill_id']=$bill_id;
      $data['bill_number']=$bill_number;
      if($deliverytime)
      {
        $data['delivey_expected_time']=$deliverytime;
      }
    }

    if($next_order_status==4)
    {
      $payment_type=getAfield("payment_type","order_master","where order_master_id=$order_id");
      $order_amount=getAfield("sum(order_total+shipping_charge)","order_master","where order_master_id=$order_id");

      if($payment_type==1)
      {
        // insert transaction
        $tr_ins=array(
          'order_master_id'=>$order_id,
          'transaction_type'=>1,
          'transaction_for'=>1,
          'transaction_date'=>date('Y-m-d'),
          'amount'=>$order_amount
        );
        $ins=insertInDb("transactions",$tr_ins);
        $data['transaction_id']=$ins;
      }
    }

    $data['order_status']=$next_order_status;
		$where=array('order_master_id'=>$order_id,'order_cancel'=>0);
		$up=update("order_master",$data,$where);
		if($up)
		{
      $address_id=getAfield("address_id","order_master","where order_master_id=$order_id");

			$order_mobile=getAfield("mobile_number","user_address","where address_id =$address_id");
			$order_num=getAfield("order_number","order_master","where order_master_id=$order_id");

      $customer_id=getAfield("user_id","order_master","where order_master_id=$order_id");
			$order_email=getAfield("email","app_usres","where app_user_id=$customer_id");
		//	$deliver_name=getAfield("order_number","deliver_name","where order_master_id=$order_id");
			$sub = 'Order confirmed';
			if($next_order_status==1)
			{
				$sub = 'Order confirmed';
				$sms_text="Placed: Your  Order (#$order_num) has been confirmed by mobitrados. Go to order details for more information ";

			}
			else if($next_order_status==2)
			{
				$sub = 'Order packed';
				$sms_text="Packed :Your Order (#$order_num) has been packed, will be shipped soon. Go to order details for more information ";

			}
			else if($next_order_status==3)
			{
				$sub = 'Order shipped';
				$sms_text="Shipped: Your Order (#$order_num) has been shipped, will be delivered soon. Go to order details for more information ";

			}
			else if($next_order_status==4)
			{
        $sub = 'Order deliverd';
				$sms_text="Delivered: Your Order (#$order_num) has been delivered, if not contact the shop as soon as possible";

			}

      /****************STATUS UPDATION********************/


      /*************************************************/
      $ins_data=array(
        'order_master_id'=>$order_id,
        'status'=>$next_order_status,
        'status_text'=>$sub
      );
      $insrt=insertInDb("order_delivery_management",$ins_data);
  	  $sendsms=sendSms($order_mobile,$sms_text);
      SendMail($order_email,$sub,array('head'=>strtoupper($sub),'name'=>"Customer",'order_no'=>$order_num,'txt'=>$sms_text),'email/order_status');

			print 1;
		}
		else {
			print 2;
		}
  }
  public function generate_invoice()
  {
    $data['page'] = 'invoice';
    $data['mainpage'] = 'order_management';
    $data['page_title'] = 'Manage Orders';
    $this->template->page_maker('order_management/generate_invoice',$data);
  }
  public function get_ivoices()
  {
    if (!$this->input->is_ajax_request()) { exit('No direct script access allowed');}
    $from_date=$this->input->post('from_date');
    $date = DateTime::createFromFormat('d/m/Y', $from_date);
    $from_date=$date->format('Y-m-d');
    $to_date=$this->input->post('to_date');
    $date = DateTime::createFromFormat('d/m/Y', $to_date);
    $to_date=$date->format('Y-m-d');

    $order_status=$this->input->post('order_status');
    $data = array();
    $filldata = $this->orders->get_invoices($from_date,$to_date,$order_status);

        $data=$filldata->result();
        $output = array(
          "recordsTotal" => $filldata->num_rows(),
          "recordsFiltered" => $filldata->num_rows(),
          "data" => $data
      );
        echo json_encode($output);
  }
  public function print_invoice()
  {
      $order_id=$this->input->get('order_id');

      $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-P']);
      $mpdf->charset_in='UTF-8';
      $data=array();

      $order_details=$this->orders->get_order_master($order_id);
      if($order_details)
      {
        $address_details=$this->orders->get_address_details($order_details->address_id);
        $order_child=$this->orders->get_order_child_invoce($order_id);

        $tax_summery=$this->orders->tax_summery($order_id);

        $data['order_details']=$order_details;
        $data['order_child']=$order_child;
        $data['address_details']=$address_details;
        $data['order_id']=$order_id;
        $data['tax_summery']=$tax_summery;
        $html = $this->load->view('order_management/invoice_view',$data,true);
        $mpdf->WriteHTML($html);
        $mpdf->Output('invoice.pdf', 'I');// opens in browser
      }
      else{
        echo "oops! somthing wrong";
      }

  }
}
?>
