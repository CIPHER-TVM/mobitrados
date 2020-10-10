<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MX_Controller {
/*	public function __construct(){
			$this->load->module('template');
		}
*/
	public function index()
	{
			$this->load->view('login');
	}
	public function admin_login()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username','User Name','required|max_length[50]|trim');
		$this->form_validation->set_rules('password','Password ','required|min_length[3]|max_length[30]');
		if($this->form_validation->run())
		{

			$username=$this->input->post('username');
			$password=$this->input->post('password');
			$this->load->model('login');
			$chk=$this->login->validate($username,$password);
			if($chk)
			{
				$uid=$chk['uid'];
				$roleid=$chk['role_id'];
				$username=$chk['name'];
				$user_type=$chk['user_type'];
				$lock_user=$chk['active_status'];
				if($lock_user==1)
				{
					$ip=$this->input->ip_address();
					$lgtime=date('Y-m-d H:i:s');
					$data = array(
					'uid' => $uid,
					'login_ip'=>$ip,
					'login_time'=>$lgtime
					);
					$this->db->insert('login_history', $data);
					$session_data= array(
						'username'=>$username,
						'roleid'=>$roleid,
						'userid'=>$uid,
						'user_type'=>$user_type
						);
						$this->session->set_userdata($session_data);
						redirect(ADMIN.'/dashboard');

				}
				else
				{
					$this->session->set_flashdata('error',"You dont have permision to access dashboard");
						$this->session->unset_userdata('account_user','userid','pid');
						$url=admin_url();
						$url.="home";
						redirect($url);
				}

			}
			else {

				$this->session->set_flashdata('error',"Invalid Username or Password");
				$this->session->unset_userdata('username','userid');
				$url=admin_url();
				$url.="home";
				redirect($url);
			}
		}
		else
		{
			$this->load->view('signin');
		}
	}
}
