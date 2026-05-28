<style>
    button.dt-button.buttons-excel.buttons-html5 {
    left: 100px !important;
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-phone"></i> Phone Directory Management
            <small>Add, Edit, Delete</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>phonedirectory/add"><i class="fa fa-plus"></i> Add New</a>
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
                        <h3 class="box-title">Phone Directory List</h3>
                        <div class="box-tools">
                            <form action="<?php echo base_url() ?>phonedirectory" method="POST" id="searchList">
                                <div class="input-group">
                                    <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover" id="phoneDirectoryTable">
                            <thead>
                                <tr style="color:white;font-size:15px;background:#020254;">
                                    <th>Sl</th>
                                    <th>Name</th>
                                    <th>Post</th>
                                    <th>Department</th>
                                    <th>District</th>
                                    <th>VS Block</th>
                                    <th>Number</th>
                                    <th>Email</th>
                                    <th>Party</th>
                                    <th>Status</th>
                                    <th>Created On</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(!empty($phoneDirectoryRecords))
                                {
                                    $sl = 1;
                                    foreach($phoneDirectoryRecords as $record)
                                    {
                                ?>
                                <tr>
                                    <td><?php echo $sl++ ?></td>
                                    <td><?php echo $record->name ?></td>
                                    <td><?php echo $record->post ? $record->post : '-' ?></td>
                                    <td><?php echo $record->department_name ? $record->department_name : '-' ?></td>
                                    <td><?php echo $record->district_name ? $record->district_name : '-' ?></td>
                                    <td><?php echo $record->block_name ? $record->block_name : '-' ?></td>
                                    <td><?php echo $record->number ?></td>
                                    <td><?php echo $record->email ? $record->email : '-' ?></td>
                                    <td><?php echo $record->party_name ? $record->party_name : '-' ?></td>
                                    <td><?php echo $record->status == 'Active' ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Inactive</span>' ?></td>
                                    <td><?php echo date("d-m-Y", strtotime($record->created_at)) ?></td>
                                    <td class="text-center">
                                        <a class="btn btn-sm btn-info" href="<?php echo base_url().'phonedirectory/view/'.$record->id; ?>" title="View"><i class="fa fa-eye"></i></a>
                                        <a class="btn btn-sm btn-info" href="<?php echo base_url().'phonedirectory/edit/'.$record->id; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                                        <a class="btn btn-sm btn-danger" href="<?php echo base_url().'phonedirectory/delete/'.$record->id; ?>" title="Delete" onclick="return confirm('Are you sure you want to delete this entry?');"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php
                                    }
                                }
                                else
                                {
                                ?>
                                <tr>
                                    <td colspan="12" class="text-center">No records found</td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix"></div>
                </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<!-- DataTables assets -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.2.2/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('#phoneDirectoryTable').DataTable({
            "processing": true,
            "serverSide": false,
            "dom": '<"top"lfB>rt<"bottom"ip>',
            "buttons": [
                {
                    extend: 'excelHtml5',
                    text: 'Export Excel',
                    title: 'Phone Directory List'
                }
            ],
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthMenu": [[10, 25, 50, 75, -1], [10, 25, 50, 75, "All"]]
        });
    });
</script>

