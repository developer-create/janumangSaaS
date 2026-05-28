<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-book" aria-hidden="true"></i> Docs (Letter) Register Management
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
                        <h3 class="box-title">Docs Register List</h3>
                        <div style="float: right;">
                            <a href="<?php echo site_url('dispatchregister/create'); ?>" class="btn btn-success">Add New Entry</a>
                        </div>
                    </div>
                    
                    <!-- Tabs Navigation -->
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#all-docs" data-toggle="tab" data-filter="all">All Records</a>
                            </li>
                            <li>
                                <a href="#dispatch-docs" data-toggle="tab" data-filter="dispatch">Dispatch Records</a>
                            </li>
                            <li>
                                <a href="#inward-docs" data-toggle="tab" data-filter="inward">Inward Doc Records</a>
                            </li>
                        </ul>
                        
                        <!-- Filters -->
                        <div style="padding: 10px; background-color: #f4f4f4; border-bottom: 1px solid #ddd;">
                            <div class="row">
                                <div class="col-md-3">
                                    <select id="monthFilter" class="form-control">
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
                                </div>
                                <div class="col-md-3">
                                    <select id="districtFilter" class="form-control">
                                        <option value="">All Districts</option>
                                        <?php if(!empty($districts)): ?>
                                            <?php foreach($districts as $district): ?>
                                                <option value="<?php echo $district->name; ?>"><?php echo $district->name; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-content">
                            <div class="tab-pane active" id="all-docs">
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
                                                <th>Inward Doc No.</th>
                                                <th>Department</th>
                                                <th>Particular (subject)</th>
                                                <th>Reference</th>
                                                <th>Block</th>
                                                <th>Letter</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($dispatch_registers as $key => $register): ?>
                                            <tr class="record-row" 
                                                data-dispatch="<?php echo !empty($register['dispatch_no']) ? '1' : '0'; ?>"
                                                data-inward="<?php echo !empty($register['inward_doc_no']) ? '1' : '0'; ?>"
                                                data-month="<?php echo $register['month']; ?>"
                                                data-district="<?php echo $register['district_name']; ?>">
                                                <td><?php echo $key + 1; ?></td>
                                                <td><?php echo $register['date'] ? date('d-m-Y', strtotime($register['date'])) : '-'; ?></td>
                                                <td><?php echo $register['year'] ? $register['year'] : '-'; ?></td>
                                                <td><?php echo $register['month'] ? $register['month'] : '-'; ?></td>
                                                <td><?php echo $register['portal_no'] ? $register['portal_no'] : '-'; ?></td>
                                                <td><?php echo $register['samiti_no'] ? $register['samiti_no'] : '-'; ?></td>
                                                <td><?php echo $register['dispatch_no'] ? $register['dispatch_no'] : '-'; ?></td>
                                                <td><?php echo $register['inward_doc_no'] ? $register['inward_doc_no'] : '-'; ?></td>
                                                <td><?php echo $register['department_name'] ? $register['department_name'] : '-'; ?></td>
                                                <td><?php echo $register['particular_subject'] ? substr($register['particular_subject'], 0, 50) . (strlen($register['particular_subject']) > 50 ? '...' : '') : '-'; ?></td>
                                                <td><?php echo $register['reference'] ? $register['reference'] : '-'; ?></td>
                                                <td><?php echo $register['block_name'] ? $register['block_name'] : '-'; ?></td>
                                                <td>
                                                    <?php if(!empty($register['upload_letter']) && file_exists($register['upload_letter'])): ?>
                                                        <a href="<?php echo base_url($register['upload_letter']); ?>" target="_blank" class="btn btn-xs btn-primary" title="View Letter">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="<?php echo site_url('dispatchregister/view/' . $register['id']); ?>" class="btn btn-xs btn-info" title="View Details">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a href="<?php echo site_url('dispatchregister/edit/' . $register['id']); ?>" class="btn btn-xs btn-warning" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="<?php echo site_url('dispatchregister/delete/' . $register['id']); ?>" class="btn btn-xs btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this record?');">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
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
    </section>
</div>

<script>
$(document).ready(function() {
    var table = $('#dispatchTable').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "pageLength": 25,
        "lengthMenu": [10, 25, 50, 100],
        "order": [[0, "desc"]],
        "dom": 'lBfrtip',
        "buttons": [
            {
                extend: 'excelHtml5',
                text: 'Export Excel',
                className: 'btn btn-success btn-sm',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            }
        ]
    });

    // Tab filtering
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var filter = $(e.target).data('filter');
        
        if (filter === 'all') {
            table.column(6).search('').column(7).search('').draw(); // Clear both dispatch and inward filters
        } else if (filter === 'dispatch') {
            // Show only records with dispatch_no (not empty)
            table.column(6).search('.+', true, false).column(7).search('').draw();
        } else if (filter === 'inward') {
            // Show only records with inward_doc_no (not empty)
            table.column(7).search('.+', true, false).column(6).search('').draw();
        }
    });

    // Month filter
    $('#monthFilter').on('change', function() {
        var month = this.value;
        table.column(3).search(month).draw();
    });

    // District filter  
    $('#districtFilter').on('change', function() {
        var district = this.value;
        table.column(11).search(district).draw(); // Adjusted for new column structure
    });
});
</script>

<style>
.nav-tabs-custom .tab-content {
    border-bottom-right-radius: 4px;
    border-bottom-left-radius: 4px;
}

.record-row {
    cursor: pointer;
}

.record-row:hover {
    background-color: #f5f5f5;
}
</style>