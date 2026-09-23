<body>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/mui/3.7.1/js/mui.min.js"
    integrity="sha512-5LSZkoyayM01bXhnlp2T6+RLFc+dE4SIZofQMxy/ydOs3D35mgQYf6THIQrwIMmgoyjI+bqjuuj4fQcGLyJFYg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="<?php echo base_url(); ?>/assets/plugins/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>/assets/js/imin-printer.min.js"></script>
	<script src="<?php echo base_url(); ?>/assets/js/dom-to-image.js"></script>
	<script src="https://cdn.bootcdn.net/ajax/libs/vConsole/3.9.1/vconsole.min.js"></script>
	<div id="archanai_ticket">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="<?php echo base_url(); ?>/assets/css/Barlow.css" rel="stylesheet">
		<style>
		body { font-family: 'Barlow', sans-serif; background: #fff; box-sizing: border-box;}
		table { border-collapse:collapse; }
		table td { padding:5px; }
		hr {
		  border:none;
		  border-top:1px dashed #000;
		  color:#fff;
		  background-color:#fff;
		  height:1px;
		}
		p{font-size: 13px;text-align: center;font-weight: 600;font-family: monospace;margin: 0px}
		#archanai_ticket{
			color: #000;
			background: #fff;
			padding: 5px;
			font-weight: 600;
			font-family: monospace;
			display: none;
		}
		#archanai_loader{
			display: flex;
			justify-content: center;
			align-items: center;
			width: 100%;
			height: 100%;
		}
		img{
			max-width: 100%;
		}
		</style>
		<?php 
		$i=1; foreach($booking as $row) 
			{
			$qty = $row['quantity']; 
			for($j=0; $j<$qty; $j++) 
				{ ?>

		<div style="max-width: 80mm;" class="arc">
			<style>
				body { font-family: 'Barlow', sans-serif; background: #fff; box-sizing: border-box;}
				table { border-collapse:collapse; }
				table td { padding:5px; }
				hr {
				  border:none;
				  border-top:1px dashed #000;
				  color:#fff;
				  background-color:#fff;
				  height:1px;
				}
				p{font-size: 13px;text-align: center;font-weight: 600;font-family: monospace;margin: 0px}
				.arc{
					color: #000;
					background: #fff;
					padding: 5px;
					font-weight: 600;
					font-family: monospace;
				}
				img{
					max-width: 100%;
				}
			</style>
			<p><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>" style="width:120px;" align="center"></p>
			<p><?php echo $temp_details['name']; ?></p>
			<p><?php echo $temp_details['address1']; ?></br><?php echo $temp_details['address2']; ?></br>
			<?php echo $temp_details['city'].'-'.$temp_details['postcode']; ?>
			<br>Tel: <?= $temp_details['telephone']; ?></p>
			<hr>
			<p style="text-align: center;">Date: <?php echo $qry1['created']; ?></p>
			<p style="text-align: center;">Bill NO: <?php echo $qry1['ref_no']; ?></p>
			<hr>

			<p style="text-align: left;">SNO&nbsp;&nbsp;PARTICULARS</p>
			<hr>
				<p style="text-align: left;"><?= $i++; ?>&nbsp;&nbsp;<?= $row['name_eng']; ?><br>&nbsp;&nbsp;
				   <?= $row['name_tamil']; ?><br>&nbsp;&nbsp;
				   <span style="font-size: 20px;">[RM <?= $row['amount']; ?> x 1 = RM <?= number_format($row['amount'],2); ?>]</span></p>
			<?php $row['amount']; ?>
			<hr>
			<p style="text-align: center; font-size: 24px;">Total:  RM <?= number_format($row['amount'],2); ?></p>
			<br><br><br><br><br><br>
		</div>
		 
		<?php 
				}
			} 
		?>

	</div>
	<div class="archanai_loader">
		<img src="<?php echo base_url(); ?>/assets/images/loader.gif" />
	</div>
	<div class="test_div">
	</div>
	<?php /* <img src="" id="test_img" /> */ ?>
	<?php /* <div>
		<button class="btn btn-primary" id="web_print">Web Print</button>
		<button class="btn btn-success" id="imin_print">Imin Print</button>
	</div> */ ?>
	<script>
		var vConsole = new VConsole();
		function printDiv(){

		  var divToPrint=document.getElementById('archanai_ticket');

		  var newWin=window.open('','Print-Window');

		  newWin.document.open();

		  newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

		  newWin.document.close();

		  setTimeout(function(){newWin.close();},1500);

		}
		$(document).ready(function(){
			$(document).on('click', '#web_print', function(){
				printDiv();
			});
			var tot_count = $('#archanai_ticket .arc').length;
			/* $('#archanai_ticket .arc').each(function(i){
				var node = this;
				domtoimage.toJpeg(node).then(function (dataUrl) {
					$('.test_div').append('<img src="' + dataUrl + '" />');
					IminPrintInstance.printSingleBitmap(dataUrl);
					IminPrintInstance.printAndFeedPaper(100);
					if(i >= (tot_count - 1)){setTimeout(function(){window.close();}, 1500);}
				});
			}); */
			/* var node = document.getElementById('archanai_ticket');
			domtoimage.toJpeg(node).then(function (dataUrl) {
				$('#test_img').attr('src', dataUrl);
			}); */
		});
		/* domtoimage.toJpeg(node).then(function (dataUrl) {
			$('#test_img').attr('src', dataUrl);
		}); */
		var IminPrintInstance = new IminPrinter();
  
		IminPrintInstance.connect().then(async (isConnect) => {
			if (isConnect) {
				$('.archanai_loader').hide();
				$('#archanai_ticket').show();
				var tot_count = $('#archanai_ticket .arc').length;
				var ticket = [];
				IminPrintInstance.initPrinter();
				console.log( IminPrintInstance.getPrinterStatus());
				$('#archanai_ticket .arc').each(function(i){
					var node = this;
					domtoimage.toJpeg(node).then(function (dataUrl) {
						$('.test_div').append('<img src="' + dataUrl + '" />');
						ticket[i] = dataUrl;
						console.log(IminPrintInstance.getPrinterStatus());
						if(i >= (tot_count - 1)){
							/* setTimeout(function(){window.close();}, 3500); */
							IminPrintInstance.printMultiBitmap(ticket);
							IminPrintInstance.printAndFeedPaper(100);
						}
					});
				});
			}else{
				alert('error printer');
			}
		});
	</script>
</body>