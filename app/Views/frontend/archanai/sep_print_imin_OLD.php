<body>
<?php /*
<script src="https://cdnjs.cloudflare.com/ajax/libs/mui/3.7.1/js/mui.min.js"
   integrity="sha512-5LSZkoyayM01bXhnlp2T6+RLFc+dE4SIZofQMxy/ydOs3D35mgQYf6THIQrwIMmgoyjI+bqjuuj4fQcGLyJFYg=="
   crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <script src="https://cdn.bootcdn.net/ajax/libs/vConsole/3.9.1/vconsole.min.js"></script>
*/ ?>
<script src="<?php echo base_url(); ?>/assets/js/mui.min.js"
	integrity="sha512-5LSZkoyayM01bXhnlp2T6+RLFc+dE4SIZofQMxy/ydOs3D35mgQYf6THIQrwIMmgoyjI+bqjuuj4fQcGLyJFYg=="
	crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?php echo base_url(); ?>/assets/js/vconsole.min.js"></script>
	<script src="<?php echo base_url(); ?>/assets/plugins/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>/assets/js/imin-printer-2.min.js"></script>
	<script src="<?php echo base_url(); ?>/assets/js/dom-to-image.js"></script>
	
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
		p{font-size: 20px;text-align: center;font-weight: 600;font-family: monospace;margin: 0px}
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
		//print_r($rasi);
		$i=1; foreach($booking as $row) 
			{
			$qty = $row['quantity']; 
			for($j=0; $j<$qty; $j++) 
				{ ?>

		<div style="width: 150mm;font-weight: 600;font-family: monospace;"  class="arc">
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
				p{font-size: 20px;text-align: center;font-weight: 600;font-family: monospace;margin: 0px}
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
			<p><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>" style="width:200px;" align="center"></p>
			<h2 style="text-align:center; margin:0"><?php echo $temp_details['name']; ?></b></h2>
			<p><?php echo $temp_details['address1']; ?>, <?php echo $temp_details['address2']; ?></br>
			<?php echo $temp_details['city'].'-'.$temp_details['postcode']; ?>. 
			Tel: <?= $temp_details['telephone']; ?></p>
			<hr>
			<p style="text-align: center;">Date: <?php echo $qry1['created']; ?></p>
			<p style="text-align: center;">Bill NO: <?php echo $qry1['ref_no']; ?></p>
			<hr>

			<p style="text-align: left;">SNO&nbsp;&nbsp;PARTICULARS</p>
			<hr>
			<p style="text-align: center;"><img src="<?php echo base_url(); ?>/uploads/archanai/watermark/<?php echo $row['watermark_image']; ?>" style="width:200px;" align="center" alt="image" style="display:block;margin:0 auto;"></p>
				<p style="text-align: left;"><?= $i++; ?>&nbsp;&nbsp;<?= $row['name_eng']; ?><br>&nbsp;&nbsp;
				   <?= $row['name_tamil']; ?><br>&nbsp;&nbsp;
				   <span style="font-size: 32px;">[RM<?= $row['amount']; ?> x 1 = RM<?= number_format($row['amount'],2); ?>]</span></p>
			<?php $row['amount']; ?>
			<hr>
			<p style="text-align: center; font-size: 40px;">Total:  RM<?= number_format($row['amount'],2); ?></p>
			<?php 
			if($row['archanai_category'] == 2){
				if(!empty($vehicles)) {  ?>
				<hr>
				<br>
				<table style="width:100%;">
					<tr>
						<th align="left">Name</th>
						<th align="left">Vehicle No</th>
					</tr>
					<?php foreach($vehicles as $vehicle) { ?>
						<tr>
							<td style="font-size:24px;"><?= $vehicle['name']; ?></td>
							<td style="font-size:24px;"><?= $vehicle['vehicle_no']; ?></td>
						</tr>
					<?php } ?>
				</table>
				<?php 
				}
			}
			 ?>
			<br>			 
			<?php 
			foreach($booking as $row1) {
				if($row1['groupname'] == 'NAVAGRAHAM PEYERCHI') { 
				?>
				<p style="text-align:center;font-size:30px;text-transform:uppercase;">1 free small vilaku</p>
				<?php 
				} 
			} 
			?>			 
			<?php if(!empty($rasi) && $row['archanai_category'] == 1){ ?>
				<hr>
				<table style="width:100%;">
					<tr><th align="left">Name</th><th align="left">Rasi</th><th align="left">Natchathram</th></tr>
					<?php foreach($rasi as $res) { ?>
					<tr><td><?= $res['name']; ?></td>
					<td><?= $res['rasi_name_tamil']; ?><br><?= $res['rasi_name_eng']; ?></td>
					<td><?= $res['nat_name_tamil']; ?><br><?= $res['nat_name_eng']; ?></td></tr>
					<?php } ?>
				</table>
			<?php } ?>
			<hr>
			<br>
			<?php 
			$k=0; 
			if($row['archanai_category'] == 3)
			{
			$k = $k+1;
			}
			if($k > 0)
			{
			?>
			<hr>
			<!--img src="<?php echo base_url(); ?>/assets/1671017506_fruit_arsanai.jpg" width="100" height="80" alt="image" style="display:block;margin:0 auto;"-->
			<p style="text-align:center;font-size:30px;">Archanai Kalanji <br> அர்ச்சனை காளாஞ்சி </p>
			<br>
			<?php
			}
			?>
			<?php /* <img src="<?php echo $qrcdoee; ?>" style="display:block;margin:0 auto;" width="250" height="250">
			<p style="text-align:center;font-size:20px;font-weight:bold;">["PLEASE SCAN HERE"]</p> */ ?>
			<br><br>
			<p  class="dot_line"><span>---</span>GRASP SOFTWARE SOLUTIONS SDN. BHD.<span>---</span></p>
			<hr>
			<br>
		</div>
		<br><br><br>
		 
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
	console.log('IminPrintInstance');
	console.log(IminPrintInstance);
	let isConnect = false;
	IminPrintInstance.connect().then(async (connect) => {
		if (connect) {
			isConnect = true;
			$('.archanai_loader').hide();
			$('#archanai_ticket').show();
			initiate_load();
		}else{
			alert('error printer');
		}
	});
	function initiate_load(){
		if(isConnect){
			var tot_count = $('#archanai_ticket .arc').length;
			var ticket = [];
			console.log( IminPrintInstance.getPrinterStatus());
			IminPrintInstance.initPrinter();
			//IminPrintInstance.setPageFormat(0);
			var i = 0;
			$('#archanai_ticket .arc').each(function(){
				var node = this;
				domtoimage.toJpeg(node).then(function (dataUrl) {
					console.log('i=' + i);
					ticket[i] = dataUrl;
					if(i >= (tot_count - 1)){
						print_queue(IminPrintInstance, ticket, 0);
					}
					i++;
				});
			});
		}
	}
	async function print_queue(IminPrintInstance, ticket, i){
		if(i < ticket.length){
			console.log(IminPrintInstance.getPrinterStatus());
			console.log('test');
			//IminPrintInstance.initPrinter();
			$('.test_div').append('<img src="' + ticket[i] + '" />');
			await IminPrintInstance.printSingleBitmap(ticket[i]);
			await IminPrintInstance.printAndFeedPaper(100);
			await IminPrintInstance.partialCut();
			print_queue(IminPrintInstance, ticket, i + 1);
		}else{
			IminPrintInstance.openCashBox();
			setTimeout(function(){window.close();},500);
		}
	}
	</script>
</body>