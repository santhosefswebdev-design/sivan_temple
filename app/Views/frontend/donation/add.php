<?php 
if($view == true){
    $readonly = 'readonly';
    $disable = "disabled";
}
?>
<style>
<?php if($view == true) { ?>
label.form-label span { display:none !important; color:transporant; }
<?php } ?>
</style>
<div id="banner-area" class="banner-area" style="background-image:url(<?php echo base_url(); ?>/assets/frontend/images/banner/banner5.jpg)">
  <div class="container">
     <div class="row">
        <div class="col-sm-12">
           <div class="banner-heading">
              <h1 class="banner-title">Cash Donation</h1>
              <ol class="breadcrumb">
                 <li>Home</li>
                 <li><a href="#">Donation</a></li>
              </ol>
           </div>
        </div>
     </div>
  </div>
</div> 
<section class="content">
    <div class="container my-5">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
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
                    <form action="<?php echo base_url(); ?>/donation_online/save" method="POST" >
                    <div class="body">
                        <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                        <div class="container-fluid">
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <label class="form-label">Date <span style="color: red;">*</span></label>
                                <input type="date" name="date" class="form-control" value="<?php if($view == true) echo date("Y-m-d",strtotime($data['date'])); else echo date("Y-m-d");?>" <?php echo $readonly; ?> required> 
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" style="">Donation <span style="color: red;">*</span></label>
                                <select class="form-control" name="pay_for" id="pay_for" <?php echo $disable; ?> required>
                                    <option value="">-- Select Donation --</option>
                                    <?php foreach($sett_don as $row) { ?>
                                    <option value="<?php echo $row['id']; ?>" <?php if($data['pay_for'] == $row['id']){ echo "selected"; } ?>><?php echo $row['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label">Target Amount </label>
                                <input type="text" id="targetamt" name="targetamt" class="form-control" value="0" readonly="">		
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label">Collected Amount </label>
                                <input type="text" id="collectedamt" name="collectedamt" class="form-control" value="0" readonly="">		
                            </div>
                            <div class="col-sm-4 bal_amnt_div">
                                <label class="form-label">Balance Amount </label>
                                <input type="text" id="balanceamt" class="form-control" value="0" readonly="">		
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Name <span style="color: red;">*</span></label>
                                <input type="text" name="name" class="form-control" value="<?php echo $data['name'];?>" <?php echo $readonly; ?> required>         
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Address</label>
                                <input type="text"  name="address" class="form-control" value="<?php echo $data['address'];?>" <?php echo $readonly; ?> >      
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Ic Number</label>
                                <input type="text" name="ic_number" class="form-control" value="<?php echo $data['ic_number'];?>" <?php echo $readonly; ?> >         
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Mobile Number</label>
                                <input type="text" name="mobile" class="form-control" value="<?php echo $data['mobile'];?>" <?php echo $readonly; ?> >       
                            </div>          
                            <div class="col-sm-6">
                                <label class="form-label">Remarks</label>
                                <input type="text" name="description" class="form-control" value="<?php echo $data['description'];?>" <?php echo $readonly; ?> >
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Amount <span style="color: red;">*</span></label>
                                <input type="number" step="0.1" name="amount" class="form-control" step=".01"  value="<?= $data['amount'] ?>" <?php echo $readonly; ?> required>        
                            </div>
                            <div class="col-md-12">&nbsp;</div>                          
                            <?php if($view != true) { ?>
                            <div class="col-sm-12" align="center" style="margin-top:20px;">  
                                <button class="btn btn-success" type="submit" >Submit</button>
                            </div>  
                            <?php } ?>
                        </div>   
                    </div> 
                    </div> 
                    </form>
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
<style>
.bal_amnt_div{
	display: none;
}
</style>
<script>
    $("#clear").click(function(){
        $("input").val("");
    });
	$('#pay_for').on('change', function(){
		var setting_id = this.value;
		$.ajax({
            type:"POST",
            url: "<?php echo base_url(); ?>/donation_online/get_donation_amount",
            data: {setting_id, setting_id},
			dataType: 'json',
            success:function(data){
                console.log(data.data);
				if(typeof data.data != 'undefined'){
					$('#targetamt').val(data.data.total_amount);
					$('#collectedamt').val(data.data.collected_amount);
					var balance_amount = parseFloat(data.data.total_amount) - parseFloat(data.data.collected_amount);
					if(balance_amount >= 0){
						$('.bal_amnt_div').show();
						$('#balanceamt').val(balance_amount);
					}else $('.bal_amnt_div').hide();
				}else{
					$('#targetamt').val(0);
					$('#collectedamt').val(0);
					$('#balanceamt').val(0);
					$('.bal_amnt_div').hide();
				}
            },
			error:function(err){
				console.log('err');
				console.log(err);
				$('#targetamt').val(0);
				$('#collectedamt').val(0);
				$('#balanceamt').val(0);
				$('.bal_amnt_div').hide();
			}
        });
	});
    $("#submit").click(function(){
        $.ajax
        ({
            type:"POST",
            url: "<?php echo base_url(); ?>/donation/save",
            data: $("form").serialize(),
            success:function(data)
            {
                obj = jQuery.parseJSON(data);
                if(obj.err != ''){
                    $('#alert-modal').modal('show', {backdrop: 'static'});
                    $("#spndeddelid").text(obj.err);
                }else{					
					if ($("#print").prop('checked')==true)	
						{
							printData(obj.id);
						}
						else 
							window.location.reload(true);
                }
            }
        });
    });  

    function printData(id) {
        $.ajax({
            url: "<?php echo base_url(); ?>/donation/print_page/"+id,
            type: 'POST',
            success: function (result) {
                //console.log(result)
                popup(result);
            }
        });
    }

    //setTimeout(popup(data), 500000);
	function popup(data)
    {
        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        frame1.css({"position": "absolute", "top": "-1000000px"});
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        //Create a new HTML document.
        frameDoc.document.write('<html>');
        frameDoc.document.write('<head>');
        frameDoc.document.write('<title></title>');
        frameDoc.document.write('</head>');
        frameDoc.document.write('<body >');
        frameDoc.document.write(data);
        frameDoc.document.write('</body>');
        frameDoc.document.write('</html>');
        frameDoc.document.close();
        setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
            window.location.reload(true);
        }, 500);
		
			frameDoc.onload(function() { 
				frameDoc.focus();
				frameDoc.print();
				frameDoc.close();
			});

        frame1.remove();
        //window.location.replace("<?php echo base_url();?>/donation");
		window.location.reload(true);
        //return true;
    }

</script>