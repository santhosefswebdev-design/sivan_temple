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
  <img src="<?php echo base_url(); ?>/assets/frontend/images/dash2.gif" style="width:100%;">
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
      </table>
    </form>
  <?php endif; ?>
</body>

</html>