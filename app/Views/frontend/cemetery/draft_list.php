<?php        
$db = db_connect();
?>
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/typicons/typicons.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/mdi/css/materialdesignicons.min.css"/>
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/css/vertical-layout-light/style.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/style.css">
  <link rel="shortcut icon" href="<?php echo base_url(); ?>/assets/archanai/images/favicon.png" />
<style>
body { height:100vh; width:100%; }
.prod::-webkit-scrollbar {
  width: 3px;
}
.prod::-webkit-scrollbar-track {
  background: #f1f1f1; 
}
.prod::-webkit-scrollbar-thumb {
  background: #d4aa00; 
}
.prod::-webkit-scrollbar-thumb:hover {
  background: #e91e63; 
}
a { text-decoration:none !important; }
.table tr th {
    border: 1px solid #f7e086;
    /* padding: 5px; */
    font-size: 14px;
    background: #f7ebbb;
    color: #333232;
}
.pack, .pay {
    background: #fff;
    margin-bottom: 15px;
}
.form-label {
    text-transform: uppercase;
    font-size: 13px;
    letter-spacing: 1px;
    color: rgb(62 60 60);
    text-align: left;
    width: 100%;
}
.input { width:100%; text-align:left; }
select.input { color:#000; }

.sidebar-icon-only .sidebar .nav .nav-item .nav-link .menu-title { display:block !important; font-size:11px; color:#FFFFFF; }
.sidebar .nav .nav-item.active > .nav-link i.menu-icon {
    background: #edc10f;
    padding: 1px; list-style:outside;
    border-radius: 5px;
    box-shadow: 2px 5px 15px #00000017;
}
.sidebar-icon-only .sidebar .nav .nav-item .nav-link {
    display: block;
    padding-left: 0.25rem;
    padding-right: 0.25rem;
    text-align: center;
    position: static;
}
.sidebar-icon-only .sidebar .nav .nav-item .nav-link[aria-expanded] .menu-title {
    padding-top: 7px;
}
.sidebar-icon-only .main-panel {
    width: calc(100% - 0px);
}
.cal_head { background:#f34c22; color:#FFF; padding:2px 5px; }
.form-control:focus {
    color: #495057;
    background-color: #fff;
    border-color: #F44336!important;
    outline: 0;
    box-shadow: none;
}
.error-input {
    border-color: #F44336!important;
}
.book_sts { float:right; margin-right:5px; padding:0px 5px; background:#07ce09; color:#FFF; }

</style>
</head>
<body class="sidebar-icon-only">
  <div class="container-scroller">
    
    
    <div class="container-fluid page-body-wrapper">
      
      <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <h5>CEMETERY LIST</h5>
                </div>
            </div>
        <div class="row">
				<div class="col-md-12 card" style="padding:20px;">
				<div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Date</th>
                                            <th>Name of Dec</th>
                                            <th>Age of Dec</th>
                                            <th>Date of Demise</th>
                                            <th>Burial No</th>
                                            <th>Registered By</th>
											                      <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; foreach($list as $row) { ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($row['date'])); ?></td>
                                            <td><?php echo $row['name_of_deceased']; ?></td>
                                            <td><?php echo $row['age']; ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($row['date_of_demise'])); ?></td>
                                            <td><?php echo $row['b_certif_no']; ?></td>
                                            <td><?php 
                                                $entry_by = $db->table('login')->where('id', $row['entry_by'])->get()->getRowArray();
                                                echo $entry_by['name']; ?>
                                            </td>
                                            <td style="width: 5%;">
                                                <a class="btn btn-success btn-rad" href="<?= base_url()?>/cemeteryreg/draft_edit/<?php echo $row['id'];?>"><i class="fa fa-edit"></i></a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>	
		        </div>
			</div>
        </div>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>

  <div id="prin_page"></div>
  <!-- container-scroller -->
  <script src="<?php echo base_url(); ?>/assets/archanai/js/jquery.min.js"></script>
  <!-- base:js -->
  <script src="<?php echo base_url(); ?>/assets/archanai/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <script src="<?php echo base_url(); ?>/assets/archanai/vendors/chart.js/Chart.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets/archanai/js/jquery.cookie.js" type="text/javascript"></script>
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="<?php echo base_url(); ?>/assets/archanai/js/off-canvas.js"></script>
  <script src="<?php echo base_url(); ?>/assets/archanai/js/hoverable-collapse.js"></script>
  <script src="<?php echo base_url(); ?>/assets/archanai/js/template.js"></script>
  <script src="<?php echo base_url(); ?>/assets/archanai/js/settings.js"></script>
  <script src="<?php echo base_url(); ?>/assets/archanai/js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="<?php echo base_url(); ?>/assets/archanai/js/dashboard.js"></script>
  
  <script src="<?php echo base_url(); ?>/assets/archanai/js/popper.js"></script>


</body>
</html>

