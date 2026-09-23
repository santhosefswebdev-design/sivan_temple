<?php $db = db_connect(); ?>
<?php $booking_calendar_range_year = booking_calendar_range_year($_SESSION['booking_range_year']); ?>
<?php $overall_temple_block_dates = get_overall_temple_block_dates(); ?>
<style>
    <?php if ($view == true) { ?>
        label.form-label span {
            display: none !important;
            color: transporant;
        }

    <?php } ?>
</style>
<?php
if ($view == true) {
    $readonly = 'readonly';
    $disable = "disabled";
}
?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2> UBAYAM <small>Ubayam / <b>Add Ubayam</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row">
                            <div class="col-md-8"><!--<h2>Ubayam</h2>--></div>
                            <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/ubayam/ubayam_new"><button
                                        type="button" class="btn bg-deep-purple waves-effect">List</button></a></div>
                        </div>
                    </div>
                    <div class="body">

                        <form>
                            <!--<input type="hidden" name="id" id="id" value="<?php //echo $data['id'];   ?>">-->
                            <div class="container-fluid">
                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label">Booking Date <span
                                                        style="color: red;">*</span></label>
												<input type="text" name="dt" id="dt" class="form-control" value="<?php echo date("d-m-Y"); ?>" max="<?php echo date("d-m-Y"); ?>" />
                                            </div>
                                        </div>
                                    </div>
									<div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label">Ubayam Date <span
                                                        style="color: red;">*</span></label>
												<?php
												if(!empty($date)){
												?>
												<input type="text" class="form-control datepicker" value="<?php echo date("d-m-Y", strtotime($date)); ?>" disabled />
												<input type="hidden" name="ubhayam_date" id="ubhayam_date" value="<?php echo date("d-m-Y", strtotime($date)); ?>" />
												<?php
												}else{?>
                                                <input type="text" name="dt" id="ubhayam_date" class="form-control datepicker"
                                                    value="<?php if ($view == true)
                                                        echo date("d-m-Y", strtotime($data['ubhayam_date']));
                                                    else
                                                        echo date("d-m-Y"); ?>" <?php echo $readonly; ?> >
												<?php 
												}
												?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="form-label" style="display: contents;">Pay for <span
                                                        style="color: red;">*</span></label>
                                                <select class="form-control" <?php echo $disable; ?> id="pay_for"
                                                    name="pay_for">

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" id="targetamt" class="form-control" value="0" readonly >
                                                <label class="form-label">Target Amount </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" id="collectionamt" class="form-control" value="0" readonly >
                                                <label class="form-label">Collection Amount </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" id="collectedamt" class="form-control" value="0" readonly >
                                                <label class="form-label">Collected Amount </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" id="balanceamt" class="form-control" value="0" readonly >
                                                <label class="form-label">Balance Amount </label>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="name" class="form-control"
                                                    value="<?php echo $data['name']; ?>" <?php echo $readonly; ?>>
                                                <label class="form-label">Name <span
                                                        style="color: red;">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="address" class="form-control"
                                                    value="<?php echo $data['address']; ?>" <?php echo $readonly; ?>>
                                                <label class="form-label">Address</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="ic_number" class="form-control"
                                                    value="<?php echo $data['ic_number']; ?>" <?php echo $readonly; ?>>
                                                <label class="form-label">Ic Number</label>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if ($view != true) { ?>
                                        <div class="col-sm-4">
                                            <div class="row">
                                                <div class="col-md-3" style="margin: 0px;">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <select class="form-control" name="phonecode" id="phonecode">
                                                                <?php
                                                                if (!empty ($phone_codes)) {
                                                                    foreach ($phone_codes as $phone_code) {
                                                                        ?>
                                                                        <option value="<?php echo $phone_code['dailing_code']; ?>"
                                                                            <?php if ($phone_code['dailing_code'] == "+60") {
                                                                                echo "selected";
                                                                            } ?>><?php echo $phone_code['dailing_code']; ?>
                                                                        </option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-9" style="margin: 0px;">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <input class="form-control reg_det" type="number" min="0"
                                                                name="mobile" id="mobile" required
                                                                pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" autocomplete="off">
                                                            <label class="form-label">Mobile Number<span
                                                                    style="color: red;"> *</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    } else {
                                        ?>
                                        <div class="col-sm-4">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="number" min="0" name="mobile" class="form-control"
                                                        value="<?php echo $data['mobile']; ?>" <?php echo $readonly; ?>>
                                                    <label class="form-label">Mobile Number</label>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="email" name="email" class="form-control"
                                                    value="<?php echo $data['email']; ?>" <?php echo $readonly; ?>>
                                                <label class="form-label">Email Address</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="description" class="form-control"
                                                    value="<?php echo $data['description']; ?>" <?php echo $readonly; ?>>
                                                <label class="form-label">Remarks</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <?php
                                                if ($data['amount'])
                                                    $amt = $data['amount'];
                                                else
                                                    $amt = 0;
                                                ?>
                                                <input type="number" onkeyup="totalamt()" onchange="totalamt()"
                                                    name="amount" id="total_amt" readonly class="form-control"
                                                    step=".01" value="<?= $amt; ?>" <?php echo $readonly; ?>>
                                                <label class="form-label">Package Amount <span
                                                        style="color: red;">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <?php
                                                if ($data['paidamount'])
                                                    $paidamt = $data['paidamount'];
                                                else
                                                    $paidamt = 0;
                                                ?>
                                                <input type="number" readonly name="paid_amount" id="paid_amount"
                                                    class="form-control" step=".01" value="<?= $paidamt; ?>" <?php echo $readonly; ?>>
                                                <label class="form-label">Paid Amount <span
                                                        style="color: red;">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <?php
                                                if ($data['balanceamount'])
                                                    $balamt = $data['balanceamount'];
                                                else
                                                    $balamt = 0;
                                                ?>
                                                <input type="number" readonly name="balance_amount" id="balance_amount"
                                                    class="form-control" step=".01" value="<?= $balamt; ?>" <?php echo $readonly; ?>>
                                                <label class="form-label">Balance Amount <span
                                                        style="color: red;">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <?php if ($view != true) { ?>
                                        <div class="products row">
                                            <div class="col-sm-12">
                                                <h3 style="margin-bottom:5px; margin-top:5px;">Pay Details</h3>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="date" class="form-control" id="pay_date"
                                                            value="<?php echo date('Y-m-d'); ?>" max="<?php echo $booking_calendar_range_year; ?>">
                                                        <label class="form-label">Pay Date</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group form-float">
                                                    <div class="form-line focused">
                                                        <input type="number" id="pay_amt" min="0" class="form-control"
                                                            step=".01" placeholder="0.00">
                                                        <label class="form-label">Amount</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <select class="form-control" name="paymentmode" id="paymentmode">
                                                            <!--option value="0">Select</option-->
                                                            <?php foreach ($payment_modes as $payment_mode) { ?>
                                                                <option value="<?php echo $payment_mode['id']; ?>">
                                                                    <?php echo $payment_mode['name']; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                        <label class="form-label">Payment Mode</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group form-float">
                                                    <div class="form-line" style="border: none;">
                                                        <label id="pay_add" class="btn btn-success"
                                                            style="padding: 5px 12px !important;">Add</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--<div class="col-sm-2">
                                                <div class="form-group form-float">
                                                    <div class="form-line" style="border: none;">
                                                        <label class="btn btn-primary">Clear</label>
                                                    </div>
                                                </div>
                                            </div>-->
                                        </div>
                                    <?php } ?>
                                    <div class="row scroll"
                                        style="overflow-y:scroll; overflow-x:hidden; height: 200px;">
                                        <div class="table-responsive">
                                            <table style="width:100%" class="table table-bordered" id="pay_table"
                                                style="height: 150px;">
                                                <thead>
                                                    <tr>
                                                        <th width="15%">Date</th>
                                                        <th width="25%">Total RM</th>
                                                        <th width="25%">Payment Mode</th>
                                                        <?php if ($view != true) { ?>
                                                            <th width="15%">Action</th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if ($view == true) { ?>
                                                        <?php foreach ($payment as $row) {
                                                            $payment_mode = $db->table("payment_mode")->where('id', $row['payment_mode'])->get()->getRowArray();
                                                            $payment_mode_name = !empty ($payment_mode['name']) ? $payment_mode['name'] : "";
                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <?php echo date("d/m/Y", strtotime($row['date'])); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $row['amount']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $payment_mode_name; ?>
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
                                                        <input type="number" id="family_icno" min="0" class="form-control">
                                                        <label class="form-label">IC No</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" id="family_relationship">
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

                                <div class="col-sm-12" align="center">
                                    <?php if ($view != true) { ?>

                                        <input type="checkbox" checked="checked" id="print" name="print" value="Print">
                                        <label for='print'> Print &nbsp;&nbsp; </label>
                                        <label id="submit" class="btn btn-success btn-lg waves-effect">SAVE</label>
                                        <button type="button" id="clear"
                                            class="btn btn-primary btn-lg waves-effect">CLEAR</button>
                                        <!--<button type="button" class="btn btn-danger btn-lg waves-effect" id="print_submit">PRINT</button>-->
                                        <!--<button type="button" class="btn btn-danger btn-lg waves-effect" onclick="window.open('<?php echo base_url(); ?>/ubayam/print_doc', '_blank')">PRINT</button>-->
                                    <?php } else { ?>
                                        <!-- <button type="button" class="btn btn-danger btn-lg waves-effect" onclick="window.open('<?php echo base_url(); ?>/ubayam/print_page/<?php echo $data['id']; ?>', '_blank')">PRINT</button>-->
                                    </div>
                                <?php } ?>
                            </div>
                    </div>
                    </form>
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
<script>
    $( ".datepicker" ).datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy',
        minDate:'<?php echo date("d-m-Y"); ?>',
        maxDate:'<?php echo date("d-m-Y", strtotime($booking_calendar_range_year)); ?>',
        beforeShowDay: function(date) {
            var datesForDisable = <?php echo $overall_temple_block_dates; ?>;
            var string = moment(date).format('DD-MM-YYYY');
            if (datesForDisable.length > 0) {
                for (var i = 0; i < datesForDisable.length; i++) { 
                    if (Array.isArray(datesForDisable[i])) {
                        var from = moment(datesForDisable[i][0]).format('DD-MM-YYYY');
                        var to = moment(datesForDisable[i][1]).format('DD-MM-YYYY');
                        var current = string;
                        if (current >= from && current <= to) return false;
                    }
                }
            }
            return [datesForDisable.indexOf(string) == -1]
        }
    });
	 $( "#dt" ).datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy',
        maxDate:'<?php echo date("d-m-Y"); ?>',
        beforeShowDay: function(date) {
            var datesForDisable = <?php echo $overall_temple_block_dates; ?>;
            var string = moment(date).format('DD-MM-YYYY');
            if (datesForDisable.length > 0) {
                for (var i = 0; i < datesForDisable.length; i++) { 
                    if (Array.isArray(datesForDisable[i])) {
                        var from = moment(datesForDisable[i][0]).format('DD-MM-YYYY');
                        var to = moment(datesForDisable[i][1]).format('DD-MM-YYYY');
                        var current = string;
                        if (current >= from && current <= to) return false;
                    }
                }
            }
            return [datesForDisable.indexOf(string) == -1]
        }
    });

    $('#ubhayam_date').change(function () {
        get_booking_ubhayam();
    });
    function get_booking_ubhayam() {
        var ubhayam_date = $("#ubhayam_date").val();
        //var cemetry_id = $("#reg_id").val();
        if (ubhayam_date != '') {
            $.ajax({
                url: "<?php echo base_url(); ?>/ubayam/get_booking_ubhayam",
                type: "post",
                data: { ubhayamdate: ubhayam_date },
                success: function (data) {
                    $("#pay_for").html(data);
                    $('#pay_for').prop('selectedIndex', 0);
                    $("#pay_for").selectpicker("refresh");
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
            url: "<?php echo base_url() ?>/ubayam/get_payfor_collection",
            type: "POST",
            data: { id: payfor },
            success: function (data) {
                obj = jQuery.parseJSON(data);
                if (obj.target_amount) $("#total_amt").val(obj.target_amount);
                else $("#total_amt").val(0);
                $("#targetamt").val(obj.target_amount);
                sum_amount();
                // $("#collectionamt").val(obj.totalamt);
                // $("#collectedamt").val(obj.collection);
                // $("#balanceamt").val(obj.balanceamt);
            }
        })
    });
    <?php if ($view) { ?>
        $.ajax({
            url: "<?php echo base_url() ?>/ubayam/get_payfor_collection",
            type: "POST",
            data: { id: <?php echo $data['pay_for']; ?> },
            success: function (data) {
                obj = jQuery.parseJSON(data);
                if (obj.target_amount) $("#total_amt").val(obj.target_amount);
                else $("#total_amt").val(0);
                // $("#targetamt").val(obj.target_amount);
                // $("#collectionamt").val(obj.totalamt);
                // $("#collectedamt").val(obj.collection);
                // $("#balanceamt").val(obj.balanceamt);
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
            html += '<td style="width: 25%;"><a class="btn btn-danger btn-rad" onclick="rmv_family(' + cnt_fmy + ')" style="width:auto;"><i class="material-icons"></i></a></td>';
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
    function get_payment_mode(id, cntno) {
        //alert(id);
        if (id != '') {
            $.ajax({
                url: "<?php echo base_url(); ?>/ubayam/get_payment_mode",
                type: "post",
                data: { id: id },
                dataType: "json",
                success: function (data) {
                    $("#payment_mode_" + cntno).val(id);
                    $("#payment_mode_label_" + cntno).text(data['name']);
                }
            });
        }
    }
    $("#pay_add").click(function () {
        var date = $("#pay_date").val();
        var amt = $("#pay_amt").val();
        var paymentmode = $("#paymentmode").val();
        var cnt = parseInt($("#pay_row_count").val());
        if (date != '' && amt != 0 && paymentmode != 0) {
            var total_amt = parseFloat($('#total_amt').val());
            var paid_amount = parseFloat($('#paid_amount').val());
            amt = parseFloat(amt);
            if (amt <= (total_amt - paid_amount)) {
                get_payment_mode(paymentmode, cnt);
                var html = '<tr id="rmv_payrow' + cnt + '">';
                html += '<td style="width: 60%;"><input type="date" style="border: none;" readonly name="pay[' + cnt + '][date]" value="' + date + '"></td>';
                html += '<td style="width: 25%;"><input type="text" style="border: none;" readonly class="pay_amt" name="pay[' + cnt + '][pay_amt]" value="' + Number(amt).toFixed(2) + '"></td>';
                html += '<td style="width: 20%;"><input type="hidden" style="border: none;" readonly id="payment_mode_' + cnt + '" name="pay[' + cnt + '][payment_mode]"><span id="payment_mode_label_' + cnt + '"></span></td>';
                html += '<td style="width: 15%;"><a class="btn btn-danger btn-rad" onclick="rmv_pay(' + cnt + ')" style="width:auto;"><i class="material-icons"></i></a></td>';
                html += '</tr>';
                $("#pay_table").append(html);
                var ct = parseInt(cnt + 1);
                $("#pay_row_count").val(ct);
                sum_amount();
                $("#pay_amt").val('');
                $('#paymentmode').prop('selectedIndex', 0);
                $("#paymentmode").selectpicker("refresh");
            }
            else {
                alert('Can\'t exceed the amount more than Total amount');
            }
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
		var total_amt = parseFloat($("#total_amt").val());
		var paid_amount = parseFloat($("#paid_amount").val());
		if(paid_amount >= total_amt){
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>/ubayam/save",
				data: $("form").serialize(),
				beforeSend: function () {
					$("#loader").show();
				},
				success: function (data) {
					obj = jQuery.parseJSON(data);
					if (obj.err != '') {
						$('#alert-modal').modal('show', { backdrop: 'static' });
						$("#spndeddelid").text(obj.err);
					} else {
						if ($("#print").prop('checked') == true) {
							printData(obj.id);
						}
						else
							window.location.replace("<?php echo base_url(); ?>/ubayam");
					}
				},
				complete: function (data) {
					// Hide image container
					$("#loader").hide();
				}
			});
		}else{
			$('#alert-modal').modal('show', { backdrop: 'static' });
			$("#spndeddelid").text('Partial Payment not allowed. Please Pay Full Amount.');
		}
    });
    
    function printData(id) {
        $.ajax({
            url: "<?php echo base_url(); ?>/ubayam/print_page/" + id,
            type: 'POST',
            success: function (result) {
                //console.log(result)
                popup(result);
            }
        });
    }

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

        frame1.remove();
        window.location.reload(true);
        //return true;
    }

</script>