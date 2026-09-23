<style>
.tem1 { margin-top:20px; }
.tem1_cem1 li { display:inline; list-style:none; margin-right: 5px; }
.tem1 { width:15px; height:15px; background:#32c9dc; display: inline-block; }
.cem1 { width:15px; height:15px; background:#ee4b82; display: inline-block; }
.temp1 { width:15px; height:15px; background:#00bcd5; display: inline-block; }
.temp2 { width:15px; height:15px; background:#8cc34b; display: inline-block; }
.temp3 { width:15px; height:15px; background:#fec107; display: inline-block; }
.temp4 { width:15px; height:15px; background:#ea1e63; display: inline-block; }
.temp5 { width:15px; height:15px; background:#009788; display: inline-block; }
.temp6 { width:15px; height:15px; background:#0012d4; display: inline-block; }
</style>

<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Archanai</h2>
                    </div>
                    <div class="body">
                        <canvas id="bar_chart" height="150"></canvas>
                        <!--ul class="tem1_cem1"><li><span class="tem1"></span></li> <li>Temple</li> <li><span class="cem1"></span></li> <li>Cemetery </li></ul-->
                </div>
                </div>
            </div>
            <!-- Line Chart -->
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Ubayam</h2>
                    </div>
                    <div class="body">
                        <canvas id="line_chart" height="150"></canvas>
                        <!--ul class="tem1_cem1"><li><span class="tem1"></span></li> <li>Temple</li> <li><span class="cem1"></span></li> <li>Cemetery </li></ul-->
                    </div>
                </div>
            </div>
            <!-- #END# Line Chart -->
        </div>

        
    </div>
</section>

<footer>
    <div class="legal">
        <div class="copyright">
            &copy; <?php echo date('Y'); ?> <a href="<?php echo base_url(); ?>/dashboard"><?php echo $_SESSION['site_title']; ?></a>. All Rights Reserved.
        </div>
    </div>
</footer>

    <!-- Jquery Core Js -->
    <script src="<?php echo base_url(); ?>/assets/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?php echo base_url(); ?>/assets/plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="<?php echo base_url(); ?>/assets/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo base_url(); ?>/assets/plugins/node-waves/waves.js"></script>

    <!-- Chart Plugins Js -->
    <script src="<?php echo base_url(); ?>/assets/plugins/chartjs/Chart.bundle.js"></script>

    <!-- Custom Js -->
    <script src="<?php echo base_url(); ?>/assets/js/admin.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/pages/charts/chartjs.js"></script>

    <!-- Demo Js -->
    <script src="<?php echo base_url(); ?>/assets/js/demo.js"></script>
</body>

</html>
