<div class="content-wrapper">
    <section class="content-header"> 
        <h1>
            <i class="fa fa-users" aria-hidden="true"></i> Kabbadi Samiti Locations
        </h1>
    </section>
    <section class="content"> 
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">कबड्डी समिति स्थान (Kabbadi Samiti Locations) List</h3>
                        <div class="box-tools">
                            <a href="<?php echo site_url('kabbadisamiti/add'); ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Location</a>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped" id="kabbadiSamitiTable">
                            <thead>
                                <tr style="color:white;font-size:15px;background-color:#020254;">
                                    <th>Sr No</th>
                                    <th>Unique ID</th>
                                    <th>वर्ष (Year)</th>
                                    <th>AC/MP No.</th>
                                    <th>ब्लॉक (Block)</th>
                                    <th>सेक्टर (Sector)</th>
                                    <th>माइक्रो सेक्टर न (Micro Sector No)</th>
                                    <th>माइक्रो सेक्टर नाम (Micro Sector Name)</th>
                                    <th>बूथ का नाम (Booth Name)</th>
                                    <th>बूथ क (Booth No)</th>
                                    <th>ग्राम पंचायत (Gram Panchayat)</th>
                                    <th>गांव का नाम (Village)</th>
                                    <th>फलिया (Faliya)</th>
                                    <th>कुल सदस्य (Total Members)</th>
                                    <th>File</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($records)): ?>
                                    <?php foreach ($records as $key => $group): ?>
                                    <tr>
                                        <td><?php echo $key + 1; ?></td>
                                        <td><strong><?php echo isset($group['unique_id']) ? $group['unique_id'] : '-'; ?></strong></td>
                                        <td><?php echo $group['year']; ?></td>
                                        <td><?php echo $group['ac_mp_no']; ?></td>
                                        <td><?php echo $group['block_name']; ?></td>
                                        <td><?php echo $group['sector']; ?></td>
                                        <td><?php echo $group['micro_sector_no']; ?></td>
                                        <td><?php echo $group['micro_sector_name']; ?></td>
                                        <td><?php echo $group['booth_display_name']; ?></td>
                                        <td><?php echo $group['booth_no_val']; ?></td>
                                        <td><?php echo $group['gram_panchayat']; ?></td>
                                        <td><?php echo $group['village']; ?></td>
                                        <td><?php echo $group['faliya']; ?></td>
                                        <td><span class="badge bg-blue"><?php echo $group['member_count']; ?></span></td>
                                        <td>
                                            <?php if (!empty($group['file_upload'])): ?>
                                                <a href="<?php echo base_url('uploads/kabbadisamiti/'.$group['file_upload']); ?>" target="_blank" class="btn btn-info btn-xs" title="View File">
                                                    <i class="fa fa-file"></i> View
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">No File</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo site_url('kabbadisamiti/members/'.$group['id']); ?>" class="btn btn-primary btn-xs" title="View Members">
                                                <i class="fa fa-users"></i>
                                            </a>
                                            <a href="<?php echo site_url('kabbadisamiti/edit/'.$group['id']); ?>" class="btn btn-warning btn-xs" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="<?php echo site_url('kabbadisamiti/delete/'.$group['id']); ?>" class="btn btn-danger btn-xs" title="Delete" onclick="return confirm('Are you sure you want to delete this location and all its members?');">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
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
    $('#kabbadiSamitiTable').DataTable({
        "dom": '<"top"lfB>rt<"bottom"ip>',
        "buttons": [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o"></i> Export Excel',
                className: 'btn btn-success btn-sm',
                title: 'Kabbadi Samiti Locations List',
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

<style>
.dt-buttons {
    margin-bottom: 15px;
    float: left;
}
.dataTables_length {
    float: left;
    margin-right: 20px;
}
.dataTables_filter {
    float: right;
}
</style>
