<?php
if ($view == true) {
    $readonly = 'readonly';
    $disable = "disabled";
}
?>
<style>
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
            <h2> Renewal Page</h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row">
                            <div class="col-md-8"><!--<h2>Cash Donation</h2>--></div>
                            <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/member/renewal"><button
                                        type="button" class="btn bg-deep-purple waves-effect">List</button></a></div>
                        </div>
                    </div>
                    <form action="<?php echo base_url(); ?>/member/renewal_save" method="post">
                        <div class="body">
                            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                            <div class="container-fluid">
                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="name" class="form-control"
                                                    value="<?php echo $data['name']; ?>" readonly>
                                                <label class="form-label">Name </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control"
                                                    value="<?php echo $data['member_no']; ?>" readonly>
                                                <label class="form-label">Member Number</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label" style="display: contents;">Member Type <span
                                                        style="color: red;">*</span></label>
                                                <select class="form-control" id="member_type" name="member_type" disabled>
                                                    <option value="">-- Select Type --</option>
                                                    <?php
                                                    if (count($member_type_list) > 0) {
                                                        foreach ($member_type_list as $mtl) {
                                                            ?>
                                                        <option value="<?php echo $mtl['id']; ?>" <?php echo ($data['member_type'] == $mtl['id']) ? "selected" : ""; ?>>
                                                            <?php echo $mtl['name']; ?>
                                                        </option>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label" style="display: contents;">Status <span
                                                        style="color: red;">*</span></label>
                                                <select class="form-control" name="status" disabled>
                                                    <option value="">-- Select Status --</option>
                                                    <option value="1" <?php echo ($data['status'] == 1) ? "selected" : ""; ?>>Active</option>
                                                    <option value="2" <?php echo ($data['status'] == 2) ? "selected" : ""; ?>>Deactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="ic_number" class="form-control"
                                                    value="<?php echo $data['ic_no']; ?>" readonly>
                                                <label class="form-label">Ic Number</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="mobile" class="form-control"
                                                    value="<?php echo $data['mobile']; ?>" readonly>
                                                <label class="form-label">Mobile Number</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="address" class="form-control"
                                                    value="<?php echo $data['address']; ?>" readonly>
                                                <label class="form-label">Address</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="email" name="email_address" id="email_address"
                                                    class="form-control" value="<?php echo $data['email_address']; ?>"
                                                    readonly>
                                                <label class="form-label">Email ID</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div style="clear:both"></div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line" id="bs_datepicker_component_container">
                                               <input type="date" required name="start_date" id="start_date" class="form-control" value="<?php if(!empty($data['start_date'])){ echo $data['start_date']; } ?>" readonly>
                                                <label class="form-label">Start Date <span
                                                        style="color: red;">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line" id="bs_datepicker_component_container">
                                                <?php
                                                $endDate = date("Y-m-d", strtotime("+1 year -1 day"));
                                                $formattedEndDate = date("d.m.Y", strtotime("+1 year -1 day"));
                                                ?>
                                               <input type="text" name="end_date" class="form-control" value="<?php if(!empty($data['end_date'])){ echo $data['end_date']; } else { echo $formattedEndDate; } ?>" readonly>
                                                <label class="form-label">End Date</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <input type="number" step="0.1" id="payment" name="payment"
                                                    class="form-control" step=".01" value="<?= $data['payment'] ?>" readonly>
                                                <label class="form-label">Payment <span
                                                        style="color: red;">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <select class="form-control" name="paymentmode" id="paymentmode">
                                                    <!--option value="0">Select</option-->
                                                    <?php foreach ($payment_modes as $payment_mode) { ?>
                                                                <option value="<?php echo $payment_mode['id']; ?>" >
                                                                    <?php echo $payment_mode['name']; ?>
                                                                </option>
                                                    <?php } ?>
                                                </select>
                                                <label class="form-label">Payment Mode <span
                                                        style="color: red;">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                    <?php if ($view != true) { ?>
                                                <div class="col-sm-12" align="center">
                                                    <!-- <input  type="checkbox" checked="checked" id="print" name="print" value="Print">
                                    <label for ='print'> Print &nbsp;&nbsp; </label> -->
                                                    <button type="submit" class="btn btn-success btn-lg waves-effect">RENEWAL</button>
                                                </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </form>
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
                        <table>
                            <tr><span id="spndeddelid"><b></b></span>&nbsp;&nbsp;&nbsp;<button type="button"
                                    class="btn btn-info my-3" data-dismiss="modal"> &times;</button></tr>
                        </table>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div>
    </div>
</section>
<link href="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>

<script>
    
$(document).ready(function () {
    var originalEndDateValue = "<?php echo $formattedEndDate; ?>";

        function updateEndDate() {
            var startDate = $("#start_date").val();
            var endDateField = $("[name='end_date']");

            if (startDate) {
                var oneYearLater = new Date(startDate);
                oneYearLater.setFullYear(oneYearLater.getFullYear() + 1);
                oneYearLater.setDate(oneYearLater.getDate() - 1);

                var dd = String(oneYearLater.getDate()).padStart(2, '0');
                var mm = String(oneYearLater.getMonth() + 1).padStart(2, '0');
                var yyyy = oneYearLater.getFullYear();

                var formattedEndDate = dd + '-' + mm + '-' + yyyy;
                endDateField.val(formattedEndDate);
            } else {
                endDateField.val(originalEndDateValue);
            }
        }

        updateEndDate();

        $("#start_date").on("change", function () {
            updateEndDate();
        });

        $("#member_type").on("change", function () {
            var selectedIndex = this.selectedIndex;
            var endDateField = $("[name='end_date']");

            if (selectedIndex === 1 || selectedIndex === 2) {
                endDateField.val(originalEndDateValue);
            } else {
                endDateField.val("");
            }
        });
    });


    $("form").on("submit", function () {
        $('input[type=submit]').prop('disabled', true);
        $("#loader").show();
    });
    $("#member_type").change(function () {
        var type = $(this).val();
        $.ajax({
            type: "post",
            url: "<?php echo base_url(); ?>/member/get_member_amount",
            data: { id: type },
            success: function (data) {
                obj = jQuery.parseJSON(data);
                $("#payment").val(obj.amount);
            }
        });
    });


    $("#clear").click(function () {
        $("input").val("");
    });
    $("#submit").click(function () {
        $.ajax
            ({
                type: "POST",
                url: "<?php echo base_url(); ?>/member/save",
                data: $("form").serialize(),
                beforeSend: function () {
                    $("#loader").show();
                },
                success: function (data) {
                    // return;
                    obj = jQuery.parseJSON(data);
                    if (obj.err != '') {
                        $('#alert-modal').modal('show', { backdrop: 'static' });
                        $("#spndeddelid").text(obj.err);
                    } else {
                        if ($("#print").prop('checked') == true) {
                            printData(obj.id);
                        }
                        else
                            window.location.reload(true);
                    }
                },
                complete: function (data) {
                    // Hide image container
                    $("#loader").hide();
                }
            });
    });

    function printData(id) {
        $.ajax({
            url: "<?php echo base_url(); ?>/member/print_page/" + id,
            type: 'POST',
            success: function (result) {
                //console.log(result)
                popup(result);
            }
        });
    }

    //setTimeout(popup(data), 500000);
    function popup(data) {
        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        frame1.css({ "position": "absolute", "top": "-1000000px" });
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        //Create a new HTML document.
        frameDoc.document.write('<html>');
        frameDoc.document.write('<head>');
        frameDoc.document.write('<title></title>');
        frameDoc.document.write('</head>');
        frameDoc.document.write('<body >');
        frameDoc.document.write(data);
        frameDoc.document.write('</body>');
        frameDoc.document.write('</html>');
        frameDoc.document.close();
        setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
            window.location.reload(true);
        }, 500);

        frameDoc.onload(function () {
            frameDoc.focus();
            frameDoc.print();
            frameDoc.close();
        });

        frame1.remove();
        //window.location.replace("<?php echo base_url(); ?>/donation");
        window.location.reload(true);
        //return true;
    }

</script>