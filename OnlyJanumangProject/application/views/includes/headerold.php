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
        <a href="<?php echo base_url(); ?>" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>J </b>U</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Jan Umang</b></span>
        </a>
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
                  <li class="header"> Last Login : <i class="fa fa-clock-o"></i> <?= empty($last_login) ? "First Time Login" : $last_login; ?></li>
                </ul>
              </li>
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="user-image" alt="User Image"/>
                  <span class="hidden-xs"><?php echo $name; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    
                    <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="img-circle" alt="User Image" />
                    <p>
                      <?php echo $name; ?>
                      <small><?php echo $role_text; ?></small>
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
            <?php $role=  $this->session->userdata('role');
            
            if($this->session->userdata('blockId')==0){ ?>
            <li>
              <a href="<?php echo base_url(); ?>dashboard">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span></i>
              </a>
            </li>
            <?php } else{ ?>
                 <li>
              <a href="<?php echo base_url(); ?>blockdashboard">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span></i>
              </a>
            </li>
           <?php } ?>
            <!--<li class="treeview">-->
            <!--  <a href="#">-->
            <!--    <i class="fa fa-share"></i> <span>Multilevel</span>-->
            <!--    <span class="pull-right-container">-->
            <!--      <i class="fa fa-angle-left pull-right"></i>-->
            <!--    </span>-->
            <!--  </a>-->
            <!--  <ul class="treeview-menu">-->
            <!--    <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>-->
            <!--    <li class="treeview">-->
            <!--      <a href="#"><i class="fa fa-circle-o"></i> Level One-->
            <!--        <span class="pull-right-container">-->
            <!--          <i class="fa fa-angle-left pull-right"></i>-->
            <!--        </span>-->
            <!--      </a>-->
            <!--      <ul class="treeview-menu">-->
            <!--        <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>-->
            <!--        <li class="treeview">-->
            <!--          <a href="#"><i class="fa fa-circle-o"></i> Level Two-->
            <!--            <span class="pull-right-container">-->
            <!--              <i class="fa fa-angle-left pull-right"></i>-->
            <!--            </span>-->
            <!--          </a>-->
            <!--          <ul class="treeview-menu">-->
            <!--            <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>-->
            <!--            <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>-->
            <!--          </ul>-->
            <!--        </li>-->
            <!--      </ul>-->
            <!--    </li>-->
            <!--    <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>-->
            <!--  </ul>-->
            <!--</li>-->
            <?php
            if($is_admin == 1 || $role == 8)
            {
            ?>
            <!--<li class="treeview">-->
            <!--  <a href="#">-->
            <!--    <i class="fa fa-share"></i> <span>Question</span>-->
            <!--    <span class="pull-right-container">-->
            <!--      <i class="fa fa-angle-left pull-right"></i>-->
            <!--    </span>-->
            <!--  </a>-->
            <!--  <ul class="treeview-menu">-->
            <!--    <li><a href="<?php echo base_url(); ?>question/questionlisting"><i class="fa fa-circle-o"></i> Question Type</a></li>-->
            <!--     <li><a href="<?php echo base_url(); ?>question/alladd"><i class="fa fa-circle-o"></i> Question List</a></li>-->
                
            <!--  </ul>-->
            <!--</li>-->
             <?php if($is_admin == 1){ ?>
            <li>
              <a href="<?php echo base_url(); ?>ServayListing">
                <i class="fa fa-users"></i>
                <span>Member List</span>
              </a>
            </li>
            <?php } ?>
            <li>
              <a href="<?php echo base_url(); ?>userListing">
                <i class="fa fa-users"></i>
                <span>Users</span>
              </a>
            </li>
            <li>
              <a href="<?php echo base_url(); ?>Usercount?date=">
                <i class="fa fa-users"></i>
                <span>User Count</span>
              </a>
            </li>
          
            <!--<li>-->
            <!--  <a href="<?php echo base_url(); ?>UserServayListing">-->
            <!--    <i class="fa fa-users"></i>-->
            <!--    <span>User Servey List</span>-->
            <!--  </a>-->
            <!--</li>-->
            <!--<li>-->
            <!--  <a href="<?php echo base_url(); ?>IpuserListing">-->
            <!--    <i class="fa fa-users"></i>-->
            <!--    <span>Ip User List</span>-->
            <!--  </a>-->
            <!--</li>-->
             <li> 
              <a href="<?php echo base_url(); ?>roles/roleListing">
                <i class="fa fa-user-circle-o " aria-hidden="true"></i>
                <span>Roles</span>
              </a>
            </li>
            
            
            <li> 
              <a href="<?php echo base_url(); ?>samiti">
                <i class="fa fa-user-circle-o " aria-hidden="true"></i>
                <span>Samiti</span>
              </a>
            </li>
            
               <li> 
              <a href="<?php echo base_url(); ?>block">
                <i class="fa fa-user-circle-o " aria-hidden="true"></i>
                <span>Block</span>
              </a>
            </li>
            
            
              <li> 
              <a href="<?php echo base_url(); ?>booth">
                <i class="fa fa-user-circle-o " aria-hidden="true"></i>
                <span>Booth</span>
              </a>
            </li>
            
            
              <li> 
              <a href="<?php echo base_url(); ?>panchayat">
                <i class="fa fa-user-circle-o " aria-hidden="true"></i>
                <span>Panchayat</span>
              </a>
            </li>
            
            
            
              <li> 
              <a href="<?php echo base_url(); ?>village">
                <i class="fa fa-user-circle-o " aria-hidden="true"></i>
                <span>Village</span>
              </a>
            </li>
            
            
              <li> 
              <a href="<?php echo base_url(); ?>user/jansunwai">
                <i class="fa fa-user-circle-o " aria-hidden="true"></i>
                <span>Public Problems 1</span>
              </a>
            </li>

 <li> 
              <a href="<?php echo base_url(); ?>user/jansunwai2">
                <i class="fa fa-user-circle-o " aria-hidden="true"></i>
                <span>Public Problems 2</span>
              </a>
            </li>
<?php if($is_admin == 1){ ?>
 <li> 
              <a href="<?php echo base_url(); ?>user/jansunwai3">
                <i class="fa fa-user-circle-o " aria-hidden="true"></i>
                <span>Public Problems 3</span>
              </a>
            </li>
            <?php  } ?>

            <li> 
              <a href="<?php echo base_url(); ?>user/party">
                <i class="fa fa-user-circle-o " aria-hidden="true"></i>
                <span>Party</span>
              </a>
            </li>
            
             <li> 
              <a href="<?php echo base_url(); ?>user/department">
                <i class="fa fa-user-circle-o " aria-hidden="true"></i>
                <span>Department</span>
              </a>
            </li>


            <?php
            }
            ?>
            
            
             <?php  
               
               if($role == 4 || $role == 5 || $role ==6 || $role ==7 || $role ==8 ) { ?> 
            
             <li>
              <a href="<?php echo base_url(); ?>user/jansunwai">
                <i class="ion ion-person-add"></i>
                <span>Jan Sunwai</span>
              </a>
            </li> 
            
            <?php  } ?> 
             
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>