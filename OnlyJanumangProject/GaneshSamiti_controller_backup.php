<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : GaneshSamiti (GaneshSamitiController)
 * GaneshSamiti Class to control ganesh samiti related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class GaneshSamiti extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('GaneshSamiti_model');        
        $this->isLoggedIn();
        $this->module = "GaneshSamiti";
    }
    
    /**
     * This function used to load the first screen of the ganesh samiti
     */
    public function index()
    {
        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            $this->global['pageTitle'] = 'CIAS : Ganesh Samiti Listing';
            
            $data['access_info'] = $this->session->userdata ( 'access_info' );
            
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->GaneshSamiti_model->ganeshSamitiListingCount($searchText);

            $returns = $this->paginationCompress ( "ganeshsamiti/", $count, 10 );
            
            $data['ganeshSamitiRecords'] = $this->GaneshSamiti_model->ganeshSamitiListing($returns["page"], $returns["segment"], $searchText);
            
            $this->global['pageTitle'] = 'CIAS : Ganesh Samiti Listing';
            
            $this->loadViews("ganeshsamiti/index", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to load the add new form
     */
    function addNew()
    {
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $data['access_info'] = $this->session->userdata ( 'access_info' );
            
            $this->global['pageTitle'] = 'CIAS : Add New Ganesh Samiti';

            $this->loadViews("ganeshsamiti/add", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to check whether serial number already exist or not
     */
    function checkSerialNumberExists()
    {
        $serialNumber = $this->input->post("serialNumber");
        $ganeshSamitiId = $this->input->post("ganeshSamitiId");

        if(empty($ganeshSamitiId)){
            $ganeshSamitiId = 0;
        }

        $result = $this->GaneshSamiti_model->checkSerialNumberExists($serialNumber, $ganeshSamitiId);

        if($result == true){
            echo("true"); 
        }
        else echo("false");
    }
    
    /**
     * This function is used to add new ganesh samiti to the system
     */
    function addNewGaneshSamiti()
    {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('serial_number','Serial Number','trim|required|max_length[50]');
        $this->form_validation->set_rules('year','Year','trim|required|max_length[4]');
        $this->form_validation->set_rules('ganesh_samiti_name','Ganesh Samiti Name','trim|required|max_length[100]');
        $this->form_validation->set_rules('establishment','Establishment','trim|max_length[100]');
        $this->form_validation->set_rules('medium_circle_writer','Medium Circle Writer','trim|max_length[100]');
        $this->form_validation->set_rules('medium_circle_name','Medium Circle Name','trim|max_length[100]');
        $this->form_validation->set_rules('group_number','Group Number','trim|max_length[50]');
        $this->form_validation->set_rules('group_name','Group Name','trim|max_length[100]');
        $this->form_validation->set_rules('coordinator','Coordinator','trim|max_length[100]');
        $this->form_validation->set_rules('quantity','Quantity','trim|max_length[50]');
        $this->form_validation->set_rules('phone','Phone','trim|max_length[20]');
        $this->form_validation->set_rules('helper_name','Helper Name','trim|max_length[100]');
        $this->form_validation->set_rules('rep_name','Rep Name','trim|max_length[100]');
        $this->form_validation->set_rules('up_sub','Up/Sub','trim|max_length[50]');
        $this->form_validation->set_rules('pat','Pat','trim|max_length[50]');
        $this->form_validation->set_rules('mobile_number','Mobile Number','trim|max_length[20]');
        $this->form_validation->set_rules('remark','Remark','trim');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->addNew();
        }
        else
        {
            $serial_number_input = $this->input->post('serial_number');
            $serial_number = $serial_number_input ? $this->security->xss_clean($serial_number_input) : '';
            
            $year_input = $this->input->post('year');
            $year = $year_input ? $this->security->xss_clean($year_input) : '';
            
            $ganesh_samiti_name_input = $this->input->post('ganesh_samiti_name');
            $ganesh_samiti_name = $ganesh_samiti_name_input ? $this->security->xss_clean($ganesh_samiti_name_input) : '';
            
            $establishment_input = $this->input->post('establishment');
            $establishment = $establishment_input ? $this->security->xss_clean($establishment_input) : '';
            
            $medium_circle_writer_input = $this->input->post('medium_circle_writer');
            $medium_circle_writer = $medium_circle_writer_input ? $this->security->xss_clean($medium_circle_writer_input) : '';
            
            $medium_circle_name_input = $this->input->post('medium_circle_name');
            $medium_circle_name = $medium_circle_name_input ? $this->security->xss_clean($medium_circle_name_input) : '';
            
            $group_number_input = $this->input->post('group_number');
            $group_number = $group_number_input ? $this->security->xss_clean($group_number_input) : '';
            
            $group_name_input = $this->input->post('group_name');
            $group_name = $group_name_input ? $this->security->xss_clean($group_name_input) : '';
            
            $coordinator_input = $this->input->post('coordinator');
            $coordinator = $coordinator_input ? $this->security->xss_clean($coordinator_input) : '';
            
            $quantity_input = $this->input->post('quantity');
            $quantity = $quantity_input ? $this->security->xss_clean($quantity_input) : '';
            
            $phone_input = $this->input->post('phone');
            $phone = $phone_input ? $this->security->xss_clean($phone_input) : '';
            
            $helper_name_input = $this->input->post('helper_name');
            $helper_name = $helper_name_input ? $this->security->xss_clean($helper_name_input) : '';
            
            $rep_name_input = $this->input->post('rep_name');
            $rep_name = $rep_name_input ? $this->security->xss_clean($rep_name_input) : '';
            
            $up_sub_input = $this->input->post('up_sub');
            $up_sub = $up_sub_input ? $this->security->xss_clean($up_sub_input) : '';
            
            $pat_input = $this->input->post('pat');
            $pat = $pat_input ? $this->security->xss_clean($pat_input) : '';
            
            $mobile_number_input = $this->input->post('mobile_number');
            $mobile_number = $mobile_number_input ? $this->security->xss_clean($mobile_number_input) : '';
            
            $remark_input = $this->input->post('remark');
            $remark = $remark_input ? $this->security->xss_clean($remark_input) : '';
            
            $ganeshSamitiInfo = array(
                'serial_number' => $serial_number,
                'year' => $year,
                'ganesh_samiti_name' => $ganesh_samiti_name,
                'establishment' => $establishment,
                'medium_circle_writer' => $medium_circle_writer,
                'medium_circle_name' => $medium_circle_name,
                'group_number' => $group_number,
                'group_name' => $group_name,
                'coordinator' => $coordinator,
                'quantity' => $quantity,
                'phone' => $phone,
                'helper_name' => $helper_name,
                'rep_name' => $rep_name,
                'up_sub' => $up_sub,
                'pat' => $pat,
                'mobile_number' => $mobile_number,
                'remark' => $remark,
                'status' => 'Active',
                'created_by' => $this->vendorId,
                'created_on' => date('Y-m-d H:i:s')
            );
            
            $result = $this->GaneshSamiti_model->addNewGaneshSamiti($ganeshSamitiInfo);
            
            if($result > 0)
            {
                $this->session->set_flashdata('success', 'New Ganesh Samiti created successfully');
            }
            else
            {
                $this->session->set_flashdata('error', 'Ganesh Samiti creation failed');
            }
            
            redirect('ganeshsamiti');
        }
    }

    /**
     * This function is used load ganesh samiti edit information
     * @param number $ganeshSamitiId : Optional parameter of the ganesh samiti
     */
    function edit($ganeshSamitiId = NULL)
    {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            if($ganeshSamitiId == null)
            {
                redirect('ganeshsamiti');
            }
            
            $data['access_info'] = $this->session->userdata ( 'access_info' );
            $data['ganeshSamitiInfo'] = $this->GaneshSamiti_model->getGaneshSamitiInfo($ganeshSamitiId);
            
            $this->global['pageTitle'] = 'CIAS : Edit Ganesh Samiti';
            
            $this->loadViews("ganeshsamiti/edit", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the ganesh samiti information
     */
    function editGaneshSamiti()
    {
        $this->load->library('form_validation');
        
        $ganeshSamitiId = $this->input->post('ganeshSamitiId');
        
        $this->form_validation->set_rules('serial_number','Serial Number','trim|required|max_length[50]');
        $this->form_validation->set_rules('year','Year','trim|required|max_length[4]');
        $this->form_validation->set_rules('ganesh_samiti_name','Ganesh Samiti Name','trim|required|max_length[100]');
        $this->form_validation->set_rules('establishment','Establishment','trim|max_length[100]');
        $this->form_validation->set_rules('medium_circle_writer','Medium Circle Writer','trim|max_length[100]');
        $this->form_validation->set_rules('medium_circle_name','Medium Circle Name','trim|max_length[100]');
        $this->form_validation->set_rules('group_number','Group Number','trim|max_length[50]');
        $this->form_validation->set_rules('group_name','Group Name','trim|max_length[100]');
        $this->form_validation->set_rules('coordinator','Coordinator','trim|max_length[100]');
        $this->form_validation->set_rules('quantity','Quantity','trim|max_length[50]');
        $this->form_validation->set_rules('phone','Phone','trim|max_length[20]');
        $this->form_validation->set_rules('helper_name','Helper Name','trim|max_length[100]');
        $this->form_validation->set_rules('rep_name','Rep Name','trim|max_length[100]');
        $this->form_validation->set_rules('up_sub','Up/Sub','trim|max_length[50]');
        $this->form_validation->set_rules('pat','Pat','trim|max_length[50]');
        $this->form_validation->set_rules('mobile_number','Mobile Number','trim|max_length[20]');
        $this->form_validation->set_rules('remark','Remark','trim');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->edit($ganeshSamitiId);
        }
        else
        {
            $serial_number_input = $this->input->post('serial_number');
            $serial_number = $serial_number_input ? $this->security->xss_clean($serial_number_input) : '';
            
            $year_input = $this->input->post('year');
            $year = $year_input ? $this->security->xss_clean($year_input) : '';
            
            $ganesh_samiti_name_input = $this->input->post('ganesh_samiti_name');
            $ganesh_samiti_name = $ganesh_samiti_name_input ? $this->security->xss_clean($ganesh_samiti_name_input) : '';
            
            $establishment_input = $this->input->post('establishment');
            $establishment = $establishment_input ? $this->security->xss_clean($establishment_input) : '';
            
            $medium_circle_writer_input = $this->input->post('medium_circle_writer');
            $medium_circle_writer = $medium_circle_writer_input ? $this->security->xss_clean($medium_circle_writer_input) : '';
            
            $medium_circle_name_input = $this->input->post('medium_circle_name');
            $medium_circle_name = $medium_circle_name_input ? $this->security->xss_clean($medium_circle_name_input) : '';
            
            $group_number_input = $this->input->post('group_number');
            $group_number = $group_number_input ? $this->security->xss_clean($group_number_input) : '';
            
            $group_name_input = $this->input->post('group_name');
            $group_name = $group_name_input ? $this->security->xss_clean($group_name_input) : '';
            
            $coordinator_input = $this->input->post('coordinator');
            $coordinator = $coordinator_input ? $this->security->xss_clean($coordinator_input) : '';
            
            $quantity_input = $this->input->post('quantity');
            $quantity = $quantity_input ? $this->security->xss_clean($quantity_input) : '';
            
            $phone_input = $this->input->post('phone');
            $phone = $phone_input ? $this->security->xss_clean($phone_input) : '';
            
            $helper_name_input = $this->input->post('helper_name');
            $helper_name = $helper_name_input ? $this->security->xss_clean($helper_name_input) : '';
            
            $rep_name_input = $this->input->post('rep_name');  
            $rep_name = $rep_name_input ? $this->security->xss_clean($rep_name_input) : '';
            
            $up_sub_input = $this->input->post('up_sub');
            $up_sub = $up_sub_input ? $this->security->xss_clean($up_sub_input) : '';
            
            $pat_input = $this->input->post('pat');
            $pat = $pat_input ? $this->security->xss_clean($pat_input) : '';
            
            $mobile_number_input = $this->input->post('mobile_number');
            $mobile_number = $mobile_number_input ? $this->security->xss_clean($mobile_number_input) : '';
            
            $remark_input = $this->input->post('remark');
            $remark = $remark_input ? $this->security->xss_clean($remark_input) : '';
            
            $ganeshSamitiInfo = array(
                'serial_number' => $serial_number,
                'year' => $year,
                'ganesh_samiti_name' => $ganesh_samiti_name,
                'establishment' => $establishment,
                'medium_circle_writer' => $medium_circle_writer,
                'medium_circle_name' => $medium_circle_name,
                'group_number' => $group_number,
                'group_name' => $group_name,
                'coordinator' => $coordinator,
                'quantity' => $quantity,
                'phone' => $phone,
                'helper_name' => $helper_name,
                'rep_name' => $rep_name,
                'up_sub' => $up_sub,
                'pat' => $pat,
                'mobile_number' => $mobile_number,
                'remark' => $remark,
                'updated_by' => $this->vendorId,
                'updated_on' => date('Y-m-d H:i:s')
            );
            
            $result = $this->GaneshSamiti_model->editGaneshSamiti($ganeshSamitiInfo, $ganeshSamitiId);
            
            if($result == true)
            {
                $this->session->set_flashdata('success', 'Ganesh Samiti updated successfully');
            }
            else
            {
                $this->session->set_flashdata('error', 'Ganesh Samiti updation failed');
            }
            
            redirect('ganeshsamiti');
        }
    }


    /**
     * This function is used to delete the ganesh samiti using ganeshSamitiId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteGaneshSamiti()
    {
        if (!$this->hasDeleteAccess()) {
            echo(json_encode(array('status'=>FALSE, 'message'=>'Access Denied')));
        } else {
            $ganeshSamitiId = $this->input->post('ganeshSamitiId');
            $ganeshSamitiInfo = array('status'=>'Deleted', 'updated_by'=>$this->vendorId, 'updated_on'=>date('Y-m-d H:i:s'));
            
            $result = $this->GaneshSamiti_model->deleteGaneshSamiti($ganeshSamitiId, $ganeshSamitiInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }

    /**
     * This function is used to view the ganesh samiti information
     * @param number $ganeshSamitiId : This is ganesh samiti id
     */  
    function view($ganeshSamitiId = NULL)
    {
        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            $data['access_info'] = $this->session->userdata ( 'access_info' );
            $data['ganeshSamitiInfo'] = $this->GaneshSamiti_model->getGaneshSamitiInfo($ganeshSamitiId);
            
            $this->global['pageTitle'] = 'CIAS : Ganesh Samiti Details';
            
            $this->loadViews("ganeshsamiti/view", $this->global, $data, NULL);
        }
    }

    /**
     * Page not found : error 404
     */
    function pageNotFound()
    {
        $this->global['pageTitle'] = 'CIAS : 404 - Page Not Found';
        
        $this->loadViews("404", $this->global, NULL, NULL);
    }
}

?>