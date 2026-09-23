<?php global $lang;?>
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
</style>
<link href="<?php echo base_url(); ?>/assets/demo.css" rel="stylesheet">
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Overall Temple Block <small>Profile / <b>Overall Temple Block</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <!--<div class="header">
                        <div class="row"><div class="col-md-12"></div></div>
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

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $lang->hall; ?> <?php echo $lang->blocking; ?></h4>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url(); ?>/templeblock/block_event_add" method="POST">
            <input type="hidden" name="event_date" id="event_date">
            <input type="hidden" name="event_id" id="event_id">
            <div class="body">
                <div class="container-fluid">
                <div class="row clearfix">
                    <div class="col-sm-12">
                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <textarea class="form-control" name="description" id="description" required></textarea>
                                <label class="form-label"><?php echo $lang->description; ?></label>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="row clearfix" id="warning_message">
                </div>
                <div class="row clearfix">
                    <div class="col-sm-6" id="show_hide_delete" align="left" style="background-color: white;padding-bottom: 1%;display:none;">
                        <button id="delete_hall_block" class="btn btn-danger btn-lg waves-effect"><?php echo $lang->delete; ?></button>
                    </div>
                    <div class="col-md-12" id="change_colmdname" align="right" style="background-color: white;padding-bottom: 1%;">
                        <button type="submit" name="submit_hallblocking" class="btn btn-success btn-lg waves-effect"><?php echo $lang->submit; ?></button>
                    </div>
                </div>                    
            </div>
            </div>
        </form>
      </div>
    </div>

  </div>
</div>

<!--<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>-->
<script src='<?php echo base_url(); ?>/assets/js/moment.min.js'></script>
<script src='<?php echo base_url(); ?>/assets/js/fullcalendar.min.js'></script>
<style>
    .blockingDay {
        background-color: gray !important;
    }
</style>

<script>
        var doubleClick = false;
         $('#calendar').fullCalendar({
             editable: true,
             // events: SITEURL + "/calender",
            events: function(start, end, timezone, callback) {
                $.ajax({
                    url: "<?php echo base_url();?>/templeblock/block_event_list",
                    dataType: 'json',
                    success: function(data) {
                        var events = [];
                        for(var i =0; i < data.length; i++){
                            events.push({
                                title:  data[i].description,
                                start:  data[i].booking_date,// will be parsed
                                end:  data[i].booking_date,// will be parsed
                                id:  data[i].id,// will be parsed
                                color: 'red',
                                textColor: 'white',
                            });
                            //$('#description').val(data[i].description);
                        }
                        callback(events);
                    },
                    error : function(data) {
                        alert("Ajax call error");
                        return false;
                    },
                });
            },
         displayEventTime: false,
         editable: true,
         eventRender: function (event, element, view) {
             if (event.allDay === 'true') {
                 event.allDay = true;
             } else {
                 event.allDay = false;
             }
         },
         selectable: true,
         selectHelper: true,
         select: function (start, end, allDay) {
			$('#warning_message').html('');
            var maxDate = moment().add(<?php echo $_SESSION['booking_range_year']; ?>, 'years');
            var end_date = moment(maxDate, 'DD.MM.YYYY').format('YYYY-MM-DD');
            var choosed_date = moment(start, 'DD.MM.YYYY').format('YYYY-MM-DD');
            var choosed_date_dmy = moment(start, 'DD.MM.YYYY').format('DD-MM-YYYY');
            var current_date = moment().format('YYYY-MM-DD');
            //alert(moment().format('YYYY-MM-DD'));
            //alert(end_date);
			$.ajax({
                url: "<?php echo base_url();?>/templeblock/hall_ubayam_event_check",
                data: {
                    eventdate: choosed_date,
                },
				dataType: 'json',
                type: "POST",
                success: function (result) {
                    console.log(result);
					if(result.length > 0){
						var html = '<div class="col-md-12"><div class="my_event_title">Some events are already booked in the date(' + choosed_date_dmy + ')</div><ul class="all_event_list">';
						for(var i=0; i<result.length; i++){
							html += '<li>' + result[i].event_name +' (' + result[i].ref_no + ')</li>';
						}
						html += '</ul></div>';
						$('#warning_message').html(html);
					}
                },
				error: function (err) {
                    console.log('err');
                    console.log(err);
                }
            });
            if (choosed_date <= end_date && choosed_date >= current_date) {
                var date =  start.format();
                var now =  new Date();
                var today =  now.toISOString().substring(0,10);
                if(date >= today){
                    var start = moment(start, 'DD.MM.YYYY').format('YYYY-MM-DD');
                    var end = moment(end, 'DD.MM.YYYY').format('YYYY-MM-DD');
                    $.ajax({
                        url: "<?php echo base_url();?>/templeblock/blocked_event_check",
                        type: "POST",
                        data:{eventdate: start},
                        success: function(data) {
                            if (start == data){
                                $('#calendar').fullCalendar('unselect');
                                $('#myModal').modal("hide");
                                return false;
                            }
                            else
                            {
                                $('#myModal').modal("show");
                                $('#event_date').val(start);
                                $('#description').val("");
                                $('#event_id').val("");
                                $('#show_hide_delete').hide();
                                $('#change_colmdname').removeClass('col-md-6');
                                $('#change_colmdname').addClass('col-md-12');
                            }
                        }
                    });
                }
            }
         },
         eventDrop: function (event, data) {
           var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
           var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
           $('#myModal').modal("show");
           $.ajax({
                 url: "<?php echo base_url();?>/templeblock/block_event_update",
                 data: {
                     title: event.title,
                     start: start,
                     end: end,
                     id: event.id
                 },
                 type: "POST",
                 success: function (response) {
                     displayMessage("Event successfully updated!");
                 }
             });
         },
         eventClick: function (event, date, view) {
            var current_date = moment().format('YYYY-MM-DD');
            var event_date = moment(event.start, 'DD.MM.YYYY').format('YYYY-MM-DD');
            if(event_date >= current_date){
                var title = event.title;
                if (title){
                    $('#myModal').modal("show");
                    $('#event_date').val(moment(event.start, 'DD.MM.YYYY').format('YYYY-MM-DD'));
                    $('#description').val(event.title);
                    $('#event_id').val(event.id);
                    $('#show_hide_delete').show();
                    $('#change_colmdname').removeClass('col-md-12');
                    $('#change_colmdname').addClass('col-md-6');
                }
            }
        },
        dayRender: function (date, cell) {
            var maxDate = moment().add(<?php echo $_SESSION['booking_range_year']; ?>, 'years');
            if (date > maxDate || date < moment()) {
                cell.addClass('fc-disabled');
            }
        },
        dayClick: function(date,event,jsEvent, view) {
            var maxDate = moment().add(<?php echo $_SESSION['booking_range_year']; ?>, 'years');
            var end_date = moment(maxDate, 'DD.MM.YYYY').format('YYYY-MM-DD');
            var choosed_date = moment(date, 'DD.MM.YYYY').format('YYYY-MM-DD');
            var current_date = moment().format('YYYY-MM-DD');
            if (choosed_date <= end_date && choosed_date >= current_date) {
                if(jsEvent.start <= date && jsEvent.end >= date) {
                    return true;
                }
                return false;
            } else {
                alert('Selected date is out of range. Please select a date between today and <?php echo $_SESSION['booking_range_year']; ?> years from now.');
            }
        }
     });

$(document).ready(function(){
  $("#delete_hall_block").click(function(){
    //var deleteMsg = confirm("Do you really want to delete this event?");
    //if(deleteMsg)
    //{
        var eventid = $('#event_id').val();
        if (eventid) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>/templeblock/block_event_delete",
                data: {
                        id: eventid
                },
                success: function (response) {
                    //displayMessage("Hallblocking Data Deleted Successfully!");
                    //location.reload();
                }
            });
        }
    //}
  });
});


function displayMessage(message) {
    toastr.success(message, 'Event');
} 
</script>

<!--script>


$('#calendar').fullCalendar({
    events: function(start, end, timezone, callback) {
        $.ajax({
            url: '<?php echo base_url();?>/templeblock/block_event_list',
            dataType: 'json',
            success: function(data) {
                //console.log(data)
                var events = [];
                for(var i =0; i < data.length; i++){
                    events.push({
                        title:  data[i].description,
                        start:  data[i].booking_date,// will be parsed
                        color: 'red',
                        textColor: 'white',
                    });
                    $('#description').val(data[i].description);
                }
                callback(events);
            }
        })
    },
    eventClick:  function(event, jsEvent, view) {
        $('#description').val(event.description);
        $('#myModal').modal("show");
    },
	fixedWeekCount: false,
	header:{
			left:   'title',
			center: '',
			right:  'today prev,next'
	},
	dayClick: function(date, jsEvent, view) {
        $("#myModal").modal("show");
        $('#event_date').val(date.format());
	}
})
</script-->