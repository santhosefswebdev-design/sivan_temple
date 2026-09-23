<body>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/mui/3.7.1/js/mui.min.js"
    integrity="sha512-5LSZkoyayM01bXhnlp2T6+RLFc+dE4SIZofQMxy/ydOs3D35mgQYf6THIQrwIMmgoyjI+bqjuuj4fQcGLyJFYg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="<?php echo base_url(); ?>/assets/plugins/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>/assets/js/imin-printer-1.min.js"></script>
	<script src="<?php echo base_url(); ?>/assets/js/dom-to-image.js"></script>
	<script src="https://cdn.bootcdn.net/ajax/libs/vConsole/3.9.1/vconsole.min.js"></script>
	<div style="max-width: 80mm;font-weight: 600;font-family: monospace;" id="archanai_ticket">
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
		<?php $total = 0; $i=1; foreach($booking as $row) { ?>
			<p style="text-align: left;"><?= $i++; ?>&nbsp;&nbsp;<?= $row['name_eng']; ?><br>&nbsp;&nbsp;
			   <?= $row['name_tamil']; ?><br>&nbsp;&nbsp;
			   <span style="font-size: 20px;">[RM <?= $row['amount']; ?> x <?= $row['quantity']; ?> = RM <?= number_format($row['quantity'] * $row['amount'],2); ?>]</span></p>
		<?php $total += $row['quantity'] * $row['amount']; } ?>
		<hr>
		<table style="width:100%;">
		<tr><th align="left">Name</th><th align="left">Rasi</th><th align="left">Natchathram</th></tr>
		<?php foreach($rasi as $res) { ?>
		<tr><td><?= $res['name']; ?></td>
		<td><?= $res['rasi_name_tamil']; ?><br><?= $res['rasi_name_eng']; ?></td>
		<td><?= $res['nat_name_tamil']; ?><br><?= $res['nat_name_eng']; ?></td></tr>
		<?php } ?>
		</table>
		<p style="text-align: center; font-size: 24px;">Total:  RM <?= number_format($total,2); ?></p>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
	</div>
	<div class="archanai_loader">
		<img src="<?php echo base_url(); ?>/assets/images/loader.gif" />
	</div>
	<?php /* <img src="" id="test_img" /> */ ?>
	<?php /* <div>
		<button class="btn btn-primary" id="web_print">Web Print</button>
		<button class="btn btn-success" id="imin_print">Imin Print</button>
	</div> */ ?>
	<script>
		//var vConsole = new VConsole();
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
			/* var node = document.getElementById('archanai_ticket');
			domtoimage.toJpeg(node).then(function (dataUrl) {
				$('#test_img').attr('src', dataUrl);
			}); */
		});
		var IminPrintInstance = new IminPrinter();
  
		IminPrintInstance.connect().then(async (isConnect) => {
			if (isConnect) {
				$('.archanai_loader').hide();
				$('#archanai_ticket').show();
				console.log( await IminPrintInstance.getPrinterStatus());
				var QrCodeSize;
				//mui('body').on('tap', '#imin_print', async function (e) {
				IminPrintInstance.initPrinter();
				console.log( await IminPrintInstance.getPrinterStatus());
				var node = document.getElementById('archanai_ticket');
				domtoimage.toJpeg(node).then(function (dataUrl) {
					IminPrintInstance.printSingleBitmap(dataUrl);
					IminPrintInstance.printAndFeedPaper(100);
					/* IminPrintInstance.partialCut(); */
					setTimeout(function(){window.close();}, 1500);
				});
				//});
			}else{
				alert('error printer');
			}
		});
	</script>
</body>