<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>User Request</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.3/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.3/bower_components/font-awesome/css/font-awesome.min.css') ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.3/bower_components/Ionicons/css/ionicons.min.css') ?>">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php //echo base_url('assets/AdminLTE-2.4.3/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.3/dist/css/AdminLTE.min.css') ?>">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
  folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.3/dist/css/skins/_all-skins.min.css')?>">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
 
  <!-- Morris chart -->
  <link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/morris/morris.css') ?>" rel="stylesheet" type="text/css" />
  <!-- jvectormap -->
  <link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/jvectormap/jquery-jvectormap-1.2.2.css') ?>" rel="stylesheet" type="text/css" />
  <!-- Date Picker -->
  <link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datepicker/datepicker3.css') ?>" rel="stylesheet" type="text/css" />
  <!-- Daterange picker -->
  <link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/daterangepicker/daterangepicker-bs3.css') ?>" rel="stylesheet" type="text/css" /> 
  <!-- bootstrap wysihtml5 - text editor -->
  <link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') ?>" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datatables/dataTables.bootstrap.css') ?>"/>
      <!-- Theme style -->

  <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
      <style>
        .example-modal .modal {
          position: relative;
          top: auto;
          bottom: auto;
          right: auto;
          left: auto;
          display: block;
          z-index: 1;
        }

        .example-modal .modal {
          background: transparent !important;
        }
        
        .transparant{
          border          : none !important;
          background-color: transparent !important;
        }

        .customers_a {
          font-family    : "Trebuchet MS", Arial, Helvetica, sans-serif;
          border-collapse: collapse;

        }

        .customers_a td, .customers_a th {
          border   : 0px solid #ddd;
          padding  : 2px;
          font-size: 14px;
        }

        .customers_a tr:nth-child(even){background-color: #f2f2f2;}

        .customers_a tr:hover {background-color: #ddd;}

        .customers_a th {
          border          : 1px solid #ddd;
          padding-top     : 1px;
          padding-bottom  : 1px;
          text-align      : left;
          background-color: #4CAF50;
          color           : white;
        }

        .customers {
          font-family    : "Trebuchet MS", Arial, Helvetica, sans-serif;
          border-collapse: collapse;

        }

        .customers td, .customers th {
          border   : 1px solid #ddd;
          padding  : 2px;
          font-size: 12px;
        }

        .customers tr:nth-child(even){background-color: #f2f2f2;}

        .customers tr:hover {background-color: #ddd;}

        .customers th {
          border          : 1px solid #ddd;
          padding-top     : 1px;
          padding-bottom  : 1px;
          text-align      : left;
          background-color: #4CAF50;
          color           : white;
        }
      </style>
</head>