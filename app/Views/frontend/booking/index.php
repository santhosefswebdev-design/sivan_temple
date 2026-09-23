<style>    
.fc-title{
	font-size: 14px;
}
.fc-scroller, .fc-scroller .fc-day-grid .fc-week.fc-widget-content { height:auto !important; overflow:visible !important; }
.fc th {
	background: #ea441b !important;
	color: #FFFFFF;
	padding: 10px;
	font-size:16px;
	text-transform:uppercase;
}
.fc td {
    background: #0707078a !important;
    color: #FFFFFF;
    max-height: 35px;
}
.fc-unthemed .fc-today {
    background: #000000 !important;
}
@media (max-width: 767px) {
	.fc-basic-view .fc-week-number, .fc-basic-view .fc-day-number {
		padding: 10px 5px !important;
		font-size: 12px !important;
		display: block;
	}
	.fc-title {
		font-size: 8px !important;
		white-space:break-spaces;
	}
	.fc table {
		font-size: 12px  !important;
	}
	.fc th {
		font-size:12px;
	}
}
</style>
<link href="<?php echo base_url(); ?>/assets/demo.css" rel="stylesheet">
<div id="banner-area" class="banner-area" style="background-image:url(<?php echo base_url(); ?>/assets/frontend/images/banner/banner5.jpg)">
  <div class="container">
     <div class="row">
        <div class="col-sm-12">
           <div class="banner-heading">
              <h1 class="banner-title">Hall Booking</h1>
              <ol class="breadcrumb">
                 <li>Home</li>
                 <li><a href="#">Hall Booking</a></li>
              </ol>
           </div>
        </div>
     </div>
  </div>
</div>

<section class="content"> 
    <div class="container">
    <div class="row">
        <!-- Basic Examples -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <!--<div class="header">
                        <div class="row"><div class="col-md-12"><h2>Hall Booking</h2></div></div>
                    </div>-->
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
                    
                    
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10"><div id="calendar">
                        </div></div>
                        <div class="col-md-1"></div>
                    </div>
                    
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 
<div id="book_list">
    <p></p>
</div>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
<script src='<?php echo base_url(); ?>/assets/js/moment.min.js'></script>
<script src='<?php echo base_url(); ?>/assets/js/fullcalendar.min.js'></script>
<style>
</style>
<script>



</script>
      
