<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends MY_Controller {
public function __construct()
{
	parent::__construct();

}
	public function index()
	{
  	$data['page'] = 'dashboard';
		$data['mainpage'] = '';
    $data['page_title'] = 'Dashboard';
		$data['orders_verify_pending'] =getAfield('count(order_master_id)',"order_master","where order_status=0 and order_cancel=0"); // order verification pending
		$data['orders_packing_pending'] =getAfield('count(order_master_id)',"order_master","where order_status=1 and order_cancel=0"); //  packing pending
		$data['orders_shipping_pending'] =getAfield('count(order_master_id)',"order_master","where order_status=2 and order_cancel=0"); // shipping pending
		$data['orders_delivery_pending'] =getAfield('count(order_master_id)',"order_master","where order_status=3 and order_cancel=0"); // delivery confirmation pending
		$this->template->page_maker('dashboard/home',$data);

		//$this->page_maker('dashboard/home', $data);
  }

public function logout()
  {
    $user_data = $this->session->all_userdata();
        foreach ($user_data as $key => $value)
         {
           $this->session->unset_userdata($key);
         }
    $this->session->sess_destroy();
		$url=admin_url();
		$url.="home";
		redirect($url);

  }

	public function chart_data()
	{
		  if (!$this->input->is_ajax_request()) { 	exit('No direct script access allowed');  }

			$type=$this->input->post('type');
			if($type==1)
			{
				$sunday = date( 'Y-m-d', strtotime( 'sunday previous week' ) );
				$saturday = date( 'Y-m-d', strtotime( 'saturday this week' ) );
				$qry="SELECT sum(order_total) as order_total,order_placed_date FROM order_master
							WHERE order_cancel=0 AND order_placed_date>='$sunday' AND order_placed_date<='$saturday' group by order_placed_date";
			}
			else 	if($type==2)
			{
				$year=date('Y');
				$qry="SELECT sum(order_total) as order_total,MONTH(order_placed_date) as order_placed_date FROM order_master
							WHERE order_cancel=0 AND
								(MONTH(order_placed_date)>='01' AND MONTH(order_placed_date)<='12') AND YEAR(order_placed_date)='$year'
							 group by MONTH(order_placed_date)";
			}


			$qrry=$this->db->query($qry);

			$labelsArray=array();
			$dataArray=array();

			foreach($qrry->result() as $key)
			{
				$order_total=$key->order_total;
				if($type==1)
				{
						$order_placed_date=$key->order_placed_date;
						$order_placed_date = date("d-m-Y D", strtotime($order_placed_date));
				}
				else 	if($type==2)
				{
						$order_placed_date=$key->order_placed_date;
						$order_placed_date = date("M", strtotime($order_placed_date));
				}

				array_push($labelsArray,$order_placed_date);
				array_push($dataArray,$order_total);
			}
			$dataset=array(
				'label'=>'Sales',
				'backgroundColor'=>'#a2d5f2',
				'borderColor'=>'#40a8c4',
				'fill'=>'start',
				'data'=>$dataArray
			);

			$out=array(
				'labels'=>$labelsArray,
				'datasets'=>$dataset,
			);
			echo json_encode($out);
	}

	public function get_customers()
	{
			$qry="SELECT name,mobile_number,email FROM app_usres  WHERE is_deleted=0 AND account_verified=1 ORDER BY app_user_id  DESC LIMIT 8";
			$qrry=$this->db->query($qry);
			$html="";
			foreach($qrry->result() as $key)
			{
				$name=$key->name;
				$mobile_number=$key->mobile_number;
				$email=$key->email;
				$sendname=urlencode(" Hai $name");
				$whastap_url="https://api.whatsapp.com/send?phone=+91$mobile_number&text=$sendname";
				$email_link="https://mail.google.com/mail/u/0/?view=cm&fs=1&to=$email&su=MOBI TRADOS WELCOMES YOU&body=Dear $name&tf=1";
				$html.='<li class="list-group-item d-flex align-items-center">
						<div class="media">
							<img src="'.base_url().'assets/admin_template/dist/img/user1.svg" alt="user" class="rounded-circle" width="40">
							<div class="media-body ml-2">
								<h6 class="font-size-sm mb-0">'.$name.'</h6>
								<span class="small text-muted">Mobile : '.$mobile_number.'</span>
							</div>
						</div>
						<div class="btn-group btn-group-sm ml-auto" role="group">
							<a href="javascript:void(0)" class="btn btn-text-secondary btn-icon rounded-circle shadow-none"><i class="material-icons">account_circle</i></a>
							<a href="'.$email_link.'"  target="_blank" class="btn btn-text-primary btn-icon rounded-circle shadow-none"><i class="material-icons">mail_outline</i></a>
							<a href="'.$whastap_url.'" target="_blank" class="btn btn-text-danger btn-icon rounded-circle shadow-none"><i class="material-icons">call</i></a>
						</div>
					</li>';
			}
			print $html;
	}

}
