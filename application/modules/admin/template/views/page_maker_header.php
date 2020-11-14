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
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin_template/plugins/jqvmap/jqvmap.min.css">

  <!-- Main Style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin_template/dist/css/style.min.css" id="main-css">
  <!-- <link rel="stylesheet" href="#" id="sidebar-css"> -->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/admin_template/dist/css/sidebar-blue.min.css" id="sidebar-css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin_template/plugins/noty/noty.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin_template/plugins/bootstrap-select/bootstrap-select.min.css">
  <title><?php echo $page_title; ?></title>
</head>
<body>
  <style>

  .card-loader {
    background-color: #fff;
    box-shadow: 0 1px 2px 1px rgba(0, 0, 0, 0.08), 0 -1px 3px 0 rgba(0, 0, 0, 0.06);

    position: relative;
    border-radius: 2px;
    margin-bottom: 0;
    overflow: hidden;
  }
  .card-loader:only-child {
    margin-top: 0;
  }
  .card-loader:before {
    content: '';
    display: block;
    background-color: #ededed;
    box-shadow: -48px 78px 0 -48px #ededed, -51px 102px 0 -51px #ededed;
  }
  .card-loader:after {
    content: '';
    background-color: #333;
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    animation-duration: 0.6s;
    animation-iteration-count: infinite;
    animation-name: loader-animate;
    animation-timing-function: linear;
    background: -webkit-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.6) 30%, rgba(255, 255, 255, 0) 81%);
    background: -o-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.6) 30%, rgba(255, 255, 255, 0) 81%);
    background: linear-gradient(to right, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.6) 30%, rgba(255, 255, 255, 0) 81%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00ffffff', endColorstr='#00ffffff',GradientType=1 );
  }

  @keyframes loader-animate {
    0% {
      transform: translate3d(-100%, 0, 0);
    }
    100% {
      transform: translate3d(100%, 0, 0);
    }
  }
  </style>
<style>
.star
{
  color:red;
}
#ar_loader .loader_content{
position: fixed;
top: 0;
bottom: 0;
left: 0;
right: 0;
background: white;
z-index: 9999;
display: flex;
align-items: center;
justify-content: center;
}

.lds-ellipsis {
  display: inline-block;
  position: relative;
  width: 80px;
  height: 80px;
}
.lds-ellipsis div {
  position: absolute;
  top: 33px;
  width: 13px;
  height: 13px;
  border-radius: 50%;
  background: #99d2ee;
  animation-timing-function: cubic-bezier(0, 1, 1, 0);
}
.lds-ellipsis div:nth-child(1) {
  left: 8px;
  animation: lds-ellipsis1 0.6s infinite;
}
.lds-ellipsis div:nth-child(2) {
  left: 8px;
  animation: lds-ellipsis2 0.6s infinite;
}
.lds-ellipsis div:nth-child(3) {
  left: 32px;
  animation: lds-ellipsis2 0.6s infinite;
}
.lds-ellipsis div:nth-child(4) {
  left: 56px;
  animation: lds-ellipsis3 0.6s infinite;
}
@keyframes lds-ellipsis1 {
  0% {
    transform: scale(0);
  }
  100% {
    transform: scale(1);
  }
}
@keyframes lds-ellipsis3 {
  0% {
    transform: scale(1);
  }
  100% {
    transform: scale(0);
  }
}
@keyframes lds-ellipsis2 {
  0% {
    transform: translate(0, 0);
  }
  100% {
    transform: translate(24px, 0);
  }
}


</style>
<style>
.overlay {
  background: rgb(2,0,36);
background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(2,2,31,1) 0%, rgba(19,89,103,1) 100%);
    display: none;        <- Not displayed by default
    position: absolute;   <- This and the following properties will
    top: 0;                  make the overlay, the element will expand
    right: 0;                so as to cover the whole body of the page
    bottom: 0;
    left: 0;
    opacity: 0.5;
    z-index: 9999999;
    text-align: center;
}
</style>
<div class="overlay">
    <div id="loading-img">Please wait...</div>
</div>
<div id="ar_loader">
 <div class="loader_content">
 <div >

 <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>
 </div>
</div>

  <?php
  $this->load->view('sidebar');
  $this->load->view('navbar');
   ?>
