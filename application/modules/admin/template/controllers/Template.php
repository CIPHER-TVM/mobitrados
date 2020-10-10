<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template extends MX_Controller {

	public function page_maker($page,$data)
	{
		if(isset($_SESSION['roleid'])){
			$data['roleid']=$_SESSION['roleid'];
			$data['userid'] = $_SESSION['userid'];
			$data['user_type'] =$_SESSION['user_type'];
		}
		else{
			redirect('');
			return;
		}

			$this->load->view('page_maker_header',$data);
			$this->load->view('javafns');
			$this->load->view($page,$data);
			$this->load->view('page_maker_footer');
	}
	public function datatables()
		{
			$this->load->view('dataTable');
		}
	public function error404($data=NULL)
	{
		if(isset($_SESSION['roleid'])){
			$data['roleid']=$_SESSION['roleid'];
			$data['userid'] = $_SESSION['userid'];
			$data['user_type'] =$_SESSION['user_type'];
		}
		else{
			redirect('');
			return;
		}
			$this->load->view('page_maker_header',$data);
			$this->load->view('javafns');
			$this->load->view('404',$data);
			$this->load->view('page_maker_footer');
	}

}
