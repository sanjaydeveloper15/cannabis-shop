<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="keywords" content="" />
      <meta name="description" content="" />
      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <!-- FAVICONS ICON --> 
      <link rel="icon" href="{{asset('public/admin/assets/images/logo.png')}}" type="image/x-icon" />
      <link rel="shortcut icon" type="image/x-icon" href="assets/images/logo.png" />
      <!-- PAGE TITLE HERE -->
      <title>{{ config('app.name', 'Laravel') }} - Admin</title>
      <!-- MOBILE SPECIFIC -->
      <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1">
      <!--[if lt IE 9]>
      <script src="js/html5shiv.min.js"></script>
      <script src="js/respond.min.js"></script>
      <![endif]-->
      <!-- STYLESHEETS -->
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;800&display=swap" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="{{asset('public/admin/assets/css/plugins.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('public/admin/assets/css/custom.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('public/admin/assets/css/panel.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('public/admin/assets/css/admin.css')}}">
      <style type="text/css">
         .list-unstyled li a img {width: 30px; height: 30px;}
         .swal2-popup{
             border-radius: 25px!important;
         }
         .category-manage .text-center h5{
            font-size: 18px;
            font-weight: 400;
            padding: 10px 3px 10px 3px;
            text-transform: capitalize;
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
         }
      </style>
   </head>
   <body>