<style>
.btn-default, .btn-default:hover, .btn-default:active, .btn-default:focus {
    background: transparent !important;
}
.form-group { margin-bottom:0 !important; }
.col-sm-2 { margin-bottom:10px !important; }
.table tr th, .table tr td { text-align:left; }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2> CEMETERY <small>Cemetery / <a href="#" target="_blank">Special Time Approval</a></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
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
                            <table class="table table-striped dataTable" id="datatables">       
                                <thead>
                                    <tr> 
                                        <th style="width:5%;">S.No</th>
                                        <th style="width:40%;">Name of Dec</th>
                                        <th style="width:10%;">Age of Dec</th>
                                        <th style="width:15%;">Date of Demise</th>
                                        <th style="width:20%;">Burial No</th>
                                        <!--th style="width:25%;">Place of Demise</th-->
                                        <th style="width:10%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="userTable" >                                    
                                    <?php $i = 1; foreach($list as $row) { ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $row['name_of_deceased']; ?></td>
                                        <td><?php echo $row['age']; ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($row['date_of_demise'])); ?></td>
                                        <td><?php echo $row['b_certif_no']; ?></td>
                                        <td style="width: 5%;">
                                            <?php if($row['special_time_status']==0) { ?>
                                            <a class="btn btn-warning" onClick="confirm_modal(<?php echo $row['id'];?>)">Pending</a>
                                            <?php } else if($row['special_time_status']==1) { ?>
                                            <span style="color:green; font-weight:bold;">Approved</span>
                                            <?php } else { ?>
                                            <span style="color:red; font-weight:bold;">Rejected</span>
                                            <?php } ?>
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
</section>

<div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body p-4">
                <div class="text-center">
                    <i class="dripicons-information h1 text-info"></i>
                    <h4 class="mt-2">Approve Special Time</h4>
                    <table>

                    <tr><span id="spndeddelid"><b></b></span></tr>
                  </table>
                    <br>
                    <a href="#" id="del" class="btn btn-success my-3" data-dismiss="modal">Approve</a> &nbsp;
                    <a href="#" id="reg" class="btn btn-danger my-3" data-dismiss="modal">Reject</a> &nbsp;
                    <button type="button" class="btn btn-info my-3" data-dismiss="modal">cancel</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div>
</div>


<div id=delete-form>
    
</div>
<div id=reg-form>
    
</div>


<script>
    function confirm_modal(id)
    {
        $('#alert-modal').modal('show', {backdrop: 'static'});
        document.getElementById('del').setAttribute('onclick' , 'dedDel('+id+')');
        document.getElementById('reg').setAttribute('onclick' , 'dedReg('+id+')');
        $("#spndeddelid").text("Are you sure to Approve" );
    
    }
    
    function dedDel(id)
    {
        var act = "<?php echo base_url(); ?>/cemetery/approve_time/"+id;
        $( "#delete-form" ).append( "<form action='"+act+"'><button type='submit' id='delete"+id+"' >submit</button></form>");
        $( "#delete"+id).trigger( "click" );
    }
    
    function dedReg(id)
    {
        var act = "<?php echo base_url(); ?>/cemetery/reg_time/"+id;
        $( "#reg-form" ).append( "<form action='"+act+"'><button type='submit' id='delete"+id+"' >submit</button></form>");
        $( "#delete"+id).trigger( "click" );
    }
</script>

