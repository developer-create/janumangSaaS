<div class="content-wrapper">
    <style>
        table.dataTable thead>tr>th.sorting:after, table.dataTable thead>tr>th.sorting_asc:after, table.dataTable thead>tr>th.sorting_desc:after, table.dataTable thead>tr>th.sorting_asc_disabled:after, table.dataTable thead>tr>th.sorting_desc_disabled:after, table.dataTable thead>tr>td.sorting:after, table.dataTable thead>tr>td.sorting_asc:after, table.dataTable thead>tr>td.sorting_desc:after, table.dataTable thead>tr>td.sorting_asc_disabled:after, table.dataTable thead>tr>td.sorting_desc_disabled:after {
            color:#000000 !important;
            opacity: 60 !important;
        }
        table.dataTable thead>tr>th.sorting:before, table.dataTable thead>tr>th.sorting_asc:before, table.dataTable thead>tr>th.sorting_desc:before, table.dataTable thead>tr>th.sorting_asc_disabled:before,         table.dataTable thead>tr>th.sorting_desc_disabled:before, table.dataTable thead>tr>td.sorting:before, table.dataTable thead>tr>td.sorting_asc:before, table.dataTable thead>tr>td.sorting_desc:before, table.dataTable thead>tr>td.sorting_asc_disabled:before, table.dataTable thead>tr>td.sorting_desc_disabled:before {
            color:#000000 !important;
            opacity: 60 !important;
        }
    </style>
    <section class="content-header"> 
        <h1>
            <i class="fa fa-users" aria-hidden="true"></i> भगोरिया कार्यक्रम समिति Management
        </h1>
    </section>
    <section class="content"> 
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">भगोरिया कार्यक्रम समिति List</h3>
                        <div style="float: right;">
                            <a href="<?php echo site_url('bhagoriasamiti/create'); ?>" class="btn btn-success">Add New Record</a>
                        </div>
                    </div>
                    <!-- Total Members Card -->
                    <div style="margin: 10px 0; padding: 10px 15px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 5px; display: inline-block; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <span style="font-size: 12px; opacity: 0.9;">कुल सदस्य:</span>
                        <span style="font-size: 18px; font-weight: bold; margin-left: 8px;">
                            <?php echo isset($total_members) ? $total_members : 0; ?>
                        </span>
                    </div>
                    <!-- Filters -->
                    <div class="box-body">
                        <form method="get" action="<?php echo site_url('bhagoriasamiti'); ?>" class="form-inline" id="filterForm">
                            <div class="form-group">
                                <label for="filter_block" class="control-label">ब्लॉक (Block):</label>
                                <select name="filter_block" id="filter_block" class="form-control input-sm">
                                    <option value="">All</option>
                                    <?php if (!empty($blocks)): foreach ($blocks as $blk): ?>
                                    <option value="<?php echo $blk->id; ?>" <?php echo (isset($filter_block) && $filter_block == $blk->id) ? 'selected' : ''; ?>><?php echo htmlspecialchars($blk->name); ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                            <div class="form-group" style="margin-left: 15px;">
                                <label for="filter_year" class="control-label">वर्ष (Year):</label>
                                <select name="filter_year" id="filter_year" class="form-control input-sm">
                                    <option value="">All</option>
                                    <?php if (!empty($years)): foreach ($years as $yr): ?>
                                    <option value="<?php echo $yr['year']; ?>" <?php echo (isset($filter_year) && $filter_year == $yr['year']) ? 'selected' : ''; ?>><?php echo $yr['year']; ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                            <div class="form-group" style="margin-left: 15px;">
                                <label for="filter_month" class="control-label">महीना (Month):</label>
                                <select name="filter_month" id="filter_month" class="form-control input-sm">
                                    <option value="">All</option>
                                    <?php 
                                    $months_names = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 
                                                          7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
                                    if (!empty($months)): 
                                        foreach ($months as $m): 
                                            $month_num = (int)$m['month'];
                                    ?>
                                    <option value="<?php echo $month_num; ?>" <?php echo (isset($filter_month) && $filter_month == $month_num) ? 'selected' : ''; ?>><?php echo $months_names[$month_num]; ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                            <div class="form-group" style="margin-left: 15px;">
                                <label for="filter_date" class="control-label">तारीख (Date):</label>
                                <input type="date" name="filter_date" id="filter_date" class="form-control input-sm" value="<?php echo isset($filter_date) ? $filter_date : ''; ?>">
                            </div>
                            <div class="form-group" style="margin-left: 15px;">
                                <button type="submit" class="btn btn-primary btn-sm" style="display:none;"><i class="fa fa-filter"></i> Filter</button>
                                <a href="<?php echo site_url('bhagoriasamiti'); ?>" class="btn btn-default btn-sm">Reset</a>
                            </div>
                        </form>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover" id="bhagoriaTable">
                            <thead>
                                <tr style="color:white;font-size:15px;background-color:#020254;">
                                    <th>क्र.</th>  
                                    <th>ब्लॉक</th>
                                    <th>दिनांक</th>
                                    <th>वार</th>
                                    <th>भगोरिया हाट</th>
                                    <th>डोल की संख्या</th>
                                    <th>प्रभारी का नाम</th>
                                    <th>मोबाइल नम्बर</th>
                                    <th>रिमार्क</th>
                                    <th>Added By</th>
                                    <th>कुल सदस्य (Total Members)</th>
                                    <th>File</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($records as $key => $record): ?>
                                <tr>    
                                    <td><?php echo $record['serial_no']; ?></td>
                                    <td>
                                        <?php
                                        $blockId = $record['block'];
                                        if ($blockId) {
                                            $blockQuery = $this->db->query("SELECT * FROM `block` WHERE `id`='$blockId'");
                                            $blockData = $blockQuery->row();
                                            if ($blockData) {
                                                echo $blockData->name;
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $record['date']; ?></td>
                                    <td><?php echo $record['var']; ?></td>
                                    <td><?php echo $record['bhagoria_hat']; ?></td>
                                    <td><?php echo $record['dol_ki_sankhya']; ?></td>
                                    <td><?php echo $record['prabhari_ka_naam']; ?></td>
                                    <td><?php echo $record['mobile_number']; ?></td>
                                    <td><?php echo $record['remark']; ?></td>
                                    <td> 
                                        <?php
                                        $uid = $record['created_by'];
                                        if ($uid) {
                                            $cc = $this->db->query("SELECT * FROM `tbl_users` WHERE `userId`='$uid'");
                                            $Uu = $cc->row();
                                            if ($Uu) {
                                                echo $Uu->name;
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td><span class="badge bg-blue"><?php echo isset($record['total_members']) ? (int)$record['total_members'] : 0; ?></span></td>
                                    <td>
                                        <?php if (!empty($record['file_upload'])): ?>
                                            <a href="<?php echo base_url('uploads/samiti_files/'.$record['file_upload']); ?>" target="_blank" class="btn btn-info btn-xs" title="View File">
                                                <i class="fa fa-file"></i> View
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">No File</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo site_url('bhagoriasamiti/view/'.$record['id']); ?>" class="btn btn-sm btn-success" title="View"><i class="fa fa-eye"></i></a>
                                        <a href="<?php echo site_url('bhagoriasamiti/edit/'.$record['id']); ?>" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-pencil"></i></a>
                                        <a href="<?php echo site_url('bhagoriasamiti/delete/'.$record['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');" title="Delete"><i class="fa fa-trash"></i></a>
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
    $('#bhagoriaTable').DataTable({
        "processing": true,
        "serverSide": false,
        "dom": '<"top"lfB>rt<"bottom"ip>',
        "buttons": [
            {
                extend: 'excelHtml5',
                text: 'Export Excel',
                title: 'Bhagoria Samiti List'
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

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/auto-filter.js" charset="utf-8"></script>
