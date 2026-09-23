<style>
    /*body { background:#fff; }
    .content { max-width: 100%; padding: 0 .2rem; }*/
</style>
<?php 
if($view == true){
    $readonly = 'readonly';
    $disable = "disabled";
}
?>
<section class="content">
    <div class="container-fluid">
        <!-- <div class="block-header">
            <h2> ACCOUNT <small>Account Create / <a href="#" target="_blank">Add Ledger</a></small></h2>
        </div>
        Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                      <div class="row"><div class="col-md-8"><h2>Add Ledger</h2></div>
                      <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/account"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                    </div>
                    <div class="body">
                        
                        <form action="<?php echo base_url(); ?>/account/save_add_ledger" method="post">
                            <div class="container-fluid">
                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                            <input type="text" name="lname" class="form-control" <?php echo $readonly; ?> >
                                            <label class="form-label">Ledger Name</label>
                                            </div>
                                        </div>
                                    </div>
                                <div class="col-sm-4" style="display:none;">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" name="lcode" class="form-control" <?php echo $readonly; ?> >
                                            <label class="form-label">Ledger code (optional)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group form-float" >
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-line">
                                                    <input type="text" name="left_code" class="form-control" <?php echo $readonly; ?> >
                                                    <label class="form-label">Left Code</label> 
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <p style="font-size: 22px; padding-top: 7px;">/</p>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-line">
                                                    <input type="text" name="right_code" class="form-control" <?php echo $readonly; ?> >
                                                    <label class="form-label">Right Code </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php /* <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control show-tick" name="lgroup">
                                                <option value="">--Group Under--</option>
                                                <?php foreach($group as $row) { ?>
                                                    <option value="<?= $row['id'];?>"><?= $row['name'];?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div> */ ?>
                                <div class="col-sm-5">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <select class="form-control" name="op_dc">
                                                <option value="D">Debit</option>
                                                <option value="C">Credit</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" name="op_bal" class="form-control">
                                            <label class="form-label">Opening Balance</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="pure-material-checkbox">
                                            <input type="checkbox" name="type" value="1">
                                            <span>Bank or cash account</span>
                                        </label>
                                        <label>Note : Select if the ledger account is a bank or a cash account</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="pure-material-checkbox">
                                            <input type="checkbox" name="reconciliation" value="1">
                                            <span>Reconciliation</span>
                                        </label>
                                        <label>Note : If selected the ledger account can be reconciled from Reports > Reconciliation.</label>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <h4><b>Balance sheet</b></h4>
                                    <input name="lgroup" type="radio" id="radio_30" class="with-gap radio-col-red" value="57" />
                                    <label for="radio_30">Capital/Retained Earnings</label><br>
                                    <input name="lgroup" type="radio" id="radio_31" class="with-gap radio-col-red" value="3" />
                                    <label for="radio_31">Current Assets</label><br>
                                    <input name="lgroup" type="radio" id="radio_32" class="with-gap radio-col-red" value="10" />
                                    <label for="radio_32">Fixed Assets</label><br>
                                    <input name="lgroup" type="radio" id="radio_33" class="with-gap radio-col-red" value="14" />
                                    <label for="radio_33">Current Liabilities</label><br>
                                    <input name="lgroup" type="radio" id="radio_34" class="with-gap radio-col-red" value="60" />
                                    <label for="radio_34">Other Liabilities</label><br>
                                    <input name="lgroup" type="radio" id="radio_35" class="with-gap radio-col-red" value="61" />
                                    <label for="radio_35">Long Term Liabilities</label><br>
                                    <input name="lgroup" type="radio" id="radio_36" class="with-gap radio-col-red" value="59" />
                                    <label for="radio_36">Other Assets</label>
                                </div>
                                <div class="col-md-3">
                                    <h4>Profit & Loss</b></h4>
                                    <input name="lgroup" type="radio" id="radio_37" class="with-gap radio-col-red" value="29" />
                                    <label for="radio_37">Sales</label><br>
                                    <input name="lgroup" type="radio" id="radio_38" class="with-gap radio-col-red" value="62" />
                                    <label for="radio_38">Sales Adjustments</label><br>
                                    <input name="lgroup" type="radio" id="radio_39" class="with-gap radio-col-red" value="64" />
                                    <label for="radio_39">Cost of Goods Sold</label><br>
                                    <input name="lgroup" type="radio" id="radio_40" class="with-gap radio-col-red" value="63" />
                                    <label for="radio_40">Other Incomes</label><br>
                                    <input name="lgroup" type="radio" id="radio_41" class="with-gap radio-col-red" value="30" />
                                    <label for="radio_41">Expenses</label><br>
                                    <input name="lgroup" type="radio" id="radio_42" class="with-gap radio-col-red" value="65" />
                                    <label for="radio_42">Taxation</label><br>
                                    <?php /* <input name="lgroup" type="radio" id="radio_43" class="with-gap radio-col-red" value="14" />
                                    <label for="radio_43">Extra-Ordinary Income/Exp</label><br>
                                    <input name="lgroup" type="radio" id="radio_44" class="with-gap radio-col-red" value="15" />
                                    <label for="radio_44">Appropriation Account</label> */ ?>
                                </div>
                                
                                </div><?php if($view != true) { ?>
                                <div class="col-sm-12" align="center">
                                    <button type="submit" class="btn btn-success btn-lg waves-effect">SAVE</button>
                                    <button type="button" id="clear" class="btn btn-primary btn-lg waves-effect">CLEAR</button>
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
</section>
<script>
	$("#clear").click(function(){
	   $("input").val("");
	});
</script>