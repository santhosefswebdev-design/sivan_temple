<?php global $lang; ?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Courier <small>
                    Prasadam Courier / <b>Charges
                    </b>
                </small>
            </h2>
        </div>
     
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row">
                            <div class="col-md-8">
                            </div>
                            <div class="col-md-4" align="right">
                                <a href="<?php echo base_url('master/add_courier_charge'); ?>">
                                    <button type="button" class="btn bg-deep-purple waves-effect">
                                        <?php echo $lang->add; ?>
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                     
                        <?php if ($_SESSION['succ'] != '') { ?>
                            <div class="row" style="padding: 0 30%;" id="content_alert">
                                <div class="suc-alert">
                                    <span class="suc-closebtn"
                                        onclick="this.parentElement.style.display='none';">&times;</span>
                                    <p><?php echo $_SESSION['succ']; ?></p>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($_SESSION['fail'] != '') { ?>
                            <div class="row" style="padding: 0 30%;" id="content_alert">
                                <div class="alert">
                                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                                    <p><?php echo $_SESSION['fail']; ?></p>
                                </div>
                            </div>
                        <?php } ?>

                        <!-- List of courier charges -->
                        <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th style="width:5%;">
                                            <?php echo $lang->sno; ?>
                                        </th>
                                        <th style="width:30%;">
                                            State Name
                                        </th>
                                        <th style="width:30%;">
                                            State Code
                                        </th>
                                        <th style="width:10%;">
                                            Amount
                                        </th>
                                        <th>
                                            <?php echo $lang->action; ?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($list as $row) { ?>
                                        <tr>
                                            <td>
                                                <?php echo $i++; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['state_name']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['state_code']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['amount']; ?>
                                            </td>
                                            <td>
                                               <a class="btn btn-success btn-rad" title="View"
                                                    href="<?= base_url() ?>/master/view_courier_charge/<?php echo $row['id']; ?>">
                                                    <i class="material-icons">&#xE417;</i>
                                                </a>

                                                <a class="btn btn-primary btn-rad" title="Edit"
                                                    href="<?= base_url() ?>/master/edit_courier_charge/<?php echo $row['id']; ?>">
                                                    <i class="material-icons">&#xE3C9;</i>
                                                </a> 
<!-- <a class="btn btn-danger btn-rad" title="Delete" href="javascript:void(0);"
    onclick="confirmDelete(<?php echo $row['id']; ?>)">
    <i class="material-icons">&#xE872;</i>
</a> -->

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
                        <h4 class="mt-2">
                            <?php echo $lang->delete; ?>
                            <?php echo $lang->service; ?>
                        </h4>
                        <table>
                            <tr><span id="spndeddelid"><b></b></span></tr>
                        </table>

                        <a href="#" id="del" class="btn btn-danger my-3" data-dismiss="modal">
                            <?php echo $lang->yes; ?>
                        </a> &nbsp;
                        <button type="button" class="btn btn-info my-3" data-dismiss="modal">
                            <?php echo $lang->no; ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="del-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-information h1 text-info"></i>
                        <table>
                            <tr>
                                <span id="delmol"><b></b></span>&nbsp;&nbsp;&nbsp;
                                <button type="button" class="btn btn-info my-3" data-dismiss="modal"> &times;</button>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


   
</section>

<script>
    
function confirmDelete(id) {
    if (confirm("Are you sure you want to delete this courier charge")) {
        dedDel(id);
    }
}

function dedDel(id) {
    var act = "<?php echo base_url(); ?>/master/delete_courier_charge/" + id;
        var form = document.createElement('form');
        form.action = act;
        form.method = 'post';
        document.body.appendChild(form);
        form.submit();
    }

</script>