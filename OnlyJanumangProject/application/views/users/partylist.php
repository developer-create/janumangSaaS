<link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Party Management
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
                    <h3 class="box-title">Party  List</h3>
                      <a href="<?php echo base_url() ?>user/partyadd" class="btn btn-info btn-sm pull-right  ">Add</a>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive ">
           
                 <table id="example" class="table table-striped">
        <thead>
            <tr style="color:white;font-size:15px;background-color:#020254;">
                <th  style="width:50px !important;">ID</th>
                <th style="width: 150px !important;">Name</th>
                <th  style="width: 150px !important;">CreatedAt</th> 
                <th  style="width:50px !important;" >Actions</th>
            </tr>
        </thead>
        <tbody>
              <?php  foreach($userRecords  as  $key => $record)  { ?>
                    <tr>
                        <td style="width: 150px !important;"><?php echo $key+1; ?></td>
                        <td style="width: 150px !important;"><?php echo $record->name ?></td>
                        <td style="width: 150px !important;"><?php echo $record->created_at; ?></td> 
                        <td style="width: 150px !important;"  class="text-center">
                            <a class="btn btn-sm btn-info" href="<?php echo base_url().'user/partyedit/'.$record->id; ?>" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
                            <a class="btn btn-sm btn-danger" href="<?php echo base_url().'user/partydelete/'.$record->id; ?>" 
                            title="Delete"
                             onclick="return confirm('Are you sure delete?')"
                             ><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php  } ?>
        </tbody>
    </table>
                 
              </div>    
          
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
   
<script>$(document).ready(function() {
    var table = $('#example').DataTable( {
        lengthChange: false,
         'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : false,
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
   

