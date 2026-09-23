<?php global $lang; ?>
<style>
    /*.thead{
        color: #fff;
        background-color: red;
    }
    a:hover { text-decoration: none; }
    body { background:#fff; }
    .content { max-width: 100%; padding: 0 .2rem; }*/
.bootstrap-select.btn-group .dropdown-menu.inner {
    padding-bottom:50px;
}
</style>
<section class="content">
    <div class="container-fluid">
        <!--<div class="block-header">
            <h2> ACCOUNTS</h2>
        </div>-->
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-4 col-sm-12 col-xs-12"><h2><?php echo $lang->chart; ?> <?php echo $lang->of; ?> <?php echo $lang->account; ?></h2></div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                        <?php
                        if(count($check_financial_year) > 0)
                        {
                            $from_date = $check_financial_year[0]['from_year_month']."-01";
                            $from_date_re = date("d-m-Y", strtotime($from_date));
                            $to_date = $check_financial_year[0]['to_year_month']."-31";
                            $to_date_re = date("d-m-Y", strtotime($to_date));
                        ?>
                        <p style="font-weight: bold;font-size: 16px;text-transform: uppercase;">( <?php echo $lang->current; ?> <?php echo $lang->financial; ?> <?php echo $lang->year; ?> <?php echo $lang->from; ?> <?php echo $from_date_re; ?> <?php echo $lang->to; ?> <?php echo $to_date_re; ?> )</p>
                        <?php
                        }
                        ?>
                        </div>
                        <?php if($add_group['create_p'] == 1) { ?>						
						<div class="col-md-1 col-sm-5 col-xs-5" align="right"><!--<a href="<?php echo base_url(); ?>/account/add_group"><button type="button" class="btn bg-deep-purple waves-effect">Add Group</button></a>--></div>
                        <?php } if($add_ledger['create_p'] == 1) { ?>
						<div class="col-md-1 col-sm-5 col-xs-5" align="right"><a href="<?php echo base_url(); ?>/account/add_ledger"><button type="button" class="btn bg-deep-purple waves-effect"><?php echo $lang->add; ?> <?php echo $lang->ledger; ?></button></a></div>
						<?php } ?>
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
                        <form action="<?php echo base_url(); ?>/account" method="post">
                            <div class="container-fluid">
                                <div class="row clearfix">
                                    <div class="col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <select class="form-control search_box" data-live-search="true" name="ledger" id="ledger">
                                                    <?php foreach($ledger as $row){ ?>
                                                    <?php echo $row; ?>
                                                <?php  } // print_r($ledger); ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2" align="left">
                                        <button type="submit" class="btn btn-success btn-lg waves-effect"><?php echo $lang->submit; ?></button>
                                    </div>
                                </div>
                            </div>
                        </form>


                        <div class="table-responsive">
                        <table class="table table-striped" style="width:100%;">
                        <tr>
                            <th style="width: 60%;" class="thead"><?php echo $lang->account; ?> <?php echo $lang->name; ?></th>
                            <th class="thead"><?php echo $lang->type; ?></th>
                            <th class="thead">O/P <?php echo $lang->balance; ?></th>
                            <th class="thead">C/L <?php echo $lang->balance; ?></th>
							<?php if($add_group['edit'] == 1 ||  $add_group['delete_p'] == 1 || $add_ledger['edit'] == 1 ||  $add_ledger['delete_p'] == 1) { ?>
							<th class="thead"><?php echo $lang->action; ?></th>
							<?php } ?>
                        </tr>
                        <?php foreach($list as $row) { ?>
                            <?php print_r($row); ?>
                        <?php } ?>
                        </table>
                        </div>
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
                            <h4 class="mt-2 heading"><?php echo $lang->delete; ?> <?php echo $lang->entries; ?></h4>
                            <table>
        
                            <tr><span id="spndeddelid"><b></b></span></tr>
                          </table>
                            
                            <a href="#" id="del" class="btn btn-danger my-3" data-dismiss="modal"><?php echo $lang->yes; ?></a> &nbsp;
                            <button type="button" class="btn btn-info my-3" data-dismiss="modal"><?php echo $lang->no; ?></button>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div>
        </div>
        <div id="alert-okay" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body p-4">
                        <div class="text-center">
                            <table>
        
                            <tr><span id="spndeddelids"><b></b></span></tr>
                          </table>
                            <button type="button" class="btn btn-info my-3" data-dismiss="modal"><?php echo $lang->okey; ?></button>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div>
        </div>
        <div id=delete-form >
            
        </div>
</section>
<script>
    function confirm_modal(id, type){
        if(type == 1) var url = "<?php echo base_url(); ?>/account/check_group/"+id;
        else var url = "<?php echo base_url(); ?>/account/check_ledger/"+id;
        $.ajax({
            type: "POST",
            url: url,
            data: {id: id},
            success:function(data){
                console.log(data)
                if(data == 'true'){
                    var name = $("#name_"+id+'_'+type).text();
                    if(type == 1){ var head_title = 'Delete Group'; var title ="Group"; }
                    else { var head_title = 'Delete Ledger'; var title ="Ledger"; }
                    $(".heading").text(head_title);
                    $('#alert-modal').modal('show', {backdrop: 'static'});
                    document.getElementById('del').setAttribute('onclick' , 'dedDel('+id+','+type+')');
                    $("#spndeddelid").text("Are you sure to Delete "+name+" "+title+"?" );
                }else{
                    $('#alert-okay').modal('show', {backdrop: 'static'});
                    $("#spndeddelids").text("We used for this, So cant Delete" );
                }
            }
        });
        
    }
    function dedDel(id, type){
        if(type == 1) var url = "<?php echo base_url(); ?>/account/delete_group/"+id;
        else var url = "<?php echo base_url(); ?>/account/delete_ledger/"+id;
        $( "#delete-form" ).append( "<form action='"+url+"'><button type='submit' id='delete_"+id+"_"+type+"' >submit</button></form>");
        $( "#delete_"+id+"_"+type).trigger( "click");
    }
</script>
