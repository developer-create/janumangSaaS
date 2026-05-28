<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Member Management
        </h1>
    </section>
    <section class="content">
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
                        <h3 class="box-title">Member List</h3>
                        <a href="<?php echo base_url() ?>ServayController/createServay"
                            class="btn btn-info btn-sm pull-right" style="margin-left: 5px;">Add New</a>
                        <a href="<?php echo base_url() ?>user/member_bulk_upload"
                            class="btn btn-success btn-sm pull-right">Bulk Upload</a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- Tab Navigation -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#all-records" aria-controls="all-records" role="tab" data-toggle="tab" data-tab="all">All Records</a>
                            </li>
                            <li role="presentation">
                                <a href="#vidhan-sabha-records" aria-controls="vidhan-sabha-records" role="tab" data-toggle="tab" data-tab="vidhan-sabha">Vidhan Sabha Member</a>
                            </li>
                            <li role="presentation">
                                <a href="#mp-records" aria-controls="mp-records" role="tab" data-toggle="tab" data-tab="mp">MP Member</a>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="all-records">
                                <br>
                                <!-- Filter Form for All Records -->
                                <div id="filter-form">
                                    <?php $f = isset($filters) ? $filters : []; ?>
                                    <form id="servayFilterForm" method="post" action="<?php echo base_url('user/servaylisting'); ?>">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="block">Block</label>
                                                    <select name="block" id="block" class="form-control">
                                                        <option value="">Select Block</option>
                                                        <?php
                                                  $userid = $this->session->userdata('userId');
                                                  $sessionBlockId = $this->session->userdata('blockId');
                                                  //  $this->db->where('id !=', 6);
                                                  if ($sessionBlockId != 0) {
                                                      $userBlockIds = $this->db->select('blockId')
                                                         ->from('tbl_users')
                                                         ->where('userId', $userid)
                                                         ->get()
                                                         ->row()
                                                         ->blockId;
                                                         
                                                         $blockIdsArray = explode(',', $userBlockIds);
                                                         $this->db->where_in('block.id', $blockIdsArray);
                                                  }
                                                  $blocks = $this->db->get('block')->result();
                                                  foreach ($blocks as $blk) {
                                                     $sel = (isset($f['block']) && (string)$f['block'] === (string)$blk->id) ? ' selected' : '';
                                                     echo "<option value='{$blk->id}'{$sel}>{$blk->name}</option>";
                                                  }
                                                  ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="year">Year</label>
                                                    <select name="year" id="year" class="form-control">
                                                        <option value="">Select Year</option>
                                                        <?php
                                                  // Generate year options
                                                  $current_year = date('Y');
                                                  for ($i = $current_year; $i >= $current_year - 5; $i--) {
                                                      $sel = (isset($f['year']) && (string)$f['year'] === (string)$i) ? ' selected' : '';
                                                      echo "<option value='{$i}'{$sel}>{$i}</option>";
                                                  }
                                                  ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="vehicle">Vehicle</label>
                                                    <select name="vehicle" id="vehicle" class="form-control">
                                                        <option value="">Select Vehicle</option>
                                                        <?php
                                                  $months = [
                                                      '2 व्हीलर' => '2 व्हीलर',
                                                      '4 व्हीलर' => '4 व्हीलर',
                                                      '2 व्हीलर,4 व्हीलर' => 'Both', 
                                                  ];
                                                  foreach ($months as $key => $value) {
                                                      $sel = (isset($f['vehicle']) && (string)$f['vehicle'] === (string)$key) ? ' selected' : '';
                                                      echo "<option value='{$key}'{$sel}>{$value}</option>";
                                                  }
                                                  ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="samithi">Samiti</label>
                                                    <select name="samithi" id="samithi" class="form-control">
                                                        <option value="">Select Samiti</option>
                                                        <?php
                                                  // Fetch blocks from database
                                                  $blocks = $this->db->get('samiti')->result();
                                                  foreach ($blocks as $blk) {
                                                      $sel = (isset($f['samithi']) && (string)$f['samithi'] === (string)$blk->id) ? ' selected' : '';
                                                      echo "<option value='{$blk->id}'{$sel}>{$blk->name}</option>";
                                                  }
                                                  ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="district">District</label>
                                                    <select name="district" id="filter_district" class="form-control">
                                                        <option value="">Select District</option>
                                                        <?php
                                                        if (!empty($districts_list)) {
                                                            foreach ($districts_list as $d) {
                                                                $sel = (isset($f['district']) && (string)$f['district'] === (string)$d->id) ? ' selected' : '';
                                                                echo '<option value="' . (int)$d->id . '"' . $sel . '>' . htmlspecialchars($d->name) . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="vidhan_sabha_id">Vidhan Sabha</label>
                                                    <select name="vidhan_sabha_id" id="filter_vidhan_sabha" class="form-control">
                                                        <option value="">Select Vidhan Sabha</option>
                                                        <option value="0"<?php echo (isset($f['vidhan_sabha_id']) && (string)$f['vidhan_sabha_id'] === '0') ? ' selected' : ''; ?>>N/A (no Vidhan Sabha)</option>
                                                        <?php
                                                        if (!empty($vidhan_sabhas_list)) {
                                                            foreach ($vidhan_sabhas_list as $vs) {
                                                                $vsId = isset($vs['id']) ? $vs['id'] : $vs->id;
                                                                $vsName = isset($vs['vidhan_sabha_name']) ? $vs['vidhan_sabha_name'] : $vs->vidhan_sabha_name;
                                                                $dName = isset($vs['district_name']) ? $vs['district_name'] : (isset($vs->district_name) ? $vs->district_name : '');
                                                                $sel = (isset($f['vidhan_sabha_id']) && (string)$f['vidhan_sabha_id'] === (string)$vsId) ? ' selected' : '';
                                                                echo '<option value="' . (int)$vsId . '"' . $sel . '>' . htmlspecialchars($vsName) . ($dName ? ' (' . htmlspecialchars($dName) . ')' : '') . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="code">Code</label>
                                                    <select name="code" id="code" class="form-control">
                                                        <option value="">Select Code</option>
                                                        <?php
                                                        $code_opts = [
                                                            'SC' => 'SC', 'YC' => 'YC', 'WC' => 'WC', 'PA' => 'PA', 'SM' => 'SM', 'EO' => 'EO', 'GS' => 'GS', 'DCC' => 'DCC', 'PW' => 'PW', 'NL' => 'NL', 'FR' => 'FR', 'SO' => 'SO', 'ST' => 'ST', 'REF' => 'REF', 'US' => 'US', 'SMW' => 'SMW', 'DYC' => 'DYC', 'OBC' => 'OBC', 'DT' => 'DT', 'DP' => 'DP', 'MLA' => 'MLA', 'AVP' => 'AVP', 'MEET' => 'MEET', 'MEDIA' => 'MEDIA', 'X MLA' => 'X MLA',
                                                            'BC (बूथ कमेटी)' => 'BC (बूथ कमेटी)', 'PP (पेज प्रभारी)' => 'PP (पेज प्रभारी)', 'IP (प्रभावशाली व्यक्ति)' => 'IP (प्रभावशाली व्यक्ति)', 'FH (परिवार का मुखिया)' => 'FH (परिवार का मुखिया)', 'SMM (सोशल मीडिया मित्र)' => 'SMM (सोशल मीडिया मित्र)', 'MS (महिला समिति)' => 'MS (महिला समिति)', 'FP (फलिया प्रभारी)' => 'FP (फलिया प्रभारी)', 'ER (चुनाव प्रभारी)' => 'ER (चुनाव प्रभारी)', 'वरिष्ठ' => 'वरिष्ठ', 'युवा' => 'युवा', 'वोटरप्रभारी(१० घर)' => 'वोटरप्रभारी(१० घर)', 'BLA (बूथ लेवल एजेंट)' => 'BLA (बूथ लेवल एजेंट)', 'FM (दानदाता)' => 'FM (दानदाता)', 'AK (नवीन सदस्‍य को सक्रिय करना)' => 'AK (नवीन सदस्‍य को सक्रिय करना)',
                                                        ];
                                                        foreach ($code_opts as $cv => $cl) {
                                                            $sel = (isset($f['code']) && (string)$f['code'] === (string)$cv) ? ' selected' : '';
                                                            echo '<option value="' . htmlspecialchars($cv) . '"' . $sel . '>' . htmlspecialchars($cl) . '</option>';
                                                        }
                                                        ?>
                                                    </select>
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
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="vidhan-sabha-records">
                                <br>
                                <p class="text-info">Showing Vidhan Sabha Members (records with block values, excluding Other)</p>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="mp-records">
                                <br>
                                <p class="text-info">Showing MP Members (records with "Other" block designation)</p>
                            </div>
                        </div>
                        
                        <!-- Main Data Table (Always Visible) -->
                        <div class="table-responsive" style="margin-top: 15px;">
                        <table id="feedbackTa" class="table table-bordered table-striped">
                                    <thead>
                                        <tr style="color:white;font-size:15px;background:#020254;">
                                            <th>#</th>
                                            <th>Created By</th>
                                            <th>District</th>
                                            <th>Vidhan Sabha</th>
                                            <th>Name</th>
                                            <th>Votar Id</th>
                                            <th>Mobile</th>
                                            <th>Father Name</th>
                                            <th>Date Of Birth</th>
                                            <th>Date Of marriage</th>
                                            <th>Block Name</th>
                                            <th>Janpad Panchayat</th>
                                            <th>Mandalam</th>
                                            <th>Booth Name</th>
                                            <th>Booth Number</th>
                                            <th>Grampanchayat</th>
                                            <th>Village</th>
                                            <th>Samiti</th>

                                            <th>Toll/Majra</th>
                                            <th>Caste</th>
                                            <th>Age</th>
                                            <th>Education</th>
                                            <th>Address</th>
                                            <th>Gender</th>
                                            <th>Vehicle</th>
                                            <th>Group</th>
                                            <th>Government Employee</th>
                                            <th>Party</th>
                                            <th>पद वर्ष </th>
                                            <th>Code</th>
                                            <th>Nari Samman Yojna </th>
                                            <th>Farmer Loan Waiver</th>
                                            <th>Facebook</th>
                                            <th>Instagram</th>
                                            <th>Twitter</th>
                                            <th>Reference</th>
                                            <th>Remark</th>
                                            <th>Start Lat</th>
                                            <th>Start long</th>
                                            <th>Start Date</th>
                                            <th>End Lat</th>
                                            <th>End long</th>
                                            <th>End Date</th>
                                            <th>Image</th>
                                            <th>Created On</th>
                                            <th>Update Date</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                 if (isset($userRecords) && !empty($userRecords))
                                 {
                                     $i=1;
                                     foreach($userRecords  as  $key => $record)
                                     {
                                         if($record->servayid!='own')
                                         {
                                 ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo isset($record->user_name) ? htmlspecialchars($record->user_name) : ''; ?></td>
                                            <td><?php echo isset($record->district_name_str) ? htmlspecialchars($record->district_name_str) : ''; ?></td>
                                            <td><?php echo isset($record->vs_name_str) && $record->vs_name_str != '' ? htmlspecialchars($record->vs_name_str) : 'N/A'; ?></td>
                                            <td><?php echo @$record->name ?></td>
                                            <td><?php echo @$record->votarcode ?></td>
                                            <td><?php echo @$record->mobile ?></td>
                                            <td><?php echo @$record->fathername ?></td>
                                             <td><?php if(!empty($record->dob) && $record->dob != '0000-00-00'){ echo date('d-m-Y',strtotime($record->dob));} ?>
                                             </td>
                                             <td><?php if(!empty($record->dom) && $record->dom != '0000-00-00'){ echo date('d-m-Y',strtotime($record->dom));} ?>
                                             </td>
                                            <td><?php echo isset($record->block_name_str) ? htmlspecialchars($record->block_name_str) : ''; ?></td>
                                            <td><?php echo @$record->janpad_panchayat; ?></td>
                                            <td><?php echo @$record->mandalam; ?></td>
                                            <td><?php echo isset($record->booth_name_str) ? htmlspecialchars($record->booth_name_str) : ''; ?></td>
                                            <td><?php echo @$record->boothnumber; ?> </td>
                                            <td><?php echo isset($record->panchayat_name_str) ? htmlspecialchars($record->panchayat_name_str) : ''; ?></td>
                                            <td><?php echo isset($record->village_name_str) ? htmlspecialchars($record->village_name_str) : ''; ?></td>
                                            <td><?php echo isset($record->samiti_name_str) ? htmlspecialchars($record->samiti_name_str) : ''; ?></td>

                                            <td><?php echo @$record->toll;  ?></td>
                                            <td><?php echo @$record->jaati; ?></td>
                                            <td><?php echo @$record->age; ?></td>
                                            <td><?php echo @$record->education; ?></td>
                                            <td><?php echo @$record->address; ?></td>
                                            <td><?php echo @$record->gender; ?></td>
                                            <td><?php echo @$record->vehicle; ?></td>
                                            <td><?php echo @$record->group; ?></td>
                                            <td><?php echo @$record->government_employee; ?></td>
                                            <td><?php echo isset($record->party_name_str) ? htmlspecialchars($record->party_name_str) : ''; ?></td>
                                            <td><?php echo @$record->padvarsh; ?></td>
                                            <td><?php echo @$record->code; ?></td>
                                            <td><?php echo @$record->respect_for_women; ?></td>
                                            <td><?php echo @$record->farmer_loan_waiver; ?></td>
                                            <td><?php echo @$record->facebook; ?></td>
                                            <td><?php echo @$record->instagram; ?></td>
                                            <td><?php echo @$record->twitter; ?></td>
                                            <td><?php echo @$record->reference; ?></td>
                                            <td><?php echo @$record->remark; ?></td>
                                            <td><?php echo @$record->lat; ?></td>
                                            <td><?php echo @$record->long; ?></td>
                                            <td><?php echo @$record->startdate; ?></td>
                                            <td><?php echo @$record->end_lat; ?></td>
                                            <td><?php echo @$record->end_long; ?></td>
                                            <td><?php echo @$record->enddate; ?></td>
                                            <td><?php if(@$record->image!=''){ ?>
                                                <a href='<?php echo base_url() ?>uploads/userservey/<?php echo $record->image; ?>'
                                                    class="btn btn-sm btn-primary" target="_blank" title="View Image">
                                                    <i class="fa fa-eye"></i>
                                                    view File
                                                </a>
                                                <?php }else{ echo"No-Image";} ?>
                                            </td>
                                            <td><?php echo $record->create_date ?></td>
                                            <td><?php echo @$record->update_date ?></td>
                                            <td class="text-center">
                                                <!--<a class="btn btn-sm btn-primary" href="<?= base_url().'login-history/'.$record->id; ?>" title="Login history"><i class="fa fa-history"></i></a> | -->
                                                <a class="btn btn-sm btn-info"
                                                    href="<?php echo base_url().'ServayController/editServay/'.$record->id; ?>"
                                                    title="Edit"><i class="fa fa-pencil"></i></a>
                                                <a class="btn btn-sm btn-info"
                                                    href="<?php echo base_url().'editservayview/'.$record->id; ?>"
                                                    title="Edit"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                <a class="btn btn-sm btn-danger"
                                                    href="<?php echo base_url().'User/deletestatus/'.$record->id; ?>"
                                                    data-userid="<?php echo $record->id; ?>" title="Delete"><i
                                                        class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <?php
                                 }
                                 }
                                 }
                                 ?>
                    </tbody>
                                </table>
                        </div>
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
</div>

<!-- Survey Detail Modal -->
<div class="modal fade" id="surveyDetailModal" tabindex="-1" role="dialog" aria-labelledby="surveyDetailModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #3c8dbc; color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="surveyDetailModalLabel"><i class="fa fa-user"></i> Survey Details - <span id="modal-title-name"></span></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3 text-center">
                        <div id="modal-image-container" style="margin-bottom: 20px;">
                            <!-- Image will be injected here -->
                        </div>
                        <div class="well well-sm">
                            <span class="detail-label">Votar ID / Code</span>
                            <span class="detail-value"><span id="modal-votar-id"></span> / <span id="modal-code"></span></span>
                        </div>
                        <div class="well well-sm">
                            <span class="detail-label">Created Date</span>
                            <span class="detail-value" id="modal-created-date"></span>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <!-- Column 1 -->
                            <div class="col-md-4 modal-detail-row">
                                <span class="detail-label">Member Name</span>
                                <span class="detail-value" id="modal-name"></span>
                            </div>
                            <div class="col-md-4 modal-detail-row">
                                <span class="detail-label">Father Name</span>
                                <span class="detail-value" id="modal-father"></span>
                            </div>
                            <div class="col-md-4 modal-detail-row">
                                <span class="detail-label">Gender / Age</span>
                                <span class="detail-value"><span id="modal-gender"></span> / <span id="modal-age"></span> yrs</span>
                            </div>
                            
                            <!-- Column 2 -->
                            <div class="col-md-4 modal-detail-row">
                                <span class="detail-label">Block</span>
                                <span class="detail-value" id="modal-block"></span>
                            </div>
                            <div class="col-md-4 modal-detail-row">
                                <span class="detail-label">Janpad Panchayat</span>
                                <span class="detail-value" id="modal-janpad"></span>
                            </div>
                            <div class="col-md-4 modal-detail-row">
                                <span class="detail-label">Mandalam</span>
                                <span class="detail-value" id="modal-mandalam"></span>
                            </div>
                            <div class="col-md-4 modal-detail-row">
                                <span class="detail-label">Panchayat</span>
                                <span class="detail-value" id="modal-panchayat"></span>
                            </div>
                            <div class="col-md-4 modal-detail-row">
                                <span class="detail-label">Village</span>
                                <span class="detail-value" id="modal-village"></span>
                            </div>

                            <!-- Column 3 -->
                            <div class="col-md-4 modal-detail-row">
                                <span class="detail-label">Booth / Number</span>
                                <span class="detail-value"><span id="modal-booth-name"></span> (<span id="modal-booth-no"></span>)</span>
                            </div>
                            <div class="col-md-4 modal-detail-row">
                                <span class="detail-label">Toll</span>
                                <span class="detail-value" id="modal-toll"></span>
                            </div>
                            <div class="col-md-4 modal-detail-row">
                                <span class="detail-label">Mobile</span>
                                <span class="detail-value" id="modal-mobile"></span>
                            </div>

                            <!-- Column 4 -->
                            <div class="col-md-4 modal-detail-row">
                                <span class="detail-label">Education</span>
                                <span class="detail-value" id="modal-education"></span>
                            </div>
                            <div class="col-md-4 modal-detail-row">
                                <span class="detail-label">Cast (Jaati)</span>
                                <span class="detail-value" id="modal-jaati"></span>
                            </div>
                            <div class="col-md-4 modal-detail-row">
                                <span class="detail-label">Address</span>
                                <span class="detail-value" id="modal-address"></span>
                            </div>

                            <!-- Column 5 -->
                            <div class="col-md-4 modal-detail-row">
                                <span class="detail-label">DOB / DOM</span>
                                <span class="detail-value"><span id="modal-dob"></span> / <span id="modal-dom"></span></span>
                            </div>
                            <div class="col-md-4 modal-detail-row">
                                <span class="detail-label">Vehicle</span>
                                <span class="detail-value" id="modal-vehicle"></span>
                            </div>
                            <div class="col-md-4 modal-detail-row">
                                <span class="detail-label">Group</span>
                                <span class="detail-value" id="modal-group"></span>
                            </div>

                            <!-- Column 6 -->
                            <div class="col-md-4 modal-detail-row">
                                <span class="detail-label">Govt Employee</span>
                                <span class="detail-value" id="modal-gov-emp"></span>
                            </div>
                            <div class="col-md-4 modal-detail-row">
                                <span class="detail-label">Party / Post Year</span>
                                <span class="detail-value"><span id="modal-party"></span> / <span id="modal-pad"></span></span>
                            </div>
                            <div class="col-md-4 modal-detail-row">
                                <span class="detail-label">Reference</span>
                                <span class="detail-value" id="modal-reference"></span>
                            </div>

                            <!-- Row 7 -->
                            <div class="col-md-4 modal-detail-row">
                                <span class="detail-label">Nari Samman / Loan Waiver</span>
                                <span class="detail-value"><span id="modal-nari"></span> / <span id="modal-loan"></span></span>
                            </div>
                            <div class="col-md-8 modal-detail-row">
                                <span class="detail-label">Remark</span>
                                <span class="detail-value" id="modal-remark"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Social Media & Technical Details -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="panel panel-info">
                            <div class="panel-heading"><b>Social Media</b></div>
                            <div class="panel-body">
                                <div><b>FB:</b> <span id="modal-fb"></span></div>
                                <div><b>IG:</b> <span id="modal-ig"></span></div>
                                <div><b>TW:</b> <span id="modal-tw"></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="panel panel-default">
                            <div class="panel-heading"><b>Samiti & Technical Details</b></div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b>Samiti:</b> <span id="modal-samiti"></span><br>
                                        <b>Created By:</b> <span id="modal-member-id"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <b>Start:</b> <span id="modal-start-date"></span> (<span id="modal-start-lat"></span>, <span id="modal-start-long"></span>)<br>
                                        <b>End:</b> <span id="modal-end-date"></span> (<span id="modal-end-lat"></span>, <span id="modal-end-long"></span>)
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <a href="#" id="modal-edit-btn" class="btn btn-primary">Edit Record</a>
            </div>
        </div>
    </div>
</div>
<!-- DataTables and related plugins -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
<style>
    table#feedbackTa:not(.dataTable) tbody {
        display: none;
    }
    #feedbackTa tbody tr {
        cursor: pointer;
    }
    #feedbackTa tbody tr:hover {
        background-color: #f5f5f5;
    }
    .modal-detail-row {
        margin-bottom: 15px;
        border-bottom: 1px solid #eee;
        padding-bottom: 8px;
    }
    .detail-label {
        font-weight: bold;
        color: #555;
        display: block;
        text-transform: uppercase;
        font-size: 0.85em;
    }
    .detail-value {
        font-size: 1.1em;
        word-break: break-all;
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.2.2/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script>
/** Column indices match servaylisting / user/servaylistingdata row order (0-based). */
function fillServayListingModal(d) {
    if (!d) return;
    var text = function (i) {
        var v = d[i];
        if (v === undefined || v === null) return '';
        if (typeof v === 'string' && v.indexOf('<') !== -1) {
            return $('<div>').html(v).text();
        }
        return v;
    };
    $('#modal-title-name').text(text(4));
    $('#modal-name').text(text(4));
    $('#modal-father').text(text(7));
    $('#modal-gender').text(text(23));
    $('#modal-age').text(text(20));
    $('#modal-block').text(text(10));
    $('#modal-janpad').text(text(11));
    $('#modal-mandalam').text(text(12));
    $('#modal-panchayat').text(text(15));
    $('#modal-village').text(text(16));
    $('#modal-booth-name').text(text(13));
    $('#modal-booth-no').text(text(14));
    $('#modal-toll').text(text(18));
    $('#modal-mobile').text(text(6));
    $('#modal-education').text(text(21));
    $('#modal-jaati').text(text(19));
    $('#modal-address').text(text(22));
    $('#modal-dob').text(text(8));
    $('#modal-dom').text(text(9));
    $('#modal-vehicle').text(text(24));
    $('#modal-group').text(text(25));
    $('#modal-gov-emp').text(text(26));
    $('#modal-party').text(text(27));
    $('#modal-pad').text(text(28));
    $('#modal-reference').text(text(35));
    $('#modal-nari').text(text(30));
    $('#modal-loan').text(text(31));
    $('#modal-remark').text(text(36));
    $('#modal-fb').text(text(32));
    $('#modal-ig').text(text(33));
    $('#modal-tw').text(text(34));
    $('#modal-votar-id').text(text(5));
    $('#modal-code').text(text(29));
    $('#modal-samiti').text(text(17));
    $('#modal-member-id').text(text(1));
    $('#modal-created-date').text(text(44));
    $('#modal-start-date').text(text(39));
    $('#modal-start-lat').text(text(37));
    $('#modal-start-long').text(text(38));
    $('#modal-end-date').text(text(42));
    $('#modal-end-lat').text(text(40));
    $('#modal-end-long').text(text(41));
    var imgCell = d[43];
    var imgHref = '';
    if (imgCell && typeof imgCell === 'string' && imgCell.indexOf('href=') !== -1) {
        var $a = $('<div>').html(imgCell).find('a').first();
        imgHref = $a.attr('href') || '';
    }
    if (imgHref) {
        $('#modal-image-container').html('<img src="' + imgHref + '" class="img-responsive img-thumbnail" style="max-height: 250px; margin: 0 auto; cursor: pointer;" onclick="window.open(\'' + imgHref + '\', \'_blank\')">');
    } else {
        $('#modal-image-container').html('<div class="well">No Image</div>');
    }
    var actionHtml = d[46] || '';
    var editHref = $('<div>').html(actionHtml).find('a[href*="editServay"]').first().attr('href');
    if (editHref) {
        $('#modal-edit-btn').attr('href', editHref).show();
    } else {
        $('#modal-edit-btn').hide();
    }
}

function bindServayListingModal(table) {
    $('#feedbackTa tbody').off('click.servayModal').on('click.servayModal', 'tr', function (e) {
        if ($(e.target).closest('a, button').length) return;
        var rowData = table.row(this).data();
        if (!rowData) return;
        fillServayListingModal(rowData);
        $('#surveyDetailModal').modal('show');
    });
}
</script>
<?php if (isset($userRecords)) { ?>
<script>
$.fn.dataTable.ext.search.push(
    function (settings, data) {
        if (settings.nTable.id !== 'feedbackTa') return true;
        var activeTab = $('ul.nav-tabs li.active a').attr('data-tab');
        if (activeTab === 'all') return true;
        var blockName = (data[10] || '').toString();
        var t = blockName.trim().toLowerCase();
        if (activeTab === 'vidhan-sabha') {
            return t !== '' && t !== '-' && t !== 'n/a' && t !== 'other';
        }
        if (activeTab === 'mp') {
            return t === 'other';
        }
        return true;
    }
);
$(document).ready(function () {
    var table = $('#feedbackTa').DataTable({
        processing: true,
        serverSide: false,
        dom: '<"top"lfB>rt<"bottom"ip>',
        buttons: [{ extend: 'excelHtml5', text: 'Export Excel', title: 'Member List' }],
        paging: true,
        searching: true,
        ordering: false,
        info: true,
        lengthMenu: [[10, 25, 50, 75, -1], [10, 25, 50, 75, 'All']]
    });
    $('ul.nav-tabs a[data-toggle="tab"]').on('shown.bs.tab', function () {
        $('ul.nav-tabs li').removeClass('active');
        $(this).parent().addClass('active');
        var activeTab = $(this).attr('data-tab');
        if (activeTab === 'all') {
            $('#filter-form').show();
        } else {
            $('#filter-form').hide();
        }
        table.draw();
    });
    bindServayListingModal(table);
});
</script>
<?php } else { ?>
<script>
$(document).ready(function () {
    var table = $('#feedbackTa').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '<?php echo base_url('user/servaylistingdata'); ?>',
            type: 'POST',
            data: function (post) {
                post.filter_block = $('#block').val();
                post.filter_year = $('#year').val();
                post.filter_vehicle = $('#vehicle').val();
                post.filter_samithi = $('#samithi').val();
                post.filter_district = $('#filter_district').val();
                post.filter_vidhan_sabha_id = $('#filter_vidhan_sabha').val();
                post.filter_code = $('#code').val();
                post.filter_tab = $('ul.nav-tabs li.active a').data('tab') || 'all';
            }
        },
        dom: '<"top"lfB>rt<"bottom"ip>',
        buttons: [{ extend: 'excelHtml5', text: 'Export Excel', title: 'Member List' }],
        paging: true,
        searching: true,
        ordering: false,
        info: true,
        lengthMenu: [[10, 25, 50, 75, -1], [10, 25, 50, 75, 'All']],
        order: [],
        columnDefs: [{ targets: '_all', orderable: false }]
    });
    $('#servayFilterForm').on('submit', function (e) {
        e.preventDefault();
        table.ajax.reload();
    });
    $('ul.nav-tabs a[data-toggle="tab"]').on('shown.bs.tab', function () {
        $('ul.nav-tabs li').removeClass('active');
        $(this).parent().addClass('active');
        var activeTab = $(this).attr('data-tab');
        if (activeTab === 'all') {
            $('#filter-form').show();
        } else {
            $('#filter-form').hide();
        }
        table.ajax.reload();
    });
    bindServayListingModal(table);
});
</script>
<?php } ?>
