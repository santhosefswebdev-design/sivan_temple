<?php
if ($view == true) {
    $readonly = 'readonly';
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
            color: transparent;
        }

    <?php } ?>
</style>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Add Courier Charges</h2>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">

                    <div class="header">
                        <div class="row">
                            <div class="col-md-8"><!-- Empty --></div>
                            <div class="col-md-4" align="right">
                                <a href="<?php echo base_url(); ?>/master/courier">
                                    <button type="button" class="btn bg-deep-purple waves-effect">List</button>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="body">
                        <form action="<?= base_url('master/save_courier_charge'); ?>" method="post">
                            <input type="hidden" name="id"
                                value="<?= isset($courier_charge['id']) ? $courier_charge['id'] : ''; ?>">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="state_name">State Name</label>
                                        <select name="state_name" class="form-control">
                                            <?php foreach ($states as $state): ?>
                                                <option value="<?= $state['name']; ?>"
                                                    <?= isset($courier_charge['state_name']) && $courier_charge['state_name'] == $state['name'] ? 'selected' : ''; ?>>
                                                    <?= $state['name']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="state_code">State Code</label>
                                        <select name="state_code" class="form-control">
                                            <?php foreach ($states as $state): ?>
                                                <option value="<?= $state['code']; ?>"
                                                    <?= isset($courier_charge['state_code']) && $courier_charge['state_code'] == $state['code'] ? 'selected' : ''; ?>>
                                                    <?= $state['code']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                        <label for="amount">Amount</label>
                                        <input type="text" name="amount" class="form-control"
                                            value="<?= isset($courier_charge['amount']) ? $courier_charge['amount'] : ''; ?>">
                                    </div>  
                                    </div>  
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ledger_id">Ledger</label>
                                        <select name="ledger_id" class="form-control">
                                            <option value="">Select Ledger</option>
                                        <?php
                                            if (!empty($ledgers)) {
                                                foreach ($ledgers as $ledger) {
                                                    ?>
                                                    <option value="<?php echo $ledger["id"]; ?>" <?php if (!empty($data['ledger_id'])) {
                                                           if ($data['ledger_id'] == $ledger["id"]) {
                                                               echo "selected";
                                                           }
                                                       } ?>>
                                                        <?php echo $ledger['left_code'] . '/' . $ledger['right_code'] . " - " . $ledger["name"]; ?> </option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                           
                            </div>

                         
                        </form>
                            <?php if ($view != true) { ?>
                                <div  align="center" style="background-color: white;padding-bottom: 1%;">
                                    <button type="submit" onclick="validations()" class="btn btn-success btn-lg waves-effect">SAVE</button>
                                    <button type="button" id="clear" class="btn btn-primary btn-lg waves-effect">CLEAR</button>
                                </div>
                            <?php } ?>
                    </div>

                    <div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-body p-4">
                                    <div class="text-center">
                                        <i class="dripicons-information h1 text-info"></i>
                                        <table>
                                            <tr>
                                                <span id="spndeddelid"><b></b></span>&nbsp;&nbsp;&nbsp;
                                                <button type="button" class="btn btn-info my-3"
                                                    data-dismiss="modal">&times;</button>
                                            </tr>
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
        $('#state_name').prop('selectedIndex', 0);
        $('#state_code').prop('selectedIndex', 0);
        $('#ledger_id').prop('selectedIndex', 0);
    });

    function validations() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>/master/validation3",
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
        });
    }
</script>