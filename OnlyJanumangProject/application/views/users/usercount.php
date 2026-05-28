 

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
                
                
                    <form method="get" action="<?php echo base_url(); ?>Usercount">
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <label for="date">Date</label>
                 <input type="date" name="date" value="<?php echo isset($selectedDate) ? $selectedDate : date('Y-m-d'); ?>" class="form-control" />
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
                    <h3 class="box-title">User List</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                <div class="container">
                   
                 <table id="feedbackTa" class="table table-striped" style="width:100%">
        <thead>
                    <tr style="color:white;font-size:15px;background-color:#020254;">
                        <th>Name</th>
                        <th>Total Count</th>
                         
                    </tr>
                      </thead>
                    <?php
                    if(!empty($userRecords))
                    {
                        foreach($userRecords as $record)
                        {
                            if($record->userId!='1'){
                    ?>
                    <tr>
                        <td><?php echo $record->name ?></td>
                        <td><?php 
                         // Use the count from controller data instead of querying in view
                         $count = isset($userCounts[$record->userId]) ? $userCounts[$record->userId] : 0;
                         echo $count;
                        ?></td>
                       
                    </tr>
                    <?php
                            }
                        }
                    }
                    ?>
      
      
    </table>
                </div>
              </div>    
              </div><!-- /.box -->
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