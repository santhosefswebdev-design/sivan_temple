<?php global $lang;?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2><?php echo $lang->prasadam; ?> <?php echo $lang->setting; ?><small><?php echo $lang->prasadam; ?> / <b><?php echo $lang->prasadam; ?> <?php echo $lang->setting; ?> <?php echo $lang->list; ?></b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <?php if ($permission['create_p'] == 1) { ?>
                        <div class="header">
                            <div class="row">
                                <div class="col-md-8"></div>
                                <div class="col-md-4" align="right"><a
                                        href="<?php echo base_url(); ?>/prasadamsetting/add"><button type="button"
                                            class="btn bg-deep-purple waves-effect"><?php echo $lang->add; ?></button></a></div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="body">
                        <?php if ($_SESSION['succ'] != '') { ?>
                            <div class="row" style="padding: 0 30%;" id="content_alert">
                                <div class="suc-alert">
                                    <span class="suc-closebtn"
                                        onclick="this.parentElement.style.display='none';">&times;</span>
                                    <p>
                                        <?php echo $_SESSION['succ']; ?>
                                    </p>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($_SESSION['fail'] != '') { ?>
                            <div class="row" style="padding: 0 30%;" id="content_alert">
                                <div class="alert">
                                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                                    <p>
                                        <?php echo $_SESSION['fail']; ?>
                                    </p>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th style="width:5%;"><?php echo $lang->sno; ?></th>
                                        <th style="width:30%;"><?php echo $lang->name_eng; ?></th>
                                        <th style="width:30%;"><?php echo $lang->name_tam; ?></th>
                                        <th style="width:10%;"><?php echo $lang->amount; ?></th>
                                        <?php if ($permission['view'] == 1 || $permission['edit'] == 1 || $permission['delete_p'] == 1) { ?>
                                            <th><?php echo $lang->action; ?></th>
                                        <?php } ?>
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
                                                <?php echo $row['name_eng']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['name_tamil']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['amount']; ?>
                                            </td>
                                            <?php if ($permission['view'] == 1 || $permission['edit'] == 1 || $permission['delete_p'] == 1) { ?>
                                                <td style="width: 10%;">
                                                    <?php if ($permission['view'] == 1) { ?>
                                                        <a class="btn btn-success btn-rad" title="View"
                                                            href="<?= base_url() ?>/prasadamsetting/view/<?php echo $row['id']; ?>"><i
                                                                class="material-icons">&#xE417;</i></a>
                                                    <?php }
                                                    if ($permission['edit'] == 1) { ?>
                                                        <a class="btn btn-primary btn-rad" title="Edit"
                                                            href="<?= base_url() ?>/prasadamsetting/edit/<?php echo $row['id']; ?>"><i
                                                                class="material-icons">&#xE3C9;</i></a>
                                                    <?php }
                                                    if ($permission['delete_p'] == 1) { ?>
                                                        <a class="btn btn-danger btn-rad" title="Delete"
                                                            onclick="confirm_modal(<?php echo $row['id']; ?>)"><i
                                                                class="material-icons">&#xE872;</i></a>
                                                    <?php } ?>
                                                </td>
                                            <?php } ?>
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
                        <h4 class="mt-2"><?php echo $lang->delete; ?> <?php echo $lang->prasadam; ?></h4>
                        <table>

                            <tr><span id="spndeddelid"><b></b></span></tr>
                        </table>

                        <a href="#" id="del" class="btn btn-danger my-3" data-dismiss="modal"><?php echo $lang->yes; ?></a> &nbsp;
                        <button type="button" class="btn btn-info my-3" data-dismiss="modal"><?php echo $lang->no; ?></button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div>
    </div>
    <div id="del-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-information h1 text-info"></i>
                        <table>
                            <tr><span id="delmol"><b></b></span>&nbsp;&nbsp;&nbsp;<button type="button"
                                    class="btn btn-info my-3" data-dismiss="modal"> &times;</button></tr>
                        </table>
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
    function confirm_modal(id) {
        //alert(id)
        $.ajax({
            url: "<?php echo base_url(); ?>/prasadamsetting/del_check",
            type: "post",
            data: { id: id },
            success: function (data) {
                if (data == 0) {
                    $('#alert-modal').modal('show', { backdrop: 'static' });
                    document.getElementById('del').setAttribute('onclick', 'dedDel(' + id + ')');
                    $("#spndeddelid").text("Are you sure to Delete " + $("#pay" + id).attr("data-id") + "?");
                } else {
                    //alert(id)
                    $('#del-modal').modal('show', { backdrop: 'static' });
                    $("#delmol").text("We used for this Prasadam, So cant delete this Prasadam");
                }
            }
        });
    }

    function dedDel(id) {
        var act = "<?php echo base_url(); ?>/prasadamsetting/delete/" + id;
        $("#delete-form").append("<form action='" + act + "'><button type='submit' id='delete" + id + "' >submit</button></form>");
        $("#delete" + id).trigger("click");
    }
</script>