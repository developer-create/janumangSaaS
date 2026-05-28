<?php if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
}
require APPPATH . "/libraries/BaseController.php";
#[AllowDynamicProperties]
class Districtpublicproblem extends BaseController {
    public function __construct() {
        parent::__construct();
        $this->load->model("Disctrictproblem");
        $this->load->model("Comman_model");
        $this->load->model("Log_model");
        $this->isLoggedIn();
        $this->load->library("form_validation");
        $this->module = "MP-publicproblem"; // Fixed: Changed from "Users" to match config
        date_default_timezone_set('Asia/Kolkata');

    }
    
    
    
        function Disctrictproblem() {
        $this->module = "MP-publicproblem"; // Fixed: Changed to match config
        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            $department = $this->input->post("department");
            $status = $this->input->post("work_status");
            $block = $this->input->post("block");
            $approved_fund = $this->input->post("approved_fund");
            $year = $this->input->post("year");
            $month = $this->input->post("month");
            
            // For admin/subadmin/manager, don't apply block filter to show all entries
            $isAdmin = $this->session->userdata('isAdmin');
            $roleId = $this->session->userdata('role');
            
            // If user is admin, subadmin, or manager, ignore block filter to show all entries
            if ($isAdmin == 1 || $roleId <= 3) {
                $block = null; // Remove block restriction for admin roles
            }
            
            $data["userRecords"] = $this->Disctrictproblem->districtpublicproblemlist($block, $year, $month, $department, $status, $approved_fund);
            $data["filters"] = array(
                "department" => $department,
                "status" => $status,
                "block" => $block,
                "approved_fund" => $approved_fund,
                "year" => $year,
                "month" => $month
            );
           $this->global["pageTitle"] = "Disctrictproblem";
            $this->loadViews("districtproblem/Disctrictproblemlist", $this->global, $data, null);
        }
    }
    
     public function addNewDisctrictproblem() {
        $this->module = "MP-publicproblem"; // Fixed: Changed to match config
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            // Set form validation rules
            // $this->form_validation->set_rules("sector_name", "Sector Name", "required");
            // $this->form_validation->set_rules("micro_sector_no", "Micro Sector No.", "required");
            // $this->form_validation->set_rules("micro_sector_name", "Micro Sector Name", "required");
            $this->form_validation->set_rules("year", "Year", "required|numeric");
            $this->form_validation->set_rules("month", "Month", "required");
            $this->form_validation->set_rules("date", "Date", "required");
            $this->form_validation->set_rules("district", "District", "required");
            $this->form_validation->set_rules("assembly", "Assembly", "required");
            $this->form_validation->set_rules("block", "Block", "required");
            $this->form_validation->set_rules("recommended_letter_no", "Recommended Letter No.", "required");
            $this->form_validation->set_rules("booth_no", "Booth No.", "required");
            $this->form_validation->set_rules("booth_name", "Booth Name", "required");
            $this->form_validation->set_rules("panchayat_name", "Panchayat Name", "required");
            $this->form_validation->set_rules("village", "Village", "required");
            $this->form_validation->set_rules("majra_faliya", "Majra-Faliya", "required");
            $this->form_validation->set_rules("work_problem", "Work/Problem", "required");
            $this->form_validation->set_rules("office", "Office", "required");
            $this->form_validation->set_rules("approximate_cost", "Approximate Cost", "required|decimal");
            $this->form_validation->set_rules("department", "Department", "required");
            $this->form_validation->set_rules("priority", "Priority", "required");
            // $this->form_validation->set_rules("ts_no_date", "TS No/Date", "required");
            // $this->form_validation->set_rules("as_no_date", "AS No/Date", "required");
            $this->form_validation->set_rules("type_of_work", "Type of Work", "required");
            $this->form_validation->set_rules("middle_men", "Middle Men", "required");
            $this->form_validation->set_rules("cont_no", "Cont No.", "required");
            $this->form_validation->set_rules("beneficial", "Beneficial", "required");
            // $this->form_validation->set_rules("po", "PO", "required");
            $this->form_validation->set_rules("work_status", "Work Status", "required");
            $this->form_validation->set_rules("remark_goshana", "Remark/Goshana", "required");
            $this->global["pageTitle"] = "CodeInsect : Add New Disctrictproblem";
            $data["blocks"] = $this->Comman_model->get_all_data("block");
            $data["departments"] = $this->Comman_model->get_all_data("department");
            $data["districts"] = $this->Comman_model->get_all_data("district");
            $data["vidhan_sabhas"] = $this->Comman_model->get_all_data("vidhan_sabha");
            if ($this->form_validation->run() == false) {
                $this->loadViews("districtproblem/addDisctrictproblem", $this->global, $data, null);
            } else {
                // Gather post data
                
                $config['upload_path'] = './uploads/'; // Specify the upload directory
                $config['allowed_types'] = '*'; // Specify allowed file types
                $config['max_size'] = '*'; // Set maximum file size in KB (2MB)
                $this->load->library('upload', $config);

                // Convert year to financial year format
                $year = $this->input->post("year");
                $month = $this->input->post("month");
                $financial_year = $year . '-' . substr($year + 1, -2);

                $this->load->helper("fund_budget");
                $this->load->model("Fund_budget_model");
                $resolved_fund = resolve_approved_fund_post($this->input->post("approved_fund"), $this->input->post("approved_fund_other"));
                $norm_fund = normalize_approved_fund_name($resolved_fund);
                if ($norm_fund !== null) {
                    $fy = canonicalize_financial_year_for_budget($financial_year);
                    $chk = $this->Fund_budget_model->check_budget($norm_fund, $fy, (float) $this->input->post("approximate_cost"), null, null);
                    if (!$chk["ok"]) {
                        $this->session->set_flashdata("error", $chk["message"]);
                        redirect("Districtpublicproblem/addNewDisctrictproblem");
                        return;
                    }
                }
                
                // Handle approved_fund
                $approved_fund = $this->input->post("approved_fund");
                $approved_fund_other = $this->input->post("approved_fund_other");

                // Get district name from district ID
                $district_id = $this->input->post("district");
                $district_name = '';
                if (!empty($district_id)) {
                    $district = $this->db->get_where('district', array('id' => $district_id))->row_array();
                    $district_name = isset($district['name']) ? $district['name'] : '';
                }

                $data = ["createdAt" => date('Y-m-d H:i:s'),"sector_name" => $this->input->post("sector_name"), "micro_sector_no" => $this->input->post("micro_sector_no"), "micro_sector_name" => $this->input->post("micro_sector_name"), "year" => $financial_year, "month" => $month, "date" => date("Y-m-d", strtotime($this->input->post("date"))), "district" => $district_name, "assembly" => $this->input->post("assembly"), "block" => $this->input->post("block"), "recommended_letter_no" => $this->input->post("recommended_letter_no"), "booth_no" => $this->input->post("booth_no"), "booth_name" => $this->input->post("booth_name"), "panchayat_name" => $this->input->post("panchayat_name"), "village" => $this->input->post("village"), "majra_faliya" => $this->input->post("majra_faliya"), "work_problem" => $this->input->post("work_problem"), "office" => $this->input->post("office"), "approximate_cost" => $this->input->post("approximate_cost"), "department" => $this->input->post("department"), "priority" => $this->input->post("priority"),
                "ts_no_date" => $this->input->post("ts_no_date"), 
                "as_no_date" =>$this->input->post("as_no_date"),
                "approved_fund" => $approved_fund,
                "approved_fund_other" => $approved_fund_other,
                "work_agency" => $this->input->post("work_agency"),
                
                "type_of_work" => $this->input->post("type_of_work"), "middle_men" => $this->input->post("middle_men"), "cont_no" => $this->input->post("cont_no"), "beneficial" => $this->input->post("beneficial"), "uname" => $this->input->post("beneficial"), "po" => $this->input->post("po"), "work_status" => $this->input->post("work_status"), "remark_goshana" => $this->input->post("remark_goshana"), "createdBy" => $this->vendorId, "mobile" => $this->input->post("mobile"), ];
                // Insert data into database
                
                if (!empty($_FILES['file']['name'])) {
    if ($this->upload->do_upload('file')) {
        // File upload success
        $upload_data = $this->upload->data();
        $data['uploaded_file'] = $upload_data['file_name']; // Add the file name to the data array
    } else {
        // Handle file upload error (optional)
        $error = $this->upload->display_errors();
        //echo "File upload error: " . $error; // You can log this error or handle it differently
    }
}
$lastRegQuery = $this->db->select("registration_no")
                                     ->order_by("id", "DESC")
                                     ->limit(1)
                                     ->get("districtpublicproblem");

            $lastRegNo = $lastRegQuery->row_array();
            $nextNumber = 100; // Default if no previous record found

            if (!empty($lastRegNo)) {
                preg_match('/\d+$/', $lastRegNo['registration_no'], $matches);
                if (!empty($matches)) {
                    $nextNumber = (int)$matches[0] + 1;
                }
            }

            $registration_no = "MP/" . $nextNumber;
 $data["registration_no"]= $registration_no;  
 
                $insert_id = $this->db->insert("districtpublicproblem", $data);
                
                if ($insert_id) {
                    // Log activity
                    $insertId = $this->db->insert_id();
                    $this->logActivity('add', 'districtpublicproblem', $insertId, $data, null, 'District Public Problem created with ID: ' . $insertId);
                    // Redirect or load success view
                    $this->session->set_flashdata("success", "Data added successfully.");
                    redirect("Districtpublicproblem/Disctrictproblem");
                } else {
                    // Redirect or load failure view
                    $this->session->set_flashdata("error", "Failed to add data.");
                    redirect("Districtpublicproblem/Disctrictproblem");
                }
            }
        }
    }
    
    
      public function editDisctrictproblem($id) {
        $this->module = "MP-publicproblem"; // Fixed: Changed to match config
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            // Fetch the existing record
            $data["jansunwai"] = $this->db->get_where("districtpublicproblem", ["id" => $id])->row();
            $this->global["pageTitle"] = "CodeInsect : Edit Disctrictproblem";
            $data["blocks"] = $this->Comman_model->get_all_data("block");
            $data["departments"] = $this->Comman_model->get_all_data("department");
            $data["districts"] = $this->Comman_model->get_all_data("district");
            $data["vidhan_sabhas"] = $this->Comman_model->get_all_data("vidhan_sabha");
            $this->loadViews("districtproblem/editDisctrictproblem", $this->global, $data, null);
        }
    }
    
    
        
        function Disctrictproblemcommentview($id) {
        // Static list of available modules - updated to match config
        $availableModules = ["Block-Level", "Bhopal-Level", "USS-Level"];
        
        foreach ($availableModules as $module) {
        $this->module = $module;
        
        if (!$this->hasListAccess()) {
        $this->loadThis();
        return; // Exit if access is denied
        } else {
        // Fetch user records for the given ID
        $data["userRecords"] = $this->Disctrictproblem->districtpublicproblemcommentlist($id);
        
        // Set the page title
        $this->global["pageTitle"] = "Disctrictproblem";
        
        // Load the views with the provided data
        $this->loadViews("districtproblem/Disctrictproblemcommentview", $this->global, $data, null);
        return; // Exit after successful loading
        }
        }
        
        // Handle case if no module is processed successfully
        $this->global["pageTitle"] = "Access Denied";
        $this->loadThis();
        }
        public function updateDisctrictproblem() {
        // Set form validation rules
        // $this->form_validation->set_rules("sector_name", "Sector Name", "required");
        // $this->form_validation->set_rules("micro_sector_no", "Micro Sector No.", "required");
        // $this->form_validation->set_rules("micro_sector_name", "Micro Sector Name", "required");
        $this->form_validation->set_rules("year", "Year", "required|numeric");
        $this->form_validation->set_rules("month", "Month", "required");
        $this->form_validation->set_rules("date", "Date", "required");
        $this->form_validation->set_rules("district", "District", "required");
        $this->form_validation->set_rules("assembly", "Assembly", "required");
        $this->form_validation->set_rules("block", "Block", "required");
        $this->form_validation->set_rules("recommended_letter_no", "Recommended Letter No.", "required");
        $this->form_validation->set_rules("booth_no", "Booth No.", "required");
        $this->form_validation->set_rules("booth_name", "Booth Name", "required");
        $this->form_validation->set_rules("panchayat_name", "Panchayat Name", "required");
        $this->form_validation->set_rules("village", "Village", "required");
        $this->form_validation->set_rules("majra_faliya", "Majra-Faliya", "required");
        $this->form_validation->set_rules("work_problem", "Work/Problem", "required");
        $this->form_validation->set_rules("office", "Office", "required");
        $this->form_validation->set_rules("approximate_cost", "Approximate Cost", "required|decimal");
        $this->form_validation->set_rules("department", "Department", "required");
        $this->form_validation->set_rules("priority", "Priority", "required");
        //$this->form_validation->set_rules("ts_no_date", "TS No/Date", "required");
        //$this->form_validation->set_rules("as_no_date", "AS No/Date", "required");
        $this->form_validation->set_rules("type_of_work", "Type of Work", "required");
        $this->form_validation->set_rules("middle_men", "Middle Men", "required");
        $this->form_validation->set_rules("cont_no", "Cont No.", "required");
        $this->form_validation->set_rules("beneficial", "Beneficial", "required");
        // $this->form_validation->set_rules("po", "PO", "required");
        // $this->form_validation->set_rules("work_status", "Work Status", "required");
        $this->form_validation->set_rules("remark_goshana", "Remark/Goshana", "required");
        
        
        $this->global["pageTitle"] = "CodeInsect : Update Disctrictproblem";
        
        if ($this->form_validation->run() == false) {
            echo  validation_errors();
        // If validation fails, reload the edit form with validation errors
        $id = $this->input->post("id");
        $this->editDisctrictproblem($id);
        } else {
        $config['upload_path'] = './uploads/'; // Specify the upload directory
        $config['allowed_types'] = '*'; // Specify allowed file types
        $config['max_size'] = '*'; // Set maximum file size in KB (2MB)
        $this->load->library('upload', $config);
        
        // Convert year to financial year format
        $year = $this->input->post("year");
        $month = $this->input->post("month");
        $financial_year = $year . '-' . substr($year + 1, -2);

        $this->load->helper("fund_budget");
        $this->load->model("Fund_budget_model");
        $id = (int) $this->input->post("id");
        $resolved_fund = resolve_approved_fund_post($this->input->post("approved_fund"), $this->input->post("approved_fund_other"));
        $norm_fund = normalize_approved_fund_name($resolved_fund);
        if ($norm_fund !== null) {
            $fy = canonicalize_financial_year_for_budget($financial_year);
            $chk = $this->Fund_budget_model->check_budget($norm_fund, $fy, (float) $this->input->post("approximate_cost"), "districtpublicproblem", $id);
            if (!$chk["ok"]) {
                $this->session->set_flashdata("error", $chk["message"]);
                redirect("Districtpublicproblem/editDisctrictproblem/" . $id);
                return;
            }
        }
        
        // Handle approved_fund
        $approved_fund = $this->input->post("approved_fund");
        $approved_fund_other = $this->input->post("approved_fund_other");
        
        // Get district name from district ID
        $district_id = $this->input->post("district");
        $district_name = '';
        if (!empty($district_id)) {
            $district = $this->db->get_where('district', array('id' => $district_id))->row_array();
            $district_name = isset($district['name']) ? $district['name'] : '';
        }
        
        // Gather post data
        $id = $this->input->post("id");
        $data = ["sector_name" => $this->input->post("sector_name"), "micro_sector_no" => $this->input->post("micro_sector_no"), "micro_sector_name" => $this->input->post("micro_sector_name"), "year" => $financial_year, "month" => $month, "date" => $this->input->post("date"), "district" => $district_name, "assembly" => $this->input->post("assembly"), "block" => $this->input->post("block"), "recommended_letter_no" => $this->input->post("recommended_letter_no"), "booth_no" => $this->input->post("booth_no"), "booth_name" => $this->input->post("booth_name"), "panchayat_name" => $this->input->post("panchayat_name"), "village" => $this->input->post("village"), "majra_faliya" => $this->input->post("majra_faliya"), "work_problem" => $this->input->post("work_problem"), "office" => $this->input->post("office"), "approximate_cost" => $this->input->post("approximate_cost"), "department" => $this->input->post("department"), "priority" => $this->input->post("priority"),
        "ts_no_date" => $this->input->post("ts_no_date"), "as_no_date" => $this->input->post("as_no_date"), "approved_fund" => $approved_fund, "approved_fund_other" => $approved_fund_other, "work_agency" => $this->input->post("work_agency"), "type_of_work" => $this->input->post("type_of_work"), "middle_men" => $this->input->post("middle_men"), "cont_no" => $this->input->post("cont_no"), "beneficial" => $this->input->post("beneficial"), "uname" => $this->input->post("beneficial"), "mobile" => $this->input->post("mobile"), "po" => $this->input->post("po"), 
        // "work_status" => $this->input->post("work_status"), 
        "remark_goshana" => $this->input->post("remark_goshana"), "updatedBy" => $this->vendorId, ];
        // Update data in database
        
        if (!empty($_FILES['file']['name'])) {
        if ($this->upload->do_upload('file')) {
        // File upload success
        $upload_data = $this->upload->data();
        $data['uploaded_file'] = $upload_data['file_name']; // Add the file name to the data array
        } else {
        // Handle file upload error (optional)
        $error = $this->upload->display_errors();
        //echo "File upload error: " . $error; // You can log this error or handle it differently
        }
        }
        
        
        // Get old data before update for logging
        $oldData = $this->db->get_where("districtpublicproblem", ["id" => $id])->row_array();
        
        $this->db->where("id", $id);
        $update = $this->db->update("districtpublicproblem", $data);
        
        if ($update) {
            // Log activity with old and new data
            $this->logActivity('edit', 'districtpublicproblem', $id, $data, $oldData, 'District Public Problem updated with ID: ' . $id);
        // Redirect or load success view
        $this->session->set_flashdata("success", "Data updated successfully.");
        redirect("Districtpublicproblem/Disctrictproblem");
        } else {
        // Redirect or load failure view
        $this->session->set_flashdata("error", "Failed to update data.");
        redirect("Districtpublicproblem/editDisctrictproblem/" . $id);
        }
        }
        }
        public function submit_form($id, $stage) {
        $this->global["pageTitle"] = "Disctrictproblem";
        
        // Load form validation and file upload libraries
        $this->load->library("form_validation");
        $this->load->helper(["form", "url"]);
        
        // Set validation rules
        // $this->form_validation->set_rules("date", "Date", "required");
        $this->form_validation->set_rules("comment", "Comment", "required");
        $this->form_validation->set_rules("status", "Status", "required");
        
        // Check if the form validation passed
        if ($this->form_validation->run() == false) {
        // Validation failed, load the form again with errors
        $this->loadViews("districtproblem/form_view", $this->global, [], null);
        } else {
        // Validation passed
        // Handle file upload if a file is uploaded
        $file_name = null;  // Initialize file name variable
        
        if (!empty($_FILES['file_upload']['name'])) {
        // Set file upload configuration
        $config["upload_path"] = "./uploads/";
        $config["allowed_types"] = "*";
        $config["max_size"] = 2048; // 2MB
        
        $this->load->library("upload", $config);
        
        if (!$this->upload->do_upload("file_upload")) {
        // File upload failed, load the form again with errors
        $error = ["error" => $this->upload->display_errors()];
        $this->loadViews("districtproblem/form_view", $this->global, $error, null);
        return;
        } else {
        // File upload success
        $upload_data = $this->upload->data();
        $file_name = $upload_data["file_name"];  // Save file name if upload was successful
        }
        }
        
        // Prepare data for database
        $data = [
        // "commentdate" => $this->input->post("date"),
        "comment" => $this->input->post("comment"),
        "fileupload" => $file_name, // If no file uploaded, file_name will be null
        "status" => $this->input->post("status"),
        "jid" => $id,
        "stage" => $stage,
        "createdBy" => $this->vendorId,
        "createdAt" => date('Y-m-d H:i:s') // Add current date and time
        ];
        
        
        // Insert data into the database
        if ($this->db->insert("districtpublicproblemcomment", $data)) {
        // Update work status in the Disctrictproblem table
        $this->db->where("id", $id);
        
        $update = $this->db->update("districtpublicproblem", ['work_status'=> $this->input->post("status"), "updatedAt" => date('Y-m-d H:i:s')]);
        
        // Log the action
        $commentId = $this->db->insert_id();
        $this->logActivity('add', 'districtpublicproblemcomment', $commentId, $data, null, 'District Public Problem comment added for record ID: ' . $id . ' (Stage: ' . $stage . ')');
        
        // Return JSON if it's an AJAX request
        if ($this->input->is_ajax_request()) {
            echo json_encode(['success' => true, 'message' => 'Comment added successfully']);
            return;
        }

        // Redirect based on stage
        if ($stage == 1) {
        redirect("Districtpublicproblem/Disctrictproblem");
        } else if ($stage == 2) {
        redirect("Districtpublicproblem/Disctrictproblem");
        } else if ($stage == 3) {
        redirect("Districtpublicproblem/Disctrictproblem");
        }
        } else {
        // Handle the error case
        if ($this->input->is_ajax_request()) {
            echo json_encode(['success' => false, 'message' => 'Failed to save data']);
            return;
        }
        $this->loadViews("districtproblem/form_view", $this->global, ["error" => "Failed to save data"], null);
        }
        }
        }

    public function add_comment_ajax() {
        header('Content-Type: application/json');
        
        $id = $this->input->post('id');
        $stage = $this->input->post('stage');
        $comment = $this->input->post('comment');
        $status = $this->input->post('status');
        
        if (empty($id) || empty($comment) || empty($status)) {
            echo json_encode([
                'success' => false,
                'message' => 'Required fields are missing'
            ]);
            return;
        }
        
        $file_name = null;
        if (!empty($_FILES['file_upload']['name'])) {
            $config["upload_path"] = "./uploads/";
            $config["allowed_types"] = "*";
            $config["max_size"] = 20000;
            
            $this->load->library("upload", $config);
            
            if ($this->upload->do_upload("file_upload")) {
                $upload_data = $this->upload->data();
                $file_name = $upload_data["file_name"];
            }
        }
        
        $data = [
            "comment" => $comment,
            "fileupload" => $file_name,
            "status" => $status,
            "jid" => $id,
            "stage" => $stage,
            "createdBy" => $this->vendorId,
            "createdAt" => date('Y-m-d H:i:s')
        ];
        
        if ($this->db->insert("districtpublicproblemcomment", $data)) {
            $this->db->where("id", $id);
            $this->db->update("districtpublicproblem", [
                'work_status' => $status, 
                "updatedAt" => date('Y-m-d H:i:s')
            ]);
            
            $comments = $this->Disctrictproblem->districtpublicproblemcommentlist($id);
            
            echo json_encode([
                'success' => true,
                'message' => 'Comment added successfully',
                'comments' => $comments
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to add comment'
            ]);
        }
    }

    public function get_districtpublicproblem_details($id) {
        header('Content-Type: application/json');
        
        // Get record details
        $this->db->select('districtpublicproblem.*, block.name as block_name, booth.name as booth_name_joined, booth.bnumber as booth_number, village.name as village_name_joined, panchayat.name as panchayat_name_joined, department.name as department_name, tbl_users.name as added_by_name');
        $this->db->from('districtpublicproblem');
        $this->db->join('block', 'block.id = districtpublicproblem.block', 'left');
        $this->db->join('booth', 'booth.id = districtpublicproblem.booth_name', 'left');
        $this->db->join('village', 'village.id = districtpublicproblem.village', 'left');
        $this->db->join('panchayat', 'panchayat.id = districtpublicproblem.panchayat_name', 'left');
        $this->db->join('department', 'department.id = districtpublicproblem.department', 'left');
        $this->db->join('tbl_users', 'tbl_users.userId = districtpublicproblem.createdBy', 'left');
        $this->db->where('districtpublicproblem.id', $id);
        $record = $this->db->get()->row();
        
        // Get comments
        $comments = $this->Disctrictproblem->districtpublicproblemcommentlist($id);
        
        if ($record) {
            echo json_encode([
                'success' => true,
                'record' => $record,
                'comments' => $comments
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Record not found'
            ]);
        }
    }

    public function delete($id) {
        $this->module = "MP-publicproblem";
        if (!$this->hasDeleteAccess()) {
            $this->loadThis();
        } else {
            // Get data before delete for logging
            $problemData = $this->db->get_where("districtpublicproblem", ["id" => $id])->row_array();

            $this->db->where('id', $id);
            $deleted = $this->db->delete('districtpublicproblem');

            if ($deleted) {
                // Also delete associated comments
                $this->db->where('jid', $id);
                $this->db->delete('districtpublicproblemcomment');

                // Log activity
                $this->logActivity('delete', 'districtpublicproblem', $id, $problemData, null, 'District Public Problem record deleted with ID: ' . $id . ' (Registration No: ' . (!empty($problemData['registration_no']) ? $problemData['registration_no'] : 'N/A') . ')');
                $this->session->set_flashdata('success', 'Record deleted successfully.');
            } else {
                $this->session->set_flashdata('error', 'Failed to delete the record.');
            }
            redirect("Districtpublicproblem/Disctrictproblem");
        }
    }

    // Get vidhan sabhas by district (AJAX)
    public function get_vidhan_sabhas_by_district() {
        $district_id = $this->input->post('district_id');
        
        if (empty($district_id)) {
            echo json_encode(['success' => false, 'vidhan_sabhas' => []]);
            return;
        }

        $this->load->model('Vidhan_sabha_model');
        $vidhan_sabhas = $this->Vidhan_sabha_model->get_vidhan_sabhas_by_district($district_id);
        echo json_encode(['success' => true, 'vidhan_sabhas' => $vidhan_sabhas]);
    }

}
?>
