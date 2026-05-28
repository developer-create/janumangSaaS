<link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Servey Management
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
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Ip User List</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                <div class="container">
                 <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Created By</th>
                <th>Name</th>
                <th>Votar Id</th>
                <th>Mobile</th>
                <th>Father Name</th>
                <th>Block Name-Number</th>
                <th>Booth Name Number</th>
                <th>Grampanchayat</th>
                <th>Village</th>
                <th>Toll</th>
                <th>Jaati</th>
                <th>Age</th>
                <th>Education</th>
                <th>Address</th>
                <th>Gender</th>
                <th>Vehicle</th>
                <th>Group</th>
                <th>Government Employee</th>
                <th>Parti</th>
                <th>Code</th>
                <th>Respect For Women</th>
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
                
                 
                    ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
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
                        <td><?php echo @$record->block_name_number; ?></td>
                        <td><?php echo @$record->booth_name_number; ?></td>
                        <td><?php echo @$record->grampanchayat; ?></td>
                        <td><?php echo @$record->village; ?></td>
                        <td><?php echo @$record->toll;  ?></td>
                        <td><?php echo @$record->jaati; ?></td>
                        <td><?php echo @$record->age; ?></td>
                        <td><?php echo @$record->education; ?></td>
                        <td><?php echo @$record->address; ?></td>
                        <td><?php echo @$record->gender; ?></td>
                        <td><?php echo @$record->vehicle; ?></td>
                        <td><?php echo @$record->group; ?></td>
                        <td><?php echo @$record->government_employee; ?></td>
                        <td><?php echo @$record->parti; ?></td>
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
                        <td><?php echo @$record->create_date ?></td>
                        <td><?php echo @$record->update_date ?></td>
                        
                        <td class="text-center">
                            <!--<a class="btn btn-sm btn-primary" href="<?= base_url().'login-history/'.$record->id; ?>" title="Login history"><i class="fa fa-history"></i></a> | -->
                            <!--<a class="btn btn-sm btn-info" href="<?php echo base_url().'editservay/'.$record->id; ?>" title="Edit"><i class="fa fa-pencil"></i></a>-->
                            <a class="btn btn-sm btn-info" href="<?php echo base_url().'editservayview/'.$record->id; ?>" title="Edit"><i class="fa fa-eye" aria-hidden="true"></i></a>

                            <a class="btn btn-sm btn-danger deleteUser" href="#" data-userid="<?php echo $record->id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php
                            }
                        }
                    
                    }
                    ?>
        </tbody>
      
    </table>
                </div>
              </div>    
          
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
   
<script>$(document).ready(function() {
    var table = $('#example').DataTable( {
        lengthChange: false,
        buttons: [ 'copy', 'excel', 'pdf', 'colvis' ]
    } );
 
    table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );</script>
  <script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js" type="text/javascript"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js" type="text/javascript"></script>
  <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js" type="text/javascript"></script>
  <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap5.min.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
  <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js" type="text/javascript"></script>
  <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js" type="text/javascript"></script>
  <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js" type="text/javascript"></script>
   

