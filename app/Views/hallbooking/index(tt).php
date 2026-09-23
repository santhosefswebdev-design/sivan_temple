<style>
    .fc-title{
        font-size: 14px;
    }
	.fc-scroller, .fc-scroller .fc-day-grid .fc-week.fc-widget-content { height:auto !important; }
	
</style>
<link href="<?php echo base_url(); ?>/assets/demo.css" rel="stylesheet">
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2> HALL BOOKING <small>Transactions / <b>Hall Booking</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
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
<<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
<script src='<?php echo base_url(); ?>/assets/js/moment.min.js'></script>
<script src='<?php echo base_url(); ?>/assets/js/fullcalendar.min.js'></script>
<style>
</style>
<script>


$('#calendar').fullCalendar({
    
	header:{
			left:   'title',
			center: '',
			right:  'today prev,next'
	},
    // events: [
    //     {
    //         title: 'All Day Event',
    //         start: '2022-05-01',
    //         color: 'red',
    //         textColor: 'white',
    //     },{
    //         title: 'All Day Event',
    //         start: '2022-05-10',
    //         color: 'red',
    //         textColor: 'white',
    //     }],
	dayClick: function(date, jsEvent, view) {
        var date =  date.format();
        var forms = '<form action="<?php echo base_url();?>/hallbooking/hallbook_list" method="get">';
            forms += '<input type="text" name="date" value="'+date+'">';
            forms += '<button type="submit" id="hall_sub">';
            forms += '</form>';
        $("#book_list").append(forms);
        $("#hall_sub").trigger('click');
	}
});
</script>
      
