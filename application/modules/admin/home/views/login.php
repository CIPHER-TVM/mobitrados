<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Font & Icon -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <!-- Plugins -->
  <!-- CSS plugins goes here -->

  <!-- Main Style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin_template/dist/css/style.min.css" id="main-css">
  <link rel="stylesheet" href="#" id="sidebar-css">

  <title>ADMIN || LOGIN</title>
</head>

<body class="login-page" style="background-image:<?=base_url()?>assets/bg.jpg">

  <?php
  $atributes=array('id'=>'frm', 'name'=>'frm' ,'autocomplete'=>'off');
    echo form_open(ADMIN.'/home/admin_login',$atributes);
   ?>
  <div class="container pt-5">
    <div class="row justify-content-center">
      <div class="col-md-auto d-flex justify-content-center">
        <div class="card shadow-sm">
          <div class="card-body p-4">

            <!-- LOG IN FORM -->
            <h4 class="card-title text-center mb-0"> MOBI TRADOS <br> LOG IN</h4>
            <div class="text-center text-muted font-italic">to your account</div>
            <hr>

              <div class="form-group">
                <span class="input-icon">
                  <i class="material-icons">person_outline</i>
                  <input type="text" name="username" id="username" class="form-control" required="" placeholder="Your User Name" autocomplete="newpassword">

                </span>
              </div>
              <div class="form-group">
                <span class="input-icon">
                  <i class="material-icons">lock_open</i>
                  <input type="password" name="password" id="password" class="form-control" required="" placeholder="Password" autocomplete="newpassword">

                </span>
              </div>
              <div class="form-group d-flex justify-content-between align-items-center">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="remember">
                  <label class="custom-control-label" for="remember">Remember me</label>
                </div>
                <a href="#" class="text-primary text-decoration-underline small">Forgot password ?</a>
              </div>
              <button  class="btn btn-primary btn-block" type="submit">LOG IN</button>

            <hr>
            <span style="color:red">   <?php
              $er= $this->session->flashdata("error");
             echo $this->session->flashdata("error");
              if($er)
              {
              //  print '<script>alert("error")</script>';
              }
              ?>
            </span>

            <!-- /LOG IN FORM -->
            <hr>
            <p style="font-size:12px"><img src="<?=base_url()?>assets/cipher.png" width="15%"> Developed By : CIPHER TECHNOLOGIES </p>

          </div>
        </div>
      </div>
    </div>
  </div>
  </form>
  <!-- Main Scripts -->

  <!-- Plugins -->
  <!-- JS plugins goes here -->

</body>

</html>
