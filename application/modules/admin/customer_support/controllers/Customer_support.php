<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Customer_support extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('customer_support/Customer_support_m','support');
       // $this->load->model('Direct_Billing_m','billing');
    }

    public function refund_status()
    {
        $data['page'] = 'refund_status';
        $data['mainpage'] = 'customer_support';
        $data['page_title'] = 'Refund Status';
        $this->template->page_maker('customer_support/refund_status',$data);
    }
}