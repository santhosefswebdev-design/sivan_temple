<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_SESSION['site_title']; ?></title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" >
<style>

</style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <p style="text-align:center;"><img src="<?php echo base_url(); ?>/assets/images/form_logo.png" class="img-fluid" style="width:300px; margin:0 auto;"></p>
            <h3 style="text-align:center;">VISITOR'S REGISTRATION LIST</h3><br>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <tr><th>S.No</th>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Citizen</th>
                    <th>Type</th>
                    <th>Pax</th>
                    <th>Comments</th></tr>
                    
                    <?php $i = 1;
                    foreach($list as $row)
                    {
                    ?>
                        <tr><td><?php echo $i; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($row['created_at'])); ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['citizen']; ?></td>
                        <td><?php echo $row['type']; ?></td>
                        <td><?php echo $row['pax']; ?></td>
                        <td><?php echo $row['comments']; ?></td></tr>
                    <?php
                    $i++;
                    }
                    ?>
                    
                </table>
            </div> 
            </div> 
        </div>
    </div>
</body>
</html>
