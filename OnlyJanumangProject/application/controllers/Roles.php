<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Roles extends BaseController
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('role_model', 'rm');
        $this->isLoggedIn();
        $this->load->model('Log_model');
        $this->module = 'Roles'; // Module name for access control
    }

    /**
     * Default routing method
     */
    public function index()
    {
        $this->hasListAccess() ? redirect('roles/roleListing') : $this->loadThis();
    }

    /**
     * Function to list roles
     */
    function roleListing()
    {
        if(!$this->hasListAccess())
        {
            $this->loadThis();
        }
        else
        {        
            $searchText = '';
            if(!empty($this->input->post('searchText'))) {
                $searchText = $this->security->xss_clean($this->input->post('searchText'));
            }
            $data['searchText'] = $searchText;

            $this->load->library('pagination');
            $count = $this->rm->roleListingCount($searchText);
            $returns = $this->paginationCompress("roles/roleListing/", $count, 10);
            $data['roleRecords'] = $this->rm->roleListing($searchText, $returns["page"], $returns["segment"]);

            $this->global['pageTitle'] = 'CodeInsect : Roles Listing';
            $this->loadViews("roles/list", $this->global, $data, NULL);
        }
    }

    /**
     * Function to load the add form
     */
    function add()
    {
        if(!$this->hasCreateAccess())
        {
            $this->loadThis();
        }
        else
        {
            $this->global['pageTitle'] = 'CodeInsect : Add New Role';
            $this->loadViews("roles/add", $this->global, NULL, NULL);
        }
    }

    /**
     * Function to check if the role exists
     */
    function checkRoleExists()
    {
        $userId = $this->input->post("userId");
        $email = $this->input->post("email");

        if(empty($userId)){
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }

    /**
     * Function to add a new role
     */
    function addNewRole()
    {
        if(!$this->hasCreateAccess())
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('role', 'Role Text', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('status', 'Status', 'trim|required|numeric');

            if($this->form_validation->run() == FALSE)
            {
                $this->add();
            }
            else
            {
                $roleText = $this->security->xss_clean($this->input->post('role'));
                $status = $this->security->xss_clean($this->input->post('status'));
                $roleInfo = array('role' => $roleText, 'status' => $status, 'createdBy' => $this->vendorId, 'createdDtm' => date('Y-m-d H:i:s'));

                $result = $this->rm->addNewRole($roleInfo);

                if($result > 0)
                {
                    $this->addRoleMatrix($result);
                    // Log activity
                    $this->logActivity('add', 'tbl_roles', $result, $roleInfo, null, 'Role created with ID: ' . $result . ' (Role: ' . $roleText . ')');
                    $this->session->set_flashdata('success', 'New Role created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Role creation failed');
                }

                redirect('roles/roleListing');
            }
        }
    }

    /**
     * Function to edit a role
     */
    // function edit($roleId = NULL)
    // {
    //     if(!$this->hasUpdateAccess())
    //     {
    //         $this->loadThis();
    //     }
    //     else
    //     {
    //         if($roleId == null)
    //         {
    //             redirect('roles/roleListing');
    //         }

    //         // Do not allow Admin role permissions to be edited from UI
    //         if((int)$roleId === 1){
    //             $this->session->set_flashdata('success', 'Admin has all permissions by default. Editing is disabled.');
    //             redirect('roles/roleListing');
    //         }

    //         $data['roleInfo'] = $this->rm->getRoleInfo($roleId);
    //         $roleAccessMatrix = $this->rm->getRoleAccessMatrix($roleId);
    //         $data['roleAccessMatrix'] = json_decode($roleAccessMatrix->access);
    //         $data['moduleList'] = $this->config->item('moduleList');

    //         $this->global['pageTitle'] = 'CodeInsect : Edit Role';
    //         $this->loadViews("roles/edit", $this->global, $data, NULL);
    //     }
    // }
function edit($roleId = NULL)
{
    if(!$this->hasUpdateAccess())
    {
        $this->loadThis();
        return;
    }

    if($roleId == null)
    {
        redirect('roles/roleListing');
        return;
    }

    // Admin ko UI se edit na karne dene ka aapka rule
    if((int)$roleId === 1){
        $this->session->set_flashdata('success', 'Admin has all permissions by default. Editing is disabled.');
        redirect('roles/roleListing');
        return;
    }

    // IMPORTANT: modules config ko yahin load karein
    $this->load->config('modules');

    $data['roleInfo'] = $this->rm->getRoleInfo($roleId);

    $roleAccessMatrix = $this->rm->getRoleAccessMatrix($roleId);
    // IMPORTANT: JSON ko associative array me decode karein
    // Check if roleAccessMatrix exists and has access property
    if($roleAccessMatrix && isset($roleAccessMatrix->access) && !empty($roleAccessMatrix->access)) {
        $decoded = json_decode($roleAccessMatrix->access, true);
        $data['roleAccessMatrix'] = is_array($decoded) ? $decoded : array();
    } else {
        // If no access matrix exists, initialize with empty array
        $data['roleAccessMatrix'] = array();
    }

    $data['moduleList'] = $this->config->item('moduleList');

    $this->global['pageTitle'] = 'CodeInsect : Edit Role';
    $this->loadViews("roles/edit", $this->global, $data, NULL);
}

    /**
     * Function to update role information
     */
    function editRole()
    {
        if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            $roleId = $this->input->post('roleId');

            $this->form_validation->set_rules('role', 'Role Text', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('status', 'Status', 'trim|required|numeric');

            if($this->form_validation->run() == FALSE)
            {
                $this->edit($roleId);
            }
            else
            {
                // Prevent editing admin role (roleId == 1)
                if((int)$roleId === 1){
                    $this->session->set_flashdata('error', 'Admin role cannot be edited. Admin has all permissions by default.');
                    redirect('roles/roleListing');
                    return;
                }
                
                $roleText = $this->security->xss_clean($this->input->post('role'));
                $status = $this->security->xss_clean($this->input->post('status'));
                // Get old data before update for logging
                $oldRoleData = $this->rm->getRoleInfo($roleId);
                
                $roleInfo = array('role' => $roleText, 'status' => $status, 'updatedBy' => $this->vendorId, 'updatedDtm' => date('Y-m-d H:i:s'));

                $result = $this->rm->editRole($roleInfo, $roleId);

                if($result == true)
                {
                    // Log activity with old and new data
                    $this->logActivity('edit', 'tbl_roles', $roleId, $roleInfo, (array)$oldRoleData, 'Role updated with ID: ' . $roleId . ' (Role: ' . $roleText . ')');
                    $this->session->set_flashdata('success', 'Role updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Role updation failed');
                }

                redirect('roles/roleListing');
            }
        }
    }

    /**
     * Function to add role matrix
     */
    private function addRoleMatrix($roleId)
    {
        $this->load->config('modules');
        $modules = $this->config->item('moduleList');

        // If Admin role, grant all permissions by default
        if((int)$roleId === 1){
            foreach($modules as &$m){
                if(isset($m['url'])){ /* keep url */ }
                $m['total_access'] = 1;
                $m['list'] = 1;
                $m['create_records'] = 1;
                $m['edit_records'] = 1;
                $m['delete_records'] = 1;
            }
        }

        $accessMatrix = array(
            'roleId' => $roleId, 
            'access' => json_encode($modules, JSON_UNESCAPED_SLASHES), 
            'createdBy' => $this->vendorId, 
            'createdDtm' => date('Y-m-d H:i:s'),
            'isDeleted' => 0
        );
        $this->rm->insertAccessMatrix($accessMatrix);
    }

    /**
     * Function to update role access matrix
     */
    // public function storeAccessMatrix()
    // {
    //     if(!$this->hasUpdateAccess()) {
    //         $this->loadThis();
    //         return;
    //     }

    //     $roleId = $this->input->post('roleIdForMatrix');
    //     $postParams = $this->input->post('access');
    //     $this->load->config('modules');
    //     $modules = $this->config->item('moduleList');
    //     $modules2 = [];

    //     // Admin role: force all permissions to ON and skip editing
    //     if((int)$roleId === 1){
    //         foreach($modules as &$m){
    //             $m['total_access'] = 1;
    //             $m['list'] = 1;
    //             $m['create_records'] = 1;
    //             $m['edit_records'] = 1;
    //             $m['delete_records'] = 1;
    //         }
    //         $accessMatrix = ['access' => json_encode($modules), 'updatedBy' => $this->vendorId, 'updatedDtm' => date('Y-m-d H:i:s')];
    //         $this->rm->updateAccessMatrix($roleId, $accessMatrix);
    //         $this->session->set_flashdata('success', 'Admin retains full permissions.');
    //         redirect('roles/roleListing');
    //         return;
    //     }

    //     foreach($modules as $module) {
    //         $singleModule = ['module' => $module['module']];
    //         foreach($module as $keyMod => $valMod) {
    //             if (isset($postParams[$module['module']][$keyMod])) {
    //                 $singleModule[$keyMod] = $postParams[$module['module']][$keyMod] == 'on' ? 1 : $postParams[$module['module']][$keyMod];
    //             } else {
    //                 $singleModule[$keyMod] = ($keyMod === 'url') ? $valMod : 0;
    //             }
    //         }
    //         $modules2[] = $singleModule;
    //     }

    //     $accessMatrix = ['access' => json_encode($modules2), 'updatedBy' => $this->vendorId, 'updatedDtm' => date('Y-m-d H:i:s')];
    //     $updated = $this->rm->updateAccessMatrix($roleId, $accessMatrix);

    //     if($updated){
    //         $this->session->set_flashdata('success', 'Access matrix updated successfully');
    //     } else {
    //         $this->session->set_flashdata('error', 'Access matrix updation failed');
    //     }

    //     redirect('roles/edit/'.$roleId);
    // }
    public function storeAccessMatrix()
{
    if(!$this->hasUpdateAccess()) {
        $this->loadThis();
        return;
    }

    $roleId = (int)$this->input->post('roleIdForMatrix');
    
    // Prevent editing admin role (roleId == 1)
    if($roleId === 1){
        $this->session->set_flashdata('error', 'Admin role cannot be edited. Admin has all permissions by default.');
        redirect('roles/roleListing');
        return;
    }
    
    $postParams = $this->input->post('access');

    // Normal roles - process access matrix
    $this->load->config('modules');
    $modules = $this->config->item('moduleList');
    $modules2 = [];

    foreach ($modules as $module) {
        if (!isset($module['module'])) continue; // safety

        $name   = $module['module'];
        $posted = isset($postParams[$name]) ? $postParams[$name] : [];

        $row = [
            'module'         => $name,
            // url ko preserve karein agar config me di hui ho
            'url'            => isset($module['url']) ? $module['url'] : (isset($posted['url']) ? $posted['url'] : null),
            'total_access'   => (isset($posted['total_access'])   && $posted['total_access']   === 'on') ? 1 : 0,
            'list'           => (isset($posted['list'])           && $posted['list']           === 'on') ? 1 : 0,
            'create_records' => (isset($posted['create_records']) && $posted['create_records'] === 'on') ? 1 : 0,
            'edit_records'   => (isset($posted['edit_records'])   && $posted['edit_records']   === 'on') ? 1 : 0,
            'delete_records' => (isset($posted['delete_records']) && $posted['delete_records'] === 'on') ? 1 : 0,
        ];

        $modules2[] = $row;
    }

    // Ensure JSON encoding is consistent (use JSON_UNESCAPED_SLASHES for URL compatibility)
    $accessMatrix = [
        'access'     => json_encode($modules2, JSON_UNESCAPED_SLASHES),
        'updatedBy'  => $this->vendorId,
        'updatedDtm' => date('Y-m-d H:i:s')
    ];

    // Get old access matrix before update for logging
    $oldAccessMatrix = $this->rm->getRoleAccessMatrix($roleId);
    
    $updated = $this->rm->updateAccessMatrix($roleId, $accessMatrix);

    if($updated){
        // Log activity for access matrix update
        $this->logActivity('edit', 'tbl_access_matrix', $roleId, $accessMatrix, (array)$oldAccessMatrix, 'Access matrix updated for Role ID: ' . $roleId);
        $this->session->set_flashdata('success', 'Access matrix updated successfully');
    } else {
        // Note: Model me affected_rows()==0 bhi aa sakta hai agar JSON same ho
        $this->session->set_flashdata('error', 'Access matrix updation failed or no changes detected');
    }

    redirect('roles/edit/'.$roleId);
}

 
}
   
?>