<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-book" aria-hidden="true"></i> Dispatch Register Management
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <?php
                    $success = $this->session->flashdata('success');
                    if($success) {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $success; ?>
                </div>
                <?php } ?>
                <?php
                    $error = $this->session->flashdata('error');
                    if($error) {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $error; ?>
                </div>
                <?php } ?>
                
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Dispatch Register List</h3>
                        <select id="monthFilter" class="form-control" style="width: 150px; display: inline-block; margin-left: 20px;">
                            <option value="">All Months</option>
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November">November</option>
                            <option value="December">December</option>
                        </select>
                        <select id="districtFilter" class="form-control" style="width: 180px; display: inline-block; margin-left: 10px;">
                            <option value="">All Districts</option>
                            <?php if(!empty($districts)): ?>
                                <?php foreach($districts as $district): ?>
                                    <option value="<?php echo $district->name; ?>"><?php echo $district->name; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <div style="float: right;">
                            <a href="<?php echo site_url('dispatchregister/create'); ?>" class="btn btn-success">Add New Entry</a>
                        </div>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover" id="dispatchTable">
                            <thead>
                                <tr style="color:white;font-size:15px;background-color:#020254;">
                                    <th>S.NO</th>
                                    <th>Date</th>
                                    <th>Year</th>
                                    <th>Month</th>
                                    <th>Portal No.</th>
                                    <th>Samiti No.</th>
                                    <th>Dispatch No.</th>
                                    <th>Department</th>
                                    <th>Particular (subject)</th>
                                    <th>Reference</th>
                                    <th>District</th>
                                    <th>Block</th>
                                    <th>Panchayat</th>
                                    <th>Village</th>
                                    <th>Letter</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dispatch_registers as $key => $register): ?>
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo $register['date'] ? date('d-m-Y', strtotime($register['date'])) : '-'; ?></td>
                                    <td><?php echo $register['year'] ? $register['year'] : '-'; ?></td>
                                    <td><?php echo $register['month'] ? $register['month'] : '-'; ?></td>
                                    <td><?php echo $register['portal_no'] ? $register['portal_no'] : '-'; ?></td>
                                    <td><?php echo $register['samiti_no'] ? $register['samiti_no'] : '-'; ?></td>
                                    <td><?php echo $register['dispatch_no'] ? $register['dispatch_no'] : '-'; ?></td>
                                    <td><?php echo $register['department_name'] ? $register['department_name'] : '-'; ?></td>
                                    <td><?php echo $register['particular_subject'] ? $register['particular_subject'] : '-'; ?></td>
                                    <td><?php echo $register['reference'] ? $register['reference'] : '-'; ?></td>
                                    <td><?php echo $register['district_name'] ? $register['district_name'] : '-'; ?></td>
                                    <td><?php echo $register['block_name'] ? $register['block_name'] : '-'; ?></td>
                                    <td><?php echo $register['panchayat_name'] ? $register['panchayat_name'] : '-'; ?></td>
                                    <td><?php echo $register['village_name'] ? $register['village_name'] : '-'; ?></td>
                                    <td>
                                        <?php if(!empty($register['upload_letter']) && file_exists($register['upload_letter'])): ?>
                                            <a href="<?php echo base_url($register['upload_letter']); ?>" target="_blank" class="btn btn-xs btn-primary" title="View Letter">
                                                <i class="fa fa-file"></i>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo site_url('dispatchregister/view/'.$register['id']); ?>" class="btn btn-sm btn-success" title="View"><i class="fa fa-eye"></i></a>
                                        <a href="<?php echo site_url('dispatchregister/edit/'.$register['id']); ?>" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-pencil"></i></a>
                                        <a href="<?php echo site_url('dispatchregister/delete/'.$register['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');" title="Delete"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer clearfix"></div>
                </div>
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
    var table = $('#dispatchTable').DataTable({
        "processing": true,
        "serverSide": false,
        "dom": '<"top"lfB>rt<"bottom"ip>',
        "buttons": [
            {
                extend: 'excelHtml5',
                text: 'Export Excel',
                title: 'Dispatch Register List'
            }
        ],
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "lengthMenu": [[10, 20, 50, 100, 500, -1], [10, 20, 50, 100, 500, "All"]],
        "pageLength": 20
    });

    // Filter table based on selected month
    $('#monthFilter').on('change', function() {
        var selectedMonth = $(this).val();
        table.column(3).search(selectedMonth).draw(); // Column 3 is the 'Month' column
    });

    // Filter table based on selected district
    $('#districtFilter').on('change', function() {
        var selectedDistrict = $(this).val();
        table.column(10).search(selectedDistrict).draw(); // Column 10 is the 'District' column
    });
});
</script>

<style>
    table.dataTable thead>tr>th.sorting:after, 
    table.dataTable thead>tr>th.sorting_asc:after, 
    table.dataTable thead>tr>th.sorting_desc:after {
        color:#000000 !important;
        opacity: 0.6 !important;
    }
    
    table.dataTable thead>tr>th.sorting:before, 
    table.dataTable thead>tr>th.sorting_asc:before, 
    table.dataTable thead>tr>th.sorting_desc:before {
        color:#000000 !important;
        opacity: 0.6 !important;
    }
</style>
