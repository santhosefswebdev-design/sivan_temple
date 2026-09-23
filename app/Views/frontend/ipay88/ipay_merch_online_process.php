<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Archanai Payment Process</title>
  <script>
  window.onload = function(){
	  document.forms['ipay_payment_process'].submit();
	}
  </script>
</head>

<body>
  <?php if(!empty($ipay88_fields)): ?>
    <form action="<?php echo $epayment_url; ?>" method="post" name="ipay_payment_process">
      <table>
        <?php foreach ($ipay88_fields as $key => $val):
		?>
          <tr>
            <td><input type="hidden" name="<?php echo $key; ?>" value="<?php echo $val; ?>" /></td>
          </tr>
        <?php
		endforeach; ?>
		<?php // <tr>
          // <td colspan="2"><input type="submit" value="Submit" name="Submit" /></td>
        // </tr> ?>
      </table>
    </form>
  <?php endif; ?>
</body>

</html>