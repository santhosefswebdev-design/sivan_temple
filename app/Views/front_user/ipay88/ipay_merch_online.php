<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Archanai Payment Process</title>
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/frontend/css/bootstrap.min.css">
</head>

<body>
<style>
form { width:50%; margin:20px auto; }
ul.payment {
    list-style-type: none;
    width: 100%;
    margin:0 auto;
    display: flex;
    justify-content: space-between;
	margin-bottom:0;
	padding-left:0;
	flex-wrap: wrap;
}

.payment li {
    display: inline-block;
    text-align:center;
    width:45%;
}

input[type="radio"][id^="cb"] {
  display: none;
}

label {
  border: 1px solid #CCC;
  border-radius: 5px;
  line-height: 1;
  padding: 5px;
  display: block;
  position: relative;
  margin: 5px;
  cursor: pointer;
  font-weight:bold;
}

label:before {
  background-color: white;
  color: white;
  content: " ";
  display: block;
  border-radius: 50%;
  border: 1px solid grey;
  position: absolute;
  top: -5px;
  left: -5px;
  width: 18px;
  height: 18px;
  text-align: center;
  line-height: 18px;
  transition-duration: 0.4s;
  transform: scale(0);
}

label i.mdi {
  transition-duration: 0.2s;
  transform-origin: 50% 50%;
  font-size:28px;
  color:#0d2f95;
}

:checked + label {
background:#f2f2f2;
}

:checked + label:before {
  content: "✓";
  background-color: green;
  transform: scale(1);
}

:checked + i.mdi{
  transform: scale(0.9);
}
</style>
    <form action="<?php echo base_url() . $submit_url ; ?>" method="post">
		<!--table>
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
		</table-->
		<h5 style="text-align:center;">Select any Payment Mode</h5>
		<ul class="payment">
          <li><input type="radio" name="pay_method" id="cb1" value="cash" />
            <label for="cb1"><img src="<?php echo base_url(); ?>/assets/frontend/images/card.png" style="height:50px;"> <br>Credit Card</label>
          </li>
          <li><input type="radio" name="pay_method" id="cb3" value="ipay_merch_qr" />
            <label for="cb3"><img src="<?php echo base_url(); ?>/assets/frontend/images/online.png" style="height:50px;"> <br>Online</label>
          </li>
        </ul>
        <input type="submit" value="Submit" class="btn btn-success" style="margin:10px auto; width:100%;" name="Submit" />
    </form>
</body>

</html>