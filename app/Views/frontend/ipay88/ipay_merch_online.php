<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Archanai Payment Process</title>
</head>

<body>
    <form action="<?php echo base_url(); ?>/<?php echo $controller; ?>/initiate_ipay_merch_online/<?php echo $id; ?>" method="post">
		<table>
			<tr>
				<td><input type="radio" name="payment_id" value="2" /></td>
				<td><label>Credit Card</label></td>
			</tr>
			<tr>
				<td><input type="radio" name="payment_id" value="16" /></td>
				<td><label>Online</label></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" value="Submit" name="Submit" /></td>
			</tr>
		</table>
    </form>
</body>

</html>