<?php
if ($view == true) {
    $readonly = 'readonly';
    $disable = "disabled";
}
?>
<style>
    #table {
        width: 100%;
        border-collapse: collapse;
    }

    #table th {
        padding: 5px;
        background: #f44336;
        color: #fff;
    }

    #table td {
        padding: 5px;
    }
</style>


<?php
// Create a function for converting the amount in words
function AmountInWords(float $amount)
{
    $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
    // Check if there is any number after decimal
    $amt_hundred = null;
    $count_length = strlen($num);
    $x = 0;
    $string = array();
    $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
        3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
        7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
        13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
        16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
        19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
        40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
        70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
    $here_digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
    while ($x < $count_length) {
        $get_divider = ($x == 2) ? 10 : 100;
        $amount = floor($num % $get_divider);
        $num = floor($num / $get_divider);
        $x += $get_divider == 10 ? 1 : 2;
        if ($amount) {
            $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
            $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
            $string[] = ($amount < 21) ? $change_words[$amount] . ' ' . $here_digits[$counter] . $add_plural . ' 
       ' . $amt_hundred : $change_words[floor($amount / 10) * 10] . ' ' . $change_words[$amount % 10] . ' 
       ' . $here_digits[$counter] . $add_plural . ' ' . $amt_hundred;
        } else
            $string[] = null;
    }
    $implode_to_Rupees = implode('', array_reverse($string));
    /*$get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
    " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';*/
    $get_paise = ($amount_after_decimal > 0) ? "and " . ($change_words[$amount_after_decimal / 10] . " 
   " . $change_words[$amount_after_decimal % 10]) . ' Cents' : '';
    //return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
    return ($implode_to_Rupees ? 'Ringgit ' . $implode_to_Rupees : '') . $get_paise . 'Only';
}
?>


<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DEFECTIVE ITEM<small>Inventory / <b>Add Defective Item</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row">
                            <div class="col-md-8">
                                <h2>Defective Item Add</h2>
                            </div>
                            <div class="col-md-4" align="right"><a
                                    href="<?php echo base_url(); ?>/stock/defective_item"><button type="button"
                                        class="btn bg-deep-purple waves-effect">List</button></a></div>
                        </div>
                    </div>
                    <div class="body">

                        <form action="<?php echo base_url(); ?>/stock/defective_item_save" method="post">
                            <div class="container-fluid">
                                <div class="row clearfix">
                                    <div class="col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line" id="bs_datepicker_container">
                                                <input type="date" name="date" id="date" class="form-control" <?php echo $readonly; ?> value="<?php if ($view == true) {
                                                        echo $data['date'];
                                                    } else {
                                                        echo date('Y-m-d');
                                                    } ?>">
                                                <!--<label class="form-label">Date</label>-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <!--<label class="form-label" style="display: contents;">Staff Name</label>-->
                                                <select class="form-control show-tick" name="staffname" id="staffname"
                                                    required>
                                                    <option value="">-- Select Staff Name --</option>
                                                    <?php foreach ($staff as $st) { ?>
                                                        <option <?php if ($data['staff_name'] == $st['id'])
                                                            echo "selected='selected'"; ?> value="<?php echo $st['id']; ?>">
                                                            <?php echo $st['name']; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group form-float" style="display:none;" required>
                                            <div class="form-line">
                                                <input type="text" name="invno" id="invno" class="form-control" readonly
                                                    value="<?php if ($view == true) {
                                                        echo $data['invoice_no'];
                                                    } else {
                                                        echo $inv_no;
                                                    } ?>">
                                                <label class="form-label">Invoice No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <?php if ($view != true) { ?>
                                        <div class="col-sm-2">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <select class="form-control" id="producttype">
                                                        <option value="">-- Select type --</option>
                                                        <option value="1">Product</option>
                                                        <option value="2">Raw Material</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="hidden" class="add_list" id="pname">
                                                    <select class="form-control show-tick calc_amt add_list"
                                                        id="productname">
                                                        <option value="">-- Select Item Name --</option>
                                                        <?php foreach ($product as $p) { ?>
                                                            <option value="<?php echo $p['id']; ?>">
                                                                <?php echo $p['name']; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <div class="form-group form-float">
                                                <div class="form-line focused">
                                                    <input type="hidden" class="add_list" id="uom_id" value="0">
                                                    <label class="form-label">UOM</label>
                                                    <input type="text" readonly class="form-control calc_amt add_list"
                                                        id="uom" <?php echo $readonly; ?>>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <div class="form-group form-float">
                                                <div class="form-line focused">
                                                    <input type="text" class="form-control calc_amt add_list" id="rate"
                                                        <?php echo $readonly; ?>>
                                                    <label class="form-label">Rate</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <div class="form-group form-float">
                                                <div class="form-line focused">
                                                    <input type="number" id="qty" min="0"
                                                        class="form-control calc_amt add_list" <?php echo $readonly; ?>>
                                                    <label class="form-label">Qty</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <div class="form-group form-float">
                                                <div class="form-line focused">
                                                    <input type="number" id="avl_qty" class="form-control add_list"
                                                        readonly>
                                                    <label class="form-label">Available</label>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group form-float">
                                                <div class="form-line focused">
                                                    <input type="number" id="amount" class="form-control add_list" <?php echo $readonly; ?>>
                                                    <label class="form-label">Amount</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <div class="form-group form-float">
                                                <button class="btn btn-success" onclick="appen()" type="button"><i
                                                        class="glyphicon glyphicon-plus"></i></button>
                                            </div>
                                        </div>

                                    <?php } ?>


                                    <br><br>
                                    <?php if ($view != true) { ?>
                                        <div class="table-responsive col-md-12">
                                            <table class="table table-bordered table-hover" id="table" border="1 ">
                                                <thead>
                                                    <tr>
                                                        <th style="width:25%;">Type</th>
                                                        <th style="width:25%;">Item Name</th>
                                                        <th style="width:10%;">UOM</th>
                                                        <th style="width:10%;">Rate</th>
                                                        <th style="width:10%;">Qty</th>
                                                        <th style="width:10%;">Amount</th>
                                                        <th style="width:10%;">Delete</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                        <input type="hidden" id="tot_count" value="0">
                                        <br><br>
                                    <?php } ?>

                                    <?php if ($view == true) { ?>
                                        <div class="table-responsive col-md-12">
                                            <table class="table table-bordered table-striped table-hover" id="table"
                                                border="1 ">
                                                <thead>
                                                    <tr>
                                                        <th style="width:25%;">Type</th>
                                                        <th style="width:35%;">Item Name</th>
                                                        <th style="width:10%;">UOM</th>
                                                        <th style="width:10%;">Rate</th>
                                                        <th style="width:10%;">Qty</th>
                                                        <th style="width:10%;">Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $total = 0;
                                                    foreach ($sto as $row) { ?>
                                                        <tr>
                                                            <td>
                                                                <?php
                                                                if ($row['item_type'] == 1) {
                                                                    echo "Product";
                                                                } else if ($row['item_type'] == 2) {
                                                                    echo "Raw Material";
                                                                } else {
                                                                    echo "";
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $row['item_name']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $row['symbol']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo number_format($row['rate'], '2', '.', ','); ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $row['quantity']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo number_format($row['amount'], '2', '.', ','); ?>
                                                            </td>
                                                        </tr>
                                                        <?php $total += $row['amount'];
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php } ?>

                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <input type="number" name="itemamount" id="itemamount"
                                                    class="form-control"
                                                    value="<?php echo number_format((float) $total, 2, '.', ''); ?>"
                                                    <?php echo $readonly; ?>>
                                                <label class="form-label">Item Amount</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <input type="text" name="wamount" id="wamount" class="form-control"
                                                    value="<?php if ($total == '') {
                                                        echo "Zero";
                                                    } else {
                                                        echo AmountInWords($total);
                                                    } ?>" <?php echo $readonly; ?>>
                                                <label class="form-label">Amount in Words</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <input type="text" name="reason" id="reason" class="form-control"
                                                    value="<?php echo $data['reason']; ?>" <?php echo $readonly; ?>>
                                                <label class="form-label">Reason</label>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if ($view != true) { ?>
                                        <div class="col-sm-12" align="center">
                                            <!--input  type="checkbox" checked="checked" id="print" name="print" value="Print">
                                    <label for ='print'> Print &nbsp;&nbsp; </label-->

                                            <label id="submit" class="btn btn-success btn-lg waves-effect">SAVE</label>

                                            <label id="clear" class="btn btn-primary btn-lg waves-effect">CLEAR</label>
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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<link href="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<script>
    $(document).ready(function () {
        $('#producttype').on('change', function () {
            $("#productname").empty();
            var product_type = this.value;
            $.ajax({
                url: "<?php echo base_url(); ?>/stock/get_productcategory",
                type: "POST",
                data: {
                    producttype: product_type
                },
                cache: false,
                success: function (result) {
                    $("#productname").html(result);
                    $('#productname').prop('selectedIndex', 0);
                    $("#productname").selectpicker("refresh");
                    $("#uom").val("");
                    $("#rate").val("");
                    $("#qty").val("");
                    $("#amount").val("");
                }
            });
        });
    });
</script>
<script>
    $("#submit").click(function () {
        $.ajax
            ({
                type: "POST",
                url: "<?php echo base_url(); ?>/stock/defective_item_save",
                data: $("form").serialize(),
                beforeSend: function () {
                    $('input[type=submit]').prop('disabled', true);
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
                            window.location.reload(true);
                    }
                },
                complete: function (data) {
                    // Hide image container
                    $('input[type=submit]').prop('disabled', false);
                    $("#loader").hide();
                }
            });
    });

    function printData(id) {
        $.ajax({
            url: "<?php echo base_url(); ?>/stock/print_page_defective_item/" + id,
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
        //window.location.replace("<?php echo base_url(); ?>/donation");
        window.location.reload(true);
        //return true;
    }

    $('#date').change(function () {

        $.ajax
            ({
                type: "POST",
                url: "<?php echo base_url(); ?>/stock/get_out_inv_no",
                data: { dt: $('#date').val() },
                success: function (data) {
                    //alert(data);
                    $('#invno').val(data);
                }
            })
    });

    $("#productname").change(function () {
        var id = $("#productname").val();
        var producttype = $("#producttype").val();
        $.ajax({
            url: "<?php echo base_url(); ?>/stock/getuom",
            type: "post",
            data: { type: producttype, name: id },
            dataType: "json",
            success: function (data) {
                //var obj = jQuery.parseJSON(data);
                console.log(data.uom_name);
                $("#avl_qty").val(data.stock);
                $("#uom_id").val(data.uom_id);
                $("#rate").val(data.amount);
                $("#uom").val(data.uom_name);
                $("#pname").val(data.name);
            }
        });
    });

    $(".calc_amt").keyup(function () {
        amt_calc();
    });
    $(".calc_amt").change(function () {
        amt_calc();
    });

    $("#clear").click(function () {
        $("input").val("");
    });

    function amt_calc() {
        var qty = $("#qty").val();
        var avl = $("#avl_qty").val();
        var rate = $("#rate").val();
        $(".month_err").remove();
        if (parseInt(avl) < parseInt(qty)) {
            $("#qty").after('<span style="color: red;" class="month_err">Please Enter Below ' + avl + '<span>')
            $("#qty").val('');
            $("#amount").val(0);
        } else {
            var total = parseFloat(qty) * parseFloat(rate);
            $("#amount").val(total);
        }

    }

    function appen() {
        var count = parseInt($("#tot_count").val());
        var a = $("#productname").val();
        var producttype = $("#producttype").val();
        var producttype_text = $("#producttype option:selected").text();
        var pname = $("#pname").val();
        var uo_id = $("#uom_id").val();
        var b = $("#uom").val();
        var c = parseInt($("#rate").val());
        var d = parseInt($("#qty").val());
        var e = $("#amount").val();
        if (producttype != "" && a != 0 && e > 0 && uo_id > 0 && c > 0 && d > 0) {
            if (producttype == 1 && a != 0 && d > 0) {
                var p_isExists = false;
                $(".rawidclass").each(function () {
                    var val_p = $(this).val();
                    if (val_p == a && producttype == 1)
                        p_isExists = true;
                }).val();
                if (p_isExists) {
                    alert('already exists this product.');
                }
                else {
                    var html = "<tr id='row_" + count + "'>";
                    html += "<td><input type='hidden' name='sout[" + count + "][ptype]' value='" + producttype + "' >" + producttype_text + "</td>";
                    html += "<td><input type='hidden' class='rawidclass' name='sout[" + count + "][pid]' value='" + a + "' ><input type='hidden' name='sout[" + count + "][pname]' value='" + pname + "' >" + pname + "</td>";
                    html += "<td><input type='hidden' name='sout[" + count + "][uoid]' value='" + uo_id + "' >" + b + "</td>";
                    html += "<td><input type='hidden' name='sout[" + count + "][rate]' value='" + c + "' >" + c + "</td>";
                    html += "<td><input type='hidden' name='sout[" + count + "][qty]' value='" + d + "' >" + d + "</td>";
                    html += "<td><input class='row_amt' type='hidden' name='sout[" + count + "][amt]' value='" + e + "'>" + e + "</td>";
                    html += "<td><button class='btn btn-danger remove' onclick='remove_row(" + count + ")' type='button'><i class='glyphicon glyphicon-remove'></i></button></td></tr>";
                    $("#table tbody").append(html);
                    $(".add_list").val('');
                    $('#productname').prop('selectedIndex', 0);
                    $("#productname").trigger("change");
                    $('#producttype').prop('selectedIndex', 0);
                    $("#producttype").selectpicker("refresh");
                    var cnt = count + 1;
                    $("#tot_count").val(cnt);
                    total_amount();
                }
            }
            if (producttype == 2 && a != 0 && d > 0) {
                var r_isExists = false;
                $(".rawidclass").each(function () {
                    var val_r = $(this).val();
                    if (val_r == a && producttype == 2)
                        r_isExists = true;
                }).val();
                if (r_isExists) {
                    alert('already exists this raw material.');
                }
                else {
                    var html = "<tr id='row_" + count + "'>";
                    html += "<td><input type='hidden' name='sout[" + count + "][ptype]' value='" + producttype + "' >" + producttype_text + "</td>";
                    html += "<td><input type='hidden' class='rawidclass' name='sout[" + count + "][pid]' value='" + a + "' ><input type='hidden' name='sout[" + count + "][pname]' value='" + pname + "' >" + pname + "</td>";
                    html += "<td><input type='hidden' name='sout[" + count + "][uoid]' value='" + uo_id + "' >" + b + "</td>";
                    html += "<td><input type='hidden' name='sout[" + count + "][rate]' value='" + c + "' >" + c + "</td>";
                    html += "<td><input type='hidden' name='sout[" + count + "][qty]' value='" + d + "' >" + d + "</td>";
                    html += "<td><input class='row_amt' type='hidden' name='sout[" + count + "][amt]' value='" + e + "'>" + e + "</td>";
                    html += "<td><button class='btn btn-danger remove' onclick='remove_row(" + count + ")' type='button'><i class='glyphicon glyphicon-remove'></i></button></td></tr>";
                    $("#table tbody").append(html);
                    $(".add_list").val('');
                    $('#productname').prop('selectedIndex', 0);
                    $("#productname").trigger("change");
                    $('#producttype').prop('selectedIndex', 0);
                    $("#producttype").selectpicker("refresh");
                    var cnt = count + 1;
                    $("#tot_count").val(cnt);
                    total_amount();
                }
            }
        }
    }

    function remove_row(id) {
        $('#row_' + id).remove();
        total_amount();
    }

    function total_amount() {
        var total_amt = 0;
        $(".row_amt").each(function () {
            total_amt += parseFloat($(this).val());
        });
        $("#itemamount").val(total_amt);
        numberToWords(total_amt);
    }

    function numberToWords(num) {
        var a = ['', 'one ', 'two ', 'three ', 'four ', 'five ', 'six ', 'seven ', 'eight ', 'nine ', 'ten ', 'eleven ', 'twelve ', 'thirteen ', 'fourteen ', 'fifteen ', 'sixteen ', 'seventeen ', 'eighteen ', 'nineteen '];
        var b = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];

        if ((num = num.toString()).length > 9) return 'overflow';
        n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
        if (!n) return; var str = '';
        str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
        str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
        str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
        str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
        str += (n[5] != 0) ? ((str != '') ? 'and' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'Only' : '';

        $("#wamount").val('Ringgit' + str);
    } 
</script>