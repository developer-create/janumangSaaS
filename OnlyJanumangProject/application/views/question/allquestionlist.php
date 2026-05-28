<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-user-circle-o" aria-hidden="true"></i> Question Management
        <small>Add, Edit, Delete</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>question/alladd"><i class="fa fa-plus"></i> Add New Question</a>
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
                    <h3 class="box-title">Question Type List</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>question/allinsertquestion" method="POST" id="searchList">
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
                  <table class="table table-hover">
                    <tr><th>Id</th>
                          <th>Type</th>
                        <th>Question</th>
                      <th>Option</th>
                        <th>Status</th>
                        <!-- <th class="text-center">Actions</th> -->
                    </tr>
                    <?php
                    if(!empty($roleRecords))
                    {
                         $i=1;
                        foreach($roleRecords as $record)
                        {
                           
                    ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $record->question; ?></td>
                        <td><?php if($record->qtype==1){
                            echo"Text";
                        }
                        if($record->qtype==2){
                            echo"Radio";
                        }
                        if($record->qtype==3){
                            echo"Checkbox";
                        }
                        if($record->qtype==4){
                            echo"Select";
                        } ?></td>
                          <td><?php if($record->qtype==1){
                            echo $record->inputanswer;
                        }
                        else{
                            if($record->inputreadio!='')
                            {
                            echo "<b>Option 1</b> ".$record->inputreadio."</br>";
                            }
                            if($record->inputreadio2!='')
                            {
                            echo "<b>Option 2</b> ".$record->inputreadio2."</br>";
                            }
                            if($record->inputreadio3!='')
                            {
                            echo "<b>Option 3</b> ".$record->inputreadio3."</br>";
                            }
                            if($record->inputreadio4!='')
                            {
                            echo "<b>Option 4</b> ".$record->inputreadio4."</br>";
                            }
                        }
                        ?></td>
                        <td>
                            <?php 
                            if($record->status == ACTIVE) {
                                ?> <span class="label label-success">Active</span> <?php
                            } else {
                                ?> <span class="label label-warning">Inactive</span> <?php
                            }
                            ?>
                        </td>
                       
                        <td class="text-center">
                            <a class="btn btn-sm btn-info" href="<?php echo base_url().'roles/edit/'.$record->id; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                            <a class="btn btn-sm btn-danger deleteRole" href="<?php echo base_url().'question/deleteallq/'.$record->id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                  </table>
                  
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "roleListing/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>
