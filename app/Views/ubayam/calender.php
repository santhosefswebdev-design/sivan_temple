<?php global $lang;?>
<style>    
    .fc-title{
        font-size: 14px;
    }
	.fc-scroller, .fc-scroller .fc-day-grid .fc-week.fc-widget-content { height:auto !important; }
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
</style>
<link href="<?php echo base_url(); ?>/assets/demo.css" rel="stylesheet">
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2><?php echo $lang->ubayam; ?>  <?php echo $lang->calendar; ?><small><?php echo $lang->ubayam; ?>  / <b><?php echo $lang->ubayam; ?>  <?php echo $lang->calendar; ?></b></small></h2>
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
	
	eventMouseover: function(calEvent, jsEvent) {
		var tooltip = '<div class="tooltipevent" style="width:auto;height:auto;background:#ccc;position:absolute;padding:10px;z-index:10001;">' + calEvent.title + '</div>';
		var $tooltip = $(tooltip).appendTo('body');
	
		$(this).mouseover(function(e) {
			$(this).css('z-index', 10000);
			$tooltip.fadeIn('500');
			$tooltip.fadeTo('10', 1.9);
		}).mousemove(function(e) {
			$tooltip.css('top', e.pageY + 10);
			$tooltip.css('left', e.pageX + 20);
		});
	},
	
	eventMouseout: function(calEvent, jsEvent) {
		$(this).css('z-index', 8);
		$('.tooltipevent').remove();
	},
	
	fixedWeekCount: false,
	header:{
			left:   'title',
			center: '',
			right:  'today prev,next'
	},
	// dayClick: function(date, jsEvent, view) {
    //     var date =  date.format();
    //     var forms = '<form action="<?php echo base_url();?>/ubayam" method="get">';
    //         forms += '<input type="hidden" name="date" value="'+date+'">';
    //         forms += '<button type="submit" id="hall_sub">';
    //         forms += '</form>';
    //     $("#book_list").append(forms);
    //     $("#hall_sub").trigger('click');
	// }
})
</script>
      
