<div class="content-wrapper">
    <style>
    .stat-card {
        border: none;
        border-radius: 6px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.1);
        padding: 12px 15px;
        margin-bottom: 15px;
        background: white;
        transition: all 0.3s ease;
        min-height: 120px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .stat-card:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        transform: translateY(-2px);
    }
    .stat-card.aqua { background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); color: white; }
    .stat-card.purple { background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%); color: white; }
    .stat-card.blue { background: linear-gradient(135deg, #2980b9 0%, #1f618d 100%); color: white; }
    .stat-card.green { background: linear-gradient(135deg, #27ae60 0%, #1e8449 100%); color: white; }
    .stat-card.orange { background: linear-gradient(135deg, #e67e22 0%, #d35400 100%); color: white; }
    .stat-card.yellow { background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); color: white; }
    .stat-card.red { background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); color: white; }
    
    .stat-card-title {
        font-size: 11px;
        font-weight: 600;
        color: inherit;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-bottom: 6px;
        opacity: 0.95;
    }
    .stat-card-value {
        font-size: 24px;
        font-weight: 700;
        color: inherit;
        margin-bottom: 8px;
    }
    .stat-card-btn {
        display: inline-block;
        padding: 4px 8px;
        font-size: 10px;
        border-radius: 3px;
        text-decoration: none;
        background: rgba(255,255,255,0.2);
        color: white;
        border: 1px solid rgba(255,255,255,0.3);
        transition: all 0.2s;
        align-self: flex-start;
    }
    .stat-card-btn:hover {
        background: rgba(255,255,255,0.3);
        color: white;
    }
    
    /* Chart styling */
    #barChart, #pieChart {
        max-height: 300px !important;
    }
    
    /* 7 columns layout */
    .col-7 {
        flex: 0 0 calc(100% / 7);
        max-width: calc(100% / 7);
        padding: 5px;
        box-sizing: border-box;
    }
    
    @media (max-width: 1200px) {
        .col-7 {
            flex: 0 0 calc(100% / 6);
            max-width: calc(100% / 6);
        }
    }
    @media (max-width: 992px) {
        .col-7 {
            flex: 0 0 calc(100% / 4);
            max-width: calc(100% / 4);
        }
    }
    @media (max-width: 768px) {
        .col-7 {
            flex: 0 0 50%;
            max-width: 50%;
        }
    }
    @media (max-width: 480px) {
        .col-7 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }

    /* Widget Toggle Button Styles */
    .widget-toggle-btn {
        position: fixed;
        right: 20px;
        top: 80px;
        z-index: 999;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        font-size: 24px;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .widget-toggle-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 16px rgba(0,0,0,0.3);
    }

    /* Widget Panel Styles */
    .widget-panel {
        position: fixed;
        right: -350px;
        top: 0;
        width: 350px;
        height: 100vh;
        background: white;
        box-shadow: -2px 0 10px rgba(0,0,0,0.1);
        z-index: 1000;
        transition: right 0.3s ease;
        overflow-y: auto;
        border-left: 3px solid #667eea;
    }
    .widget-panel.active {
        right: 0;
    }

    .widget-panel-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        font-size: 18px;
        font-weight: bold;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .widget-panel-close {
        background: none;
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .widget-list {
        padding: 15px;
    }

    .widget-item {
        display: flex;
        align-items: center;
        padding: 12px;
        margin-bottom: 10px;
        background: #f8f9fa;
        border-radius: 6px;
        border-left: 4px solid #667eea;
        transition: all 0.2s ease;
    }
    .widget-item:hover {
        background: #e9ecef;
        transform: translateX(-5px);
    }

    .widget-item input[type="checkbox"] {
        width: 20px;
        height: 20px;
        margin-right: 12px;
        cursor: pointer;
    }

    .widget-item label {
        flex: 1;
        margin: 0;
        cursor: pointer;
        font-size: 14px;
        color: #333;
    }

    .widget-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.3);
        z-index: 999;
        display: none;
    }
    .widget-overlay.active {
        display: block;
    }

    .widget-section-title {
        font-size: 12px;
        font-weight: bold;
        color: #667eea;
        text-transform: uppercase;
        margin-top: 15px;
        margin-bottom: 10px;
        padding-left: 12px;
        letter-spacing: 0.5px;
    }

    .widget-reset-btn {
        width: 100%;
        padding: 10px;
        margin: 15px 0;
        background: #667eea;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
        transition: all 0.2s ease;
    }
    .widget-reset-btn:hover {
        background: #764ba2;
    }

    /* Hide sections based on widget settings */
    .dashboard-section {
        transition: all 0.3s ease;
    }
    .dashboard-section.hidden {
        display: none;
    }
    </style>
    <!-- Widget Toggle Button -->
    <button class="widget-toggle-btn" id="widgetToggleBtn" title="Customize Dashboard">
        <i class="fa fa-sliders"></i>
    </button>

    <!-- Widget Panel -->
    <div class="widget-overlay" id="widgetOverlay"></div>
    <div class="widget-panel" id="widgetPanel">
        <div class="widget-panel-header">
            <span>Customize Dashboard</span>
            <button class="widget-panel-close" id="widgetPanelClose">&times;</button>
        </div>
        <div class="widget-list">
            <div class="widget-section-title">Vidhan Sabha Cards</div>
            <div class="widget-item">
                <input type="checkbox" id="widget-vidhan-cards" class="widget-checkbox" data-section="vidhan-cards" checked>
                <label for="widget-vidhan-cards">All Vidhan Sabha Cards</label>
            </div>

            <div class="widget-section-title">MP Cards</div>
            <div class="widget-item">
                <input type="checkbox" id="widget-mp-cards" class="widget-checkbox" data-section="mp-cards" checked>
                <label for="widget-mp-cards">All MP Cards</label>
            </div>

            <div class="widget-section-title">Charts & Tables</div>
            <div class="widget-item">
                <input type="checkbox" id="widget-charts" class="widget-checkbox" data-section="charts" checked>
                <label for="widget-charts">Charts (Bar & Pie)</label>
            </div>
            <div class="widget-item">
                <input type="checkbox" id="widget-assembly-table" class="widget-checkbox" data-section="assembly-table" checked>
                <label for="widget-assembly-table">Assembly Department Summary</label>
            </div>
            <div class="widget-item">
                <input type="checkbox" id="widget-mp-table" class="widget-checkbox" data-section="mp-table" checked>
                <label for="widget-mp-table">MP Department Summary</label>
            </div>

            <div class="widget-section-title">Party Worker Code Summary</div>
            <div class="widget-item">
                <input type="checkbox" id="widget-vidhan-worker-code" class="widget-checkbox" data-section="vidhan-worker-code" checked>
                <label for="widget-vidhan-worker-code">Vidhan Sabha Party Worker Code</label>
            </div>
            <div class="widget-item">
                <input type="checkbox" id="widget-mp-worker-code" class="widget-checkbox" data-section="mp-worker-code" checked>
                <label for="widget-mp-worker-code">MP Party Worker Code</label>
            </div>

            <button class="widget-reset-btn" id="widgetResetBtn">Reset to Default</button>
        </div>
    </div>

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard
            <small>Control panel</small>
        </h1>
    </section>
    <section class="content" style="padding: 10px;">
        <!-- First Row: My Assembly Cards - 7 per row -->
        <div class="dashboard-section" id="section-vidhan-cards" style="display: flex; flex-wrap: wrap; margin: 0; padding: 0;">
            <div class="col-7">
                <div class="stat-card aqua">
                    <div class="stat-card-title">Today Vidhan Sabha</div>
                    <div class="stat-card-value"><?php $date=date('Y-m-d');
                     $cc=  $this->db->query("SELECT count(*) as todaytotal FROM `servayapp` s 
                                            JOIN `block` b ON s.block_name_number = b.id 
                                            WHERE s.create_date LIKE '%$date%' AND b.name != 'Other'");
                       $ca=$cc->row();
                       echo $ca->todaytotal;
                       ?></div>
                    <a href="<?php echo base_url('ServayListing'); ?>" class="stat-card-btn">View</a>
                </div>
            </div>
            <div class="col-7">
                <div class="stat-card purple">
                    <div class="stat-card-title">Vidhan Sabha</div>
                    <div class="stat-card-value"><?php 
                     $cc=  $this->db->query("SELECT count(*) as vidhansabha_total FROM `servayapp` s 
                                            JOIN `block` b ON s.block_name_number = b.id 
                                            WHERE b.name != 'Other'");
                       $ca=$cc->row();
                       echo $ca->vidhansabha_total;
                       ?></div>
                    <a href="<?php echo base_url('ServayListing'); ?>" class="stat-card-btn">View</a>
                </div>
            </div>
            <div class="col-7">
                <div class="stat-card blue">
                    <div class="stat-card-title">Total Public Problems</div>
                    <div class="stat-card-value"><?php $date=date('Y-m-d');
                     $cc1=  $this->db->query("SELECT count(*) as userstoday FROM `jansunwai` ");
                     $ca2=$cc1->row();
                     echo $ca2->userstoday;
                     ?></div>
                    <a href="<?php echo base_url('user/jansunwai'); ?>" class="stat-card-btn">View</a>
                </div>
            </div>
            <div class="col-7">
                <div class="stat-card green">
                    <div class="stat-card-title">Complete Public Problems</div>
                    <div class="stat-card-value"><?php
                     $cc12=  $this->db->query("SELECT count(*) as totalusers FROM `jansunwai` WHERE `work_status`='Complete'");
                     $cc122=$cc12->row();
                     echo $cc122->totalusers; ?></div>
                    <a href="<?php echo base_url('user/jansunwai?status=Complete'); ?>" class="stat-card-btn">View</a>
                </div>
            </div>
            <div class="col-7">
                <div class="stat-card orange">
                    <div class="stat-card-title">Incomplete Public Problems</div>
                    <div class="stat-card-value"><?php $date=date('Y-m-d');
                     $cc1=  $this->db->query("SELECT count(*) as userstoday FROM `jansunwai` WHERE  `work_status`='Incomplete' ");
                     $ca2=$cc1->row();
                     echo $ca2->userstoday;
                     ?></div>
                    <a href="<?php echo base_url('user/jansunwai?status=Incomplete'); ?>" class="stat-card-btn">View</a>
                </div>
            </div>
            <div class="col-7">
                <div class="stat-card yellow">
                    <div class="stat-card-title">In-Progress Public Problems</div>
                    <div class="stat-card-value"><?php
                     $cc12=  $this->db->query("SELECT count(*) as totalusers FROM `jansunwai` WHERE    `work_status`='In progress' ");
                     $cc122=$cc12->row();
                     echo $cc122->totalusers; ?></div>
                    <a href="<?php echo base_url('user/jansunwai?status=In progress'); ?>" class="stat-card-btn">View</a>
                </div>
            </div>
            <div class="col-7">
                <div class="stat-card red">
                    <div class="stat-card-title">Rejected Public Problems</div>
                    <div class="stat-card-value"><?php
                     $cc12=  $this->db->query("SELECT count(*) as totalusers FROM `jansunwai` WHERE `work_status`='Reject' ");
                     $cc122=$cc12->row();
                     echo $cc122->totalusers; ?></div>
                    <a href="<?php echo base_url('user/jansunwai?status=Reject'); ?>" class="stat-card-btn">View</a>
                </div>
            </div>
        </div>
        <!-- Second Row: All MP Cards - 7 per row -->
        <div class="dashboard-section" id="section-mp-cards" style="display: flex; flex-wrap: wrap; margin: 0; padding: 0;">
            <div class="col-7">
                <div class="stat-card aqua">
                    <div class="stat-card-title">Today MP</div>
                    <div class="stat-card-value"><?php $date=date('Y-m-d');
                     $cc=  $this->db->query("SELECT count(*) as todaytotal FROM `servayapp` s 
                                            JOIN `block` b ON s.block_name_number = b.id 
                                            WHERE s.create_date LIKE '%$date%' AND b.name = 'Other'");
                       $ca=$cc->row();
                       echo $ca->todaytotal;
                       ?></div>
                    <a href="<?php echo base_url('ServayListing'); ?>" class="stat-card-btn">View</a>
                </div>
            </div>
            <div class="col-7">
                <div class="stat-card purple">
                    <div class="stat-card-title">All MP</div>
                    <div class="stat-card-value"><?php 
                     $cc=  $this->db->query("SELECT count(*) as mp_total FROM `servayapp`");
                       $ca=$cc->row();
                       echo $ca->mp_total;
                       ?></div>
                    <a href="<?php echo base_url('ServayListing'); ?>" class="stat-card-btn">View</a>
                </div>
            </div>
            <div class="col-7">
                <div class="stat-card blue">
                    <div class="stat-card-title">MP Total Public Problems</div>
                    <div class="stat-card-value"><?php $date=date('Y-m-d');
                     $cc1=  $this->db->query("SELECT count(*) as userstoday FROM `districtpublicproblem` ");
                     $ca2=$cc1->row();
                     echo $ca2->userstoday;
                     ?></div>
                    <a href="<?php echo base_url('Districtpublicproblem/Disctrictproblem'); ?>" class="stat-card-btn">View</a>
                </div>
            </div>
            <div class="col-7">
                <div class="stat-card green">
                    <div class="stat-card-title">MP Complete Public Problems</div>
                    <div class="stat-card-value"><?php
                     $cc12=  $this->db->query("SELECT count(*) as totalusers FROM `districtpublicproblem` WHERE `work_status`='Complete'");
                     $cc122=$cc12->row();
                     echo $cc122->totalusers; ?></div>
                    <a href="<?php echo base_url('Districtpublicproblem/Disctrictproblem?status=Complete'); ?>" class="stat-card-btn">View</a>
                </div>
            </div>
            <div class="col-7">
                <div class="stat-card orange">
                    <div class="stat-card-title">MP Incomplete Public Problems</div>
                    <div class="stat-card-value"><?php $date=date('Y-m-d');
                     $cc1=  $this->db->query("SELECT count(*) as userstoday FROM `districtpublicproblem` WHERE  `work_status`='Incomplete' ");
                     $ca2=$cc1->row();
                     echo $ca2->userstoday;
                     ?></div>
                    <a href="<?php echo base_url('Districtpublicproblem/Disctrictproblem?status=Incomplete'); ?>" class="stat-card-btn">View</a>
                </div>
            </div>
            <div class="col-7">
                <div class="stat-card yellow">
                    <div class="stat-card-title">MP In-Progress Public Problems</div>
                    <div class="stat-card-value"><?php
                     $cc12=  $this->db->query("SELECT count(*) as totalusers FROM `districtpublicproblem` WHERE    `work_status`='In progress' ");
                     $cc122=$cc12->row();
                     echo $cc122->totalusers; ?></div>
                    <a href="<?php echo base_url('Districtpublicproblem/Disctrictproblem?status=In progress'); ?>" class="stat-card-btn">View</a>
                </div>
            </div>
            <div class="col-7">
                <div class="stat-card red">
                    <div class="stat-card-title">MP Rejected Public Problems</div>
                    <div class="stat-card-value"><?php
                     $cc12=  $this->db->query("SELECT count(*) as totalusers FROM `districtpublicproblem` WHERE `work_status`='Reject' ");
                     $cc122=$cc12->row();
                     echo $cc122->totalusers; ?></div>
                    <a href="<?php echo base_url('Districtpublicproblem/Disctrictproblem?status=Reject'); ?>" class="stat-card-btn">View</a>
                </div>
            </div>
        </div>
        <div class="dashboard-section" id="section-charts">
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <div class="box box-primary" >
                        <form method="post" action="<?php echo base_url('user/index'); ?>">
                            <div class="row">
                                <!-- Start Date -->
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="start_date">Start Date:</label>
                                        <input type="date" id="start_date" name="start_date" class="form-control"
                                            value="<?php echo set_value('start_date'); ?>">
                                    </div>
                                </div>
                                <!-- End Date -->
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="end_date">End Date:</label>
                                        <input type="date" id="end_date" name="end_date" class="form-control"
                                            value="<?php echo set_value('end_date'); ?>">
                                    </div>
                                </div>
                                <!-- Submit Button -->
                                <div class="col-md-4 col-sm-12 col-xs-12 d-flex align-items-end " style="margin-top: 22px;">
                                    <div class="form-group">
                                        <label for=" "></label>
                                        <button type="submit" class="btn btn-primary">Filter Graph Data</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-xs-6">
                    <div class="box box-primary" >
                        <h4 >Status By Block</h4>
                        <button onclick="printChart('barChart')" class="btn btn-primary">Print Bar Chart</button>
                        <canvas id="barChart" style="max-height: 300px;"></canvas>
                    </div>
                </div>
                <div class="col-lg-6 col-xs-6">
                    <div class="box box-primary" >
                        <h4 >Over-All Status</h4>
                        <button onclick="printChart('pieChart')" class="btn btn-primary">Print Pie Chart</button>
                        <canvas id="pieChart" style="max-height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-section" id="section-assembly-table">
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <div class="box box-primary" >
                        <form method="post" action="<?php echo base_url('user/index'); ?>">
                            <div class="row">
                                <!-- Start Block -->
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="block">Start Block:</label>
                                        <select id="block" name="blockname" class="form-control">
                                            <option value="">Select</option>
                                            <?php foreach($Allblocks as $eachblock) { ?>
                                            <option value="<?php echo $eachblock->id ?>" <?php echo (isset($blockname) && $blockname == $eachblock->id) ? 'selected' : ''; ?>><?php echo $eachblock->name ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- Submit Button -->
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </form>
                        <div class="box-body table-responsive no-padding">
                            <h3 style="text-align:center;"><b>My Assembly Department - Summary Report</b></h3>
                            <table class="table table-hover" id="dashboardtable">
                                <thead>
                                    <tr>
                                        <th>Department Name</th>
                                        <th>Complete</th>
                                        <th>Incomplete</th>
                                        <th>In Progress</th>
                                        <th>Total</th>
                                        <!-- New Total column -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($results)): ?>
                                    <?php foreach ($results as $row): ?>
                                    <tr>
                                        <td>
                                            <a
                                                href="<?php echo base_url()?>user/filterJansunwai?block=&stage=&status=<?php echo $row->work_statuses ?>&department=<?php echo $row->department_id ?>">
                                                <?php echo $row->department_name; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a
                                                href="<?php echo base_url()?>user/filterJansunwai?block=&stage=&status=Complete&department=<?php echo $row->department_id ?>">
                                                <?php echo $row->complete_count; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a
                                                href="<?php echo base_url()?>user/filterJansunwai?block=&stage=&status=Incomplete&department=<?php echo $row->department_id ?>">
                                                <?php echo $row->incomplete_count; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a
                                                href="<?php echo base_url()?>user/filterJansunwai?block=&stage=&status=In progress&department=<?php echo $row->department_id ?>">
                                                <?php echo $row->inprogress_count; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a
                                                href="<?php echo base_url()?>user/filterJansunwai?block=&stage=&status=&department=<?php echo $row->department_id ?>">
                                                <?php echo $row->total_count; ?>
                                            </a>
                                        </td>
                                        <!-- Display total -->
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <tr>
                                        <td colspan="5">No data available</td>
                                        <!-- Adjust colspan for total column -->
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
            </div>
        </div>

        <div class="dashboard-section" id="section-mp-table">
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <div class="box box-primary" >
                        <div class="box-body table-responsive no-padding">
                            <h3 style="text-align:center;"><b>MP Public Problems Department - Summary Report</b></h3>
                            <table class="table table-hover" id="dashboardtable">
                                <thead>
                                    <tr>
                                        <th>Department Name</th>
                                        <th>Complete</th>
                                        <th>Incomplete</th>
                                        <th>In Progress</th>
                                        <th>Total Problems</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($public_problems_dept_summary)): ?>
                                    <?php foreach ($public_problems_dept_summary as $row): ?>
                                    <tr>
                                        <td>
                                            <a
                                                href="<?php echo base_url()?>Districtpublicproblem/Disctrictproblem?department=<?php echo $row->department_id ?>">
                                                <?php echo $row->department_name; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a
                                                href="<?php echo base_url()?>Districtpublicproblem/Disctrictproblem?status=Complete&department=<?php echo $row->department_id ?>">
                                                <?php echo $row->completed; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a style="color:red;"
                                                href="<?php echo base_url()?>Districtpublicproblem/Disctrictproblem?status=Incomplete&department=<?php echo $row->department_id ?>">
                                                <?php echo $row->incomplete; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a
                                                href="<?php echo base_url()?>user/filterdistrictpublicproblemlist?block=&stage=&status=In progress&department=<?php echo $row->department_id ?>">
                                                <?php echo $row->in_progress; ?>
                                            </a>
                                        </td>
                                        <td> <?php echo $row->total_problems; ?> </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <tr>
                                        <td colspan="5">No data available</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
            </div>
        </div>

        <!-- <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="box box-primary" >
                    <div class="box-body table-responsive no-padding">
                        <h3 style="text-align:center;"><b>MP Public Problems - Summary Report</b></h3>
                        <table class="table table-hover" id="dashboardtable2">
                            <thead>
                                <tr>
                                    <th>Total Records</th>
                                    <th>Today Records</th>
                                    <th>Total Incomplete</th>
                                    <th>Total Complete</th>
                                    <th>In Progress</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($public_problems_summary)): ?>
                                <?php foreach ($public_problems_summary as $row): ?>
                                <tr>
                                    <td><?php echo $row->total_records; ?></td>
                                    <td><?php echo $row->today_records; ?></td>
                                    <td style="color:red;"><?php echo $row->total_incomplete; ?></td>
                                    <td><?php echo $row->total_complete; ?></td>
                                    <td><?php echo $row->in_progress; ?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="7">No records found</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div> -->
        <!-- <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="box box-primary" >
                    <div class="box-body table-responsive no-padding">
                        <h3 style="text-align:center;"><b>Public Problems - Summary Report</b></h3>
                        <table class="table table-hover" id="dashboardtable">
                            <thead>
                                <tr>
                                    <th>Block Name</th>
                                    <th>Total Records</th>
                                    <th>Today Records</th>
                                    <th>Total Incomplete</th>
                                    <th>Total Complete</th>
                                    <th class="gray">Stage 1 - Incomplete</th>
                                    <th class="gray">Stage 1 - Complete</th>
                                    <th class="gray">Stage 1 - In-progress</th>
                                    <th class="dark-gray">Stage 2 - Incomplete</th>
                                    <th class="dark-gray">Stage 2 - Complete</th>
                                    <th class="dark-gray">Stage 2 - In-progress</th>
                                    <th class="light-gray">Stage 3 - Incomplete</th>
                                    <th class="light-gray">Stage 3 - Complete</th>
                                    <th class="light-gray">Stage 3 - In-progress</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($records)): ?>
                                <?php foreach($records as $row): ?>
                                <?php 
                           $total_incomplete = $row->stage_1_incomplete + $row->stage_2_incomplete + $row->stage_3_incomplete;
                           $total_complete = $row->stage_1_complete + $row->stage_2_complete + $row->stage_3_complete;
                        ?>
                                <tr>
                                    <td><?= $row->block_name ?></td>
                                    <td>
                                        <a
                                            href="<?php echo base_url()?>user/filterJansunwai?block=<?php echo $row->block_id ?>&stage=&status=">
                                            <?= $row->total_records ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a
                                            href="<?php echo base_url()?>user/filterJansunwai?block=<?php echo $row->block_id ?>&stage=1&status=">
                                            <?= $row->today_count ?>
                                        </a>
                                    </td>
                                    <td style="color:red;">
                                        <a
                                            href="<?php echo base_url()?>user/filterJansunwai?block=<?php echo $row->block_id ?>&stage=&status=Incomplete">
                                            <?= $total_incomplete ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a
                                            href="<?php echo base_url()?>user/filterJansunwai?block=<?php echo $row->block_id ?>&stage=&status=complete">
                                            <?= $total_complete ?>
                                        </a>
                                    </td>
                                    <td style="color:red;">
                                        <a
                                            href="<?php echo base_url()?>user/filterJansunwai?block=<?php echo $row->block_id ?>&stage=1&status=Incomplete">
                                            <?= $row->stage_1_incomplete ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a
                                            href="<?php echo base_url()?>user/filterJansunwai?block=<?php echo $row->block_id ?>&stage=1&status=complete">
                                            <?= $row->stage_1_complete ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a
                                            href="<?php echo base_url()?>user/filterJansunwai?block=<?php echo $row->block_id ?>&stage=1&status=In progress">
                                            <?= $row->stage_1_in_progress ?>
                                        </a>
                                    </td>
                                    <td style="color:red;">
                                        <a
                                            href="<?php echo base_url()?>user/filterJansunwai?block=<?php echo $row->block_id ?>&stage=2&status=Incomplete">
                                            <?= $row->stage_2_incomplete ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a
                                            href="<?php echo base_url()?>user/filterJansunwai?block=<?php echo $row->block_id ?>&stage=2&status=complete">
                                            <?= $row->stage_2_complete ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a
                                            href="<?php echo base_url()?>user/filterJansunwai?block=<?php echo $row->block_id ?>&stage=2&status=In progress">
                                            <?= $row->stage_2_in_progress ?>
                                        </a>
                                    </td>
                                    <td style="color:red;">
                                        <a
                                            href="<?php echo base_url()?>user/filterJansunwai?block=<?php echo $row->block_id ?>&stage=3&status=Incomplete">
                                            <?= $row->stage_3_incomplete ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a
                                            href="<?php echo base_url()?>user/filterJansunwai?block=<?php echo $row->block_id ?>&stage=3&status=complete">
                                            <?= $row->stage_3_complete ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a
                                            href="<?php echo base_url()?>user/filterJansunwai?block=<?php echo $row->block_id ?>&stage=3&status=In progress">
                                            <?= $row->stage_3_in_progress ?>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="14">No records found</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div> -->
        <div class="dashboard-section" id="section-vidhan-worker-code">
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <div class="box box-primary" >
                        <div class="box-body table-responsive no-padding">
                            <h3 style="text-align:center;"><b>Vidhan Sabha Party Worker Code Summary</b></h3>
                            <table class="table table-hover" id="dashboardtable1">
                                <thead>
                                    <tr>
                                        <th>Block Name</th>
                                        <th class="th-total-count">Total Count</th>
                                        <th class="th-today-count">Today Count</th>
                                        <?php if (!empty($coding_types)) { foreach ($coding_types as $ct) : ?>
                                        <th><?php echo htmlspecialchars($ct['label']); ?></th>
                                        <?php endforeach; } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $coding_types = isset($coding_types) ? $coding_types : [];
                                    if (!empty($blocks)) :
                                        foreach ($blocks as $block) :
                                            $block_param = isset($block->block_id) ? 'block=' . $block->block_id : 'block=';
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($block->BlockName); ?></td>
                                        <td><?php echo isset($block->Total_Count) ? (int)$block->Total_Count : 0; ?></td>
                                        <td><?php echo isset($block->Today_Count) ? (int)$block->Today_Count : 0; ?></td>
                                        <?php foreach ($coding_types as $ct) :
                                            $col = $ct['col'];
                                            $count = isset($block->$col) ? (int)$block->$col : 0;
                                            $url = base_url('user/filterServaylisting') . '?' . $block_param . '&code=' . rawurlencode($ct['code_param']);
                                        ?>
                                        <td><a href="<?php echo $url; ?>"><?php echo $count; ?></a></td>
                                        <?php endforeach; ?>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else : ?>
                                    <tr>
                                        <td colspan="<?php echo count($coding_types) + 3; ?>">No data available.</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
            </div>
        </div>
        <div class="dashboard-section" id="section-mp-worker-code">
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <div class="box box-primary" >
                        <form method="post" action="<?php echo base_url('user/index'); ?>">
                            <div class="row" style="padding: 15px 15px 0 15px;">
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Summary View By:</label>
                                        <select name="summary_type" class="form-control" onchange="this.form.submit()">
                                            <option value="district" <?php echo ($summary_type == 'district') ? 'selected' : ''; ?>>District Wise</option>
                                            <option value="vidhan_sabha" <?php echo ($summary_type == 'vidhan_sabha') ? 'selected' : ''; ?>>Vidhan Sabha Wise</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>District:</label>
                                        <select name="filter_district" id="worker_filter_district" class="form-control">
                                            <option value="">All Districts</option>
                                            <?php if(!empty($Alldistricts)) { foreach($Alldistricts as $dist) { ?>
                                            <option value="<?php echo $dist->id ?>" <?php echo ($filter_district == $dist->id) ? 'selected' : ''; ?>>
                                                <?php echo $dist->name ?>
                                            </option>
                                            <?php } } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Vidhan Sabha:</label>
                                        <select name="filter_vidhan_sabha" id="worker_filter_vidhan_sabha" class="form-control">
                                            <option value="">All Vidhan Sabhas</option>
                                            <?php if(!empty($Allvidhansabhas)) { foreach($Allvidhansabhas as $vs) { ?>
                                            <option value="<?php echo $vs->id ?>" <?php echo ($filter_vidhan_sabha == $vs->id) ? 'selected' : ''; ?>>
                                                <?php echo $vs->vidhan_sabha_name ?>
                                            </option>
                                            <?php } } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12" style="margin-top: 25px;">
                                    <button type="submit" class="btn btn-primary btn-block">Apply Filters</button>
                                </div>
                            </div>
                        </form>
                        <hr style="margin: 5px 0;">
                        <div class="box-body table-responsive no-padding">
                            <h3 style="text-align:center;"><b>MP Party Worker Code Summary</b></h3>
                            <table class="table table-hover" id="dashboardtable1">
                                <thead>
                                    <tr>
                                        <th>District Name</th>
                                        <?php if ($summary_type == 'vidhan_sabha') : ?>
                                        <th>Vidhan Sabha Name</th>
                                        <?php endif; ?>
                                        <th class="th-total-count">Total Count</th>
                                        <th class="th-today-count">Today Count</th>
                                        <?php if (!empty($coding_types)) { foreach ($coding_types as $ct) : ?>
                                        <th><?php echo htmlspecialchars($ct['label']); ?></th>
                                        <?php endforeach; } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($districts)) :
                                        if ($summary_type == 'vidhan_sabha') :
                                            $district_groups = [];
                                            foreach ($districts as $row) {
                                                $d_id = $row->district_id_val ? $row->district_id_val : 'total';
                                                $district_groups[$d_id][] = $row;
                                            }
                                            foreach ($district_groups as $d_id => $rows) :
                                                foreach ($rows as $index => $block) :
                                                    $vs_param = $block->vidhan_sabha_id ? 'vidhan_sabha_id=' . $block->vidhan_sabha_id : 'vidhan_sabha_id=';
                                    ?>
                                    <tr>
                                        <?php if ($index === 0) : ?>
                                        <td rowspan="<?php echo count($rows); ?>" style="vertical-align: middle; background-color: #f9f9f9; font-weight: bold;">
                                            <?php echo htmlspecialchars(($block->district_id_val ? $block->DistrictName : 'All Districts') ?? ''); ?>
                                        </td>
                                        <?php endif; ?>
                                        <td><?php echo htmlspecialchars(($block->vidhan_sabha_id ? $block->VidhanSabhaName : 'All Vidhan Sabhas') ?? ''); ?></td>
                                        <td><?php echo isset($block->Total_Count) ? (int)$block->Total_Count : 0; ?></td>
                                        <td><?php echo isset($block->Today_Count) ? (int)$block->Today_Count : 0; ?></td>
                                        <?php foreach ($coding_types as $ct) :
                                            $col = $ct['col'];
                                            $count = isset($block->$col) ? (int)$block->$col : 0;
                                            $url = base_url('user/filterServaylisting') . '?' . $vs_param . '&code=' . rawurlencode($ct['code_param']);
                                        ?>
                                        <td><a href="<?php echo $url; ?>"><?php echo $count; ?></a></td>
                                        <?php endforeach; ?>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php endforeach; ?>
                                    <?php else : ?>
                                    <?php foreach ($districts as $block) : 
                                        $district_param = isset($block->district_id) ? 'district_id=' . $block->district_id : 'district_id=';
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($block->DistrictName ?? ''); ?></td>
                                        <td><?php echo isset($block->Total_Count) ? (int)$block->Total_Count : 0; ?></td>
                                        <td><?php echo isset($block->Today_Count) ? (int)$block->Today_Count : 0; ?></td>
                                        <?php foreach ($coding_types as $ct) :
                                            $col = $ct['col'];
                                            $count = isset($block->$col) ? (int)$block->$col : 0;
                                            $url = base_url('user/filterServaylisting') . '?' . $district_param . '&code=' . rawurlencode($ct['code_param']);
                                        ?>
                                        <td><a href="<?php echo $url; ?>"><?php echo $count; ?></a></td>
                                        <?php endforeach; ?>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php else : ?>
                                <tr>
                                    <td colspan="<?php echo count($coding_types) + 3; ?>">No data available.</td>
                                </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fund Summary Section -->
        <!-- <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="box box-primary" >
                    <div class="box-body table-responsive no-padding">
                        <h3 style="text-align:center;"><b>Fund Summary</b></h3>
                        <table class="table table-hover" id="dashboardtable">
                            <thead>
                                <tr>
                                    <th>Fund Name</th>
                                    <th>Complete</th>
                                    <th>Incomplete</th>
                                    <th>In Progress</th>
                                    <th>Total</th>
                                    <th>Total Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($fund_summary)): ?>
                                <?php foreach ($fund_summary as $row): ?>
                                <tr>
                                    <td><?php echo $row->fund_name; ?></td>
                                    <td><?php echo $row->complete_count; ?></td>
                                    <td><?php echo $row->incomplete_count; ?></td>
                                    <td><?php echo $row->inprogress_count; ?></td>
                                    <td><?php echo $row->total_count; ?></td>
                                    <td><?php echo number_format($row->total_amount, 2); ?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="6">No data available</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> -->

        <!-- Project Summary Section -->
        <!-- <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="box box-primary" >
                    <div class="box-body table-responsive no-padding">
                        <h3 style="text-align:center;"><b>Project Summary</b></h3>
                        <table class="table table-hover" id="dashboardtable">
                            <thead>
                                <tr>
                                    <th>Work Name</th>
                                    <th>Active</th>
                                    <th>Completed</th>
                                    <th>Pending</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($project_summary)): ?>
                                <?php foreach ($project_summary as $row): ?>
                                <tr>
                                    <td><?php echo $row->work_name; ?></td>
                                    <td><?php echo $row->active_count; ?></td>
                                    <td><?php echo $row->completed_count; ?></td>
                                    <td><?php echo $row->pending_count; ?></td>
                                    <td><?php echo $row->total_count; ?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="5">No data available</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> -->

        <!-- Event Summary Section -->
        <!-- <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="box box-primary" >
                    <div class="box-body table-responsive no-padding">
                        <h3 style="text-align:center;"><b>Event Summary</b></h3>
                        <table class="table table-hover" id="dashboardtable">
                            <thead>
                                <tr>
                                    <th>Event Name</th>
                                    <th>Approved</th>
                                    <th>Pending</th>
                                    <th>Rejected</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($event_summary)): ?>
                                <?php foreach ($event_summary as $row): ?>
                                <tr>
                                    <td><?php echo $row->event_name; ?></td>
                                    <td><?php echo $row->approved_count; ?></td>
                                    <td><?php echo $row->pending_count; ?></td>
                                    <td><?php echo $row->rejected_count; ?></td>
                                    <td><?php echo $row->total_count; ?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="5">No data available</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> -->

        <!-- Visitor Summary Section -->
        <!-- <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="box box-primary" >
                    <div class="box-body table-responsive no-padding">
                        <h3 style="text-align:center;"><b>Visitor Summary</b></h3>
                        <table class="table table-hover" id="dashboardtable">
                            <thead>
                                <tr>
                                    <th>District</th>
                                    <th>Total Visitors</th>
                                    <th>Today Visitors</th>
                                    <th>This Month Visitors</th>
                                    <th>This Year Visitors</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($visitor_summary)): ?>
                                <?php foreach ($visitor_summary as $row): ?>
                                <tr>
                                    <td><?php echo $row->district; ?></td>
                                    <td><?php echo $row->total_visitors; ?></td>
                                    <td><?php echo $row->today_visitors; ?></td>
                                    <td><?php echo $row->month_visitors; ?></td>
                                    <td><?php echo $row->year_visitors; ?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="5">No data available</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> -->
    </section>
</div>
<!-- DataTables and related plugins -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.2.2/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script>
$(document).ready(function() {
    $('#dashboardtable, #dashboardtable1').DataTable({
        "processing": true,
        "serverSide": false,
        "dom": '<"top"lfB>rt<"bottom"ip>',
        "buttons": [{
            extend: 'excelHtml5',
            text: 'Export Excel',
            title: 'List'
        }],
        "paging": true,
        "searching": true,
        "ordering": false,
        "info": true,
        "lengthMenu": [
            [10, 25, 50, 75, -1],
            [10, 25, 50, 75, "All"]
        ]
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
var ctx = document.getElementById('pieChart').getContext('2d');

// Data for pie chart
var statusCountData = <?php echo json_encode($status_count); ?>;
var statuses = [];
var counts = [];
var colors = {
    'Incomplete': 'red',
    'Complete': '#18d94b',
    'In progress': '#FFCE56'
};

// Prepare data for pie chart
statusCountData.forEach(function(item) {
    statuses.push(item.work_status);
    counts.push(item.total);
});

// Create pie chart
var pieChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: statuses.map(function(status, index) {
            // Adding count with each label
            return `${status} (${counts[index]} records)`;
        }),
        datasets: [{
            data: counts,
            backgroundColor: statuses.map(status => colors[status] || '#CCCCCC'),
            hoverOffset: 4
        }]
    },
    options: {
        plugins: {
            legend: {
                display: true,
                position: 'bottom'
            },
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        var label = tooltipItem.label || '';
                        if (label) {
                            label += ': ';
                        }
                        label += tooltipItem.raw + ' records';
                        return label;
                    }
                }
            }
        }
    }
});
</script>
<script>
var ctx = document.getElementById('barChart').getContext('2d');

// Data for bar chart
var statusCountData = <?php echo json_encode($status_count_by_block); ?>;
var blocks = [];
var incompleteCounts = [];
var completeCounts = [];
var inProgressCounts = [];

statusCountData.forEach(function(item) {
    var index = blocks.indexOf(item.block_name);
    if (index === -1) {
        blocks.push(item.block_name);
        incompleteCounts.push(0);
        completeCounts.push(0);
        inProgressCounts.push(0);
        index = blocks.length - 1;
    }
    if (item.work_status === 'Incomplete') {
        incompleteCounts[index] += item.total;
    } else if (item.work_status === 'Complete') {
        completeCounts[index] += item.total;
    } else if (item.work_status === 'In progress') {
        inProgressCounts[index] += item.total;
    }
});

var barChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: blocks,
        datasets: [{
            label: 'Incomplete',
            data: incompleteCounts,
            backgroundColor: 'red',
        }, {
            label: 'Complete',
            data: completeCounts,
            backgroundColor: '#18d94b',
        }, {
            label: 'In Progress',
            data: inProgressCounts,
            backgroundColor: '#FFCE56',
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Print chart function
function printChart(chartId) {
    var chartCanvas = document.getElementById(chartId);
    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Print Chart</title></head><body>');
    printWindow.document.write('<img src="' + chartCanvas.toDataURL() + '"/>');
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
}
</script>

<script>
$(document).ready(function() {
    var allVidhanSabhas = <?php echo json_encode($Allvidhansabhas); ?>;
    
    $('#worker_filter_district').change(function() {
        var districtId = $(this).val();
        var vsDropdown = $('#worker_filter_vidhan_sabha');
        vsDropdown.empty();
        vsDropdown.append('<option value="">All Vidhan Sabhas</option>');
        
        if (districtId) {
            var filteredVS = allVidhanSabhas.filter(function(vs) {
                return vs.district_id == districtId;
            });
            
            filteredVS.forEach(function(vs) {
                vsDropdown.append('<option value="' + vs.id + '">' + vs.vidhan_sabha_name + '</option>');
            });
        } else {
            allVidhanSabhas.forEach(function(vs) {
                vsDropdown.append('<option value="' + vs.id + '">' + vs.vidhan_sabha_name + '</option>');
            });
        }
    });

    // Widget Toggle Functionality
    const widgetToggleBtn = $('#widgetToggleBtn');
    const widgetPanel = $('#widgetPanel');
    const widgetOverlay = $('#widgetOverlay');
    const widgetPanelClose = $('#widgetPanelClose');
    const widgetCheckboxes = $('.widget-checkbox');
    const widgetResetBtn = $('#widgetResetBtn');

    // Load saved preferences from localStorage
    function loadWidgetPreferences() {
        const saved = localStorage.getItem('dashboardWidgets');
        if (saved) {
            const preferences = JSON.parse(saved);
            widgetCheckboxes.each(function() {
                const section = $(this).data('section');
                if (preferences.hasOwnProperty(section)) {
                    $(this).prop('checked', preferences[section]);
                }
            });
            applyWidgetPreferences();
        }
    }

    // Save preferences to localStorage
    function saveWidgetPreferences() {
        const preferences = {};
        widgetCheckboxes.each(function() {
            const section = $(this).data('section');
            preferences[section] = $(this).is(':checked');
        });
        localStorage.setItem('dashboardWidgets', JSON.stringify(preferences));
    }

    // Apply widget preferences (show/hide sections)
    function applyWidgetPreferences() {
        widgetCheckboxes.each(function() {
            const section = $(this).data('section');
            const isChecked = $(this).is(':checked');
            const sectionElement = $('#section-' + section);
            
            if (isChecked) {
                sectionElement.removeClass('hidden');
            } else {
                sectionElement.addClass('hidden');
            }
        });
    }

    // Toggle widget panel
    widgetToggleBtn.click(function() {
        widgetPanel.toggleClass('active');
        widgetOverlay.toggleClass('active');
    });

    // Close widget panel
    widgetPanelClose.click(function() {
        widgetPanel.removeClass('active');
        widgetOverlay.removeClass('active');
    });

    // Close panel when clicking overlay
    widgetOverlay.click(function() {
        widgetPanel.removeClass('active');
        widgetOverlay.removeClass('active');
    });

    // Handle checkbox changes
    widgetCheckboxes.change(function() {
        applyWidgetPreferences();
        saveWidgetPreferences();
    });

    // Reset to default
    widgetResetBtn.click(function() {
        if (confirm('Are you sure you want to reset all widgets to default?')) {
            widgetCheckboxes.prop('checked', true);
            applyWidgetPreferences();
            saveWidgetPreferences();
        }
    });

    // Load preferences on page load
    loadWidgetPreferences();
});
</script>
