<?php $db = db_connect(); ?>
<?php $booking_calendar_range_year = booking_calendar_range_year($_SESSION['booking_range_year']); ?>
<?php $overall_temple_block_dates = get_overall_temple_block_dates(); ?>
<style>
    <?php if ($view == true) { ?>
        label.form-label span {
            display: none !important;
            color: transporant;
        }

    <?php } ?>
</style>
<?php
if ($view == true) {
    $readonly = 'readonly';
    $disable = "disabled";
}
?>

<style>    
.fc-title{
	font-size: 14px;
}
.fc-scroller, .fc-scroller .fc-day-grid .fc-week.fc-widget-content { height:auto !important; }
.fc th {
	background: #04214e !important;
	color: #FFFFFF;
	padding: 10px;
	font-size:16px;
	text-transform:uppercase;
}
@media (max-width: 767px) {
	.fc-basic-view .fc-week-number, .fc-basic-view .fc-day-number {
		padding: 20px 14px !important;
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
}
.fc-day-grid-event .fc-content {
    white-space: unset!important;
    overflow: auto!important;
}
.fc-blocked
{
    background:#000000!important;
    /*background:#f5ed23!important;*/
}
</style>
<link href="<?php echo base_url(); ?>/assets/demo.css" rel="stylesheet">
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2> UBAYAM<small>Ubayam / <b>Ubayam Calendar</b></small></h2>
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
<!--<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>-->
<script src='<?php echo base_url(); ?>/assets/js/moment.min.js'></script>
<script src='<?php echo base_url(); ?>/assets/js/fullcalendar.min.js'></script>
<style>
</style>
<script>
$('#calendar').fullCalendar({
    events: function(start, end, timezone, callback) {
        $.ajax({
            url: '<?php echo base_url();?>/ubayam/ubayam_list',
            dataType: 'json',
            success: function(data) {
                console.log(data)
                var events = [];
                for(var i =0; i < data.length; i++){
                    events.push({
                        title: data[i].name,
                        start:  data[i].date,// will be parsed
                        color: 'red',
                        textColor: 'white',
						//tip: 'Personal tip 1',
                    });
                }
                // events.push({
                //         title: 'ghjjj',
                //         start:  '2023-02-10',// will be parsed
                //         color: 'red',
                //         textColor: 'white',
                //     });
                callback(events);
            }
        })
    },
    fixedWeekCount: false,
    header: {
        left: 'title',
        center: '',
        right: 'prevYear,prev,today,next,nextYear'
    },
    /*dayRender: function (date, cell) {
        var maxDate = moment().add(<?php echo $_SESSION['booking_range_year']; ?>, 'years');
        console.log(cell);
        if (date > maxDate || date < moment()) {
            cell.addClass('fc-disabled');
        }
        var start = moment(date, 'DD.MM.YYYY').format('YYYY-MM-DD');
        $.ajax({
            url: "<?php echo base_url();?>/hallbooking/overall_blocked_event_check",
            type: "POST",
            data:{eventdate: start},
            success: function(data) {
                if (start == data){
                    cell.addClass('fc-blocked');
                }
            }
        });
    },*/
    dayClick: function(date, jsEvent, view) {
        var maxDate = moment().add(<?php echo $_SESSION['booking_range_year']; ?>, 'years');
        var end_date = moment(maxDate, 'DD.MM.YYYY').format('YYYY-MM-DD');
        var choosed_date = moment(date, 'DD.MM.YYYY').format('YYYY-MM-DD');
        var current_date = moment().format('YYYY-MM-DD');
        //if (choosed_date <= end_date && choosed_date >= current_date) {
            var start = moment(date, 'DD.MM.YYYY').format('YYYY-MM-DD');
            $.ajax({
                url: "<?php echo base_url();?>/hallbooking/overall_blocked_event_check",
                type: "POST",
                data:{eventdate: start},
                success: function(data) {
                    if (start == data){
                        $('#calendar').fullCalendar('unselect');
                        return false;
                    }
                    else
                    {
                        var forms = '<form action="<?php echo base_url();?>/ubayam" method="get">';
                        forms += '<input type="hidden" name="date" value="'+date.format()+'">';
                        forms += '<button type="submit" id="hall_sub"></button>';
                        forms += '</form>';
                        $("#book_list").append(forms);
                        $("#hall_sub").trigger('click');
                    }
                }
            });

            
        /*} else {
            alert('Selected date is out of range. Please select a date between today and <?php echo $_SESSION['booking_range_year']; ?> years from now.');
        }*/
    }
});

</script>

      
