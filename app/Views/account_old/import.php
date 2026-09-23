<style>
.btn.dropdown-toggle.btn-default{
    display: none;
}
</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2> IMPORT <small>Account/ <a href="#" target="_blank">Import</a></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                      <div class="row"><div class="col-md-8"><h2>Import</h2></div>
                      <div class="col-md-4" align="right"></div></div>
                    </div>
                    <div class="body">
                        
                        <form action="<?php echo base_url(); ?>/import/save" method="post" enctype="multipart/form-data">
                            <div class="container-fluid">
                                <div class="row clearfix">
                                    <div class="col-md-2">
                                        <label class="form-label">Import Excel</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="form-group">
                                            <div class="form-line">
                                            <input name="entry_file" accept=".xls, .xlsx"  class="form-control" id="name"  name="" type="file" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12" align="center">
                                    <button type="submit" class="btn btn-success btn-lg waves-effect">SAVE</button>
                                    <button type="button" id="clear" class="btn btn-primary btn-lg waves-effect">CLEAR</button>
                                </div>
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