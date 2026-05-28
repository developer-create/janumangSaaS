<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$url = 'https://umangsinghar.in/janumang/';

$config['moduleList'] = array(

    array(
        'module' => 'Dashboard',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'dashboard'
    ),
    array(
        'module' => 'Users',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'userListing'
    ),
    array(
        'module' => 'Roles',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'roles/roleListing'
    ),
    array(
        'module' => 'UserCount',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'Usercount?date='
    ),
    array(
        'module' => 'MemberList',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'ServayListing'
    ),
    array(
        'module' => 'Vidhansabha-Member',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'ServayListing'
    ),
    array(
        'module' => 'MP-Vidhan-Sabha-Member',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'mp_vidhan_sabha_member'
    ),
    array(
        'module' => 'MP-publicproblem',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'Districtpublicproblem/Disctrictproblem'
    ),
    array(
        'module' => 'Block-Level',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'user/jansunwai'
    ),
    array(
        'module' => 'Bhopal-Level',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'user/jansunwai2'
    ),
    array(
        'module' => 'USS-Level',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'user/jansunwai3'
    ),
    array(
        'module' => 'Project-Summary',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'projectSummary'
    ),
    array(
        'module' => 'Fund-Summary',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'fundSummary'
    ),
    array(
        'module' => 'Fund-Budget-Limits',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'fundBudget'
    ),
    array(
        'module' => 'Visitors',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'Visitors'
    ),
    array(
        'module' => 'Events',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'Events'
    ),
    array(
        'module' => 'Events-Approval',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'Events/approvals'
    ),
    array(
        'module' => 'Voter',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'voter'
    ),
    array(
        'module' => 'Samiti',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'samiti'
    ),
    array(
        'module' => 'Ganesh-Samiti',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'ganeshsamiti'
    ),
     array(
        // 'module' => 'Kabbadi-Samiti',
         'module' => 'Khel-Samiti',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'kabbadisamiti'
    ),
    array(
        'module' => 'Tenkar-Samiti',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'tenkarsamiti'
    ),
    
     array(
        'module' => 'Boring-Samiti',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'boringsamiti'
    ),


    
    array(
        'module' => 'DP-Samiti',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'dpsamiti'
    ),
    array(
        'module' => 'Mandir-Samiti',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'mandirsamiti'
    ),
    array(
        'module' => 'Bhagoria-Samiti',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'bhagoriasamiti'
    ),
    array(
        'module' => 'Nirman-Samiti',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'nirmansamiti'
    ),
    array(
        'module' => 'Booth-Samiti',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'boothsamiti'
    ),
    array(
        'module' => 'Block-Samiti',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'blocksamiti'
    ),

    // ===== Master Data =====
    array(
        'module' => 'District',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'district'
    ),
    array(
        'module' => 'Vidhan-Sabha',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'vidhan_sabha'
    ),
    array(
        'module' => 'Block',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'block'
    ),
    array(
        'module' => 'Booth',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'booth'
    ),
    array(
        'module' => 'Panchayat',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'panchayat'
    ),
    array(
        'module' => 'Village',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'village'
    ),
    array(
        'module' => 'Party',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'user/party'
    ),
    array(
        'module' => 'Department',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'user/department'
    ),
    array(
        'module' => 'Worktype',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'worktype'
    ),
    array(
        'module' => 'SubtypeOfWork',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'subtypeofwork'
    ),
    array(
        'module' => 'Phone-Directory',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'phonedirectory'
    ),
    array(
        'module' => 'In-Out-Register',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'dispatchregister'
    ),
    array(
        'module' => 'ActivityLog',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'activitylog'
    ),
    array(
        'module' => 'Call-Management',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'callmanagement'
    ),
    array(
        'module' => 'US-Code',
        'total_access' => 0, 'list' => 0, 'create_records' => 0, 'edit_records' => 0, 'delete_records' => 0,
        'url' => $url . 'us_code'
    )

);
