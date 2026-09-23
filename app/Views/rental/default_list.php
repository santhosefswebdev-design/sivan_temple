<?php global $lang;?>
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/jquery-ui.css">
<script src="<?php echo base_url(); ?>/assets/jquery-ui.js"></script>
<link href="<?php echo base_url(); ?>/assets/monthpicker/MonthPicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>/assets/monthpicker/MonthPicker.min.js"></script>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2><?php echo $lang->rental; ?><small><?php echo $lang->rental; ?> / <b><?php echo $lang->defaults; ?> <?php echo $lang->list; ?></b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                	<!--<div class="header">
                        <div class="row"><div class="col-md-8"><h2>Hall</h2></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/master/add_property_type"><button type="button" class="btn bg-deep-purple waves-effect">Add</button></a></div></div>
                    </div>-->
                    <div class="body">
                        <form action="<?php echo base_url(); ?>/rental/default_list" method="post">
                            <div class="row clearfix">
                                <div class="col-sm-2 date">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="rental_monthyear" id="rental_monthyear" class="form-control rental_monthyear" value="<?php if(!empty($rental_monthyear)) { echo $rental_monthyear; } else{ echo date("m/Y"); } ?>" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2" align="right">
                                    <button type="submit" class="btn btn-success btn-lg waves-effect"><?php echo $lang->submit; ?></button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th style="width:5%;"><?php echo $lang->sno; ?></th>
                                        <th style="width:20%;"><?php echo $lang->property; ?> <?php echo $lang->name; ?></th>
                                        <th style="width:20%;"><?php echo $lang->tennant; ?> <?php echo $lang->name; ?></th>
                                        <th style="width:20%;"> <?php echo $lang->phone; ?> <?php echo $lang->no; ?></th>
                                        <th style="width:20%;"><?php echo $lang->rental; ?> <?php echo $lang->amount; ?></th>
                                        <th><?php echo $lang->action; ?></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    //var_dump($list);
                                    $i = 1; 
                                    foreach($list as $row) {
                                        $temple_name = $_SESSION['site_title'];
                                        $tennant_name = $row['tennant_name'];
                                        $property_address = $row['property_name'];
                                        $rental_amount = $row['amount'];
                                        $due_month = $row['due_month'];
                                        $whatsapp_msg = <<<PRITHIVI
                                        Dear $tennant_name,
                                        This is a friendly reminder that your rent payment for the month of $due_month.
                                        Here are the details for your reference:
                                        Rental Property: $property_address
                                        Rental Amount: $rental_amount
                                        We kindly request that you submit your payment on or before the due date to avoid any late fees or disruptions to your tenancy.
                                        If you have already made the payment, we sincerely thank you for your promptness. Your cooperation in this matter is greatly appreciated, and it contributes to the smooth operation of the property.
                                        Thank you for being a valued tenant.

                                        Best regards,
                                        $temple_name
                                        PRITHIVI;
                                        $whatsapp_url = 'https://wa.me/+60' . $row['phone_no'] . '?text=' . urlencode($whatsapp_msg);
                                        ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $row['property_name']; ?></td>
                                        <td><?php echo $tennant_name; ?></td>
                                        <td><?php echo $row['phone_no']; ?></td>
                                        <td><?php echo $row['amount']; ?></td>
                                        <td>
                                            <a href="<?php echo $whatsapp_url; ?>" target="_blank" class="text-success" style="float: left;"><img src="<?php echo base_url(); ?>/assets/images/whatsapp.png" style="width:25px;"></a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#rental_monthyear').MonthPicker({ Button: false });
    </script>