<title><?php echo $_SESSION['site_title']; ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">
<style>
body { font-family: 'Barlow', sans-serif; }
table { border-collapse:collapse; }
.inner_table tr:nth-child(even) { background:#F3F3F3; }
.inner_table tr:last-child { background:#e2dfdf; }
.table tr th, .table tr td { text-align:center; }
table td { padding:5px; line-height:1.5em; }
h2 { font-size: 20px; }
.level_1  { padding-left:20px !important; }
.level_2  { padding-left:40px !important; }
.level_ledger { padding-left:60px !important; }
.level_total { text-align:center !important; }

.table1{ border:1px solid #CCCCCC; }
.table1 tr th { background-color:#EFEFEF; padding:5px; min-width:120px; font-size:16px; }
.table1 tr td:first-child { padding:5px; text-align:left; }
.table1 tr td { padding:5px; text-align:right;  }
/*.table1 tr td:last-child { font-weight:bold;  }*/ 
</style>
    <table style="width:100%">
    <tr><td width="15%" align="left"><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>" style="max-height: 80px;" align="left"></td>
    <td width="85%" align="center"><h2 style="text-align:center;margin-bottom: 0;"><?php echo $_SESSION['site_title']; ?></h2>
    <p style="text-align:center; font-size:16px; margin:5px 0px;"><?php echo $_SESSION['address1']; ?>, <?php echo $_SESSION['address2']; ?>,
	<?php echo $_SESSION['city']; ?> - <?php echo $_SESSION['postcode']; ?><br>
    Tel : <?php echo $_SESSION['telephone']; ?></p></td></tr>
    </table>
	<h2 style="text-align:center;">Income and Expenditure Statement <?php echo date("d/m/Y", strtotime($sdate)).' - '.date("d/m/Y", strtotime($edate)); ?></h2>
	<table class="table1" style="width:100%;" border="1">
		<thead>
			<tr style="padding: 15px 0;">
				<?php if($filter_option == 'separate'){ ?>
				<td width="10%" align="left" style="padding: 15px 5px;"><strong>Date</strong></td>
				<?php } ?>
				<td width="30%" align="left" style="padding: 15px 5px;"><strong>Ledger</strong></td>
				<td width="40%" align="right" style="padding: 15px 5px;"><strong>Description</strong></td>
				<td width="20%" align="right" style="padding: 15px 5px;"><strong>Amount</strong></td>
			</tr>
		</thead>
		<tbody>
			<?php 
			$total_amount = 0;

			if(count($exp_list) > 0){
				foreach($exp_list as $row) { 
				?>
					<tr>
						<?php if($filter_option == 'separate'){ ?>
						<td style="padding: 6px 0;" ><?= date('d-m-Y',strtotime($row['date'])); ?></td>
						<?php } ?>
						<td style="padding: 6px 0;" ><?= '(' . $row['left_code'] . '/' . $row['right_code'] . ') - ' . $row['name']; ?></td>
						<td align="right" style="padding: 6px 0;" ><?= $row['narration']; ?></td>
						<td align="right" style="padding: 6px 0;" ><?php
							$total_amount += $row['amount'];
							if($row['amount'] < 0){
								echo "( ".number_format(abs($row['amount']),2)." )";
							}
							else{
								echo number_format($row['amount'],2);
							}
							?>
						</td>
					</tr>
				<?php 
				}
			}
			?>
		</tbody>
		<tfoot>
			<tr>
			<?php if($filter_option == 'separate'){ ?>
				<td colspan="2"></td>
				<?php }else{ ?>
				<td colspan=""></td>
				<?php } ?>
				<td align="right"><b>Total</b></td>
				<td align="right"><b><?php
					if($total_amount < 0){
						echo "( ".number_format(abs($total_amount),2)." )";
					}
					else{
						echo number_format($total_amount,2);
					}
				?>
				</b></td>
			</tr>
		</tfoot>
    </table>
<div class="row">
    <div class="col-md-12">
        <h1 align="center"><?php echo $profit; ?></h1>
    </div>
</div>
<script>
window.print();
</script>