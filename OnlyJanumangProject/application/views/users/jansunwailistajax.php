<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <i class="fa fa-users"></i> Public Problems Management
      </h1>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-xs-12 text-right">
            <div class="form-group">
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <?php
               $this->load->helper("form");
               $error = $this->session->flashdata("error");
               if ($error) { ?>
            <div class="alert alert-danger alert-dismissable">
               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
               <?php echo $this->session->flashdata(
                  "error"
                  ); ?>                    
            </div>
            <?php } ?>
            <?php
               $success = $this->session->flashdata("success");
               if ($success) { ?>
            <div class="alert alert-success alert-dismissable">
               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
               <?php echo $this->session->flashdata("success"); ?>
            </div>
            <?php }
               ?>
            <div class="row">
               <div class="col-md-12">
                  <?php echo validation_errors(
                     '<div class="alert alert-danger alert-dismissable">',
                     ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'
                     ); ?>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <!-- Filter Form -->
         <div class="col-xs-12">
            <form method="post" action="<?php echo base_url(
               "user/jansunwai"
               ); ?>">
               <div class="row">
                  <div class="col-md-2">
                     <div class="form-group">
                        <label for="block">Block</label>
                        <select name="block" id="block" class="form-control">
                           <option value="">Select Block</option>
                           <?php
                              $userid = $this->session->userdata("userId");
                              $sessionBlockId = $this->session->userdata("blockId");
                              //  $this->db->where('id !=', 6);
                              if ($sessionBlockId != 0) {
                                  $userBlockIds = $this->db
                                      ->select("blockId")
                                      ->from("tbl_users")
                                      ->where("userId", $userid)
                                      ->get()
                                      ->row()->blockId;
                              
                                  $blockIdsArray = explode(",", $userBlockIds);
                                  $this->db->where_in("block.id", $blockIdsArray);
                              }
                              $blocks = $this->db->get("block")->result();
                              foreach ($blocks as $blk) {
                                  echo "<option value='{$blk->id}'>{$blk->name}</option>";
                              }
                              ?>  
                        </select>
                     </div>
                  </div>
                  <div class="col-md-2">
                     <div class="form-group">
                        <label for="year">Financial Year</label>
                        <?php
                           $this->load->helper('financial_year');
                           $financial_years = get_financial_years(2008, 2027);
                        ?>
                        <select name="year" id="year" class="form-control">
                           <option value="">Select Financial Year</option>
                           <?php
                              // Sort in descending order (newest first)
                              krsort($financial_years);
                              foreach ($financial_years as $fy) {
                                  echo "<option value='{$fy}'>{$fy}</option>";
                              }
                              ?>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-2">
                     <div class="form-group">
                        <label for="month">Month</label>
                        <select name="month" id="month" class="form-control">
                           <option value="">Select Month</option>
                           <?php
                              $months = [
                                  "01" => "January",
                                  "02" => "February",
                                  "03" => "March",
                                  "04" => "April",
                                  "05" => "May",
                                  "06" => "June",
                                  "07" => "July",
                                  "08" => "August",
                                  "09" => "September",
                                  "10" => "October",
                                  "11" => "November",
                                  "12" => "December",
                              ];
                              foreach ($months as $key => $value) {
                                  echo "<option value='{$key}'>{$value}</option>";
                              }
                              ?>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-2">
                     <div class="form-group">
                        <label for="work_status">Status</label>
                        <select name="work_status" id="work_status" class="form-control">
                           <option value="">Select Status</option>
                           <?php
                              $months = [
                                  "Incomplete" => "Incomplete",
                                  "In progress" => "In progress",
                                  "Complete" => "Complete",
                                  "Reject" => "Reject"
                              ];
                              foreach ($months as $key => $value) {
                                  echo "<option value='{$key}'>{$value}</option>";
                              }
                              ?>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-2">
                     <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary form-control">Filter</button>
                     </div>
                  </div>
               </div>
            </form>
            <div class="box">
               <div class="box-header">
                  <h3 class="box-title">Public Problems  List</h3>
                  <a href="<?php echo base_url(); ?>user/addNewJansunwai"  class="btn btn-info" style="float: right;" >Add</a>
               </div>
               <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table id="feedbackTa" class="table table-striped" style="width:100%">
                     <thead>
                        <tr style="color:white;font-size:15px;background-color:#020254;">
                            <th>Sr.No.</th>
                           <th>Regi. No.</th>
                           <th>Timer</th>
                           <th>Sector Name</th>
                           <th>Micro Sector No.</th>
                           <th>Micro Sector Name</th>
                           <th>Year</th>
                           <th>Month</th>
                           <th>Date</th>
                           <th>District</th>
                           <th>Assembly</th>
                           <th>Block</th>
                           <th>Recommended Letter No</th>
                           <th>Booth No</th>
                           <th>Booth Name</th>
                           <th>Panchayat Name</th>
                           <th>Village</th>
                           <th>Majra/Faliya</th>
                           <th style="width:200px !important;">Work/Problem</th>
                           <th>Office</th>
                           <th>Approximate Cost</th>
                           <th>Department</th>
                           <th>Priority</th>
                           <th>TS No/ Date</th>
                           <th>AS No/ date</th>
                           <th>Type of work</th>
                           <th>Sub Work Type</th>
                           <th>Middle Men</th>
                           <th>Contact No</th>
                           <th>Beneficial</th>
                           <th>PO</th>
                           <th>Beneficially Mobile</th>
                           <th>Status</th>
                           <th>Remark/ GOSHANA <br> ( भईया द्वारा दिए गए निर्देश )</th>
                           <th>REMARK / TIP/ USD</th>
                           <th>Added By</th>
                           <th>lat-lng</th>
                           <th>Registration Date</th>
                           <th>Avedan</th>
                           <th class="text-center">Actions</th>
                        </tr>
                     </thead>
                     <tbody></tbody>
                    
                  </table>
               </div>
            </div>
            <!-- /.box -->
         </div>
      </div>
   </section>
</div>
<style>
   button.dt-button.buttons-excel.buttons-html5 {
   left: 3px !important;
   }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.2.2/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<!--<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">-->
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.colVis.min.js"></script>
<script>
$(document).ready(function() {
    const table = $('#feedbackTa').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?php echo base_url('user/jansunwaidata'); ?>",
            type: "POST",
            data: function (d) {
                d.list_variant = "ajax_simple";
            }
        },
        dom: '<"top"lfB>rt<"bottom"ip>',
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Export Excel',
                title: 'List'
            },
            {
                extend: 'colvis',
                text: 'Show/Hide Columns',
                titleAttr: 'Show/Hide Columns'
            }
        ],
        lengthMenu: [
            [10, 25, 50, 75, -1],
            [10, 25, 50, 75, "All"]
        ],
        order: [], // Prevent default ordering
         columnDefs: [
            {
                targets: '_all', // apply to all columns
                orderable: false // disable ordering
            }
        ],
        rowCallback: function(row, data, index) {
            // Extract record ID from the row data
            // The ID should be in the last column or we need to modify the response
            // For now, we'll extract it from the action buttons or add it as a hidden column
            // We'll modify the controller to include ID in a way we can access it
            // Since DT_RowData might not work, let's use a different approach
            // We'll add the ID as a data attribute in the rowCallback
            var recordId = null;
            var stage = 1; // Default stage for jansunwailistajax
            
            // Try to extract ID from the row HTML or data
            // The action buttons contain the ID, so we can extract it
            var actionCell = $(row).find('td:last-child');
            var viewLink = actionCell.find('a[href*="jansunwaicommentview"]');
            if (viewLink.length > 0) {
                var href = viewLink.attr('href');
                var match = href.match(/jansunwaicommentview\/(\d+)/);
                if (match) {
                    recordId = match[1];
                }
            }
            
            if (recordId) {
                $(row).addClass('clickable-row').attr('data-id', recordId).attr('data-stage', stage).css('cursor', 'pointer');
            }
        },
        
        drawCallback: function() {
            startLiveTimers(); // Attach live timers after draw
        }
    });

    function startLiveTimers() {
        const timers = document.querySelectorAll('.live-timer');
        timers.forEach(span => {
            const createdAt = parseInt(span.dataset.createdAt);
            if (!createdAt) return;

            const interval = setInterval(() => {
                const now = Date.now();
                let diff = now - createdAt;
                if (diff < 0) diff = 0;

                const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                span.innerHTML = `${days}d, ${hours}h, ${minutes}m, ${seconds}s`;
            }, 1000);
        });
    }
    
    // Make rows clickable (excluding action buttons) - use event delegation for dynamically loaded rows
    $(document).on('click', '#feedbackTa tbody tr.clickable-row', function(e) {
        // Don't trigger if clicking on action buttons or links
        if ($(e.target).closest('a, button').length) {
            return;
        }
        
        var recordId = $(this).data('id');
        var stage = $(this).data('stage') || 1;
        
        $('#commentRecordId').val(recordId);
        $('#commentStage').val(stage);
        
        // Show modal
        $('#recordModal').modal('show');
        
        // Load record details
        loadRecordDetails(recordId);
    });
    
    function loadRecordDetails(id) {
        $('#recordData').html('<div class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...</div>');
        $('#commentsList').html('<div class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading comments...</div>');
        
        $.ajax({
            url: '<?php echo base_url("user/get_jansunwai_details/"); ?>' + id,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    displayRecordData(response.record);
                    displayComments(response.comments);
                } else {
                    $('#recordData').html('<div class="alert alert-danger">' + response.message + '</div>');
                }
            },
            error: function() {
                $('#recordData').html('<div class="alert alert-danger">Error loading record details</div>');
            }
        });
    }
    
    function displayRecordData(record) {
        var months = {
            1: 'January', 2: 'February', 3: 'March', 4: 'April',
            5: 'May', 6: 'June', 7: 'July', 8: 'August',
            9: 'September', 10: 'October', 11: 'November', 12: 'December'
        };
        
        var monthName = months[record.month] || record.month;
        
        var statusBadge = '';
        if (record.work_status == "Complete") {
            statusBadge = '<span class="label label-success">' + record.work_status + '</span>';
        } else if (record.work_status == "Incomplete") {
            statusBadge = '<span class="label label-danger">' + record.work_status + '</span>';
        } else if (record.work_status == "In progress") {
            statusBadge = '<span class="label label-warning">' + record.work_status + '</span>';
        } else if (record.work_status == "Reject") {
            statusBadge = '<span class="label label-default" style="background-color: #d73925; color: white;">' + record.work_status + '</span>';
        }
        
        var html = '<div class="row">' +
            '<div class="col-md-6"><strong>Registration No:</strong> ' + (record.registration_no || 'N/A') + '</div>' +
            '<div class="col-md-6"><strong>Sector Name:</strong> ' + (record.sector_name || 'N/A') + '</div>' +
            '<div class="col-md-6"><strong>Micro Sector No:</strong> ' + (record.micro_sector_no || 'N/A') + '</div>' +
            '<div class="col-md-6"><strong>Micro Sector Name:</strong> ' + (record.micro_sector_name || 'N/A') + '</div>' +
            '<div class="col-md-6"><strong>Year:</strong> ' + (record.year || 'N/A') + '</div>' +
            '<div class="col-md-6"><strong>Month:</strong> ' + (monthName || 'N/A') + '</div>' +
            '<div class="col-md-6"><strong>Date:</strong> ' + (record.date || 'N/A') + '</div>' +
            '<div class="col-md-6"><strong>District:</strong> ' + (record.district || 'N/A') + '</div>' +
            '<div class="col-md-6"><strong>Assembly:</strong> ' + (record.assembly || 'N/A') + '</div>' +
            '<div class="col-md-6"><strong>Block:</strong> ' + (record.block_name || 'N/A') + '</div>' +
            '<div class="col-md-6"><strong>Recommended Letter No:</strong> ' + (record.recommended_letter_no || 'N/A') + '</div>' +
            '<div class="col-md-6"><strong>Booth No:</strong> ' + (record.booth_number || 'N/A') + '</div>' +
            '<div class="col-md-6"><strong>Booth Name:</strong> ' + (record.booth_name || 'N/A') + '</div>' +
            '<div class="col-md-6"><strong>Panchayat Name:</strong> ' + (record.panchayat_name || 'N/A') + '</div>' +
            '<div class="col-md-6"><strong>Village:</strong> ' + (record.village_name || 'N/A') + '</div>' +
            '<div class="col-md-6"><strong>Majra/Faliya:</strong> ' + (record.majra_faliya || 'N/A') + '</div>' +
            '<div class="col-md-6"><strong>Office:</strong> ' + (record.office || 'N/A') + '</div>' +
            '<div class="col-md-6"><strong>Approximate Cost:</strong> ' + (record.approximate_cost || 'N/A') + '</div>' +
            '<div class="col-md-6"><strong>Department:</strong> ' + (record.department_name || 'N/A') + '</div>' +
            '<div class="col-md-6"><strong>Priority:</strong> ' + (record.priority || 'N/A') + '</div>' +
            '<div class="col-md-6"><strong>TS No/ Date:</strong> ' + (record.ts_no_date || 'N/A') + '</div>' +
            '<div class="col-md-6"><strong>AS No/ date:</strong> ' + (record.as_no_date || 'N/A') + '</div>' +
            '<div class="col-md-6"><strong>Type of work:</strong> ' + (record.type_of_work || 'N/A') + '</div>' +
            '<div class="col-md-6"><strong>Sub Work Type:</strong> ' + (record.sub_work_type_name || 'N/A') + '</div>' +
            '<div class="col-md-6"><strong>Middle Men:</strong> ' + (record.middle_men || 'N/A') + '</div>' +
            '<div class="col-md-6"><strong>Contact No:</strong> ' + (record.cont_no || 'N/A') + '</div>' +
            '<div class="col-md-6"><strong>Beneficial:</strong> ' + (record.beneficial || 'N/A') + '</div>' +
            '<div class="col-md-6"><strong>PO:</strong> ' + (record.po || 'N/A') + '</div>' +
            '<div class="col-md-6"><strong>Status:</strong> ' + statusBadge + '</div>' +
            '<div class="col-md-6"><strong>Beneficially Mobile:</strong> ' + (record.mobile || 'N/A') + '</div>' +
            '<div class="col-md-6"><strong>Lat-Lng:</strong> ' + (record.lat || 'N/A') + ', ' + (record.lng || 'N/A') + '</div>' +
            '<div class="col-md-6"><strong>Registration Date:</strong> ' + (record.createdAt || 'N/A') + '</div>' +
            '<div class="col-md-12"><strong>Work/Problem:</strong> ' + (record.work_problem || 'N/A') + '</div>' +
            '<div class="col-md-12"><strong>Remark/ GOSHANA:</strong> ' + (record.remark_goshana || 'N/A') + '</div>' +
            '<div class="col-md-12"><strong>REMARK / TIP/ USD:</strong> ' + (record.remark || 'N/A') + '</div>' +
            '<div class="col-md-6"><strong>Added By:</strong> ' + (record.added_by_name || 'N/A') + '</div>';
        
        if (record.uploaded_file) {
            html += '<div class="col-md-6"><strong>Avedan:</strong> <a href="<?php echo base_url(); ?>uploads/' + record.uploaded_file + '" target="_blank" class="btn btn-sm btn-info">View File</a></div>';
        }
        
        html += '</div>';
        
        $('#recordData').html(html);
    }
    
    function displayComments(comments) {
        if (!comments || comments.length === 0) {
            $('#commentsList').html('<div class="alert alert-info">No comments yet.</div>');
            return;
        }
        
        var html = '<table class="table table-bordered table-striped">' +
            '<thead><tr><th>Date</th><th>Comment</th><th>File</th><th>Status</th><th>Comment By</th></tr></thead>' +
            '<tbody>';
        
        comments.forEach(function(comment) {
            var statusBadge = '';
            if (comment.status == "Complete") {
                statusBadge = '<span class="label label-success">' + comment.status + '</span>';
            } else if (comment.status == "Incomplete") {
                statusBadge = '<span class="label label-danger">' + comment.status + '</span>';
            } else if (comment.status == "In progress") {
                statusBadge = '<span class="label label-warning">' + comment.status + '</span>';
            } else if (comment.status == "Reject") {
                statusBadge = '<span class="label label-default" style="background-color: #d73925; color: white;">' + comment.status + '</span>';
            } else {
                statusBadge = comment.status || 'N/A';
            }
            
            var fileLink = comment.fileupload ? 
                '<a href="<?php echo base_url(); ?>uploads/' + comment.fileupload + '" target="_blank">View file</a>' : 
                'NA';
            
            html += '<tr>' +
                '<td>' + (comment.createdAt || 'N/A') + '</td>' +
                '<td>' + (comment.comment || 'N/A') + '</td>' +
                '<td>' + fileLink + '</td>' +
                '<td>' + statusBadge + '</td>' +
                '<td>' + (comment.userName || 'N/A') + '</td>' +
                '</tr>';
        });
        
        html += '</tbody></table>';
        $('#commentsList').html(html);
    }
    
    // Handle comment form submission
    $('#commentForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        
        $.ajax({
            url: '<?php echo base_url("user/add_comment_ajax"); ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    $('#commentForm')[0].reset();
                    displayComments(response.comments);
                    // Reload page to refresh status
                    location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('Error submitting comment. Please try again.');
            }
        });
    });
});
</script>

<!-- Modal for Viewing Record Details and Comments -->
<div class="modal fade" id="recordModal" tabindex="-1" role="dialog" aria-labelledby="recordModalLabel">
    <div class="modal-dialog modal-lg" role="document" style="width: 90%; max-width: 1200px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="recordModalLabel">Public Problem Details</h4>
            </div>
            <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                <!-- Record Details Section -->
                <div id="recordDetails" style="margin-bottom: 30px;">
                    <h4 style="border-bottom: 2px solid #3c8dbc; padding-bottom: 10px; margin-bottom: 20px;">Record Information</h4>
                    <div class="row" id="recordData">
                        <!-- Data will be loaded here via AJAX -->
                        <div class="text-center">
                            <i class="fa fa-spinner fa-spin fa-2x"></i> Loading...
                        </div>
                    </div>
                </div>
                
                <!-- Comments Section -->
                <div id="commentsSection" style="margin-top: 30px; border-top: 2px solid #3c8dbc; padding-top: 20px;">
                    <h4 style="border-bottom: 2px solid #3c8dbc; padding-bottom: 10px; margin-bottom: 20px;">Comments</h4>
                    
                    <!-- Existing Comments -->
                    <div id="commentsList" style="margin-bottom: 30px; max-height: 300px; overflow-y: auto;">
                        <!-- Comments will be loaded here -->
                    </div>
                    
                    <!-- Add Comment Form -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5 class="panel-title">Add New Comment</h5>
                        </div>
                        <div class="panel-body">
                            <form id="commentForm" enctype="multipart/form-data">
                                <input type="hidden" id="commentRecordId" name="id">
                                <input type="hidden" id="commentStage" name="stage">
                                
                                <div class="form-group">
                                    <label for="commentText">Comment <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="commentText" name="comment" rows="4" required></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="commentStatus">Status <span class="text-danger">*</span></label>
                                    <select class="form-control" id="commentStatus" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="Incomplete">Incomplete</option>
                                        <option value="In progress">In progress</option>
                                        <option value="Complete">Complete</option>
                                        <option value="Reject">Reject</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="commentFile">File Upload (Optional)</label>
                                    <input type="file" class="form-control" id="commentFile" name="file_upload">
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Add Comment
                                </button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.clickable-row:hover {
    background-color: #f5f5f5 !important;
}
#recordModal .modal-body {
    padding: 20px;
}
#recordModal .row {
    margin-bottom: 10px;
}
#recordModal strong {
    color: #3c8dbc;
}
</style>
 