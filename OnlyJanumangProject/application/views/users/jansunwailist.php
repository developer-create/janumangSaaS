<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <i class="fa fa-users"></i> Public Problems Management
         <a href="<?php echo site_url('user/jansunwai_bulk_upload'); ?>" class="btn btn-info btn-sm" style="float: right; margin-left: 5px;">
            <i class="fa fa-upload"></i> Bulk Upload
         </a>
         <a href="<?php echo site_url('user/addNewJansunwai'); ?>" class="btn btn-success btn-sm" style="float: right;">
            <i class="fa fa-plus"></i> Add New Entry
         </a>
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
            <?php }
               ?>
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
            <?php $f = isset($filters) ? $filters : []; ?>
            <form id="jansunwaiFilterForm" method="post" action="<?php echo base_url(
               "user/jansunwai"
               ); ?>">
               <div class="row">
                   <div class="col-md-2">
                     <div class="form-group">
                        <label for="department">Department</label>
                        <select name="department" id="department" class="form-control">
                           <option value="">Select Department</option>
                           <?php 
                              $department = $this->db->get("department")->result();
                              foreach ($department as $blk) {
                                  $sel = (isset($f['department']) && (string)$f['department'] === (string)$blk->id) ? ' selected' : '';
                                  echo "<option value='{$blk->id}'{$sel}>{$blk->name}</option>";
                              }
                              ?>  
                        </select>
                     </div>
                  </div>
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
                                  $sel = (isset($f['block']) && (string)$f['block'] === (string)$blk->id) ? ' selected' : '';
                                  echo "<option value='{$blk->id}'{$sel}>{$blk->name}</option>";
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
                                  $sel = (isset($f['year']) && (string)$f['year'] === (string)$fy) ? ' selected' : '';
                                  echo "<option value='{$fy}'{$sel}>{$fy}</option>";
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
                                  $sel = (isset($f['month']) && (string)$f['month'] === (string)$key) ? ' selected' : '';
                                  echo "<option value='{$key}'{$sel}>{$value}</option>";
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
                                  $sel = (isset($f['work_status']) && (string)$f['work_status'] === (string)$key) ? ' selected' : '';
                                  echo "<option value='{$key}'{$sel}>{$value}</option>";
                              }
                              ?>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-2">
                     <div class="form-group">
                        <label for="approved_fund">Approved Fund</label>
                        <select name="approved_fund" id="approved_fund" class="form-control">
                           <option value="">Select Fund</option>
                           <?php
                              $fund_options = ['MLA FUND', 'MLA Swechanudan', 'CLP Swechanudan', 'Jansampark Fund'];
                              foreach ($fund_options as $fund) {
                                  $sel = (isset($f['approved_fund']) && (string)$f['approved_fund'] === (string)$fund) ? ' selected' : '';
                                  echo "<option value='{$fund}'{$sel}>{$fund}</option>";
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
               
               <!-- Tab Navigation -->
               <ul class="nav nav-tabs" role="tablist">
                     <li role="presentation" class="active">
                        <a href="#all-records" aria-controls="all-records" role="tab" data-toggle="tab" data-tab="all">All Records</a>
                     </li>
                     <li role="presentation">
                        <a href="#approval-records" aria-controls="approval-records" role="tab" data-toggle="tab" data-tab="approval">Approval</a>
                     </li>
                     <li role="presentation">
                        <a href="#complete-records" aria-controls="complete-records" role="tab" data-toggle="tab" data-tab="complete">Complete</a>
                     </li>
                     <li role="presentation">
                        <a href="#incomplete-records" aria-controls="incomplete-records" role="tab" data-toggle="tab" data-tab="incomplete">Incomplete</a>
                     </li>
                     <li role="presentation">
                        <a href="#inprogress-records" aria-controls="inprogress-records" role="tab" data-toggle="tab" data-tab="inprogress">In Progress</a>
                     </li>
                     <li role="presentation">
                        <a href="#reject-records" aria-controls="reject-records" role="tab" data-toggle="tab" data-tab="reject">Reject</a>
                     </li>
                  </ul>

                  <!-- Tab Content -->
                  <div class="tab-content">
                     <div role="tabpanel" class="tab-pane active" id="all-records">
                        <br>
                        <p class="text-info">Showing All Records</p>
                     </div>
                     <div role="tabpanel" class="tab-pane" id="approval-records">
                        <br>
                        <p class="text-info">Showing Approval Records (Complete status only)</p>
                     </div>
                     <div role="tabpanel" class="tab-pane" id="complete-records">
                        <br>
                        <p class="text-info">Showing Complete Records</p>
                     </div>
                     <div role="tabpanel" class="tab-pane" id="incomplete-records">
                        <br>
                        <p class="text-info">Showing Incomplete Records</p>
                     </div>
                     <div role="tabpanel" class="tab-pane" id="inprogress-records">
                        <br>
                        <p class="text-info">Showing In Progress Records</p>
                     </div>
                     <div role="tabpanel" class="tab-pane" id="reject-records">
                        <br>
                        <p class="text-info">Showing Reject Records</p>
                     </div>
                  </div>
                  
                  <!-- Main Data Table (Always Visible) -->
                  <div class="table-responsive no-padding" style="margin-top: 15px;">
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
                           <th style="width:300px !important;">Work/Problem</th>
                           <th>Office</th>
                           <th>Approximate Cost</th>
                           <th>Department</th>
                           <th>Approved Fund</th>
                           <th>Work Agency</th>
                           <th>Priority</th>
                           <th>TS No/ Date</th>
                           <th>AS No/ date</th>
                           <th>Type of work</th>
                           <th>Sub Work Type</th>
                           <th>Middle Man</th>
                           <th>Contact No</th>
                           <th>Beneficial Name</th>
                           <th>Beneficial Post</th>
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
                     <tbody>
                        <?php if (isset($userRecords) && !empty($userRecords)) {
                           $i = 1;
                           foreach ($userRecords as $key => $record) {
                           /* Legacy path (e.g. filterJansunwai): full list rendered server-side */
                           
                               $createdAt = new DateTime($record->createdAt);
                               $updatedAt = isset($record->updatedAt)
                                   ? new DateTime($record->updatedAt)
                                   : null; // Check if updatedAt is available
                               $currentTime = new DateTime();
                               $timeDifference = $currentTime->diff($createdAt);
                              // $isWithin24Hours =$timeDifference->days == 0 && $timeDifference->h < 48;
                                   $timeDifferenceInSeconds = $currentTime->getTimestamp() - $createdAt->getTimestamp();
                                    $isWithin24Hours = $timeDifferenceInSeconds < (72 * 60 * 60); // 48 hours in seconds


                               $expireTimestamp = $createdAt->getTimestamp() * 1000; // Default to createdAt for timer
                           
                               $timeDiffText = "";
                               // If the work status is Complete, calculate time difference between createdAt and updatedAt
                               if ($record->work_status == "Complete" && $updatedAt) {
                                   $timeDifference = $updatedAt->diff($createdAt); // Difference between createdAt and updatedAt
                                   // Pass time difference to display in a different format (or just show the text)
                                   $timeDiffText = $timeDifference->format(
                                       "%dd, %hh, %im, %ss"
                                   );
                               }
                               ?>
                        <tr class="clickable-row" data-id="<?php echo $record->id; ?>" data-stage="1" style="cursor: pointer;">
                           <td><?php echo $i++; ?></td>
                           <td><?php echo $record->registration_no; ?></td>
                           <?php if ($record->work_status == "Complete") { ?>
                           <td><b style="color: red;"><?php echo $timeDiffText; ?></b></td>
                           <?php } else { ?>
                           <td id="timer-<?php echo $i; ?>" <?php echo $record->work_status ==
                              "Complete"
                                  ? 'style="display:block;"'
                                  : ""; ?> data-created-at="<?php echo $expireTimestamp; ?>">
                              <b style="color: red;"></b>  
                           </td>
                           <?php } ?>
                           <td><?php echo $record->sector_name; ?></td>
                           <td><?php echo $record->micro_sector_no; ?></td>
                           <td><?php echo $record->micro_sector_name; ?></td>
                           <td><?php echo $record->year; ?></td>
                           <?php
                              $months = [
                                  1 => 'January',
                                  2 => 'February',
                                  3 => 'March',
                                  4 => 'April',
                                  5 => 'May',
                                  6 => 'June',
                                  7 => 'July',
                                  8 => 'August',
                                  9 => 'September',
                                  10 => 'October',
                                  11 => 'November',
                                  12 => 'December',
                              ];
                              
                              $monthName = $record->month; // Ensure $record->month is defined
                              $monthNumber = $months[$monthName] ?? 'N/A'; // Map month name to number or default to 'N/A'
                              ?>
                           <td><?php echo $monthNumber; ?></td>
                           <td><?php echo $record->date; ?></td>
                           <td><?php echo $record->district; ?></td>
                           <td><?php echo $record->assembly; ?></td>
                           <td><?php echo @$record->block_name; ?></td>
                           <td><?php echo $record->recommended_letter_no; ?></td>
                           <td><?php echo @$record->booth_number; ?></td>
                           <td><?php echo $record->booth_name; ?></td>
                           <td><?php echo @$record->panchayat_name; ?></td>
                           <td><?php echo @$record->village_name; ?></td>
                           <td><?php echo @$record->majra_faliya; ?></td>
                           <td style="width:200px !important;"><?php echo $record->work_problem; ?></td>
                           <td><?php echo $record->office; ?></td>
                           <td><?php echo @$record->approximate_cost; ?></td>
                           <td><?php echo @$record->department_name; ?></td>
                           <td><?php echo !empty($record->approved_fund) ? $record->approved_fund : '-'; ?></td>
                           <td><?php echo !empty($record->work_agency) ? $record->work_agency : '-'; ?></td>
                           <td><?php echo $record->priority; ?></td>
                           <td><?php echo $record->ts_no_date; ?></td>
                           <td><?php echo $record->as_no_date; ?></td>
                           <td><?php echo $record->type_of_work; ?></td>
                           <td><?php echo isset($record->sub_work_type_name) ? $record->sub_work_type_name : '-'; ?></td>
                           <td><?php echo $record->middle_men; ?></td>
                           <td><?php echo $record->cont_no; ?></td>
                           <td><?php echo $record->beneficial; ?></td>
                           <td><?php echo $record->po; ?></td>
                           <td><?php echo @$record->mobile; ?></td>
                           <td>
                              <?php if ($record->work_status == "Complete") {
                                 echo '<span class="label label-success">' .
                                     $record->work_status .
                                     "</span>";
                                 } elseif ($record->work_status == "Incomplete") {
                                 echo '<span class="label label-danger">' .
                                     $record->work_status .
                                     "</span>";
                                 } elseif ($record->work_status == "In progress") {
                                 echo '<span class="label label-warning">' .
                                     $record->work_status .
                                     "</span>";
                                 } elseif ($record->work_status == "Reject") {
                                 echo '<span class="label label-default" style="background-color: #d73925; color: white;">' .
                                     $record->work_status .
                                     "</span>";
                                 } else {
                                 //   echo '<span class="label label-default">Unknown</span>';
                                 } ?>
                           </td>
                           <td><?php echo @$record->remark_goshana; ?></td>
                           <td><?php echo @$record->remark; ?></td>
                           <td><?php echo @$record->added_by_name; ?></td>
                           <td>
                              <?php echo @$record->lat; ?> <br>
                              <?php echo @$record->lng; ?>
                           </td>
                           <td><?php echo @$record->createdAt; ?></td>
                           <td>
                              <?php if (!empty($record->uploaded_file)): ?>
                              <a class="btn btn-sm btn-info" 
                                 href="<?php echo base_url() .
                                    "uploads/" .
                                    $record->uploaded_file; ?>" 
                                 title="Image" target="_blank">View File</a>
                              <?php else: ?>
                              <span>No File Uploaded</span>
                              <?php endif; ?>
                           </td>
                           <td class="text-center">
                              <a class="btn btn-sm btn-info" href="<?php echo base_url() .
                                 "user/jansunwaicommentview/" .
                                 $record->id; ?>" title="View Comment"><i class="fa fa-eye" aria-hidden="true"></i></a>
                              <a class="btn btn-sm btn-success  <?php echo !$isWithin24Hours
                                 ? "disabled"
                                 : ""; ?>"    href="<?php echo base_url() .
                                 "user/submit_form/" .
                                 $record->id; ?>/1"  data-userid="<?php echo $record->id; ?>" title="Add Comment"><i class="fa fa-edit"></i></a>
                              <a class="btn btn-sm btn-warning" href="<?php echo base_url() .
                                 "user/editJansunwai/" .
                                 $record->id; ?>" title="Edit"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                  <a class="btn btn-sm btn-danger" href="<?php echo base_url().'user/delete_jansunwai/'.$record->id; ?>" onclick="return confirm('Are you sure you want to delete this record?');" title="Delete">
    <i class="fa fa-trash"></i>
</a>
                           </td>
                        </tr>
                        <?php
                           }
                           } ?>
                     </tbody>
                  </table>
                  </div>
               </div>
            </div>
            <!-- /.box -->
         </div>
      </div>
   </section>
</div>
<?php if (isset($userRecords)) { ?>
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
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.colVis.min.js"></script>
<script>
$.fn.dataTable.ext.search.push(
    function(settings, data, dataIndex) {
        if (settings.nTable.id !== 'feedbackTa') {
            return true;
        }
        var activeTab = $('ul.nav-tabs li.active a').attr('data-tab');
        if (activeTab === 'all') {
            return true;
        } else if (activeTab === 'approval' || activeTab === 'complete') {
            for (var i = 0; i < data.length; i++) {
                var cellData = data[i] || '';
                if (cellData.indexOf('label-success') !== -1 || cellData.indexOf('Complete') !== -1) {
                    return true;
                }
            }
            return false;
        } else if (activeTab === 'incomplete') {
            for (var i = 0; i < data.length; i++) {
                var cellData = data[i] || '';
                if (cellData.indexOf('label-danger') !== -1 || cellData.indexOf('Incomplete') !== -1) {
                    return true;
                }
            }
            return false;
        } else if (activeTab === 'inprogress') {
            for (var i = 0; i < data.length; i++) {
                var cellData = data[i] || '';
                if (cellData.indexOf('label-warning') !== -1 || cellData.indexOf('In progress') !== -1) {
                    return true;
                }
            }
            return false;
        } else if (activeTab === 'reject') {
            for (var i = 0; i < data.length; i++) {
                var cellData = data[i] || '';
                if (cellData.indexOf('d73925') !== -1 || cellData.indexOf('Reject') !== -1) {
                    return true;
                }
            }
            return false;
        }
        return true;
    }
);
   $(document).ready(function() {
        var table = $('#feedbackTa').DataTable({
           "processing": true,
           "serverSide": false,
           "dom": '<"top"lfB>rt<"bottom"ip>',
           "buttons": [
               {
                   extend: 'excelHtml5',
                   text: 'Export Excel',
                   title: 'Public Problems List'
               },
                {
                   extend: 'colvis',
                   text: 'Show/Hide Columns',
                   titleAttr: 'Show/Hide Columns'
               }
           ],
           "paging": true,
           "searching": true,
           "ordering": false,
           "info": true,
           "lengthMenu": [
               [10, 25, 50, 75, -1],
               [10, 25, 50, 75, "All"]
           ]
       });
       $('ul.nav-tabs a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
           $('ul.nav-tabs li').removeClass('active');
           $(this).parent().addClass('active');
           table.draw();
       });
   });
</script>
<script>
   document.addEventListener("DOMContentLoaded", function() {
       function updateTimers() {
           const now = new Date().getTime();
           document.querySelectorAll("td[id^='timer-']").forEach(timer => {
               const createdAt = parseInt(timer.getAttribute("data-created-at"), 10);
               const timeElapsed = now - createdAt;
               const days = Math.floor(timeElapsed / (1000 * 60 * 60 * 24));
               const hours = Math.floor((timeElapsed % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
               const minutes = Math.floor((timeElapsed % (1000 * 60 * 60)) / (1000 * 60));
               const seconds = Math.floor((timeElapsed % (1000 * 60)) / 1000);
               timer.innerHTML = `<b style="color: red;">${days}d ${hours.toString().padStart(2, '0')}h:${minutes.toString().padStart(2, '0')}m:${seconds.toString().padStart(2, '0')}s</b>`;
           });
       }
       setInterval(updateTimers, 1000);
       updateTimers();
   });
</script>
<?php } else { ?>
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
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.colVis.min.js"></script>
<script>
$(document).ready(function() {
    var liveTimerTick = null;
    function startLiveTimers() {
        if (liveTimerTick) {
            clearInterval(liveTimerTick);
        }
        function tick() {
            var now = Date.now();
            document.querySelectorAll('.live-timer').forEach(function(span) {
                var createdAt = parseInt(span.getAttribute('data-created-at'), 10);
                if (!createdAt) return;
                var diff = now - createdAt;
                if (diff < 0) diff = 0;
                var days = Math.floor(diff / (1000 * 60 * 60 * 24));
                var hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((diff % (1000 * 60)) / 1000);
                span.innerHTML = '<b style="color: red;">' + days + 'd ' +
                    (hours < 10 ? '0' : '') + hours + 'h:' +
                    (minutes < 10 ? '0' : '') + minutes + 'm:' +
                    (seconds < 10 ? '0' : '') + seconds + 's</b>';
            });
        }
        tick();
        liveTimerTick = setInterval(tick, 1000);
    }

    var table = $('#feedbackTa').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?php echo base_url('user/jansunwaidata'); ?>",
            type: "POST",
            data: function(d) {
                d.filter_block = $('#block').val();
                d.filter_year = $('#year').val();
                d.filter_month = $('#month').val();
                d.filter_department = $('#department').val();
                d.filter_approved_fund = $('#approved_fund').val();
                d.filter_work_status = $('#work_status').val();
                d.filter_tab = $('ul.nav-tabs li.active a').data('tab') || 'all';
                d.list_variant = 'full';
            }
        },
        dom: '<"top"lfB>rt<"bottom"ip>',
        buttons: [
            { extend: 'excelHtml5', text: 'Export Excel', title: 'Public Problems List' },
            { extend: 'colvis', text: 'Show/Hide Columns', titleAttr: 'Show/Hide Columns' }
        ],
        lengthMenu: [[10, 25, 50, 75, -1], [10, 25, 50, 75, "All"]],
        order: [],
        columnDefs: [{ targets: '_all', orderable: false }],
        rowCallback: function(row) {
            var viewLink = $(row).find('a[href*="jansunwaicommentview"]');
            if (viewLink.length) {
                var href = viewLink.attr('href');
                var match = href.match(/jansunwaicommentview\/(\d+)/);
                if (match) {
                    $(row).addClass('clickable-row').attr('data-id', match[1]).attr('data-stage', 1).css('cursor', 'pointer');
                }
            }
        },
        drawCallback: function() {
            startLiveTimers();
        }
    });

    $('#jansunwaiFilterForm').on('submit', function(e) {
        e.preventDefault();
        table.ajax.reload();
    });

    $('ul.nav-tabs a[data-toggle="tab"]').on('shown.bs.tab', function() {
        $('ul.nav-tabs li').removeClass('active');
        $(this).parent().addClass('active');
        table.ajax.reload();
    });
});
</script>
<?php } ?>

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

<script>
$(document).ready(function() {
    var currentRecordId = null;
    var currentStage = null;
    
    // Make rows clickable (excluding action buttons)
    $(document).on('click', '.clickable-row', function(e) {
        // Don't trigger if clicking on action buttons or links
        if ($(e.target).closest('a, button').length) {
            return;
        }
        
        var recordId = $(this).data('id');
        var stage = $(this).data('stage');
        currentRecordId = recordId;
        currentStage = stage;
        
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