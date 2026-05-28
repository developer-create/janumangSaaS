<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-tasks" aria-hidden="true"></i> Project Summary Management
            <small>Add, Edit, Delete</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>

                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Project Summary List</h3>
                        <div style="float: right;">
                            <a class="btn btn-primary" href="<?php echo base_url(); ?>projectSummary/add"><i class="fa fa-plus"></i> Add New Project</a>
                        </div>
                    </div><!-- /.box-header -->
                    
                    <!-- Filter Section -->
                    <div class="box-body" style="padding: 10px; border-bottom: 1px solid #ddd;">
                        <form method="post" action="<?php echo site_url('projectSummary/projectListing'); ?>" style="margin: 0;">
                            <div class="row">
                                <div class="col-md-2">
                                    <select name="department" id="filterDepartment" class="form-control" style="font-size: 12px; padding: 5px;">
                                        <option value="">All Departments</option>
                                        <?php if(!empty($departments)): ?>
                                            <?php foreach($departments as $dept): ?>
                                                <option value="<?php echo htmlspecialchars($dept->department_name); ?>" <?php echo (isset($filters['department']) && $filters['department'] == $dept->department_name) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($dept->department_name); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="tender_status" id="filterTenderStatus" class="form-control" style="font-size: 12px; padding: 5px;">
                                        <option value="">All Tender Statuses</option>
                                        <?php if(!empty($tender_statuses)): ?>
                                            <?php foreach($tender_statuses as $status): ?>
                                                <option value="<?php echo htmlspecialchars($status->tender_status); ?>" <?php echo (isset($filters['tender_status']) && $filters['tender_status'] == $status->tender_status) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($status->tender_status); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="work_status" id="filterWorkStatus" class="form-control" style="font-size: 12px; padding: 5px;">
                                        <option value="">All Work Statuses</option>
                                        <?php if(!empty($work_statuses)): ?>
                                            <?php foreach($work_statuses as $ws): ?>
                                                <option value="<?php echo htmlspecialchars($ws->status); ?>" <?php echo (isset($filters['work_status']) && $filters['work_status'] == $ws->status) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($ws->status); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="estimate_range" id="filterEstimateRange" class="form-control" style="font-size: 12px; padding: 5px;">
                                        <option value="">-- Proposal Estimate (Crore) --</option>
                                        <option value="0-1" <?php echo (isset($filters['estimate_range']) && $filters['estimate_range'] == '0-1') ? 'selected' : ''; ?>>0 - 1 Crore</option>
                                        <option value="1-5" <?php echo (isset($filters['estimate_range']) && $filters['estimate_range'] == '1-5') ? 'selected' : ''; ?>>1 - 5 Crore</option>
                                        <option value="5-10" <?php echo (isset($filters['estimate_range']) && $filters['estimate_range'] == '5-10') ? 'selected' : ''; ?>>5 - 10 Crore</option>
                                        <option value="10 Above" <?php echo (isset($filters['estimate_range']) && $filters['estimate_range'] == '10 Above') ? 'selected' : ''; ?>>10 Crore & Above</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-primary form-control" style="font-size: 12px; padding: 5px;">Filter</button>
                                </div>
                                <div class="col-md-1">
                                    <a href="<?php echo site_url('projectSummary/projectListing'); ?>" class="btn btn-default form-control" style="font-size: 12px; padding: 5px;">Clear</a>
                                </div>
                            </div>
                        </form>
                    </div><!-- /.filter-section -->
                    
                    <div class="box-body table-responsive no-padding">
                        <table id="projectSummaryTable" class="table table-hover">
                            <thead>
                                <tr style="color:white;font-size:15px;background:#020254;">
                                    <th>Sr No</th>
                                    <th>Unique ID</th>
                                    <th>District</th>
                                    <th>Block</th>
                                    <th>Department</th>
                                    <th>Work Name</th>
                                    <?php /* <th>Project Cost</th> */ ?>
                                    <th>Project Cost (In Words)</th>
                                    <?php /* <th>Proposal Estimate</th> */ ?>
                                    <th>Proposal Estimate (In Words)</th>
                                    <th>Work Status</th>
                                    <th>Officer Name</th>
                                    <th>Contact No</th>
                                    <th>Technical Session</th>
                                    <th>Administrative Session</th>
                                    <th>Tender Status</th>
                                    <th>Company Name</th>
                                    <th>Contractor Name</th>
                                    <th>Phone No</th>
                                    <th>USD Remark</th>
                                    <th class="remark-col">Remark</th>
                                    <th class="remark-col">Current Progress</th>
                                    <th>Created Date</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                    if(!empty($records))
                    {
                        $sno = 1;
                        foreach($records as $record)
                        {
                    ?>
                                <tr>
                                    <td><?php echo $sno ?></td>
                                    <td><?php echo !empty($record->unique_id) ? htmlspecialchars($record->unique_id) : 'N/A'; ?></td>
                                    <td><?php echo $record->district_name ?></td>
                                    <td><?php echo $record->block_name ?></td>
                                    <td><?php echo $record->department_name ?></td>
                                    <td><?php echo $record->work_name ?></td>
                                    <?php /* <td><?php echo formatIndianCurrency($record->amount_project_cost) ?></td> */ ?>
                                    <td><?php echo !empty($record->amount_project_cost) ? numberToHindiWords($record->amount_project_cost) : 'शून्य'; ?></td>
                                    <?php /* <td><?php echo formatIndianCurrency($record->proposal_estimate) ?></td> */ ?>
                                    <td><?php echo !empty($record->proposal_estimate) ? numberToHindiWords($record->proposal_estimate) : 'शून्य'; ?></td>
                                    <td>
                                        <span
                                            class="label <?php echo ($record->status == 'Completed') ? 'label-success' : (($record->status == 'In Progress') ? 'label-warning' : 'label-info') ?>">
                                            <?php echo $record->status ?>
                                        </span>
                                    </td>
                                    <td><?php echo $record->officer_name ?></td>
                                    <td><?php echo $record->contact_no ?></td>
                                    <td><?php echo !empty($record->technical_session) ? $record->technical_session : 'N/A'; ?></td>
                                    <td><?php echo !empty($record->administrative_session) ? $record->administrative_session : 'N/A'; ?></td>
                                    <td>
                                        <?php 
                                        if(!empty($record->tender_status)) {
                                            $tender_class = ($record->tender_status == 'Open') ? 'label-success' : (($record->tender_status == 'Pending') ? 'label-warning' : 'label-danger');
                                            echo '<span class="label ' . $tender_class . '">' . $record->tender_status . '</span>';
                                        } else {
                                            echo 'N/A';
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo !empty($record->company_name) ? $record->company_name : 'N/A'; ?></td>
                                    <td><?php echo !empty($record->contractor_name) ? $record->contractor_name : 'N/A'; ?></td>
                                    <td><?php echo !empty($record->phone_no) ? $record->phone_no : 'N/A'; ?></td>
                                    <td class="remark-col"><?php echo !empty($record->usd_remark) ? $record->usd_remark : 'N/A'; ?></td>
                                    <td class="remark-col"><?php echo !empty($record->remark) ? $record->remark : 'N/A'; ?></td>
                                    <td class="remark-col"><?php echo !empty($record->last_comment) ? htmlspecialchars($record->last_comment) : 'No comments'; ?></td>
                                    <td><?php echo date("d-m-Y", strtotime($record->created_at)) ?></td>
                                    <td class="text-center">
                                        <a class="btn btn-sm btn-primary" href="<?php echo base_url().'projectSummary/view/'.$record->id; ?>" title="View"><i class="fa fa-eye"></i></a>

                                        <a class="btn btn-sm btn-info"
                                            href="<?php echo base_url().'projectSummary/edit/'.$record->id; ?>"
                                            title="Edit"><i class="fa fa-pencil"></i></a>

                                        <button class="btn btn-sm btn-warning btnComments" 
                                            data-projectid="<?php echo $record->id; ?>" 
                                            data-projectname="<?php echo htmlspecialchars($record->work_name); ?>"
                                            title="Comments"><i class="fa fa-comments"></i></button>

                                        <a class="btn btn-sm btn-danger deleteProject" href="#"
                                            data-projectid="<?php echo $record->id; ?>" title="Delete"><i
                                                class="fa fa-trash"></i></a>

                                    </td>
                                </tr>
                                <?php
                        $sno++;
                        }
                    }
                    else
                    {
                        echo '<tr><td colspan="22" class="text-center">No records found</td></tr>';
                    }
                    ?>
                        </table>

                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">
                    </div>
                </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>

<!-- Comment Modal -->
<div class="modal fade" id="commentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-comments"></i> Project Comments: <span id="projectNameHeader"></span></h4>
            </div>
            <div class="modal-body">
                <!-- Comments List -->
                <div class="comment-section">
                    <h5><i class="fa fa-list"></i> Previous Comments</h5>
                    <div id="commentsList" style="max-height: 300px; overflow-y: auto; margin-bottom: 20px;">
                        <div class="text-center">
                            <i class="fa fa-spinner fa-spin fa-2x"></i>
                            <p>Loading comments...</p>
                        </div>
                    </div>
                </div>
                
                <!-- Add New Comment -->
                <div class="new-comment-section">
                    <h5><i class="fa fa-plus"></i> Add New Comment</h5>
                    <form id="addCommentForm">
                        <input type="hidden" id="commentProjectId" name="project_id">
                        <div class="form-group">
                            <textarea class="form-control" id="newComment" name="comment" rows="4" 
                                placeholder="Enter your comment here..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Add Comment
                        </button>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
<style>
/* DataTables buttons styling */
.dt-buttons {
    float: left;
    margin-right: 10px;
}

button.dt-button {
    background-color: #3c8dbc !important;
    color: white !important;
    border: 1px solid #367fa9 !important;
    padding: 5px 12px !important;
    margin-right: 5px !important;
    border-radius: 3px !important;
}

button.dt-button:hover {
    background-color: #367fa9 !important;
}

/* Length menu styling */
.dataTables_length {
    float: left;
    margin-left: 15px;
}

/* Wrapper styling */
.dataTables_wrapper {
    overflow-x: auto;
}

/* Table column width - doubled for better visibility */
table.table th, 
table.table td {
    min-width: 120px !important;
    padding: 10px !important;
    font-size: 13px !important;
}

/* Specific column widths */
table thead tr th:nth-child(1) { min-width: 50px; }  /* Sr No */
table thead tr th:nth-child(2) { min-width: 120px; } /* Unique ID */
table thead tr th:nth-child(3) { min-width: 120px; } /* District */
table thead tr th:nth-child(4) { min-width: 120px; } /* Block */
table thead tr th:nth-child(5) { min-width: 150px; } /* Department */
table thead tr th:nth-child(6) { min-width: 150px; } /* Work Name */
table thead tr th:nth-child(7) { min-width: 120px; } /* Project Cost */
table thead tr th:nth-child(8) { min-width: 200px; } /* Project Cost (In Words) */
table thead tr th:nth-child(9) { min-width: 140px; } /* Proposal Estimate */
table thead tr th:nth-child(10) { min-width: 200px; } /* Proposal Estimate (In Words) */
table thead tr th:nth-child(11) { min-width: 100px; } /* Status */
table thead tr th:nth-child(12) { min-width: 130px; } /* Officer Name */
table thead tr th:nth-child(13) { min-width: 120px; } /* Contact No */
table thead tr th:nth-child(14) { min-width: 140px; } /* Technical Session */
table thead tr th:nth-child(15) { min-width: 150px; } /* Administrative Session */
table thead tr th:nth-child(16) { min-width: 120px; } /* Tender Status */
table thead tr th:nth-child(17) { min-width: 140px; } /* Company Name */
table thead tr th:nth-child(18) { min-width: 140px; } /* Contractor Name */
table thead tr th:nth-child(19) { min-width: 120px; } /* Phone No */
table thead tr th:nth-child(20) { min-width: 300px; } /* USD Remark */
table thead tr th:nth-child(21) { min-width: 600px; } /* Remark */
table thead tr th:nth-child(22) { min-width: 130px; } /* Current Progress */
table thead tr th:nth-child(23) { min-width: 120px; } /* Created Date */
table thead tr th:nth-child(24) { min-width: 100px; } /* Actions */

/* Remark column styling */
.remark-col {
    max-width: 600px;
    word-break: break-word;
    white-space: normal;
    line-height: 1.5;
}

/* Comment styling */
.comment-item {
    padding: 10px;
    border-left: 3px solid #3c8dbc;
    margin-bottom: 10px;
    background-color: #f9f9f9;
}

.dataTables_length {
    float: left;
    margin-right: 20px;
}

.dataTables_length select {
    padding: 5px;
    border: 1px solid #d2d6de;
    border-radius: 3px;
}

/* Allow wrapping in Remark column despite Bootstrap's .table-responsive nowrap */
#projectSummaryTable th.remark-col,
#projectSummaryTable td.remark-col {
    white-space: normal !important;
    word-break: break-word;
}

/* Comment modal styles */
.comment-item {
    background: #f9f9f9;
    border-left: 3px solid #3c8dbc;
    padding: 10px 15px;
    margin-bottom: 10px;
    border-radius: 4px;
}

.comment-item .comment-header {
    font-size: 12px;
    color: #666;
    margin-bottom: 5px;
}

.comment-item .comment-author {
    font-weight: bold;
    color: #3c8dbc;
}

.comment-item .comment-date {
    float: right;
    font-style: italic;
}

.comment-item .comment-text {
    font-size: 14px;
    color: #333;
    line-height: 1.5;
}

.new-comment-section {
    border-top: 2px solid #ddd;
    padding-top: 15px;
}

#commentsList::-webkit-scrollbar {
    width: 8px;
}

#commentsList::-webkit-scrollbar-track {
    background: #f1f1f1;
}

#commentsList::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

#commentsList::-webkit-scrollbar-thumb:hover {
    background: #555;
}
/* Style for DataTables sorting arrows */
table.dataTable thead>tr>th.sorting:after, 
table.dataTable thead>tr>th.sorting_asc:after, 
table.dataTable thead>tr>th.sorting_desc:after, 
table.dataTable thead>tr>th.sorting_asc_disabled:after, 
table.dataTable thead>tr>th.sorting_desc_disabled:after, 
table.dataTable thead>tr>td.sorting:after, 
table.dataTable thead>tr>td.sorting_asc:after, 
table.dataTable thead>tr>td.sorting_desc:after, 
table.dataTable thead>tr>td.sorting_asc_disabled:after, 
table.dataTable thead>tr>td.sorting_desc_disabled:after {
    color: #000000 !important;
    opacity: 0.6 !important;
}

table.dataTable thead>tr>th.sorting:before, 
table.dataTable thead>tr>th.sorting_asc:before, 
table.dataTable thead>tr>th.sorting_desc:before, 
table.dataTable thead>tr>th.sorting_asc_disabled:before, 
table.dataTable thead>tr>th.sorting_desc_disabled:before, 
table.dataTable thead>tr>td.sorting:before, 
table.dataTable thead>tr>td.sorting_asc:before, 
table.dataTable thead>tr>td.sorting_desc:before, 
table.dataTable thead>tr>td.sorting_asc_disabled:before, 
table.dataTable thead>tr>td.sorting_desc_disabled:before {
    color: #000000 !important;
    opacity: 0.6 !important;
}
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.2.2/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.colVis.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>

<script type="text/javascript">
$(document).ready(function() {
    var table = $('#projectSummaryTable').DataTable({
        "processing": true,
        "serverSide": false,
        "dom": '<"top"lfB>rt<"bottom"ip>',
        "buttons": [{
                extend: 'excelHtml5',
                text: 'Export Excel',
                title: 'Project Summary List',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22] // Exclude Actions column (23)
                }
            },
            {
                extend: 'colvis',
                text: 'Show/Hide Columns',
                titleAttr: 'Show/Hide Columns'
            }
        ],
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "pageLength": 20, // Default page length
        "lengthMenu": [
            [10, 20, 50, 100, 500, -1],
            [10, 20, 50, 100, 500, "All"]
        ]
    });
});
</script>

<script>
jQuery(document).ready(function() {
    jQuery(document).on("click", ".deleteProject", function() {
        var projectId = $(this).data("projectid"),
            hitURL = baseURL + "projectSummary/delete",
            currentRow = $(this);

        var confirmation = confirm("Are you sure to delete this project ?");

        if (confirmation) {
            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: hitURL,
                data: {
                    projectId: projectId
                }
            }).done(function(data) {
                console.log(data);
                currentRow.parents('tr').remove();
                if (data.status = true) {
                    alert("Project successfully deleted");
                } else if (data.status = false) {
                    alert("Project deletion failed");
                } else {
                    alert("Access denied..!");
                }
            });
        }
    });

    // Handle comment button click
    jQuery(document).on("click", ".btnComments", function() {
        var projectId = $(this).data("projectid");
        var projectName = $(this).data("projectname");
        
        // Set project ID and name in modal
        $('#commentProjectId').val(projectId);
        $('#projectNameHeader').text(projectName);
        
        // Load comments
        loadComments(projectId);
        
        // Show modal
        $('#commentModal').modal('show');
    });

    // Load comments for a project
    function loadComments(projectId) {
        $('#commentsList').html('<div class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i><p>Loading comments...</p></div>');
        
        $.ajax({
            url: baseURL + 'projectSummary/getComments/' + projectId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if(response.status && response.comments.length > 0) {
                    var html = '';
                    $.each(response.comments, function(index, comment) {
                        var commentDate = new Date(comment.created_at);
                        var formattedDate = commentDate.toLocaleDateString('en-GB') + ' ' + 
                                          commentDate.toLocaleTimeString('en-GB', {hour: '2-digit', minute: '2-digit'});
                        
                        html += '<div class="comment-item">';
                        html += '<div class="comment-header">';
                        html += '<span class="comment-author"><i class="fa fa-user"></i> ' + comment.created_by_name + '</span>';
                        html += '<span class="comment-date"><i class="fa fa-clock-o"></i> ' + formattedDate + '</span>';
                        html += '</div>';
                        html += '<div class="comment-text">' + comment.comment + '</div>';
                        html += '</div>';
                    });
                    $('#commentsList').html(html);
                } else {
                    $('#commentsList').html('<div class="alert alert-info"><i class="fa fa-info-circle"></i> No comments yet. Be the first to add a comment!</div>');
                }
            },
            error: function() {
                $('#commentsList').html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Failed to load comments</div>');
            }
        });
    }

    // Handle add comment form submission
    $('#addCommentForm').on('submit', function(e) {
        e.preventDefault();
        
        var projectId = $('#commentProjectId').val();
        var comment = $('#newComment').val().trim();
        
        if(comment === '') {
            alert('Please enter a comment');
            return false;
        }
        
        // Disable submit button
        var submitBtn = $(this).find('button[type="submit"]');
        submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Adding...');
        
        $.ajax({
            url: baseURL + 'projectSummary/addComment',
            type: 'POST',
            dataType: 'json',
            data: {
                project_id: projectId,
                comment: comment
            },
            success: function(response) {
                if(response.status) {
                    // Clear the form
                    $('#newComment').val('');
                    
                    // Reload comments
                    loadComments(projectId);
                    
                    // Show success message
                    alert('Comment added successfully!');
                } else {
                    alert(response.message || 'Failed to add comment');
                }
            },
            error: function() {
                alert('Error adding comment. Please try again.');
            },
            complete: function() {
                // Re-enable submit button
                submitBtn.prop('disabled', false).html('<i class="fa fa-save"></i> Add Comment');
            }
        });
    });

    // Clear form when modal is closed
    $('#commentModal').on('hidden.bs.modal', function() {
        $('#newComment').val('');
        $('#commentsList').html('');
    });
});
</script>