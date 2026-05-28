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
                        <label for="department">Department</label>
                        <select name="department" id="department" class="form-control">
                           <option value="">Select Department</option>
                           <?php
                              $departments = $this->db->get("department")->result();
                              foreach ($departments as $dept) {
                                  echo "<option value='{$dept->id}'>{$dept->name}</option>";
                              }
                              ?>  
                        </select>
                     </div>
                  </div>
                  <div class="col-md-2">
                     <div class="form-group">
                        <label for="year">Year</label>
                        <select name="year" id="year" class="form-control">
                           <option value="">Select Year</option>
                           <?php
                              // Generate year options
                              $current_year = date("Y");
                              for ($i = $current_year; $i >= $current_year - 5; $i--) {
                                  echo "<option value='{$i}'>{$i}</option>";
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
                        <label for="approved_fund">Approved Fund</label>
                        <select name="approved_fund" id="approved_fund" class="form-control">
                           <option value="">Select Fund</option>
                           <?php
                              $fund_options = ['MLA FUND', 'MLA Swechanudan', 'CLP Swechanudan', 'Jansampark Fund'];
                              foreach ($fund_options as $fund) {
                                  echo "<option value='{$fund}'>{$fund}</option>";
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
                        <tr style="color:white;font-size:15px;background:#020254;">
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
                           <th>Panchayat</th>
                           <th>Gram</th>
                           <th>Faliya</th>
                           <th>Samasya</th>
                           <th>Office</th>
                           <th>Anumanit Lagat</th>
                           <th>Department</th>
                           <th>Priority</th>
                           <th>ts no date</th>
                           <th>as no date</th>
                           <th>type of work</th>
                           <th>Middle Men</th>
                           <th>Contact No</th>
                           <th>Beneficial</th>
                           <th>PO</th>
                           <th>Status</th>
                           <th>Added By</th>
                           <th>Name</th>
                           <th>Mobile</th>
                           <th>lat-lng</th>
                           <th>Registration Date</th>
                           <th>Avedan</th>
                           <th class="text-center">Actions</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php if (!empty($userRecords)) {
                           $i = 1;
                           foreach ($userRecords as $key => $record) {
                           
                               $createdAt = new DateTime($record->createdAt);
                               $updatedAt = isset($record->updatedAt)
                                   ? new DateTime($record->updatedAt)
                                   : null; // Check if updatedAt is available
                               $currentTime = new DateTime();
                               $timeDifference = $currentTime->diff($createdAt);
                               $isWithin24Hours =
                                   $timeDifference->days == 0 && $timeDifference->h < 48;
                               $expireTimestamp = $createdAt->getTimestamp() * 1000; // Default to createdAt for timer
                           
                               // If the work status is Complete, calculate time difference between createdAt and updatedAt
                               if ($record->work_status == "Complete" && $updatedAt) {
                                   $timeDifference = $updatedAt->diff($createdAt); // Difference between createdAt and updatedAt
                                   // Pass time difference to display in a different format (or just show the text)
                                   $timeDiffText = $timeDifference->format(
                                       "%dd, %hh, %im, %ss"
                                   );
                               }
                               ?>
                        <tr>
                           <td><?php echo $i++; ?></td>
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
                           <td> 
                              <?php
                                 $uid = $record->booth_no;
                                 if (!empty($record->joined_booth_name)) {
                                     $cc = $this->db->query("SELECT bnumber FROM booth WHERE id='$uid'");
                                     $Uu = $cc->row();
                                     echo !empty($Uu) ? $Uu->bnumber : $uid;
                                 } else {
                                     echo $uid;
                                 }
                                 ?>
                           </td>
                           <td><?php echo !empty($record->joined_booth_name) ? $record->joined_booth_name : $record->booth_name; ?></td>
                           <td><?php echo !empty($record->joined_panchayat_name) ? $record->joined_panchayat_name : $record->panchayat_name; ?></td>
                           <td><?php echo !empty($record->joined_village_name) ? $record->joined_village_name : $record->village; ?></td>
                           <td><?php echo @$record->majra_faliya; ?></td>
                           <td><?php echo $record->work_problem; ?></td>
                           <td><?php echo $record->office; ?></td>
                           <td><?php echo @$record->approximate_cost; ?></td>
                           <td>
                              <?php
                                 $uid = $record->department;
                                 
                                 $cc = $this->db->query(
                                     "SELECT * FROM `department` WHERE `id`='$uid'"
                                 );
                                 $Uu = $cc->row();
                                 if (!empty($Uu)) {
                                     echo $Uu->name;
                                 }
                                 ?>
                           </td>
                           <td><?php echo $record->priority; ?></td>
                           <td><?php echo $record->ts_no_date; ?></td>
                           <td><?php echo $record->as_no_date; ?></td>
                           <td><?php echo $record->type_of_work; ?></td>
                           <td><?php echo $record->middle_men; ?></td>
                           <td><?php echo $record->cont_no; ?></td>
                           <td><?php echo $record->beneficial; ?></td>
                           <td><?php echo $record->po; ?></td>
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
                                 } else {
                                 //   echo '<span class="label label-default">Unknown</span>';
                                 } ?>
                           </td>
                           <td>
                              <?php
                                 $uid = $record->createdBy;
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
                           <td><?php echo @$record->uname; ?></td>
                           <td><?php echo @$record->mobile; ?></td>
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
                                 $record->id; ?>" title="View Comments"><i class="fa fa-eye" aria-hidden="true"></i></a>
                              <a class="btn btn-sm btn-success  <?php echo !$isWithin24Hours
                                 ? "disabled"
                                 : ""; ?>"    href="<?php echo base_url() .
                                 "user/submit_form/" .
                                 $record->id; ?>/1"  data-userid="<?php echo $record->id; ?>" title="Add Comment"><i class="fa fa-comment"></i></a>
                              <a class="btn btn-sm btn-warning" href="<?php echo base_url() .
                                 "user/editJansunwai/" .
                                 $record->id; ?>" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
                              <a class="btn btn-sm btn-danger" href="<?php echo base_url() .
                                 "user/delete_jansunwai/" .
                                 $record->id; ?>" onclick="return confirm('Are you sure you want to delete this record?');" title="Delete"><i class="fa fa-trash"></i></a>
                           </td>
                        </tr>
                        <?php
                           }
                           } ?>
                     </tbody>
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
        $('#feedbackTa').DataTable({
           "processing": true,  
           "serverSide": false,  
           "dom": '<"top"lfB>rt<"bottom"ip>', 
           "buttons": [
               {
                   extend: 'excelHtml5',
                   text: 'Export Excel',
                   title: 'List'
               },
                {
                   extend: 'colvis',  // This adds the column visibility button
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
   });
</script>
<script>
   document.addEventListener("DOMContentLoaded", function() {
       function updateTimers() {
           const now = new Date().getTime();
           document.querySelectorAll("td[id^='timer-']").forEach(timer => {
               const createdAt = parseInt(timer.getAttribute("data-created-at"), 10);
               const timeElapsed = now - createdAt;
   
               // Calculate days, hours, minutes, and seconds
               const days = Math.floor(timeElapsed / (1000 * 60 * 60 * 24));
               const hours = Math.floor((timeElapsed % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
               const minutes = Math.floor((timeElapsed % (1000 * 60 * 60)) / (1000 * 60));
               const seconds = Math.floor((timeElapsed % (1000 * 60)) / 1000);
   
               // Display in format "DD:HH:MM:SS" with red color and bold tag
               timer.innerHTML = `<b style="color: red;">${days}d ${hours.toString().padStart(2, '0')}h:${minutes.toString().padStart(2, '0')}m:${seconds.toString().padStart(2, '0')}s</b>`;
           });
       }
       
       setInterval(updateTimers, 1000); // Update every second
       updateTimers(); // Initial call
   });
   
   
</script>