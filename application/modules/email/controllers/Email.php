<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Email extends MX_Controller
{
  public function __construct()
	{
		parent::__construct();
	}

	public function index($otp='123')
	{
		$this->load->helper('mail');

		$data = array(
			'head' => 'OTP VERIFICATION',
			'name' => 'Arun r',
			'otp'=>123
		);
		SendMail('arunrk818@gmail.com','OTP VERIFICATION',$data,'email/otp');
	}

	public function test($otp='123')
	{
		$data = array(
			'head' => 'OTP VERIIFCATION',
			'name' => 'Arun r',
			'otp'=>123
		);
		$this->load->view('email/header',$data);
		$this->load->view('email/otp',$data);
		$this->load->view('email/footer',$data);
	}

}
