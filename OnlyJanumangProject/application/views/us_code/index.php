<div class="content-wrapper">
    <section class="content-header">
        <h1>
             US Code Management
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">US Code List</h3>
                        <a href="<?php echo site_url('us_code/create'); ?>" class="btn btn-success" style="float: right;">
                            <i class="fa fa-plus"></i> Add New Code
                        </a>
                    </div>

                    <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php echo $this->session->flashdata('success'); ?>
                    </div>
                    <?php endif; ?>

                    <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                    <?php endif; ?>

                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover" id="codeTable">
                            <thead>
                                <tr style="color:white;font-size:15px;background:#020254;">
                                    <th>ID</th>
                                    <th>Code</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Created By</th>
                                    <th>Created Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($codes)): ?>
                                    <?php foreach ($codes as $code): ?>
                                    <tr>
                                        <td><?php echo $code['id']; ?></td>
                                        <td><?php echo htmlspecialchars($code['code']); ?></td>
                                        <td><?php echo !empty($code['description']) ? htmlspecialchars($code['description']) : '-'; ?></td>
                                        <td>
                                            <span class="label <?php echo $code['status'] == 1 ? 'label-success' : 'label-danger'; ?>">
                                                <?php echo $code['status'] == 1 ? 'Active' : 'Inactive'; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php 
                                            $this->db->select('name');
                                            $user = $this->db->get_where('tbl_users', ['userId' => $code['created_by']])->row_array();
                                            echo isset($user['name']) ? htmlspecialchars($user['name']) : 'System';
                                            ?>
                                        </td>
                                        <td><?php echo date('d-m-Y H:i:s', strtotime($code['created_at'])); ?></td>
                                        <td>
                                            <a href="<?php echo site_url('us_code/edit/'.$code['id']); ?>" class="btn btn-sm btn-info">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <button class="btn btn-sm btn-danger deleteCode" data-id="<?php echo $code['id']; ?>" data-code="<?php echo htmlspecialchars($code['code']); ?>">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No US Codes found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function() {
    $('#codeTable').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
    });

    $(document).on('click', '.deleteCode', function() {
        var id = $(this).data('id');
        var code = $(this).data('code');
        
        if (confirm('Are you sure you want to delete "' + code + '"?')) {
            $.ajax({
                url: '<?php echo site_url('us_code/delete/'); ?>' + id,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert('US Code deleted successfully');
                        location.reload();
                    } else {
                        alert(response.message || 'Failed to delete US Code');
                    }
                },
                error: function() {
                    alert('Error deleting US Code');
                }
            });
        }
    });
});
</script>
