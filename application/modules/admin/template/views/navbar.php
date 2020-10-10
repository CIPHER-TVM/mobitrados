


  <!-- Navbar -->
  <nav class="navbar navbar-expand navbar-light fixed-top navbar-main">
    <div class="navbar-nav nav-circle">
      <a class="nav-link nav-icon" href="#" data-toggle="sidebar"><i class="material-icons">menu</i></a>
    </div>
    <ul class="navbar-nav nav-circle ml-auto">

    </ul>
    <ul class="navbar-nav nav-pills">
      <li class="nav-link-divider mx-2"></li>
      <li class="nav-item dropdown">
        <a class="nav-link has-img dropdown-toggle" href="#" data-toggle="dropdown">
				<?php

				$logo = base_url('uploads/').@$shop_logo;
				if(!@$shop_logo || !file_exists('./uploads/'.@$shop_logo)){
					$logo = base_url('assets/noimage.jpg');
				}

				?>
          <img src="<?=@$logo ?>" alt="Admin" class="rounded-circle mr-2">
          <span class="d-none d-sm-block"><?=@$ownersName?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right font-size-sm">
          <a class="dropdown-item has-icon pr-5 text-danger" href="<?php echo admin_url() ?>dashboard/logout"><i class="material-icons mr-2">exit_to_app</i> Logout</a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /Navbar -->
