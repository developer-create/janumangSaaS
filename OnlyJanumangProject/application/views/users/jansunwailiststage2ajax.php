<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <i class="fa fa-users"></i> Public Problems Management - Stage 2
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
               $this->load->helper("financial_year");
               $error = $this->session->flashdata("error");
               if ($error) { ?>
            <div class="alert alert-danger alert-dismissable">
               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
               <?php echo $this->session->flashdata("error"); ?>                    
            </div>
            <?php } ?>
            <?php
               $success = $this->session->flashdata("success");
               if ($success) { ?>
            <div class="alert alert-success alert-dismissable">
               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
               <?php echo $this->session->flashdata("success"); ?>
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
         <!-- Filter Form -->
         <div class="col-xs-12">
            <form method="post" id="stage2FilterForm">
               <div class="row">
                  <div class="col-md-2">
                     <div class="form-group">
                        <label for="block">Block</label>
                        <select name="block" id="block" class="form-control">
                           <option value="">Select Block</option>
                           <?php
                              $userid = $this->session->userdata("userId");
                              $sessionBlockId = $this->session->userdata("blockId");
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
                           $financial_years = get_financial_years(2008, 2027);
                        ?>
                        <select name="year" id="year" class="form-control">
                           <option value="">Select Financial Year</option>
                           <?php
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
                           <option value="Incomplete">Incomplete</option>
                           <option value="In progress">In progress</option>
                           <option value="Complete">Complete</option>
                           <option value="Reject">Reject</option>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-2">
                     <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary form-control">Filter</button>
                     </div>
                  </div>
                  <div class="col-md-2">
                     <div class="form-group">
                        <label>&nbsp;</label>
                        <a href="<?php echo base_url('user/jansunwai2'); ?>" class="btn btn-default form-control"><i class="fa fa-refresh"></i> Reset</a>
                     </div>
                  </div>
               </div>
            </form>
         </div>
      </div>
      <div class="row">
         <div class="col-xs-12">
            <div class="box">
               <div class="box-header">
                  <h3 class="box-title">Stage 2 - Public Problems List</h3>
               </div>
               <div class="box-body table-responsive">
                  <table id="stage2Table" class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>Sr No</th>
                           <th>Regi No</th>
                           <th>Timer</th>
                           <th>Sector</th>
                           <th>Micro Sector No</th>
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
                           <th>Village</th>
                           <th>Majra/Faliya</th>
                           <th>Work Problem</th>
                           <th>Office</th>
                           <th>Approx Cost</th>
                           <th>Department</th>
                           <th>Approved Fund</th>
                           <th>Work Agency</th>
                           <th>Priority</th>
                           <th>TS No/Date</th>
                           <th>AS No/Date</th>
                           <th>Type of Work</th>
                           <th>Sub Work Type</th>
                           <th>Middle Men</th>
                           <th>Contact No</th>
                           <th>Beneficial</th>
                           <th>PO</th>
                           <th>Status</th>
                           <th>Remark Goshana</th>
                           <th>Remark</th>
                           <th>Added By</th>
                           <th>Mobile</th>
                           <th>Lat/Lng</th>
                           <th>Created At</th>
                           <th>File</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </section>
</div>

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
    const table = $('#stage2Table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?php echo base_url('user/jansunwai2data'); ?>",
            type: 'POST',
            data: function(d) {
                d.filter_block = $('#block').val();
                d.filter_year = $('#year').val();
                d.filter_month = $('#month').val();
                d.filter_work_status = $('#work_status').val();
                d.stage = 2;
            }
        },
        columns: [
            { data: 0 },
            { data: 1 },
            { data: 2 },
            { data: 3 },
            { data: 4 },
            { data: 5 },
            { data: 6 },
            { data: 7 },
            { data: 8 },
            { data: 9 },
            { data: 10 },
            { data: 11 },
            { data: 12 },
            { data: 13 },
            { data: 14 },
            { data: 15 },
            { data: 16 },
            { data: 17 },
            { data: 18 },
            { data: 19 },
            { data: 20 },
            { data: 21 },
            { data: 22 },
            { data: 23 },
            { data: 24 },
            { data: 25 },
            { data: 26 },
            { data: 27 },
            { data: 28 },
            { data: 29 },
            { data: 30 },
            { data: 31 },
            { data: 32 },
            { data: 33 },
            { data: 34 },
            { data: 35 },
            { data: 36 },
            { data: 37 },
            { data: 38 },
            { data: 39 },
            { data: 40 },
            { data: 41 }
        ],
        order: [[1, 'desc']],
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    });

    // Filter form submission
    $('#stage2FilterForm').on('submit', function(e) {
        e.preventDefault();
        table.draw();
    });

    // Live timer update
    setInterval(function() {
        $('.live-timer').each(function() {
            const createdAtTimestamp = parseInt($(this).data('created-at'));
            const createdAt = new Date(createdAtTimestamp);
            const now = new Date();
            const diff = now - createdAt;
            
            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);
            
            $(this).find('b').text(days + 'd, ' + hours + 'h, ' + minutes + 'm, ' + seconds + 's');
        });
    }, 1000);
});
</script>
