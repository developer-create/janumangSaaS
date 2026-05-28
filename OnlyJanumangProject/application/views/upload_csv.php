<div class="content-wrapper">
    <section class="content">
   <div class="row">
      <!-- left column -->
      <div class="col-md-8">
         <!-- general form elements -->
         <div class="box box-primary">
            <div class="box-header">
               <h3 class="box-title">Upload Jansunwai</h3>
               <a href="<?php echo site_url('uploads/samplejansunwai.csv'); ?>" target="_blank">Sample file</a>
            </div>
                <form action="<?php echo site_url('jansunwai/import_csv'); ?>" method="post" enctype="multipart/form-data">
                   <div class="box-body">
                      <div class="row">
                         <div class="col-md-6">
                            <div class="form-group">
                               <label for="name">Select CSV File:</label>
                               <input type="file" name="csv_file" accept=".csv" required> 
                            </div>
                         </div>
                      </div>
                      <div class="box-footer">
                         <input type="submit" value="Upload" class="btn btn-primary">
                      </div>
                      </div>
                </form>
            </div>
         </div>
         <div class="col-md-4">
            <?php
               $this->load->helper('form');
               $success = $this->session->flashdata('success');
               if ($success) {
               ?>
            <div class="alert alert-success alert-dismissable">
               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
               <?php echo $this->session->flashdata('success'); ?>
            </div>
            <?php } ?>
         </div>
      </div>
</section>
</div>