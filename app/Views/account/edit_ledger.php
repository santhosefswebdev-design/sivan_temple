<?php $db = db_connect(); ?>
<style>
   /* body { background:#fff; }
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
            <h2> ACCOUNT <small>Account Create / <a href="#" target="_blank">Edit Ledger</a></small></h2>
        </div>
        Basic Examples -->
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
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                            <input type="text" name="lname" class="form-control" value="<?php echo $data['name']; ?>" required> 
                                            <label class="form-label">Ledger Name</label>
                                            </div>
                                        </div>
                                    </div>
                                <div class="col-sm-4" style="display:none;">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" name="lcode" class="form-control" value="<?php echo $data['code']; ?>" > 
                                            <label class="form-label">Ledger code (optional)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group form-float" >
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-line">
                                                    <input type="text" name="left_code" id="left_code" class="form-control" value="<?php echo $data['left_code']; ?>" readonly>
                                                    <label class="form-label">Left Code</label> 
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <p style="font-size: 22px; padding-top: 7px;">/</p>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-line">
                                                    <input type="text" name="right_code" minlength="4" maxlength="4" class="form-control" value="<?php echo $data['right_code']; ?>" required>
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
                                                    <option <?php if($data['group_id'] == $row['id'] ) echo 'selected'; ?> value="<?= $row['id'];?>"><?= $row['name'];?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div> */ ?>
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="pure-material-checkbox">
                                            <input type="checkbox" name="profit_accuulation" value="1" <?php if($data['pa'] == 1) echo 'checked'; ?>>
                                            <span>Profit Accuulation</span>
                                        </label>
                                        <!--label>Note : Select if the ledger account is a bank or a cash account</label-->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="pure-material-checkbox">
                                            <input type="checkbox" name="aging" value="1" <?php if($data['aging'] == 1) echo 'checked'; ?>>
                                            <span>Aging</span>
                                        </label><br>
                                        <label>Note : If selected the ledger account can be aging from Reports > Aging.</label>
                                    </div>
                                </div>
                                <?php
                                $inarray_list = array(57,10,3,59,14,61,60,29,64,26,30,65);
                                if(in_array($data['group_id'], $inarray_list)){
                                    //echo trim($data['group_id']);
                                    $groupre_id = trim($data['group_id']);
                                    $sub_groupre_id = 0;
                                }
                                else{
                                    $subgroups = $db->table('groups')->where("id", $data['group_id'])->get()->getRowArray();
                                    $groupre_id = $subgroups['parent_id'];
                                    $sub_groupre_id = trim($data['group_id']);
                                }
                                ?>
								<div class="col-md-3">
                                    <h4><b>Balance sheet</b></h4>
                                    <input name="lgroup" type="radio" id="radio_30" class="with-gap radio-col-red" value="57" <?php if ($groupre_id == '57') {echo 'checked';} ?> />
                                    <label for="radio_30">Equity/Retained Earnings</label><br>
									<input name="lgroup" type="radio" id="radio_32" class="with-gap radio-col-red" value="10" <?php if ($groupre_id == '10') {echo 'checked';} ?> />
                                    <label for="radio_32">Non Current Assets</label><br>
                                    <input name="lgroup" type="radio" id="radio_31" class="with-gap radio-col-red" value="3" <?php if ($groupre_id == '3') {echo 'checked';} ?> />
                                    <label for="radio_31">Current Assets</label><br>
									<input name="lgroup" type="radio" id="radio_36" class="with-gap radio-col-red" value="59" <?php if ($groupre_id == '59') {echo 'checked';} ?> />
                                    <label for="radio_36">Other Assets</label><br>
                                    <input name="lgroup" type="radio" id="radio_33" class="with-gap radio-col-red" value="14" <?php if ($groupre_id == '14') {echo 'checked';} ?> />
                                    <label for="radio_33">Current Liabilities</label><br>
                                    <input name="lgroup" type="radio" id="radio_35" class="with-gap radio-col-red" value="61" <?php if ($groupre_id == '61') {echo 'checked';} ?> />
                                    <label for="radio_35">Long Term Liabilities</label><br>
                                    <input name="lgroup" type="radio" id="radio_34" class="with-gap radio-col-red" value="60" <?php if ($groupre_id == '60') {echo 'checked';} ?> />
                                    <label for="radio_34">Other Liabilities</label>
                                </div>
                                <div class="col-md-3">
                                    <h4>Profit & Loss</b></h4>
                                    <input name="lgroup" type="radio" id="radio_37" class="with-gap radio-col-red" value="29" <?php if ($groupre_id == '29') {echo 'checked';} ?> />
                                    <label for="radio_37">Sales</label><br>
                                    <?php /* <input name="lgroup" type="radio" id="radio_38" class="with-gap radio-col-red" value="62" <?php if ($groupre_id == '62') {echo 'checked';} ?> />
                                    <label for="radio_38">Sales Adjustments</label><br> */ ?>
                                    <input name="lgroup" type="radio" id="radio_39" class="with-gap radio-col-red" value="64" <?php if ($groupre_id == '64') {echo 'checked';} ?> />
                                    <label for="radio_39">Cost of Sale</label><br>
                                    <input name="lgroup" type="radio" id="radio_40" class="with-gap radio-col-red" value="26" <?php if ($groupre_id == '26') {echo 'checked';} ?> />
                                    <label for="radio_40">Incomes</label><br>
                                    <?php /* <input name="lgroup" type="radio" id="radio_43" class="with-gap radio-col-red" value="63" <?php if ($groupre_id == '63') {echo 'checked';} ?> />
                                    <label for="radio_43">Other Incomes</label><br> */ ?>
                                    <input name="lgroup" type="radio" id="radio_41" class="with-gap radio-col-red" value="30" <?php if ($groupre_id == '30') {echo 'checked';} ?> />
                                    <label for="radio_41">Expenses</label><br>
                                    <?php /* <input name="lgroup" type="radio" id="radio_44" class="with-gap radio-col-red" value="67" <?php if ($groupre_id == '67') {echo 'checked';} ?> />
                                    <label for="radio_44">Other Expenses</label><br> */ ?>
                                    <input name="lgroup" type="radio" id="radio_42" class="with-gap radio-col-red" value="65" <?php if ($groupre_id == '65') {echo 'checked';} ?> />
                                    <label for="radio_42">Taxation</label><br>
                                    <?php /* <input name="lgroup" type="radio" id="radio_43" class="with-gap radio-col-red" value="14" />
                                    <label for="radio_43">Extra-Ordinary Income/Exp</label><br>
                                    <input name="lgroup" type="radio" id="radio_44" class="with-gap radio-col-red" value="15" />
                                    <label for="radio_44">Appropriation Account</label> */ ?>
                                </div>
                            </div>
                            <div class="row clearfix">
								 <div class="col-sm-5">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <select class="form-control" name="ledger_subgroup" id="ledger_subgroup">
                                                <option value="">First You choose Balancesheet or P&L</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <button type="button"  style="display:none;" id="add_btn" class="btn bg-light-blue waves-effect" data-toggle="modal" data-target="#addgroup">Add</button>
                                </div>
                            </div>    
                                <?php if($view != true) { ?>
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
<div class="modal fade" id="addgroup" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="group_form">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Add Group</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="g_id" name="g_id" value="<?php echo $groupre_id; ?>">
                <div class="row"><div class="col-md-8">
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="text" id="group" name="group" class="form-control">
                        <label class="form-label">Group Name</label>
                    </div>
                </div>
                </div>
                <div class="col-md-4">
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="text" id="code" name="code" class="form-control">
                        <label class="form-label">Code</label>
                    </div>
                </div>
                </div></div>
            </div>
            <div class="modal-footer">
                <label id="submit" class="btn btn-link waves-effect">Submit</label>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
            </form>
        </div>
    </div>
</div> 
</section>
<script>
$(document).ready(function(){
    $("input[name='lgroup']").change(function(){
        var lgroup = $("input[name='lgroup']:checked").val();
        var lggroup = $("#ledger_subgroup").val();
        $.ajax({
            type:'POST',
            data:{ledger_group_id:lgroup,ledger_subgroup_id:lggroup},
            url:'<?php echo base_url(); ?>/account/get_group_code',
            success:function(response){
                $('#left_code').val(response);
            }
        }); 
    });
    $('#ledger_subgroup').change(function(){
        var lggroup = $("#ledger_subgroup").val();
        var lgroup = $("input[name='lgroup']:checked").val();
        $.ajax({
            type:'POST',
            data:{ledger_subgroup_id:lggroup,ledger_group_id:lgroup},
            url:'<?php echo base_url(); ?>/account/get_group_code',
            success:function(response){
                $('#left_code').val(response);
            }
        }); 
    });
});
</script>
<script>
$(document).ready(function(){
	$("#clear").click(function(){
	   $("input").val("");
	});
    $('input[name=lgroup]').on('change', function(){
		var id = this.value;
		$('#g_id').val(id);
		//$('#add_btn').show();
		$.ajax({
			url: '/account/get_sub_group/' + id,
			dataType: 'json',
			success: function(result){
				//console.log(result);
				var html = '';
				if(result.length > 0){
					html += '<option value="">---Select Group---</option>';
					for(var i=0; i<result.length; i++){
						html += '<option value="' + result[i].id + '">(' + result[i].code + ') ' + result[i].name + '</option>';
					}
					$('#ledger_subgroup').html(html);
					$("#ledger_subgroup").selectpicker("refresh");
				}else{
					//html = '<option value="">---Select Group---</option>';
					$('#ledger_subgroup').html(html);
					$("#ledger_subgroup").selectpicker("refresh");
				}
			},
			error: function(err){
				console.log('err');
				console.log(err);
			}
		});
	});
});
$(document).ready(function(){
    fetch_group();
});
function fetch_group()
{
    var id= $("#g_id").val();
    if(id != ""){
        $('#add_btn').show();
        $.ajax({
            //type:'GET',
            dataType: 'json',
            url:'<?php echo base_url(); ?>/account/get_sub_group/'+id,
            success:function(result){
                $('#ledger_subgroup').empty();
                var html = '';
                if(result.length > 0){
					html += '<option value="">---Select Group---</option>';
					for(var i=0; i<result.length; i++){
                        if(<?php echo $sub_groupre_id; ?> == result[i].id){
                            html += '<option value="' + result[i].id + '" selected>(' + result[i].code + ') ' + result[i].name + '</option>';
                        }
                        else{
                            html += '<option value="' + result[i].id + '">(' + result[i].code + ') ' + result[i].name + '</option>';
                        }
					}
					$('#ledger_subgroup').html(html);
					$("#ledger_subgroup").selectpicker("refresh");
				}else{
					$('#ledger_subgroup').html(html);
					$("#ledger_subgroup").selectpicker("refresh");
				}
            }
        }); 
    }
    else{
        $('#add_btn').hide();
    }
}
$("#submit").click(function(){
    var g_id       = $("#g_id").val();
    var group     = $("#group").val();
    var code     = $("#code").val();
    $.ajax({
        url: "<?php echo base_url();?>/account/save_group",
        type: "post",
        dataType: "json",
        data: $("form#group_form").serialize(),
        success:function(response){
            //alert(response.gid);
            if (response.status !='') {
                $('#addgroup').modal('hide');
                $('#ledger_subgroup').empty();
                var sub_groups = response.sub_groups;
                //console.log(sub_groups);
                var html = '';
                if(sub_groups.length > 0){
                    html += '<option value="">---Select Group---</option>';
                    for(var i=0; i<sub_groups.length; i++){
                        html += '<option value="' + sub_groups[i].id + '">(' + sub_groups[i].code + ') ' + sub_groups[i].name + '</option>';
                    }
                    $('#ledger_subgroup').html(html);
                    $("#ledger_subgroup").selectpicker("refresh");
                }else{
                    //html = '<option value="">---Select Group---</option>';
                    $('#ledger_subgroup').html(html);
                    $("#ledger_subgroup").selectpicker("refresh");
                }
            }else{					
                alert('Please enter required fields.');
            }
        }
    });
});
</script>