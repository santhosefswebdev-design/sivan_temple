<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/jquery-ui.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/typicons/typicons.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/mdi/css/materialdesignicons.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/css/vendor.bundle.base.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/css/vertical-layout-light/style.css">
<link href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css" rel="stylesheet">
<?php 
if($view == true){
    $readonly = 'readonly';
    $disabled = 'disabled';
}
?>
<?php $db = db_connect();?>
<style>
.card {
    border: none;
    padding: 25px !important;
}
.form-group { margin-bottom: 0px; }
.form-group .form-control { border: 1px solid #CCC;padding-left: 5px; }
.btn { padding: 6px 12px !important; }

.dropdown-toggle {  border-bottom: 0px solid #ddd !important; }
.panel-primary { border-color: #d4aa00; }
.bootstrap-select.btn-group .dropdown-menu.inner { padding-bottom:50px; }

label {
    display: inline-block;
    max-width: 100%;
    margin-bottom: 5px;
    font-weight: bold;
    
}

div {
    display: block;
}

.panel-heading{
    margin-top:5px;
}
</style>

<style>
  body {
    height: 100vh;
    width: 100%;
  }

  .navbar-light .navbar-nav .nav-link {
    font-weight: 500;
  }

  /*.row { width:100%; }*/
  .btn {
    padding: 0.25rem 0.5rem;
    height: 2rem;
  }

  .product {
    /*height:500px;*/
    max-height: 67vh;
    overflow: auto;
  }

  .cart {
    /*height:330px;*/
    height: 32vh;
    max-height: 32vh;
    overflow: auto;
    width: 100%;
    margin-bottom: 10px;
    margin-top: 10px;
  }

  select.form-control:not([size]):not([multiple]) {
    height: calc(1.625rem + 2px);
  }

  .prod::-webkit-scrollbar {
    width: 3px;
  }

  .prod::-webkit-scrollbar-track,
  .prod1::-webkit-scrollbar-track {
    background: #f1f1f1;
  }

  .prod::-webkit-scrollbar-thumb,
  .prod1::-webkit-scrollbar-thumb {
    background: #d4aa00;
  }

  .prod::-webkit-scrollbar-thumb:hover,
  .prod1::-webkit-scrollbar-thumb:hover {
    background: #e91e63;
  }

  .prod1::-webkit-scrollbar {
    height: 3px;
  }

  .ui-front {
    z-index: 9999;
  }

  a {
    text-decoration: none !important;
  }

  .text-muted.arch {
    color: #000000 !important;
    font-size: 10px;
    text-align: center;
    padding: 10px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    /* max-height:50px;
  min-height:50px; */
    height: 78px;
    text-transform: uppercase;
    font-weight: bold;
  }

  .show-cart {
    max-height: 350px;
    overflow: auto;
  }

  .show-cart tr {
    border-radius: 10px;
  }

  .show-cart td {
    font-size: 11px;
    padding: 5px;
  }

  .total {
    margin-top: 15px;
    padding-bottom: 10px;
  }

  .total p {
    font-size: 24px;
    font-weight: bold;
  }

  .submit_btn {
    width: 100%;
    font-size: 24px;
    padding: 7px;
    height: 50px;
    background: #d4aa00;
    border: #d4aa00;
    margin-top: 1px;
  }

  .amt {
    padding: 3px 5px;
    font-weight: bold;
    color: #333333 !important;
  }

  .prod_img {
    width: 90px;
    margin: 0 auto;
    border-radius: 50%;
    min-height: 90px;
    max-height: 90px;
    background: #e1e1d68a;
    padding: 5px;
  }

  .clear-cart i,
  .total_cart i {
    font-size: 28px;
    color: #000000bd;
  }

  .item-count {
    background: #dfdbdb;
    padding: 5px 1px;
    margin: 0 3px;
    border-radius: 5px;
    max-width: 27px;
    min-width: 27px;
    text-align: center;
    font-size: 14px;
  }

  .count {
    position: absolute;
    left: 28px;
    top: 7px;
    background: #051898;
    border-radius: 50%;
    padding: 2px 7px;
    font-size: 12px;
    color: #FFF;
  }

  .fade.show {
    opacity: 1;
    background: #abaaaad4;
  }

  .item-count_new {
    background: #dfdbdb;
    padding: 2px 1px;
    margin: 0 3px;
    border-radius: 5px;
    max-width: 50px;
    min-width: 27px;
    text-align: center;
    font-size: 14px;
  }

  /* Chrome, Safari, Edge, Opera */
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  /* Firefox */
  input[type=number] {
    -moz-appearance: textfield;
  }

  .popup_table {
    height: 50vh;
    overflow: auto;
    margin-top: 15px;
  }

  .show-cart_popup_table tr th {
    text-align: left;
    font-size: 12px;
    font-weight: 600;
    padding: 5px;
    border-bottom: 1px solid #E4E4E4;
  }

  .show-cart_popup_table tr td,
  .show-cart_popup_table tr td p {
    text-align: left;
    font-size: 11px;
    padding: 5px;
    line-height: 17px;
    border: 0;
  }

  .sidebar-icon-only .sidebar .nav .nav-item .nav-link .menu-title {
    display: block !important;
    font-size: 11px;
    color: #FFFFFF;
  }

  .sidebar .nav .nav-item.active>.nav-link i.menu-icon {
    background: #edc10f;
    padding: 1px;
    list-style: outside;
    border-radius: 5px;
    box-shadow: 2px 5px 15px #00000017;
  }

  .sidebar-icon-only .sidebar .nav .nav-item .nav-link {
    display: block;
    padding-left: 0.25rem;
    padding-right: 0.25rem;
    text-align: center;
    position: static;
  }

  .sidebar-icon-only .sidebar .nav .nav-item .nav-link[aria-expanded] .menu-title {
    padding-top: 7px;
  }

  .form-group {
    margin-bottom: 0.5rem;
  }

  .caticon {
    font-size: 22px;
    text-align: center;
    line-height: 2em;
  }

  @media (min-width: 1200px) {
    .col-xl-3 {
      flex: 0 0 20%;
      max-width: 20%;
    }
  }

  .sidebar-icon-only .main-panel {
    width: calc(100% - 0px);
  }

  .ar_btn {
    background: linear-gradient(179deg, rgb(0 126 212) 0%, rgb(16 197 180) 35%, rgb(59 134 209) 100%);
    border-radius: 15px;
    font-weight: bold;
    height: 1.75em;
  }

  .cl_btn {
    background: linear-gradient(179deg, rgb(212 0 0) 0%, rgb(242 105 105) 35%, rgb(209 59 59) 100%);
    border-radius: 15px;
    font-weight: bold;
    height: 1.75em;
  }

  .big_font {
    font-size: 14px;
  }

  @media (max-width: 960px) {
    span.archa_name {
      text-transform: uppercase;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      width: 100px;
      display: inline-block;
    }

    .btn {
      padding: 0.25rem 0.35rem !important;
    }
  }

  .money-input {
    width: 100%;
    /* height: 50px; */
    padding: 10px;
    padding-left: 50px;
    /* padding: 10px; */
    border: 2px solid #ccc;
    border-radius: 5px;
    background-size: 40px 40px;
    background-repeat: no-repeat;
    background-position: 10px center;
    font-size: 16px;
    text-align: right;
    display: inline-block;
    cursor: pointer;
  }

  .sgd-1 {
    background-image: url('<?php echo base_url(); ?>/assets/images/sg1.jpeg') !important;
  }

  .sgd_dollar2 {
    background-image: url('<?php echo base_url(); ?>/assets/images/sgd_dollar2.jpeg') !important;
  }

  .sgd_dollar5 {
    background-image: url('<?php echo base_url(); ?>/assets/images/sgd_dollar5.jpeg') !important;
  }

  .sgd_dollar10 {
    background-image: url('<?php echo base_url(); ?>/assets/images/sgd_dollar10.jpeg') !important;
  }

  .sgd_dollar50 {
    background-image: url('<?php echo base_url(); ?>/assets/images/sgd_dollar50.jpeg') !important;
  }

  .sgd_dollarl00 {
    background-image: url('<?php echo base_url(); ?>/assets/images/sgd_dollar100.jpeg') !important;
  }

  .sgd_dollar1000 {
    background-image: url('<?php echo base_url(); ?>/assets/images/sgd_dollar1000.jpeg') !important;
  } 

  .sgd-5 {
    background-image: url('<?php echo base_url(); ?>/assets/images/sg5.jpeg') !important;
  }
  .sgd-10 {
    background-image: url('<?php echo base_url(); ?>/assets/images/sg10.jpeg') !important;
  }

  .sgd-20 {
    background-image: url('<?php echo base_url(); ?>/assets/images/sg20.jpeg') !important;
  }

  .sgd-50 {
    background-image: url('<?php echo base_url(); ?>/assets/images/sg50.jpeg') !important;
  }
</style>
<style>
    /* .rasi-table thead,
    tbody.rasi-body tr,
    .rasi-table1 thead {
      display: table;
      width: 100%;
      table-layout: fixed;
    }

    .rasi-table th,
    .rasi-table1 th {
      font-size: 12px;
      text-align: left;
      background: #fcf8eb;
    }

    .rasi-table td,
    .rasi-table1 td {
      font-size: 12px;
      text-align: left;
    }

    .rasi-body {
      overflow: auto;
      height: 12vh;
      display: block;
    }

    .vehicle-table thead,
    tbody.vehicle-body tr {
      display: table;
      width: 100%;
      table-layout: fixed;
    }

    .vehicle-table th {
      font-size: 12px;
      text-align: left;
      background: #fcf8eb;
    }

    .vehicle-table td {
      font-size: 12px;
    }

    .vehicle-body {
      overflow: auto;
      height: 90px;
      display: block;
    } */

    .bal-amt {
      background: #1def3b;
      padding: 3px 5px;
    }

    .pay_amt p {
      font-size: 17px;
      font-weight: bold;
    }

    .navbar+.page-body-wrapper {
      padding-top: calc(3.625rem + 1.875rem);
    }

    .pay_mode {
      display: block;
      margin-bottom: 0;
      margin-top: 10px;
      width: 100%;
      background: #00d454;
      color: white;
      padding: 5px;
      text-align: center;
      font-size: 16px;
      text-transform: uppercase;
    }

    #filters {
      margin: 0 0 10px;
      padding: 0;
      list-style: none;
      width: 100%;
      overflow: auto;
      display: inherit;
    }

    #filters li:first-child {
      margin-left: 0;
    }

    #filters li {
      float: left;
      background: white;
      margin: 0 7px;
      width: 100px;
      max-height: 130px;
      min-width: 150px;
    }

    #filters li span {
      display: block;
      padding: 5px 2px;
      text-decoration: none;
      color: #000;
      cursor: pointer;
      transition: color 300ms ease-in-out;
      text-align: center;
      line-height: 1.5em;
      font-size: 13px;
      height: 130px;
    }

    #filters li span:hover {
      color: #d4aa00;
    }

    #filters li span.active {
      /*background: #d4aa00;*/
      background: linear-gradient(179deg, rgb(212 170 0) 0%, rgb(197 191 16) 35%, rgb(252 245 6) 100%);
      color: #000;
    }

    #portfoliolist .portfolio {
      display: none;
      float: left;
      overflow: hidden;
    }

    .portfolio-wrapper {
      overflow: hidden;
      position: relative !important;
      cursor: pointer;
    }

    .portfolio img {
      max-width: 100%;
      position: relative;
      top: 0;
    }

    .portfolio .label {
      position: absolute;
      width: 100%;
      height: 40px;
      bottom: -40px;
    }

    .portfolio .label-bg {
      background: #222;
      width: 100%;
      height: 100%;
      position: absolute;
      top: 0;
      left: 0;
    }

    .portfolio .label-text {
      color: #fff;
      position: relative;
      z-index: 500;
      padding: 5px 8px;
    }

    .portfolio .text-category {
      display: block;
      font-size: 9px;
    }

    .container:after {
      content: "\0020";
      display: block;
      height: 0;
      clear: both;
      visibility: hidden;
    }

    .clearfix:before,
    .clearfix:after {
      content: '\0020';
      display: block;
      overflow: hidden;
      visibility: hidden;
      width: 0;
      height: 0;
    }

    .clearfix {
      zoom: 1;
    }

    .clear {
      clear: both;
    }

    .clearfix:after {
      clear: both;
      display: block;
      overflow: hidden;
      visibility: hidden;
      width: 0;
      height: 0;
    }

    ul.payment {
      list-style-type: none;
      width: 100%;
      display: flex;
      justify-content: space-between;
      margin-bottom: 0;
      padding-left: 0;
    }

    .payment li {
      display: inline-block;
      text-align: center;
      width: 50%;
    }

    input[type="radio"][id^="cb"] {
      display: none;
    }

    input[type="radio"][id^="radio"] {
      display: none;
    }

    label {
      /* border: 1px solid #CCC; */
      /* border-radius: 5px; */
      /* line-height: 1; */
      /* padding: 5px 15px; */
      /* display: block; */
      position: relative;
      /* margin: 10px 15px; */
      cursor: pointer;
      font-weight: bold;
    }

    label:before {
      background-color: white;
      color: white;
      content: " ";
      display: block;
      border-radius: 50%;
      border: 1px solid grey;
      position: absolute;
      top: -12px;
      left: -5px;
      width: 18px;
      height: 18px;
      text-align: center;
      line-height: 18px;
      transition-duration: 0.4s;
      transform: scale(0);
    }

    label i.mdi {
      transition-duration: 0.2s;
      transform-origin: 50% 50%;
      font-size: 18px;
      color: #0d2f95;
    } 

    :checked+label {
      background: #f6ef08;
    }

    :checked+label:before {
      content: "✓";
      background-color: green;
      transform: scale(1);
    }

    :checked+i.mdi {
      transform: scale(0.9);
    }

    .archname {}

    .select2-container--default .select2-selection--multiple {
    border: 1px solid #ddd; /* Example to match your form design */
    border-radius: 4px;
    padding: 6px;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice {
    color: #555; /* Styling for tags in multi-select */
}
.dropdown-menu.open.show .dropdown-menu { display:block; max-height:100% !important; height:auto !important; }
.bootstrap-select > .dropdown-toggle {
    width: 90% !important; border: 1px solid #CCC;
}
.bootstrap-select.btn-group.show-tick .dropdown-menu li a span.text {
    margin-right: 0;
    color: black;
    font-size: 14px;
    padding: 2px 5px;
}
.bootstrap-select .dropdown-toggle {
    border-bottom: 1px solid #ccc !important;
}
li.selected { background:#d4aa004f; }
.dropdown-toggle::after {
    margin-left: 0 !important;
}
.protable tr th { color:#FFFFFF; background:#d4aa00; }
.protable th, .protable td {
    padding: .91rem 0.9375rem;
    vertical-align: middle;
    border-top: 1px solid #f3f3f3;
}
</style>

<!--link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script-->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/css/bootstrap-select.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/js/bootstrap-select.js"></script>
<script>
$('.selectpicker').selectpicker();
</script>

<section class="content mt-3">
    <div class="container-fluid ">
        <!--<div class="block-header">
            <h2> ENTRIES <small style="font-size: 14px;">Account / <?php echo $sub_title; ?></small></h2>
        </div>-->
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                
                    
                    
                       <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"><!--<h2>Ubayam</h2>--></div>
                        </div>
                    </div>
                    <div class="body">
							<?php if($_SESSION['succ'] != '') { ?>
							<div class="row" style="padding: 0 30%;" id="content_alert">
								<div class="suc-alert" style="width: 100%;">
									<span class="suc-closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
									<p><?php echo $_SESSION['succ']; ?></p> 
								</div>
							</div> 
							<?php } ?>
							<?php if($_SESSION['fail'] != '') { ?>
							<div class="row" style="padding: 0 30%;" id="content_alert">
								<div class="alert" style="width: 100%;">
									<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
									<p><?php echo $_SESSION['fail']; ?></p>
								</div>
							</div>
							<?php } ?>
                <form method="POST" enctype="multipart/form-data">
                    <div class="body">
                        <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                        <input type="hidden" name="date" id="date" class="form-control" value="<?php echo date('Y-m-d'); ?>"  >
                        <div class="container-fluid">
                        <div class="row clearfix">
                            <div class="col-sm-3">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label class="form-label">Offering Category <span style="color: red;"> *</span></label>
                                        <select id="offering_id" name="offering_id" class="form-control">
										    <option value="">-- Select Offering Category --</option>
										    <?php foreach($offer as $row) { ?>
										    <option <?php if($data['off_cat_id']==$row['id']) { echo "selected"; } ?> value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
										    <?php } ?>
										</select> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label class="form-label">Product Category <span style="color: red;"> *</span></label>
                                        <select id="product_id" name="product_id" class="form-control">
										    <option value="">-- Select Product Category --</option>
										</select> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label class="form-label">Grams <span style="color: red;"> *</span></label>
                                        <input type="number"  class="form-control" id="grams" name="grams" value="<?php echo $data['name'];?>" <?php echo $readonly; ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label class="form-label">Value <span style="color: red;"> *</span></label>
                                        <input type="number"  class="form-control" id="value" name="value" required value="<?php echo $data['name'];?>" <?php echo $readonly; ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-1" align="right">
                                <div class="form-group form-float">
                                    <br><button class="btn btn-success" onclick="appen()" type="button">Add</button>
                                </div>
                            </div>
                            <br><br><br><br>
                            <div class="table-responsive col-md-12" style="margin-bottom:20px;">
                            <table class="table protable table-bordered table-striped table-hover" id="table" border="1 ">
                              <thead>
                                <tr>
                                  <th style="width:25%;">Offering Category</th>
                                  <th style="width:25%;">Product Category</th>
                                  <th style="width:10%;">Grams</th>
                                  <th style="width:10%;">Value</th>
                                  <th style="width:10%;">Delete</th>
                                </tr>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>
                            </div>
                            
                            <input type="hidden" id="tot_count" value="0">
                            <br>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label class="form-label">Name <span style="color: red;"> *</span></label>
                                        <input type="text"  class="form-control" id="name" name="name" value="<?php echo $data['name'];?>" <?php echo $readonly; ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label class="form-label">Phone <span style="color: red;"> *</span></label>
                                        <input type="text"  class="form-control" id="phone" name="phone" value="<?php echo $data['phone'];?>" <?php echo $readonly; ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label class="form-label">Address </label>
                                        <input type="text"  class="form-control" id="address" name="address" value="<?php echo $data['address'];?>" <?php echo $readonly; ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12" align="center" style="background-color: white;padding-bottom: 1%;">
                                <button type="submit" id="submit" class="btn btn-success btn-lg waves-effect">SAVE</button>
                                <button type="button" id="clear" class="btn btn-primary btn-lg waves-effect">CLEAR</button>
                            </div>
                        </div>
                    </div>
                    </div>
                    </form>
                    </div>
                </div>
                    
                    
                   
            </div>
        </div>
    </div>
    <div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" style="width: 127%;">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-information h1 text-info"></i>
                        <table>
                            <tr><span id="spndeddelid"><b></b></span>&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-info my-3" data-dismiss="modal"> &times;</button></tr>
                        </table>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div>
    </div>
    <div id="alertModal" class="modal fade" tabindex="-1" rele="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!--div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div-->
                <div class="modal-body">
                    <p style="text-align:center;"><br><i class="mdi mdi-alert-circle-outline"
                            style="font-size:42px; color:red;"></i></p>
                    <h5 style="text-align:center;" id="modalMsg"></h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
	
	
</section>
<script src="<?php echo base_url(); ?>/assets/archanai/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/archanai/vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<script src="<?php echo base_url(); ?>/assets/archanai/vendors/chart.js/Chart.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/archanai/js/jquery.cookie.js" type="text/javascript"></script>
<!--link href="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/js/bootstrap-select.js"></script-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"/>
<script>
$("#offering_id").change(function(){
var id = $("#offering_id").val();
if(id != "")
	{
        $.ajax({
			url: '<?php echo base_url();?>/offering_online/get_category',
			type: 'post',
			data: {id:id},
			dataType: 'json',
			success:function(data)
			{
				console.log(data.data);
                $('#product_id').empty();
                $('#product_id').append('<option value="">Select Product Category</option>');
                data.data.forEach(function(item) {
                    $('#product_id').append(
                        $('<option></option>').val(item.id).text(item.name)
                    );
                });
                $('#product_id').selectpicker('refresh');
				//$('#product_id').append('<option value="' + data.data.pid + '">' + data.data.pname + '</option>');
		    }
		});
	}
});

$("#submit").click(function(event){
  event.preventDefault();
    $.ajax
    ({
        type:"POST",
        url: "<?php echo base_url(); ?>/offering_online/pro_offering_save",
        data: $("form").serialize(),
        beforeSend: function() {    
            $('input[type=submit]').prop('disabled', true);
            $("#loader").show();
        },
        success:function(data)
        {
            obj = jQuery.parseJSON(data);
            if(obj.err != ''){
                $('#alert-modal').modal('show', {backdrop: 'static'});
                $("#spndeddelid").text(obj.err);
            }else{					
              window.open("<?php echo base_url(); ?>/offering_online/print_offering/" + obj.id);
              window.location.replace("<?php echo base_url(); ?>/offering_online");
            }
        },
        complete:function(data){
            // Hide image container
            $('input[type=submit]').prop('disabled', false);
            $("#loader").hide();
        }
    });
});



function appen() {
  var count = parseInt($("#tot_count").val());
  var offering_id = $("#offering_id").val();
  var offering_text = $("#offering_id option:selected").text();
  var product_id = $("#product_id").val();
  var product_text = $("#product_id option:selected").text();
  var grams = $("#grams").val();
  var value = $("#value").val();
  if (offering_id === "") {
    alert("Please select an offering category.");
    return; 
  }
  if (product_id === "") {
    alert("Please select a product category.");
    return; 
  }
  if (grams === "" || grams == 0) {
    alert("Please enter Grams.");
    return; 
  }
  if (value === "" || value <= 0) {
    alert("Please enter the Value of the product.");
    return; 
  }

  {
    var html = "<tr id='row_"+count+"'>";
    html += "<td><input type='hidden' name='sout["+count+"][offering_id]' class='typeidclass' value='"+offering_id+"' >" + offering_text + "</td>";
    html += "<td><input type='hidden' class='rawidclass' name='sout["+count+"][product_id]' value='"+product_id+"' >" + product_text + "</td>";
    html += "<td><input type='hidden' name='sout["+count+"][grams]' value='"+grams+"' >" + grams + "</td>";
    html += "<td><input type='hidden' name='sout["+count+"][value]' value='"+value+"' >" + value + "</td>";
    html += "<td><button class='btn btn-danger remove' onclick='remove_row("+count+")' type='button'><i class='fa fa-trash'></i></button></td></tr>";
    $("#table tbody").append(html);
    
    $("#grams").val('');
    $("#value").val('');
    $('#offering_id').prop('selectedIndex',0);
    //$("#offering_id").selectpicker("refresh");
    $('#product_id').prop('selectedIndex',0);
    //$("#product_id").selectpicker("refresh");
    var cnt = count + 1;
    $("#tot_count").val(cnt);
  }
}
function remove_row(id){
    $('#row_'+id).remove();
}
</script>

