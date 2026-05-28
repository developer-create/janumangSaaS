<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <i class="fa fa-list"></i> Survey Management
         <small>Edit Survey Details</small>
      </h1>
   </section>
   <section class="content">
      <div class="row">
         <!-- left column -->
         <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
               <div class="box-header">
                  <h3 class="box-title">Update Survey Details</h3>
               </div>
               <!-- /.box-header -->
               <!-- form start -->
               <?php $this->load->helper("form"); ?>
               <form action="<?php echo base_url()?>ServayController/updateServay/<?php echo $survey->id; ?>" method="post"  enctype="multipart/form-data">
                  <div class="container-fluid">
                     <h2>Edit Survey Form</h2>
                     <?php if (isset($upload_error) && !empty($upload_error)): ?>
                     <div class="alert alert-danger">
                        <?php echo $upload_error; ?>
                     </div>
                     <?php endif; ?>
                     <?php if (validation_errors()): ?>
                     <div class="alert alert-danger">
                        <?php echo validation_errors(); ?>
                     </div>
                     <?php endif; ?>
                     <div class="row">
                        <div class="form-group col-md-3">
                           <label for="district">District</label>
                           <select name="district" id="district" class="form-control select2">
                              <option value="">Select District</option>
                              <?php foreach ($districts as $district): ?>
                              <option value="<?php echo $district->id; ?>" <?php echo ($survey->district == $district->id) ? 'selected' : ''; ?>><?php echo $district->name; ?></option>
                              <?php endforeach; ?>
                           </select>
                        </div>
                        <div class="form-group col-md-3">
                           <label for="vidhan_sabha_id">Vidhan Sabha</label>
                           <select name="vidhan_sabha_id" id="vidhan_sabha_id" class="form-control select2">
                              <option value="">Select District first</option>
                              <?php if (!empty($vidhan_sabhas)): ?>
                                 <?php foreach ($vidhan_sabhas as $vs): ?>
                                 <option value="<?php echo $vs->id; ?>" <?php echo (isset($survey->vidhan_sabha_id) && $survey->vidhan_sabha_id == $vs->id) ? 'selected' : ''; ?>><?php echo $vs->vidhan_sabha_name; ?></option>
                                 <?php endforeach; ?>
                              <?php endif; ?>
                           </select>
                        </div>
                        <div class="form-group col-md-3">
                           <label for="samithi">Samithi</label>
                           <select name="samithi" id="samithi" class="form-control select2">
                              <option value="">Select Committee</option>
                              <?php foreach ($committees as $committee): ?>
                              <option value="<?php echo $committee->id; ?>" <?php echo ($survey->samithi == $committee->id) ? 'selected' : ''; ?>><?php echo $committee->name; ?></option>
                              <?php endforeach; ?>
                           </select>
                        </div>
                        <div class="form-group col-md-3">
                           <label for="block_name_number">Block Name</label>
                           <select name="block_name_number" id="block" class="form-control select2">
                              <option value="">Select Block</option>
                              <?php foreach ($blocks as $block): ?>
                              <option value="<?php echo $block->id; ?>" <?php echo ($survey->block_name_number == $block->id) ? 'selected' : ''; ?>><?php echo $block->name; ?></option>
                              <?php endforeach; ?>
                           </select>
                        </div>
                     </div>
                     <div class="row">
                        <div class="form-group col-md-3">
                           <label for="janpad_panchayat">Janpad Panchayat</label>
                           <input type="text" class="form-control" id="janpad_panchayat" name="janpad_panchayat" value="<?php echo $survey->janpad_panchayat; ?>" />
                        </div>
                        <div class="form-group col-md-3">
                           <label for="mandalam">Mandalam</label>
                           <input type="text" class="form-control" id="mandalam" name="mandalam" value="<?php echo $survey->mandalam; ?>" />
                        </div>
                        <div class="form-group col-md-3">
                           <label for="toll">Majra/Falia/Tolla</label>
                           <input type="text" class="form-control" id="toll" name="toll" value="<?php echo $survey->toll; ?>" />
                        </div>
                        <div class="form-group col-md-3">
                           <label for="padvarsh">Post-Year</label>
                           <input type="text" class="form-control" id="padvarsh" name="padvarsh" value="<?php echo $survey->padvarsh; ?>" />
                        </div>
                     </div>
                     <div class="row">
                        <div class="form-group col-md-3">
                           <label for="boothname">Booth Name</label>
                           <select name="boothname" id="booth" class="form-control select2">
                              <option value="">Select Booth</option>
                           </select>
                        </div>
                        <div class="form-group col-md-3">
                           <label for="boothnumber">Booth Number</label>
                           <input type="text" class="form-control" id="boothnumber" name="boothnumber" value="<?php echo $survey->boothnumber; ?>" />
                        </div>
                        <div class="form-group col-md-3">
                           <label for="grampanchayat">Gram Panchayat</label>
                           <select name="grampanchayat" id="panchayat" class="form-control select2">
                              <option value="">Select Panchayat</option>
                           </select>
                        </div>
                        <div class="form-group col-md-3">
                           <label for="village">Village</label>
                           <select name="village" id="village" class="form-control select2">
                              <option value="">Select Village</option>
                           </select>
                        </div>
                     </div>
                     <div class="row">
                        <div class="form-group col-md-3">
                           <label for="name">Name</label>
                           <input type="text" class="form-control" id="name" name="name" value="<?php echo $survey->name; ?>" />
                        </div>
                        <div class="form-group col-md-3">
                           <label for="fathername">Father's Name</label>
                           <input type="text" class="form-control" id="fathername" name="fathername" value="<?php echo $survey->fathername; ?>" />
                        </div>
                        <div class="form-group col-md-3">
                           <label for="jaati">Caste</label>
                           <select name="jaati" id="jaati" class="form-control select2">
                              <option value="">Select Caste</option>
                              <option value="ST (bhil)" <?php echo ($survey->jaati == 'ST (bhil)') ? 'selected' : ''; ?>>ST (bhil)</option>
                              <option value="ST (Bhilala)" <?php echo ($survey->jaati == 'ST (Bhilala)') ? 'selected' : ''; ?>>ST (Bhilala)</option>
                              <option value="Muslim" <?php echo ($survey->jaati == 'Muslim') ? 'selected' : ''; ?>>Muslim</option>
                              <option value="Brahman" <?php echo ($survey->jaati == 'Brahman') ? 'selected' : ''; ?>>Brahman</option>
                              <option value="Sirvi" <?php echo ($survey->jaati == 'Sirvi') ? 'selected' : ''; ?>>Sirvi</option>
                              <option value="Maheshwari" <?php echo ($survey->jaati == 'Maheshwari') ? 'selected' : ''; ?>>Maheshwari</option>
                              <option value="Prajapati" <?php echo ($survey->jaati == 'Prajapati') ? 'selected' : ''; ?>>Prajapati</option>
                              <option value="Rajput" <?php echo ($survey->jaati == 'Rajput') ? 'selected' : ''; ?>>Rajput</option>
                              <option value="Lohar" <?php echo ($survey->jaati == 'Lohar') ? 'selected' : ''; ?>>Lohar</option>
                              <option value="Sikh" <?php echo ($survey->jaati == 'Sikh') ? 'selected' : ''; ?>>Sikh</option>
                              <option value="Rathor" <?php echo ($survey->jaati == 'Rathor') ? 'selected' : ''; ?>>Rathor</option>
                              <option value="Jain" <?php echo ($survey->jaati == 'Jain') ? 'selected' : ''; ?>>Jain</option>
                              <option value="Bohra" <?php echo ($survey->jaati == 'Bohra') ? 'selected' : ''; ?>>Bohra</option>
                              <option value="other" <?php echo ($survey->jaati == 'other') ? 'selected' : ''; ?>>Other</option>
                           </select>
                        </div>
                        <div class="form-group col-md-3">
                           <label for="gender">Gender</label>
                           <select name="gender" id="gender" class="form-control select2">
                              <option value="">Select Gender</option>
                              <option value="Male" <?php echo ($survey->gender == 'Male') ? 'selected' : ''; ?>>Male</option>
                              <option value="Female" <?php echo ($survey->gender == 'Female') ? 'selected' : ''; ?>>Female</option>
                              <option value="other" <?php echo ($survey->gender == 'other') ? 'selected' : ''; ?>>Other</option>
                           </select>
                        </div>
                     </div>
                     <div class="row">
                        <div class="form-group col-md-3">
                           <label for="dob">Date of Birth</label>
                           <input type="date" class="form-control" id="dob" name="dob" value="<?php echo ($survey->dob && $survey->dob != '0000-00-00') ? $survey->dob : ''; ?>" />
                        </div>
                        <div class="form-group col-md-3">
                           <label for="age">Age</label>
                           <input type="text" class="form-control" id="age" name="age" value="<?php echo $survey->age; ?>" />
                        </div>
                        <div class="form-group col-md-3">
                           <label for="dom">Date of Marriage</label>
                           <input type="date" class="form-control" id="dom" name="dom" value="<?php echo ($survey->dom && $survey->dom != '0000-00-00') ? $survey->dom : ''; ?>" />
                        </div>
                        <div class="form-group col-md-3">
                           <label for="education">Education</label>
                           <select name="education" id="education" class="form-control select2">
                              <option value="">Select Education</option>
                              <option value="uneducate" <?php echo ($survey->education == 'uneducate') ? 'selected' : ''; ?>>Uneducate</option>
                              <option value="educate" <?php echo ($survey->education == 'educate') ? 'selected' : ''; ?>>Educate</option>
                              <option value="5th" <?php echo ($survey->education == '5th') ? 'selected' : ''; ?>>5th</option>
                              <option value="8th" <?php echo ($survey->education == '8th') ? 'selected' : ''; ?>>8th</option>
                              <option value="10th" <?php echo ($survey->education == '10th') ? 'selected' : ''; ?>>10th</option>
                              <option value="12th" <?php echo ($survey->education == '12th') ? 'selected' : ''; ?>>12th</option>
                              <option value="Gradute" <?php echo ($survey->education == 'Gradute') ? 'selected' : ''; ?>>Graduate</option>
                              <option value="Post-Gradute" <?php echo ($survey->education == 'Post-Gradute') ? 'selected' : ''; ?>>Post-Graduate</option>
                           </select>
                        </div>
                     </div>
                     <div class="row">
                        <div class="form-group col-md-3">
                           <label for="mobile">Mobile</label>
                           <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo $survey->mobile; ?>" />
                        </div>
                        <div class="form-group col-md-3">
                           <label for="votarcode">Voter Code</label>
                           <input type="text" class="form-control" id="votarcode" name="votarcode" value="<?php echo $survey->votarcode; ?>" />
                        </div>
                        <div class="form-group col-md-3">
                           <label for="address">Address</label>
                           <textarea class="form-control" id="address" name="address" rows="3"><?php echo $survey->address; ?></textarea>
                        </div>
                        <div class="form-group col-md-3">
                           <label for="group">Group</label>
                           <input type="text" class="form-control" id="group" name="group" value="<?php echo $survey->group; ?>" />
                        </div>
                     </div>
                     <div class="row">
                        <div class="form-group col-md-3">
                           <label for="government_employee">Government Employee</label>
                           <input type="text" class="form-control" id="government_employee" name="government_employee" value="<?php echo $survey->government_employee; ?>" />
                        </div>
                        <div class="form-group col-md-3">
                           <label for="parti">Party</label>
                           <select name="parti" id="parti" class="form-control select2">
                              <option value="">Select Party</option>
                              <?php foreach ($parties as $party): ?>
                              <option value="<?php echo $party->id; ?>" <?php echo ($survey->parti == $party->id) ? 'selected' : ''; ?>><?php echo $party->name; ?></option>
                              <?php endforeach; ?>
                           </select>
                        </div>
                     </div>

                     <div class="row">
                        <div class="form-group col-md-12">
                           <label><strong>Code</strong></label>
                        </div>
                     </div>
                     <?php 
                     $savedCodes = [];
                     if (!empty($survey->code) && $survey->code != '0') {
                         if (strpos($survey->code, '[') === 0) {
                             $savedCodes = json_decode($survey->code, true);
                         } else {
                             $savedCodes = explode(',', $survey->code);
                         }
                         $savedCodes = array_map('trim', (array)$savedCodes);
                     }
                     ?>
                     <div class="row">
                        <div class="col-md-3">
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="SC" <?php echo in_array('SC', $savedCodes) ? 'checked' : ''; ?> /> SC</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="YC" <?php echo in_array('YC', $savedCodes) ? 'checked' : ''; ?> /> YC</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="WC" <?php echo in_array('WC', $savedCodes) ? 'checked' : ''; ?> /> WC</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="PA" <?php echo in_array('PA', $savedCodes) ? 'checked' : ''; ?> /> PA</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="SM" <?php echo in_array('SM', $savedCodes) ? 'checked' : ''; ?> /> SM</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="EO" <?php echo in_array('EO', $savedCodes) ? 'checked' : ''; ?> /> EO</label></div>
                        </div>
                        <div class="col-md-3">
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="GS" <?php echo in_array('GS', $savedCodes) ? 'checked' : ''; ?> /> GS</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="DCC" <?php echo in_array('DCC', $savedCodes) ? 'checked' : ''; ?> /> DCC</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="PW" <?php echo in_array('PW', $savedCodes) ? 'checked' : ''; ?> /> PW</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="NL" <?php echo in_array('NL', $savedCodes) ? 'checked' : ''; ?> /> NL</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="FR" <?php echo in_array('FR', $savedCodes) ? 'checked' : ''; ?> /> FR</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="SO" <?php echo in_array('SO', $savedCodes) ? 'checked' : ''; ?> /> SO</label></div>
                        </div>
                        <div class="col-md-3">
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="ST" <?php echo in_array('ST', $savedCodes) ? 'checked' : ''; ?> /> ST</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="REF" <?php echo in_array('REF', $savedCodes) ? 'checked' : ''; ?> /> REF</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="US" <?php echo in_array('US', $savedCodes) ? 'checked' : ''; ?> /> US</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="SMW" <?php echo in_array('SMW', $savedCodes) ? 'checked' : ''; ?> /> SMW</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="DYC" <?php echo in_array('DYC', $savedCodes) ? 'checked' : ''; ?> /> DYC</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="OBC" <?php echo in_array('OBC', $savedCodes) ? 'checked' : ''; ?> /> OBC</label></div>
                        </div>
                        <div class="col-md-3">
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="DT" <?php echo in_array('DT', $savedCodes) ? 'checked' : ''; ?> /> DT</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="DP" <?php echo in_array('DP', $savedCodes) ? 'checked' : ''; ?> /> DP</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="MLA" <?php echo in_array('MLA', $savedCodes) ? 'checked' : ''; ?> /> MLA</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="AVP" <?php echo in_array('AVP', $savedCodes) ? 'checked' : ''; ?> /> AVP</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="MEET" <?php echo in_array('MEET', $savedCodes) ? 'checked' : ''; ?> /> MEET</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="MEDIA" <?php echo in_array('MEDIA', $savedCodes) ? 'checked' : ''; ?> /> MEDIA</label></div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-3">
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="X MLA" <?php echo in_array('X MLA', $savedCodes) ? 'checked' : ''; ?> /> X MLA</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="BC (बूथ कमेटी)" <?php echo in_array('BC (बूथ कमेटी)', $savedCodes) ? 'checked' : ''; ?> /> BC (बूथ कमेटी)</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="PP (पेज प्रभारी)" <?php echo in_array('PP (पेज प्रभारी)', $savedCodes) ? 'checked' : ''; ?> /> PP (पेज प्रभारी)</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="IP (प्रभावशाली व्यक्ति)" <?php echo in_array('IP (प्रभावशाली व्यक्ति)', $savedCodes) ? 'checked' : ''; ?> /> IP (प्रभावशाली व्यक्ति)</label></div>
                        </div>
                        <div class="col-md-3">
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="FH (परिवार का मुखिया)" <?php echo in_array('FH (परिवार का मुखिया)', $savedCodes) ? 'checked' : ''; ?> /> FH (परिवार का मुखिया)</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="SMM (सोशल मीडिया मित्र)" <?php echo in_array('SMM (सोशल मीडिया मित्र)', $savedCodes) ? 'checked' : ''; ?> /> SMM (सोशल मीडिया मित्र)</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="MS (महिला समिति)" <?php echo in_array('MS (महिला समिति)', $savedCodes) ? 'checked' : ''; ?> /> MS (महिला समिति)</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="FP (फलिया प्रभारी)" <?php echo in_array('FP (फलिया प्रभारी)', $savedCodes) ? 'checked' : ''; ?> /> FP (फलिया प्रभारी)</label></div>
                        </div>
                        <div class="col-md-3">
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="ER (चुनाव प्रभारी)" <?php echo in_array('ER (चुनाव प्रभारी)', $savedCodes) ? 'checked' : ''; ?> /> ER (चुनाव प्रभारी)</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="वरिष्ठ" <?php echo in_array('वरिष्ठ', $savedCodes) ? 'checked' : ''; ?> /> वरिष्ठ</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="युवा" <?php echo in_array('युवा', $savedCodes) ? 'checked' : ''; ?> /> युवा</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="वोटरप्रभारी(१० घर)" <?php echo in_array('वोटरप्रभारी(१० घर)', $savedCodes) ? 'checked' : ''; ?> /> वोटरप्रभारी(१० घर)</label></div>
                        </div>
                        <div class="col-md-3">
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="BLA (बूथ लेवल एजेंट)" <?php echo in_array('BLA (बूथ लेवल एजेंट)', $savedCodes) ? 'checked' : ''; ?> /> BLA (बूथ लेवल एजेंट)</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="FM (दानदाता)" <?php echo in_array('FM (दानदाता)', $savedCodes) ? 'checked' : ''; ?> /> FM (दानदाता)</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="AK (नवीन सदस्‍य को सक्रिय करना)" <?php echo in_array('AK (नवीन सदस्‍य को सक्रिय करना)', $savedCodes) ? 'checked' : ''; ?> /> AK (नवीन सदस्‍य को सक्रिय करना)</label></div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="form-group col-md-3">
                           <label for="respect_for_women">Nari Samman Yojana</label>
                           <select name="respect_for_women" id="respect_for_women" class="form-control select2">
                              <option value="">Select Option</option>
                              <option value="Yes" <?php echo ($survey->respect_for_women == 'Yes') ? 'selected' : ''; ?>>Yes</option>
                              <option value="No" <?php echo ($survey->respect_for_women == 'No') ? 'selected' : ''; ?>>No</option>
                           </select>
                        </div>
                        <div class="form-group col-md-3">
                           <label for="farmer_loan_waiver">Farmer Loan Waiver</label>
                           <select name="farmer_loan_waiver" id="farmer_loan_waiver" class="form-control select2">
                              <option value="">Select Option</option>
                              <option value="Nahi" <?php echo ($survey->farmer_loan_waiver == 'Nahi') ? 'selected' : ''; ?>>Nahi</option>
                              <option value="Congres" <?php echo ($survey->farmer_loan_waiver == 'Congres') ? 'selected' : ''; ?>>Congress</option>
                              <option value="BJP" <?php echo ($survey->farmer_loan_waiver == 'BJP') ? 'selected' : ''; ?>>BJP</option>
                           </select>
                        </div>
                        <div class="form-group col-md-3">
                           <label for="vehicle">Vehicle</label>
                           <select name="vehicle" id="vehicle" class="form-control select2">
                              <option value="">Select Vehicle</option>
                              <option value="2 wheeler" <?php echo ($survey->vehicle == '2 wheeler') ? 'selected' : ''; ?>>2 wheeler</option>
                              <option value="4 wheeler" <?php echo ($survey->vehicle == '4 wheeler') ? 'selected' : ''; ?>>4 wheeler</option>
                              <option value="Koi Vahan nhi" <?php echo ($survey->vehicle == 'Koi Vahan nhi') ? 'selected' : ''; ?>>Koi Vahan nhi</option>
                           </select>
                        </div>
                        <div class="form-group col-md-3">
                           <label for="facebook">Facebook</label>
                           <input type="text" class="form-control" id="facebook" name="facebook" value="<?php echo $survey->facebook; ?>" />
                        </div>
                     </div>
                     <div class="row">
                        <div class="form-group col-md-3">
                           <label for="instagram">Instagram</label>
                           <input type="text" class="form-control" id="instagram" name="instagram" value="<?php echo $survey->instagram; ?>" />
                        </div>
                        <div class="form-group col-md-3">
                           <label for="twitter">Twitter</label>
                           <input type="text" class="form-control" id="twitter" name="twitter" value="<?php echo $survey->twitter; ?>" />
                        </div>
                        <div class="form-group col-md-3">
                           <label for="image">Image</label>
                           <input type="file" class="form-control" id="image" name="image" />
                        </div>
                        <div class="form-group col-md-3">
                           <label for="reference">Reference</label>
                           <input type="text" class="form-control" id="reference" name="reference" value="<?php echo $survey->reference; ?>" />
                        </div>
                     </div>
                     <div class="row">
                        <div class="form-group col-md-3">
                           <label for="remark">Remark</label>
                           <input type="text" class="form-control" id="remark" name="remark" value="<?php echo $survey->remark; ?>" />
                        </div>
                        <div class="form-group col-md-9">
                           <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </section>
</div>
<script>
   $(document).ready(function () {
       var base_url = "<?php echo base_url()?>";
       var surveyBlockId = "<?php echo $survey->block_name_number; ?>";
       var surveyBoothId = "<?php echo $survey->boothname; ?>";
       var surveyPanchayatId = "<?php echo $survey->grampanchayat; ?>";
       var surveyVillageId = "<?php echo $survey->village; ?>";
       
       $("#district").change(function () {
           var districtId = $(this).val();
           var $vs = $("#vidhan_sabha_id");
           $vs.empty().append('<option value="">N/A</option>').prop("disabled", !districtId);
           if (districtId) {
               $.getJSON(base_url + "getVidhanSabhaByDistrict?district_id=" + districtId, function (data) {
                   if (data && data.length) {
                       $.each(data, function (i, item) {
                           $vs.append('<option value="' + item.id + '">' + (item.vidhan_sabha_name || '') + '</option>');
                       });
                   }
               });
           }
       });
       
       $("#block").change(function () {
           const blockId = $(this).val();
           $("#booth").prop("disabled", !blockId).empty().append('<option value="">Select Booth</option>');
           $("#panchayat").prop("disabled", true).empty().append('<option value="">Select Panchayat</option>');
           $("#village").prop("disabled", true).empty().append('<option value="">Select Village</option>');
   
           if (blockId) {
               $.ajax({
                   url: base_url + "api/get_booths_by_block",
                   type: "POST",
                   data: { block_id: blockId },
                   dataType: "json",
                   success: function (response) {
                       if (!response.error) {
                           $.each(response.booths, function (index, booth) {
                               $("#booth").append('<option bnumbervalue="' + booth.bnumber + '" value="' + booth.id + '">' + booth.name + "</option>");
                           });
                           if (surveyBoothId) {
                               $("#booth").val(surveyBoothId).trigger('change');
                           }
                       }
                   },
               });
           }
       });
   
       $("#booth").change(function () {
           const boothId = $(this).val();
           const bnumbervalue = $(this).find("option:selected").attr("bnumbervalue");
           $("#panchayat").prop("disabled", !boothId).empty().append('<option value="">Select Panchayat</option>');
           $("#village").prop("disabled", true).empty().append('<option value="">Select Village</option>');
   
           if (boothId) {
               $("#boothnumber").val(bnumbervalue);
               $.ajax({
                   url: base_url + "api/get_panchayats_by_booth",
                   type: "POST",
                   data: { booth_id: boothId },
                   dataType: "json",
                   success: function (response) {
                       if (!response.error) {
                           $.each(response.panchayats, function (index, panchayat) {
                               $("#panchayat").append('<option value="' + panchayat.id + '">' + panchayat.name + "</option>");
                           });
                           if (surveyPanchayatId) {
                               $("#panchayat").val(surveyPanchayatId).trigger('change');
                           }
                       }
                   },
               });
           }
       });
   
       $("#panchayat").change(function () {
           const panchayatId = $(this).val();
           $("#village").prop("disabled", !panchayatId).empty().append('<option value="">Select Village</option>');
   
           if (panchayatId) {
               $.ajax({
                   url: base_url + "api/get_villages_by_panchayat",
                   type: "POST",
                   data: { panchayat_id: panchayatId },
                   dataType: "json",
                   success: function (response) {
                       if (!response.error) {
                           $.each(response.villages, function (index, village) {
                               $("#village").append('<option value="' + village.id + '">' + village.name + "</option>");
                           });
                           if (surveyVillageId) {
                               $("#village").val(surveyVillageId);
                           }
                       }
                   },
               });
           }
       });
       
       // Trigger initial load if block is selected
       if (surveyBlockId) {
           $("#block").val(surveyBlockId).trigger('change');
       }
   });
</script>