<?php global $lang;?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2><?php echo $lang->setting; ?><small><?php echo $lang->annathanam; ?> / <b><?php echo $lang->setting; ?></b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                	<div class="header">
                        <div class="row"><div class="col-md-8"></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/annathanam/add_setting"><button type="button" class="btn bg-deep-purple waves-effect"><?php echo $lang->add; ?></button></a></div></div>
                    </div>
                    <div class="body">
                    	<?php if($_SESSION['succ'] != '') { ?>
                                <div class="row" style="padding: 0 30%;" id="content_alert">
                                    <div class="suc-alert">
                                        <span class="suc-closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                        <p><?php echo $_SESSION['succ']; ?></p> 
                                    </div>
                                </div>
                            <?php } ?>
                             <?php if($_SESSION['fail'] != '') { ?>
                                <div class="row" style="padding: 0 30%;" id="content_alert">
                                    <div class="alert">
                                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                        <p><?php echo $_SESSION['fail']; ?></p>
                                    </div>
                                </div>
                            <?php } ?>
                        <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th style="width:5%;"><?php echo $lang->sno; ?></th>
                                        <th style="width:20%;"><?php echo $lang->rice; ?> <?php echo $lang->category; ?></th>
                                        <th style="width:20%;"><?php echo $lang->kuruma; ?> <?php echo $lang->type; ?></th>
                                        <th style="width:20%;"><?php echo $lang->rice; ?> <?php echo $lang->type; ?></th>
                                        <th style="width:20%;"><?php echo $lang->amount; ?></th>
                                        <th><?php echo $lang->action; ?></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; foreach($list as $row) { ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td id="pay<?= $row['id']; ?>" data-id="<?= $row['rc_name_eng'];?>">
                                            <?php echo $row['rc_name_eng']."/".$row['rc_name_tamil']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['kt_name_eng']."/".$row['kt_name_tamil']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['rt_name']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['s_amount']; ?>
                                        </td>
                                        <td>
                                        	<a class="btn btn-success btn-rad" title="View" href="<?= base_url()?>/annathanam/view_setting/<?php echo $row['id'];?>"><i class="material-icons">&#xE417;</i></a>
                                            <a class="btn btn-primary btn-rad" title="Edit" href="<?= base_url()?>/annathanam/edit_setting/<?php echo $row['id'];?>"><i class="material-icons">&#xE3C9;</i></a>
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
        <!--End Delete Form-->
</section>
<script>

</script>