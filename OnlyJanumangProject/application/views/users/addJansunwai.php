<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Jansunwai Details</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    
                    <!-- Check if form data exists in session (from budget error) -->
                    <?php 
                    if (!isset($form_data) || empty($form_data)) {
                        // Only restore session data if there's a budget error (flashdata present)
                        if ($this->session->flashdata('error')) {
                            $form_data = $this->session->userdata('jansunwai_form_data');
                        }
                        if (!$form_data) {
                            $form_data = [];
                        }
                    }
                    ?>
                    
                    <!-- Budget Error Modal -->
                    <div id="budgetErrorModal" class="modal fade" role="dialog" style="display: none;">
                        <div class="modal-dialog" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 9999; width: auto; max-width: 500px;">
                            <div class="modal-content" style="background-color: #f8d7da; border: 2px solid #f5c6cb; border-radius: 5px;">
                                <div class="modal-header" style="background-color: #f5c6cb; border-bottom: 1px solid #f5c6cb;">
                                    <h4 class="modal-title" style="color: #721c24;">⚠️ Invalid Fund Limit</h4>
                                    <button type="button" class="close" data-dismiss="modal" style="color: #721c24;">&times;</button>
                                </div>
                                <div class="modal-body" style="color: #721c24; padding: 20px;">
                                    <p id="budgetErrorMessage"></p>
                                </div>
                                <div class="modal-footer" style="border-top: 1px solid #f5c6cb;">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">बंद करें</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <form role="form" id="addJansunwai" action="<?php echo base_url() ?>user/addNewJansunwai"
                        enctype="multipart/form-data" method="post">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 style="background-color: #3C8DBC; color: white; padding: 10px; display: block; border-radius: 4px;"><strong>1. Receiving information</strong></h4>
                                </div>
                            </div>

                            <div class="row">

                            <!-- Office -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="office">Office</label>
                                        <select class="form-control required" id="office" name="office">
                                            <option value="">Select Office</option>
                                            <option value="Bhopal" <?php echo set_select('office', 'Bhopal'); ?>>Bhopal</option>
                                            <option value="Dhar" <?php echo set_select('office', 'Dhar'); ?>>Dhar</option>
                                            <option value="Bagh" <?php echo set_select('office', 'Bagh'); ?>>Bagh</option>
                                            <option value="Gandhwani" <?php echo set_select('office', 'Gandhwani'); ?>>Gandhwani</option>
                                            <option value="Tanda" <?php echo set_select('office', 'Tanda'); ?>>Tanda</option>
                                        </select>
                                        <?php echo form_error('office', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>

                                <!-- Date (First - to auto-fetch Month and Year) -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="date">Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control required" id="date" name="date"
                                            value="<?php echo isset($form_data['date']) ? htmlspecialchars($form_data['date']) : ''; ?>">
                                        <?php echo form_error('date', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>

                                

                                
                            </div>

                            <div class="row">
                                <!-- Month (Auto-filled from Date) -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="month">Month <span class="text-danger">*</span> (Auto-filled)</label>
                                        <select name="month" id="month" class="form-control required" readonly>
                                            <option value="">Select Date First</option>
                                            <?php
                                            $months = [
                                                '01' => 'January',
                                                '02' => 'February',
                                                '03' => 'March',
                                                '04' => 'April',
                                                '05' => 'May',
                                                '06' => 'June',
                                                '07' => 'July',
                                                '08' => 'August',
                                                '09' => 'September',
                                                '10' => 'October',
                                                '11' => 'November',
                                                '12' => 'December'
                                            ];
                                            foreach ($months as $key => $value) {
                                                echo "<option value='{$key}' " . set_select('month', $key) . ">{$value}</option>";
                                            }
                                            ?>
                                        </select>
                                        <?php echo form_error('month', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <!-- Financial Year (Auto-filled from Date) -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="year">Financial Year <span class="text-danger">*</span> (Auto-filled)</label>
                                        <?php
                                        $this->load->helper('financial_year');
                                        $financial_years = get_financial_years(2008, 2027);
                                        ?>
                                        <select name="year" id="year" class="form-control required" readonly>
                                            <option value="">Select Date First</option>
                                            <?php
                                            krsort($financial_years);
                                            foreach ($financial_years as $fy) {
                                                echo "<option value='{$fy}' " . set_select('year', $fy) . ">{$fy}</option>";
                                            }
                                            ?>
                                        </select>
                                        <?php echo form_error('year', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <h4 style="background-color: #3C8DBC; color: white; padding: 10px; display: block; border-radius: 4px;"><strong>2. Geographyical Details</strong></h4>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Sector Name -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sector_name">Sector Name</label>
                                        <input type="text" class="form-control required" id="sector_name"
                                            name="sector_name" value="<?php echo isset($form_data['sector_name']) ? htmlspecialchars($form_data['sector_name']) : ''; ?>">
                                        <?php echo form_error('sector_name', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <!-- Micro Sector No -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="micro_sector_no">Micro Sector No.</label>
                                        <input type="text" class="form-control required" id="micro_sector_no"
                                            name="micro_sector_no" value="<?php echo isset($form_data['micro_sector_no']) ? htmlspecialchars($form_data['micro_sector_no']) : ''; ?>">
                                        <?php echo form_error('micro_sector_no', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <!-- Micro Sector Name -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="micro_sector_name">Micro Sector Name</label>
                                        <input type="text" class="form-control required" id="micro_sector_name"
                                            name="micro_sector_name"
                                            value="<?php echo isset($form_data['micro_sector_name']) ? htmlspecialchars($form_data['micro_sector_name']) : ''; ?>">
                                        <?php echo form_error('micro_sector_name', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- District -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="district">District</label>
                                        <select class="form-control select2 required" id="district" name="district">
                                            <option value="">Select District</option>
                                            <?php foreach($districts as $district){ ?>
                                            <option value="<?php echo $district->id ?>" <?php echo set_select('district', $district->id); ?>>
                                                <?php echo $district->name ?></option>
                                            <?php } ?>
                                        </select>
                                        <?php echo form_error('district', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <!-- Assembly -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="assembly">Assembly</label>
                                        <select class="form-control select2 required" id="assembly" name="assembly">
                                            <option value="">Select Assembly</option>
                                            <?php foreach($assemblies as $assembly){ ?>
                                            <option value="<?php echo $assembly->id ?>" <?php echo set_select('assembly', $assembly->id); ?>>
                                                <?php echo $assembly->vidhan_sabha_name ?></option>
                                            <?php } ?>
                                        </select>
                                        <?php echo form_error('assembly', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <!-- Block -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="block">Block</label>
                                        <select class="form-control select2 required" id="block" name="block">
                                            <option value="">Select</option>
                                            <?php foreach($blocks as $eachblock){ ?>
                                            <option value="<?php echo $eachblock['id'] ?>" <?php echo set_select('block', $eachblock['id']); ?>>
                                                <?php echo $eachblock['name'] ?></option>
                                            <?php }   ?>

                                        </select>
                                        <?php echo form_error('block', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Booth Name -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="booth_name">Booth Name</label>
                                        <select class="form-control select2 required" id="booth_name" name="booth_name">
                                            <option value="">Select Booth</option>
                                            <!-- Booth options will be populated dynamically based on selected Block -->
                                        </select>
                                        <?php echo form_error('booth_name', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <!-- Booth No -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="booth_no">Booth No.</label>
                                        <select class="form-control select2 required" id="booth_no" name="booth_no">
                                            <option value="">Select Booth</option>
                                            <!-- Booth options will be populated dynamically based on selected Block -->
                                        </select>
                                        <?php echo form_error('booth_no', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <!-- Panchayat Name -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="panchayat_name">Panchayat Name</label>
                                        <select class="form-control select2 required" id="panchayat_name"
                                            name="panchayat_name" required>
                                            <option value="">Select Panchayat</option>
                                            <!-- Panchayat options will be populated dynamically based on selected Booth -->
                                        </select>
                                        <?php echo form_error('panchayat_name', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Village -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="village">Village</label>
                                        <select class="form-control select2" id="village" name="village">
                                            <option value="">Select Village</option>
                                        </select>
                                        <?php echo form_error('village', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <!-- Majra-Faliya -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="majra_faliya">Majra/Faliya</label>
                                        <input type="text" class="form-control required" id="majra_faliya"
                                            name="majra_faliya" value="<?php echo isset($form_data['majra_faliya']) ? htmlspecialchars($form_data['majra_faliya']) : ''; ?>">
                                        <?php echo form_error('majra_faliya', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <h4 style="background-color: #3C8DBC; color: white; padding: 10px; display: block; border-radius: 4px;"><strong>3. Work Info</strong></h4>
                                </div>
                            </div>
                            <div class="row">

                                <!-- Work/Problem -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="work_problem">Work/Problem</label>
                                        <input type="text" class="form-control required" id="work_problem"
                                            name="work_problem" value="<?php echo isset($form_data['work_problem']) ? htmlspecialchars($form_data['work_problem']) : ''; ?>">
                                        <?php echo form_error('work_problem', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>

                                 <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="type_of_work">Type of Work</label>
                                        <?php
                                            $q=$this->db->query("select * from workType");
                                          $worktypes=  $q->result();
                                        ?>
                                        <select class="form-control select2 required" id="type_of_work"
                                            name="type_of_work">
                                            <option value="">Select Type of Work</option>
                                            <?php foreach ($worktypes as $each_aa): ?>
                                            <option value="<?= $each_aa->name ?>" <?php echo set_select('type_of_work', $each_aa->name); ?>>
                                                <?= htmlspecialchars($each_aa->name) ?></option>
                                            <?php endforeach; ?>
                                        </select>

                                        <?php echo form_error('type_of_work', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sub_work_type_id">Sub Work Type</label>
                                        <select class="form-control select2" id="sub_work_type_id"
                                            name="sub_work_type_id">
                                            <option value="">Select Sub Work Type</option>
                                        </select>
                                        <?php echo form_error('sub_work_type_id', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>


                                 <!-- Priority -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="priority">Priority</label>
                                        <input type="text" class="form-control required" id="priority" name="priority"
                                            value="<?php echo isset($form_data['priority']) ? htmlspecialchars($form_data['priority']) : ''; ?>">
                                        <?php echo form_error('priority', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>

                               
                            </div>

                            <div class="row">
                                
                                
                                
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <h4 style="background-color: #3C8DBC; color: white; padding: 10px; display: block; border-radius: 4px;"><strong>4. Department & Fund Info</strong></h4>
                                </div>
                            </div>
                            <div class="row">



                            <!-- Department -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="department">Department</label>
                                        <select class="form-control select2 required" id="department" name="department">
                                            <option value="">Select</option>
                                            <?php foreach($departments as $eachblock){ ?>
                                            <option value="<?php echo $eachblock['id'] ?>" <?php echo set_select('department', $eachblock['id']); ?>>
                                                <?php echo $eachblock['name'] ?></option>
                                            <?php } ?>
                                        </select>
                                        <?php echo form_error('department', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>


                                 <!-- Approximate Cost -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="approximate_cost">Approximate Cost</label>
                                        <input type="text" class="form-control required" id="approximate_cost"
                                            name="approximate_cost"
                                            value="<?php echo isset($form_data['approximate_cost']) ? htmlspecialchars($form_data['approximate_cost']) : ''; ?>">
                                        <?php echo form_error('approximate_cost', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>


                                <!-- Approved Fund -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="approved_fund">Approved Fund</label>
                                        <select class="form-control" id="approved_fund" name="approved_fund">
                                            <option value="">Select Fund</option>
                                            <option value="MLA FUND" <?php echo set_select('approved_fund', 'MLA FUND'); ?>>MLA FUND</option>
                                            <option value="MLA Swechanudan" <?php echo set_select('approved_fund', 'MLA Swechanudan'); ?>>MLA Swechanudan</option>
                                            <option value="CLP Swechanudan" <?php echo set_select('approved_fund', 'CLP Swechanudan'); ?>>CLP Swechanudan</option>
                                            <option value="Jansampark Fund" <?php echo set_select('approved_fund', 'Jansampark Fund'); ?>>Jansampark Fund</option>
                                            <option value="others" <?php echo set_select('approved_fund', 'others'); ?>>Others</option>
                                        </select>
                                        <?php echo form_error('approved_fund', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>


                                <!-- Approved Fund (Others) - Initially Hidden -->
                                <div class="col-md-4" id="approved_fund_other_wrapper" style="display:none;">
                                    <div class="form-group">
                                        <label for="approved_fund_other">Enter Fund Name</label>
                                        <input type="text" class="form-control" id="approved_fund_other" name="approved_fund_other"
                                            value="<?php echo isset($form_data['approved_fund_other']) ? htmlspecialchars($form_data['approved_fund_other']) : ''; ?>"
                                            placeholder="Enter custom fund name">
                                        <?php echo form_error('approved_fund_other', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>


                                <!-- Work Agency -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="work_agency">Work Agency</label>
                                        <input type="text" class="form-control" id="work_agency" name="work_agency"
                                            value="<?php echo isset($form_data['work_agency']) ? htmlspecialchars($form_data['work_agency']) : ''; ?>"
                                            placeholder="Enter work executing agency">
                                        <?php echo form_error('work_agency', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>

                                 <!-- Recommended Letter No -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="recommended_letter_no">Recommended Letter No</label>
                                        <input type="text" class="form-control required" id="recommended_letter_no"
                                            name="recommended_letter_no"
                                            value="<?php echo isset($form_data['recommended_letter_no']) ? htmlspecialchars($form_data['recommended_letter_no']) : ''; ?>">
                                        <?php echo form_error('recommended_letter_no', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                               
                                <!-- TS No/Date -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ts_no_date">TS No/Date</label>
                                        <input type="text" class="form-control" id="ts_no_date" name="ts_no_date"
                                            value="<?php echo isset($form_data['ts_no_date']) ? htmlspecialchars($form_data['ts_no_date']) : ''; ?>">
                                        <?php echo form_error('ts_no_date', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <!-- AS No/Date -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="as_no_date">AS No/Date</label>
                                        <input type="text" class="form-control" id="as_no_date" name="as_no_date"
                                            value="<?php echo isset($form_data['as_no_date']) ? htmlspecialchars($form_data['as_no_date']) : ''; ?>">
                                        <?php echo form_error('as_no_date', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>

                                <!-- Type of Work -->
                               
                                <!-- Sub Work Type -->
                                
                               
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <h4 style="background-color: #3C8DBC; color: white; padding: 10px; display: block; border-radius: 4px;"><strong>5. Middle Man - Beneficial Details</strong></h4>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Middle Men -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="middle_men">Middle Man name</label>
                                        <input type="text" class="form-control required" id="middle_men"
                                            name="middle_men" value="<?php echo isset($form_data['middle_men']) ? htmlspecialchars($form_data['middle_men']) : ''; ?>">
                                        <?php echo form_error('middle_men', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <!-- Middle Man Cont No -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cont_no">Middle Man Cont No.</label>
                                        <input type="text" class="form-control" id="cont_no" name="cont_no" 
                                            maxlength="10" pattern="[0-9]{10}" placeholder="10 digits only"
                                            value="<?php echo isset($form_data['cont_no']) ? htmlspecialchars($form_data['cont_no']) : ''; ?>">
                                        <small class="text-muted">Must be exactly 10 digits</small>
                                        <?php echo form_error('cont_no', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <!-- Beneficial -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="beneficial">Beneficial(Name)</label>
                                        <input type="text" class="form-control required" id="beneficial"
                                            name="beneficial" value="<?php echo isset($form_data['beneficial']) ? htmlspecialchars($form_data['beneficial']) : ''; ?>">
                                        <?php echo form_error('beneficial', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- PO -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="po">Beneficial PO</label>
                                        <input type="text" class="form-control required" id="po" name="po"
                                            value="<?php echo isset($form_data['po']) ? htmlspecialchars($form_data['po']) : ''; ?>">
                                        <?php echo form_error('po', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <!-- Beneficial Cont No -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mobile">Beneficial Cont No.</label>
                                        <input type="text" class="form-control" id="mobile" name="mobile" 
                                            maxlength="10" pattern="[0-9]{10}" placeholder="10 digits only"
                                            value="<?php echo isset($form_data['mobile']) ? htmlspecialchars($form_data['mobile']) : ''; ?>">
                                        <small class="text-muted">Must be exactly 10 digits</small>
                                        <?php echo form_error('mobile', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>

                                <!-- Work Status - Hidden, default to Incomplete -->
                                <input type="hidden" id="work_status" name="work_status" value="Incomplete">
                            </div>

                            <div id="section6_wrapper">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 style="background-color: #3C8DBC; color: white; padding: 10px; display: block; border-radius: 4px;"><strong>6. Section Details</strong></h4>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Account Details -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="account_details">Account Details</label>
                                        <textarea class="form-control" id="account_details"
                                            name="account_details"><?php echo isset($form_data['account_details']) ? htmlspecialchars($form_data['account_details']) : ''; ?></textarea>
                                        <?php echo form_error('account_details', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>

                                <!-- Residential Number -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="residential_number">IFSC Number</label>
                                        <input type="text" class="form-control" id="residential_number"
                                            name="residential_number"
                                            value="<?php echo isset($form_data['residential_number']) ? htmlspecialchars($form_data['residential_number']) : ''; ?>">
                                        <?php echo form_error('residential_number', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <!-- ID Proof Number -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="id_proof_number">Adhar Card Number</label>
                                        <input type="text" class="form-control" id="id_proof_number"
                                            name="id_proof_number" value="<?php echo isset($form_data['id_proof_number']) ? htmlspecialchars($form_data['id_proof_number']) : ''; ?>">
                                        <?php echo form_error('id_proof_number', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                
                                <!-- Upload Document -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="document_upload">Upload Document (Set Of Complete Doc Pdf)</label>
                                        <input type="file" class="form-control" id="document_upload"
                                            name="document_upload">
                                        <?php echo form_error('document_upload', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            </div>
                            </div>

                            <div class="row">
                                <!-- Remark/Goshana -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="remark_goshana">Remark/Goshana (भईया द्वारा दिए गए निर्देश)</label>
                                        <textarea class="form-control" id="remark_goshana"
                                            name="remark_goshana"><?php echo isset($form_data['remark_goshana']) ? htmlspecialchars($form_data['remark_goshana']) : ''; ?></textarea>
                                        <?php echo form_error('remark_goshana', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="po">Avedan</label>
                                        <input type="file" name="file" />
                                        <?php echo form_error('file', '<div class="text-danger">', '</div>'); ?>
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
                $success = $this->session->flashdata('success');
                if($success)
                {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $success; ?>
                </div>
                <?php } ?>
                <?php 
                $ferr = $this->session->flashdata('error'); 
                // Don't show alert for budget errors - they will be shown in modal
                $isBudgetError = $ferr && (strpos($ferr, 'बजट') !== false || strpos($ferr, 'कुल बजट') !== false);
                if ($ferr && !$isBudgetError) { 
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $ferr; ?>
                </div>
                <?php } ?>


            </div>
        </div>
    </section>
</div>


<script type="text/javascript">
// Store form data for restoration after validation errors
var formData = <?php echo isset($form_data_json) ? $form_data_json : '{}'; ?>;

$(document).ready(function() {
    // Check if there's a budget error message in the session
    <?php if ($this->session->flashdata('error')): ?>
        var errorMessage = "<?php echo addslashes($this->session->flashdata('error')); ?>";
        $('#budgetErrorMessage').html(errorMessage);
        $('#budgetErrorModal').modal('show');
        
        // When modal is closed, clear the session data
        $('#budgetErrorModal').on('hidden.bs.modal', function() {
            // Session data will be cleared on next page load
        });
        
        // Restore form data from session
        var formDataFromSession = <?php echo json_encode($form_data); ?>;
        if (formDataFromSession && Object.keys(formDataFromSession).length > 0) {
            restoreAllFormDataFromSession(formDataFromSession);
        }
        return false;
    <?php endif; ?>
    
    // Restore form data after validation error
    if (Object.keys(formData).length > 0) {
        restoreAllFormData();
    }
    
    function restoreAllFormDataFromSession(formDataFromSession) {
        // Restore all input, textarea, and select fields
        $.each(formDataFromSession, function(key, value) {
            var $field = $('[name="' + key + '"]');
            if ($field.length) {
                if ($field.is('input[type="text"], input[type="number"], input[type="date"], input[type="email"], textarea')) {
                    $field.val(value);
                } else if ($field.is('select')) {
                    $field.val(value);
                }
            }
        });

        // Trigger changes for dependent dropdowns with proper sequencing
        if (formDataFromSession.district) {
            $('#district').val(formDataFromSession.district).trigger('change');
            // Wait for AJAX to complete before restoring dependent fields
            setTimeout(function() {
                if (formDataFromSession.assembly) {
                    $('#assembly').val(formDataFromSession.assembly);
                }
            }, 800);
        }
        
        if (formDataFromSession.block) {
            $('#block').val(formDataFromSession.block).trigger('change');
            // Wait for AJAX to complete before restoring dependent fields
            setTimeout(function() {
                if (formDataFromSession.booth_name) {
                    $('#booth_name').val(formDataFromSession.booth_name).trigger('change');
                }
            }, 800);
            
            setTimeout(function() {
                if (formDataFromSession.panchayat_name) {
                    $('#panchayat_name').val(formDataFromSession.panchayat_name).trigger('change');
                }
            }, 1600);
            
            setTimeout(function() {
                if (formDataFromSession.village) {
                    $('#village').val(formDataFromSession.village);
                }
            }, 2400);
        }
        
        if (formDataFromSession.type_of_work) {
            $('#type_of_work').val(formDataFromSession.type_of_work).trigger('change');
            setTimeout(function() {
                if (formDataFromSession.sub_work_type_id) {
                    $('#sub_work_type_id').val(formDataFromSession.sub_work_type_id);
                }
            }, 800);
        }
        
        if (formDataFromSession.approved_fund) {
            $('#approved_fund').val(formDataFromSession.approved_fund).trigger('change');
        }
        
        if (formDataFromSession.date) {
            $('#date').val(formDataFromSession.date).trigger('change');
        }
    }

    function restoreAllFormData() {
        // Restore all input, textarea, and select fields
        $.each(formData, function(key, value) {
            var $field = $('[name="' + key + '"]');
            if ($field.length) {
                if ($field.is('input[type="text"], input[type="number"], input[type="date"], input[type="email"], textarea')) {
                    $field.val(value);
                } else if ($field.is('select')) {
                    $field.val(value);
                }
            }
        });

        // Trigger changes for dependent dropdowns with proper sequencing
        if (formData.district) {
            $('#district').val(formData.district).trigger('change');
            // Wait for AJAX to complete before restoring dependent fields
            setTimeout(function() {
                if (formData.assembly) {
                    $('#assembly').val(formData.assembly);
                }
            }, 800);
        }
        
        if (formData.block) {
            $('#block').val(formData.block).trigger('change');
            // Wait for AJAX to complete before restoring dependent fields
            setTimeout(function() {
                if (formData.booth_name) {
                    $('#booth_name').val(formData.booth_name).trigger('change');
                }
            }, 800);
            
            setTimeout(function() {
                if (formData.panchayat_name) {
                    $('#panchayat_name').val(formData.panchayat_name).trigger('change');
                }
            }, 1600);
            
            setTimeout(function() {
                if (formData.village) {
                    $('#village').val(formData.village);
                }
            }, 2400);
        }
        
        if (formData.type_of_work) {
            $('#type_of_work').val(formData.type_of_work).trigger('change');
            setTimeout(function() {
                if (formData.sub_work_type_id) {
                    $('#sub_work_type_id').val(formData.sub_work_type_id);
                }
            }, 800);
        }
        
        if (formData.approved_fund) {
            $('#approved_fund').val(formData.approved_fund).trigger('change');
        }
        
        if (formData.date) {
            $('#date').val(formData.date).trigger('change');
        }
    }

    // Handle District change - populate Assembly dropdown
    $('#district').change(function() {
        var districtId = $(this).val();
        if (districtId != 0 && districtId != '') {
            $.ajax({
                url: '<?php echo site_url('user/getAssembliesByDistrict'); ?>',
                method: 'POST',
                data: {
                    district_id: districtId
                },
                dataType: 'json',
                success: function(response) {
                    $('#assembly').empty();
                    $('#assembly').append('<option value="">Select Assembly</option>');
                    if (response.success && response.assemblies && response.assemblies.length > 0) {
                        $.each(response.assemblies, function(index, value) {
                            $('#assembly').append('<option value="' + value.id + '">' + value.vidhan_sabha_name + '</option>');
                        });

                        // Restore assembly if it was selected
                        if (formData.assembly) {
                            $('#assembly').val(formData.assembly);
                        }
                    }
                },
                error: function() {
                    $('#assembly').empty();
                    $('#assembly').append('<option value="">Select Assembly</option>');
                }
            });
        } else {
            $('#assembly').empty();
            $('#assembly').append('<option value="">Select Assembly</option>');
        }
    });

    $('#block').change(function() {
        var blockId = $(this).val();
        if (blockId != 0) {
            $.ajax({
                url: '<?php echo site_url('panchayat/getBoothsByBlock'); ?>',
                method: 'POST',
                data: {
                    blockid: blockId
                },
                dataType: 'json',
                success: function(response) {
                    $('#booth_name').empty();
                    $('#booth_name').append('<option value="">Select Booth</option>');
                    $.each(response, function(index, value) {
                        $('#booth_name').append('<option bnumbervalue="' + value.bnumber + '" value="' + value.id + '">' + value.name + '</option>');
                    });

                    // Restore booth_name if it was selected
                    if (formData.booth_name) {
                        $('#booth_name').val(formData.booth_name).trigger('change');
                    }

                    $('#booth_no').empty().append('<option value="">Select Booth No.</option>');
                }
            });
        } else {
            $('#booth_name').empty();
            $('#booth_name').append('<option value="">Select Booth</option>');
            $('#booth_no').empty().append('<option value="">Select Booth No.</option>');
        }
    });

    $('#booth_name').change(function() {
        var boothid = $(this).val();
        if (boothid != 0) {
            var selectedBooth = $('#booth_name option:selected');
            var bnumber = selectedBooth.attr('bnumbervalue');

            if (bnumber) {
                $('#booth_no').empty().append('<option value="">Select Booth No.</option>');
                $('#booth_no').append('<option value="' + selectedBooth.val() + '" selected>' + bnumber + '</option>');
            } else {
                $('#booth_no').empty().append('<option value="">Select Booth No.</option>');
            }

            $.ajax({
                url: '<?php echo site_url('panchayat/getpanchayatidByBooth'); ?>',
                method: 'POST',
                data: {
                    boothid: boothid
                },
                dataType: 'json',
                success: function(response) {
                    $('#panchayat_name').empty();
                    $('#panchayat_name').append('<option value="">Select Panchayat</option>');
                    $.each(response, function(index, value) {
                        $('#panchayat_name').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });

                    // Restore panchayat_name if it was selected
                    if (formData.panchayat_name) {
                        $('#panchayat_name').val(formData.panchayat_name).trigger('change');
                    }
                }
            });
        } else {
            $('#panchayat_name').empty();
            $('#panchayat_name').append('<option value="">Select Panchayat</option>');
        }
    });

    $('#panchayat_name').change(function() {
        var panchayatid = $(this).val();
        console.log('Panchayat changed, ID:', panchayatid);
        
        if (panchayatid != 0 && panchayatid != '') {
            $.ajax({
                url: '<?php echo site_url('panchayat/getvillageBypanchayat'); ?>',
                method: 'POST',
                data: {
                    panchayatid: panchayatid
                },
                dataType: 'json',
                success: function(response) {
                    console.log('Villages response:', response);
                    $('#village').empty();
                    $('#village').append('<option value="">Select Village</option>');
                    if (response && response.length > 0) {
                        $.each(response, function(index, value) {
                            console.log('Adding village:', value.id, value.name);
                            $('#village').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    } else {
                        console.log('No villages found for panchayat ID: ' + panchayatid);
                    }

                    // Restore village if it was selected
                    if (formData.village) {
                        $('#village').val(formData.village);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error loading villages:', error);
                    console.error('Response:', xhr.responseText);
                    $('#village').empty();
                    $('#village').append('<option value="">Select Village</option>');
                }
            });
        } else {
            $('#village').empty();
            $('#village').append('<option value="">Select Village</option>');
        }
    });

    // Filter Sub Work Type based on Type of Work selection
    function toggleSectionSixBySubWorkType() {
        var selectedText = $('#sub_work_type_id option:selected').text().trim().toLowerCase();
        var shouldShowSectionSix = (selectedText.indexOf('स्वेछानुदान') !== -1) ||
            (selectedText.indexOf('स्वेच्छानुदान') !== -1) ||
            (selectedText.indexOf('swechanudan') !== -1);
        
        // Section 6 is always visible now, only toggle remark_goshana requirement
        if (shouldShowSectionSix) {
            $('#remark_goshana').addClass('required');
        } else {
            $('#remark_goshana').removeClass('required');
        }
    }

    $('#type_of_work').change(function() {
        var workTypeName = $(this).val();
        if (workTypeName) {
            $.ajax({
                url: '<?php echo site_url('user/getSubWorkTypesByWorkType'); ?>',
                method: 'POST',
                data: {
                    work_type_name: workTypeName
                },
                dataType: 'json',
                success: function(response) {
                    $('#sub_work_type_id').empty();
                    $('#sub_work_type_id').append('<option value="">Select Sub Work Type</option>');
                    if (response.success && response.subtypes && response.subtypes.length > 0) {
                        $.each(response.subtypes, function(index, value) {
                            $('#sub_work_type_id').append('<option value="' + value.id + '">' + 
                                value.name + '</option>');
                        });

                        // Restore sub_work_type_id if it was selected
                        if (formData.sub_work_type_id) {
                            $('#sub_work_type_id').val(formData.sub_work_type_id);
                        }
                    }
                    toggleSectionSixBySubWorkType();
                },
                error: function() {
                    $('#sub_work_type_id').empty();
                    $('#sub_work_type_id').append('<option value="">Select Sub Work Type</option>');
                    toggleSectionSixBySubWorkType();
                }
            });
        } else {
            $('#sub_work_type_id').empty();
            $('#sub_work_type_id').append('<option value="">Select Sub Work Type</option>');
            toggleSectionSixBySubWorkType();
        }
    });

    $('#sub_work_type_id').change(function() {
        toggleSectionSixBySubWorkType();
    });

    // Auto-fill Month and Financial Year from Date
    $('#date').on('change', function() {
        var dateValue = $(this).val();
        
        if (dateValue) {
            // Parse the date
            var date = new Date(dateValue);
            var month = String(date.getMonth() + 1).padStart(2, '0'); // Month is 0-indexed
            var year = date.getFullYear();
            
            // Set the month dropdown
            $('#month').val(month).trigger('change');
            
            // Calculate financial year
            var monthNum = parseInt(month);
            var financialYear;
            
            if (monthNum >= 4) {
                // April onwards - current year is start year
                var nextYear = String(year + 1).slice(-2);
                financialYear = year + '-' + nextYear;
            } else {
                // January to March - previous year is start year
                var prevYear = year - 1;
                var currentYearLast2 = String(year).slice(-2);
                financialYear = prevYear + '-' + currentYearLast2;
            }
            
            // Set the financial year dropdown
            $('#year').val(financialYear).trigger('change');
        } else {
            // Clear if date is empty
            $('#month').val('').trigger('change');
            $('#year').val('').trigger('change');
        }
    });

    // Handle Approved Fund "Others" option
    $('#approved_fund').change(function() {
        var selectedFund = $(this).val();
        if (selectedFund === 'others') {
            $('#approved_fund_other_wrapper').slideDown();
            $('#approved_fund_other').addClass('required');
        } else {
            $('#approved_fund_other_wrapper').slideUp();
            $('#approved_fund_other').removeClass('required');
            $('#approved_fund_other').val('');
        }
    });

    // Trigger on page load to show/hide based on current value
    var currentFund = $('#approved_fund').val();
    if (currentFund === 'others') {
        $('#approved_fund_other_wrapper').show();
        $('#approved_fund_other').addClass('required');
    }

    // Initial state for section 6 visibility
    toggleSectionSixBySubWorkType();

    // Save form data to localStorage before submit
    $('#addJansunwai').on('submit', function(e) {
        // Validate contact numbers - must be exactly 10 digits
        var contNo = $('#cont_no').val().trim();
        var mobileNo = $('#mobile').val().trim();
        
        // Check if cont_no is exactly 10 digits
        if (!/^\d{10}$/.test(contNo)) {
            e.preventDefault();
            showCenteredMessage('Middle Man Contact Number must be exactly 10 digits', 'error');
            return false;
        }
        
        // Check if mobile is exactly 10 digits
        if (!/^\d{10}$/.test(mobileNo)) {
            e.preventDefault();
            showCenteredMessage('Beneficial Contact Number must be exactly 10 digits', 'error');
            return false;
        }
        
        // Save all form data to localStorage
        var formDataToSave = {};
        $('#addJansunwai').find('input, select, textarea').each(function() {
            var $field = $(this);
            var fieldName = $field.attr('name');
            if (fieldName) {
                formDataToSave[fieldName] = $field.val();
            }
        });
        localStorage.setItem('jansunwaiFormData', JSON.stringify(formDataToSave));
    });

    // Function to show centered message
    function showCenteredMessage(message, type) {
        // Remove existing message if any
        $('#centeredMessage').remove();
        
        var messageClass = type === 'error' ? 'alert-danger' : 'alert-success';
        var messageHtml = '<div id="centeredMessage" class="alert ' + messageClass + ' alert-dismissable" style="' +
            'position: fixed; ' +
            'top: 50%; ' +
            'left: 50%; ' +
            'transform: translate(-50%, -50%); ' +
            'z-index: 9999; ' +
            'min-width: 400px; ' +
            'text-align: center; ' +
            'box-shadow: 0 4px 6px rgba(0,0,0,0.1); ' +
            'padding: 20px; ' +
            '">' +
            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
            '<strong>' + message + '</strong>' +
            '</div>';
        
        $('body').append(messageHtml);
        
        // Auto-dismiss after 5 seconds
        setTimeout(function() {
            $('#centeredMessage').fadeOut(function() {
                $(this).remove();
            });
        }, 5000);
    }

    // Add real-time validation for contact numbers
    $('#cont_no, #mobile').on('input', function() {
        var value = $(this).val();
        // Remove non-numeric characters
        value = value.replace(/\D/g, '');
        // Limit to 10 digits
        if (value.length > 10) {
            value = value.substring(0, 10);
        }
        $(this).val(value);
    });

    // Restore form data from localStorage on page load
    function restoreFromLocalStorage() {
        var savedData = localStorage.getItem('jansunwaiFormData');
        if (savedData) {
            try {
                var formDataToRestore = JSON.parse(savedData);
                
                // Restore all fields
                $.each(formDataToRestore, function(key, value) {
                    var $field = $('[name="' + key + '"]');
                    if ($field.length) {
                        $field.val(value);
                    }
                });

                // Trigger cascading dropdowns
                if (formDataToRestore.block) {
                    $('#block').trigger('change');
                }
                
                // Clear localStorage after restoration
                localStorage.removeItem('jansunwaiFormData');
            } catch(e) {
                console.log('Error restoring form data:', e);
            }
        }
    }

    // Call restore function on page load
    restoreFromLocalStorage();

    // Helper function to check if string is empty
    function empty(mixed_var) {
        if (mixed_var === "" || mixed_var === 0 || mixed_var === "0" || mixed_var === null || 
            mixed_var === false || (typeof mixed_var === "undefined")) {
            return true;
        }
        return false;
    }

    // Trigger auto-fill if date already has a value (for edit mode)
    if ($('#date').val()) {
        $('#date').trigger('change');
    }

});
</script>