<div class="content-wrapper">
    <!-- Include Select2 CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Edit Jansunwai Details</h3>
                    </div>
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="editJansunwai" enctype="multipart/form-data"  action="<?php echo base_url() ?>Districtpublicproblem/updateDisctrictproblem" method="post">
                        <div class="box-body">
                            <input type="hidden" name="id" value="<?php echo $jansunwai->id; ?>">
                            
                            

                            <div class="row">
                               
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="date">Date</label>
                                        <input type="date" class="form-control required" id="date" name="date" value="<?php echo set_value('date', $jansunwai->date); ?>" onchange="updateMonthAndFinancialYear()">
                                        <?php echo form_error('date', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                           
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="year">Financial Year</label>
                                        <select name="year" id="year" class="form-control required">
                                            <option value="">Select Financial Year</option>
                                            <?php
                                                $current_year = date('Y');
                                                for ($i = $current_year + 1; $i >= $current_year - 10; $i--) {
                                                    $next_year = $i + 1;
                                                    $last_two = substr($next_year, -2);
                                                    $fy = $i . '-' . $last_two;
                                                    
                                                    $current_val = set_value('year', $jansunwai->year);
                                                    $is_selected = false;
                                                    
                                                    if ($current_val == $i || $current_val == $fy || (string)$current_val === (string)$i || strpos((string)$current_val, (string)$i) === 0) {
                                                        $is_selected = true;
                                                    }
                                                    
                                                    $selected = $is_selected ? 'selected' : '';
                                                    echo "<option value='{$i}' {$selected}>{$fy}</option>";
                                                }
                                            ?>
                                        </select>
                                        <?php echo form_error('year', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="month">Month</label>
                                        <select name="month" id="month" class="form-control required">
    <option value="">Select Month</option>
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
        $selected = ((int)set_value('month', $jansunwai->month) == (int)$key) ? 'selected' : '';
        echo "<option value='{$key}' {$selected}>{$value}</option>";
    }
    ?>
</select>

                <?php echo form_error('month', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            </div>

                            <script>
                            function updateMonthAndFinancialYear() {
                                const dateInput = document.getElementById('date').value;
                                if (!dateInput) return;
                                
                                const date = new Date(dateInput + 'T00:00:00');
                                const month = date.getMonth() + 1;
                                const year = date.getFullYear();
                                
                                // Auto-select month
                                const monthStr = String(month).padStart(2, '0');
                                document.getElementById('month').value = monthStr;
                                
                                // Calculate and select financial year
                                // April onwards = current year
                                // Jan-Mar = previous year
                                const fyYear = month >= 4 ? year : year - 1;
                                document.getElementById('year').value = fyYear;
                            }
                            </script>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="district">District</label>
                                        <select class="form-control select2 required" id="district" name="district">
                                            <option value="">Select District</option>
                                            <?php foreach($districts as $district): ?>
                                                <option value="<?php echo $district['id']; ?>" <?php echo set_value('district', $jansunwai->district) == $district['name'] ? 'selected' : ''; ?>><?php echo $district['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?php echo form_error('district', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="assembly">Assembly</label>
                                        <select class="form-control select2 required" id="assembly" name="assembly">
                                            <option value="">Select Assembly</option>
                                            <?php foreach($vidhan_sabhas as $vs): ?>
                                                <option value="<?php echo $vs['vidhan_sabha_name']; ?>" <?php echo set_value('assembly', $jansunwai->assembly) == $vs['vidhan_sabha_name'] ? 'selected' : ''; ?>><?php echo $vs['vidhan_sabha_name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?php echo form_error('assembly', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="block">Block</label>
                                        <select class="form-control select2 required" id="block" name="block">
                                            <option value="">Select Block</option>
                                            <?php foreach($blocks as $block): ?>
                                                <option value="<?php echo $block['id']; ?>" <?php echo set_value('block', $jansunwai->block) == $block['id'] ? 'selected' : ''; ?>><?php echo $block['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?php echo form_error('block', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">                                <!-- Approved Fund -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="approved_fund">Approved Fund <span class="text-danger">*</span></label>
                                        <?php 
                                            $predefined_funds = ['MLA FUND', 'MLA Swechanudan', 'CLP Swechanudan', 'Jansampark Fund'];
                                            $current_fund = set_value('approved_fund', $jansunwai->approved_fund);
                                            $is_other = ($current_fund == 'others' || (!empty($current_fund) && !in_array($current_fund, $predefined_funds)));
                                            
                                            // Ensure approved_fund_other has a value if it was saved directly in approved_fund
                                            $other_value = set_value('approved_fund_other', $jansunwai->approved_fund_other);
                                            if (empty($other_value) && $is_other && $current_fund != 'others') {
                                                $other_value = $current_fund;
                                            }
                                        ?>
                                        <select name="approved_fund" id="approved_fund" class="form-control required" onchange="toggleApprovedFundOther()">
                                            <option value="">Select Approved Fund</option>
                                            <option value="MLA FUND" <?php echo ($current_fund == 'MLA FUND') ? 'selected' : ''; ?>>MLA FUND</option>
                                            <option value="MLA Swechanudan" <?php echo ($current_fund == 'MLA Swechanudan') ? 'selected' : ''; ?>>MLA Swechanudan</option>
                                            <option value="CLP Swechanudan" <?php echo ($current_fund == 'CLP Swechanudan') ? 'selected' : ''; ?>>CLP Swechanudan</option>
                                            <option value="Jansampark Fund" <?php echo ($current_fund == 'Jansampark Fund') ? 'selected' : ''; ?>>Jansampark Fund</option>
                                            <option value="others" <?php echo $is_other ? 'selected' : ''; ?>>Others</option>
                                        </select>
                                        <?php echo form_error('approved_fund', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>

                                <!-- Approved Fund Other (conditional) -->
                                <div class="col-md-4" id="approved_fund_other_div" style="display: none;">
                                    <div class="form-group">
                                        <label for="approved_fund_other">Other Approved Fund</label>
                                        <input type="text" class="form-control" id="approved_fund_other" name="approved_fund_other" value="<?php echo $other_value; ?>" placeholder="Enter custom approved fund">
                                        <?php echo form_error('approved_fund_other', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>

                                <!-- Work Agency -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="work_agency">Work Agency <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control required" id="work_agency" name="work_agency" value="<?php echo set_value('work_agency', $jansunwai->work_agency); ?>">
                                        <?php echo form_error('work_agency', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            </div>

                            <script>
                            function toggleApprovedFundOther() {
                                const approved_fund = document.getElementById('approved_fund').value;
                                const approved_fund_other_div = document.getElementById('approved_fund_other_div');
                                if (approved_fund === 'others') {
                                    approved_fund_other_div.style.display = 'block';
                                } else {
                                    approved_fund_other_div.style.display = 'none';
                                }
                            }
                            // Call on page load in case there's a value
                            window.addEventListener('load', toggleApprovedFundOther);
                            </script>

                            <div class="row">                              
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="recommended_letter_no">Recommended Letter No.</label>
                                        <input type="text" class="form-control required" id="recommended_letter_no" name="recommended_letter_no" value="<?php echo set_value('recommended_letter_no', $jansunwai->recommended_letter_no); ?>">
                                        <?php echo form_error('recommended_letter_no', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                           
                              <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="booth_name">Booth Name</label>
                                        <input type="text" class="form-control required" id="booth_name" name="booth_name" value="<?php echo set_value('booth_name', $jansunwai->booth_name); ?>">
                                        <?php echo form_error('booth_name', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="booth_no">Booth No.</label>
                                        <input type="text" class="form-control required" id="booth_no" name="booth_no" value="<?php echo set_value('booth_no', $jansunwai->booth_no); ?>">
                                        <?php echo form_error('booth_no', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                             
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="panchayat_name">Panchayat Name</label>
                                        <input type="text" class="form-control required" id="panchayat_name" name="panchayat_name" value="<?php echo set_value('panchayat_name', $jansunwai->panchayat_name); ?>">
                                        <?php echo form_error('panchayat_name', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="village">Village</label>
                                        <input type="text" class="form-control required" id="village" name="village" value="<?php echo set_value('village', $jansunwai->village); ?>">
                                        <?php echo form_error('village', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="majra_faliya">Majra-Faliya</label>
                                        <input type="text" class="form-control required" id="majra_faliya" name="majra_faliya" value="<?php echo set_value('majra_faliya', $jansunwai->majra_faliya); ?>">
                                        <?php echo form_error('majra_faliya', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                               
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="work_problem">Work/Problem</label>
                                        <input type="text" class="form-control required" id="work_problem" name="work_problem" value="<?php echo set_value('work_problem', $jansunwai->work_problem); ?>">
                                        <?php echo form_error('work_problem', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                             
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="office">Office</label>
                                        <input type="text" class="form-control required" id="office" name="office" value="<?php echo set_value('office', $jansunwai->office); ?>">
                                        <?php echo form_error('office', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="approximate_cost">Approximate Cost</label>
                                        <input type="number" step="0.01" class="form-control required" id="approximate_cost" name="approximate_cost" value="<?php echo set_value('approximate_cost', $jansunwai->approximate_cost); ?>">
                                        <?php echo form_error('approximate_cost', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="department">Department</label>
                                    <select class="form-control select2 required" id="department" name="department">
                                            <option value="0">Select</option>
                                        <?php foreach($departments as $eachblock){ ?>
                                        <option value="<?php echo $eachblock['id'] ?>" <?php if(set_value('department', $jansunwai->department)==$eachblock['id']){ echo "selected";} ?> ><?php echo $eachblock['name'] ?></option>
                                        <?php } ?>
                                        </select>
                                        <?php echo form_error('department', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="priority">Priority</label>
                                        <input type="text" class="form-control required" id="priority" name="priority" value="<?php echo set_value('priority', $jansunwai->priority); ?>">
                                        <?php echo form_error('priority', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="row">
                                
                                
                           
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="type_of_work">Type of Work</label>
                                        <input type="text" class="form-control required" id="type_of_work" name="type_of_work" value="<?php echo set_value('type_of_work', $jansunwai->type_of_work); ?>">
                                        <?php echo form_error('type_of_work', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="middle_men">Middle Men</label>
                                        <input type="text" class="form-control required" id="middle_men" name="middle_men" value="<?php echo set_value('middle_men', $jansunwai->middle_men); ?>">
                                        <?php echo form_error('middle_men', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cont_no">Cont No</label>
                                        <input type="text" class="form-control required" id="cont_no" name="cont_no" value="<?php echo set_value('cont_no', $jansunwai->cont_no); ?>">
                                        <?php echo form_error('cont_no', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="beneficial">Beneficial</label>
                                        <input type="text" class="form-control required" id="beneficial" name="beneficial" value="<?php echo set_value('beneficial', $jansunwai->beneficial); ?>">
                                        <?php echo form_error('beneficial', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mobile">Cont No.</label>
                                        <input type="text" class="form-control required" id="mobile" name="mobile" value="<?php echo set_value('mobile', $jansunwai->mobile); ?>">
                                        <?php echo form_error('mobile', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            </div>
 
                            
                            
                            <div class="row">
                                
                                <!--<div class="col-md-4">-->
                                <!--    <div class="form-group">-->
                                <!--        <label for="work_status">Work Status</label>-->
                                        <!--<input type="text" class="form-control required" id="work_status" name="work_status" value="<?php echo set_value('work_status', $jansunwai->work_status); ?>">-->
                                <!--         <select class="form-control required select2" id="work_status" name="work_status">             -->
                                <!--            <option value="0" >Select Status</option>-->
                                <!--            <option value="Incomplete" <?php if($jansunwai->work_status== 'Incomplete'){ echo "selected";} ?>>Incomplete</option>-->
                                <!--             <option value="In progress" <?php if($jansunwai->department== 'In progress' ){ echo "selected";} ?>>In progress</option>-->
                                <!--             <option value="Complete" <?php if($jansunwai->department== 'Complete'){ echo "selected";} ?>>Complete</option>-->
                                <!--        </select>-->
                                <!--        <?php echo form_error('work_status', '<div class="text-danger">', '</div>'); ?>-->
                                <!--    </div>-->
                                <!--</div>-->
                            </div>

                            <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="po">Avedan</label>
                                            <input type="file" name="file" />
                                        <?php echo form_error('file', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                
                            <div class="form-group">
                                <label for="remark">Remark/Goshana</label>
                                <textarea class="form-control required" id="remark" name="remark_goshana"><?php echo set_value('remark_goshana', $jansunwai->remark_goshana); ?></textarea>
                                <?php echo form_error('remark', '<div class="text-danger">', '</div>'); ?>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Update" />
                            <a href="<?php echo base_url(); ?>user/jansunwai" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <?php
                $success = $this->session->flashdata('success');
                if ($success) {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>

                <?php
                $error = $this->session->flashdata('error');
                if ($error) {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
</div>

 
 
 
 
 
 
 
 
 <script type="text/javascript">
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
        width: '100%'
    });
});
</script>

 
 
 
 
 
 
 

<script>
$(document).ready(function() {
    // Handle district change event
    $('#district').on('change', function() {
        var district_id = $(this).val();
        
        if (district_id === '') {
            // Clear assembly dropdown if no district selected
            $('#assembly').html('<option value="">Select Assembly</option>');
            return;
        }
        
        // Make AJAX request to get vidhan sabhas for selected district
        $.ajax({
            url: '<?php echo site_url("Districtpublicproblem/get_vidhan_sabhas_by_district"); ?>',
            type: 'POST',
            data: { district_id: district_id },
            dataType: 'json',
            success: function(response) {
                if (response.success && response.vidhan_sabhas.length > 0) {
                    var options = '<option value="">Select Assembly</option>';
                    $.each(response.vidhan_sabhas, function(index, vs) {
                        options += '<option value="' + vs.vidhan_sabha_name + '">' + vs.vidhan_sabha_name + '</option>';
                    });
                    $('#assembly').html(options);
                } else {
                    $('#assembly').html('<option value="">No Assembly available for this district</option>');
                }
            },
            error: function() {
                $('#assembly').html('<option value="">Error loading Assembly</option>');
            }
        });
    });
});
</script>
