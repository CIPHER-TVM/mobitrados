<?php
class MY_Controller extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        // session_destroy();
        $user = $this->session->userdata('username');
        if (!$user) {
            $redirects = admin_url();
            redirect($redirects);
        }
        $this->load->module('template');
    }
}

class ShopUser_Controller extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $shopuser = $this->session->userdata('is_shopuser_loggedin');
        if (!$shopuser) {
            $redirects = shop_url();
            redirect($redirects);
        }
        $this->load->module('shop_template');
        $this->load->module('file_uploader');
    }
}
