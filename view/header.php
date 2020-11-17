<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">



  <title><?php echo $page_title; ?> | <?php echo config('app_name'); ?></title>

  <!-- Custom fonts for this template-->
  <?php Html::cssLink(assets_url('vendor/fontawesome-free/css/all.min.css')); ?>
  <?php Html::cssLink('https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i'); ?>
  <?php Html::cssLink(assets_url('css/sb-admin-2.min.css')); ?>

</head>

<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">


<?php View('sidebar'); ?>


    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      <?php View('nav'); ?>
      
      	<!-- Begin Page Content -->
        <div class="container-fluid">

          <?php alert_box(); ?>