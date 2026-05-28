<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-user-circle-o" aria-hidden="true"></i> Question Management
        <small>Add / Edit Question</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Question Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addRole" action="<?php echo base_url() ?>question/allinsertquestion" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="role">Question</label>
                                        <input type="text" class="form-control required" value="<?php echo set_value('question'); ?>" id="question" name="question" maxlength="50" />
                                    </div>
                                    
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="status">Select Type</label>
                                        <select class="form-control required"  name="qtype" onchange="myfun(this.value)">
                                            <option value="">Select Type</option>
                                            <?php 
                                                foreach($type as $k =>$tp)
                                                {
                                                    ?>
                                                        <option value="<?= $tp->id ?>" ><?= $tp->questiontypes ?></option>
                                                    <?php
                                                }
                                            ?>
                                            
                                            <!-- <option value="<?= INACTIVE ?>" >Inactive</option> -->
                                        </select>
                                    </div>
                                </div>
                   
                            
                                    <div id="inputdiv"></div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control required" id="status" name="status">
                                            <option value="">Select Status</option>
                                            <option value="<?= ACTIVE ?>" >Active</option>
                                            <option value="<?= INACTIVE ?>" >Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
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
<script src="<?php echo base_url(); ?>assets/js/addRole.js" type="text/javascript"></script>
<script type="text/javascript">
    function myfun(A)
    {
        // if(A==1)
        // {
        // $("#inputdiv").show();

        //  $("#inputreadio").hide();
        //     $("#inputcheckbox").hide();
        //     $("#inputselect").hide();
            

        // }
        // else if(A==2)
        // {
        //      $("#inputreadio").show();
        //       $("#inputdiv").hide();
        //          $("#inputcheckbox").hide();
        //            $("#inputselect").hide();
        // }
        // else if(A==3)
        // {
            
        //      $("#inputcheckbox").show();
        //      $("#inputreadio").hide();
        //        $("#inputselect").hide();
        //       $("#inputdiv").hide();
        // }
        // //inputcheckbox
        // else if(A==4) 
        // {
        //     $("#inputcheckbox").hide();
        //      $("#inputreadio").hide();
        //        $("#inputselect").show();
        //       $("#inputdiv").hide();
        // }

        var base_url='<?php echo base_url(); ?>';
        $.ajax({
         type: "POST",
         url: base_url + "question/selectquestion", 
         data: {qtype: A},
         dataType: "html",  
         cache:false,
         success: 
              function(data){
                
                 $("#inputdiv").html(data);
              }
          });// you have missed this bracket
     // return false;
    }
</script>