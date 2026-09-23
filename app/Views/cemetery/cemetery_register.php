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
                <h2>CEMETERY<small>Cemetery / <b>Cemetery Registration</b></small></h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
					<?php //if($permission['create_p'] == 1) { ?>
                        <div class="header">
                            <div class="row">
                            <form action="<?php echo base_url(); ?>/report/print_payslipreport" method="get" target="_blank">
                                <div class="col-md-4">
                                    <?php
                                    if($_SESSION['role'] == 1 && $_SESSION['log_name'] == "admin") { 
                                    ?>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <select name="customFilter" id="customFilter" class="form-control">
                                                <option value="">select agent</option>
                                                <?php
                                                if(!empty($agent_dets))
                                                {
                                                    foreach($agent_dets as $agent_det)
                                                    {
                                                ?>
                                                <option value="<?php echo $agent_det['name']; ?>"><?php echo $agent_det['name'].'- '.$agent_det['member_comes']; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="col-md-4"> </div>
                            </form>
                                <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/cemetery/register"><button type="button" class="btn bg-deep-purple waves-effect">Register New</button></a></div>
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
                                            <th>Date of Demise</th>
                                            <th>Burial No</th>
                                            <?php
                                            if($_SESSION['role'] == 1 && $_SESSION['log_name'] == "admin"){ ?>
                                            <th>Registered By</th>
                                            <?php } ?>
                                            <?php //if($permission['view'] == 1 ||  $permission['print'] == 1) { ?>
											<th>Actions</th>
											<?php //} ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; foreach($list as $row) { ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($row['date'])); ?></td>
                                            <td><?php echo $row['name_of_deceased']; ?></td>
                                            <td><?php echo $row['age']; ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($row['date_of_demise'])); ?></td>
                                            <td><?php echo $row['b_certif_no']; ?></td>
                                            <?php
                                            if($_SESSION['role'] == 1 && $_SESSION['log_name'] == "admin"){ ?>
                                            <td><?php 
                                                $entry_by = $db->table('login')->where('id', $row['entry_by'])->get()->getRowArray();
                                                echo $entry_by['name']; ?>
                                            </td>
                                            <?php } ?>
                                            <td style="width: 5%;">
                                                <a class="btn btn-success btn-rad" href="<?= base_url()?>/cemetery/edit/<?php echo $row['id'];?>"><i class="material-icons">&#xE3C9;</i></a>
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
         <div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body p-4">
                        <div class="text-center">
                            <i class="dripicons-information h1 text-info"></i>
                            <h4 class="mt-2">Delete Donation</h4>
                            <table>
        
                            <tr><span id="spndeddelid"><b></b></span></tr>
                          </table>
                            
                            <a href="#" id="del" class="btn btn-danger my-3" data-dismiss="modal">Yes</a> &nbsp;
                            <button type="button" class="btn btn-info my-3" data-dismiss="modal">No</button>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div>
        </div>
        <!--Delete Form-->
        <div id=delete-form>
            
        </div>
        <!--End Delete Form-->
    </section>
<script>
    function confirm_modal(id)
    {
        $('#alert-modal').modal('show', {backdrop: 'static'});
        document.getElementById('del').setAttribute('onclick' , 'dedDel('+id+')');
        $("#spndeddelid").text("Are you sure to Delete "+$("#pay"+id).attr("data-id") + "  Donation?" );
    
    }
    
    function dedDel(id)
    {
        var act = "<?php echo base_url(); ?>/donation/delete/"+id;
        $( "#delete-form" ).append( "<form action='"+act+"'><button type='submit' id='delete"+id+"' >submit</button></form>");
        $( "#delete"+id).trigger( "click" );
    }
</script>

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