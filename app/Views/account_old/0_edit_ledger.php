<?php 
if($view == true){
    $readonly = 'readonly';
    $disable = "disabled";
}
?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2> ACCOUNT <small>Account Create / <a href="#" target="_blank">Edit Ledger</a></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                      <div class="row"><div class="col-md-8"><h2>Edit Ledger</h2></div>
                      <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/account"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                    </div>
                    <div class="body">
                        
                        <form action="<?php echo base_url(); ?>/account/save_add_ledger" method="post">
                        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                            <div class="container-fluid">
                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                            <input type="text" name="lname" class="form-control" value="<?php echo $data['name']; ?>"> 
                                            <label class="form-label">Ledger Name</label>
                                            </div>
                                        </div>
                                    </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" name="lcode" class="form-control" value="<?php echo $data['code']; ?>"> 
                                            <label class="form-label">Ledger code (optional)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control show-tick" name="lgroup">
                                                <option value="">--Group Under--</option>
                                                <?php foreach($group as $row) { ?>
                                                    <option <?php if($data['group_id'] == $row['id'] ) echo 'selected'; ?> value="<?= $row['id'];?>"><?= $row['name'];?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <!--<div class="col-sm-2">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <select class="form-control" name="op_dc">
                                                <option <?php if($data['op_balance_dc'] == 'D') echo 'selected'; ?> value="D">Debit</option>
                                                <option <?php if($data['op_balance_dc'] == 'C') echo 'selected'; ?> value="C">Credit</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" name="op_bal" class="form-control" value="<?php echo $data['op_balance']; ?>">
                                            <label class="form-label">Opening Balance</label>
                                        </div>
                                    </div>
                                </div>-->
                                <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="pure-material-checkbox">
                                            <input type="checkbox" name="type" value="1" <?php if($data['type'] == 1) echo 'checked'; ?> >
                                            <span>Bank or cash account</span>
                                        </label>
                                        <label>Note : Select if the ledger account is a bank or a cash account</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="pure-material-checkbox">
                                            <input type="checkbox" name="reconciliation" value="1" <?php if($data['reconciliation'] == 1) echo 'checked'; ?> >
                                            <span>Reconciliation</span>
                                        </label>
                                        <label>Note : If selected the ledger account can be reconciled from Reports > Reconciliation.</label>
                                    </div>
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