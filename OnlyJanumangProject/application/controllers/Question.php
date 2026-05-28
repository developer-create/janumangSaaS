<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Roles (RolesController)
 * Roles Class to control role related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 22 Jan 2021
 */
class Question extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Question_model', 'qm');
        $this->isLoggedIn();     
        $this->load->model('Log_model');

    }

    /**
     * This is default routing method
     * It routes to default listing page
     */
    public function index()
    {
        redirect('question/questionlisting');

    }
    
    /**
     * This function is used to load the role list
     */
    function questionlisting()
    {
        // if(!$this->isAdmin())
        // {
        //     $this->loadThis();
        // }
        // else
        // {        
            $searchText = '';
            if(!empty($this->input->post('searchText'))) {
                $searchText = $this->security->xss_clean($this->input->post('searchText'));
            }
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->qm->roleListingCount($searchText);

			$returns = $this->paginationCompress ( "question/questionlisting", $count, 10 );
            
            $data['roleRecords'] = $this->qm->roleListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'CodeInsect : Roles Listing';
            
            $this->loadViews("question/list", $this->global, $data, NULL);
        // }
    }

    /**
     * This function is used to load the add new form
     */
    function add()
    {
        // if(!$this->isAdmin())
        // {
        //     $this->loadThis();
        // }
        // else
        // {
            $this->global['pageTitle'] = 'CodeInsect : Add New Question Type';

            $this->loadViews("question/add", $this->global, NULL, NULL);
        // }
    }

    /**
     * This function is used to check whether email already exist or not
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
     * This function is used to add new user to the system
     */
    function insertquestion()
    {
        // if(!$this->isAdmin())
        // {
        //     $this->loadThis();
        // }
        // else
        // {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('questiontypes','question Type','trim|required');
            $this->form_validation->set_rules('status','Status','trim|required|numeric');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->add();
            }
            else
            {
                $roleText = $this->security->xss_clean($this->input->post('questiontypes'));
                $status = $this->security->xss_clean($this->input->post('status'));
                
                $roleInfo = array('questiontypes'=>$roleText, 'status'=>$status);
                
                $result = $this->qm->questiontypesRole($roleInfo);
                
                if($result > 0)
                {
                    $this->addRoleMatrix($result);
                    $this->session->set_flashdata('success', 'New Role created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Role creation failed');
                }
                
                redirect('question/questionlisting');
            // }
        }
    }

    
    /**
     * This function is used load user edit information
     * @param number $roleId : Optional : This is user id
     */
    function edit($roleId = NULL)
    {
        // if(!$this->isAdmin())
        // {
        //     $this->loadThis();
        // }
        // else
        // {
            if($roleId == null)
            {
                redirect('question/questionlisting');
            }
            
            $data['roleInfo'] = $this->qm->getRoleInfo($roleId);
            $roleAccessMatrix = $this->qm->getRoleAccessMatrix($roleId);
            $data['roleAccessMatrix'] = json_decode($roleAccessMatrix->access);
            $data['moduleList'] = $this->config->item('moduleList');
       
            $this->global['pageTitle'] = 'CodeInsect : Edit Role';
            
            $this->loadViews("roles/edit", $this->global, $data, NULL);
        // }
    }
    
    
    /**
     * This function is used to edit the user information
     */
    function editRole()
    {
        // if(!$this->isAdmin())
        // {
        //     $this->loadThis();
        // }
        // else
        // {
            $this->load->library('form_validation');
            
            $roleId = $this->input->post('roleId');
            
            $this->form_validation->set_rules('role','Role Text','trim|required|max_length[50]');
            $this->form_validation->set_rules('status','Status','trim|required|numeric');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->edit($roleId);
            }
            else
            {
                $roleText = $this->security->xss_clean($this->input->post('role'));
                $status = $this->security->xss_clean($this->input->post('status'));
                
                $roleInfo = array('role'=>$roleText, 'status'=>$status, 'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
                
                $result = $this->qm->editRole($roleInfo, $roleId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Role updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Role updation failed');
                }
                
                redirect('question/questionlisting');
            }
        // }
    }

    private function addRoleMatrix($roleId)
    {
        $this->load->config('modules');

        $modules = $this->config->item('moduleList');

        $accessMatrix = array('roleId'=>$roleId, 'access'=>json_encode($modules), 'createdBy'=> $this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'));

        $this->qm->insertAccessMatrix($accessMatrix);
    }

    public function storeAccessMatrix()
    {
        $roleId = $this->input->post('roleIdForMatrix');
        $postParams = $this->input->post('access');

        $this->load->config('modules');

        $modules = $this->config->item('moduleList');
        $modules2 = [];

        foreach($modules as $module) {
            $singleModule = ['module'=>$module['module']];
            foreach($module as $keyMod=>$valMod) {
                if(isset($postParams[$module['module']][$keyMod])) {
                    $singleModule[$keyMod] = $postParams[$module['module']][$keyMod] == 'on' ? 1 : $postParams[$module['module']][$keyMod];
                } else {
                    $singleModule[$keyMod] = 0;
                }
            }
            $modules2[] = $singleModule;
        }

        $accessMatrix = ['access'=>json_encode($modules2), 'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s')];

        $updated = $this->qm->updateAccessMatrix($roleId, $accessMatrix);

        if($updated){
            $this->session->set_flashdata('success', 'Access matrix updated successfully');
        } else {
            $this->session->set_flashdata('error', 'Access matrix updation failed');
        }

        redirect('roles/edit/'.$roleId);
    }
       function questiondelete($id)
    {
      
      $result = $this->qm->questiondelete($id);
                
                if($result == true)
                {

                    $this->session->set_flashdata('success', ' Delete successfully');
                     redirect('question/questionlisting');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Delete  failed');
                     redirect('question/questionlisting');
                }
    }
    function allquestion()
    {
    //  if(!$this->isAdmin())
    //     {
    //         $this->loadThis();
    //     }
    //     else
    //     {        
            $searchText = '';
            if(!empty($this->input->post('searchText'))) {
                $searchText = $this->security->xss_clean($this->input->post('searchText'));
            }
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->qm->questionListingCount($searchText);

			$returns = $this->paginationCompress( "question/allquestionlist", $count, 10 );
            
            $data['roleRecords'] = $this->qm->questionListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'CodeInsect : Roles Listing';
            
            $this->loadViews("question/allquestionlist", $this->global, $data, NULL);
        // }
    }
     function alladd()
    {
        // if(!$this->isAdmin())
        // {
        //     $this->loadThis();
        // }
        // else
        // {
            $this->global['pageTitle'] = 'CodeInsect : Add New Question';
             $this->global['type']  = $this->qm->questiontypes();
            $this->loadViews("question/alladd", $this->global, NULL, NULL);
        // }
    }
    function selectquestion()
    {
    	if($this->input->post('qtype')==1)
    	{
    		?>
    		     <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="role">Answer</label>
                                        <textarea name="inputanswer" class="form-control required"></textarea>
                                      
                                    </div>
                                    
                                </div>
    		<?php
    	}
    	if($this->input->post('qtype')==2)
    	{
    		?>
			<div class="col-md-12">                                
                                <div class="form-group">
                                    <label for="role">Option 1</label>
                                    <input type="text" class="form-control required" name="option1" placeholder="option1">
                                     <label for="role">Option 2</label>
                                    <input type="text" class="form-control "name="option2" placeholder="option2">
                                     <label for="role">Option 3</label>
                                    <input type="text" class="form-control "  name="option3" placeholder="option3">
                                   <label for="role">Option 4</label>
                                    <input type="text" class="form-control " name="option4" placeholder="option4">
                                </div>
                                
                            </div>
    		<?php
    	}
    	if($this->input->post('qtype')==3)
    	{
    		?>
			<div class="col-md-12">                                
                                <div class="form-group">
                                    <label for="role">Option 1</label>
                                    <input type="text" class="form-control required" name="option1" placeholder="option1">
                                     <label for="role">Option 2</label>
                                    <input type="text" class="form-control "name="option2" placeholder="option2">
                                     <label for="role">Option 3</label>
                                    <input type="text" class="form-control "  name="option3" placeholder="option3">
                                   <label for="role">Option 4</label>
                                    <input type="text" class="form-control " name="option4" placeholder="option4">
                                </div>
                                
                            </div>
    		<?php
    	}
    	if($this->input->post('qtype')==4)
    	{
    		?>
			<div class="col-md-12">                                
                                <div class="form-group">
                                    <label for="role">Option 1</label>
                                    <input type="text" class="form-control required" name="option1" placeholder="option1">
                                     <label for="role">Option 2</label>
                                    <input type="text" class="form-control "name="option2" placeholder="option2">
                                     <label for="role">Option 3</label>
                                    <input type="text" class="form-control "  name="option3" placeholder="option3">
                                   <label for="role">Option 4</label>
                                    <input type="text" class="form-control " name="option4" placeholder="option4">
                                </div>
                                
                            </div>
    		<?php
    	}
    }
     function allinsertquestion()
    
    {
        // if(!$this->isAdmin())
        // {
        //     $this->loadThis();
        // }
        // else
        // {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('question','Question','trim|required');
			$this->form_validation->set_rules('qtype','Question Type','required');
			// $this->form_validation->set_rules('qtype','Question Type','required');
            
            $this->form_validation->set_rules('status','Status','trim|required|numeric');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->alladd();
            }
            else
            {
            	// print_r($this->input->post());
                $aa['question'] = $this->security->xss_clean($this->input->post('question'));
                $aa['status'] = $this->security->xss_clean($this->input->post('status'));
                $aa['qtype'] = $this->security->xss_clean($this->input->post('qtype'));
                       $aa['createdDtm'] = date('Y-m-d H:i:s');
                if($this->input->post('option1')!='')
                {
                	 $aa['inputreadio'] = $this->security->xss_clean($this->input->post('option1'));
                }
                  if($this->input->post('option2')!='')
                {
                	 $aa['inputreadio2'] = $this->security->xss_clean($this->input->post('option2'));
                }
                   if($this->input->post('option3')!='')
                {
                	 $aa['inputreadio3'] = $this->security->xss_clean($this->input->post('option3'));
                }
                   if($this->input->post('option4')!='')
                {
                	 $aa['inputreadio4'] = $this->security->xss_clean($this->input->post('option4'));
                }
                       if($this->input->post('inputanswer')!='')
                {
                	 $aa['inputanswer'] = $this->security->xss_clean($this->input->post('inputanswer'));
                }
                // print_r( $aa);die;
                
                // $roleInfo = array('questiontypes'=>$roleText, 'status'=>$status);
                
                $result = $this->qm->allquestion($aa);
                
                if($result > 0)
                {
                    $this->addRoleMatrix($result);
                    $this->session->set_flashdata('success', 'New Role created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Role creation failed');
                }
                
                redirect('question/allquestion');
            }
        // }
    }
         function deleteallq($id)
    {
      
      $result = $this->qm->questiondeleteall($id);
                
                if($result == true)
                {

                    $this->session->set_flashdata('success', ' Delete successfully');
                     redirect('question/allquestion');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Delete  failed');
                     redirect('question/allquestion');
                }
    }

}



?>