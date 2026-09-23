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
<div id="banner-area" class="banner-area"
    style="background-image:url(<?php echo base_url(); ?>/assets/frontend/images/banner/banner5.jpg)">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="banner-heading">
                    <h1 class="banner-title">Ubayam Registration</h1>
                    <ol class="breadcrumb">
                        <li>Home</li>
                        <li><a href="#">New Ubayam Registration</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container my-5">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <?php if ($_SESSION['succ'] != '') { ?>
                        <div class="row" style="padding: 0 30%;" id="content_alert">
                            <div class="suc-alert">
                                <span class="suc-closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
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
                    <form action="<?php echo base_url(); ?>/ubayam_online/save" method="POST">
                        <div class="body">
                            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                            <div class="container-fluid">
                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <label class="form-label">Date <span style="color: red;">*</span></label>
                                        <input type="date" name="dt" id="ubhayam_date" class="form-control"
                                            value="<?php if ($view == true)
                                                echo date("Y-m-d", strtotime($data['dt']));
                                            else
                                                echo date("Y-m-d"); ?>"
                                            <?php echo $readonly; ?> required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Pay for</label>
                                        <select class="form-control" <?php echo $disable; ?> id="pay_for" name="pay_for"
                                            required>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label" style="display: contents;">Name<span
                                                style="color: red;">*</span></label>
                                        <input type="text" name="name" class="form-control"
                                            value="<?php echo $data['name']; ?>" <?php echo $readonly; ?> required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label" style="display: contents;">Address</label>
                                        <input type="text" name="address" class="form-control"
                                            value="<?php echo $data['address']; ?>" <?php echo $readonly; ?>>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">IC Number</label>
                                        <input type="text" name="ic_number" class="form-control"
                                            value="<?php echo $data['ic_number']; ?>" <?php echo $readonly; ?>>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Mobile Number</label>
                                        <input type="text" name="mobile" class="form-control"
                                            value="<?php echo $data['mobile']; ?>" <?php echo $readonly; ?>>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Remarks</label>
                                        <input type="text" name="description" class="form-control"
                                            value="<?php echo $data['description']; ?>" <?php echo $readonly; ?>>
                                    </div>
                                    <div class="col-sm-6">
                                        <?php
                                        if ($data['amount'])
                                            $amt = $data['amount'];
                                        else
                                            $amt = 0;
                                        ?>
                                        <label class="form-label">Package Amount <span
                                                style="color: red;">*</span></label>
                                        <input type="number" onkeyup="totalamt()" onchange="totalamt()" name="amount"
                                            id="total_amt" readonly class="form-control" step=".01" value="<?= $amt; ?>"
                                            <?php echo $readonly; ?>>
                                    </div>
                                    <div class="col-sm-6">
                                        <?php
                                        if ($data['paidamount'])
                                            $paidamt = $data['paidamount'];
                                        else
                                            $paidamt = 0;
                                        ?>
                                        <label class="form-label">Paid Amount <span style="color: red;">*</span></label>
                                        <input type="number" readonly name="paid_amount" id="paid_amount"
                                            class="form-control" step=".01" value="<?= $paidamt; ?>" <?php echo $readonly; ?>>
                                    </div>
                                    <div class="col-sm-6">
                                        <?php
                                        if ($data['balanceamount'])
                                            $balamt = $data['balanceamount'];
                                        else
                                            $balamt = 0;
                                        ?>
                                        <label class="form-label">Balance Amount <span
                                                style="color: red;">*</span></label>
                                        <input type="number" readonly name="balance_amount" id="balance_amount"
                                            class="form-control" step=".01" value="<?= $balamt; ?>" <?php echo $readonly; ?>>
                                    </div>
                                    <div class="col-md-12">&nbsp;</div>
                                    <div class="col-md-12">
                                        <?php if ($view != true) { ?>
                                            <div class="products row">
                                                <div class="col-sm-12">
                                                    <h3 style="margin-bottom:5px; margin-top:5px;">Pay Details</h3>
                                                </div>
                                                <div class="col-sm-5">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <input type="date" class="form-control" id="pay_date"
                                                                value="<?php echo date('Y-m-d'); ?>">
                                                            <label class="form-label">Pay Date</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <input type="number" id="pay_amt" min="0" class="form-control"
                                                                step=".01" value="0">
                                                            <label class="form-label">Amount</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group form-float">
                                                        <div class="form-line" style="border: none;">
                                                            <label id="pay_add" class="btn btn-success"
                                                                style="padding: 5px 12px !important;">Add</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="row scroll"
                                            style="overflow-y:scroll; overflow-x:hidden; height: 200px;">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table style="width:100%" class="table table-bordered"
                                                        id="pay_table" style="height: 150px;">
                                                        <thead>
                                                            <tr>
                                                                <th width="60%">Date</th>
                                                                <th width="25%">Total RM</th>
                                                                <?php if ($view != true) { ?>
                                                                    <th width="15%">Action</th>
                                                                <?php } ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if ($view == true) { ?>
                                                                <?php foreach ($payment as $row) { ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?php echo date("d/m/Y", strtotime($row['date'])); ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $row['amount']; ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php }
                                                            } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <input type="hidden" id="pay_row_count" value="1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">&nbsp;</div>
                                    <div class="col-md-12">
                                        <?php if ($view != true) { ?>
                                            <div class="products row">
                                                <div class="col-sm-12">
                                                    <h3 style="margin-bottom:5px; margin-top:5px;">Family Details</h3>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <input type="text" class="form-control" id="family_name">
                                                            <label class="form-label">Name</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <input type="number" id="family_icno" min="0"
                                                                class="form-control">
                                                            <label class="form-label">IC No</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <input type="text" class="form-control"
                                                                id="family_relationship">
                                                            <label class="form-label">Relationship</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group form-float">
                                                        <div class="form-line" style="border: none;">
                                                            <label id="family_add" class="btn btn-success"
                                                                style="padding: 5px 12px !important;">Add</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="row scroll"
                                            style="overflow-y:scroll; overflow-x:hidden; height: 200px;">
                                            <div class="table-responsive">
                                                <table style="width:100%" class="table table-bordered" id="family_table"
                                                    style="height: 150px;">
                                                    <thead>
                                                        <tr>
                                                            <th width="25%">Name</th>
                                                            <th width="25%">IC No</th>
                                                            <th width="25%">Relationship</th>
                                                            <?php if ($view != true) { ?>
                                                                <th width="25%">Action</th>
                                                            <?php } ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if ($view == true) { ?>
                                                            <?php foreach ($family as $row) { ?>
                                                                <tr>
                                                                    <td>
                                                                        <?php echo $row['name']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $row['icno']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $row['relationship']; ?>
                                                                    </td>
                                                                </tr>
                                                            <?php }
                                                        } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <input type="hidden" id="family_row_count" value="1">
                                        </div>
                                    </div>
                                    <?php if ($view != true) { ?>
                                        <div class="col-sm-12" align="center" style="margin-top:20px;">
                                            <button class="btn btn-success" type="submit">Submit</button>
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
                            <tr><span id="spndeddelid"><b></b></span>&nbsp;&nbsp;&nbsp;<button id="hide_remove_button"
                                    type="button" class="btn btn-info my-3" data-dismiss="modal"> &times;</button></tr>
                        </table>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div>
    </div>
</section>


<script>
    $('#ubhayam_date').change(function () {
        get_booking_ubhayam();
    });
    function get_booking_ubhayam() {
        var ubhayam_date = $("#ubhayam_date").val();
        //var cemetry_id = $("#reg_id").val();
        if (ubhayam_date != '') {
            $.ajax({
                url: "<?php echo base_url(); ?>/ubayam_online/get_booking_ubhayam",
                type: "post",
                data: { ubhayamdate: ubhayam_date },
                success: function (data) {
                    $("#pay_for").html(data);
                }
            });
        }
    }
    $(document).ready(function () {
        get_booking_ubhayam();
    });

    $("#pay_for").change(function () {
        var payfor = $(this).val();
        $.ajax({
            url: "<?php echo base_url() ?>/ubayam_online/get_payfor_collection",
            type: "POST",
            data: { id: payfor },
            success: function (data) {
                obj = jQuery.parseJSON(data);
                if (obj.target_amount) $("#total_amt").val(obj.target_amount);
                else $("#total_amt").val(0);
                // $("#targetamt").val(obj.target_amount);
                sum_amount();
            }
        })
    });
    <?php if ($view) { ?>
        $.ajax({
            url: "<?php echo base_url() ?>/ubayam_online/get_payfor_collection",
            type: "POST",
            data: { id: <?php echo $data['pay_for']; ?> },
            success: function (data) {
                obj = jQuery.parseJSON(data);
                if (obj.target_amount) $("#total_amt").val(obj.target_amount);
                else $("#total_amt").val(0);
            }
        })
    <?php } ?>
    $("#family_add").click(function () {
        var family_name = $("#family_name").val();
        var family_icno = $("#family_icno").val();
        var family_relationship = $("#family_relationship").val();
        var cnt_fmy = parseInt($("#family_row_count").val());
        if (family_name != '' && family_icno != '' && family_relationship != '') {
            var html = '<tr id="rmv_familyrow' + cnt_fmy + '">';
            html += '<td style="width: 25%;"><input type="text" style="border: none;" readonly name="familly[' + cnt_fmy + '][name]" value="' + family_name + '"></td>';
            html += '<td style="width: 25%;"><input type="text" style="border: none;" readonly name="familly[' + cnt_fmy + '][icno]" value="' + family_icno + '"></td>';
            html += '<td style="width: 25%;"><input type="text" style="border: none;" readonly name="familly[' + cnt_fmy + '][relationship]" value="' + family_relationship + '"></td>';
            html += '<td style="width: 25%;"><a class="btn btn-danger btn-rad" onclick="rmv_family(' + cnt_fmy + ')" style="width:auto;"><i class="fa fa-remove" style="color: #fff;font-size: 18px;"></i></a></td>';
            html += '</tr>';
            $("#family_table").append(html);
            var ct_fmy = parseInt(cnt_fmy + 1);
            $("#family_row_count").val(ct_fmy);
            $("#family_name").val('');
            $("#family_icno").val('');
            $("#family_relationship").val('');
        }
    });
    function rmv_family(id) {
        $("#rmv_familyrow" + id).remove();
    }
    $("#pay_add").click(function () {
        var date = $("#pay_date").val();
        var amt = $("#pay_amt").val();
        var cnt = parseInt($("#pay_row_count").val());
        if (date != '' && amt != 0) {
            var html = '<tr id="rmv_payrow' + cnt + '">';
            html += '<td style="width: 60%;"><input type="date" style="border: none;" readonly name="pay[' + cnt + '][date]" value="' + date + '"></td>';
            html += '<td style="width: 25%;"><input type="text" style="border: none;" readonly class="pay_amt" name="pay[' + cnt + '][pay_amt]" value="' + Number(amt).toFixed(2) + '"></td>';
            html += '<td style="width: 15%;"><a class="btn btn-danger btn-rad" onclick="rmv_pay(' + cnt + ')" style="width:auto;"><i class="fa fa-remove" style="color: #fff;font-size: 18px;"></i></a></td>';
            html += '</tr>';
            $("#pay_table").append(html);
            var ct = parseInt(cnt + 1);
            $("#pay_row_count").val(ct);
            sum_amount();
            $("#pay_amt").val('');
        }
    });
    function rmv_pay(id) {
        $("#rmv_payrow" + id).remove();
        sum_amount();
    }
    function totalamt() {
        sum_amount();
    }
    function sum_amount() {
        var pay_tot = 0;
        $(".pay_amt").each(function () {
            pay_tot += parseFloat($(this).val());
        });

        var total = Number($("#total_amt").val()).toFixed(2);
        $("#paid_amount").val(Number(pay_tot).toFixed(2));
        var balance = total - pay_tot;
        $("#balance_amount").val(Number(balance).toFixed(2));
    }
    $("#clear").click(function () {
        $("input").val("");
    });
    $("#submit").click(function () {
        $.ajax
            ({
                type: "POST",
                url: "<?php echo base_url(); ?>/memberreg/save",
                data: $("form").serialize(),
                success: function (data) {
                    obj = jQuery.parseJSON(data);
                    if (obj.err != '') {
                        $('#alert-modal').modal('show', { backdrop: 'static' });
                        $("#spndeddelid").text(obj.err);
                    } else {
                        if ($("#print").prop('checked') == true) {
                            printData(obj.id);
                        }
                        else {
                            $('#alert-modal').modal('show', { backdrop: 'static' });
                            $("#spndeddelid").text(obj.succ);
                            $("#hide_remove_button").hide();
                            //$("#reset_member_reg")[0].reset();
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                            //window.location.reload(true);
                        }
                    }
                }
            });
    });

    function printData(id) {
        $.ajax({
            url: "<?php echo base_url(); ?>/memberreg/print_page/" + id,
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