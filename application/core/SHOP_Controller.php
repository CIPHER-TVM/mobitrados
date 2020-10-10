<?php
class MY_Controller extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $user = $this->session->userdata('username');
        if(!$user)
        {
          $redirects=admin_url();
          $redirects.="home";
          redirect($redirects);
        }
        	$this->load->module('template');
        //  $this->load->model('template/getmenus');

    }

  }
 ?>
