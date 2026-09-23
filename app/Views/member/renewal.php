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
                                    <table border="1"
                                        class="table table-bordered table-striped table-hover js-basic-example dataTable">
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
                                                                echo 'ORDINARY MEMBER';
                                                                break;
                                                            case 3:
                                                                echo 'LIFETIME MEMBER';
                                                                break;
                                                            default:
                                                                echo 'Unknown';
                                                                break;
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?= ($member['status'] == 1) ? 'Active' : 'Deactive'; ?>
                                                    </td>
                                                    <td>
                                                        <!-- Renewal button -->
                                                        <a
                                                            href="<?php echo base_url(); ?>/member/renewal_page/<?= $member['id'] ?>"><button
                                                                type="button" class="btn btn-success ">
                                                                renewal</button></a>

                                                        <!-- Renewal Modal -->
                                                        <!--  <div class="modal fade" id="renewalModal<?= $member['id']; ?>"
                                                            tabindex="-1" role="dialog"
                                                            aria-labelledby="renewalModalLabel<?= $member['id']; ?>">
                                                            <div class="modal-dialog modal-dialog-centered"
                                                                style="max-height: 500px;" role="document">
                                                                 <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title"
                                                                            id="renewalModalLabel<?= $member['id']; ?>">
                                                                            Renewal for
                                                                            <?= $member['name']; ?>
                                                                        </h4>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div> -->
                                                        <!-- <div class="modal-body">
                                                                       
                                                                        <form
                                                                            action="<?= base_url('member/process_renewal/' . $member['id']); ?>"
                                                                            method="post">
                                                                            <div class="form-group">
                                                                                <label for="payment">Payment:</label>
                                                                                <input type="text" class="form-control"
                                                                                    name="payment"
                                                                                    value="<?= $member['payment']; ?>"
                                                                                    readonly>
                                                                            </div>
                                                                            <div style="margin-top:10px">
                                                                                <div class="form-group" style="width:100px">
                                                                                    <label for="payment_mode">Payment
                                                                                        Mode:</label>
                                                                                    <select class="form-control"
                                                                                        name="payment_mode">
                                                                                        <option value="1">Cash</option>
                                                                                        <option value="2">Online</option>
                                                                                        <option value="3">Cheque</option>
                                                                                       
                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                        </form>
                                                                    </div> 
                                                                </div>-->
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