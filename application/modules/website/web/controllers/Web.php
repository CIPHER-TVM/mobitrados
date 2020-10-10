<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Web extends MX_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function views($page = 'home',$data=array())
	{

		 if ((is_file(APPPATH . 'modules' . DS . 'website' . DS . 'web' . DS . 'views' . DS . $page . '.php'))) {
			$this->load->view('sections/header', $data);
			$this->load->view( $page, $data);
			$this->load->view('sections/footer');
		} else {
			$this->load->view('sections/header', $data);
			$this->load->view('404');
			$this->load->view('sections/footer');
		}
	}

}
