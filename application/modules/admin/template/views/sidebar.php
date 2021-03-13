<style>
  .font-sm{
    font-size: 14px;
  }
</style>

  <!-- Sidebar -->
  <aside class="sidebar border-right">

    <!-- Sidebar header -->
    <div class="sidebar-header">
      <!-- Logo -->
      <a href="#" class="logo d-flex align-items-center">
			<i style="font-size : 22px;padding-right:6px" class="material-icons">home</i> MOBITRADOS
        <!-- <img src="<?=@base_url('uploads/').@$shop_logo ?>" alt="Logo" id="main-logo"> -->
          <!-- <img src="<?=@base_url('uploads/').@$shop_logo ?>" alt="Admin" class="rounded-circle mr-2"> -->
        <?=@$shopName?>
      </a>
      <a href="#" class="nav-link nav-icon rounded-circle ml-auto" data-toggle="sidebar">
        <i style="font-size : 19px" class="material-icons">close</i>
      </a>
    </div>

    <!-- Sidebar body -->
    <div class="sidebar-body">
      <!-- Menu -->
      <ul class="nav nav-sub mt-3 font-sm" id="menu">
        <li class="nav-item">
          <a class="nav-link has-icon " href="<?php echo admin_url() ?>dashboard"><i style="font-size : 19px" class="material-icons">dashboard</i>Dashboard</a>
				</li>

<li class="nav-item <?php if($mainpage == 'order_management') echo 'active' ?>">
  <a class="nav-link has-icon dropdown-toggle <?php if($page == 'order_management') echo 'active' ?>" href="#"><i style="font-size : 19px" class="material-icons">redeem</i>Order Management</a>
  <ul>
    <!-- <li><a href="<?php //echo base_url() ?>webuser/States">Add State</a></li>
    <li><a href="<?php //echo base_url() ?>webuser/districts">Add District</a></li> -->
      <li><a class="<?php if($page == 'order_management') echo 'active' ?>"  href="<?php echo admin_url() ?>order_management">Manage Orders</a></li>
      <li><a class="<?php if($page == 'invoice') echo 'active' ?>"  href="<?php echo admin_url() ?>order_management/generate_invoice">Print Invoice</a></li>
  </ul>
</li>



        <a class="nav-link has-icon <?php if($page == 'catagory') echo 'active' ?>" href="<?php echo admin_url() ?>category"><i style="font-size : 19px" class="material-icons">assignment</i>Manage Category</a>

          <li class="nav-item <?php if($page == 'localPlaces') echo 'active' ?>">
                  <a class="nav-link has-icon dropdown-toggle <?php if($page == 'localPlaces') echo 'active' ?>" href="#"><i style="font-size : 19px" class="material-icons">gps_fixed</i>Location Settings</a>
                  <ul>
                    <!-- <li><a href="<?php //echo base_url() ?>webuser/States">Add State</a></li>
                    <li><a href="<?php //echo base_url() ?>webuser/districts">Add District</a></li> -->
                    <li><a class="<?php if($mainpage == 'places') echo 'active' ?>"  href="<?php echo admin_url() ?>localPlaces">Add Place</a></li>
                  </ul>
                </li>

                <li class="nav-item <?php if($mainpage == 'master_settings') echo 'active' ?>">
                  <a class="nav-link has-icon dropdown-toggle <?php if($page == 'tax') echo 'active' ?>" href="#"><i style="font-size : 19px" class="material-icons">gps_fixed</i>Master Settings</a>
                  <ul>
                    <li><a class="<?php if($page == 'tax') echo 'active' ?>"  href="<?php echo admin_url() ?>master_settings/tax_master">Tax Settings</a></li>
                  </ul>
               </li>

               <li class="nav-item <?php if($mainpage == 'product_settings') echo 'active' ?>">
                 <a class="nav-link has-icon dropdown-toggle <?php if($page == 'add_product') echo 'active' ?>" href="#"><i style="font-size : 19px" class="material-icons">gps_fixed</i>Product Management</a>
                 <ul>
                   <li><a class="<?php if($page == 'add_product') echo 'active' ?>"  href="<?php echo admin_url() ?>manage_products/add_product">Add Product</a></li>
                   <li><a class="<?php if($page == 'add_stock') echo 'active' ?>"  href="<?php echo admin_url() ?>manage_products/add_stock">Add Stock</a></li>
                 </ul>
              </li>

              <li class="nav-item <?php if($mainpage == 'app_settings') echo 'active' ?>">
                <a class="nav-link has-icon dropdown-toggle <?php if($page == 'banner_upload') echo 'active' ?>" href="#"><i style="font-size : 19px" class="material-icons">mobile_screen_share</i>App Management</a>
                <ul>
                  <li><a class="<?php if($page == 'banner_upload') echo 'active' ?>"  href="<?php echo admin_url() ?>manage_app/banner_upload">Banner Upload</a></li>
                  <li><a class="<?php if($page == 'offers') echo 'active' ?>"  href="<?php echo admin_url() ?>manage_app/offers">Manage Offers</a></li>
                  <li><a class="<?php if($page == 'new_arrivals') echo 'active' ?>"  href="<?php echo admin_url() ?>manage_app/new_arrivals">New Arrivals</a></li>
                  <li><a class="<?php if($page == 'featured_products') echo 'active' ?>"  href="<?php echo admin_url() ?>manage_app/featured_products">Fetured Products</a></li>
                  <li><a class="<?php if($page == 'terms_conditions') echo 'active' ?>"  href="<?php echo admin_url() ?>manage_app/terms_conditions">Terms & Conditions</a></li>
                </ul>
             </li>
             <a class="nav-link has-icon <?php if($page == 'c_stock') echo 'active' ?>" href="<?php echo admin_url() ?>reports/current_stock"><i style="font-size : 19px" class="material-icons">book</i>Current Stock Report</a>

               <li class="nav-item <?php if($mainpage == 'sales_report') echo 'active' ?>">
                 <a class="nav-link has-icon dropdown-toggle <?php if($page == 'sales_report') echo 'active' ?>" href="#"><i style="font-size : 19px" class="material-icons">book</i>Sales Report</a>
                 <ul>
                   <li><a class="<?php if($page == 'basic_sales') echo 'active' ?>"  href="<?php echo admin_url() ?>reports/basic_sales_report">Basic Sales Report</a></li>
                    <li><a class="<?php if($page == 'sales_report') echo 'active' ?>"  href="<?php echo admin_url() ?>reports/product_sales_report">Produt Wise Sales Report</a></li>
                 </ul>
              </li>

              <li class="nav-item <?php if($mainpage == 'sales_report') echo 'active' ?>">
                <a class="nav-link has-icon dropdown-toggle <?php if($page == 'billing') echo 'active' ?>" href="#"><i style="font-size : 19px" class="material-icons">calculate</i>Direct Billing</a>
                <ul>
                    <li><a class="<?php if($page == 'billing') echo 'active' ?>"  href="<?php echo admin_url() ?>directbilling/index">Billing</a></li>
                    <li><a class="<?php if($page == 'manage_bill') echo 'active' ?>"  href="<?php echo admin_url() ?>directbilling/manage_bills">Manage Bills</a></li>
                   <li><a class="<?php if($page == 'direct_bill_report') echo 'active' ?>"  href="<?php echo admin_url() ?>directbilling/sales_report">Basic Sales Report</a></li>
                </ul>
             </li>

             <li class="nav-item <?php if($mainpage == 'customer_support') echo 'active' ?>">
                 <a class="nav-link has-icon dropdown-toggle " href="#"><i style="font-size : 19px" class="material-icons">gps_fixed</i>Customer Support</a>
                 <ul>
                   <li><a class="<?php if($page == 'refund_status') echo 'active' ?>"  href="<?php echo admin_url() ?>customer_support/refund_status">Refund Status</a></li>
                   </ul>
              </li>
      </ul>
      <!-- /Menu -->
    </div>
    <!-- /Sidebar body -->

  </aside>
  <!-- /Sidebar -->
