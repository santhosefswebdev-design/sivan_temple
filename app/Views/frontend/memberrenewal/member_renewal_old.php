<head>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>

</head>
   <style>
        .table { width: 100%; margin-top: 20px; }
        .table thead th { background-color: #f8f9fa; }
        .table td, .table th { padding: 0.25rem; }
        .modal-dialog { max-width: 500px; margin: 1.75rem auto; }
        .btn-success { color: #fff; background-color: #28a745; border-color: #28a745; }
    </style>
<div class="container-fluid">
    <div class="block-header">
        <h2> Inactive Members</h2>
    </div>
    <!-- Basic Examples -->
    
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">

                <div class="body">

                    <div class="table-responsive">
                        <div class="card">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="table-responsive">
                                <table id="inactiveMembersTable" border="1" class="table table-bordered table-striped table-hover">

                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Member Name</th>
                                                <th>IC No</th>
                                                <th>Member Type</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $serialNumber = 1;
                                            foreach ($inactiveMembers as $member): ?>
                                                <tr>
                                                    <td>
                                                        <?= $serialNumber++; ?>
                                                    </td>
                                                    <td>
                                                        <?= $member['name']; ?>
                                                    </td>
                                                    <td>
                                                        <?= $member['ic_no']; ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        switch ($member['member_type']) {
                                                            case 1:
                                                                echo 'Normal Member';
                                                                break;
                                                            case 2:
                                                                echo 'Associate Member';
                                                                break;
                                                            case 3:
                                                                echo 'Lifetime Member';
                                                                break;
                                                            default:
                                                                echo 'Unknown Member Type';
                                                                break;
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?= ($member['status'] == 1) ? 'Active' : 'Deactive'; ?>
                                                    </td>
                                                    <td>
                                                        <!-- Renewal button -->
                                                        <a href="#" data-toggle="modal"
                                                            data-target="#renewalModal<?= $member['id']; ?>"
                                                            class="btn btn-success">Renewal</a>
                                                        <!-- Renewal Modal -->
                                                      <div class="modal fade" id="renewalModal<?= $member['id']; ?>" tabindex="-1" role="dialog"
                                                            aria-labelledby="renewalModalLabel<?= $member['id']; ?>">
                                                            <div class="modal-dialog modal-dialog-centered" style="max-height: 500px;" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title" id="renewalModalLabel<?= $member['id']; ?>">
                                                                            Renewal for
                                                                            <?= $member['name']; ?>
                                                                        </h4>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <!-- Renewal form -->
                                                                        <form action="<?= base_url('/memberrenewal/renewal_save/'); ?>" method="post">
                                                                        <input type="hidden" name="id" value="<?= $member['id']; ?>" />
                                                                            <div class="form-group">
                                                                                <label for="payment">Payment:</label>
                                                                                <input type="text" class="form-control" name="payment" value="<?= $member['payment']; ?>"
                                                                                    readonly>
                                                                            </div>
                                                    
                                                                            <div class="form-group">
                                                                                <label for="payment_mode">Payment Mode:</label>
                                                                                <select class="form-control" name="payment_mode">
                                                                                    <option value="1">Cash</option>
                                                                                    <option value="2">Online</option>
                                                                                    <option value="3">Cheque</option>
                                                                                    <!-- Add other payment modes as needed -->
                                                                                </select>
                                                                            </div>
                                                   
                                                        <div class="col-sm-12" align="center">
                                                            <!-- <input  type="checkbox" checked="checked" id="print" name="print" value="Print">
                                                                                                                                                                <label for ='print'> Print &nbsp;&nbsp; </label> -->
                                                            <button type="submit" class="btn btn-success btn-md waves-effect">RENEWAL</button>
                                                        </div>
                                                  
                                                                            <!-- <button type="submit" class="btn btn-primary">Submit Renewal</button> -->
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </td>
                                                    </tr>
                                            <?php endforeach; ?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#inactiveMembersTable').DataTable({
        "pageLength": 10 // This will set the initial page length (number of rows per page) to 10
    
    });
});
</script>
