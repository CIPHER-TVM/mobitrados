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
    $data['cs']=120;
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



}
