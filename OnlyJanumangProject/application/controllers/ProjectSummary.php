<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

/**
 * Class : ProjectSummary (ProjectSummaryController)
 * ProjectSummary Class to control project summary related operations.
 * @author : Admin
 * @version : 1.0
 * @since : 10 Aug 2025
 */
class ProjectSummary extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ProjectSummary_model', 'psm');
        $this->load->model('Comman_model', 'cm');
        $this->load->helper('hindi_number'); // Load Hindi number helper
        $this->isLoggedIn();
        $this->module = 'Project-Summary'; // Fixed: Changed to match config (with hyphen)
    }

    /**
     * This is default routing method
     * It routes to default listing page
     */
    public function index()
    {
        redirect('projectSummary/projectListing');
    }
    
    /**
     * This function is used to load the project summary list
     */
    function projectListing()
    {
        if(!$this->hasListAccess())
        {
            $this->loadThis();
        }
        else
        {
            // Get filter values from POST
            $filters = array();
            if($this->input->post()) {
                $filters['department'] = $this->input->post('department');
                $filters['tender_status'] = $this->input->post('tender_status');
                $filters['work_status'] = $this->input->post('work_status');
                $filters['estimate_range'] = $this->input->post('estimate_range');
            }
            
            // Load records with filters
            $data['records'] = $this->psm->getAllProjects($filters);
            
            // Load filter options
            $data['departments'] = $this->psm->getUniqueDepartments();
            $data['tender_statuses'] = $this->psm->getUniqueTenderStatuses();
            $data['work_statuses'] = $this->psm->getUniqueWorkStatuses();
            
            // Pass filters to view for persistence
            $data['filters'] = $filters;
            
            $this->global['pageTitle'] = 'Gandhwani : Project Summary';
            
            $this->loadViews("project_summary/list", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to load the add new form
     */
    function add()
    {
        if(!$this->hasCreateAccess())
        {
            $this->loadThis();
        }
        else
        {
            // Load dropdown data
            $data['districts'] = $this->cm->getDistricts();
            $data['departments'] = $this->cm->getDepartments();
            $data['blocks'] = $this->cm->getBlocksByDistrict();
            
            $this->global['pageTitle'] = 'Gandhwani : Add New Project';

            $this->loadViews("project_summary/add", $this->global, $data, NULL);
        }
    }
    
    /**
     * This function is used to get blocks by district ID (AJAX)
     */
    function getBlocksByDistrict()
    {
        $districtId = $this->input->post('districtId');
        $blocks = $this->cm->getBlocksByDistrict($districtId);
        echo json_encode($blocks);
    }
    
    /**
     * This function is used to add new project to the system
     */
    function addNewProject()
    {
        if(!$this->hasCreateAccess())
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('district_id','District','trim|required|numeric');
            $this->form_validation->set_rules('block_id','Block','trim|required|numeric');
            $this->form_validation->set_rules('department_id','Department','trim|required|numeric');
            $this->form_validation->set_rules('work_name','Work Name','trim|required|max_length[255]');
            $this->form_validation->set_rules('amount_project_cost','Project Cost','trim|required|numeric');
            $this->form_validation->set_rules('proposal_estimate','Proposal Estimate','trim|required|numeric');
            $this->form_validation->set_rules('status','Status','trim|required|max_length[100]');
            $this->form_validation->set_rules('officer_name','Officer Name','trim|required|max_length[150]');
            $this->form_validation->set_rules('contact_no','Contact Number','trim|required|regex_match[/^\d{10}$/]');
            $this->form_validation->set_rules('technical_session','Technical Session','trim|max_length[255]');
            $this->form_validation->set_rules('administrative_session','Administrative Session','trim|max_length[255]');
            $this->form_validation->set_rules('tender_status','Tender Status','trim|max_length[50]');
            $this->form_validation->set_rules('company_name','Company Name','trim|max_length[255]');
            $this->form_validation->set_rules('contractor_name','Contractor Name','trim|max_length[255]');
            $this->form_validation->set_rules('phone_no','Phone No','trim|regex_match[/^\d{10}$/]');
            $this->form_validation->set_rules('usd_remark','USD Remark','trim|max_length[500]');
            $this->form_validation->set_rules('remark','Remark','trim|max_length[500]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->add();
            }
            else
            {
                $district_id = $this->security->xss_clean($this->input->post('district_id'));
                $block_id = $this->security->xss_clean($this->input->post('block_id'));
                $department_id = $this->security->xss_clean($this->input->post('department_id'));
                $work_name = $this->security->xss_clean($this->input->post('work_name'));
                $amount_project_cost = $this->security->xss_clean($this->input->post('amount_project_cost'));
                $proposal_estimate = $this->security->xss_clean($this->input->post('proposal_estimate'));
                $status = $this->security->xss_clean($this->input->post('status'));
                $officer_name = $this->security->xss_clean($this->input->post('officer_name'));
                $contact_no = $this->security->xss_clean($this->input->post('contact_no'));
                $technical_session = $this->security->xss_clean($this->input->post('technical_session'));
                $administrative_session = $this->security->xss_clean($this->input->post('administrative_session'));
                $tender_status = $this->security->xss_clean($this->input->post('tender_status'));
                $company_name = $this->security->xss_clean($this->input->post('company_name'));
                $contractor_name = $this->security->xss_clean($this->input->post('contractor_name'));
                $phone_no = $this->security->xss_clean($this->input->post('phone_no'));
                $usd_remark = $this->security->xss_clean($this->input->post('usd_remark'));
                $remark = $this->security->xss_clean($this->input->post('remark'));
                
                // Generate unique ID
                $unique_id = $this->psm->generateUniqueID();
                
                $projectInfo = array(
                    'unique_id' => $unique_id,
                    'district_id' => $district_id,
                    'block_id' => $block_id,
                    'department_id' => $department_id,
                    'work_name' => $work_name,
                    'amount_project_cost' => $amount_project_cost,
                    'proposal_estimate' => $proposal_estimate,
                    'status' => $status,
                    'officer_name' => $officer_name,
                    'contact_no' => $contact_no,
                    'technical_session' => $technical_session,
                    'administrative_session' => $administrative_session,
                    'tender_status' => $tender_status,
                    'company_name' => $company_name,
                    'contractor_name' => $contractor_name,
                    'phone_no' => $phone_no,
                    'usd_remark' => $usd_remark,
                    'remark' => $remark,
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => $this->vendorId
                );
                
                $result = $this->psm->addNewProject($projectInfo);
                
                if($result > 0) {
                    $this->session->set_flashdata('success', 'New Project created successfully');
                } else {
                    $this->session->set_flashdata('error', 'Project creation failed');
                }
                
                redirect('projectSummary/projectListing');
            }
        }
    }

    /**
     * This function is used load project edit information
     * @param number $projectId : Optional : This is project id
     */
    function edit($projectId = NULL)
    {
        if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        {
            if($projectId == null)
            {
                redirect('projectSummary/projectListing');
            }
            
            $data['projectInfo'] = $this->psm->getProjectInfo($projectId);
            $data['districts'] = $this->cm->getDistricts();
            $data['departments'] = $this->cm->getDepartments();
            $data['blocks'] = $this->cm->getBlocksByDistrict();
            

            $this->global['pageTitle'] = 'Gandhwani : Edit Project';
            
            $this->loadViews("project_summary/edit", $this->global, $data, NULL);
        }
    }

    /**
     * View a single project's details
     * @param number $projectId : Project id
     */
    function view($projectId = NULL)
    {
        if(!$this->hasListAccess())
        {
            $this->loadThis();
        }
        else
        {
            if($projectId == null)
            {
                redirect('projectSummary/projectListing');
            }

            $data['projectInfo'] = $this->psm->getProjectInfo($projectId);

            if(empty($data['projectInfo']))
            {
                $this->session->set_flashdata('error', 'Project not found');
                redirect('projectSummary/projectListing');
            }

            $this->global['pageTitle'] = 'Gandhwani : View Project';
            $this->loadViews("project_summary/view", $this->global, $data, NULL);
        }
    }
    
    /**
     * This function is used to edit the project information
     */
    function editProject()
    {
        if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $projectId = $this->input->post('projectId');
            
            $this->form_validation->set_rules('district_id','District','trim|required|numeric');
            $this->form_validation->set_rules('block_id','Block','trim|required|numeric');
            $this->form_validation->set_rules('department_id','Department','trim|required|numeric');
            $this->form_validation->set_rules('work_name','Work Name','trim|required|max_length[255]');
            $this->form_validation->set_rules('amount_project_cost','Project Cost','trim|required|numeric');
            $this->form_validation->set_rules('proposal_estimate','Proposal Estimate','trim|required|numeric');
            $this->form_validation->set_rules('status','Status','trim|required|max_length[100]');
            $this->form_validation->set_rules('officer_name','Officer Name','trim|required|max_length[150]');
            $this->form_validation->set_rules('contact_no','Contact Number','trim|required|regex_match[/^\d{10}$/]');
            $this->form_validation->set_rules('remark','Remark','trim|max_length[500]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->edit($projectId);
            }
            else
            {
                $district_id = $this->security->xss_clean($this->input->post('district_id'));
                $block_id = $this->security->xss_clean($this->input->post('block_id'));
                $department_id = $this->security->xss_clean($this->input->post('department_id'));
                $work_name = $this->security->xss_clean($this->input->post('work_name'));
                $amount_project_cost = $this->security->xss_clean($this->input->post('amount_project_cost'));
                $proposal_estimate = $this->security->xss_clean($this->input->post('proposal_estimate'));
                $status = $this->security->xss_clean($this->input->post('status'));
                $officer_name = $this->security->xss_clean($this->input->post('officer_name'));
                $contact_no = $this->security->xss_clean($this->input->post('contact_no'));
                $technical_session = $this->security->xss_clean($this->input->post('technical_session'));
                $administrative_session = $this->security->xss_clean($this->input->post('administrative_session'));
                $tender_status = $this->security->xss_clean($this->input->post('tender_status'));
                $company_name = $this->security->xss_clean($this->input->post('company_name'));
                $contractor_name = $this->security->xss_clean($this->input->post('contractor_name'));
                $phone_no = $this->security->xss_clean($this->input->post('phone_no'));
                $usd_remark = $this->security->xss_clean($this->input->post('usd_remark'));
                $remark = $this->security->xss_clean($this->input->post('remark'));
                
                $projectInfo = array(
                    'district_id' => $district_id,
                    'block_id' => $block_id,
                    'department_id' => $department_id,
                    'work_name' => $work_name,
                    'amount_project_cost' => $amount_project_cost,
                    'proposal_estimate' => $proposal_estimate,
                    'status' => $status,
                    'officer_name' => $officer_name,
                    'contact_no' => $contact_no,
                    'technical_session' => $technical_session,
                    'administrative_session' => $administrative_session,
                    'tender_status' => $tender_status,
                    'company_name' => $company_name,
                    'contractor_name' => $contractor_name,
                    'phone_no' => $phone_no,
                    'usd_remark' => $usd_remark,
                    'remark' => $remark,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => $this->vendorId
                );
                
                $result = $this->psm->editProject($projectInfo, $projectId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Project updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Project updation failed');
                }
                
                redirect('projectSummary/projectListing');
            }
        }
    }
    
    /**
     * This function is used to delete project
     * @param number $projectId : This is project id
     */
     
     function delete($projectId = NULL)
{
    // If projectId not passed in URL, try getting from POST
    if ($projectId == NULL) {
        $projectId = $this->input->post('projectId');
    }

    if ($projectId == NULL) {
        if ($this->input->is_ajax_request()) {
            echo json_encode(['status' => false, 'message' => 'Invalid Project ID']);
            return;
        } else {
            redirect('projectSummary/projectListing');
        }
    }

    $result = $this->psm->deleteProject($projectId);

    if ($this->input->is_ajax_request()) {
        // Response for AJAX request
        if ($result > 0) {
            echo json_encode(['status' => true, 'message' => 'Project deleted successfully']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Project deletion failed']);
        }
    } else {
        // Response for normal browser request
        if ($result > 0) {
            $this->session->set_flashdata('success', 'Project deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Project deletion failed');
        }
        redirect('projectSummary/projectListing');
    }
}

    /**
     * Get comments for a project (AJAX)
     * @param number $projectId : Project ID
     */
    function getComments($projectId = NULL)
    {
        if($projectId == NULL) {
            echo json_encode(['status' => false, 'message' => 'Invalid Project ID']);
            return;
        }

        $comments = $this->psm->getProjectComments($projectId);
        echo json_encode(['status' => true, 'comments' => $comments]);
    }

    /**
     * Add a new comment to a project (AJAX)
     */
    function addComment()
    {
        if(!$this->hasCreateAccess())
        {
            echo json_encode(['status' => false, 'message' => 'Access denied']);
            return;
        }

        $projectId = $this->input->post('project_id');
        $comment = $this->input->post('comment');

        if(empty($projectId) || empty($comment)) {
            echo json_encode(['status' => false, 'message' => 'Project ID and comment are required']);
            return;
        }

        $commentData = array(
            'project_id' => $projectId,
            'comment' => $comment,
            'created_by' => $this->vendorId,
            'created_at' => date('Y-m-d H:i:s')
        );

        $result = $this->psm->addComment($commentData);

        if($result > 0) {
            // Log activity
            $this->logActivity('add', 'project_comments', $result, $commentData, null, 'Comment added to project ID: ' . $projectId);
            echo json_encode(['status' => true, 'message' => 'Comment added successfully']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Failed to add comment']);
        }
    }

}

?>
