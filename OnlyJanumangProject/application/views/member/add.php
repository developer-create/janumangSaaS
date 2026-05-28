<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <i class="fa fa-list"></i> Survey Management
         <small>Add Survey Details</small>
      </h1>
   </section>
   <section class="content">
      <div class="row">
         <!-- left column -->
         <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
               <div class="box-header">
                  <h3 class="box-title">Enter Survey Details</h3>
               </div>
               <!-- /.box-header -->
               <!-- form start -->
               <?php $this->load->helper("form"); ?>
               <form action="<?php echo base_url()?>ServayController/createServay" method="post"  enctype="multipart/form-data">
                  <div class="container-fluid">
                     <h2>Survey Form</h2>
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
                              <option value="<?php echo $district->id; ?>"><?php echo $district->name; ?></option>
                              <?php endforeach; ?>
                           </select>
                        </div>
                        <div class="form-group col-md-3">
                           <label for="vidhan_sabha_id">Vidhan Sabha</label>
                           <select name="vidhan_sabha_id" id="vidhan_sabha_id" class="form-control select2" disabled>
                              <option value="">Select District first</option>
                           </select>
                        </div>
                        <div class="form-group col-md-3">
                           <label for="samithi">Samithi</label>
                           <select name="samithi" id="samithi" class="form-control select2">
                              <option value="">Select Committee</option>
                              <?php foreach ($committees as $committee): ?>
                              <option value="<?php echo $committee->id; ?>"><?php echo $committee->name; ?></option>
                              <?php endforeach; ?>
                           </select>
                        </div>
                        <div class="form-group col-md-3">
                           <label for="block_name_number">Block Name</label>
                           <select name="block_name_number" id="block" class="form-control select2">
                              <option value="">Select Block</option>
                              <?php foreach ($blocks as $block): ?>
                              <option value="<?php echo $block->id; ?>"><?php echo $block->name; ?></option>
                              <?php endforeach; ?>
                           </select>
                        </div>
                     </div>
                     <div class="row">
                        <div class="form-group col-md-3">
                           <label for="janpad_panchayat">Janpad Panchayat</label>
                           <input type="text" class="form-control" id="janpad_panchayat" name="janpad_panchayat" value="<?php echo set_value('janpad_panchayat'); ?>" />
                        </div>
                        <div class="form-group col-md-3">
                           <label for="mandalam">Mandalam</label>
                           <input type="text" class="form-control" id="mandalam" name="mandalam" value="<?php echo set_value('mandalam'); ?>" />
                        </div>
                        <div class="form-group col-md-3">
                           <label for="toll">Majra/Falia/Tolla</label>
                           <input type="text" class="form-control" id="toll" name="toll" value="<?php echo set_value('toll'); ?>" />
                        </div>
                        <div class="form-group col-md-3">
                           <label for="padvarsh">Post-Year</label>
                           <input type="text" class="form-control" id="padvarsh" name="padvarsh" value="<?php echo set_value('padvarsh'); ?>" />
                        </div>
                     </div>
                     <div class="row">
                        <div class="form-group col-md-3">
                           <label for="boothname">Booth Name</label>
                           <select name="boothname" id="booth" disabled class="form-control select2">
                              <option value="">Select Booth</option>
                           </select>
                        </div>
                        <div class="form-group col-md-3">
                           <label for="boothnumber">Booth Number</label>
                           <input type="text" class="form-control" id="boothnumber" name="boothnumber" value="<?php echo set_value('boothnumber'); ?>" />
                        </div>
                        <div class="form-group col-md-3">
                           <label for="grampanchayat">Gram Panchayat</label>
                           <select name="grampanchayat" id="panchayat" disabled class="form-control select2">
                              <option value="">Select Panchayat</option>
                           </select>
                        </div>
                        <div class="form-group col-md-3">
                           <label for="village">Village</label>
                           <select name="village" id="village" disabled class="form-control select2">
                              <option value="">Select Village</option>
                           </select>
                        </div>
                     </div>
                     <div class="row">
                        <div class="form-group col-md-3">
                           <label for="name">Name</label>
                           <input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name'); ?>" />
                        </div>
                        <div class="form-group col-md-3">
                           <label for="fathername">Father's Name</label>
                           <input type="text" class="form-control" id="fathername" name="fathername" value="<?php echo set_value('fathername'); ?>" />
                        </div>
                        <div class="form-group col-md-3">
                           <label for="jaati">Caste</label>
                           <select name="jaati" id="jaati" class="form-control select2">
                              <option value="">Select Caste</option>
                              <option value="ST (bhil)" <?php echo set_select('jaati', 'ST (bhil)'); ?>>ST (bhil)</option>
                              <option value="ST (Bhilala)" <?php echo set_select('jaati', 'ST (Bhilala)'); ?>>ST (Bhilala)</option>
                              <option value="Muslim" <?php echo set_select('jaati', 'Muslim'); ?>>Muslim</option>
                              <option value="Brahman" <?php echo set_select('jaati', 'Brahman'); ?>>Brahman</option>
                              <option value="Sirvi" <?php echo set_select('jaati', 'Sirvi'); ?>>Sirvi</option>
                              <option value="Maheshwari" <?php echo set_select('jaati', 'Maheshwari'); ?>>Maheshwari</option>
                              <option value="Prajapati" <?php echo set_select('jaati', 'Prajapati'); ?>>Prajapati</option>
                              <option value="Rajput" <?php echo set_select('jaati', 'Rajput'); ?>>Rajput</option>
                              <option value="Lohar" <?php echo set_select('jaati', 'Lohar'); ?>>Lohar</option>
                              <option value="Sikh" <?php echo set_select('jaati', 'Sikh'); ?>>Sikh</option>
                              <option value="Rathor" <?php echo set_select('jaati', 'Rathor'); ?>>Rathor</option>
                              <option value="Jain" <?php echo set_select('jaati', 'Jain'); ?>>Jain</option>
                              <option value="Bohra" <?php echo set_select('jaati', 'Bohra'); ?>>Bohra</option>
                              <option value="other" <?php echo set_select('jaati', 'other'); ?>>Other</option>
                           </select>
                        </div>
                        <div class="form-group col-md-3">
                           <label for="gender">Gender</label>
                           <select name="gender" id="gender" class="form-control select2">
                              <option value="">Select Gender</option>
                              <option value="Male" <?php echo set_select('gender', 'Male'); ?>>Male</option>
                              <option value="Female" <?php echo set_select('gender', 'Female'); ?>>Female</option>
                              <option value="other" <?php echo set_select('gender', 'other'); ?>>Other</option>
                           </select>
                        </div>
                     </div>
                     <div class="row">
                        <div class="form-group col-md-3">
                           <label for="dob">Date of Birth</label>
                           <input type="date" class="form-control" id="dob" name="dob" value="<?php echo set_value('dob'); ?>" />
                        </div>
                        <div class="form-group col-md-3">
                           <label for="age">Age</label>
                           <input type="text" class="form-control" id="age" name="age" value="<?php echo set_value('age'); ?>" />
                        </div>
                        <div class="form-group col-md-3">
                           <label for="dom">Date of Marriage</label>
                           <input type="date" class="form-control" id="dom" name="dom" value="<?php echo set_value('dom'); ?>" />
                        </div>
                        <div class="form-group col-md-3">
                           <label for="education">Education</label>
                           <select name="education" id="education" class="form-control select2">
                              <option value="">Select Education</option>
                              <option value="uneducate" <?php echo set_select('education', 'uneducate'); ?>>Uneducate</option>
                              <option value="educate" <?php echo set_select('education', 'educate'); ?>>Educate</option>
                              <option value="5th" <?php echo set_select('education', '5th'); ?>>5th</option>
                              <option value="8th" <?php echo set_select('education', '8th'); ?>>8th</option>
                              <option value="10th" <?php echo set_select('education', '10th'); ?>>10th</option>
                              <option value="12th" <?php echo set_select('education', '12th'); ?>>12th</option>
                              <option value="Gradute" <?php echo set_select('education', 'Gradute'); ?>>Graduate</option>
                              <option value="Post-Gradute" <?php echo set_select('education', 'Post-Gradute'); ?>>Post-Graduate</option>
                           </select>
                        </div>
                     </div>
                     <div class="row">
                        <div class="form-group col-md-3">
                           <label for="mobile">Mobile</label>
                           <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo set_value('mobile'); ?>" />
                        </div>
                        <div class="form-group col-md-3">
                           <label for="votarcode">Voter Code</label>
                           <input type="text" class="form-control" id="votarcode" name="votarcode" value="<?php echo set_value('votarcode'); ?>" />
                        </div>
                        <div class="form-group col-md-3">
                           <label for="address">Address</label>
                           <textarea class="form-control" id="address" name="address" rows="3"><?php echo set_value('address'); ?></textarea>
                        </div>
                        <div class="form-group col-md-3">
                           <label for="group">Group</label>
                           <input type="text" class="form-control" id="group" name="group" value="<?php echo set_value('group'); ?>" />
                        </div>
                     </div>
                     <div class="row">
                        <div class="form-group col-md-3">
                           <label for="government_employee">Government Employee</label>
                           <input type="text" class="form-control" id="government_employee" name="government_employee" value="<?php echo set_value('government_employee'); ?>" />
                        </div>
                        <div class="form-group col-md-3">
                           <label for="parti">Party</label>
                           <select name="parti" id="parti" class="form-control select2">
                              <option value="">Select Party</option>
                              <?php foreach ($parties as $party): ?>
                              <option value="<?php echo $party->id; ?>" <?php echo set_select('parti', $party->id); ?>><?php echo $party->name; ?></option>
                              <?php endforeach; ?>
                           </select>
                        </div>
                     </div>
                     
                     <div class="row">
                        <div class="form-group col-md-12">
                           <label><strong>Code</strong></label>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-3">
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="SC" /> SC</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="YC" /> YC</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="WC" /> WC</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="PA" /> PA</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="SM" /> SM</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="EO" /> EO</label></div>
                        </div>
                        <div class="col-md-3">
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="GS" /> GS</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="DCC" /> DCC</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="PW" /> PW</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="NL" /> NL</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="FR" /> FR</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="SO" /> SO</label></div>
                        </div>
                        <div class="col-md-3">
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="ST" /> ST</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="REF" /> REF</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="US" /> US</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="SMW" /> SMW</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="DYC" /> DYC</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="OBC" /> OBC</label></div>
                        </div>
                        <div class="col-md-3">
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="DT" /> DT</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="DP" /> DP</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="MLA" /> MLA</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="AVP" /> AVP</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="MEET" /> MEET</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="MEDIA" /> MEDIA</label></div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-3">
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="X MLA" /> X MLA</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="BC (बूथ कमेटी)" /> BC (बूथ कमेटी)</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="PP (पेज प्रभारी)" /> PP (पेज प्रभारी)</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="IP (प्रभावशाली व्यक्ति)" /> IP (प्रभावशाली व्यक्ति)</label></div>
                        </div>
                        <div class="col-md-3">
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="FH (परिवार का मुखिया)" /> FH (परिवार का मुखिया)</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="SMM (सोशल मीडिया मित्र)" /> SMM (सोशल मीडिया मित्र)</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="MS (महिला समिति)" /> MS (महिला समिति)</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="FP (फलिया प्रभारी)" /> FP (फलिया प्रभारी)</label></div>
                        </div>
                        <div class="col-md-3">
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="ER (चुनाव प्रभारी)" /> ER (चुनाव प्रभारी)</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="वरिष्ठ" /> वरिष्ठ</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="युवा" /> युवा</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="वोटरप्रभारी(१० घर)" /> वोटरप्रभारी(१० घर)</label></div>
                        </div>
                        <div class="col-md-3">
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="BLA (बूथ लेवल एजेंट)" /> BLA (बूथ लेवल एजेंट)</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="FM (दानदाता)" /> FM (दानदाता)</label></div>
                           <div class="checkbox"><label><input type="checkbox" name="code[]" value="AK (नवीन सदस्‍य को सक्रिय करना)" /> AK (नवीन सदस्‍य को सक्रिय करना)</label></div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="form-group col-md-3">
                           <label for="respect_for_women">Nari Samman Yojana</label>
                           <select name="respect_for_women" id="respect_for_women" class="form-control select2">
                              <option value="">Select Option</option>
                              <option value="Yes" <?php echo set_select('respect_for_women', 'Yes'); ?>>Yes</option>
                              <option value="No" <?php echo set_select('respect_for_women', 'No'); ?>>No</option>
                           </select>
                        </div>
                        <div class="form-group col-md-3">
                           <label for="farmer_loan_waiver">Farmer Loan Waiver</label>
                           <select name="farmer_loan_waiver" id="farmer_loan_waiver" class="form-control select2">
                              <option value="">Select Option</option>
                              <option value="Nahi" <?php echo set_select('farmer_loan_waiver', 'Nahi'); ?>>Nahi</option>
                              <option value="Congres" <?php echo set_select('farmer_loan_waiver', 'Congres'); ?>>Congress</option>
                              <option value="BJP" <?php echo set_select('farmer_loan_waiver', 'BJP'); ?>>BJP</option>
                           </select>
                        </div>
                        <div class="form-group col-md-3">
                           <label for="vehicle">Vehicle</label>
                           <select name="vehicle" id="vehicle" class="form-control select2">
                              <option value="">Select Vehicle</option>
                              <option value="2 wheeler" <?php echo set_select('vehicle', '2 wheeler'); ?>>2 wheeler</option>
                              <option value="4 wheeler" <?php echo set_select('vehicle', '4 wheeler'); ?>>4 wheeler</option>
                              <option value="Koi Vahan nhi" <?php echo set_select('vehicle', 'Koi Vahan nhi'); ?>>Koi Vahan nhi</option>
                           </select>
                        </div>
                        <div class="form-group col-md-3">
                           <label for="facebook">Facebook</label>
                           <input type="text" class="form-control" id="facebook" name="facebook" value="<?php echo set_value('facebook'); ?>" />
                        </div>
                     </div>
                     <div class="row">
                        <div class="form-group col-md-3">
                           <label for="instagram">Instagram</label>
                           <input type="text" class="form-control" id="instagram" name="instagram" value="<?php echo set_value('instagram'); ?>" />
                        </div>
                        <div class="form-group col-md-3">
                           <label for="twitter">Twitter</label>
                           <input type="text" class="form-control" id="twitter" name="twitter" value="<?php echo set_value('twitter'); ?>" />
                        </div>
                        <div class="form-group col-md-3">
                           <label for="image">Image</label>
                           <input type="file" class="form-control" id="image" name="image" />
                        </div>
                        <div class="form-group col-md-3">
                           <label for="reference">Reference</label>
                           <input type="text" class="form-control" id="reference" name="reference" value="<?php echo set_value('reference'); ?>" />
                        </div>
                     </div>
                     <div class="row">
                        <div class="form-group col-md-3">
                           <label for="remark">Remark</label>
                           <input type="text" class="form-control" id="remark" name="remark" value="<?php echo set_value('remark'); ?>" />
                        </div>
                        <div class="form-group col-md-9">
                           <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                     </div>
                  </div-fluid>
               </form>
            </div>
         </div>
      </div>
   </section>
</div>
<script>
   $(document).ready(function () {
       var base_url = "<?php echo base_url()?>";
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
                   url: base_url + "api/get_booths_by_block", // Your controller method
                   type: "POST",
                   data: { block_id: blockId },
                   dataType: "json",
                   success: function (response) {
                       if (!response.error) {
                           $.each(response.booths, function (index, booth) {
                               $("#booth").append('<option bnumbervalue="' + booth.bnumber + '" value="' + booth.id + '">' + booth.name + "</option>");
                           });
                       } else {
                           alert(response.message);
                       }
                   },
               });
           }
       });
   
       $("#booth").change(function () {
           const boothId = $(this).val();
            const bnumbervalue = $(this).find("option:selected").attr("bnumbervalue"); // Get the bnumbervalue attribute

           $("#panchayat").prop("disabled", !boothId).empty().append('<option value="">Select Panchayat</option>');
           $("#village").prop("disabled", true).empty().append('<option value="">Select Village</option>');
   
           if (boothId) {
               $("#boothnumber").val(bnumbervalue);
               $.ajax({
                   url: base_url + "api/get_panchayats_by_booth", // Your controller method
                   type: "POST",
                   data: { booth_id: boothId },
                   dataType: "json",
                   success: function (response) {
                       if (!response.error) {
                           $.each(response.panchayats, function (index, panchayat) {
                               $("#panchayat").append('<option value="' + panchayat.id + '">' + panchayat.name + "</option>");
                           });
                       } else {
                           alert(response.message);
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
                   url: base_url + "api/get_villages_by_panchayat", // Your controller method
                   type: "POST",
                   data: { panchayat_id: panchayatId },
                   dataType: "json",
                   success: function (response) {
                       if (!response.error) {
                           $.each(response.villages, function (index, village) {
                               $("#village").append('<option value="' + village.id + '">' + village.name + "</option>");
                           });
                       } else {
                           alert(response.message);
                       }
                   },
               });
           }
       });
   });
</script>