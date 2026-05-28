<div class="content-wrapper">
    <style>
        table.dataTable thead>tr>th.sorting:after, table.dataTable thead>tr>th.sorting_asc:after, table.dataTable thead>tr>th.sorting_desc:after, table.dataTable thead>tr>th.sorting_asc_disabled:after, table.dataTable thead>tr>th.sorting_desc_disabled:after, table.dataTable thead>tr>td.sorting:after, table.dataTable thead>tr>td.sorting_asc:after, table.dataTable thead>tr>td.sorting_desc:after, table.dataTable thead>tr>td.sorting_asc_disabled:after, table.dataTable thead>tr>td.sorting_desc_disabled:after{
            color:#000000 !important;
            opacity: 60 !important;
        }

        table.dataTable thead>tr>th.sorting:before, table.dataTable thead>tr>th.sorting_asc:before, table.dataTable thead>tr>th.sorting_desc:before, table.dataTable thead>tr>th.sorting_asc_disabled:before, table.dataTable thead>tr>th.sorting_desc_disabled:before, table.dataTable thead>tr>td.sorting:before, table.dataTable thead>tr>td.sorting_asc:before, table.dataTable thead>tr>td.sorting_desc:before, table.dataTable thead>tr>td.sorting_asc_disabled:before, table.dataTable thead>tr>td.sorting_desc_disabled:before{
            color:#000000 !important;
            opacity: 60 !important;
        }
    </style>
    <section class="content-header"> 
        <h1>
            <i class="fa fa-users" aria-hidden="true"></i> Nirman Samiti Members
        </h1>
    </section>
    <section class="content"> 
        <!-- Location Info Card -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-map-marker"></i> Location Information</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>ब्लॉक (Block):</strong> <?php echo $group['block_name']; ?>
                            </div>
                            <div class="col-md-3">
                                <strong>सेक्टर (Sector):</strong> <?php echo $group['sector']; ?>
                            </div>
                            <div class="col-md-3">
                                <strong>बूथ का नाम (Booth Name):</strong> <?php echo $group['booth_name']; ?>
                            </div>
                            <div class="col-md-3">
                                <strong>बूथ क (Booth No):</strong> <?php echo $group['booth_no']; ?>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-3">
                                <strong>ग्राम पंचायत:</strong> <?php echo $group['gram_panchayat']; ?>
                            </div>
                            <div class="col-md-3">
                                <strong>गांव का नाम (Village):</strong> <?php echo $group['village']; ?>
                            </div>
                            <div class="col-md-3">
                                <strong>फलिया (Faliya):</strong> <?php echo $group['faliya']; ?>
                            </div>
                        </div>
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
                            <a href="<?php echo site_url('nirmansamiti/add_member/'.$group['id']); ?>" class="btn btn-success">
                                <i class="fa fa-plus"></i> Add Member
                            </a>
                            <a href="<?php echo site_url('nirmansamiti'); ?>" class="btn btn-default">
                                <i class="fa fa-arrow-left"></i> Back to Locations
                            </a>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover" id="membersTable">
                            <thead>
                                <tr style="color:white;font-size:15px;background-color:#020254;">
                                    <th>Sr No</th>
                                    <th>ब्लॉक (Block)</th>
                                    <th>सेक्टर (Sector)</th>
                                    <th>माइक्रो सेक्टर न (Micro Sector No)</th>
                                    <th>माइक्रो सेक्टर नाम (Micro Sector Name)</th>
                                    <th>बूथ का नाम (Booth Name)</th>
                                    <th>बूथ क (Booth No)</th>
                                    <th>ग्राम पंचायत (Gram Panchayat)</th>
                                    <th>गांव का नाम (Village)</th>
                                    <th>फलिया (Faliya)</th>
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
                                    <td colspan="16" class="text-center">No members added yet. Click "Add Member" to add the first member.</td>
                                </tr>
                                <?php else: ?>
                                    <?php foreach ($members as $key => $member): ?>
                                    <tr>
                                        <td><?php echo $key + 1; ?></td>
                                        <td><?php echo $group['block_name']; ?></td>
                                        <td><?php echo $group['sector']; ?></td>
                                        <td><?php echo $group['micro_sector_no']; ?></td>
                                        <td><?php echo $group['micro_sector_name']; ?></td>
                                        <td><?php echo $group['booth_name']; ?></td>
                                        <td><?php echo $group['booth_no']; ?></td>
                                        <td><?php echo $group['gram_panchayat']; ?></td>
                                        <td><?php echo $group['village']; ?></td>
                                        <td><?php echo $group['faliya']; ?></td>
                                        <td><?php echo $member['member_name']; ?></td>
                                        <td><?php echo $member['father_name']; ?></td>
                                        <td><?php echo $member['age']; ?></td>
                                        <td><?php echo $member['position']; ?></td>
                                        <td><?php echo $member['mobile_number']; ?></td>
                                        <td><?php echo $member['remark']; ?></td>
                                        <td>
                                            <a href="<?php echo site_url('nirmansamiti/edit_member/'.$member['id']); ?>" class="btn btn-warning btn-xs" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="<?php echo site_url('nirmansamiti/delete_member/'.$member['id']); ?>" class="btn btn-danger btn-xs" title="Delete" onclick="return confirm('Are you sure you want to delete this member?');">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">
                    </div>
                </div><!-- /.box -->
            </div>
        </div>
    </section> 
</div>

<!-- DataTables and related plugins -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.2.2/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

<script>
$(document).ready(function() {
    $('#membersTable').DataTable({
        "processing": true,
        "serverSide": false,
        "dom": '<"top"lfB>rt<"bottom"ip>',
        "buttons": [
            {
                extend: 'excelHtml5',
                text: 'Export Excel',
                title: 'Nirman Samiti Members - <?php echo $group['block_name']; ?> - <?php echo $group['village']; ?>',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            }
        ],
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "lengthMenu": [[10, 25, 50, 75, -1], [10, 25, 50, 75, "All"]]
    });
});
</script>
