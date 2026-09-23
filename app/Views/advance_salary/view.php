<style>
#wamount {
  text-transform: capitalize;
}
#pay_table { width:100%; border-collapse:collapse; }
#pay_table th { padding: 10px; background: #f44336; color: #fff; }
#pay_table td { padding:10px; }

.pay_desc {border :none}
.pay_earn {border :none; text-align: right;width:100%}
.pay_ded {border :none;text-align: right;width:100%}

</style>

<section class="content">
    <div class="container-fluid">
        <div class="block-header"> 
            <h2>ADVANCE SALARY<small>Finance / <b>View Advance Salary</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/payslip/advance_salary"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                    </div>
                    <div class="body">
                        <form  id="form_submit">
                            <div class="container-fluid">
                                <div class="row clearfix">
                                    <div class="col-sm-3">
                                        <div class="form-group form-float">
                                            <div id="bs_datepicker_container" >
                                                <label class="form-control">Date : <?php echo $data['date']; ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="form-control">Staff : <?php echo $data['name']; ?></label>
                                        </div>
                                    </div>
                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <label class="form-control">Ref No : <?php echo $data['ref_no']; ?></label>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <label class="form-control">Amount : <?php echo $data['amount']; ?></label>
                                    </div>
                                </div>
                                
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <label class="form-control">Narration : <?php echo $data['narration']; ?></label>
                                    </div>
                                </div>
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
            <div class="modal-content" style="width: 127%;">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-information h1 text-info"></i>
                        <table>
                            <tr><span id="spndeddelid"><b></b></span>&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-info my-3" data-dismiss="modal"> &times;</button></tr>
                        </table>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div>
    </div>
</section>
<link href="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>