<?php
class MY_Controller extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $user = $this->session->userdata('username');
        $shopuser = $this->session->userdata('is_shopuser_loggedin');
				// session_destroy();
				$module = $this->router->fetch_module();
				$current_back_key = $this->uri->segment(1);

				if($user) {
					if(($current_back_key != ADMIN) || (!ismodule_present($module , 1))) {
						redirect(admin_url());
					}
					$this->load->module('template');
					return;
				}
				// else{
        //   redirect($redirects);
				// }


				if($shopuser) {
					if(($current_back_key != USER) || (!ismodule_present($module , 3))) {
						redirect(shop_url());
						$this->load->module('shop_template');
					}
				}
				else{
					if($current_back_key == USER) { redirect(shop_url()); }
					if($current_back_key == ADMIN) { redirect(admin_url()); }
          redirect(site_url());
				}

        	$this->load->module('template');
        	$this->load->module('shop_template');
        //  $this->load->model('template/getmenus');

    }

  }
 ?>
