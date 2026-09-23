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
<tr><td colspan="2">
    <table style="width:100%">
    <tr><td width="15%" align="left"><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>" style="max-height: 80px;" align="left"></td>
    <td width="85%" align="center"><h2 style="text-align:center;margin-bottom: 0;"><?php echo $_SESSION['site_title']; ?></h2>
    <p style="text-align:center; font-size:16px; margin:5px 0px;"><?php echo $_SESSION['address1']; ?>, <?php echo $_SESSION['address2']; ?>,
	<?php echo $_SESSION['city']; ?> - <?php echo $_SESSION['postcode']; ?><br>
    Tel : <?php echo $_SESSION['telephone']; ?></p></td></tr>
    </table>
</td></tr>
<tr><td colspan="2"><hr></td></tr>
<tr><td colspan="2">
<?php
if($breakdown == 'daily'){
    $file_name = "Income and Expenditure Statement ".date("d/m/Y", strtotime($sdate))." - ".date("d/m/Y", strtotime($edate));
}
else{
    $file_name = "Income and Expenditure Statement ".date("m/Y", strtotime($smonthdate))." - ".date("m/Y", strtotime($emonthdate));
}
?>    
<h2 style="text-align:center;"><?php echo $file_name; ?></h2>
</td></tr>
<tr><td colspan="2">
	<table class="table1" style="width:100%;" border="1">
    <thead><tr>
    <th align="left"  style="width: 300px; min-width:300px !important;">Account Name</th>
    <?php
    if($breakdown == 'monthly'){
        foreach($getMonthsInRange as $getmonth){
            // var_dump($getmonth['date']);  
    ?>
    <th align="right"><?php echo date('F, Y',strtotime($getmonth['date'])); ?></th>
    <?php
        }
    ?>
    <th align="right">Total</th>
    <?php
    }
    else{
    ?>
    <th align="right">Amount</th>
    <?php
    }
    ?>
    </tr></thead>
    <tbody>
    <?php foreach($table as $row) { ?>
		<?php print_r($row); ?>
    <?php } ?>
    </tbody>
    </table>
</td></tr>
</table>
<div calss="row">
    <div class="col-md-12">
        <h1 align="center"><?php echo $profit; ?></h1>
    </div>
</div>
<script>
<?php
if($breakdown == "monthly"){
?>
var css = '@page { size: landscape; }',
    head = document.head || document.getElementsByTagName('head')[0],
    style = document.createElement('style');

style.type = 'text/css';
style.media = 'print';

if (style.styleSheet){
  style.styleSheet.cssText = css;
} else {
  style.appendChild(document.createTextNode(css));
}

head.appendChild(style);
window.print();
<?php
}
else{
?>
window.print();
<?php
}
?>
</script>