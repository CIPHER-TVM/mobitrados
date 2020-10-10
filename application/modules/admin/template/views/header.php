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
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin_template/plugins/noty/noty.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin_template/plugins/clockpicker/bootstrap-clockpicker.min.css">
<script src="<?php echo base_url() ?>assets/admin_template/plugins/noty/noty.min.js"></script>

<link rel="stylesheet" href="<?php echo base_url() ?>assets/admin_template/plugins/bootstrap-select/bootstrap-select.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/admin_template/dist/css/sidebar-blue.min.css" id="sidebar-css">

  <title><?php echo $page_title; ?></title>
</head>
<body>

<style>
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

<div id="ar_loader">
 <div class="loader_content">
 <div >

 <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>
 </div>
</div>
