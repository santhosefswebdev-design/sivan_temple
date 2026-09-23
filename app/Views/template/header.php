<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <title>
    <?php echo $_SESSION['site_title']; ?>
  </title>
  <!--<link rel="icon" href="favicon.ico" type="image/x-icon">-->
  <?php
  if ($_SESSION['language'] == "english") {
    ?>
    <style>
      .navbar1 .links li a {
        font-size: 15px !important;
      }

      .navbar1 .links li {
        min-width: 35px !important;
      }
    </style>
    <?php
  }
  if ($_SESSION['language'] == "tamil") {
    ?>
    <style>
      .navbar1 .links li a {
        font-size: 13px !important;
      }

      .navbar1 .links li {
        min-width: 35px !important;
      }
    </style>
    <?php
  }
  ?>
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&amp;subset=latin,cyrillic-ext" rel="stylesheet"
    type="text/css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url(); ?>/assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>/assets/plugins/node-waves/waves.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>/assets/plugins/animate-css/animate.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>/assets/plugins/morrisjs/morris.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>/assets/css/style.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>/assets/css/themes/all-themes.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>/assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css"
    rel="stylesheet">
  <script src="<?php echo base_url(); ?>/assets/jquery.min.js"></script>
  <link href="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
  <script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
  <link href="<?php echo base_url(); ?>/assets/checkbox.css" rel="stylesheet" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/ui_jquery/jquery-ui.css">
<script src="<?php echo base_url(); ?>/assets/ui_jquery/jquery-ui.js"></script>
<script src="<?php echo base_url(); ?>/assets/ui_jquery/moment.min.js"></script>
</head>
<style>
  @media screen and (min-width: 767px) and (max-width: 992px) {
    .section.content {
      margin: 100px auto 65px !important;
    }

  }

  @media screen and (min-width: 320px) and (max-width: 767px) {
    .section.content {
      margin: 100px auto 65px !important;
    }

  }

  body:fullscreen {
    overflow: scroll !important;
  }

  body:-ms-fullscreen {
    overflow: scroll !important;
  }

  body:-webkit-full-screen {
    overflow: scroll !important;
  }

  body:-moz-full-screen {
    overflow: scroll !important;
  }

  .btn:not(.btn-link):not(.btn-circle) i {
    font-size: 16px !important;
  }

  .btn-rad {
    border-radius: 50% !important;
  }

  .alert {
    padding: 8px;
    background-color: #f44336;
    color: white;
  }

  .suc-alert {
    padding: 8px;
    background-color: #368e00;
    color: white;
  }

  .closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
  }

  .closebtn:hover,
  .suc-closebtn:hover {
    color: black;
  }

  .suc-closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
  }

  .show-tick {
    padding: 0px 0 !important;
  }

  .table {
    width: 100% !important;
  }

  .table tr th {
    background: #a1a09f !important;
    color: #FFFFFF !important;
  }

  .table tr th:first-child {
    width: 5%;
  }

  .btn-lg,
  .btn-group-lg>.btn {
    padding: 10px 15px !important;
  }

  footer {
    background: #FFFFFF;
    padding: 10px;
    text-align: center;
    margin-top: 20px;
  }

  .ls-closed .navbar-brand {
    margin-left: 5px;
  }

  .modal-content {
    width: 100% !important;
  }

  .btn {
    padding: 8px 12px !important;
  }

  .table-responsive {
    overflow-x: hidden !important;
  }




  .navbar>.container .navbar-brand,
  .navbar>.container-fluid .navbar-brand {
    margin-left: 5px;
    width: 100%;
  }

  .navbar-brand {
    padding: 15px 0px;
  }

  /* section.content {
    margin: 65px auto 65px !important;
  } */

  table.table-bordered.dataTable tbody th,
  table.table-bordered.dataTable tbody td {
    white-space: nowrap;
  }

  .table tr th,
  .table tr td {
    white-space: nowrap;
  }

  .form-group .form-line {
    margin-bottom: 15px;
  }

  .table-responsive {
    overflow-x: auto !important;
  }


  .form-group .form-line.focused .form-label {
    top: -14px;
  }


  .push:focus {
    outline: none;
  }

  .push i {
    line-height: 1.3;
    font-size: 14px;
    font-weight: bold;
  }

  .push {
    cursor: pointer;
    font-weight: bold;
    transition: all 0.3s;
    padding: 10px 15px;
    margin: 5px 10px;
    background-image: linear-gradient(to right, #cbe50f, #f7ff44, #eedd68, #b3da53);
    border: none;
    color: #000;
    border-radius: 8px;
    box-shadow: 0 4px 0 rgba(0, 0, 0, 0.25),
      0 4px 0 rgba(218, 79, 73, 1),
      0 4px 6px rgba(0, 0, 0, 0.45);
  }

  .push:hover {
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.45);
    transform: translateY(4px);
    transition: all 0.2s;
    text-decoration: none;
  }

  .push:active {
    background-color: #d14141;
    padding: 5px 15px;
    transition: none;
    /* So when you tap, effect is instant */
    padding: 0;
    /* Firefox adds padding because it's a special sausage */
  }

  .menu-button__wrapper {
    position: fixed;
    top: 1rem !important;
    right: 2rem !important;
    left: 90% !important;

  }
  
  .level_1  { padding-left:20px !important; }
  .level_2  { padding-left:40px !important; }
  .level_ledger { padding-left:60px !important; }
  .ui-datepicker td{
        padding: 0!important;
    }
</style>
<script>
  $(document).ready(function () {
    setTimeout(function () {
      $("#content_alert").css("display", "none");
    }, 5000);
  });
</script>
<link rel='stylesheet' href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css'>

<body class="theme-red" id="element">
  <?php echo view('frontend/layout/loader'); ?>
  <!--<nav class="navbar">
        <div class="container-fluid">
        <div class="col-md-4 col-sm-3"></div>
        
        <div class="col-md-4 col-sm-6">
          <div class="row" style="display: flex; align-items: center; flex-wrap: nowrap;">
              <div class="col-md-2 col-xs-3 col-sm-2" style="padding:0">
                  <a href="<?php echo base_url(); ?>/dashboard"> <img src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>" class="img-responsive" style="background:#FFFFFF;"> </a>
                </div>
                <div class="col-md-10 col-xs-9 col-sm-10 navbar-header" style="padding:0; padding-left:15px;">
                  <a href="<?php echo base_url(); ?>/dashboard" style="color:#FFFFFF;width:100%; font-size:18px; text-transform:uppercase;text-decoration:none; text-align:center;"> <?php echo $_SESSION['site_title']; ?> </a>
                </div>
          </div>
        </div>
        
        <div class="col-md-4 col-sm-3"></div>
        
            
        </div>
    </nav>-->


  <nav class="navbar">
    <div class="container-fluid">
      <div class="col-md-3"></div>

      <div class="col-md-6 col-sm-6 lg-head">
        <div class="row" style="display: flex; align-items: center; flex-wrap: nowrap;">
          <div class="col-md-2 det"></div>
          <div class="col-md-1 col-xs-2 col-sm-2" style="padding:0">
            <a href="<?php echo base_url(); ?>/dashboard"> <img
                src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>" class="img-responsive"
                style="max-height: 60px;"> </a>
          </div>
          <div class="col-md-7 col-xs-10 col-sm-10 navbar-header" style="padding:0; padding-left:15px;">
            <a href="<?php echo base_url(); ?>/dashboard"
              style="color:#FFFFFF;width:100%; font-size:18px; text-transform:uppercase;text-decoration:none; text-align:center;">
              <?php echo $_SESSION['site_title']; ?>
            </a>
          </div>
          <div class="col-md-2 det"></div>
        </div>
      </div>

      <div class="col-md-3 yellow_btns" align="right" style="padding-top: 15px;">
        <a id="go-button" class="push"><i class="material-icons" id="go-btn">fullscreen</i></a>
        <a href="<?= base_url('language_switcher/index/english') ?>" class="push">E</a>
        <a class="push" href="<?= base_url('language_switcher/index/tamil') ?>">த</a>
      </div>
    </div>
  </nav>

  <script>

    /* Get into full screen */
    function GoInFullscreen(element) {
      if (element.requestFullscreen)
        element.requestFullscreen();
      else if (element.mozRequestFullScreen)
        element.mozRequestFullScreen();
      else if (element.webkitRequestFullscreen)
        element.webkitRequestFullscreen();
      else if (element.msRequestFullscreen)
        element.msRequestFullscreen();
    }

    /* Get out of full screen */
    function GoOutFullscreen() {
      if (document.exitFullscreen)
        document.exitFullscreen();
      else if (document.mozCancelFullScreen)
        document.mozCancelFullScreen();
      else if (document.webkitExitFullscreen)
        document.webkitExitFullscreen();
      else if (document.msExitFullscreen)
        document.msExitFullscreen();
    }

    /* Is currently in full screen or not */
    function IsFullScreenCurrently() {
      var full_screen_element = document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document.msFullscreenElement || null;

      // If no element is in full-screen
      if (full_screen_element === null)
        return false;
      else
        return true;
    }

    $("#go-button").on('click', function () {
      if (IsFullScreenCurrently())
        GoOutFullscreen();
      else
        GoInFullscreen($("#element").get(0));
    });

    $(document).on('fullscreenchange webkitfullscreenchange mozfullscreenchange MSFullscreenChange', function () {
      if (IsFullScreenCurrently()) {
        $("#go-btn").text('fullscreen_exit');
      }
      else {
        $("#go-btn").text('fullscreen');
      }
    });

  </script>


  <style>
    .btn-language {
      border-radius: 50% !important;
      margin: 13px;
      width: 35px;
      height: 35px;
    }

    .navbar-brand {
      float: left;
      height: 35px;
      padding: 15px 15px;
      font-size: 18px;
      line-height: 6px;
    }

    section.content {
      margin: 15px auto 40px;
    }

    .sidebar {
      top: 50px !important;
      height: calc(100vh - 50px);
    }

    footer {
      margin-top: 20px;
      width: 100%;
      position: fixed;
      bottom: 0;
    }

    /*.card { margin-bottom: 45px !important; }*/
    .bootstrap-select>.dropdown-toggle {
      padding-left: 0 !important;
    }

    .top_content {
      margin-top: 50px;
      background: #FFFFFF;
      padding-top: 15px;
      box-shadow: 0 1px 5px rgb(0 0 0 / 30%);
    }

    .top_menu li {
      list-style: none;
      display: inline-block;
      margin: 0 20px;
    }



    .navbar1 {
      height: 100%;
      /*max-width: 1250px;*/
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin: auto;
      /* background: red;
  padding: 0 50px; */
    }

    .navbar1 .logo a {
      font-size: 30px;
      color: #000;
      text-decoration: none;
      font-weight: 600;
    }

    .navbar1 .links li a img {
      margin: 0 auto;
    }

    .navbar1 .links li a span {
      background: #fff0f0;
      border-radius: 3px;
      padding: 2px 5px;
      border-top: 1px dotted #f44336;
      border-bottom: 1px dotted #f44336;
    }

    .navbar1 .nav-links {
      line-height: 20px;
      height: 100%;
      width: 99%;
    }

    .navbar1 .links {
      display: flex;
      margin-top: 5px;
      padding-left: 0px;
      width: 100%;
      justify-content: space-between;
    }

    .navbar1 .links li {
      position: relative;
      display: flex;
      align-items: center;
      justify-content: space-between;
      list-style: none;
      padding: 0 5px;
      min-width: 35px;
      /*border-right: 1px solid #dddbdb;*/
    }

    .navbar1 .links li:last-child {
      border-right: none;
    }

    .navbar1 .links li a {
      height: 100%;
      text-decoration: none;
      white-space: nowrap;
      color: #000;
      font-size: 15px;
      font-weight: 500;
    }

    .links li:hover .htmlcss-arrow,
    .links li:hover .js-arrow {
      transform: rotate(180deg);
    }

    .navbar1 .links li .arrow {
      /* background: red;
  height: 100%; */
      width: 22px;
      line-height: 15px;
      text-align: center;
      display: inline-block;
      color: #000;
      transition: all 0.3s ease;
    }

    .navbar1 .links li .sub-menu {
      position: absolute;
      top: 71px;
      left: 0;
      line-height: 40px;
      background: #fff;
      box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
      border-radius: 0 0 4px 4px;
      display: none;
      z-index: 99999;
      padding-left: 0px;
    }

    .navbar1 .links li:hover .htmlCss-sub-menu,
    .navbar1 .links li:hover .js-sub-menu {
      display: block;
    }

    .navbar .links li .sub-menu li {
      padding: 0 22px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .navbar .links li .sub-menu a {
      color: #fff;
      font-size: 15px;
      font-weight: 500;
    }

    .navbar .links li .sub-menu .more-arrow {
      line-height: 40px;
    }

    .navbar .links li .htmlCss-more-sub-menu {
      /* line-height: 40px; */
    }

    .navbar .links li .sub-menu .more-sub-menu {
      position: absolute;
      top: 0;
      left: 100%;
      border-radius: 0 4px 4px 4px;
      z-index: 1;
      display: none;
    }

    .links li .sub-menu .more:hover .more-sub-menu {
      display: block;
    }

    .navbar .search-box {
      position: relative;
      height: 40px;
      width: 40px;
    }

    .navbar .search-box i {
      position: absolute;
      height: 100%;
      width: 100%;
      line-height: 40px;
      text-align: center;
      font-size: 22px;
      color: #fff;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .navbar .search-box .input-box {
      position: absolute;
      right: calc(100% - 40px);
      top: 80px;
      height: 60px;
      width: 300px;
      background: #3E8DA8;
      border-radius: 6px;
      opacity: 0;
      pointer-events: none;
      transition: all 0.4s ease;
    }

    .navbar.showInput .search-box .input-box {
      top: 65px;
      opacity: 1;
      pointer-events: auto;
      background: #3E8DA8;
    }

    .search-box .input-box::before {
      content: '';
      position: absolute;
      height: 20px;
      width: 20px;
      background: #3E8DA8;
      right: 10px;
      top: -6px;
      transform: rotate(45deg);
    }

    .search-box .input-box input {
      position: absolute;
      top: 50%;
      left: 50%;
      border-radius: 4px;
      transform: translate(-50%, -50%);
      height: 35px;
      width: 280px;
      outline: none;
      padding: 0 15px;
      font-size: 16px;
      border: none;
    }

    .navbar .nav-links .sidebar-logo {
      display: none;
    }

    .navbar .bx-menu {
      display: none;
    }

    @media (max-width:920px) {
      .navbar1 {
        max-width: 100%;
        padding: 0 25px;
      }

      .navbar1 .logo a {
        font-size: 27px;
      }

      .navbar1 .links li {
        padding: 0 10px;
        white-space: nowrap;
      }

      .navbar1 .links li a {
        font-size: 15px;
      }
    }

    @media (max-width:800px) {
      nav {
        /* position: relative; */
      }

      .navbar .bx-menu {
        display: block;
      }

      .navbar1 .nav-links {
        position: fixed;
        top: 0;
        left: -100%;
        display: block;
        max-width: 270px;
        width: 100%;
        background: #3E8DA8;
        line-height: 40px;
        padding: 20px;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        transition: all 0.5s ease;

        z-index: 1000;
      }

      .navbar .nav-links .sidebar-logo {
        display: flex;
        align-items: center;
        justify-content: space-between;
      }

      .sidebar-logo .logo-name {
        font-size: 25px;
        color: #fff;
      }

      .sidebar-logo i,
      .navbar .bx-menu {
        font-size: 25px;
        color: #fff;
      }

      .navbar1 .links {
        display: block;
        margin-top: 20px;
      }

      .navbar1 .links li .arrow {
        line-height: 40px;
      }

      .navbar1 .links li {
        display: block;
      }

      .navbar1 .links li .sub-menu {
        position: relative;
        top: 0;
        box-shadow: none;
        display: none;
      }

      .navbar1 .links li .sub-menu li {
        border-bottom: none;

      }

      .navbar .links li .sub-menu .more-sub-menu {
        display: none;
        position: relative;
        left: 0;
      }

      .navbar .links li .sub-menu .more-sub-menu li {
        display: flex;
        align-items: center;
        justify-content: space-between;
      }

      .links li:hover .htmlcss-arrow,
      .links li:hover .js-arrow {
        transform: rotate(0deg);
      }

      .navbar .links li .sub-menu .more-sub-menu {
        display: none;
      }

      .navbar .links li .sub-menu .more span {
        /* background: red; */
        display: flex;
        align-items: center;
        /* justify-content: space-between; */
      }

      .links li .sub-menu .more:hover .more-sub-menu {
        display: none;
      }

      .navbar1 .links li:hover .htmlCss-sub-menu,
      .navbar1 .links li:hover .js-sub-menu {
        display: none;
      }

      .navbar .nav-links.show1 .links .htmlCss-sub-menu,
      .navbar .nav-links.show3 .links .js-sub-menu,
      .navbar .nav-links.show2 .links .more .more-sub-menu {
        display: block;
      }

      .navbar .nav-links.show1 .links .htmlcss-arrow,
      .navbar .nav-links.show3 .links .js-arrow {
        transform: rotate(180deg);
      }

      .navbar .nav-links.show2 .links .more-arrow {
        transform: rotate(90deg);
      }
    }

    @media (max-width:370px) {
      .navbar1 .nav-links {
        max-width: 100%;
      }
    }

    @media screen and (min-width: 767px) and (max-width: 992px) {
      .lg-head {
        margin-left: 15rem;

      }

      .menu-button {
        margin-left: 3rem;
      }

      .yellow_btns {
        margin-top: 3rem;
      }
    }
  </style>

  <script>
    // search-box open close js code
    let navbar = document.querySelector(".navbar");
    let searchBox = document.querySelector(".search-box .bx-search");
    // let searchBoxCancel = document.querySelector(".search-box .bx-x");

    searchBox.addEventListener("click", () => {
      navbar.classList.toggle("showInput");
      if (navbar.classList.contains("showInput")) {
        searchBox.classList.replace("bx-search", "bx-x");
      } else {
        searchBox.classList.replace("bx-x", "bx-search");
      }
    });

    // sidebar open close js code
    let navLinks = document.querySelector(".nav-links");
    let menuOpenBtn = document.querySelector(".navbar .bx-menu");
    let menuCloseBtn = document.querySelector(".nav-links .bx-x");
    menuOpenBtn.onclick = function () {
      navLinks.style.left = "0";
    }
    menuCloseBtn.onclick = function () {
      navLinks.style.left = "-100%";
    }


    // sidebar submenu open close js code
    let htmlcssArrow = document.querySelector(".htmlcss-arrow");
    htmlcssArrow.onclick = function () {
      navLinks.classList.toggle("show1");
    }
    let moreArrow = document.querySelector(".more-arrow");
    moreArrow.onclick = function () {
      navLinks.classList.toggle("show2");
    }
    let jsArrow = document.querySelector(".js-arrow");
    jsArrow.onclick = function () {
      navLinks.classList.toggle("show3");
    }
  </script>