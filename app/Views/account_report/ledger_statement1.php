<table width="1000" border="0" align="center" style="border-collapse:collapse; font-family:Calibri ;font-size:18px;">
<tr><td width="15%" align="left"><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>" style="width:120px;" align="left"></td>
    <td width="85%" align="left"><h2 style="text-align:left;margin-bottom: 0;"><?php echo $_SESSION['site_title']; ?></h2>
    <p style="text-align:left; font-size:16px; margin:5px 0px;"><?php echo $_SESSION['address1']; ?>, <br><?php echo $_SESSION['address2']; ?>,<br>
	<?php echo $_SESSION['city']; ?> - <?php echo $_SESSION['postcode']; ?><br>
    Tel : <?php echo $_SESSION['telephone']; ?></p></td></tr>
    </table>


	<table width="1000" border="0" align="center" style="border-collapse:collapse; font-family: Arial, Helvetica, sans-serif;">
		<tr style="font-size: 16px;">
			<td height="50" width="100%" align="center" style="border-bottom:1px solid black;text-transform:uppercase;"><strong>General Ledger Statement </strong></td>
		</tr>
	</table>
	<table width="1000" border="0" align="center" style="border-collapse:collapse; font-family: Arial, Helvetica, sans-serif; font-size: 15px;">
		<thead>
			<tr style="padding: 15px 0;">
				
				<td width="10%" align="left" style="border-bottom:1px solid black;padding: 15px 5px;"><strong>Date</strong></td>
				<!--<td width="10%" align="left" style="border-bottom:1px solid black;"><strong>Inv No</strong></td>-->
				<td width="25%" align="left" style="border-bottom:1px solid black;padding: 15px 5px;"><strong>Ledger</strong></td>
				<td width="16%" align="left" style="border-bottom:1px solid black;padding: 15px 5px;"><strong>Debit Amount</strong></td>
				<td width="16%" align="left" style="border-bottom:1px solid black;padding: 15px 5px;"><strong>Credit Amount</strong></td>
				<td width="18%" align="right" style="border-bottom:1px solid black;padding: 15px 5px;"><strong>Balance Amount</strong></td>
			</tr>
		</thead>
		<tbody>
			<tr style="background-color: #d2afaf;">
				<td></td><td>Opening Balance</td><td></td><td></td><td align="right" style="padding: 15px 5px;"><?= str_replace('-0.00', '0.00', number_format($op_bal,2)); ?></td>
			</tr> 
			<?php foreach($data as $row) { ?>
				<tr>
					<td style="padding: 6px 0;" ><?= date('d-m-Y',strtotime($row['date'])); ?></td>
					<!--<td style="padding: 6px 0;" ><?= $row['inv_no']; ?></td>-->
					<td style="padding: 6px 0;" ><?= $row['ledger']; ?></td>
					<td align="left" style="padding: 6px 0;" ><?= $row['debit']; ?></td>
					<td align="left" style="padding: 6px 0;" ><?= $row['credit']; ?></td>
					<td align="right" style="padding: 6px 2px;" >
					<?php
					if($row['balance'] < 0){
						echo "( ".number_format(abs($row['balance']),2)." )";
					}
					else{
						echo number_format($row['balance'],2);
					}
					?>
					</td>
				</tr>
			<?php } ?>
			<tr style="background-color: #d2afaf;">
				<td></td>
				<td>Closing Balance</td>
				<td><?= number_format($cu_debit,'2','.',','); ?></td>
				<td><?= number_format($cu_credit,'2','.',','); ?></td>
				<td align="right" style="padding: 15px 5px;">
				<?php
				if($cl_bal < 0){
					echo "( ".number_format(abs($cl_bal),'2','.',',')." )";
				}
				else{
					echo number_format($cl_bal,'2','.',',');
				}
				?>
				</td>
			</tr>
		</tbody>
	</table>
<script>
window.print();
</script>