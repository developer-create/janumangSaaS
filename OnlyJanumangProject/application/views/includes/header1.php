<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Jan Umang</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/bower_components/Ionicons/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <style>
    	.error{
    		color:red;
    		font-weight: normal;
    	}
    	
    	button.dt-button.buttons-excel.buttons-html5 {
    left: 58px !important;
}
div#feedbackTa_filter {
    margin-right: 138px !important;
}
/* 3px black border for all table rows in CRUD list pages */
table tbody tr td {
    border: 1px solid #000000 !important;
}
table {
    border-collapse: separate !important;
    border-spacing: 0 !important;
}

/* Global table header styling for all tables */
.table thead th {
    background-color: #020254 !important; /* Deep navy blue */
    color: white !important;
    font-weight: bold !important;
    text-align: center !important;
    padding: 12px 8px !important;
    border: 1px solid #2e6da4 !important;
}

/* Dashboard specific table headers with different colors */
#dashboardtable thead th {
    background-color: #3c8dbc !important; /* Light blue */
    color: white !important;
}

#dashboardtable1 thead th {
    background-color: #00a65a !important; /* Green */
    color: white !important;
}

#dashboardtable1 thead th.th-total-count,
#dashboardtable1 thead th.th-today-count {
    background-color: #1a6fc4 !important;
    color: white !important;
}

#dashboardtable2 thead th {
    background-color: #f39c12 !important; /* Orange */
    color: white !important;
}

/* Ganesh Samiti table headers */
#ganeshSamitiTable thead th {
    background-color: #605ca8 !important; /* Purple */
    color: white !important;
}

/* Other module specific table headers */
#mandirSamitiTable thead th {
    background-color: #dd4b39 !important; /* Red */
    color: white !important;
}

#tenkarTable thead th {
    background-color: #00c0ef !important; /* Cyan */
    color: white !important;
}

#phoneDirectoryTable thead th {
    background-color: #932ab6 !important; /* Dark purple */
    color: white !important;
}

#voterTable thead th {
    background-color: #39cccc !important; /* Teal */
    color: white !important;
}

#visitorTable thead th {
    background-color: #ff7043 !important; /* Deep orange */
    color: white !important;
}

#vidhanSabhaTable thead th {
    background-color: #8bc34a !important; /* Light green */
    color: white !important;
}

#subtypeOfWorkTable thead th {
    background-color: #673ab7 !important; /* Deep purple */
    color: white !important;
}

#projectSummaryTable thead th {
    background-color: #795548 !important; /* Brown */
    color: white !important;
}

/* Jansunwai (Block-Level) table headers - centered text */
#feedbackTa thead th {
    background-color: #020254 !important; /* Dark blue as per existing styling */
    color: white !important;
    text-align: center !important; /* Center horizontally */
    vertical-align: middle !important; /* Center vertically */
    padding: 12px 8px !important;
    font-size: 15px !important;
    font-weight: bold !important;
    line-height: 1.2 !important;
    white-space: normal !important; /* Allow text wrapping */
    word-wrap: break-word !important; /* Break long words */
    border: 1px solid #fff !important; /* Add border for better separation */
}

/* Override any inline styles that might conflict */
#feedbackTa thead tr th {
    background-color: #020254 !important;
    color: white !important;
    text-align: center !important;
    vertical-align: middle !important;
}

/* Ensure proper cell alignment for jansunwai tables */
#feedbackTa tbody td {
    vertical-align: middle !important;
    padding: 8px !important;
    text-align: center !important;
}

/* Special handling for wider columns */
#feedbackTa th[style*="width:300px"] {
    max-width: 300px !important;
    min-width: 200px !important;
    word-wrap: break-word !important;
}

/* Additional responsive handling for jansunwai tables */
@media (max-width: 1200px) {
    #feedbackTa thead th {
        font-size: 13px !important;
        padding: 8px 4px !important;
    }
}

@media (max-width: 768px) {
    #feedbackTa thead th {
        font-size: 12px !important;
        padding: 6px 2px !important;
    }
}

/* Ensure DataTables wrapper doesn't override our header styling */
.dataTables_wrapper #feedbackTa thead th {
    background-color: #020254 !important;
    color: white !important;
    text-align: center !important;
    vertical-align: middle !important;
}

/* Universal Table Header Styling for All CRUD Pages */
.table thead th,
table thead th {
    background-color: #020254 !important;
    color: white !important;
    text-align: center !important;
    vertical-align: middle !important;
    padding: 8px !important;
}

/* Ensure all table body cells are centered and properly aligned */
.table tbody td, 
table tbody td {
    text-align: center !important;
    vertical-align: middle !important;
    padding: 8px !important;
}

/* Override any inline styles or conflicting CSS */
table[style] thead th {
    background-color: #020254 !important;
    color: white !important;
    text-align: center !important;
    vertical-align: middle !important;
}

/* Make sure DataTables doesn't override our styling */
.dataTables_wrapper table thead th {
    background-color: #020254 !important;
    color: white !important;
    text-align: center !important;
    vertical-align: middle !important;
}

/* Specific styling for common CRUD table IDs used throughout the application */
#example thead th,
#example2 thead th,
#userTable thead th,
#roleTable thead th,
#userListTable thead th,
#dataTable thead th,
#myTable thead th,
table.display thead th,
.display thead th {
    background-color: #020254 !important;
    color: white !important;
    text-align: center !important;
    vertical-align: middle !important;
}

/* Responsive handling for all tables */
@media (max-width: 1200px) {
    .table thead th, table thead th {
        font-size: 13px !important;
        padding: 8px 4px !important;
    }
}

@media (max-width: 768px) {
    .table thead th, table thead th {
        font-size: 12px !important;
        padding: 6px 2px !important;
    }
}

/* Hover effects for all table headers */
.table thead th:hover, 
table thead th:hover {
    opacity: 0.85 !important;
    transition: opacity 0.3s ease !important;
}

/* Ensure all links in table headers are visible and styled properly */
.table thead th a, 
table thead th a,
.table tbody td a,
table tbody td a {
    color: inherit !important;
    text-decoration: none !important;
}

.table thead th a:hover, 
table thead th a:hover {
    color: #f0f0f0 !important;
    text-decoration: underline !important;
}

/* Action buttons styling in CRUD tables */
.table tbody td .btn, 
table tbody td .btn {
    margin: 1px !important;
    padding: 4px 8px !important;
    font-size: 12px !important;
}

/* Ensure proper spacing for action columns */
.table tbody td:last-child,
table tbody td:last-child {
    white-space: nowrap !important;
}

/* Fix any alignment issues in action columns */
.text-center {
    text-align: center !important;
}

/* Ensure consistent styling across all table types */
.table-striped thead th,
.table-bordered thead th,
.table-hover thead th,
.table-condensed thead th {
    background-color: #020254 !important;
    color: white !important;
    text-align: center !important;
    vertical-align: middle !important;
}

/* Special styling for stage headers in dashboard */
.gray {
    background-color: #6c757d !important; /* Bootstrap gray */
    color: white !important;
}

.light-gray {
    background-color: #adb5bd !important; /* Light gray */
    color: white !important;
}

.dark-gray {
    background-color: #495057 !important; /* Dark gray */
    color: white !important;
}

/* Hover effect for table headers */
.table thead th:hover {
    opacity: 0.8;
    transition: opacity 0.3s ease;
}

/* Ensure links in headers remain visible */
.table thead th a {
    color: white !important;
    text-decoration: none;
}

.table thead th a:hover {
    color: #f0f0f0 !important;
    text-decoration: underline;
}
    /* Disable text selection */
    body {
        -webkit-user-select: none; /* Safari */
        -moz-user-select: none;    /* Firefox */
        -ms-user-select: none;     /* IE10+ */
        user-select: none;         /* Standard */
    }
    </style>
    <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript">
        var baseURL = "<?php echo base_url(); ?>";
    </script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
      
      <header class="main-header">
        <!-- Logo -->
        <?php if($this->session->userdata('role') != 1){ ?>
        <a href="#" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>J </b>U</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Jan Umang</b></span>
        </a>
        <?php }else{ ?>
        <a href="<?php echo base_url() ?>dashboard" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>J </b>U</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Jan Umang</b></span>
        </a>
        
        <?php } ?>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li class="dropdown tasks-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                  <i class="fa fa-history"></i>
                </a>
                <ul class="dropdown-menu">
                  <li class="header"> Last Login : <i class="fa fa-clock-o"></i> <?= empty($this->session->userdata('last_login')) ? "First Time Login" : $this->session->userdata('last_login'); ?></li>
                </ul>
              </li>
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="user-image" alt="User Image"/>
                  <span class="hidden-xs"><?php echo $this->session->userdata('name') ? $this->session->userdata('name') : 'User'; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    
                    <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="img-circle" alt="User Image" />
                    <p>
                      <?php echo $this->session->userdata('name') ? $this->session->userdata('name') : 'User'; ?>
                      <small><?php echo $this->session->userdata('role_text') ? $this->session->userdata('role_text') : 'Role'; ?></small>
                    </p>
                    
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="<?php echo base_url(); ?>profile" class="btn btn-warning btn-flat"><i class="fa fa-user-circle"></i> Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="<?php echo base_url(); ?>logout" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            
            
            
               <?php if($this->session->userdata('isAdmin') != 1){ ?>
                 <li> 
                          <a href="<?php echo base_url() ?>blockdashboard" >
                                <i class="fa fa-circle"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        
                        <?php } ?>
               
               
                  <?php
                  // Check if user has admin role (roleId == 1) - only admin role gets all modules
                  $userRoleId = $this->session->userdata('role');
                  $isAdminRole = ($userRoleId == 1); // Admin role ID is 1
                  $modulesToProcess = array();
                  
                  if ($isAdminRole) {
                      // Admin role users: Load all modules from config
                      $this->load->config('modules');
                      $moduleList = $this->config->item('moduleList');
                      if (!empty($moduleList)) {
                          foreach ($moduleList as $module) {
                              // Convert config module format to access_info format
                              $modulesToProcess[] = array(
                                  'module' => $module['module'],
                                  'list' => 1,  // Admin role has access to all
                                  'total_access' => 1,
                                  'url' => $module['url']
                              );
                          }
                      }
                  } else {
                      // Non-admin users: Use access_info from session (associative array keyed by module name)
                      if (!empty($access_info) && is_array($access_info)) {
                          // Convert access_info format to include URL
                          $this->load->config('modules');
                          $moduleList = $this->config->item('moduleList');
                          $moduleUrlMap = array();
                          if (!empty($moduleList)) {
                              foreach ($moduleList as $module) {
                                  $moduleUrlMap[$module['module']] = $module['url'];
                              }
                          }
                          
                          // access_info is associative array: ['ModuleName' => ['module' => 'ModuleName', 'list' => 1, ...], ...]
                          foreach ($access_info as $moduleName => $module) {
                              // Ensure module data is array
                              $moduleData = is_array($module) ? $module : (array)$module;
                              
                              // Ensure module name is set and trimmed
                              if (!isset($moduleData['module']) || empty(trim($moduleData['module']))) {
                                  $moduleData['module'] = trim($moduleName);
                              } else {
                                  $moduleData['module'] = trim($moduleData['module']);
                              }
                              
                              // Only include modules where user has list or total_access permission
                              if ((isset($moduleData['list']) && $moduleData['list'] == 1) || 
                                  (isset($moduleData['total_access']) && $moduleData['total_access'] == 1)) {
                                  // Add URL if not present - try both exact match and case-insensitive match
                                  if (!isset($moduleData['url'])) {
                                      if (isset($moduleUrlMap[$moduleData['module']])) {
                                          $moduleData['url'] = $moduleUrlMap[$moduleData['module']];
                                      } else {
                                          // Try case-insensitive match
                                          foreach ($moduleUrlMap as $configModule => $configUrl) {
                                              if (strcasecmp($moduleData['module'], $configModule) == 0) {
                                                  $moduleData['url'] = $configUrl;
                                                  $moduleData['module'] = $configModule; // Normalize to config module name
                                                  break;
                                              }
                                          }
                                      }
                                  }
                                  $modulesToProcess[] = $moduleData;
                              }
                          }
                      }
                  }
                  
                  // First, collect Assembly Issue modules, Samiti modules, and other modules separately
                  $hasBlockLevel = false;
                  $hasBhopalLevel = false;
                  $hasUSSLevel = false;
                  $blockLevelUrl = '';
                  $bhopalLevelUrl = '';
                  $ussLevelUrl = '';
                  $samitiModules = array();
                  $otherModules = array();
                 
                  foreach ($modulesToProcess as $module) {
                    // Ensure module is an array and has the 'module' key
                    $moduleName = isset($module['module']) ? trim($module['module']) : '';
                    
                    // Check for Assembly Issue modules (case-insensitive comparison for safety)
                    if (strcasecmp($moduleName, 'Block-Level') == 0) {
                        // Check if user has list or total_access permission
                        $hasList = isset($module['list']) && $module['list'] == 1;
                        $hasTotalAccess = isset($module['total_access']) && $module['total_access'] == 1;
                        if ($hasList || $hasTotalAccess) {
                            $hasBlockLevel = true;
                            // Use direct routes instead of config URLs
                            $blockLevelUrl = base_url() . 'user/jansunwai';
                        }
                    }
                    if (strcasecmp($moduleName, 'Bhopal-Level') == 0) {
                        $hasList = isset($module['list']) && $module['list'] == 1;
                        $hasTotalAccess = isset($module['total_access']) && $module['total_access'] == 1;
                        if ($hasList || $hasTotalAccess) {
                            $hasBhopalLevel = true;
                            $bhopalLevelUrl = base_url() . 'user/jansunwai2';
                        }
                    }
                    if (strcasecmp($moduleName, 'USS-Level') == 0) {
                        $hasList = isset($module['list']) && $module['list'] == 1;
                        $hasTotalAccess = isset($module['total_access']) && $module['total_access'] == 1;
                        if ($hasList || $hasTotalAccess) {
                            $hasUSSLevel = true;
                            $ussLevelUrl = base_url() . 'user/jansunwai3';
                        }
                    }
                    
                    // Check for Samiti modules
                    $isSamitiModule = (strcasecmp($moduleName, 'DP-Samiti') == 0 ||
                                      strcasecmp($moduleName, 'Ganesh-Samiti') == 0 ||
                                       strcasecmp($moduleName, 'Kabbadi-Samiti') == 0 ||
                                      strcasecmp($moduleName, 'Tenkar-Samiti') == 0 ||
                                      strcasecmp($moduleName, 'Mandir-Samiti') == 0 ||
                                      strcasecmp($moduleName, 'Bhagoria-Samiti') == 0 ||
                                      strcasecmp($moduleName, 'Nirman-Samiti') == 0 ||
                                      strcasecmp($moduleName, 'Booth-Samiti') == 0 ||
                                      strcasecmp($moduleName, 'Block-Samiti') == 0);
                    
                    // Collect modules (excluding Assembly Level modules and ActivityLog)
                    $isAssemblyLevelModule = (strcasecmp($moduleName, 'Block-Level') == 0 || 
                                          strcasecmp($moduleName, 'Bhopal-Level') == 0 || 
                                          strcasecmp($moduleName, 'USS-Level') == 0);
                    $isActivityLog = (strcasecmp($moduleName, 'ActivityLog') == 0);
                    
                    if (!$isAssemblyLevelModule && !$isActivityLog) {
                        $hasList = isset($module['list']) && $module['list'] == 1;
                        $hasTotalAccess = isset($module['total_access']) && $module['total_access'] == 1;
                        if ($hasList || $hasTotalAccess) {
                            if ($isSamitiModule) {
                                $samitiModules[] = $module;
                            } else {
                                $otherModules[] = $module;
                            }
                        }
                    }
                  }
                  
                  // Display other modules first, and insert Assembly Issue after MP-publicproblem (or at end if no MP-publicproblem)
                  $assemblyIssueShown = false;
                  $mpPublicProblemShown = false;
                  
                  foreach ($otherModules as $module) {
                    $url = $module['url'];
                    // Convert absolute URL to relative if needed
                    if (strpos($url, 'http') === 0) {
                        $parsedUrl = parse_url($url);
                        // Extract path and remove the base directory name if it exists
                        $path = ltrim($parsedUrl['path'], '/');
                        // Remove 'janumang/' from the path if it exists
                        $path = preg_replace('#^janumang/#', '', $path);
                        $url = base_url() . $path;
                    }
                    
                    if ($this->session->userdata('blockId') != 0 && $this->session->userdata('isAdmin') != 1 && $module['module'] =='Dashboard') {
                         $url = base_url().'blockdashboard'; 
                    }
                    ?>
                    
                    <li> 
                        <a href="<?php echo $url; ?>">
                            <i class="fa fa-circle"></i>
                            <span><?php echo $module['module']; ?></span>
                        </a>
                    </li>
                    
                    <?php
                    // Track if MP-publicproblem was shown
                    if ($module['module'] == 'MP-publicproblem') {
                        $mpPublicProblemShown = true;
                    }
                    
                    // Insert Assembly Issue dropdown right after MP-publicproblem (if it exists)
                    if ($module['module'] == 'MP-publicproblem' && ($hasBlockLevel || $hasBhopalLevel || $hasUSSLevel) && !$assemblyIssueShown) {
                        ?>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-file-text"></i> <span>Assembly Issue</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <?php if ($hasBlockLevel): ?>
                                <li><a href="<?php echo $blockLevelUrl; ?>"><i class="fa fa-circle-o"></i> <span>Block-Level</span></a></li>
                                <?php endif; ?>
                                <?php if ($hasBhopalLevel): ?>
                                <li><a href="<?php echo $bhopalLevelUrl; ?>"><i class="fa fa-circle-o"></i> <span>Bhopal-Level</span></a></li>
                                <?php endif; ?>
                                <?php if ($hasUSSLevel): ?>
                                <li><a href="<?php echo $ussLevelUrl; ?>"><i class="fa fa-circle-o"></i> <span>USS-Level</span></a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <?php
                        $assemblyIssueShown = true;
                    }
                    
                    // Insert Vidhasabha Samiti dropdown right after MP-publicproblem (if it exists) and Assembly Issue
                    if ($module['module'] == 'MP-publicproblem' && !empty($samitiModules)) {
                        ?>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-users"></i> <span>Vidhasabha Samiti</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <?php foreach ($samitiModules as $samitiModule): 
                                    $samitiUrl = $samitiModule['url'];
                                    if (strpos($samitiUrl, 'http') === 0) {
                                        $parsedUrl = parse_url($samitiUrl);
                                        $path = ltrim($parsedUrl['path'], '/');
                                        $path = preg_replace('#^janumang/#', '', $path);
                                        $samitiUrl = base_url() . $path;
                                    }
                                ?>
                                <li><a href="<?php echo $samitiUrl; ?>"><i class="fa fa-circle-o"></i> <span><?php echo $samitiModule['module']; ?></span></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <?php
                    }
                }
                
                // If Assembly Issue modules exist but MP-publicproblem was not shown, show Assembly Issue at the end
                if (($hasBlockLevel || $hasBhopalLevel || $hasUSSLevel) && !$assemblyIssueShown) {
                    ?>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-file-text"></i> <span>Assembly Issue</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <?php if ($hasBlockLevel): ?>
                            <li><a href="<?php echo $blockLevelUrl; ?>"><i class="fa fa-circle-o"></i> <span>Block-Level</span></a></li>
                            <?php endif; ?>
                            <?php if ($hasBhopalLevel): ?>
                            <li><a href="<?php echo $bhopalLevelUrl; ?>"><i class="fa fa-circle-o"></i> <span>Bhopal-Level</span></a></li>
                            <?php endif; ?>
                            <?php if ($hasUSSLevel): ?>
                            <li><a href="<?php echo $ussLevelUrl; ?>"><i class="fa fa-circle-o"></i> <span>USS-Level</span></a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <?php
                }
                
                // If Samiti modules exist but MP-publicproblem was not shown, show Vidhasabha Samiti at the end
                if (!empty($samitiModules) && !$mpPublicProblemShown) {
                    ?>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-users"></i> <span>Vidhasabha Samiti</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <?php foreach ($samitiModules as $samitiModule): 
                                $samitiUrl = $samitiModule['url'];
                                if (strpos($samitiUrl, 'http') === 0) {
                                    $parsedUrl = parse_url($samitiUrl);
                                    $path = ltrim($parsedUrl['path'], '/');
                                    $path = preg_replace('#^janumang/#', '', $path);
                                    $samitiUrl = base_url() . $path;
                                }
                            ?>
                            <li><a href="<?php echo $samitiUrl; ?>"><i class="fa fa-circle-o"></i> <span><?php echo $samitiModule['module']; ?></span></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <?php
                }
                ?>
                
                <?php
                // Show Activity Log only for admin role (roleId == 1) or if role has permission
                $showActivityLog = false;
                if ($isAdminRole) {
                    $showActivityLog = true;
                } else if (!empty($access_info) && is_array($access_info)) {
                    if (isset($access_info['ActivityLog'])) {
                        $al = is_array($access_info['ActivityLog']) ? $access_info['ActivityLog'] : (array)$access_info['ActivityLog'];
                        if ((isset($al['list']) && $al['list'] == 1) || (isset($al['total_access']) && $al['total_access'] == 1)) {
                            $showActivityLog = true;
                        }
                    }
                }
                if ($showActivityLog): ?>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-history"></i> <span>Activity Management</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?php echo base_url('activitylog'); ?>"><i class="fa fa-list"></i> <span>Activity Logs</span></a></li>
                        <li><a href="<?php echo base_url('activitylog/report'); ?>"><i class="fa fa-chart-line"></i> <span>User Activity Report</span></a></li>
                    </ul>
                </li>
                <?php endif; ?>
                
              
            </ul>
        </section>
        <!-- /.sidebar -->
      </aside>