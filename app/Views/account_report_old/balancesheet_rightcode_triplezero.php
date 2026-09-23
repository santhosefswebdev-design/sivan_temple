<?php global $lang; ?>
<style>
    /*body { background:#fff; }
    .content { max-width: 100%; padding: 0 .2rem; 

    .thead{
        color: #fff;
        background-color: red;
    }
    a:hover { text-decoration: none; }*/
</style>
<section class="content">
    <div class="container-fluid">
        <!-- <div class="block-header">
            <h2> ACCOUNTS</h2>
        </div>
        Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-2"><h2><?php echo $lang->balance_sheet; ?></h2></div>
                        <div class="col-md-10">
							<?php
                            if(count($check_financial_year) > 0)
                            {
                                $from_date = $check_financial_year[0]['from_year_month']."-01";
                                $from_date_re = date("d-m-Y", strtotime($from_date));
                                $to_date = $check_financial_year[0]['to_year_month']."-31";
                                $to_date_re = date("d-m-Y", strtotime($to_date));
                            ?>
                            <p style="font-weight: bold;font-size: 16px;text-transform: uppercase;">( <?php echo $lang->current; ?> <?php echo $lang->financial; ?> <?php echo $lang->year; ?> <?php echo $lang->from; ?> <?php echo $from_date_re; ?><?php echo $lang->to; ?>  <?php echo $to_date_re; ?> )</p>
                            <?php
                            }
                            ?>
						</div>
                        </div>
                    </div>
                    <div class="body">
                        <?php if($_SESSION['succ'] != '') { ?>
                            <div class="row" style="padding: 0 30%;" id="content_alert">
                                <div class="suc-alert">
                                    <span class="suc-closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                    <p><?php echo $_SESSION['succ']; ?></p> 
                                </div>
                            </div>
                        <?php } ?>
                         <?php if($_SESSION['fail'] != '') { ?>
                            <div class="row" style="padding: 0 30%;" id="content_alert">
                                <div class="alert">
                                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                    <p><?php echo $_SESSION['fail']; ?></p>
                                </div>
                            </div>
                        <?php } ?>
                        <form action="<?php echo base_url();?>/balance_sheet/balancesheet_rightcode_triplezero" method="post" style="margin-top:15px;">
                            <div class="container-fluid">
                                <div class="row clearfix">
                                <div class="col-sm-3 date">
                                    <div class="form-group">
                                        <div class="form-line focused" style="margin-top:-20px;">
                                            <label class="form-label" style="display: contents;"><?php echo $lang->date; ?></label>
                                            <input type="date" name="tdate" id="tdate" class="form-control" value="<?= $tdate; ?>">
                                            <!--<label class="form-label">To Date</label>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2" align="right">
                                    <button type="submit" class="btn btn-success btn-lg waves-effect"><?php echo $lang->submit; ?></button>
                                    <!-- <label id="print" class="btn btn-primary btn-lg waves-effect">Print</label> -->
                                </div>
                                                                </div>
                                </div>
                            </form>
                            <form style="display: none;" target="_blank" id="print_sheet" action="<?php echo base_url();?>/balance_sheet/print_balancesheet_rightcode_triplezero" method="post">
                                <input type="hidden" name="fdate" id="fdate" class="form-control" value="<?= $sdate; ?>">
                                <input type="hidden" name="tdate" id="tdate" class="form-control" value="<?= $tdate; ?>">
                            </form>
                            <form style="display: none;" target="_blank" id="excel_sheet" action="<?php echo base_url();?>/balance_sheet/excel_balancesheet_rightcode_triplezero" method="post">
                                <input type="hidden" name="fdate" id="fdate" class="form-control" value="<?= $sdate; ?>">
                                <input type="hidden" name="tdate" id="tdate" class="form-control" value="<?= $tdate; ?>">
                            </form>
                        <div class="table-responsive">
                        <table class="table table-striped" style="width:100%;">
                        <tr>
                            <th style="width: 60%;" class="thead"><?php echo $lang->account; ?> <?php echo $lang->name; ?></th>
                            <th style="text-align: right;" class="thead"><?php echo $lang->current; ?> <?php echo $lang->year; ?> </th>
                            <th style="text-align: right;" class="thead"><?php echo $lang->previous; ?> <?php echo $lang->year; ?> </th>
                        </tr>
                        <?php foreach($list as $row) { ?>
                            <?php print_r($row); ?>
                        <?php } ?>
                        </table>
                        </div>
                        <div class="row">
                            <div class="col-md-12" align="center">
                                <label id="print" class="btn btn-primary">Print</label>
                                <label id="excel" class="btn btn-success">Excel</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="modal-title" id="modal_ledger_title"></h4>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="font-size: 24px;">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
			<div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-12">
                        <div id="display_indivitual_ledgers"></div>
                    </div>
                </div>
			</div>
		</div><!-- /.modal-content -->
	</div>
</div>
<script>
    $("#print").click(function(){
        $("#print_sheet").submit();
    });
    $("#excel").click(function(){
        $("#excel_sheet").submit();
    });
</script>

<script>
	function open_group_ledger_triblezero_modal(led_id,fdate,tdate)
    {
        if(led_id != "")
        {
            $.ajax({
                url: '<?php echo base_url(); ?>/balance_sheet/open_group_ledger_triblezero',
                type: 'post',
                data: {led_id:led_id,fdate:fdate,tdate:tdate},
                success: function(response){
                    get_ledger_triblezero(led_id);
                    $('#alert-modal').modal('show', {backdrop: 'static'});
                    $("#display_indivitual_ledgers").html(response);
                }
            }); 
        }
    }
    function get_ledger_triblezero(ledg_id)
    {
        if(ledg_id != "")
        {
            $.ajax({
                url: '<?php echo base_url(); ?>/balance_sheet/get_ledger_triblezero',
                type: 'post',
                data: {ledg_id:ledg_id},
                success: function(response){
                    $("#modal_ledger_title").text(response);
                }
            }); 
        }
    }
</script>
