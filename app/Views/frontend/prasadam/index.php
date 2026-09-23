<?php $booking_calendar_range_year = booking_calendar_range_year($_SESSION['booking_range_year_frend']); ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/typicons/typicons.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/css/vendor.bundle.base.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/mdi/css/materialdesignicons.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/css/vertical-layout-light/style.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/style.css">
<link rel="shortcut icon" href="<?php echo base_url(); ?>/assets/archanai/images/favicon.png" />
<style>
  body {
    height: 100vh;
    width: 100%;
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

  /* select.form-control:not([size]):not([multiple]) {
    height: calc(1.625rem + 2px);
  } */

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

  a {
    text-decoration: none !important;
  }

  .text-muted.arch {
    color: #000000 !important;
    font-size: 14px;
    text-align: center;
    padding: 10px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    max-height: 50px;
    min-height: 50px;
    text-transform: uppercase;
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
    max-width: 50px;
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
  }

  .cl_btn {
    background: linear-gradient(179deg, rgb(212 0 0) 0%, rgb(242 105 105) 35%, rgb(209 59 59) 100%);
    border-radius: 15px;
    font-weight: bold;
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

  @media (min-width: 992px) {
    .cart-clm {
      max-width: 38%;
    }
  }

  .table tr th {
    border: 1px solid #f7e086;
    font-size: 14px;
    background: #f7ebbb;
    color: #333232;
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
  /*width:100px;
  max-height:95px;
  min-width:95px;*/
}

#filters li span {
    display: block;
    padding: 10px;
    text-decoration: none;
    color: #000;
    cursor: pointer;
    transition: color 300ms ease-in-out;
    text-align: center;
    line-height: 1em;
    font-size: 14px;
    text-transform: uppercase;
    font-weight: bold;
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

<body class="sidebar-icon-only">
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->


    <div class="container-fluid page-body-wrapper">

      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="row">
              <!-- <div class="col-xl-8 col-sm-6 col-lg-6 col-md-7 stretch-card flex-column">
                <div class="row prod product" id="portfoliolist">
                  <?php foreach ($prasadam_settings as $row) { ?>
                    <div class="col-xl-3 col-sm-6 col-lg-3 col-md-4 grid-margin stretch-card portfolio archanai"
                      data-cat="archanai">
                      <div class="card">
                        <a href="#" data-product_id="<?php echo $row['id']; ?>"
                          data-name="<?php echo str_replace(' ', '_', strtolower($row['name_eng'])); ?>"
                          data-price="<?php echo (float) ($row['amount']); ?>" class="add-to-cart"
                          data-src="<?php echo base_url(); ?>/uploads/prasadam_setting/<?php echo $row['image']; ?>"
                          data-category="1">
                          <div class="card-body d-flex flex-column justify-content-between">
                            <img class="img-fluid prod_img"
                              src="<?php echo base_url(); ?>/uploads/prasadam_setting/<?php echo $row['image']; ?>">
                            <div class="d-flex justify-content-between align-items-center mb-2 mt-2"
                              style="flex-direction: column;">
                              <p class="mb-0 text-muted arch">
                                <?php echo $row['name_tamil'] . ' <br>' . $row['name_eng']; ?>
                              </p>
                            </div>
                          </div>
                        </a>
                      </div>
                    </div>
                  <?php } ?>
                </div>
              </div> -->


              <!-- GROUPING -->
 <div class="col-xl-8 col-sm-6 col-lg-7 col-md-7 stretch-card flex-column">
    <ul id="filters" class="clearfix prod1">
        <?php
        foreach ($sett_data as $key => $value) {
            if (is_array($value) && !empty($key)) {
                ?>
                <li>
                    <span class="filter" data-filter="<?php echo '.' . str_replace(' ', '_', strtolower($key)); ?>">
                        <br><?php echo strtoupper($key); ?>
                    </span>
                </li>
                <?php
            }
        }
        ?>
    </ul>
  <div class="row prod product" id="portfoliolist">
    <?php
    foreach ($sett_data as $key => $value) {
      if (!empty($value)) {
        ?>
        <?php foreach ($value as $row) { ?>
          <div class="col-xl-3 col-sm-6 col-lg-3 col-md-4 grid-margin stretch-card portfolio <?php if (!empty($key)) {
            echo str_replace(' ', '_', strtolower($key));
          } ?>" data-cat="<?php if (!empty($key)) {
             echo str_replace(' ', '_', strtolower($key));
           } ?>">
            <div class="card">
              <a href="#" data-product_id="<?php echo $row['id']; ?>"
                data-name="<?php echo str_replace(' ', '_', strtolower($row['name_eng'])); ?>"
                data-price="<?php echo (float) ($row['amount']); ?>" class="add-to-cart"
                data-src="<?php echo base_url(); ?>/uploads/prasadam_setting/<?php echo $row['image']; ?>" data-category="1">
                <div class="card-body d-flex flex-column justify-content-between">
                  <img class="img-fluid prod_img"
                    src="<?php echo base_url(); ?>/uploads/prasadam_setting/<?php echo $row['image']; ?>">
                  <div class="d-flex justify-content-between align-items-center mb-2 mt-2" style="flex-direction: column;">
                    <p class="mb-0 text-muted arch">
                      <?php echo $row['name_tamil'] . ' <br>' . $row['name_eng']; ?>
                    </p>
                  </div>
                </div>
              </a>
            </div>
          </div>
        <?php }
      }
    }
    ?>
  </div>
</div>

              <div class="col-xl-4 col-sm-6 col-lg-6 col-md-5 stretch-card flex-column cart-clm">
                <div class="h-100">
                  <div class="stretch-card" style="height:100%;">
                    <div class="card">
                      <div class="card-body">
                        <form method="post">
                          <input type="hidden" name="date" id="date" value="<?php echo date('Y-m-d'); ?>" max="<?php echo $booking_calendar_range_year; ?>">
                          <div class="d-flex align-items-start flex-wrap">
                            <div class="d-flex justify-content-between" style="width:100%;">
                              <button type="button" class="btn btn-info btn-lg ar_btn" onClick="userModalOpen();">Add
                                Detail</button>
                              <button type="button" class="btn btn-warning btn-lg ar_btn" onClick="rePrint();"
                                style="background: #FFC107;border: 1px solid #FFC107;color: #fff;">Reprint</button>
                              <button type="button" class="btn btn-danger btn-lg cl_btn clear-cart">Clear All</button>
                            </div>
                            <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                              <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  </div>
                                  <div class="modal-body p-4" style="padding-bottom:10px;">
                                    <div class="text-center">
                                      <div class="row">
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label class="form-label" for="name">Customer Name<span
                                                style="color:red;">*</span></label>
                                            <input class="form-control" type="text" id="name" name="name"
                                              autocomplete="off">
                                            <span id="error_msg"></span>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label class="form-label" for="email_id">Email Address</label>
                                            <input class="form-control" type="email" id="email_id" name="email_id"
                                              autocomplete="off">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label class="form-label" for="ic_number">Ic No / Passport No</label>
                                            <input class="form-control" type="text" id="ic_number" name="ic_number"
                                              autocomplete="off">
                                            <!-- <span id="error_msg"></span> -->
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label class="form-label" for="mobile">Mobile No<span
                                                style="color:red;">*</span></label>
                                            <div class="row">
                                              <div class="col-md-4">
                                                <select class="form-control" name="phonecode" id="phonecode">
                                                  <option value="">Dialing code</option>
                                                  <?php
                                                  if (!empty ($phone_codes)) {
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
                                              <div class="col-md-8">
                                                <input class="form-control" type="number" id="mobile" name="mobile"
                                                  min="0" autocomplete="off">
                                                <span id="error_msg"></span>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-6">
                                         <div class="form-group">
    <label class="form-label" for="collection_date">Collection Date <span
                                                style="color:red;">*</span></label>
    <input required class="form-control" type="date" id="collection_date" name="collection_date" autocomplete="off" min="<?php echo date('Y-m-d'); ?>" max="<?php echo $booking_calendar_range_year; ?>">
                                        </div>

                                        </div>
                                        <!-- <div class="col-md-6">
                                          <div class="form-group">
                                            <label class="form-label" for="s_time">Collection Time</label>
                                            <input class="form-control" type="time" id="s_time" name="s_time"
                                              autocomplete="off">
                                          </div>
                                        </div> -->
                                        <div class="col-md-6">
											<div class="form-group">
												<label class="form-label" for="c_session">Collection Time <span
                                                style="color:red;">*</span></label>
												<select class="form-control" id="c_session" name="c_session">
													<option value="Select time" selected >Select time</option>
													<option value="AM">AM</option>
													<option value="PM">PM</option>
												</select>
											</div>
										</div>
        
                                        <!--div class="col-md-3">
                                                  <div class="form-group">  
                                                      <label class="form-label" for="e_time">End Time</label>
                                                      <input class="form-control" type="time" id="e_time" name="e_time" autocomplete="off" >
                                                  </div> 
                                              </div-->
                                      </div>
                                      <div class="row">
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label class="form-label" for="address">Address</label>
                                            <textarea class="form-control" id="address" name="address"
                                              style="width:100%;" rows="2">  </textarea>
                                            <!-- <span id="error_msg"></span> -->
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label class="form-label" for="description">Remarks</label>
                                            <textarea class="form-control" id="description" name="description"
                                              style="width:100%;" rows="2" autocomplete="off"></textarea>
                                            <!-- <span id="error_msg"></span> -->
                                          </div>
                                        </div>
                                      </div>
                                      <button type="button" name="ar_add_btn" id="ar_add_btn" class="btn btn-info my-3"
                                        style="width:100%; font-size:24px; height:auto;margin-bottom: 0 !important;">Submit</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="prod cart  col-md-12">
                              <table class="show-cart" style="width:100%;"></table>
                            </div>

                            <div class="col-md-12">
                              <table class="show-cart1 table table-bordered" style="width:100%;display:none;"></table>
                              <!--div class="detail prod">
                             </div-->
                            </div>

                            <div class="col-md-12"<?php if(!empty($setting['prasadam_discount'])){ echo ' style="display: block;"'; }else echo ' style="display: none;"'; ?>>
								                <div style="display: flex; gap: 20px; align-items: center;">
                                    <div>
                                        <h5 style="text-align: center; margin-bottom:5px; margin-top:5px; color:#FFFFFF; background:#17a2b8;">Total Amount</h5>
                                        <input style="text-align: center" type="number" min="0" step="any" id="sub_total" class="form-control" name="sub_total" value="0" readonly>
                                    </div>

                                    <div>
                                        <h5 style="text-align: center; margin-bottom:5px; margin-top:5px; color:#FFFFFF; background:#17a2b8;">Discount</h5>
                                        <input style="text-align: center" type="number" min="0" step="any" id="discount_amount" class="form-control" name="discount_amount" value="0">
                                    </div>
                                </div>
							              </div>


                            <div class="total d-flex justify-content-between align-items-center"
                              style="width:100%; border-bottom:1px dashed #CCC;">
                              <p class="mb-0">Total </p>
                              <p class="mb-0">RM : <span class="total-cart"></span></p>
                              <input type="hidden" id="tot_amt" name="tot_amt">
                            </div>
                            <!--h5 class="pay_mode">Payment Mode</h5-->
                            <ul class="payment">
                              <li><input type="radio" name="pay_method" id="cb1" value="cash" />
                                <label for="cb1"><i class="mdi mdi-square-inc-cash"></i> Cash</label>
                              </li>
                              <li><input type="radio" name="pay_method" id="cb2" value="qr" />
                                <label for="cb2"><i class="mdi mdi-qrcode"></i> QR</label>
                              </li>
                              <li><input type="radio" name="pay_method" id="cb3" value="card" />
                                <label for="cb3"><i class="mdi mdi-credit-card-multiple"></i> Card</label>
                              </li>
                              <li><input type="radio" name="pay_method" id="cb4" value="online" />
                                <label for="cb4"><i class="mdi mdi-web"></i> Online</label>
                              </li>
                              <!-- <li><input type="radio" name="pay_method" id="cb5" value="cheque" />
                                <label for="cb5"><i class="mdi mdi-checkbook"></i> Cheque</label>
                              </li> -->
                            </ul>
                  
                            <!--<div class="pay_amt d-flex justify-content-between align-items-center" style="width:100%; margin-top:5px;">
                          <p class="mb-0">Amount : </p>
                            <input type="number" style="width:100px; font-size:14px;" name="amount">
                            <p class="mb-0">Balance RM : </p>
                            <p class="mb-0"><span class="bal-amt total-cart"></span></p>
                         </div>-->

                         <div class="row clearfix" style="width:105%; border-bottom:1px dashed #CCC; display: flex; justify-content: center; align-items: center;">
                              <div class="payment-options" style="flex-grow: 1; display: flex; justify-content: center;">
                                  <div class="form-group">
                                      <input type="radio" name="payment_type" id="payment_type_full" class="payment_type" value="full" 
                                          <?php echo (empty($data['payment_type']) || $data['payment_type'] == 'full') ? 'checked' : ''; ?>>
                                      <label for="payment_type_full" class="pay-label btn-payment">Full Payment</label>
                                  </div>
                                  <!-- <div class="form-group">
                                      <input type="radio" name="payment_type" id="payment_type_partial" class="payment_type" value="partial" 
                                          <?php echo ($data['payment_type'] == 'partial') ? 'checked' : ''; ?>>
                                      <label for="payment_type_partial" class="pay-label btn-payment">Partial Payment</label>
                                  </div> -->
                              </div>
                              <div class="col-sm-6 partial_paid_sec" align="center" style="<?php echo (!empty($data['payment_type']) && $data['payment_type'] == 'partial') ? '' : 'display: none;'; ?>">
                                  <label class="form-label" align="center">Pay Amount</label>
                                  <input type="number" name="paid_amount" id="paid_amount" step=".01" class="form-control" value="<?php echo $data['paid_amount'] ?? '0.00'; ?>">
                              </div>
                          </div>


                            <div class="col-xl-12 col-sm-12 col-lg-12 col-md-12">
                              <input type="button" disabled value="PRINT" class="btn btn-info submit_btn" id="submit">
                            </div>
                            <!--div class="col-xl-6 col-sm-6 col-lg-6 col-md-6">
                                 <input type="submit" disabled value="Sep.PRINT" class="btn btn-info submit_btn" id="submit_sep">
                             </div-->

                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Image loader -->
            <div id='loader' style='display: none;'>
              <img src='./assets/Loading_2.gif' width='32px' height='32px'>
            </div>
            <!-- Image loader -->




          </div>
        </div>



      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- main-panel ends -->
  </div>
  <!-- page-body-wrapper ends -->
  </div>
  <div id="prin_page"></div>
  <!-- container-scroller -->
  <div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-body">
          <p style="text-align:center;"><br><i class="mdi mdi-alert-circle-outline"
              style="font-size:42px; color:red;"></i></p>
          <h5 style="text-align:center;" id="spndeddelid"></h5>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info" data-dismiss="modal">OK</button>
        </div>
      </div><!-- /.modal-content -->
    </div>
  </div>

  <!--REPRINT SECTION START-->
  <div id="myModal_reprint" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body p-4" style="padding-bottom:10px;">
          <div class="text-center">
            <div class="row">
              <div class="col-md-12">
                <table class="table table-bordered" style="width:100%">
                  <thead>
                    <tr style="font-size: 13px;text-align: left;background: #3F51B5;color: #fff;">
                      <th style="width: 10%;padding: 5px 10px;text-align:center;">S.No</th>
                      <th style="width: 40%;padding: 5px 10px;text-align:center;">Name</th>
                      <th style="width: 40%;padding: 5px 10px;text-align:center;">Amount</th>
                      <th style="width: 10%;padding: 5px 10px;text-align:center;">Action</th>
                    </tr>
                  </thead>
                  <tbody style="height:auto; margin-bottom:30px;">
                    <?php
                    if (count($reprintlists) > 0) {
                      $ire = 1;
                      foreach ($reprintlists as $reprintlist) {
                        ?>
                        <tr>
                          <td style="width: 10%;padding: 5px 0px!important;text-align:center;">
                            <?php echo $ire; ?>
                          </td>
                          <td style="width: 40%;padding: 5px 0px!important;text-align:center;">
                            <?php echo $reprintlist['customer_name']; ?>
                          </td>
                          <td style="width: 40%;padding: 5px 0px!important;text-align:center;">
                            <?php echo $reprintlist['amount']; ?>
                          </td>
                          <td style="width: 10%;padding: 5px 0px!important;text-align:center;">
                            <a class='btn btn-primary'
                              style='font-size: 13px;font-weight: bold;padding: 8px 10px;background: #2196F3;border: 1px solid #2196F3;'
                              title='Print'
                              href='<?php echo base_url(); ?>/prasadam_online/reprint_booking/<?php echo $reprintlist['id']; ?>'
                              target='_blank'>Print</a>
                          </td>
                        </tr>
                        <?php
                        $ire++;
                      }
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- REPRINT SECTION END -->
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
    <script src="<?php echo base_url(); ?>/assets/archanai/js/dashboard.js"></script>



    <!--script src='https://code.jquery.com/jquery-2.2.4.min.js'></script-->
    <script src="<?php echo base_url(); ?>/assets/archanai/script.js"></script>

    <style>
      .detail {
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
      }

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

      .payment li label {
        border: 1px solid #CCC;
        border-radius: 5px;
        line-height: 1;
        padding: 5px 16px;
        display: block;
        position: relative;
        margin: 10px 4px;
        cursor: pointer;
        font-weight: bold;
      }

      .payment li label:before {
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

      .payment li label i.mdi {
        transition-duration: 0.2s;
        transform-origin: 50% 50%;
        font-size: 18px;
        color: #0d2f95;
      }

      .payment li :checked+label {
        background: #f6ef08;
      }

      .payment li :checked+label:before {
        content: "✓";
        background-color: green;
        transform: scale(1);
      }

      .payment1 li label :checked+i.mdi {
        transform: scale(0.9);
      }

      .archname {}

      .show-cart1 {
        max-height: 350px;
        overflow: auto;
      }

      .show-cart1 tr {
        border-radius: 10px;
      }

      .show-cart1 td {
        font-size: 13px;
        padding: 3px 10px;
      }
    </style>

  <script>
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
      var userDetail = (function () {
        user = [];
        // Constructor
        function Item(name, email_id, ic_number, phonecode, mobile, collection_date, c_session, address, description) {
          this.name = name;
          this.email_id = email_id;
          this.ic_number = ic_number;
          this.phonecode = phonecode;
          this.mobile = mobile;
          this.collection_date = collection_date;
          this.c_session = c_session;
          // this.s_time = s_time;
          // this.e_time = e_time;
          this.address = address;
          this.description = description;
        }
        // Save user
        function saveUser() {
          sessionStorage.setItem('prasadam_userdetails', JSON.stringify(user));
          console.log(user, "save");
        }

        // Load user
        function loadUser() {
          user = JSON.parse(sessionStorage.getItem('prasadam_userdetails'));
        }
        if (sessionStorage.getItem("prasadam_userdetails") != null) {
          loadUser();
        }
        var obj = {};
        // Add to user
        obj.addUserToCart = function (name, email_id, ic_number, phonecode, mobile, collection_date, c_session, address, description) {
          var item = new Item(name, email_id, ic_number, phonecode, mobile, collection_date, c_session, address, description);
          user.push(item);
          saveUser();
        }
        // clear user
        obj.clearUser = function () {
          user = [];
          saveUser();
        }
        // List user
        obj.listUser = function () {
          return user;
        }
        return obj;
      })();

      function userModalOpen() {
        $("#myModal").modal("show");
        var cartArray = userDetail.listUser();
        if (cartArray.length > 0) {
          $('#name').val(cartArray[0].name);
          $('#email_id').val(cartArray[0].email_id);
          $('#ic_number').val(cartArray[0].ic_number);
          $('#phonecode').val(cartArray[0].phonecode);
          $('#mobile').val(cartArray[0].mobile);
          $('#collection_date').val(cartArray[0].collection_date);
          $('#c_session').val(cartArray[0].c_session);
          $('#address').val(cartArray[0].address);
          $('#description').val(cartArray[0].description);
          $('.show-cart1').show();
        }
        else {
          $('#name').val("");
          $('#email_id').val("");
          $('#ic_number').val("");
          $('#phonecode').val("+60");
          $('#mobile').val("");
          $('#collection_date').val("");
          $('#c_session').val("");
          $('#address').val("");
          $('#description').val("");
          $('.show-cart1').empty();
          $('.show-cart1').hide();
        }
      }

function clearCart() {
    // Clear all input fields
    $('#name').val("");
    $('#email_id').val("");
    $('#ic_number').val("");
    $('#phonecode').val("+60");
    $('#mobile').val("");
    $('#collection_date').val("");
    $('#c_session').val("");
    $('#address').val("");
    $('#description').val("");

    // Hide the cart display
    $('.show-cart1').empty();
    $('.show-cart1').hide();

    // Optionally, clear the cartArray in userDetail
    userDetail.clearUser(); // Ensure this function exists to reset the user data
}

// Bind the clearCart function to the Clear All button
$(document).on('click', '.clear-cart', function () {
    clearCart();
});


      // $('#ar_add_btn').click(function (event) {
      //   userDetail.clearUser();
      //   event.preventDefault();
      //   var name = $('#name').val();
      //   // var email_id = $('#email_id').val();
      //   // var ic_number = $('#ic_number').val();
      //   var phonecode = $('#phonecode').val();
      //   var mobile = $('#mobile').val();
      //   var collection_date = $('#collection_date').val();
      //   var s_time = $('#s_time').val();
      //   // var address = $('#address').val();
      //   // var description = $('#description').val();

      //   $('.form-control').each(function () {
      //     if ($(this).val() == "") {
      //       $(this).siblings('#error_msg').text('Field needs to Fill');
      //     } else {
      //       $(this).siblings('#error_msg').text('');
      //     }
      //   });
      //   /*
      //   if(email_id != "") {
      //       if(IsEmail(email_id)==false){
      //           $('#invalid_email').show();
      //           return false;
      //       }
      //   }

      //   function IsEmail(email_id) {
      //       var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      //       if(!regex.test(email_id)) {
      //          return false;
      //       }else{
      //          return true;
      //       }
      //   }
      //   */

      //   if (name != "" && email_id != "" && ic_number != "" && address != "" && mobile != "" && collection_date != "" && s_time != "") {
      //     $("#myModal").modal("hide");
      //     userDetail.addUserToCart(name, email_id, ic_number, phonecode, mobile, collection_date, s_time, address, description);
      //     displayCart_prasadam_user();
      //   }
      // });

      $('#ar_add_btn').click(function (event) {
        userDetail.clearUser();
        event.preventDefault();

        // Get values from form
        var name = $('#name').val().trim();
        var email_id = $('#email_id').val().trim();
        var ic_number = $('#ic_number').val().trim();
        var phonecode = $('#phonecode').val().trim();
        var mobile = $('#mobile').val().trim();
        var collection_date = $('#collection_date').val().trim();
        var c_session = $('#c_session').val().trim();
        var address = $('#address').val().trim();
        var description = $('#description').val().trim();

        // Validate required fields
        if (name == "") {
          $('#name').siblings('#error_msg').text('Name is required').css('color', 'red');;
        } else {
          $('#name').siblings('#error_msg').text('').css('color', 'red');;
        }
        if (collection_date == "") {
          $('#collection_date').siblings('#error_msg').text('Date is required').css('color', 'red');;
        } else {
          $('#collection_date').siblings('#error_msg').text('').css('color', 'red');;
        }


        if (mobile == "") {
          $('#mobile').siblings('#error_msg').text('Mobile No is required').css('color', 'red');;
        } else {
          $('#mobile').siblings('#error_msg').text('').css('color', 'red');;
        }
        // Validate required fields
        if (!name || !phonecode || !mobile || !collection_date) {

          return;
        }

        // Proceed with saving the user even if non-required fields are empty
        $("#myModal").modal("hide");
        userDetail.addUserToCart(name, email_id, ic_number, phonecode, mobile, collection_date, c_session, address, description);
        displayCart_prasadam_user();
      });




      function displayCart_prasadam_user() {
        var cartArray = userDetail.listUser();
        if (cartArray.length > 0) {
          //console.log(cartArray);
          //var formattedDate = [tempDate.getMonth() + 1, tempDate.getDate(), tempDate.getFullYear()].join('/');
          var output = "";
          output += "<tr>"
            + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Customer Name </th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>" + cartArray[0].name + "</td>"
            + "</tr>";
          output += "<tr>"
            + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Email ID </th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>" + cartArray[0].email_id + "</td>"
            + "</tr>";
          output += "<tr>"
            + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Mobile No </th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>" + cartArray[0].phonecode + " " + cartArray[0].mobile + "</td>"
            + "</tr>";
          output += "<tr>"
            + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Collection Date </th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>" + cartArray[0].collection_date + "</td>"
            + "</tr>";
          $('.show-cart1').html(output);
          $('.show-cart1').show();
        }
        else {
          $('#name').val("");
          $('#email_id').val("");
          $('#ic_number').val("");
          $('#phonecode').val("+60");
          $('#mobile').val("");
          $('#collection_date').val("");
          $('#c_session').val("");
          $('#address').val("");
          $('#description').val("");
          $('.show-cart1').empty();
          $('.show-cart1').hide();
        }
        //alert(cartArray.length);
      }
      displayCart_prasadam_user();
function clearCartPrasadamUser() {
    // Reset form fields to their default values
    $('#name').val("");
    $('#email_id').val("");
    $('#ic_number').val("");
    $('#phonecode').val("+60");  // Default phone code
    $('#mobile').val("");
    $('#collection_date').val("");
    $('#c_session').val("");
    $('#address').val("");
    $('#description').val("");

    // Hide the cart display
    $('.show-cart1').empty();
    $('.show-cart1').hide();
}

$('.clear-cart').click(function() {
    clearCartPrasadamUser();
});

      $(function () {
        var filterList = {
          init: function () {
            // MixItUp plugin
            // http://mixitup.io
            $('#portfoliolist').mixItUp({
              selectors: {
                target: '.portfolio',
                filter: '.filter'
              },
              load: {
               filter: '.<?php echo strtolower($default); ?>'
              }
            });

          }

        };
        // Run the show!
        filterList.init();
      });

      var shoppingCart = (function () {
        cart = [];
        // Constructor
        function Item(name, price, count, src, product_id, category) {
          this.name = name;
          this.price = price;
          this.count = count;
          this.src = src;
          this.product_id = product_id;
          this.category = category;
        }

        // Save cart
        function saveCart() {
          sessionStorage.setItem('prasadamCart', JSON.stringify(cart));
        }

        // Load cart
        function loadCart() {
          cart = JSON.parse(sessionStorage.getItem('prasadamCart'));
        }
        if (sessionStorage.getItem("prasadamCart") != null) {
          loadCart();
        }

        var obj = {};

        // Add to cart
        obj.addItemToCart = function (name, price, count, src, product_id, category) {
          for (var item in cart) {
            if (cart[item].name === name) {
              cart[item].count++;
              saveCart();
              return;
            }
          }
          var item = new Item(name, price, count, src, product_id, category);
          cart.push(item);
          saveCart();
        }
        // Set count from item
        obj.setCountForItem = function (name, count) {
          for (var i in cart) {
            if (cart[i].name === name) {
              cart[i].count = count;
              break;
            }
          }
        };
        // Remove item from cart
        obj.removeItemFromCart = function (name) {
          for (var item in cart) {
            if (cart[item].name === name) {
              cart[item].count--;
              if (cart[item].count === 0) {
                cart.splice(item, 1);
              }
              break;
            }
          }
          saveCart();
        }

        // Remove all items from cart
        obj.removeItemFromCartAll = function (name) {
          for (var item in cart) {
            if (cart[item].name === name) {
              cart.splice(item, 1);
              break;
            }
          }
          saveCart();
        }

        // Clear cart
        obj.clearCart = function () {
          cart = [];
          saveCart();
        }

        // Count cart 
        obj.totalCount = function () {
          var totalCount = 0;
          for (var item in cart) {
            totalCount += cart[item].count;
          }
          return totalCount;
        }

        // Total cart
        obj.totalCart = function () {
          var totalCart = 0;
          for (var item in cart) {
            totalCart += cart[item].price * cart[item].count;
          }
          return Number(totalCart.toFixed(2));
        }

        // List cart
        obj.listCart = function () {
          var cartCopy = [];
          for (i in cart) {
            item = cart[i];
            itemCopy = {};
            for (p in item) {
              itemCopy[p] = item[p];

            }
            itemCopy.total = Number(item.price * item.count).toFixed(2);
            cartCopy.push(itemCopy)
          }
          return cartCopy;
        }
        return obj;
      })();


      // Add item
      $('.add-to-cart').click(function (event) {
        event.preventDefault();
        var src = $(this).data('src');
        var name = $(this).data('name');
        var price = Number($(this).data('price'));
        var product_id = Number($(this).data('product_id'));
        var category = Number($(this).data('category'));
        shoppingCart.addItemToCart(name, price, 1, src, product_id, category);
        displayCart();
      });

      // Clear items
      $('.clear-cart').click(function () {
        shoppingCart.clearCart();
        displayCart();
      });

      $('#discount_amount').on('blur change', function(){
			  displayCart();
		  });


      function displayCart() {
        var cartArray = shoppingCart.listCart();
        //alert(cartArray.length);
        var output = "";
        var popup = "";
        //var output = '<tr><td colspan="4" align="center"><img src="images/cart_is_empty.png" class="img-fluid" style="width:100px; margin:0 auto;"></td></tr>';
        if (cartArray.length == 0) {
          output += "tr><td colspan='4' align='center'><img src='./assets/archanai/images/cart_is_empty.png' class='img-fluid' style='width:150px; margin:0 auto;'></td></tr>";
        }
        else {
          // ... (existing code)

          for (var i in cartArray) {
            output += "<tr style='background:#d4aa0014;'>"
              + "<td style='width:10%'><input type='hidden' name='prasadam[" + i + "][id]' value='" + cartArray[i].product_id + "' ><img data-name=" + cartArray[i].name + " src='" + cartArray[i].src + "' style='width:35px; border:1px solid #e9e6e6; background:#FFF; border-radius:5px;'></td>"
              + "<td style='width:42%'><input type='hidden' name='prasadam[" + i + "][amt]' value='" + (Number(cartArray[i].price).toFixed(2)) + "' ><span class='archa_name' style='text-transform:uppercase;'>" + cartArray[i].name + "</span><br>"
              + "RM : " + (Number(cartArray[i].price).toFixed(2)) + "</td>"
              + "<td style='width:35%'><div class='input-group'><button class='minus-item input-group-addon btn btn-primary' data-name=" + cartArray[i].name + ">-</button>"
              + "<input type='number' class='item-count form-control' data-name='" + cartArray[i].name + "' value='" + cartArray[i].count + "'>"
              + "<button class='plus-item btn btn-primary input-group-addon' data-name=" + cartArray[i].name + ">+</button><input type='hidden' name='prasadam[" + i + "][qty]' value='" + cartArray[i].count + "' class='item-count'></div></td>"
              + "<td style='width:8%'><button class='delete-item btn btn-danger' data-name=" + cartArray[i].name + ">X</button></td>"
              + "</tr><tr><td colspan='4'></td></tr>";
            $('#submit, #submit_sep').removeAttr('disabled');
          }

          // ... (existing code)

          for (var i in cartArray) {
            popup += "<tr>"
              + "<td>" + i + "</td>"
              + "<td><span style='text-transform:uppercase;'>" + cartArray[i].name + "</span><br>RM : " + Number(cartArray[i].price).toFixed(2) + "</td>"
              + "<td><p data-name='" + cartArray[i].name + "'>" + cartArray[i].count + "</p></td>"
              + "<td style='text-align:right;'>" + Number(cartArray[i].total).toFixed(2) + "</td></tr>";
          }
        }

        var sub_total = Number(shoppingCart.totalCart());
		var discount = ($('#discount_amount').val() != '') ? parseFloat($('#discount_amount').val()) : 0;
		if(discount > sub_total){
			discount = sub_total - 1;
			$('#discount_amount').val(discount.toFixed(2));
		}
		var tot_amt = sub_total - discount;

        $('.show-cart').html(output);
		    $('.total-cart').html(tot_amt.toFixed(2));
		    $('#sub_total').val(sub_total.toFixed(2));
		    $('#tot_amt').val(tot_amt.toFixed(2));
        $('.show-cart_popup').html(popup);

        var tot = shoppingCart.totalCount();
        if (tot == 0) {
          $('#submit, #submit_sep').prop('disabled', true);
        }
        //open_vehicle_entry();
      }

      function displayCart1() {
        var cartArray = shoppingCart.listCart();
        var output = '<tr><td colspan="4" align="center"><img src="./assets/archanai/images/cart_is_empty.png" class="img-fluid" style="width:100px; margin:0 auto;"></td></tr>';
        $('.show-cart').html(output);
        $('.total-cart').html(shoppingCart.totalCart());
        $('.total-count').html(shoppingCart.totalCount());
        $('.show-cart_popup').html(popup);
      }

      // Delete item button

      $('.show-cart').on("click", ".delete-item", function (event) {
        var name = $(this).data('name')
        shoppingCart.removeItemFromCartAll(name);
        displayCart();
        open_vehicle_entry();
      })


      // -1
      $('.show-cart').on("click", ".minus-item", function (event) {
        var name = $(this).data('name');
        shoppingCart.removeItemFromCart(name);
        displayCart();
        calculateAndUpdateTotal();
      });

      $('.show-cart').on("click", ".plus-item", function (event) {
        var name = $(this).data('name');
        shoppingCart.addItemToCart(name);
        displayCart();
        calculateAndUpdateTotal();
      });


      // Item count input
      $('.show-cart').on("change", ".item-count", function (event) {
        var name = $(this).data('name');
        var count = Number($(this).val());
        shoppingCart.setCountForItem(name, count);
        displayCart();
      });

      displayCart();

      function submit_modal() {
        $('#modal').show().addClass('show');
      }

      function print_page() {
        var cartArray = shoppingCart.listCart();
        var result = "";
        for (var i in cartArray) {
          result += "<tr>"
            + "<td>" + i + "</td>"
            + "<td><span style='text-transform:uppercase;' class='archname'>" + cartArray[i].name + "</span><br>RM : " + cartArray[i].price + "</td>"
            + "<td><p data-name='" + cartArray[i].name + "'>" + cartArray[i].count + "</p></td>"
            + "<td style='text-align:right;'>" + cartArray[i].total + "</td></tr>";
        }
        $('#prin_page').html(result);
        shoppingCart.clearCart();
        displayCart();
        window.print();
      }
      function save_prasadam(sep_print = 0) {
        $.ajax
          ({
            type: "POST",
            url: "<?php echo base_url(); ?>/prasadam_online/save?sep_print=" + sep_print,
            data: $("form").serialize(),
            beforeSend: function () {
              //$("#submit, #submit_sep").prop('disabled', true);
              $("#loader").show();
            },
            success: function (data) {
              //return;
              obj = jQuery.parseJSON(data);
              //return;
              if (obj.err != '') {
                $('#alert-modal').modal('show', { backdrop: 'static' });
                $("#spndeddelid").text(obj.err);
              } else {
                userDetail.clearUser();
                shoppingCart.clearCart();
                displayCart();
                window.open("<?php echo base_url(); ?>/prasadam_online/payment_process/" + obj.id, "_blank", "width=680,height=500");
                window.location.reload(true);
              }
            },
            complete: function (data) {
              // Hide image container
              $("#loader").hide();
            },
            error: function (err) {
              $("#submit, #submit_sep").prop('disabled', false);
              console.log('err');
              console.log(err);
            }
          });
      }

      window.onbeforeunload = () => {
        userDetail.clearUser();
        shoppingCart.clearCart();  
      };
    </script>

    <script>
      $(function () {
        $("[data-dismiss='modal']").on('click', function () {
          $('.modal').hide();
        })
      })
    </script>
    <script>
      function rePrint() {
        $("#myModal_reprint").modal("show");
      }

      $("#submit").click(function () {
        save_prasadam();
      });
      $("#submit_sep").click(function () {
        save_prasadam(1);
      });

      function handleItemCountChange() {
        // Item count input
        $('.show-cart').on("change", ".item-count-input", function (event) {
          var name = $(this).data('name');
          var count = Number($(this).val());
          shoppingCart.setCountForItem(name, count);
          displayCart();
          calculateAndUpdateTotal();
        });
      }

      function calculateAndUpdateTotal() {
        var cartArray = shoppingCart.listCart();
        var newTotal = 0;

        for (var i in cartArray) {
          newTotal += cartArray[i].price * cartArray[i].count;
        }
        var sub_total = Number(newTotal);
		var discount = ($('#discount_amount').val() != '') ? parseFloat($('#discount_amount').val()) : 0;
		var tot_amt = sub_total - discount;
		$('#sub_total').val(sub_total.toFixed(2));
    
        $('.total-cart').html(tot_amt.toFixed(2));
        $('#tot_amt').val(tot_amt.toFixed(2));
      }

      // Call handleItemCountChange to set up event listeners
      handleItemCountChange();

    </script>


</body>