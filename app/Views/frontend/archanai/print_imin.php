<?php $db = db_connect(); ?>
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
	
	<div style="width: 150mm;font-weight: 600;font-family: monospace;" id="archanai_ticket">
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
		tr td, tr th{font-size: 20px;}
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
		<h2 style="text-align:center; margin:0"><?php echo $temp_details['name']; ?></h2>
		<p><?php echo $temp_details['address1']; ?>, <?php echo $temp_details['address2']; ?></br>
		<?php echo $temp_details['city'].'-'.$temp_details['postcode']; ?>.
		Tel: <?= $temp_details['telephone']; ?></p>
		<hr>
		<p style="text-align:center;font-size:30px;">WELCOME <br> வரவேற்கிறோம்</p>
		<p style="text-align: center;">Date: <?php echo date('d-m-Y h:ia', strtotime($qry1['created'])); ?></p>

		<p style="text-align: center;">Bill NO: <?php echo $qry1['ref_no']; ?></p>
		<p style="text-align: center;">Description: <?php echo $qry1['description']; ?></p>
		<hr>

		<p style="text-align: left;">SNO&nbsp;&nbsp;PARTICULARS</p>
		<hr>
		<?php $sub_total = 0; $i=1; foreach($booking as $row) { ?>
			<p style="text-align: left;"><?= $i++; ?>&nbsp;&nbsp;<?= $row['name_eng']; ?><br>&nbsp;&nbsp;
			   <?= $row['name_tamil']; ?><br>&nbsp;&nbsp;
			   <span style="font-size: 32px;">[RM <?= $row['amount']; ?> x <?= $row['quantity']; ?> = RM <?= number_format($row['quantity'] * $row['amount'],2); ?>]</span></p>
		<?php $sub_total += $row['quantity'] * $row['amount']; } ?>
		<?php
		$archanai_book_id = $qry1['id'];
		$check_amt = $db->table('archanai_booking')->where('id', $archanai_book_id)->get()->getResultArray();
		if (count($check_amt) > 0) {
			$paid_amt = !empty($check_amt[0]['paid_amount']) ? $check_amt[0]['paid_amount'] : 0;
		} else {
			$paid_amt = 0;
		}
		$final_total = $sub_total;
			?>
			<br>
			<!-- <p style="text-align: center; font-weight: bold; font-size: 18px;">SUB TOTAL : RM
				<?php /* number_format($sub_total, 2);*/ ?>
			</p> -->
			<?php 
			if (!empty($qry1['discount_amount'])) {
				$discount = (float) $qry1['discount_amount'];
				if (!empty($discount)) {
					$final_total -= $discount;
					?>
					<p style="text-align: center; font-weight: bold; font-size: 18px;">DISCOUNT AMOUNT : RM
						<?= number_format($discount, 2); ?>
					</p>
					<?php
				}
			}
			?>
			<br>
			<p style="text-align: center; font-size: 40px;">Total:  RM <?= number_format($final_total, 2); ?></p>
			<br>
			<p style="text-align: center; font-weight: bold; font-size: 18px;">PAID AMOUNT : RM
				<?= number_format($paid_amt, 2); ?>
			</p>
			<?php 
			$balance_amt = $paid_amt - $final_total;
			if (!empty($balance_amt)) {
			?>
			<p style="text-align: center; font-weight: bold; font-size: 18px;">BALANCE AMOUNT : RM
				<?= number_format($balance_amt, 2); ?>
			</p>
			<?php
			}
			?>

		<br>
		<?php if(count($rasi) > 0) {  ?>
			<hr>
			<table style="width:100%;">
			<tr><th align="left">Name</th><th align="left">Rasi</th><th align="left">Natchathram</th></tr>
			<?php foreach($rasi as $res) { ?>
			<tr><td><?= $res['name']; ?></td>
			<td><?= $res['rasi_name_tamil']; ?><br><?= $res['rasi_name_eng']; ?></td>
			<td><?= $res['nat_name_tamil']; ?><br><?= $res['nat_name_eng']; ?></td></tr>
			<?php } ?>
		<?php } ?>
		</table>
		<?php if(count($vehicles) > 0) {  ?>
		<hr>
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
		<?php } ?>
		<br>
		<br>
		
		
		<?php 
		foreach($booking as $row) {
			if($row['groupname'] == 'NAVAGRAHAM PEYERCHI') { 
			?>
			<p style="text-align:center;font-size:30px;text-transform:uppercase;">1 free small vilaku</p>
			<?php 
			} 
		} 
		?>

		<?php 
		$j=0; 
		foreach($booking as $row) {
		if($row['archanai_category'] == 3)
		{
		$j = $j+1;
		}
		}
		if($j > 0)
		{
		?>
		<img src="<?php echo base_url(); ?>/assets/1671017506_fruit_arsanai.jpg" width="200" height="160" alt="image" style="display:block;margin:0 auto;">
		<p style="text-align:center;font-size:30px;">Archanai Kalanji <br> அர்ச்சனை காளாஞ்சி </p>
		<?php
		}
		?>
		<br>
		<br>
		<p><span>---</span>GRASP SOFTWARE SOLUTIONS SDN. BHD.<span>---</span></p>
		<hr>
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
	<style>
		/* Browser print (same method as daily closing): 80mm roll, scaled from the 150mm layout */
		@page { size: 80mm auto; margin: 0; }
		@media print {
			body { margin: 0; }
			.archanai_loader { display: none !important; }
			#archanai_ticket { zoom: 0.53; padding: 0; padding-bottom: 60px; }
		}
	</style>
	<script>
		$(document).ready(function(){
			$('.archanai_loader').hide();
			$('#archanai_ticket').show();
			setTimeout(function(){
				window.print();
				setTimeout(function(){ window.close(); }, 60000);
			}, 500);
		});
	</script>
