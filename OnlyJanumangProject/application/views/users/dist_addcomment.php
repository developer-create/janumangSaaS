<div class="content-wrapper">
  
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
                <!-- general form elements -->
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Comment</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addUser" action="<?php echo base_url() ?>user/submit_form/<?php echo $this->uri->segment(3) ?>/<?php echo $this->uri->segment(4) ?>" method="post" role="form" enctype="multipart/form-data">
                        <div class="box-body"> 
                            <!--<div class="row">-->
                            <!--    <div class="col-md-12">-->
                            <!--        <div class="form-group">-->
                            <!--            <label for="date">Date</label>-->
                            <!--            <input type="date" class="form-control required" id="date" name="date" value="<?php echo set_value('date'); ?>">-->
                            <!--        </div>-->
                            <!--    </div>-->
                               
                            <!--</div>-->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="comment">Comment</label>
                                        <textarea class="form-control required" id="comment" name="comment"><?php echo set_value('comment'); ?></textarea>
                                    </div>
                                </div>
                            <input type="hidden"  id="jid" name="jid" value="<?php echo set_value('jid'); ?>" >
                                     
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="file_upload">File Upload</label>
                                        <input type="file" class="form-control" id="file_upload" name="file_upload">
                                    </div>
                                </div>
                            </div>
                            
                             <div class="row">
                             <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control required" id="status" name="status"
                                        >                                            <option value="0" >Select Status</option>
                                            
                                             <option value="Incomplete" >Incomplete</option>
                                             <option value="In progress" >In progress</option>
                                             <option value="Complete" >Complete</option>
                                              
                                            </select>
                                    </div>
                                </div>
                                 </div>
                            <!-- Existing form fields continue here -->

                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <!-- Error handling -->
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
    </section>
    
</div>
<script src="<?php echo base_url(); ?>assets/js/addUser.js" type="text/javascript"></script>
