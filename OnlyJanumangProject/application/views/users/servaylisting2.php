<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Member Management
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
                <form method="post" action="<?php echo base_url('user/servaylisting'); ?>">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="block">Block</label>
                                <select name="block" id="block" class="form-control">
                                    <option value="">Select Block</option>
                                    <?php
                              $userid = $this->session->userdata('userId');
                              $sessionBlockId = $this->session->userdata('blockId');
                              //  $this->db->where('id !=', 6);
                              if ($sessionBlockId != 0) {
                                  $userBlockIds = $this->db->select('blockId')
                                     ->from('tbl_users')
                                     ->where('userId', $userid)
                                     ->get()
                                     ->row()
                                     ->blockId;
                                     
                                     $blockIdsArray = explode(',', $userBlockIds);
                                     $this->db->where_in('block.id', $blockIdsArray);
                              }
                              $blocks = $this->db->get('block')->result();
                              foreach ($blocks as $blk) {
                                 echo "<option value='{$blk->id}'>{$blk->name}</option>";
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
                              $current_year = date('Y');
                              for ($i = $current_year; $i >= $current_year - 5; $i--) {
                                  echo "<option value='{$i}'>{$i}</option>";
                              }
                              ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="vehicle">Vehicle</label>
                                <select name="vehicle" id="vehicle" class="form-control">
                                    <option value="">Select Vehicle</option>
                                    <?php
                              $months = [
                                  '2 व्हीलर' => '2 व्हीलर',
                                  '4 व्हीलर' => '4 व्हीलर',
                                  '2 व्हीलर,4 व्हीलर' => 'Both', 
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
                                <label for="samithi">Samiti</label>
                                <select name="samithi" id="samithi" class="form-control">
                                    <option value="">Select Samiti</option>
                                    <?php
                              // Fetch blocks from database
                              $blocks = $this->db->get('samiti')->result();
                              foreach ($blocks as $blk) {
                                  echo "<option value='{$blk->id}'>{$blk->name}</option>";
                              }
                              ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="code">Code</label>
                                <select name="code" id="code" class="form-control">
                                    <option value="">Select Code</option>
                                    <option value="BC">BC (बूथ कमेटी)</option>
                                    <option value="PP">PP (पेज प्रभारी)</option>
                                    <option value="IP">IP (प्रभावशाली व्यक्ति)</option>
                                    <option value="FH">FH (परिवार का मुखिया)</option>
                                    <option value="SMM">SMM (सोशल मीडिया मित्र)</option>
                                    <option value="MS">MS (महिला समिति)</option>
                                    <option value="FP">FP (फलिया प्रभारी)</option>
                                    <option value="ER">ER (चुनाव प्रभारी)</option>
                                    <option value="वरिष्ठ">वरिष्ठ</option>
                                    <option value="युवा">युवा</option>
                                    <option value="BLA">BLA (बूथ लेवल एजेंट)</option>
                                      <option value="FM (दानदाता)">FM (दानदाता)</option>
 <option value="AK (नवीन सदस्‍य को सक्रिय करना)">AK (नवीन सदस्‍य को सक्रिय करना)</option>
 
                                    <option value="वोटर प्रभारी (10 घर)">वोटर प्रभारी (10 घर)</option>
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
                        <h3 class="box-title">Member List</h3>
                        <a href="<?php echo base_url() ?>ServayController/createServay"
                            class="btn btn-info btn-sm pull-right  ">Add New</a>
                    </div>
                    <!-- /.box-header -->
                    <form action="<?php echo base_url(); ?>User/editstatus" method="POST">
                        <div class="box-body table-responsive no-padding">
                            <div class="container">
                                <!--<div><button class="btn btn-primary">Edit Status</button></div>-->
                                <table id="feedbackTa" class="table">
                                    <thead>
                                        <tr style="color:white;font-size:15px;background:#020254;">
                                            <th><input type="checkbox" id="select_all" name="editstatus[]" value="0" />
                                                #</th>
                                            <th>Created By</th>
                                            <th>Name</th>
                                            <th>Votar Id</th>
                                            <th>Mobile</th>
                                            <th>Father Name</th>
                                            <th>Date Of Birth</th>
                                            <th>Date Of marriage</th>
                                            <th>Block Name</th>
                                            <th>Booth Name</th>
                                            <th>Booth Number</th>
                                            <th>Grampanchayat</th>
                                            <th>Village</th>
                                            <th>Samiti</th>

                                            <th>Toll</th>
                                            <th>Jaati</th>
                                            <th>Age</th>
                                            <th>Education</th>
                                            <th>Address</th>
                                            <th>Gender</th>
                                            <th>Vehicle</th>
                                            <th>Group</th>
                                            <th>Government Employee</th>
                                            <th>Party</th>
                                            <th>पद वर्ष </th>
                                            <th>Code</th>
                                            <th>Nari Samman Yojna </th>
                                            <th>Farmer Loan Waiver</th>
                                            <th>Facebook</th>
                                            <th>Instagram</th>
                                            <th>Twitter</th>
                                            <th>Start Lat</th>
                                            <th>Start long</th>
                                            <th>Start Date</th>
                                            <th>End Lat</th>
                                            <th>End long</th>
                                            <th>End Date</th>
                                            <th>Image</th>
                                            <th>Created On</th>
                                            <th>Update Date</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                 if(!empty($userRecords))
                                 {
                                     $i=1;
                                     foreach($userRecords  as  $key => $record)
                                     {
                                         if($record->servayid!='own')
                                         {
                                 ?>
                                        <tr>
                                            <td><input type="checkbox"
                                                    class="checkbox <?php if($record->editstatus=='1'){ echo"checked";} ?>"
                                                    name="editstatus[]" value="<?php echo $record->id;  ?>" />
                                                <?php echo $i++; ?></td>
                                            <td><?php $uid=$record->user_id;
                                    if($uid!='')
                                    {
                                    $cc=$this->db->query("SELECT * FROM `tbl_users` WHERE `userId`='$uid'");
                                    @$Uu=$cc->row();
                                    if(@$Uu->name!='')
                                    {
                                        echo @$Uu->name;
                                    }
                                    ?></td>
                                            <td><?php echo @$record->name ?></td>
                                            <td><?php echo @$record->votarcode ?></td>
                                            <td><?php echo @$record->mobile ?></td>
                                            <td><?php echo @$record->fathername ?></td>
                                            <td><?php if($record->dob !='	0000-00-00'){ echo date('d-m-Y',strtotime($record->dob));} ?>
                                            </td>
                                            <td><?php if($record->dom !='	0000-00-00'){ echo date('d-m-Y',strtotime($record->dom));} ?>
                                            </td>
                                            <td>
                                                <?php $block_name_number= $record->block_name_number;
                                       $q=$this->db->query("SELECT * FROM `block` WHERE `id`='$block_name_number' ");
                                       $row=$q->row();
                                       if(!empty($row)){
                                       echo $row->name;
                                       }
                                       ?>
                                            </td>
                                            <td>
                                                <?php $boothnumber= $record->boothname;
                                       $q=$this->db->query("SELECT * FROM `booth` WHERE `id`='$boothnumber' ");
                                       $row=$q->row();
                                       if(!empty($row)){
                                       echo $row->name;
                                       }
                                       ?>
                                            </td>
                                            <td><?php echo @$record->boothnumber; ?> </td>
                                            <td>
                                                <?php $grampanchayat= $record->grampanchayat;
                                       $q=$this->db->query("SELECT * FROM `panchayat` WHERE `id`='$grampanchayat' ");
                                       $row=$q->row();
                                       if(!empty($row)){
                                       echo $row->name;
                                       }
                                       ?>
                                            </td>
                                            <td>
                                                <?php $village= $record->village;
                                       $q=$this->db->query("SELECT * FROM `village` WHERE `id`='$village' ");
                                       $row=$q->row();
                                       if(!empty($row)){
                                       echo $row->name;
                                       }
                                       ?>
                                            </td>
                                            <td>
                                                <?php $samiti= $record->samithi;
                                       $q=$this->db->query("SELECT * FROM `samiti` WHERE `id`='$samiti' ");
                                       $row=$q->row();
                                       if(!empty($row)){
                                       echo $row->name;
                                       }
                                       ?>
                                            </td>

                                            <td><?php echo @$record->toll;  ?></td>
                                            <td><?php echo @$record->jaati; ?></td>
                                            <td><?php echo @$record->age; ?></td>
                                            <td><?php echo @$record->education; ?></td>
                                            <td><?php echo @$record->address; ?></td>
                                            <td><?php echo @$record->gender; ?></td>
                                            <td><?php echo @$record->vehicle; ?></td>
                                            <td><?php echo @$record->group; ?></td>
                                            <td><?php echo @$record->government_employee; ?></td>
                                            <td>
                                                <?php $parti= $record->parti;
                                       $q=$this->db->query("SELECT * FROM `party` WHERE `id`='$parti' ");
                                       $row=$q->row();
                                       if(!empty($row)){
                                       echo $row->name;
                                       }
                                       ?>
                                            </td>
                                            <td><?php echo @$record->padvarsh; ?></td>
                                            <td><?php echo @$record->code; ?></td>
                                            <td><?php echo @$record->respect_for_women; ?></td>
                                            <td><?php echo @$record->farmer_loan_waiver; ?></td>
                                            <td><?php echo @$record->facebook; ?></td>
                                            <td><?php echo @$record->instagram; ?></td>
                                            <td><?php echo @$record->twitter; ?></td>
                                            <td><?php echo @$record->lat; ?></td>
                                            <td><?php echo @$record->long; ?></td>
                                            <td><?php echo @$record->startdate; ?></td>
                                            <td><?php echo @$record->end_lat; ?></td>
                                            <td><?php echo @$record->end_long; ?></td>
                                            <td><?php echo @$record->enddate; ?></td>
                                            <td><?php if(@$record->image!=''){ ?>
                                                <a href='<?php echo base_url() ?>uploads/userservey/<?php echo $record->image; ?>'
                                                    class="btn btn-sm btn-primary" target="_blank" title="View Image">
                                                    <i class="fa fa-eye"></i>
                                                    view File
                                                </a>
                                                <?php }else{ echo"No-Image";} ?>
                                            </td>
                                            <td><?php echo $record->create_date ?></td>
                                            <td><?php echo @$record->update_date ?></td>
                                            <td class="text-center">
                                                <!--<a class="btn btn-sm btn-primary" href="<?= base_url().'login-history/'.$record->id; ?>" title="Login history"><i class="fa fa-history"></i></a> | -->
                                                <a class="btn btn-sm btn-info"
                                                    href="<?php echo base_url().'ServayController/editServay/'.$record->id; ?>"
                                                    title="Edit"><i class="fa fa-pencil"></i></a>
                                                <a class="btn btn-sm btn-info"
                                                    href="<?php echo base_url().'editservayview/'.$record->id; ?>"
                                                    title="Edit"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                <a class="btn btn-sm btn-danger"
                                                    href="<?php echo base_url().'User/deletestatus/'.$record->id; ?>"
                                                    data-userid="<?php echo $record->id; ?>" title="Delete"><i
                                                        class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <?php
                                 }
                                 }
                                 }
                                 }
                                 ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
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
    $('#feedbackTa').DataTable({
        "processing": true,
        "serverSide": false,
        "dom": '<"top"lfB>rt<"bottom"ip>',
        "buttons": [{
            extend: 'excelHtml5',
            text: 'Export Excel',
            title: 'List'
        }],
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
<script type="text/javascript">
$(document).ready(function() {
    $('#select_all').on('click', function() {
        if (this.checked) {

            $('.checkbox').each(function() {
                this.checked = true;
                console.log(this.checked);
            });
        } else {
            $('.checkbox').each(function() {
                this.checked = false;
            });
        }
    });

    $('.checkbox').on('click', function() {
        if ($('.checkbox:checked').length == $('.checkbox').length) {
            alert("check");
            $('#select_all').prop('checked', true);
        } else {
            $('#select_all').prop('checked', false);
        }
    });
});
</script>