<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/demo.css"> 
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">-->

<style>
.links li img { display:none !important; }
.navbar1 .links li .sub-menu { top: 23px; }
.navbar1 .links li { min-width: 80px; }
[type="checkbox"] + label {
	display:none;
}
[type="checkbox"] + label.s_print {
	display:block;
}
.heading { text-align:center; background:#000; color:#FFF; padding:10px; }
.products { 
	background:#FFF;
	display: flex;
    flex-wrap: wrap;
    align-items: center; 
	max-height: 420px;
    overflow-y: scroll;
}
.products .col-md-3{ 
	margin-bottom: 0px;
}
.prod { background:#CCCCCC; padding:5px 3px; margin-top:3px; margin-bottom:3px; cursor:pointer; }
.prod img { width:30%; float:left; border-right:1px dashed #999999; }
.prod .detail { width:60%; position:relative; margin-left:40%; }
.prod .detail h4,.prod .detail h5 { font-weight:bold; }
.vl { border-left: 2px dashed #999999; height: 82%; position: absolute; left: 38%; margin-left: -3px; top: 0; bottom:0; margin-top:10px; }
.cart-table { width:100%; } 
.cart-table tr th, .rasi-table tr th { font-weight:600; padding:4px;  }
.cart-table tr td, .rasi-table tr td { padding:2px; font-size:12px; border :none;}
.row_amt,.row_qty,.row_tot,.tot  {border :none;width: 100%;}
.detail h5 { font-size:11px; }
form.example input[type=text] {
  padding: 10px;
  font-size: 17px;
  border: 1px solid grey;
  float: left;
  width: 90%;
  background: #f1f1f1;
}

form.example button {
  float: left;
  width: 10%;
  padding: 10px;
  background: #000;
  color: white;
  font-size: 17px;
  border: 1px solid grey;
  border-left: none;
  cursor: pointer;
}

form.example button:hover {
  background:#333333;
}

form.example::after {
  content: "";
  clear: both;
  display: table;
}
.all_close{
	height: auto;
}
.cart-body{
    overflow-y: scroll;
    overflow-x: hidden;
    /*height: 220px;*/
	height:100px;
	display: block;
}
.rasi-body { 
	overflow-y: scroll;
    overflow-x: hidden;
    /*height: 220px;*/
	height:50px;
	display: block; 
}
.cart-table thead, tbody.cart-body tr {
    display: table;
    width: 100%;
    table-layout: fixed;
}
.rasi-table thead, tbody.rasi-body tr {
    display: table;
    width: 100%;
    table-layout: fixed;
}
.arch_total { background:#CCC; color:#000; font-weight:bold; text-align:center; font-size:38px; padding:0px; line-height:40px; } 

.card .body .col-xs-12, .card .body .col-sm-12, .card .body .col-md-12, .card .body .col-lg-12 {
    margin-bottom: 0px !important;
}
.detail h4 { font-size:21px; }
.prod { min-height:110px; }
@media (min-width: 992px) and (max-width: 1285px) {
.detail h4 { font-size:19px; }
}






/*@media screen and (orientation:portrait) {
body {
    transform: rotate(-90deg);
    transform-origin: 50% 50%;
}
}*/
.name { min-height:45px; max-height:45px; }
.form-group { margin-bottom: 10px; }
hr { margin: 2px auto;}
.cart { padding: 5px 20px 0 !important;  }
.btn {
    padding: 5px 7px !important;
}
.card { margin-bottom: 10px !important; }
.form-control { height: 27px; }
.card .body { padding: 15px 20px; }
section.content { min-height: 470px; }
@media (min-width: 1020px) {
    .card .body, .btn, .form-control { font-size: 12px !important; }
    .arch_total { font-size: 22px !important; line-height: 30px !important; }
    .cart-table tr td, .rasi-table tr td { font-size: 10px !important; }
    .dropdown-menu > li > a { font-size: 12px; line-height: 14px; }
    .btn { padding: 5px 2px !important; }
}


.nav { display: flex; flex-direction: row; }
.nav-tabs { width: 100%; }
.nav-tabs > li > a:before { border-bottom: 2px solid #f44336; }
.tab-content { width:100%; }
</style>  
<section class="content">
    <div class="container-fluid">
        <!-- <div class="block-header">
            <h2> ARCHANAI Ticket Entry<small>Archanai / <b>Archanai Ticket</b></small></h2>
        </div>
        Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="body">
                    <?php if($_SESSION['succ'] != '') { ?>
                                <div class="row" style="padding: 0 30%;" id="content_alert">
                                    <div class="suc-alert">
                                        <span class="suc-closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                        <p><?php echo $_SESSION['succ']; ?></p> 
                                    </div>
                                </div>
                            <?php } ?>
                             <?php if($_SESSION['fail'] != '') { ?>
                                <div class="row" style="padding: 0 30%;" id="content_alert">
                                    <div class="alert">
                                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                        <p><?php echo $_SESSION['fail']; ?></p>
                                    </div>
                                </div>
                            <?php } ?>
                        <div class="container-fluid">
                            <div class="row">
                                  <div class="col-md-8" style="margin-bottom: 0;">
                                    <div class="row">
                                        <div class="col-md-12 search-container" style="padding:0;">
                                          <input type="text" class="form-control" placeholder="Search.." name="search" id="search">
                                          <!--<button type="submit"><i class="fa fa-search"></i></button>-->
                                        </div>
                                    </div>
                                    <div id="products" class="products row scroll">
                                        
                                        <ul class="nav nav-tabs tab-nav-right" role="tablist">
                                            <li role="presentation" class="active"><a href="#home" data-toggle="tab">Archanai 1</a></li>
                                            <li role="presentation"><a href="#profile" data-toggle="tab">Archanai 2</a></li>
                                            <li role="presentation"><a href="#messages" data-toggle="tab">Archanai 3</a></li>
                                            <li role="presentation"><a href="#settings" data-toggle="tab">Archanai 4</a></li>
                                        </ul>
                                        
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade in active" id="home">
                                                <div class="col-md-12"><h4>Archanai 1</h4></div>
                                                <div class="col-md-4 col-lg-3 col-sm-6 col-xs-12" style="padding-left: 0px;">
                                                    <div class="prod" id="1240" data-id="prod1240" onclick="addtocart(1240)"><img src="http://templeganesh.grasp.com.my/uploads/archanai/1690352894_paalabhishekam.jpg" width="200" height="80" alt="image" />
                                                        <!--<div class="vl"></div>-->
                                                        <div class="detail">
                                                            <h5 class="name" id="nm_1240" data-id="1240">பால் அபிஷேகம் <br>PAAL ABHISHEKAM</h5><h4 id="amt_1240" data-id="40.00" >RM 40.00</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-lg-3 col-sm-6 col-xs-12" style="padding-left: 0px;">
                                                    <div class="prod" id="1241" data-id="prod1241" onclick="addtocart(1241)"><img src="http://templeganesh.grasp.com.my/uploads/archanai/1690524400_abhishekam.jpg" width="200" height="80" alt="image" />
                                                        <!--<div class="vl"></div>-->
                                                        <div class="detail">
                                                            <h5 class="name" id="nm_1241" data-id="1241">குங்கும அபிஷேகம் <br>KUMKUMA ABHISHEKAM</h5><h4 id="amt_1241" data-id="35.00" >RM 35.00</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-lg-3 col-sm-6 col-xs-12" style="padding-left: 0px;">
                                                    <div class="prod" id="1242" data-id="prod1242" onclick="addtocart(1242)"><img src="http://templeganesh.grasp.com.my/uploads/archanai/1690524896_abhishekam.jpg" width="200" height="80" alt="image" />
                                                        <!--<div class="vl"></div>-->
                                                        <div class="detail">
                                                            <h5 class="name" id="nm_1242" data-id="1242">பன்னீர் அபிஷேகம் <br>PANEER ABHISHEKAM</h5><h4 id="amt_1242" data-id="38.00" >RM 38.00</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-lg-3 col-sm-6 col-xs-12" style="padding-left: 0px;">
                                                    <div class="prod" id="1240" data-id="prod1240" onclick="addtocart(1240)"><img src="http://templeganesh.grasp.com.my/uploads/archanai/1690352894_paalabhishekam.jpg" width="200" height="80" alt="image" />
                                                        <!--<div class="vl"></div>-->
                                                        <div class="detail">
                                                            <h5 class="name" id="nm_1240" data-id="1240">பால் அபிஷேகம் <br>PAAL ABHISHEKAM</h5><h4 id="amt_1240" data-id="40.00" >RM 40.00</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-lg-3 col-sm-6 col-xs-12" style="padding-left: 0px;">
                                                    <div class="prod" id="1241" data-id="prod1241" onclick="addtocart(1241)"><img src="http://templeganesh.grasp.com.my/uploads/archanai/1690524400_abhishekam.jpg" width="200" height="80" alt="image" />
                                                        <!--<div class="vl"></div>-->
                                                        <div class="detail">
                                                            <h5 class="name" id="nm_1241" data-id="1241">குங்கும அபிஷேகம் <br>KUMKUMA ABHISHEKAM</h5><h4 id="amt_1241" data-id="35.00" >RM 35.00</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-lg-3 col-sm-6 col-xs-12" style="padding-left: 0px;">
                                                    <div class="prod" id="1242" data-id="prod1242" onclick="addtocart(1242)"><img src="http://templeganesh.grasp.com.my/uploads/archanai/1690524896_abhishekam.jpg" width="200" height="80" alt="image" />
                                                        <!--<div class="vl"></div>-->
                                                        <div class="detail">
                                                            <h5 class="name" id="nm_1242" data-id="1242">பன்னீர் அபிஷேகம் <br>PANEER ABHISHEKAM</h5><h4 id="amt_1242" data-id="38.00" >RM 38.00</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane fade" id="profile">
                                                <div class="col-md-12"><h4>Archanai 2</h4></div>
                                                <div class="col-md-4 col-lg-3 col-sm-6 col-xs-12" style="padding-left: 0px;">
                                                    <div class="prod" id="1240" data-id="prod1240" onclick="addtocart(1240)"><img src="http://templeganesh.grasp.com.my/uploads/archanai/1690352894_paalabhishekam.jpg" width="200" height="80" alt="image" />
                                                        <!--<div class="vl"></div>-->
                                                        <div class="detail">
                                                            <h5 class="name" id="nm_1240" data-id="1240">பால் அபிஷேகம் <br>PAAL ABHISHEKAM</h5><h4 id="amt_1240" data-id="40.00" >RM 40.00</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-lg-3 col-sm-6 col-xs-12" style="padding-left: 0px;">
                                                    <div class="prod" id="1241" data-id="prod1241" onclick="addtocart(1241)"><img src="http://templeganesh.grasp.com.my/uploads/archanai/1690524400_abhishekam.jpg" width="200" height="80" alt="image" />
                                                        <!--<div class="vl"></div>-->
                                                        <div class="detail">
                                                            <h5 class="name" id="nm_1241" data-id="1241">குங்கும அபிஷேகம் <br>KUMKUMA ABHISHEKAM</h5><h4 id="amt_1241" data-id="35.00" >RM 35.00</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-lg-3 col-sm-6 col-xs-12" style="padding-left: 0px;">
                                                    <div class="prod" id="1242" data-id="prod1242" onclick="addtocart(1242)"><img src="http://templeganesh.grasp.com.my/uploads/archanai/1690524896_abhishekam.jpg" width="200" height="80" alt="image" />
                                                        <!--<div class="vl"></div>-->
                                                        <div class="detail">
                                                            <h5 class="name" id="nm_1242" data-id="1242">பன்னீர் அபிஷேகம் <br>PANEER ABHISHEKAM</h5><h4 id="amt_1242" data-id="38.00" >RM 38.00</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-lg-3 col-sm-6 col-xs-12" style="padding-left: 0px;">
                                                    <div class="prod" id="1240" data-id="prod1240" onclick="addtocart(1240)"><img src="http://templeganesh.grasp.com.my/uploads/archanai/1690352894_paalabhishekam.jpg" width="200" height="80" alt="image" />
                                                        <!--<div class="vl"></div>-->
                                                        <div class="detail">
                                                            <h5 class="name" id="nm_1240" data-id="1240">பால் அபிஷேகம் <br>PAAL ABHISHEKAM</h5><h4 id="amt_1240" data-id="40.00" >RM 40.00</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-lg-3 col-sm-6 col-xs-12" style="padding-left: 0px;">
                                                    <div class="prod" id="1241" data-id="prod1241" onclick="addtocart(1241)"><img src="http://templeganesh.grasp.com.my/uploads/archanai/1690524400_abhishekam.jpg" width="200" height="80" alt="image" />
                                                        <!--<div class="vl"></div>-->
                                                        <div class="detail">
                                                            <h5 class="name" id="nm_1241" data-id="1241">குங்கும அபிஷேகம் <br>KUMKUMA ABHISHEKAM</h5><h4 id="amt_1241" data-id="35.00" >RM 35.00</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-lg-3 col-sm-6 col-xs-12" style="padding-left: 0px;">
                                                    <div class="prod" id="1242" data-id="prod1242" onclick="addtocart(1242)"><img src="http://templeganesh.grasp.com.my/uploads/archanai/1690524896_abhishekam.jpg" width="200" height="80" alt="image" />
                                                        <!--<div class="vl"></div>-->
                                                        <div class="detail">
                                                            <h5 class="name" id="nm_1242" data-id="1242">பன்னீர் அபிஷேகம் <br>PANEER ABHISHEKAM</h5><h4 id="amt_1242" data-id="38.00" >RM 38.00</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane fade" id="messages">
                                                <div class="col-md-12"><h4>Archanai 3</h4></div>
                                                <div class="col-md-4 col-lg-3 col-sm-6 col-xs-12" style="padding-left: 0px;">
                                                    <div class="prod" id="1240" data-id="prod1240" onclick="addtocart(1240)"><img src="http://templeganesh.grasp.com.my/uploads/archanai/1690352894_paalabhishekam.jpg" width="200" height="80" alt="image" />
                                                        <!--<div class="vl"></div>-->
                                                        <div class="detail">
                                                            <h5 class="name" id="nm_1240" data-id="1240">பால் அபிஷேகம் <br>PAAL ABHISHEKAM</h5><h4 id="amt_1240" data-id="40.00" >RM 40.00</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-lg-3 col-sm-6 col-xs-12" style="padding-left: 0px;">
                                                    <div class="prod" id="1241" data-id="prod1241" onclick="addtocart(1241)"><img src="http://templeganesh.grasp.com.my/uploads/archanai/1690524400_abhishekam.jpg" width="200" height="80" alt="image" />
                                                        <!--<div class="vl"></div>-->
                                                        <div class="detail">
                                                            <h5 class="name" id="nm_1241" data-id="1241">குங்கும அபிஷேகம் <br>KUMKUMA ABHISHEKAM</h5><h4 id="amt_1241" data-id="35.00" >RM 35.00</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-lg-3 col-sm-6 col-xs-12" style="padding-left: 0px;">
                                                    <div class="prod" id="1242" data-id="prod1242" onclick="addtocart(1242)"><img src="http://templeganesh.grasp.com.my/uploads/archanai/1690524896_abhishekam.jpg" width="200" height="80" alt="image" />
                                                        <!--<div class="vl"></div>-->
                                                        <div class="detail">
                                                            <h5 class="name" id="nm_1242" data-id="1242">பன்னீர் அபிஷேகம் <br>PANEER ABHISHEKAM</h5><h4 id="amt_1242" data-id="38.00" >RM 38.00</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-lg-3 col-sm-6 col-xs-12" style="padding-left: 0px;">
                                                    <div class="prod" id="1240" data-id="prod1240" onclick="addtocart(1240)"><img src="http://templeganesh.grasp.com.my/uploads/archanai/1690352894_paalabhishekam.jpg" width="200" height="80" alt="image" />
                                                        <!--<div class="vl"></div>-->
                                                        <div class="detail">
                                                            <h5 class="name" id="nm_1240" data-id="1240">பால் அபிஷேகம் <br>PAAL ABHISHEKAM</h5><h4 id="amt_1240" data-id="40.00" >RM 40.00</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-lg-3 col-sm-6 col-xs-12" style="padding-left: 0px;">
                                                    <div class="prod" id="1241" data-id="prod1241" onclick="addtocart(1241)"><img src="http://templeganesh.grasp.com.my/uploads/archanai/1690524400_abhishekam.jpg" width="200" height="80" alt="image" />
                                                        <!--<div class="vl"></div>-->
                                                        <div class="detail">
                                                            <h5 class="name" id="nm_1241" data-id="1241">குங்கும அபிஷேகம் <br>KUMKUMA ABHISHEKAM</h5><h4 id="amt_1241" data-id="35.00" >RM 35.00</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-lg-3 col-sm-6 col-xs-12" style="padding-left: 0px;">
                                                    <div class="prod" id="1242" data-id="prod1242" onclick="addtocart(1242)"><img src="http://templeganesh.grasp.com.my/uploads/archanai/1690524896_abhishekam.jpg" width="200" height="80" alt="image" />
                                                        <!--<div class="vl"></div>-->
                                                        <div class="detail">
                                                            <h5 class="name" id="nm_1242" data-id="1242">பன்னீர் அபிஷேகம் <br>PANEER ABHISHEKAM</h5><h4 id="amt_1242" data-id="38.00" >RM 38.00</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane fade" id="settings">
                                                <div class="col-md-12"><h4>Archanai 4</h4></div>
                                                <div class="col-md-4 col-lg-3 col-sm-6 col-xs-12" style="padding-left: 0px;">
                                                    <div class="prod" id="1240" data-id="prod1240" onclick="addtocart(1240)"><img src="http://templeganesh.grasp.com.my/uploads/archanai/1690352894_paalabhishekam.jpg" width="200" height="80" alt="image" />
                                                        <!--<div class="vl"></div>-->
                                                        <div class="detail">
                                                            <h5 class="name" id="nm_1240" data-id="1240">பால் அபிஷேகம் <br>PAAL ABHISHEKAM</h5><h4 id="amt_1240" data-id="40.00" >RM 40.00</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-lg-3 col-sm-6 col-xs-12" style="padding-left: 0px;">
                                                    <div class="prod" id="1241" data-id="prod1241" onclick="addtocart(1241)"><img src="http://templeganesh.grasp.com.my/uploads/archanai/1690524400_abhishekam.jpg" width="200" height="80" alt="image" />
                                                        <!--<div class="vl"></div>-->
                                                        <div class="detail">
                                                            <h5 class="name" id="nm_1241" data-id="1241">குங்கும அபிஷேகம் <br>KUMKUMA ABHISHEKAM</h5><h4 id="amt_1241" data-id="35.00" >RM 35.00</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-lg-3 col-sm-6 col-xs-12" style="padding-left: 0px;">
                                                    <div class="prod" id="1242" data-id="prod1242" onclick="addtocart(1242)"><img src="http://templeganesh.grasp.com.my/uploads/archanai/1690524896_abhishekam.jpg" width="200" height="80" alt="image" />
                                                        <!--<div class="vl"></div>-->
                                                        <div class="detail">
                                                            <h5 class="name" id="nm_1242" data-id="1242">பன்னீர் அபிஷேகம் <br>PANEER ABHISHEKAM</h5><h4 id="amt_1242" data-id="38.00" >RM 38.00</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-lg-3 col-sm-6 col-xs-12" style="padding-left: 0px;">
                                                    <div class="prod" id="1240" data-id="prod1240" onclick="addtocart(1240)"><img src="http://templeganesh.grasp.com.my/uploads/archanai/1690352894_paalabhishekam.jpg" width="200" height="80" alt="image" />
                                                        <!--<div class="vl"></div>-->
                                                        <div class="detail">
                                                            <h5 class="name" id="nm_1240" data-id="1240">பால் அபிஷேகம் <br>PAAL ABHISHEKAM</h5><h4 id="amt_1240" data-id="40.00" >RM 40.00</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-lg-3 col-sm-6 col-xs-12" style="padding-left: 0px;">
                                                    <div class="prod" id="1241" data-id="prod1241" onclick="addtocart(1241)"><img src="http://templeganesh.grasp.com.my/uploads/archanai/1690524400_abhishekam.jpg" width="200" height="80" alt="image" />
                                                        <!--<div class="vl"></div>-->
                                                        <div class="detail">
                                                            <h5 class="name" id="nm_1241" data-id="1241">குங்கும அபிஷேகம் <br>KUMKUMA ABHISHEKAM</h5><h4 id="amt_1241" data-id="35.00" >RM 35.00</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-lg-3 col-sm-6 col-xs-12" style="padding-left: 0px;">
                                                    <div class="prod" id="1242" data-id="prod1242" onclick="addtocart(1242)"><img src="http://templeganesh.grasp.com.my/uploads/archanai/1690524896_abhishekam.jpg" width="200" height="80" alt="image" />
                                                        <!--<div class="vl"></div>-->
                                                        <div class="detail">
                                                            <h5 class="name" id="nm_1242" data-id="1242">பன்னீர் அபிஷேகம் <br>PANEER ABHISHEKAM</h5><h4 id="amt_1242" data-id="38.00" >RM 38.00</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                        <div class="col-md-4 det" style="margin-bottom: 0;">
                                            <div class="cart">
                                                
                                                <div class="row">
                                                <!--<h3 style="margin-top:0px; margin-bottom: 15px;">Archanai Items</h3>-->
                                                <form action="" method="post">
                                                <div class="row" style="margin-top:20px;">
													<div class="col-sm-6" style="margin: 0px;">
														<div class="form-group form-float">
															<div class="form-line" id="bs_datepicker_container" >
																<input type="date" name="dt" id="dt" class="form-control" value="<?php echo date('Y-m-d'); ?>"  >
																<label class="form-label">Date</label>
															</div>
														</div>
													</div>
													<div class="col-sm-6" style="margin: 0px;">
														<div class="form-group form-float">
															<div class="form-line">
																<input type="text"  name="billno"  id="billno" class="form-control" value="<?php echo $bill_no; ?>" readonly>
																<label class="form-label">Bill No</label>
															</div>
														</div>
													</div>
                                                </div>
                                                <div class="row" style="margin-top:5px;">
													<div class="col-sm-6" style="margin: 0px;">
														<div class="form-group form-float">
															<div class="form-line" id="ar_name_cont" >
                                                                  <input type="text"  name="ar_name"  id="ar_name" placeholder="Name" class="form-control" value="" />
															</div>
														</div>
													</div>
													<div class="col-sm-6" style="margin: 0px;">
														<div class="form-group form-float">
															<div class="form-line" id="bs_datepicker_container" >
																<select class="form-control" name="rasi_id" id="rasi_id">
                                                                    <option>Select Rasi</option>
                                                                    <?php foreach($rasi as $row) { ?>
                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name_eng'];?></option>
                                                                    <?php } ?>
                                                                </select>
															</div>
														</div>
													</div>
													<div class="col-sm-6" style="margin: 0px;">
														<div class="form-group form-float">
															<div class="form-line">
																<!--<select class="form-control" name="natchathra_id" id="natchathra_id">
                                                                    <option>Select Natchathiram</option>
                                                                    <?php
																	//foreach($nat1 as $res) {
																	//$nat_name = $this->db->table('natchathram')->where('id', $nat)->get()->getResultArray();
																	//foreach($nat as $row) { ?>
                                                                    <option value="<?php //echo $res; ?>"><?php //echo $res;?></option>
                                                                    <?php //} ?>
                                                                </select>-->
                                                                <input type="hidden" id="natchathram_id" name="natchathram_id" class="form-control">
                                                                <select class="form-control" name="natchathra_id" id="natchathra_id">
                                                                <option>Select Natchiram</option>
                                                                </select>
															</div>
														</div>
													</div>
													<div class="col-sm-6" style="margin: 0px;">
														<div class="form-group form-float">
															<div class="" id="ar_name_cont" >
                                                                  <button type="button"  name="ar_add_btn"  id="ar_add_btn" class="btn btn-info form-control">Add</button>
															</div>
														</div>
													</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group form-float" style="margin: 2px;">
                                                            <div class="form-line">
                                                                <!--<label>Comission To</label>-->
                                                                <select class="form-control" name="comission_to">
                                                                    <option value="0">Select Staff for Comission</option>
                                                                    <?php foreach($staff as $row) { ?>
                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name'];?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                    <input type="hidden" value="0" name="cnt" id="count">
													<div class="cart_tab_outer">
														<table class="cart-table">
															<thead>
																<th style="width: 40%;">Archanai Name</th>
																<th style="width: 20%; text-align: center;">RM</th>
																<th style="width: 8%; text-align: center;">Qty</th>
																<th style="width: 20%; text-align: center;">Total</th>
																<th style="width: 12%; text-align: center;">&nbsp;</th>
															</thead>
															<tbody class="cart-body scroll">
															</tbody>
														</table>
													</div>
                                                    <input type="hidden" value="0" name="cnt1" id="count1">
													<div class="cart_tab_outer">
														<table class="rasi-table">
															<thead>
																<th style="width: 38%;">Name</th>
																<th style="width: 32%;">Rasi</th>
																<th style="width: 30%;">Natchathra</th>
															</thead>
															<tbody class="rasi-body scroll">
															</tbody>
														</table>
													</div>
                                                    <hr>
													<div class="arch_total">
														<input type="hidden" class="tot" id="tot_amt" name="tot_amt" value="0.00">
														<strong>Total RM</strong> <span class="tot_amt_txt">0.00</span>
													</div>
                                                    <div class="row">
                                                        <div class="col-md-12" style="background:#FFFFFF;margin-top:5px;">                                                        
														<?php if($permission['create_p'] == 1) {?>														
														<div class="col-md-3 col-xs-4" align="left" style="margin-bottom: 0;">
                                                            <input  type="checkbox" checked="checked" id="print" name="print" value="Print">
                                                            <label for ='print'> &nbsp;&nbsp; </label>
                                                            <label id="submit" class="btn btn-success btn-lg waves-effect">PRINT</label>
                                                        </div>
														<div class="col-md-3 col-xs-4" align="left" style="margin-bottom: 0;">
                                                            <label id="submit_mob" class="btn btn-success btn-lg waves-effect">M Print</label>
                                                        </div>
                                                        <div class="col-md-3 col-xs-4" align="center" style="margin-bottom: 0;padding: 0px 12px">
                                                            <input  type="checkbox" id="s_print" name="s_print" value="Separate">
                                                            <label class="s_print" for ='s_print'> Separate </label>
                                                        </div>
                                                        <?php } ?>
														<div class="col-md-3 col-xs-4" align="right" style="margin-bottom: 0;">
                                                        <a style="float:right;"><button type="submit" class="btn btn-danger btn-lg waves-effect" id="clear">Clear All</button></a>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    
                            </div>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
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
</section>
<link href="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>

<script>
$(document).ready(function() {

    $('#dt').change(function() {
        $.ajax
            ({
                type:"POST",
                url: "<?php echo base_url();?>/archanaibooking/getbillno",
                data:{dt:$('#dt').val()},
                success:function(data)
                {
                    //alert(data);
                   $('#billno').val(data);
                }
            })
    });

    $('#search').keyup(function() {

    //alert($('#search').val());
    $.ajax
        ({
            type:"POST",
            url: "<?php echo base_url();?>/archanaibooking/show_product1",
            data:{prod:$('#search').val()},
            success: function (response) {
                //alert($('#search').val());
        		var obj=jQuery.parseJSON(response);
                console.log(obj.row)
                $('#products').empty();
                $('#products').append(obj.row);
                //alert(data);
            //$('#billno').val(data);
            }
        })
    });
	
	$("#clear").click(function() {
       $(".cart-table .all_close").empty();
       $("#count").val(0);
        sum_total();
    });
	
	$('tr td #remove').click(function() {
    	$(this).css({"display":"block"});
	});
	
	$('#ar_add_btn').on('click', function(){
		var ar_name = $('#ar_name').val();
		var rasi_id = $('#rasi_id').val();
		var rasi_text = $( "#rasi_id option:selected" ).text();
		var natchathra_id = $('#natchathra_id').val();
		var natchathra_text = $( "#natchathra_id option:selected" ).text();
		$('#ar_name').val('');
		$('#rasi_id').prop('selectedIndex',0);
		$("#rasi_id").selectpicker("refresh");
		//$('#rasi_id').val(0);
		$('#natchathra_id').prop('selectedIndex',0);
		$("#natchathra_id").selectpicker("refresh");
		$("#natchathra_id").empty();
		//$('#natchathra_id').val(0);
		var count1 = $('#count1').val(); 
		var html = '';
		html += '<tr>';
		html += '<td><input type="hidden" name="rasi['+count1+'][arc_name]" value="' + ar_name + '" /><label>' + ar_name + '</label></td>';
		html += '<td><input type="hidden" name="rasi['+count1+'][rasi_ids]" value="' + rasi_id + '" /><label>' + rasi_text + '</label></td>';
		html += '<td><input type="hidden" name="rasi['+count1+'][natchathra_ids]" value="' + natchathra_id + '" /><label>' + natchathra_text + '</label></td>';
		html += '</tr>';
		$('.rasi-table').append(html);
		count1++;
		$("#count1").val(count1);
		console.log(ar_name);
		console.log(rasi_id);
		console.log(rasi_text);
		console.log(natchathra_id);
		console.log(natchathra_text);
	});
	
	
	$("#rasi_id").change(function(){
	    var rasi = $("#rasi_id").val();
	    
            if(rasi != "")
			{
				//console.log(rasi_id);
				$.ajax({
					url: '<?php echo base_url();?>/archanaibooking/get_natchathram',
					type: 'post',
					data: {rasi_id:rasi},
					dataType: 'json',
					success:function(response)
					{
						$('#natchathram_id').val(response.natchathra_id);
						
						var str = response.natchathra_id;
						console.log(str);
						//return;
                        if(str !="") {
                            $("#natchathra_id").empty();
                            
    		                $('#natchathra_id').append('<option value="">Select Natchiram</option>');
                        	$.each(str.split(','), function(key, value) {
                        	    //$('#natchathra_id').append('<option value="' + value + '">' + value + '</option>');
                        	    $.ajax({
                					url: '<?php echo base_url();?>/archanaibooking/get_natchathram_name',
                					type: 'post',
                					data: {id:value},
                					dataType: 'json',
                					success:function(response)
                					{
                                    $('#natchathra_id').append('<option value="' + response.id + '">' + response.name_eng + '</option>');
                                    $('#natchathra_id').prop('selectedIndex',0);
    		                        $("#natchathra_id").selectpicker("refresh");
                					}
                        	    });
                            });
                        }
				    }
				});
			}
			/*if(rasi == "")
			{
				alert("empty");
			}*/
    });
    
    
    
});

    function sum_total(){
        var total_qty = 0;
        $( ".row_qty" ).each(function() {
            total_qty += parseFloat($( this ).val());
        });
        /* $("#tot_qty").text(total_qty); */

        var total_amt = 0;
        $( ".row_tot" ).each(function() {
            total_amt += parseFloat($( this ).val());
        });
        $("#tot_amt").val(Number(total_amt).toFixed(2));
        $(".tot_amt_txt").text(Number(total_amt).toFixed(2));

        
    }
    function remove(id){
        $(".cart-table #remov"+id).remove();

        $("#count").val(  parseInt($("#count").val())-1);
         sum_total();
    }

    function addtocart(ids){

		//if(!this.form.checkbox.checked){alert('You must agree to the terms first.');return false}
		//alert ($("#print").prop('checked')); 
        
        var text = $("#nm_"+ids).text();
        var amt = Number($("#amt_"+ids).attr("data-id")).toFixed(2);
        
        // let num = amt;
        // let n = num.toFixed(2);
         //alert (amt); exit;
        
        let exist_id=$("#remov"+ids).attr("data-id");
        exist_id = exist_id || 0;

        let exist_qty=$("#qty_"+ids).val();
        exist_qty = exist_qty || 0;
        
        
        if (exist_id==0 || exist_qty==0)
        {
            var count = $('#count').val();        
		
            var text1 = '<tr class="all_close" data-id="'+ids+'" id="remov'+ids +'"><td style="width: 40%;"><input type="hidden" id="id_'+ids+'" name="arch['+count+'][id]" value="'+ids+'" ><p>'+text+'</p></td>';
            text1 += '<td style="width: 20%;"><input type="text" style="text-align: center;" class="row_amt" readonly name="arch['+count+'][amt]" value="'+amt+'"></td>';
            text1 += '<td style="width: 8%;"><input type="text" style="text-align: center;" class="row_qty" name="arch['+count+'][qty]" onkeyup="man_qun('+ids+')" id="qty_'+ids+'" value="1"></td>';
            text1 += '<td style="width: 20%;"><input type="text" style="text-align: center;" class="row_tot"readonly  name="tot" id="tot_'+ids+'" value="'+amt+'"></td>';
            text1 += '<td style="width: 12%;"><button class="btn btn-info" style="font-size:10px;" onclick="remove('+ids+')" id="remove">X</button></td></tr>';
            $(".cart-table").append(text1);
            count++;
		
        $("#count").val(count);
		
        }
       
        else
        {
                $("#qty_"+ids).val(parseInt($("#qty_"+ids).val())+1);
                $("#tot_"+ids).val(Number(parseInt($("#qty_"+ids).val())*amt).toFixed(2));

        }
        sum_total();
        
    }

    function man_qun(ids){
        //alert(ids)
        sum_total();
        var amt = Number($("#amt_"+ids).attr("data-id")).toFixed(2);
        var cnt = $("#qty_"+ids).val();
        var tot = amt * cnt;
        $("#tot_"+ids).val(tot.toFixed(2));
        sum_total();
    }
</script>
  



