<?php
if ($view == true) {
    $readonly = 'readonly';
    $disabled = 'disabled';
}
?>
<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }

    <?php if ($view == true) { ?>
        label.form-label span {
            display: none !important;
            color: transporant;
        }

    <?php } ?>
</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Prasadam Group<small>Prasadam / <b>Prasadam Group</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row">
                            <div class="col-md-8">
                                <h2>Prasadam Group</h2>
                            </div>
                            <div class="col-md-4" align="right"><a
                                    href="<?php echo base_url(); ?>/prasadamsetting/prasadam_group"><button
                                        type="button" class="btn bg-deep-purple waves-effect">List</button></a></div>
                        </div>
                    </div>
                    <form action="<?php echo base_url(); ?>/prasadamsetting/save_prasadam_group" method="POST"
                        enctype="multipart/form-data">
                        <div class="body">
                            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                            <div class="container-fluid">
                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="name"
                                                    value="<?php echo $data['name']; ?>" <?php echo $readonly; ?>>
                                                <label class="form-label">Group Name <span style="color: red;">
                                                        *</span></label>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <select class="form-control" name="status" <?php echo $readonly; ?>>
                                                    <option>-- Select Status --</option>
                                                    <option value="1" <?php if ($data['status'] == '1') {
                                                        echo "selected";
                                                    } ?>>Active</option>
                                                    <option value="2" <?php if ($data['status'] == '2') {
                                                        echo "selected";
                                                    } ?>>Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php if ($view != true) { ?>
                        <div class="col-sm-12" align="center" style="background-color: white;padding-bottom: 1%;">
                            <button type="submit" onclick="validations()"
                                class="btn btn-success btn-lg waves-effect">SAVE</button>
                            <button type="button" id="clear" class="btn btn-primary btn-lg waves-effect">CLEAR</button>
                        </div>
                    <?php } ?>
                    <div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-body p-4">
                                    <div class="text-center">
                                        <i class="dripicons-information h1 text-info"></i>
                                        <table>
                                            <tr><span id="spndeddelid"><b></b></span>&nbsp;&nbsp;&nbsp;<button
                                                    type="button" class="btn btn-info my-3" data-dismiss="modal">
                                                    &times;</button></tr>
                                        </table>

                                    </div>
                                </div>
                            </div><!-- /.modal-content -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $("#clear").click(function () {
        $("input").val("");
    });
</script>
<script>

    function addCategory() {
        $('.custom-category-modal').modal();
    }

    $("#imgInp").change(function () {
        // alert (0);
        readURL(this);
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                //alert (URL.createObjectURL(e.target.files[0]))
                $('#img_pre').attr('src', e.target.result);
                $('#img_pre').show();
                //$('#img_anchor').attr("href", e.target.result)				
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                //alert (URL.createObjectURL(e.target.files[0]))
                $('#img_pre').attr('src', e.target.result);
                $('#img_pre').show();
                //$('#img_anchor').attr("href", e.target.result)				
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function validations() {
        $.ajax
            ({
                type: "POST",
                url: "<?php echo base_url(); ?>/prasadamsetting/prasadam_g_validation",
                data: $("form").serialize(),
                success: function (data) {
                    obj = jQuery.parseJSON(data);
                    console.log(obj);
                    if (obj.err != '') {
                        $('#alert-modal').modal('show', { backdrop: 'static' });
                        $("#spndeddelid").text(obj.err);
                    } else {
                        $('input[type=submit]').prop('disabled', true);
                        $("#loader").show();
                        $("form").submit();
                    }
                }
            })

    }
</script>