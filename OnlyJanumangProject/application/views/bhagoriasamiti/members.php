<div class="content-wrapper">
    <style>
        table.dataTable thead>tr>th.sorting:after, table.dataTable thead>tr>th.sorting_asc:after, table.dataTable thead>tr>th.sorting_desc:after { color:#000000 !important; opacity: 60 !important; }
        table.dataTable thead>tr>th.sorting:before, table.dataTable thead>tr>th.sorting_asc:before, table.dataTable thead>tr>th.sorting_desc:before { color:#000000 !important; opacity: 60 !important; }
    </style>
    <section class="content-header">
        <h1><i class="fa fa-eye"></i> भगोरिया समिति विवरण / सदस्य (View & Members)</h1>
    </section>
    <section class="content">
        <?php if (!empty($this->session->flashdata('error'))): ?>
        <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
        <?php endif; ?>
        <?php if (!empty($this->session->flashdata('success'))): ?>
        <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
        <?php endif; ?>

        <!-- Record Details -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-info-circle"></i> समिति विवरण (Record Details)</h3>
                        <div style="float: right;">
                            <a href="<?php echo site_url('bhagoriasamiti/edit/'.$record['id']); ?>" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i> Edit</a>
                            <a href="<?php echo site_url('bhagoriasamiti'); ?>" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Back to List</a>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-3"><strong>क्र. (Serial No):</strong> <?php echo $record['serial_no']; ?></div>
                            <div class="col-md-3"><strong>ब्लॉक (Block):</strong> <?php echo isset($block_name) ? $block_name : '-'; ?></div>
                            <div class="col-md-3"><strong>दिनांक (Date):</strong> <?php echo $record['date']; ?></div>
                            <div class="col-md-3"><strong>वार (Day):</strong> <?php echo $record['var']; ?></div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-3"><strong>भगोरिया हाट:</strong> <?php echo $record['bhagoria_hat']; ?></div>
                            <div class="col-md-3"><strong>ढोल की संख्या:</strong> <?php echo $record['dol_ki_sankhya']; ?></div>
                            <div class="col-md-3"><strong>प्रभारी का नाम:</strong> <?php echo $record['prabhari_ka_naam']; ?></div>
                            <div class="col-md-3"><strong>मोबाइल नम्बर:</strong> <?php echo $record['mobile_number']; ?></div>
                        </div>
                        <?php if (!empty($record['remark'])): ?>
                        <div class="row" style="margin-top: 10px;"><div class="col-md-12"><strong>रिमार्क:</strong> <?php echo nl2br(htmlspecialchars($record['remark'])); ?></div></div>
                        <?php endif; ?>
                        <?php if (!empty($record['file_upload'])): ?>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-12">
                                <strong>फाइल (File):</strong>
                                <a href="<?php echo base_url('uploads/samiti_files/'.$record['file_upload']); ?>" target="_blank" class="btn btn-default btn-xs"><i class="fa fa-download"></i> <?php echo htmlspecialchars($record['file_upload']); ?></a>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Members List -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">समिति सदस्य (Committee Members) List</h3>
                        <div style="float: right;">
                            <a href="<?php echo site_url('bhagoriasamiti/add_member/'.$record['id']); ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add Member</a>
                        </div>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover" id="membersTable">
                            <thead>
                                <tr style="color:white;font-size:15px;background-color:#020254;">
                                    <th>क्र.</th>
                                    <th>सदस्य का नाम (Member Name)</th>
                                    <th>पिता का नाम (Father Name)</th>
                                    <th>उम्र (Age)</th>
                                    <th>पद (Position)</th>
                                    <th>मोबाइल नम्बर (Mobile)</th>
                                    <th>रिमार्क (Remark)</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($members)): ?>
                                <tr>
                                    <td colspan="8" class="text-center">No members added yet. Click "Add Member" to add.</td>
                                </tr>
                                <?php else: ?>
                                <?php foreach ($members as $key => $member): ?>
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo htmlspecialchars($member['member_name']); ?></td>
                                    <td><?php echo htmlspecialchars($member['father_name']); ?></td>
                                    <td><?php echo $member['age']; ?></td>
                                    <td><?php echo htmlspecialchars($member['position']); ?></td>
                                    <td><?php echo htmlspecialchars($member['mobile_number']); ?></td>
                                    <td><?php echo htmlspecialchars($member['remark']); ?></td>
                                    <td>
                                        <a href="<?php echo site_url('bhagoriasamiti/edit_member/'.$member['id']); ?>" class="btn btn-warning btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>
                                        <a href="<?php echo site_url('bhagoriasamiti/delete_member/'.$member['id']); ?>" class="btn btn-danger btn-xs" title="Delete" onclick="return confirm('Are you sure you want to delete this member?');"><i class="fa fa-trash"></i></a>
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
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#membersTable').DataTable({ "paging": true, "searching": true, "ordering": true, "info": true, "lengthMenu": [[10, 25, 50], [10, 25, 50]] });
});
</script>
