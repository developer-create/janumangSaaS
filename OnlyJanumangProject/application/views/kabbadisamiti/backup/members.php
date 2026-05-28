<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-users" aria-hidden="true"></i> Kabbadi Samiti Members
            <small>for <?php echo $group['unique_id']; ?> (<?php echo $group['booth_name']; ?>)</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Members List</h3>
                        <div class="box-tools">
                            <a href="<?php echo site_url('kabbadisamiti/add_member/'.$group['id']); ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add New Member</a>
                            <a href="<?php echo site_url('kabbadisamiti'); ?>" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Back to Locations</a>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped" id="membersTable">
                            <thead>
                                <tr style="background-color: #020254; color: white;">
                                    <th>Sr No</th>
                                    <th>नाम (Name)</th>
                                    <th>पिता का नाम (Father's Name)</th>
                                    <th>उम्र (Age)</th>
                                    <th>पद (Position)</th>
                                    <th>मोबाइल नंबर (Mobile)</th>
                                    <th>टिप्पणी (Remark)</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($members)): ?>
                                    <?php foreach ($members as $key => $member): ?>
                                    <tr>
                                        <td><?php echo $key + 1; ?></td>
                                        <td><?php echo $member['member_name']; ?></td>
                                        <td><?php echo $member['father_name']; ?></td>
                                        <td><?php echo $member['age']; ?></td>
                                        <td><?php echo $member['position']; ?></td>
                                        <td><?php echo $member['mobile_number']; ?></td>
                                        <td><?php echo $member['remark']; ?></td>
                                        <td>
                                            <a href="<?php echo site_url('kabbadisamiti/edit_member/'.$member['id']); ?>" class="btn btn-warning btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>
                                            <a href="<?php echo site_url('kabbadisamiti/delete_member/'.$member['id']); ?>" class="btn btn-danger btn-xs" title="Delete" onclick="return confirm('Are you sure you want to delete this member?');"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#membersTable').DataTable();
});
</script>
