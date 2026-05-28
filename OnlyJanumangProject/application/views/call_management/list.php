<div class="content-wrapper">
    <!-- Content Header (Page header) --> 
    
    <style>
        
        table.dataTable thead>tr>th.sorting:after, table.dataTable thead>tr>th.sorting_asc:after, table.dataTable thead>tr>th.sorting_desc:after, table.dataTable thead>tr>th.sorting_asc_disabled:after, table.dataTable thead>tr>th.sorting_desc_disabled:after, table.dataTable thead>tr>td.sorting:after, table.dataTable thead>tr>td.sorting_asc:after, table.dataTable thead>tr>td.sorting_desc:after, table.dataTable thead>tr>td.sorting_asc_disabled:after, table.dataTable thead>tr>td.sorting_desc_disabled:after{

color:#000000 !important;
    opacity: 60 !important;
}

table.dataTable thead>tr>th.sorting:before, table.dataTable thead>tr>th.sorting_asc:before, table.dataTable thead>tr>th.sorting_desc:before, table.dataTable thead>tr>th.sorting_asc_disabled:before, table.dataTable thead>tr>th.sorting_desc_disabled:before, table.dataTable thead>tr>td.sorting:before, table.dataTable thead>tr>td.sorting_asc:before, table.dataTable thead>tr>td.sorting_desc:before, table.dataTable thead>tr>td.sorting_asc_disabled:before, table.dataTable thead>tr>td.sorting_desc_disabled:before{

color:#000000 !important;
    opacity: 60 !important;
}

/* DataTables Buttons Styling */
.dt-buttons {
    margin-bottom: 15px;
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.dt-buttons .btn {
    margin-right: 8px !important;
    margin-bottom: 5px !important;
    white-space: nowrap;
}

.dataTables_wrapper .dataTables_filter {
    float: right;
    text-align: right;
    margin-bottom: 10px;
}

.dataTables_wrapper .dataTables_length {
    float: left;
    margin-bottom: 10px;
}

.dataTables_wrapper .dt-buttons {
    clear: both;
    text-align: center;
    margin-bottom: 15px;
}

.dataTables_wrapper::after {
    content: '';
    display: table;
    clear: both;
}

.mr-2 {
    margin-right: 8px !important;
}
    </style>
    <section class="content-header"> 
      <h1>
        <i class="fa fa-phone" aria-hidden="true"></i> Call Management
      </h1>
    </section>
    <section class="content"> 
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
    <h3 class="box-title">Call Management List</h3>  
    <select id="categoryFilter" class="form-control" style="width: 200px; display: inline-block; margin-left: 20px;">
        <option value="">All Categories</option>
        <option value="Complaint">Complaint</option>
        <option value="Inquiry">Inquiry</option>
        <option value="Suggestion">Suggestion</option>
        <option value="Information">Information</option>
        <option value="Service Request">Service Request</option>
        <option value="Emergency">Emergency</option>
        <option value="Follow Up">Follow Up</option>
        <option value="Other">Other</option>
    </select>
    <div style="float: right;">
        <a href="<?php echo site_url('callmanagement/create'); ?>" class="btn btn-success">Add New Call</a>
    </div>
</div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover" id="callTable">
                    <thead>
                      <tr style="color:white;font-size:15px;background-color:#020254;">
                       <th>Sr No</th>  
                       <th>Date & Time</th>
                       <th>Category</th>
                       <th>Name</th>
                       <th>Mobile No</th>
                       <th>Address</th>
                       <th>Subject</th>
                       <th>Description</th>
                       <th>Assign Date & Time</th>
                       <th>Remark</th>
                       <th>Added By</th>
                       <th>Actions</th>
                </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($calls)) : ?>
                        <?php foreach ($calls as $key => $call): ?>
                        <tr>    
                               <td><?php echo $key+1; ?></td>
                               <td><?php echo date('d-m-Y H:i', strtotime($call->date_time)); ?></td>
                               <td>
                                   <?php 
                                   $category_colors = array(
                                       'Complaint' => 'label-danger',
                                       'Inquiry' => 'label-info',
                                       'Suggestion' => 'label-warning',
                                       'Information' => 'label-primary',
                                       'Service Request' => 'label-success',
                                       'Emergency' => 'label-danger',
                                       'Follow Up' => 'label-warning',
                                       'Other' => 'label-default'
                                   );
                                   $color_class = isset($category_colors[$call->category]) ? $category_colors[$call->category] : 'label-default';
                                   ?>
                                   <span class="label <?php echo $color_class; ?>"><?php echo $call->category; ?></span>
                               </td>
                               <td><?php echo $call->name; ?></td>
                               <td><?php echo $call->mobile_no; ?></td>
                               <td><?php echo $call->address; ?></td>
                               <td><?php echo substr($call->subject, 0, 30) . (strlen($call->subject) > 30 ? '...' : ''); ?></td>
                               <td><?php echo substr($call->description, 0, 40) . (strlen($call->description) > 40 ? '...' : ''); ?></td>
                               <td><?php echo !empty($call->assign_datetime) ? date('d-m-Y H:i', strtotime($call->assign_datetime)) : '<span class="text-muted">Not Assigned</span>'; ?></td>
                               <td><?php echo $call->remark; ?></td>
                               <td> 
                                <?php
                                    $uid = $call->created_by;
                                    if ($uid) {
                                        $cc = $this->db->query(
                                            "SELECT * FROM `tbl_users` WHERE `userId`='$uid'"
                                        );
                                        $Uu = $cc->row();
                                        if ($Uu) {
                                            echo $Uu->name;
                                        }
                                    }
                                    ?>
                                    </td>
                                <td>
                                <a href="<?php echo site_url('callmanagement/view/'.$call->id); ?>" class="btn btn-success btn-xs" title="View"><i class="fa fa-eye"></i></a>
                                <a href="<?php echo site_url('callmanagement/edit/'.$call->id); ?>" class="btn btn-info btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>
                                <a href="<?php echo site_url('callmanagement/delete/'.$call->id); ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure?');" title="Delete"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="12" class="text-center">No call records found.</td>
                        </tr>
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
<!-- Include Moment.js for date sorting -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.13.4/sorting/datetime-moment.js"></script>

<script>
$(document).ready(function() {
    // Register moment.js for DataTables date sorting
    $.fn.dataTable.moment('DD-MM-YYYY HH:mm'); // Adjust format for datetime

    var table = $('#callTable').DataTable({
        "processing": true,
        "serverSide": false,
        "dom": 'Bfrtip',
        "buttons": {
            dom: {
                button: {
                    className: 'btn btn-sm'
                }
            },
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o"></i> Excel',
                    className: 'btn btn-success btn-sm mr-2',
                    title: 'Call Management List'
                },
                {
                    extend: 'csvHtml5',
                    text: '<i class="fa fa-file-text-o"></i> CSV',
                    className: 'btn btn-info btn-sm mr-2',
                    title: 'Call Management List'
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf-o"></i> PDF',
                    className: 'btn btn-danger btn-sm mr-2',
                    title: 'Call Management List'
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i> Print',
                    className: 'btn btn-warning btn-sm mr-2',
                    title: 'Call Management List'
                }
            ]
        },
        "paging": true,
        "searching": true,
        "ordering": true, // Enable ordering
        "info": true,
        "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]],
        "columnDefs": [
            { "type": "date", "targets": 1 }, // Enable sorting on the "Date & Time" column
            { "type": "datetime", "targets": 8 } // Enable sorting on the "Assign Date & Time" column  
        ]
    });

    // Move buttons to a better position and fix layout
    setTimeout(function() {
        $('.dt-buttons').css({
            'display': 'inline-block',
            'margin-left': '20px',
            'margin-bottom': '10px',
            'vertical-align': 'top'
        });
        
        $('.dt-buttons .btn').css({
            'margin-right': '8px',
            'margin-bottom': '5px'
        });
    }, 100);

    // Filter table based on selected category
    $('#categoryFilter').on('change', function() {
        var selectedCategory = $(this).val();
        table.column(2).search(selectedCategory).draw(); // Column 2 is the 'Category' column
    });
});
</script>