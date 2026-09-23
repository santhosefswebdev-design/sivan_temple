<?php        
$db = db_connect();
?>
<style>
    .table-responsive{
        overflow-x: hidden;
    }
</style>
<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>CEMETERY<small>Cemetery / <b>Cemetery Specialtime Registration</b></small></h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
					<?php //if($permission['create_p'] == 1) { ?>
                        <div class="header">
                            <div class="row">
                                <div class="col-md-4" align="right"></div>
                            </div>
                        </div>
					<?php //} ?>
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
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable" id="datatables">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Date</th>
                                            <th>Name of Dec</th>
                                            <th>Age of Dec</th>
                                            <th>Date of Cremation</th>
                                            <th>Burial No</th>
                                            <th>Registered By</th>
											<th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; foreach($list as $row) { ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($row['date'])); ?></td>
                                            <td><?php echo $row['name_of_deceased']; ?></td>
                                            <td><?php echo $row['age']; ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($row['date_for_cremation'])); ?></td>
                                            <td><?php echo $row['burial_no']; ?></td>
                                            <td><?php 
                                                $entry_by = $db->table('login')->where('id', $row['entry_by'])->get()->getRowArray();
                                                echo $entry_by['name']; ?>
                                            </td>
                                            <td style="width: 5%;">
                                                <a class="btn btn-success btn-rad" href="<?= base_url()?>/cemetery/payment/<?php echo $row['id'];?>"><i class="material-icons">loop</i></a>
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
    $("document").ready(function () {
        $("#datatables").dataTable({
            "searching": true
        });
        var table = $('#datatables').DataTable();
        $("#customFilter").on('change', function() {
            //filter by selected value on second column
            table.column(6).search($(this).val()).draw();
        }); 
    });
</script>