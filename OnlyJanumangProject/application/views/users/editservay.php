<?php
$userId = @$userInfo->userId;
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Servey Management
        <small>Add / Edit User</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Servey Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo base_url() ?>editUser" method="post" id="editUser" role="form">
                        <div class="box-body">
                            <div class="row"> <div class="col-md-6">  <h3 class="box-title">Step 1</h3></div></div>
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">ब्लॉक का नाम और नंबर</label>
                                        <input type="text" class="form-control" id="block_name_number" placeholder="ब्लॉक का नाम और नंबर" name="block_name_number" value="<?php echo @$userInfo->block_name_number; ?>">
                                        <input type="hidden" value="<?php echo $userId; ?>" name="userId" id="userId" />    
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">बूथ का नाम & नंबर</label>
                                        <input type="text" class="form-control" id="booth_name_number" placeholder="बूथ का नाम & नंबर" name="booth_name_number" value="<?php echo @$userInfo->booth_name_number; ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">ग्राम पंचायत</label>
                                        <input type="text" class="form-control" id="grampanchayat" placeholder="ग्राम पंचायत" name="grampanchayat"   value="<?php echo @$userInfo->grampanchayat; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cpassword">गाँव</label>
                                        <input type="text" class="form-control" id="village" placeholder="गाँव" name="village" value="<?php echo @$userInfo->village;?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile">फालिया  / मजरा / टोल</label>
                                        <input type="text" class="form-control" id="toll" placeholder="फालिया  / मजरा / टोल" name="toll" value="<?php echo @$userInfo->toll; ?>" >
                                    </div>
                                </div>
                                
                                
                            </div>
                             <div class="row"> <div class="col-md-6">  <h3 class="box-title">Step 2</h3></div></div>
                              <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"> नाम </label>
                                        <input type="text" class="form-control" id="name" placeholder="नाम" name="name" value="<?php echo @$userInfo->name; ?>">
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">पिता का नाम</label>
                                        <input type="text" class="form-control" id="fathername" placeholder="पिता का नाम" name="fathername" value="<?php echo @$userInfo->fathername; ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"> जाति </label>
                                        <input type="text" class="form-control" id="jaati" placeholder="जाति" name="jaati" value="<?php echo @$userInfo->jaati; ?>">
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">पिता का नाम</label>
                                        <input type="text" class="form-control" id="age" placeholder="आयु" name="age" value="<?php echo @$userInfo->age; ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"> जाति </label>
                                        <input type="text" class="form-control" id="jaati" placeholder="जाति" name="jaati" value="<?php echo @$userInfo->jaati; ?>">
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">शिक्षा</label>
                                        <input type="text" class="form-control" id="education" placeholder="शिक्षा" name="education" value="<?php echo @$userInfo->education; ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"> मोबाइल नंबर </label>
                                        <input type="text" class="form-control" id="mobile" placeholder="मोबाइल नंबर" name="mobile" value="<?php echo @$userInfo->mobile; ?>" maxlength="10" pattern="[0-9]{10}">
                                    </div>
                                    
                                </div>
                                
                            </div>
                            <div class="row"> <div class="col-md-6">  <h3 class="box-title">Step 3</h3></div></div>
                             <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"> मतदाता पहचान पत्र </label>
                                        <input type="text" class="form-control" id="votarcode" placeholder="मतदाता पहचान पत्र" name="votarcode" value="<?php echo @$userInfo->votarcode; ?>">
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">पता</label>
                                        <input type="text" class="form-control" id="address" placeholder="पता" name="address" value="<?php echo @$userInfo->address; ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"> मतदाता पहचान पत्र </label>
                                        <input type="text" class="form-control" id="votarcode" placeholder="मतदाता पहचान पत्र" name="votarcode" value="<?php echo @$userInfo->votarcode; ?>">
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">लिंग</label>
                                        <input type="text" class="form-control" id="gender" placeholder="लिंग" name="gender" value="<?php echo @$userInfo->gender; ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"> समूह </label>
                                        <input type="text" class="form-control" id="group" placeholder="समूह" name="group" value="<?php echo @$userInfo->group; ?>">
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">वाहन</label>
                                        <input type="text" class="form-control" id="vehicle" placeholder="वाहन" name="vehicle" value="<?php echo @$userInfo->vehicle; ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"> सरकारी कर्मचारी </label>
                                        <input type="text" class="form-control" id="government_employee" placeholder="सरकारी कर्मचारी" name="government_employee" value="<?php echo @$userInfo->government_employee; ?>">
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="row"> <div class="col-md-6">  <h3 class="box-title">Step 4</h3></div></div>
                             <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"> पार्टी </label>
                                        <input type="text" class="form-control" id="parti" placeholder="पार्टी" name="parti" value="<?php echo @$userInfo->parti; ?>">
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="code">कोड (Code)</label><br>
                                        <?php 
                                        $selectedCodes = !empty(@$userInfo->code) ? explode(',', @$userInfo->code) : [];
                                        $allCodes = [
                                            'SC', 'YC', 'WC', 'PA', 'SM', 'EO', 'GS', 'DCC', 'PW', 'NL', 'FR', 'SO', 
                                            'ST', 'REF', 'US', 'SMW', 'DYC', 'OBC', 'DT', 'DP', 'MLA', 'AVP', 'MEET', 
                                            'MEDIA', 'X MLA', 'BC (बूथ कमेटी)', 'PP (पेज प्रभारी)', 'IP (प्रभावशाली व्यक्ति)', 
                                            'FH (परिवार का मुखिया)', 'SMM (सोशल मीडिया मित्र)', 'MS (महिला समिति)', 
                                            'FP (फलिया प्रभारी)', 'ER (चुनाव प्रभारी)', 'वरिष्ठ', 'युवा', 
                                            'वोटरप्रभारी(१० घर)', 'BLA (बूथ लेवल एजेंट)', 'FM (दानदाता)', 
                                            'AK (नवीन सदस्‍य को सक्रिय करना)'
                                        ];
                                        foreach ($allCodes as $code) {
                                            $checked = in_array($code, $selectedCodes) ? 'checked' : '';
                                            echo '<input type="checkbox" name="code[]" value="'.$code.'" '.$checked.'> '.$code.'<br>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"> नारी सम्मान  </label>
                                        <input type="text" class="form-control" id="respect_for_women" placeholder="नारी सम्मान" name="respect_for_women" value="<?php echo @$userInfo->respect_for_women; ?>">
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">किसान कर्ज माफी</label>
                                        <input type="text" class="form-control" id="farmer_loan_waiver	" placeholder="किसान कर्ज माफी" name="farmer_loan_waiver" value="<?php echo @$userInfo->farmer_loan_waiver	; ?>" >
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

<script src="<?php echo base_url(); ?>assets/js/editUser.js" type="text/javascript"></script>