<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/typicons/typicons.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/css/vendor.bundle.base.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/css/vertical-layout-light/style.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/style.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/mdi/css/materialdesignicons.min.css" />
<link rel="shortcut icon" href="<?php echo base_url(); ?>/assets/archanai/images/favicon.png" />
  <link href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css" rel="stylesheet">
<!-- Load jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Load Bootstrap and Bootstrap-Select -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<!-- Bootstrap-Select CSS and JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>

<style>
  .error{
    color:red;
  }
  body {
    height: 100vh;
    width: 100%;
  }

  .prod::-webkit-scrollbar {
    width: 3px;
  }

  .prod::-webkit-scrollbar-track {
    background: #f1f1f1;
  }

  .prod::-webkit-scrollbar-thumb {
    background: #d4aa00;
  }

  .prod::-webkit-scrollbar-thumb:hover {
    background: #e91e63;
  }

  a {
    text-decoration: none !important;
  }

  .table tr th {
    border: 1px solid #f7e086;
    font-size: 14px;
    background: #f7ebbb;
    color: #333232;
  }

  .pack,
  .pay {
    margin-bottom: 15px;
  }

  .form-label {
    text-transform: uppercase;
    font-size: 13px;
    letter-spacing: 1px;
    color: #333333;
    text-align: left;
    width: 100%;
  }

  .input {
    width: 100%;
    text-align: left;
  }

  select.input {
    color: #000;
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

  .sidebar-icon-only .main-panel {
    width: calc(100% - 0px);
  }

  .back {
    background: #00000087;
    padding: 15px;
    color: white;
    min-height: 120px;
  }

  .back h5 {
    min-height: 80px;
    font-size: 15px;
    font-weight: bold;
    color: #FFFFFF;
  }

  .greensubmit {
    background: #ab8a04 !important;
    font-weight: bold !important;
    color: #ffffff !important;
    box-shadow: -1px 10px 20px #ab8a04;
    background: #ab8a04 !important;
    background: -moz-linear-gradient(left, #ab8a04 0%, #ab8a04 80%, #ab8a04 100%) !important;
    background: -webkit-linear-gradient(left, #ab8a04 0%, #ab8a04 80%, #ab8a04 100%) !important;
    background: linear-gradient(to right, #ab8a04 0%, #ab8a04 80%, #ab8a04 100%) !important;
  }
  input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    margin: 0; 
}
.annathanam_container {
    width: 100%;
    margin: 0 auto;
    background-color: #ffffff;
    padding: 20px;
    /* box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); */
}

h3 {
    margin-top: 20px;
    margin-bottom: 20px;
    color: #333;
}

.row {
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 15px;
}

.form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.btn-info {
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.btn-info:hover {
    background-color: #0056b3;
}

.table-responsive {
    overflow-x: auto;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th, .table td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: left;
}

.table th {
    background-color: #f2f2f2;
}

.table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}
</style>
<style>
    ul.payment1 {
      list-style-type: none;
      width: 100%;
      display: flex;
      justify-content: space-between;
      margin-bottom: 0;
      padding-left: 0;
    }

    .payment1 li {
      display: inline-block;
      text-align: center;
      width: 50%;
    }

    .payment1 li label {
      border: 1px solid #CCC;
      border-radius: 5px;
      line-height: 1;
      padding: 15px 20px;
      display: block;
      position: relative;
      margin: 15px 15px;
      cursor: pointer;
      font-weight: bold;
    }

    .payment1 li label:before {
      background-color: white;
      color: white;
      content: " ";
      display: block;
      border-radius: 50%;
      border: 1px solid grey;
      position: absolute;
      top: -5px;
      left: -5px;
      width: 18px;
      height: 18px;
      text-align: center;
      line-height: 18px;
      transition-duration: 0.4s;
      transform: scale(0);
    }

    .payment1 li label i.mdi {
      transition-duration: 0.2s;
      transform-origin: 50% 50%;
      font-size: 18px;
      color: #0d2f95;
    }

    .payment1 li :checked+label {
      background: #f6ef08;
    }

    .payment1 li :checked+label:before {
      content: "✓";
      background-color: green;
      transform: scale(1);
    }

    .payment1 li label :checked+i.mdi {
      transform: scale(0.9);
    }

    input[type="radio"][id^="cb"] {
      display: none;
    }

    input[type="checkbox"][class^="package_amt"] {
      display: none;
    }

    /* Basic reset and box sizing */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Style the container */
.payment-options {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px; /* space between buttons */
}

/* Hide the actual radio input */
.payment-options .payment_type {
    display: none;
}

/* Style labels to look like buttons */
.payment-options .btn-payment {
    padding: 10px 20px;
    cursor: pointer;
    background-color: #f0f0f0;
    border: 1px solid #ccc;
    transition: background-color 0.3s, color 0.3s;
    display: inline-block;
    border-radius: 5px;
}

/* Change style when radio is checked */
.payment-options .payment_type:checked + .btn-payment {
    background-color: #008000; /* Green */
    color: white;
}

/* Hover effect for the buttons */
.payment-options .btn-payment:hover {
    background-color: #45a049;
}
.row.clearfix {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    border-bottom: 1px dashed #CCC;
    padding: 10px;
}

.payment-options {
    flex-grow: 1; /* Takes up the full width of the container */
    display: flex;
    justify-content: center; /* Centers the payment options */
    padding: 10px; /* Additional padding for better spacing */
    background-color: #f9f9f9; /* Optional: for better visibility of padding */
}

.partial_paid_sec {
    flex-grow: 1; /* Optional: Allows this section to take equal space */
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.pay-label {
    margin: 0 10px; /* Adds some space between the buttons */
}
.button-container {
    display: flex;
    justify-content: center;  /* Centers the content horizontally */
    align-items: center;      /* Centers the content vertically if needed */
    padding: 10px;            /* Adds some padding around the button for spacing */
}
  </style>
</head>

<body class="sidebar-icon-only">
  <div class="container-scroller">

    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->

      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <?php if ($_SESSION['succ'] != '') { ?>
              <div class="row" style="padding: 0 30%;margin: 0px 0 15px 0;" id="content_alert">
                <div class="suc-alert" style="width: 100%;">
                  <span class="suc-closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                  <p>
                    <?php echo $_SESSION['succ']; ?>
                  </p>
                </div>
              </div>
          <?php } ?>
          <?php if ($_SESSION['fail'] != '') { ?>
              <div class="row" style="padding: 0 30%;margin: 0px 0 15px 0;" id="content_alert">
                <div class="alert" style="width: 100%;">
                  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                  <p>
                    <?php echo $_SESSION['fail']; ?>
                  </p>
                </div>
              </div>
          <?php } ?>
          <div class="row">
            <div class="col-md-12 card" style="padding:20px;">
              <form id="form_validation" action="<?php echo base_url(); ?>/annathanam_counter/save_annathanam" method="POST">
                <div class="form-container card-body" align="center">
                  <div class="container-fluid">
                    <div class="row">

                      <div class="body">
                        <div class="container-fluid">
                          <div class="row clearfix">
                          <input type="hidden" name="date" id="date" class="form-control" value="<?php echo date('Y-m-d'); ?>"  >
                            <div class="col-sm-4">
                              <div class="form-group"><label class="form-label">Event Date <span
                                    style="color: red;">*</span></label>
                                <input type="date" name="event_date" id="event_date" class="form-control" autocomplete="off" value="<?php echo date("d-m-Y"); ?>"
                                  required>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="form-group"><label class="form-label">Bill No</label>
                                <input type="text" class="form-control" name="billno" id="billno" value="<?php echo $bill_no; ?>"
                                  readonly>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="form-group"><label class="form-label">Name <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="name" id="name" required>
                              </div>
                            </div>
                            <div class="col-sm-1">
                              <div class="form-group">
                                <label class="form-label">&nbsp;</label>
                                <select class="form-control" id="phone_code" name="phone_code">
                                  <option value="">code</option>
                                  <?php
                                  if (count($phone_codes) > 0) {
                                    foreach ($phone_codes as $phone_code) {
                                      ?>
                                          <option value="<?php echo $phone_code['dailing_code']; ?>" <?php if ($phone_code['dailing_code'] == "+60") {
                                               echo "selected";
                                             } ?>>
                                              <?php echo $phone_code['dailing_code']; ?>
                                          </option>
                                          <?php
                                    }
                                  }
                                  ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group"><label class="form-label">Mobile Number <span style="color: red;">*</span></label>
                                <input type="number" min="0" class="form-control" name="phone_no" id="phone_no" required>
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group"><label class="form-label">DOB </label>
                                <input type="date" class="form-control" name="dob" id="dob" max="<?php echo date('Y-m-d'); ?>">
                              </div>
                            </div>
                            <div class="col-md-1" style="margin: 30px 0;text-align:right">
                                <b>Time :</b> 
                            </div>
                            <div class="col-md-4" style="margin: 30px 0;text-align:left">
                                <input  type="checkbox" id="breakfast" name="time" value="Breakfast" class="check_time" >
                                <label for ='breakfast'> Breakfast &nbsp;&nbsp; </label>
                                <input  type="checkbox" id="lunch" name="time" value="Lunch" class="check_time" >
                                <label for ='lunch'> Lunch &nbsp;&nbsp; </label>
                                <input  type="checkbox" id="dinner" name="time" value="Dinner" class="check_time" >
                                <label for ='dinner'> Dinner &nbsp;&nbsp; </label>
                            </div>
                            <!-- <div class="col-sm-4">
                               <div class="form-group"><label class="form-label">Annathanam Package </label>
                                  <select class="form-control " name="package_id" id="package_id" required onchange="fetchItemsByPackageId(this.value); updatePackageAmount(this)">
                                      <option value="">--select Annathanam Package --</option>
                                      <?php if (count($packages) > 0) { ?>
                                        <?php foreach ($packages as $pack) { ?>
                                          <option value="<?php echo $pack['id']; ?>" data-amount="<?php echo $pack['amount']; ?>" <?php if ($data['package_id'] == $pack['id']) {
                                                  echo "selected";
                                                } ?>><?php echo $pack['name_eng'] . ' / ' . $pack['name_tamil']; ?></option>
                                        <?php } ?>
                                      <?php } ?>
                                  </select>
                                </div>
                            </div> -->

                            <div class="col-sm-4">
                               <div class="form-group"><label class="form-label">Annathanam Package </label>
                                    <select class="form-control" name="package_id" id="package_id" required onchange="packageChanged(this)">
                                        <option value="">--select Annathanam Package--</option>
                                        <?php if (count($packages) > 0): ?>
                                              <?php foreach ($packages as $pack): ?>
                                                    <option value="<?php echo $pack['id']; ?>" data-amount="<?php echo $pack['amount']; ?>" data-view="<?php echo $pack['view']; ?>" <?php echo ($data['package_id'] == $pack['id']) ? "selected" : ""; ?>> 
                                                        <?php echo $pack['name_eng'] . ' / ' . $pack['name_tamil']; ?>
                                                    </option>
                                              <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <input type="hidden" name="package_name" id="package_name" value="">
                            </div>
                            
                            <div class="col-sm-4">
                              <div class="form-group"><label class="form-label">Package amount per pax</label>
                                <input type="number" name="amount" id="amount" min="0" step=".01" class="form-control" value="0.00" readonly>
                              </div>
                            </div>
                            <!-- <div class="col-sm-4">
                              <div class="form-group"><label class="form-label">No of Pax (*Minimum 50 pax)<span style="color: red;">*</span></label>
                                <input type="number" name="no_of_pax" id="no_of_pax" min="0" class="form-control" placeholder="0" required>
                              </div>
                            </div>  -->
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line focused">
                                    <label class="form-label">No of Pax (*Minimum 30 pax)<span style="color: red;">*</span></label>
                                        <input type="number" id="no_of_pax" min="30" name="no_of_pax" class="form-control" value="<?php echo !empty($data['no_of_pax']) ? $data['no_of_pax'] : ""; ?>" <?php echo $readonly; ?> required placeholder="0" oninput="calculateTotalAmount()">
                                    </div>
                                </div>
                            </div><br>

                            <div class="col-sm-12">
                              <div class="row">
                                <h3 style="text-align:center;">Annathanam Items</h3>
                                    <div class="table-responsive">
                                        <table class="table" id="annathanam_items_table">
                                            <thead>
                                                <tr>
                                                    <th width="10%">S.no</th>
                                                    <th width="60%">Service</th>
                                                    <th width="30%">Description</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Items will be dynamically added here -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <input type="hidden" id="pack_items" name="pack_items">
                                </div>
                            </div>
                            <div class="col-md-12"> 
                              <div class="annathanam_special_items" style="display: none;">
                                  <h3>Annathanam Special Items<small><b></b></small></h3>
                                  <div class="row clearfix">
                                      <div class="col-sm-5">
                                          <div class="form-group form-float">
                                              <select class="form-control" id="special_dropdown">
                                                  <option value="">-- Select Service --</option> 
                                              </select>
                                          </div>
                                      </div>
                                      <div class="col-sm-2" align="left">
                                          <div class="form-group form-float">
                                              <button class="btn btn-success" id="add_special_item" type="button">Add</button>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="col-sm-12">
                                          <div class="table-responsive">
                                              <table class="table" id="annathanam_special_table">
                                                  <thead>
                                                      <tr>
                                                        <th width="10%">S.no</th>
                                                        <th width="20%">Type</th>
                                                        <th width="30%">Service</th>
                                                        <th width="10%">Amount</th>
                                                        <th width="10%">Quantity</th>
                                                        <th width="10%">Total</th>
                                                        <th width="10%">Action</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                      <!-- Items will be dynamically added here -->
                                                  </tbody>
                                              </table>
                                          </div>
                                          <input type="hidden" id="special_items" name="special_items">
                                      </div>
                                  </div>
                                </div>
                              </div> <br>

                              <div class="col-md-12"> 
                              <h3 style="text-align:center;">Annathanam Add-on Items<small><b></b></small></h3><br>
                              <div class="row clearfix">
                                  <div class="col-sm-5">
                                      <div class="form-group form-float">
                                          <select class="form-control" id="annathanamAddonDropdown">
                                              <option value="">-- Select Service --</option>
                                              <!-- Add options dynamically -->
                                          </select>
                                      </div>
                                  </div>
                                  <div class="col-sm-2" align="left">
                                      <div class="form-group form-float">
                                          <button class="btn btn-success" id="add_annathanam_addon" onclick="addAnnathanamAddonItem()" type="button">Add</button>
                                      </div>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-sm-12">
                                      <div class="table-responsive">
                                          <table class="table" id="annathanam_addon_items_table">
                                              <thead>
                                                  <tr>
                                                      <th width="10%">S.no</th>
                                                      <th width="30%">Addon</th>
                                                      <th width="15%">Quantity</th>
                                                      <th width="15%">Item Amount</th>
                                                      <th width="15%">Item Total</th>
                                                      <th width="15%">Action</th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                                  <!-- Addon items will be dynamically added here -->
                                              </tbody>
                                          </table>
                                      </div>
                                      <input type="hidden" id="addon_pack_items" name="addon_pack_items">
                                  </div>
                              </div>
                            </div>
                              <!-- </div> -->
                              <!-- <div class="col-md-12"<?php if (!empty($setting['annathanam_discount'])) {
                                echo ' style="display: block;"';
                              } else
                                echo ' style="display: none;"'; ?>>
                                <div style="display: flex; gap: 20px; align-items: center;">
                                    

                                    <div>
                                        <h5 style="text-align: center; margin-bottom:5px; margin-top:5px; color:#FFFFFF; background:#17a2b8;">Discount</h5>
                                        <input style="text-align: center" type="number" min="0" step="any" id="discount_amount" class="form-control" name="discount_amount" value="0">
                                    </div>
                                </div>
                            </div> -->

                            <div class="col-sm-3" <?php if (!empty($setting['annathanam_discount'])) {
                              echo ' style="display: block;"';
                            } else
                              echo ' style="display: none;"'; ?>>
                              <div class="form-group">
                                <label class="form-label" style="text-align: center">Discount</label>
                                <input type="number" name="discount_amount" id="discount_amount" min="0" step=".01" class="form-control" value="0.00">
                              </div>
                            </div>


                            <div class="col-sm-3">
                              <div class="form-group">
                                <label class="form-label" style="text-align: center">Total Amount</label>
                                <input type="number" name="total_amount" id="total_amount" min="0" step=".01" class="form-control" value="0.00" readonly>
                              </div>
                            </div>
                            <input type="hidden" name="total_amount_hidden" id="total_amount_hidden" min="0" step=".01" class="form-control" value="0.00" readonly>

                            <div class="row clearfix" style="width:105%; border-bottom:1px dashed #CCC; display: flex; justify-content: center; align-items: center;">
                              <div class="col-sm-10">
                                <div class="payment-options" style="flex-grow: 1; display: flex; justify-content: center;">
                                    <div class="form-group">
                                        <input type="radio" name="payment_type" id="payment_type_full" class="payment_type" value="full" 
                                            <?php echo (empty($data['payment_type']) || $data['payment_type'] == 'full') ? 'checked' : ''; ?>>
                                        <label for="payment_type_full" class="pay-label btn-payment">Full Payment</label>
                                    </div>
                                              <?php /*
                               <div class="form-group">
                                   <input type="radio" name="payment_type" id="payment_type_partial" class="payment_type" value="partial" 
                                       <?php echo ($data['payment_type'] == 'partial') ? 'checked' : ''; ?>>
                                   <label for="payment_type_partial" class="pay-label btn-payment">Partial Payment</label>
                               </div>
                                       */ ?>
                                </div>
                              </div>
                              <div class="col-sm-3 partial_paid_sec" align="center" style="<?php echo (!empty($data['payment_type']) && $data['payment_type'] == 'partial') ? '' : 'display: none;'; ?>">
                                  <label class="form-label" style="text-align: center">Pay Amount</label>
                                  <input type="number" name="paid_amount" id="paid_amount" step=".01" class="form-control" value="<?php echo $data['paid_amount'] ?? '0.00'; ?>">
                              </div>
                          </div>

                          <!-- </div>
                            <div class="row clearfix">
                              <div class="col-sm-4">
                                <div class="form-group"><input type="radio" name="payment_type" id="payment_type_2" class="payment_type" value="full" checked>  <label class="pay-label">Full Payment</label>  <input type="radio" name="payment_type" id="payment_type_1" class="payment_type" value="partial">  <label class="pay-label">Partial Payment</label>
                                </div>
                              </div>
                              <div class="col-sm-4 partial_paid_sec" style="display: none;">
                                <label class="form-label">Pay Amount</label>
                                <input type="number" name="paid_amount" id="paid_amount" step=".01" class="form-control" value="0.00">
                                <input type="hidden" name="paid_amount" id="full_paid_amount" class="form-control" value="0.00">
                              </div>
                            </div>
                          </div> -->
                      </div>

                    </div>
                  </div>

                </div>
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                      <ul class="payment1">
                      <?php foreach ($payment_mode as $key => $pay) { ?>
<li>
<input type="radio" name="pay_method" id="cb<?php echo $pay['id']; ?>" value="<?php echo $pay['id']; ?>" data-name="<?php echo $pay['name']; ?>" />
<label for="cb<?php echo $pay['id']; ?>">
<?php echo $pay['name']; ?>
</label>
</li>
<?php 
                      } ?>

                      <!-- <li><input type="radio" name="pay_method" id="cb1" value="cash" />
                            <label for="cb1"><i class="mdi mdi-square-inc-cash"></i> Cash</label>
                          </li>
                          <li><input type="radio" name="pay_method" id="cb3" value="qr" />
                            <label for="cb3"><i class="mdi mdi-qrcode"></i> QR</label>
                          </li>
                          <li><input type="radio" name="pay_method" id="cb4" value="card" />
                            <label for="cb4"><i class="mdi mdi-credit-card-multiple"></i> Card</label>
                          </li>
                          <li><input type="radio" name="pay_method" id="cb5" value="online" />
                            <label for="cb5"><i class="mdi mdi-web"></i> Online</label>
                          </li> -->
                      </ul>
                    </div>
                    <div class="col-sm-6" align="right" style="margin:0 auto;">
                        <button type="submit" id="saveButton" class="button button-white greensubmit">SAVE</button>
                    </div>
                    <div class="col-sm-6" align="left" style="margin:0 auto;">
                        <button type="button" id="clear_all" class="button button-white greensubmit">Clear All</button>
                    </div>
                  </div>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>


    </div>
    <!-- main-panel ends -->
  </div>
  <!-- page-body-wrapper ends -->
  </div>

<div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <p style="text-align:center;"><br><i class="mdi mdi-alert-circle-outline" style="font-size:42px; color:red;"></i></p>
                <h5 style="text-align:center;" id="spndeddelid"></h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">OK</button>
            </div>
        </div><!-- /.modal-content -->
    </div>
</div>

<div class="modal fade" id="validationModal" tabindex="-1" role="dialog" aria-labelledby="validationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="validationModalLabel" style="Text-align:center">Attention here!!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="validationModalBody" style="Text-align:center; font-size: 16px;">
                    <!-- Validation messages will be inserted here -->
                </div>
                    <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div> -->
            </div>
        </div>
    </div>


  <!-- container-scroller -->
  <script src="<?php echo base_url(); ?>/assets/archanai/js/jquery.min.js"></script>
  <!-- base:js -->
  <script src="<?php echo base_url(); ?>/assets/archanai/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <script src="<?php echo base_url(); ?>/assets/archanai/vendors/chart.js/Chart.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets/archanai/js/jquery.cookie.js" type="text/javascript"></script>
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="<?php echo base_url(); ?>/assets/archanai/js/off-canvas.js"></script>
  <script src="<?php echo base_url(); ?>/assets/archanai/js/hoverable-collapse.js"></script>
  <script src="<?php echo base_url(); ?>/assets/archanai/js/template.js"></script>
  <script src="<?php echo base_url(); ?>/assets/archanai/js/settings.js"></script>
  <script src="<?php echo base_url(); ?>/assets/archanai/js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <!-- <script src="<?php echo base_url(); ?>/assets/archanai/js/dashboard.js"></script> -->
  <script src="<?php echo base_url(); ?>/assets/jquery.validate.js"></script>

  <link href="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>

<script>
    $(document).ready(function () {
        $("#clear_all").click(function () {
            $("input").val("");
            $("select").each(function () {
                $(this).prop("selectedIndex", 0); // Reset to the first option
            });
            $("#annathanam_items_table tbody").empty();
            $("#annathanam_addon_items_table tbody").empty();
            $("#package_name").val("");
            $("input[type='checkbox'], input[type='radio']").prop("checked", false);
        });
    });
    $(document).ready(function(){
        $('.check_time').click(function() {
            $('.check_time').not(this).prop('checked', false);
        });
    });

    $(document).on('change', '.payment_type', function(){
      if(this.value == 'partial'){
        $('.partial_paid_sec').show();
        $('#full_paid_amount').prop('disabled', true);
      }else{
        $('.partial_paid_sec').hide();
        $('#full_paid_amount').prop('disabled', false);
      }
    });
</script>

<script>

    function packageChanged(element) {
        var selectedOption = $(element).find('option:selected');
        var packageId = selectedOption.val();
        var packageView = selectedOption.data('view');
        var packageName = selectedOption.text().trim();
        var englishName = packageName.split('/')[0].trim();
        //console.log('Package name:', englishName);

        $('#package_name').val(englishName);

        if (packageView == '0') {
            $('#no_of_pax').closest('.col-sm-4').hide();
            $('#amount').closest('.col-sm-4').hide();
            $('#annathanam_items_table').closest('.col-sm-12').hide();
            $('.annathanam_special_items').show();
            fetchSpecialItems();
            fetchAddonItems();
        } else {
            $('#amount').closest('.col-sm-4').show();
            $('#no_of_pax').closest('.col-sm-4').show();
            $('#annathanam_items_table').closest('.col-sm-12').show();
            $('.annathanam_special_items').hide();
            if (packageId) {
                fetchItemsByPackageId(packageId);
                updatePackageAmount(element);
            }
        }
        sum_amount();
    }

    function fetchSpecialItems() {
        $.ajax({
            url: '<?php echo base_url(); ?>/annathanam_counter/get_special_items',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var $dropdown = $('#special_dropdown');
                $dropdown.empty().append('<option value="">-- Select Service --</option>'); 

                $.each(data, function(typeName, typeData) {
                    var $group = $('<optgroup>', {
                        label: typeName,
                        style: "font-weight: bold"
                    });

                    $.each(typeData.items, function(index, item) {
                        $group.append($('<option>', {
                            value: item.id,
                            text: item.name_eng + ' / ' + item.name_tamil,
                            'data-amount': item.amount,
                            'data-type-id': item.type_id
                        }));
                    });

                    $dropdown.append($group);
                    //$("#special_dropdown").selectpicker("refresh"); // Refresh the select picker if you're using Bootstrap-select
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error fetching special items: ' + textStatus);
            }
        });
    }


function fetchAddonItems() {
    
    $.ajax({
        url: '<?php echo base_url(); ?>/annathanam_counter/get_addon_items',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log('received addon data:', response);
            updateAddonItemsDropdown(response);
        },
        error: function(error) {
            console.log('Error fetching items:', error);
        }
    });
}
</script>

<script>
    $(document).ready(function() {
        function addItemToTable(itemName, itemId, type, typeId, amount) {
            //const noOfPax = $('#no_of_pax').val() || 50; // Default to 1 if no_of_pax is empty
            const noOfPax =  30;
            const totalAmount = amount * noOfPax;
            const rowCount = $('#annathanam_special_table tbody tr').length + 1;

            const rowHtml = `
                <tr data-item-id="${itemId}" data-type-id="${typeId}">
                    <td>${rowCount}</td>
                    <td>${type}</td>
                    <td>${itemName}</td>
                    <td>${parseFloat(amount).toFixed(2)}</td>
                    <td><input type="number" class="form-control item-quantity" value="${noOfPax}" min="30" data-price="${amount}"></td>
                    <td class="item-total">${totalAmount.toFixed(2)}</td>
                    <td><button class="btn btn-danger remove-item">X</button></td>
                </tr>`;

            $('#annathanam_special_table tbody').append(rowHtml);
            updateTotalAmount(totalAmount, 'add');
            updateSpecialItems()
        }

        $('#add_special_item').click(function() {
            const selectedOption = $('#special_dropdown option:selected');
            const itemId = selectedOption.val();
            const itemName = selectedOption.text();
            const typeLabel = selectedOption.closest('optgroup').attr('label');
            const typeId = selectedOption.data('type-id'); // Assuming type ID is stored as a data attribute on the option
            const amount = parseFloat(selectedOption.data('amount')); // Ensure this is a number

            if (itemId) {
                addItemToTable(itemName, itemId, typeLabel, typeId, amount);
            } else {
                alert('Please select an item to add.');
            }
        });

        // $('#annathanam_special_table').on('input', '.item-quantity', function() {
        //     const row = $(this).closest('tr');
        //     const oldTotal = parseFloat(row.find('.item-total').text()); // Fetch the old total
        //     const quantity = $(this).val();
        //     const price = parseFloat($(this).data('price'));
        //     const newTotal = quantity * price;
        //     row.find('.item-total').text(newTotal.toFixed(2));
        //     row.data('total', newTotal); // Update the data attribute
        //     updateTotalAmount(newTotal, 'update');
        //     updateSpecialItems()
        // });
        $('#annathanam_special_table').on('input', '.item-quantity', function() {
            const row = $(this).closest('tr');
            const oldTotal = parseFloat(row.find('.item-total').text());
            const quantity = parseInt($(this).val());
            const price = parseFloat($(this).data('price'));
            const newTotal = quantity * price;
            row.find('.item-total').text(newTotal.toFixed(2));
            const totalDifference = newTotal - oldTotal;
            updateTotalAmount(totalDifference, 'update');
            updateSpecialItems();  // Ensure this function is defined
        });

        $('#annathanam_special_table').on('click', '.remove-item', function() {
            const row = $(this).closest('tr');
            const total = parseFloat(row.find('.item-total').text()); // Fetch the current total directly from the text
            updateTotalAmount(total, 'remove');
            row.remove();
            updateSpecialItems();
        });
        sum_amount();
    });

    function updateSpecialItems() {
        var table = document.getElementById('annathanam_special_table').getElementsByTagName('tbody')[0];
        var specialItems = [];
        for (var i = 0, row; row = table.rows[i]; i++) {
            var itemId = $(row).data('item-id');  // Use jQuery to access data attributes
            var typeId = $(row).data('type-id');
            var type = row.cells[1].innerText;
            var itemName = row.cells[2].innerText;
            var amount = parseFloat(row.cells[3].innerText);
            var quantity = parseInt(row.cells[4].getElementsByTagName('input')[0].value, 10);
            var total = parseFloat(row.cells[5].innerText);

            var item = {
                item_id: itemId,
                type_id: typeId,
                //type: type,
                //item_name: itemName,
                amount: amount,
                quantity: quantity,
                total: total
            };

            specialItems.push(item);
        }
        var specialItemsJSON = JSON.stringify(specialItems);
        console.log("SpecialItemsJSON: ", specialItemsJSON);
        document.getElementById('special_items').value = specialItemsJSON;
        sum_amount();
    }

</script>


<script>

    function updatePackageAmount(selectElement) {
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var packageAmount = selectedOption.getAttribute('data-amount');
        
        document.getElementById('amount').value = packageAmount;
        calculateTotalAmount();  // Example: Recalculate total amount based on the new package amount
        sum_amount();
    }


    function calculateTotalAmount() {
        var packageAmount = parseFloat(document.getElementById('amount').value);
        var noOfPax = parseInt(document.getElementById('no_of_pax').value);
        if (isNaN(noOfPax) || noOfPax < 30) {
            noOfPax = 0;
        }
        var totalAmount = packageAmount * noOfPax;
        var discount = ($('#discount_amount').val() != '') ? parseFloat($('#discount_amount').val()) : 0;
        totalAmount = totalAmount - discount;
        document.getElementById('total_amount').value = totalAmount.toFixed(2);
        document.getElementById('total_amount_hidden').value = totalAmount.toFixed(2);
        document.getElementById('full_paid_amount').value = totalAmount.toFixed(2);
        sum_amount();
    }

    document.addEventListener('DOMContentLoaded', function() {
        updatePackageAmount();
        sum_amount();
    });
</script>

<script>
    var items = <?php echo json_encode($items); ?>;
    console.log('items', items);
    var addon_items = <?php echo json_encode($addon_items); ?>;

    function populateItemsTable(items) {
        var itemsTable = document.getElementById('annathanam_items_table').getElementsByTagName('tbody')[0];
        itemsTable.innerHTML = ''; // Clear existing rows

        items.forEach(function(item, index) {
            var row = itemsTable.insertRow(-1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);

            var itemName = (item.name_eng || '') + ' / ' + (item.name_tamil || '');

            cell1.innerHTML = index + 1;
            cell2.innerHTML = '<input type="hidden" name="pack_items[]" value=\'{"item_id":"' + (item.item_id || '') + '","add_on":0}\'> ' + itemName;
            //cell3.innerHTML = '<a onclick="removeAnnathanamItem(this.parentElement.parentElement)" class="btn btn-danger">Remove</a>';
        });
        sum_amount();
    }

    function populateAddonItemsTable(addonItems) {
        var addonItemsTable = document.getElementById('annathanam_addon_items_table').getElementsByTagName('tbody')[0];
        addonItemsTable.innerHTML = ''; // Clear existing rows

        addonItems.forEach(function(addonItem, index) {
            var row = addonItemsTable.insertRow(-1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);

            var addonItemName = (addonItem.name_eng || '') + ' / ' + (addonItem.name_tamil || '');

            cell1.innerHTML = index + 1;
            cell2.innerHTML = `<input type="hidden" value="${addonItem.item_id}">` + addonItemName;
            cell3.innerHTML = `<input type="number" class="form-control text-center" value="${parseFloat(addonItem.item_amount).toFixed(2)}" onchange="updateItemTotalAmount(this, ${index})">`;
            cell4.innerHTML = `<input type="number" class="form-control total-amount" value="${parseFloat(addonItem.item_total_amount).toFixed(2)}" readonly>`;
            //cell5.innerHTML = `<a onclick="removeAnnathanamAddonItem(this.parentElement.parentElement)" class="btn btn-danger">Remove</a>`;
        });
        sum_amount();
    }

    function loadDataFromBackend(items, addonItems) {
        if (items && items.length > 0) {
            populateItemsTable(items);
        }

        if (addonItems && addonItems.length > 0) {
            populateAddonItemsTable(addonItems);
        }
        sum_amount();
    }
    sum_amount();
    loadDataFromBackend(items, addon_items);
</script>


<script>
function fetchItemsByPackageId(packageId) {
    if (packageId) {
        $.ajax({
            url: '<?php echo base_url(); ?>/annathanam_counter/get_items_by_package_id/' + packageId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
              console.log('received data:', response);
              // updateItemsDropdown(response);  
              // updateAddonItemsDropdown(response);
              // updateItemsDropdown(response.items, response.package_details.veg_count);
              updateItemsTable(response.items)
              updateAddonItemsDropdown(response.items);
              
            },
            error: function(error) {
                console.log('Error fetching items:', error);
            }
        });
    }
    sum_amount();
}


// function updateItemsDropdown(items) {
//     console.log("Called updateItemsDropdown", items);
//     var itemsDropdown = document.getElementById('annathanamDropdown');
//     itemsDropdown.innerHTML = '<option value="">-- Select Service --</option>';
    
//     items.forEach(function(item) {
//         console.log("Processing item for main dropdown:", item);
//         if (item.add_on == 0) {
//             itemsDropdown.innerHTML += '<option value="' + item.id + '">' + item.name_eng + ' / ' + item.name_tamil + '</option>';
//         }
//     });
//     //$("#annathanamDropdown").selectpicker("refresh");
// }

// function updateItemsDropdown(items, vegCount) {
//     var itemsDropdown = document.getElementById('annathanamDropdown');
//     itemsDropdown.innerHTML = '<option value="">-- Select Service --</option>';

//     items.forEach(function(item) {
//         if (item.add_on == 0 && item.add_veg != 1) {
//             itemsDropdown.innerHTML += '<option value="' + item.id + '">' + item.name_eng + ' / ' + item.name_tamil + '</option>';
//         }
//     });

//     var vegItems = items.filter(function(item) {
//         return item.add_on == 0 && item.add_veg == 1;
//     });

//     if (vegItems.length > 0) {
//         itemsDropdown.innerHTML += '<option disabled class="dropdown-header">--Vegetables (select any ' + vegCount + ')--</option>';
        
//         vegItems.forEach(function(item) {
//             itemsDropdown.innerHTML += '<option value="' + item.id + '">' + item.name_eng + ' / ' + item.name_tamil + '</option>';
//         });
//     }
//     //$("#annathanamDropdown").selectpicker("refresh");
// }

function updateItemsTable(items) {
    var itemsTableBody = document.getElementById('annathanam_items_table').getElementsByTagName('tbody')[0];
    itemsTableBody.innerHTML = ''; // Clear existing entries

    var serialNumber = 1;
    items.forEach(function(item) {
        if (item.add_on == 0) { // Assuming you want to filter out add-on items
            var row = itemsTableBody.insertRow();
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);

            cell1.innerHTML = serialNumber++; // S.no
            cell2.innerHTML = `<input type="hidden" value="${item.id}">${item.name_eng} / ${item.name_tamil}`; // Items with hidden input for ID
            cell3.innerHTML = item.description || "N/A"; // Description - assuming description is a property, or default to "N/A"
        }
    });
    updatePackItems();
    sum_amount();
}

function updateAddonItemsDropdown(items) {
    console.log("Updating Addon Items Dropdown", items);
    var addonItemsDropdown = document.getElementById('annathanamAddonDropdown');
    addonItemsDropdown.innerHTML = '<option value="">-- Select Addon --</option>';
    
    items.forEach(function(item) {
        console.log("Checking item: ", item);
        if (item.add_on == 1) {
            console.log("Adding item to dropdown: ", item);
            addonItemsDropdown.innerHTML += '<option value="' + item.id + '" data-amount="' + item.amount + '">' + item.name_eng + ' / ' + item.name_tamil + '</option>';
        }
    });
    sum_amount();
    //$("#annathanamAddonDropdown").selectpicker("refresh");
}

var itemCount = <?php echo !empty($items) ? count($items) : 0; ?>;
var addonItemCount = <?php echo !empty($items) ? count($items) : 0; ?>;

function getItemNameById(id, itemsArray) {
    for (var i = 0; i < itemsArray.length; i++) {
        if (itemsArray[i].id == id) {
            return itemsArray[i].name;
        }
    }
    return null;
}

function getItemAmountById(id, itemsArray) {
    for (var i = 0; i < itemsArray.length; i++) {
        if (itemsArray[i].id == id) {
            return itemsArray[i].amount;
        }
    }
    return null;
}

function isItemInTable(itemId, tableId) {
    var table = document.getElementById(tableId);
    return Array.from(table.querySelectorAll('input[type="hidden"]')).some(input => {
        let itemData = JSON.parse(input.value);
        return itemData.item_id == itemId;
    });
}

function showValidationModal(messages) {
    var modalBody = document.getElementById('validationModalBody');
    modalBody.innerHTML = messages.join('<br>');
    $('#validationModal').modal('show');
}

function addAnnathanamItem() {
    var packageSelect = document.getElementById('package_id');
    var noOfPaxInput = document.getElementById('no_of_pax');
    var selectedPackageId = packageSelect.value;
    var noOfPax = noOfPaxInput.value;
    var select = document.getElementById('annathanamDropdown');
    var selectedItemId = select.value;
    var selectedText = select.options[select.selectedIndex].text;

    if (!selectedPackageId) {
        showValidationModal(["Please select a package."]);
        packageSelect.classList.add('highlight');
        return;
    } else {
        packageSelect.classList.remove('highlight');
    }

    if (!noOfPax || noOfPax < 30) {
        showValidationModal(["Please enter the number of pax (minimum 30)."]);
        noOfPaxInput.classList.add('highlight');
        return;
    } else {
        noOfPaxInput.classList.remove('highlight');
    }

    if (selectedItemId && !isItemInTable(selectedItemId, 'annathanam_items_table')) {
        var table = document.getElementById('annathanam_items_table').getElementsByTagName('tbody')[0];
        var row = table.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);

        cell1.innerHTML = table.rows.length;
        cell2.innerHTML = '<input type="hidden" name="pack_items[]" value=\'{"item_id":"' + selectedItemId + '","add_on":0}\'> ' + selectedText;
        cell3.innerHTML = '<a onclick="removeAnnathanamItem(this.parentElement.parentElement)" class="btn btn-danger">Remove</a>';

        itemCount++;
        updatePackItems();
        select.selectedIndex = 0;
    } else {
        showValidationModal(["This item is already added."]);
    }
}

function removeAnnathanamItem(rowId) {
    var row = document.getElementById(rowId);
    row.parentNode.removeChild(row);
    updatePackItems();
    updateSno('annathanam_items_table');
    sum_amount();
}

function updatePackItems() {
    var table = document.getElementById('annathanam_items_table').getElementsByTagName('tbody')[0];
    var items = [];
    for (var i = 0, row; row = table.rows[i]; i++) {
        var itemId = row.cells[1].getElementsByTagName('input')[0].value;
        var itemObject = {
            item_id: itemId,
            add_on: 0  // If needed, you can dynamically set this based on some row data
        };
        items.push(itemObject);
    }
    var itemsJSON = JSON.stringify(items);
    document.getElementById('pack_items').value = itemsJSON;
    sum_amount();
}

// function addAnnathanamAddonItem() {
//     console.log("addAnnathanamAddonItem function called"); // Debug log
//     var packageSelect = document.getElementById('package_id');
//     var noOfPaxInput = document.getElementById('no_of_pax');
//     var selectedPackageId = packageSelect.value;
//     var noOfPax = noOfPaxInput.value;

//     var select = document.getElementById('annathanamAddonDropdown');
//     var selectedItemId = select.value;
//     var selectedText = select.options[select.selectedIndex].text;
//     var itemAmount = parseFloat(select.options[select.selectedIndex].getAttribute('data-amount'));
//     var noOfPax = parseInt(document.getElementById('no_of_pax').value || 0);
//     var totalAmount = itemAmount * noOfPax;

//     if (!selectedPackageId) {
//         showValidationModal(["Please select a package."]);
//         packageSelect.classList.add('highlight');
//         return;
//     } else {
//         packageSelect.classList.remove('highlight');
//     }

//     if (!noOfPax || noOfPax < 50) {
//         showValidationModal(["Please enter the number of pax (minimum 50)."]);
//         noOfPaxInput.classList.add('highlight');
//         return;
//     } else {
//         noOfPaxInput.classList.remove('highlight');
//     }

//     if (selectedItemId && !isItemInTable(selectedItemId, 'annathanam_addon_items_table')) {
//         var table = document.getElementById('annathanam_addon_items_table').getElementsByTagName('tbody')[0];
//         var row = table.insertRow(-1);
//         var cell1 = row.insertCell(0);
//         var cell2 = row.insertCell(1);
//         var cell3 = row.insertCell(2);
//         var cell4 = row.insertCell(3);
//         var cell5 = row.insertCell(4);

//         cell1.innerHTML = table.rows.length;
//         cell2.innerHTML = `<input type="hidden" value="${selectedItemId}">` + selectedText;
//         cell3.innerHTML = `<input type="number" class="form-control text-center" value="${itemAmount.toFixed(2)}" onchange="updateItemTotalAmount(this, ${table.rows.length - 1})">`;
//         cell4.innerHTML = `<input type="number" class="form-control total-amount" value="${totalAmount.toFixed(2)}" readonly>`;
//         cell5.innerHTML = `<a onclick="removeAnnathanamAddonItem(this.parentElement.parentElement)" class="btn btn-danger">Remove</a>`;


//         cell3.querySelector('input').addEventListener('input', function() {
//             updateItemTotalAmount(this, table.rows.length - 1);
//         });

//         updateTotalAmount(totalAmount, 'add');
//         select.selectedIndex = 0;
//         updateAddonPackItems(); // Call to update hidden field after adding item
//     } else {
//         alert("This addon is already added or not selected.");
//     }
// }

function addAnnathanamAddonItem() {
    console.log("addAnnathanamAddonItem function called"); // Debug log
    var packageSelect = document.getElementById('package_id');
    var noOfPaxInput = document.getElementById('no_of_pax');
    var selectedPackageId = packageSelect.value;
    var noOfPax = parseInt(noOfPaxInput.value || 30);
    //var noOfPax = parseInt(50);

    var select = document.getElementById('annathanamAddonDropdown');
    var selectedItemId = select.value;
    var selectedText = select.options[select.selectedIndex].text;
    var itemAmount = parseFloat(select.options[select.selectedIndex].getAttribute('data-amount'));
    var totalAmount = itemAmount * noOfPax;

    if (selectedItemId && !isItemInTable(selectedItemId, 'annathanam_addon_items_table')) {
        var table = document.getElementById('annathanam_addon_items_table').getElementsByTagName('tbody')[0];
        var row = table.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);
        var cell6 = row.insertCell(5);

        cell1.innerHTML = table.rows.length;
        cell2.innerHTML = `<input type="hidden" value="${selectedItemId}">` + selectedText;
        cell3.innerHTML = `<input type="number" class="form-control text-center quantity-input" value="${noOfPax}" min="30" oninput="updateItemAndTotalAmounts(this)">`;
        cell4.innerHTML = `<input type="number" class="form-control text-center" value="${itemAmount.toFixed(2)}" oninput="updateItemAndTotalAmounts(this)">`;
        cell5.innerHTML = `<input type="number" class="form-control total-amount" value="${totalAmount.toFixed(2)}" readonly>`;
        cell6.innerHTML = `<a onclick="removeAnnathanamAddonItem(this.parentElement.parentElement)" class="btn btn-danger">Remove</a>`;

        updateTotalAmount(totalAmount, 'add'); // Update the total amount
        select.selectedIndex = 0; // Reset the dropdown
        updateAddonPackItems(); // Update hidden field after adding item
    } else {
        alert("This addon is already added or not selected.");
    }
    sum_amount();
}

// function removeAnnathanamAddonItem(row) {
//     var totalAmount = parseFloat(row.cells[3].querySelector('.total-amount').value);
//     var table = document.getElementById('annathanam_addon_items_table').getElementsByTagName('tbody')[0];
    
//     table.removeChild(row);
//     updateTotalAmount(totalAmount, 'remove');
//     updateSno('annathanam_addon_items_table');
// }

function removeAnnathanamAddonItem(rowElement) {
    var totalCell = rowElement.cells[4].querySelector('input');
    var amountToRemove = parseFloat(totalCell.value) || 0; // Get the total amount from the row to be removed
    updateTotalAmount(amountToRemove, 'remove'); // Subtract this amount from the overall total

    rowElement.parentNode.removeChild(rowElement);
    updateSno('annathanam_addon_items_table'); 
    sum_amount();
}

function updateAddonPackItems() {
    var table = document.getElementById('annathanam_addon_items_table').getElementsByTagName('tbody')[0];
    var items = [];
    for (var i = 0, row; row = table.rows[i]; i++) {
        var itemId = row.cells[1].querySelector('input').value; // Correct extraction of item_id
        var itemQuantity = row.cells[2].querySelector('input').value; 
        var itemAmount = row.cells[3].querySelector('input').value; // Correct extraction of item_amount
        var itemTotalAmount = row.cells[4].querySelector('input').value; // Correct extraction of item_total_amount
        items.push({
            item_id: itemId,
            item_quantity: itemQuantity,
            item_amount: parseFloat(itemAmount),
            item_total_amount: parseFloat(itemTotalAmount),
            add_on: 1
        });
    }
    var addonItemsJSON = JSON.stringify(items);
    console.log("addonItemsJSON inside updateAddonPackItems: ", addonItemsJSON); // Debug log
    document.getElementById('addon_pack_items').value = addonItemsJSON;
    sum_amount();
}

// function updateItemTotalAmount(input, rowIndex) {
//     var noOfPax = parseInt(document.getElementById('no_of_pax').value || '0');
//     var newAmount = parseFloat(input.value || 0);
//     var row = document.getElementById('annathanam_addon_items_table').getElementsByTagName('tbody')[0].rows[rowIndex];
//     var totalCell = row.cells[3].querySelector('.total-amount');
//     var oldTotal = parseFloat(totalCell.value);
//     var newTotal = newAmount * noOfPax;

//     totalCell.value = newTotal.toFixed(2);
//     updateTotalAmount(newTotal - oldTotal, 'update');
//     updateAddonPackItems(); // Ensure the hidden field is updated
// }

function updateItemAndTotalAmounts(inputElement) {
    var row = inputElement.closest('tr'); // Get the closest row to the input element
    var quantityInput = row.cells[2].querySelector('input'); // Quantity input
    var priceInput = row.cells[3].querySelector('input'); // Price input
    var totalCell = row.cells[4].querySelector('input'); // Total amount input

    var oldTotal = parseFloat(totalCell.value) || 0; // Current total of the row before update
    var quantity = parseInt(quantityInput.value) || 0; // Parse quantity, default to 0
    var price = parseFloat(priceInput.value) || 0; // Parse price, default to 0
    var newTotal = quantity * price; // Calculate the new total

    totalCell.value = newTotal.toFixed(2); // Set the new total for the row

    var totalDifference = newTotal - oldTotal; // Calculate the difference to adjust the overall total
    updateTotalAmount(totalDifference, 'update'); // Update the overall total using the difference
    sum_amount();
}

// function updateTotalAmount(amount, action) {
//     var totalAmountField = document.getElementById('total_amount');
//     var full_paid_amountField = document.getElementById('full_paid_amount');
//     var currentTotal = parseFloat(totalAmountField.value);
//     if (action === 'add') {
//         totalAmountField.value = (currentTotal + amount).toFixed(2);
//         full_paid_amountField.value = (currentTotal + amount).toFixed(2);
//     } else if (action === 'remove') {
//         totalAmountField.value = (currentTotal - amount).toFixed(2);
//         full_paid_amountField.value = (currentTotal - amount).toFixed(2);
//     } else if (action === 'update') {
//         totalAmountField.value = (currentTotal + amount).toFixed(2);
//         full_paid_amountField.value = (currentTotal + amount).toFixed(2);
//     }
// }

$('#discount_amount').on('change input blur', function(){
//   var totalAmountField = $('#total_amount_hidden').val()
//   var discount = ($('#discount_amount').val() != '') ? parseFloat($('#discount_amount').val()) : 0;
//   totalAmountField = (totalAmountField - discount).toFixed(2);
//   // const total = parseFloat(row.find('.item-total').text());
//   // totalAmountField = totalAmountField + total.toFixed(2);
//   console.log('totalAmountField:', totalAmountField);
//   $('#total_amount').val(totalAmountField);
// // calculateTotalAmount();
sum_amount();
      });

  function sum_amount() {
    var totalAmount = 0;
    var totalAmountField = 0;
    $('#annathanam_addon_items_table .total-amount').each(function () {
        totalAmount += parseFloat($(this).val() || 0); // Sum up the values
    });
    var discount = ($('#discount_amount').val() !== '') ? parseFloat($('#discount_amount').val()) : 0;
    var totalAmountFields = $('#total_amount_hidden').val();
    totalAmountField = ((parseFloat(totalAmountFields) || 0) + totalAmount - discount).toFixed(2);
    document.getElementById('total_amount').value = totalAmountField;
  }


function updateTotalAmount(newAmount, action, oldAmount = 0) {
    var totalAmountField = document.getElementById('total_amount');
    var discount = ($('#discount_amount').val() != '') ? parseFloat($('#discount_amount').val()) : 0;
    var totalAmountFields = $('#total_amount_hidden').val()
    totalAmountField.value = (totalAmountFields - discount).toFixed(2);
       
    if (totalAmountField) {  // Check if the element exists
        var currentTotal = parseFloat(totalAmountField.value) || 0;

        if (action === 'add') {
            totalAmountField.value = (currentTotal + newAmount).toFixed(2);
        } else if (action === 'remove') {
            totalAmountField.value = (currentTotal - newAmount).toFixed(2);
        } else if (action === 'update') {
            totalAmountField.value = (currentTotal - oldAmount + newAmount).toFixed(2);
        }

        console.log('current total after:', totalAmountField.value);
    } else {
        console.error("The total amount field does not exist.");
    }
    sum_amount();
}


function updateSno(tableId) {
    var table = document.getElementById(tableId).getElementsByTagName('tbody')[0];
    var i = 0;
    Array.from(table.rows).forEach(row => {
        row.cells[0].innerText = ++i;
    });
}

document.addEventListener('DOMContentLoaded', function () {
    //console.log("DOM fully loaded and parsed"); // Debug log
    updatePackItems();
    updateAddonPackItems();
    sum_amount();
});

</script>

<script>
//   $(document).ready(function() {
//     $("form").submit(function(event) {
//         var totalAmount = parseFloat($("#total_amount").val());
//         var paidAmount = parseFloat($("#paid_amount").val());
//         if (paidAmount > totalAmount) {
//             event.preventDefault();
            
//             $('#spndeddelid').text("Pay Amount should not be greater than Total Amount.");
//             $('#alert-modal').modal('show');
//         }
//     });
// });

  // $('#form_validation').validate({
  // 	rules: {
  // 		"name": {
  // 			required: true,
  // 		},
  //     "package_id": {
  // 			required: true,
  // 		},
  //     "no_of_pax": {
  // 			required: true,
  // 		},
  //     "phone_no": {
  // 			required: true,
  // 		}
  //     "time": {
  // 			required: true,
  // 		}
  // 	},
  // 	messages: {
  // 		"name": {
  // 			required: "Name is required"
  // 		},
  //     "package_id": {
  // 			required: "Rice type is required"
  // 		},
  //     "no_of_pax": {
  // 			required: "No of fax is required"
  // 		},
  //     "phone_no": {
  // 			required: "Phone no is required"
  // 		}
  //     "time": {
  // 			required: "Session is required"
  // 		}
  // 	},
  // 	submitHandler: function (form) {
  //       $.ajax({
  //           url: '<?php echo base_url(); ?>/annathanam_counter/save_annathanam',
  //       type: 'POST',
  //       data: $('#form_validation').serialize(),
  //       success: function (response) {
  //         obj = jQuery.parseJSON(response);
  //         console.log('Final response', obj);
  //         if (obj.err != '') {
  //           $('#alert-modal').modal('show', { backdrop: 'static' });
  //           $("#spndeddelid").text(obj.err);
  //         } else {
  //           window.open("<?php echo base_url(); ?>/annathanam_new/print_annathanam/" + obj.id);
  //           window.location.replace("<?php echo base_url(); ?>/annathanam_new");
  //         }
  //       }
  //     });
  //   }
  // });
</script>
  

<script>
//   $(document).ready(function() {
//     $('#saveButton').click(function(event) {
//         event.preventDefault();  // Prevent the default form submission

//         var packageSelect = document.getElementById('package_id');
//         var noOfPaxInput = document.getElementById('no_of_pax');
//         var selectedPackageId = packageSelect.value;
//         var noOfPax = parseInt(noOfPaxInput.value);

//         var errors = [];
//         var highlightClass = 'highlight'; // Class to add for highlighting fields

//         if (!selectedPackageId) {
//             errors.push("Please select a package.");
//             packageSelect.classList.add(highlightClass);
//         } else {
//             packageSelect.classList.remove(highlightClass);
//         }

//         if (!noOfPax || noOfPax < 30) {
//             errors.push("Please enter the number of pax (minimum 30).");
//             noOfPaxInput.classList.add(highlightClass);
//         } else {
//             noOfPaxInput.classList.remove(highlightClass);
//         }

//         var timeSlots = document.querySelectorAll('.check_time');
//         var timeSelected = Array.from(timeSlots).some(slot => slot.checked);
        
//         if (!timeSelected) {
//             errors.push("Please select any time slot.");
//             timeSlots.forEach(slot => slot.classList.add(highlightClass));
//         } else {
//             timeSlots.forEach(slot => slot.classList.remove(highlightClass));
//         }

//         var payMethods = document.querySelectorAll('input[name="pay_method"]');
//         var payMethodSelected = Array.from(payMethods).some(radio => radio.checked);
//         if (!payMethodSelected) {
//             errors.push("Please select a payment method.");
//             // Highlight the payment method list
//             document.querySelector('.payment1').classList.add(highlightClass);
//         } else {
//             document.querySelector('.payment1').classList.remove(highlightClass);
//         }

//         if (errors.length > 0) {
//             event.preventDefault(); // Prevent form submission
//             showValidationModal(errors); // Function to show modal with errors
//         }

//         var totalAmount = parseFloat($("#total_amount").val());
//         var paidAmount = parseFloat($("#paid_amount").val());

//         // Validation to check if the paid amount is greater than the total amount
//         if (paidAmount > totalAmount) {
//             $('#alert-modal').modal('show', { backdrop: 'static' });
//             $("#spndeddelid").text("Pay Amount should be less than the Total Amount.");
//             return;
//         }

//         // AJAX call to send form data to the server
//         $.ajax({
//             url: '<?php echo base_url(); ?>/annathanam_counter/save_annathanam',
//             type: 'post',
//             data: $('#form_validation').serialize(),  // Serialize the data in the form
//             success: function(response) {
//                 console.log("Success response:", response);
//                 try {
//                     var obj = jQuery.parseJSON(response);
//                     if (obj.err) {
//                         $('#alert-modal').modal('show', { backdrop: 'static' });
//                         $("#spndeddelid").text(obj.err);
//                     } else {
//                         window.open("<?php echo base_url(); ?>/annathanam_counter/print_annathanam/" + obj.id);
//                         window.location.replace("<?php echo base_url(); ?>/annathanam_counter");
//                     }
//                 } catch (e) {
//                     console.error("Response parsing error:", e);
//                 }
//             },
//             error: function(xhr, status, error) {
//                 console.error("AJAX error:", status, error);
//             }
//         });
//     });
// });

$(document).ready(function() {
    $('#saveButton').click(function(event) {
        event.preventDefault();  // Prevent the default form submission

        var packageSelect = document.getElementById('package_id');
        var noOfPaxInput = document.getElementById('no_of_pax');
        var selectedPackageId = packageSelect.value;
        console.log('package_id', selectedPackageId);
        var noOfPax = parseInt(noOfPaxInput.value);

        var errors = [];
        var highlightClass = 'highlight'; // Class to add for highlighting fields

        if (!selectedPackageId) {
            errors.push("Please select a package.");
            packageSelect.classList.add(highlightClass);
        } else {
            packageSelect.classList.remove(highlightClass);
        }

        if(selectedPackageId != 3){
            if (!noOfPax || noOfPax < 30) {
                errors.push("Please enter the number of pax (minimum 30).");
                noOfPaxInput.classList.add(highlightClass);
            } else {
                noOfPaxInput.classList.remove(highlightClass);
            }
        }

        var timeSlots = document.querySelectorAll('.check_time');
        var timeSelected = Array.from(timeSlots).some(slot => slot.checked);
        
        if (!timeSelected) {
            errors.push("Please select any time slot.");
            timeSlots.forEach(slot => slot.classList.add(highlightClass));
        } else {
            timeSlots.forEach(slot => slot.classList.remove(highlightClass));
        }

        var payMethods = document.querySelectorAll('input[name="pay_method"]');
        var payMethodSelected = Array.from(payMethods).some(radio => radio.checked);
        if (!payMethodSelected) {
            errors.push("Please select a payment method.");
            document.querySelector('.payment1').classList.add(highlightClass);
        } else {
            document.querySelector('.payment1').classList.remove(highlightClass);
        }

        // Check if there are any errors
        if (errors.length > 0) {
            showValidationModal(errors); // Function to show modal with errors
            return; // Stop the function here if there are errors
        }

        var totalAmount = parseFloat($("#total_amount").val());
        var paidAmount = parseFloat($("#paid_amount").val());

        // Validation to check if the paid amount is greater than the total amount
        if (paidAmount > totalAmount) {
            $('#alert-modal').modal('show', { backdrop: 'static' });
            $("#spndeddelid").text("Pay Amount should be less than the Total Amount.");
            return;
        }

        // If all validations are passed, make AJAX call to send form data to the server
        $.ajax({
            url: '<?php echo base_url(); ?>/annathanam_counter/save_annathanam',
            type: 'post',
            data: $('#form_validation').serialize(),  // Serialize the data in the form
            success: function(response) {
                console.log("Success response:", response);
                try {
                    var obj = jQuery.parseJSON(response);
                    if (obj.err) {
                        $('#alert-modal').modal('show', { backdrop: 'static' });
                        $("#spndeddelid").text(obj.err);
                    } else {
                        window.open("<?php echo base_url(); ?>/annathanam_counter/print_annathanam/" + obj.id);
                        window.location.replace("<?php echo base_url(); ?>/annathanam_counter");
                    }
                } catch (e) {
                    console.error("Response parsing error:", e);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX error:", status, error);
            }
        });
    });
});

</script>

<!-- <?php if (isset($_GET['annathanam_id'])): ?>
    <script type="text/javascript">
        window.onload = function() {
            window.open('<?php echo base_url("/annathanam_counter/print_annathanam/" . $_GET['annathanam_id']); ?>', '_blank');
            location.href = '<?php echo base_url("/annathanam_counter"); ?>';
        };
    </script>
<?php endif; ?> -->

</body>

</html>