<?php global $lang;?>
<style>
.btn-default, .btn-default:hover, .btn-default:active, .btn-default:focus {
    background: transparent !important;
}
.form-group { margin-bottom:0 !important; }
.col-sm-4 { margin-bottom:10px !important; }
.table tr th, .table tr td { text-align:center; }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2> <?php echo $lang->visitor; ?> <?php echo $lang->reg; ?> <?php echo $lang->report; ?> <small><?php echo $lang->member; ?> / <b><?php echo $lang->visitor; ?> <?php echo $lang->reg; ?> <?php echo $lang->report; ?></b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="body">
                    <p style="text-align:right;"><a class="btn btn-primary btn-lg waves-effect" target="_blank" href="<?php echo base_url(); ?>/report/visitors_print"><?php echo $lang->print; ?></a> </p>   
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">        
                            <thead><tr><th><?php echo $lang->sno; ?></th>
                            <th><?php echo $lang->date; ?></th>
                            <th><?php echo $lang->name; ?></th>
                            <th><?php echo $lang->citizen; ?></th>
                            <th><?php echo $lang->type; ?></th>
                            <th><?php echo $lang->pax; ?></th>
                            <th><?php echo $lang->comments; ?></th></tr>
                            </thead>
                            <tbody>
                            <?php $i = 1;
                            foreach($list as $row)
                            {
                            ?>
                                <tr><td><?php echo $i; ?></td>
                                <td><?php echo date('d/m/Y', strtotime($row['created_at'])); ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['citizen']; ?></td>
                                <td><?php echo $row['type']; ?></td>
                                <td><?php echo $row['pax']; ?></td>
                                <td><?php echo $row['comments']; ?></td></tr>
                            <?php
                            $i++;
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
           
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




