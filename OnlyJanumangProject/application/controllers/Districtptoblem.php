<?php if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
}
require APPPATH . "/libraries/BaseController.php";
class Districtptoblem extends BaseController {
    public function __construct() {
        parent::__construct();
        $this->load->model("user_model");
        $this->load->model("Comman_model");
        $this->load->model("Log_model");
        $this->isLoggedIn();
        $this->load->library("form_validation");
        $this->module = "Users";
        date_default_timezone_set('Asia/Kolkata');

    }
    public function index() {
        
//         $data["blocks"] = $this->Comman_model->send_sms('1707173000152417598','9997735570,9315180828',"श्रीमान आपके यहां var1 जनसमस्याएं पेंडिंग हैं, जल्द से जल्द निराकरण कीजिए।
// उमंग सिंगार 
// नेता प्रतिपक्ष");
// print_r(   $data["blocks"] );

// die;


        $this->global["pageTitle"] = "CodeInsect : Dashboard";
        $data["dashboarddata1"] = $this->user_model->getJansunwaiStatusCountByBlock(1);
        $data["dashboarddata2"] = $this->user_model->getJansunwaiStatusCountByBlock(2);
        $data["dashboarddata3"] = $this->user_model->getJansunwaiStatusCountByBlock(3);
        $data["dashboarddata4"] = $this->user_model->getJansunwaiStatusCountByBlock(4);
        $sql = "
        SELECT 
        b.id as block_id, 
        b.name as block_name, 
        COUNT(j.id) as total_records,
        SUM(CASE WHEN j.current_stage = 1 AND j.work_status = 'Incomplete' THEN 1 ELSE 0 END) as stage_1_incomplete,
        SUM(CASE WHEN j.current_stage = 1 AND j.work_status = 'Complete' THEN 1 ELSE 0 END) as stage_1_complete,
        SUM(CASE WHEN j.current_stage = 1 AND j.work_status = 'In progress' THEN 1 ELSE 0 END) as stage_1_in_progress,
        SUM(CASE WHEN j.current_stage = 2 AND j.work_status = 'Incomplete' THEN 1 ELSE 0 END) as stage_2_incomplete,
        SUM(CASE WHEN j.current_stage = 2 AND j.work_status = 'Complete' THEN 1 ELSE 0 END) as stage_2_complete,
        SUM(CASE WHEN j.current_stage = 2 AND j.work_status = 'In progress' THEN 1 ELSE 0 END) as stage_2_in_progress,
        SUM(CASE WHEN j.current_stage = 3 AND j.work_status = 'Incomplete' THEN 1 ELSE 0 END) as stage_3_incomplete,
        SUM(CASE WHEN j.current_stage = 3 AND j.work_status = 'Complete' THEN 1 ELSE 0 END) as stage_3_complete,
        SUM(CASE WHEN j.current_stage = 3 AND j.work_status = 'In progress' THEN 1 ELSE 0 END) as stage_3_in_progress,
        COUNT(j.id) as total_count,
        SUM(CASE WHEN DATE(j.createdAt) = CURDATE() THEN 1 ELSE 0 END) as today_count
        FROM jansunwai j 
        LEFT JOIN block b ON b.id = j.block
        GROUP BY b.id, b.name
    
        UNION ALL
    
        SELECT 
        NULL as block_id,
        'All Blocks' as block_name, 
        COUNT(j.id) as total_records,
        SUM(CASE WHEN j.current_stage = 1 AND j.work_status = 'Incomplete' THEN 1 ELSE 0 END) as stage_1_incomplete,
        SUM(CASE WHEN j.current_stage = 1 AND j.work_status = 'Complete' THEN 1 ELSE 0 END) as stage_1_complete,
        SUM(CASE WHEN j.current_stage = 1 AND j.work_status = 'In progress' THEN 1 ELSE 0 END) as stage_1_in_progress,
        SUM(CASE WHEN j.current_stage = 2 AND j.work_status = 'Incomplete' THEN 1 ELSE 0 END) as stage_2_incomplete,
        SUM(CASE WHEN j.current_stage = 2 AND j.work_status = 'Complete' THEN 1 ELSE 0 END) as stage_2_complete,
        SUM(CASE WHEN j.current_stage = 2 AND j.work_status = 'In progress' THEN 1 ELSE 0 END) as stage_2_in_progress,
        SUM(CASE WHEN j.current_stage = 3 AND j.work_status = 'Incomplete' THEN 1 ELSE 0 END) as stage_3_incomplete,
        SUM(CASE WHEN j.current_stage = 3 AND j.work_status = 'Complete' THEN 1 ELSE 0 END) as stage_3_complete,
        SUM(CASE WHEN j.current_stage = 3 AND j.work_status = 'In progress' THEN 1 ELSE 0 END) as stage_3_in_progress,
        COUNT(j.id) as total_count,
        SUM(CASE WHEN DATE(j.createdAt) = CURDATE() THEN 1 ELSE 0 END) as today_count
        FROM jansunwai j
    
        ORDER BY 
        CASE 
            WHEN block_name = 'All Blocks' THEN 0 
            ELSE 1 
        END,
        block_name";
        $query = $this->db->query($sql);
        $data["records"] = $query->result();
        
        $query = $this->db->query("
        SELECT *
        FROM (
            SELECT 
            CASE
                WHEN b.name IS NULL THEN 'All Blocks'
                ELSE b.name
            END AS BlockName,
            b.id AS block_id, 
            SUM(CASE WHEN j.code LIKE '%BC%' THEN 1 ELSE 0 END) AS BC_Count,
            SUM(CASE WHEN j.code LIKE '%PP%' THEN 1 ELSE 0 END) AS PP_Count,
            SUM(CASE WHEN j.code LIKE '%IP%' THEN 1 ELSE 0 END) AS IP_Count,
            SUM(CASE WHEN j.code LIKE '%FH%' THEN 1 ELSE 0 END) AS FH_Count,
            SUM(CASE WHEN j.code LIKE '%SMM%' THEN 1 ELSE 0 END) AS SMM_Count,
            SUM(CASE WHEN j.code LIKE '%MS%' THEN 1 ELSE 0 END) AS MS_Count,
            SUM(CASE WHEN j.code LIKE '%FP%' THEN 1 ELSE 0 END) AS FP_Count,
            SUM(CASE WHEN j.code LIKE '%ER%' THEN 1 ELSE 0 END) AS ER_Count,
            SUM(CASE WHEN j.code LIKE '%AK%' THEN 1 ELSE 0 END) AS AK_Count,
            SUM(CASE WHEN j.code LIKE '%FM%' THEN 1 ELSE 0 END) AS FM_Count,
            SUM(CASE WHEN j.code LIKE '%वरिष्ठ%' THEN 1 ELSE 0 END) AS वरिष्ठ_Count,
            SUM(CASE WHEN j.code LIKE '%युवा%' THEN 1 ELSE 0 END) AS युवा_Count,
            SUM(CASE WHEN j.code LIKE '%वोटर प्रभारी (10 घर)%' THEN 1 ELSE 0 END) AS वोटर_प्रभारी_Count,
            COUNT(j.id) AS Total_Count,
            SUM(CASE WHEN DATE(j.create_date) = CURDATE() THEN 1 ELSE 0 END) AS Today_Count
        FROM block b
        LEFT JOIN servayapp j ON b.id = j.block_name_number
        WHERE b.id != 6
        GROUP BY b.name, b.id WITH ROLLUP
        ) AS subquery
        WHERE block_id IS NOT NULL -- Remove rows where block_id is NULL (extra row from ROLLUP)
        ORDER BY 
        CASE 
            WHEN BlockName = 'All Blocks' THEN 0 
            ELSE 1 
        END, 
        BlockName");
        $data["blocks"] = $query->result();
        
        
        $query = $this->db->query("SELECT *
FROM (
    SELECT 
    CASE
        WHEN d.name IS NULL THEN 'All Districts'
        ELSE d.name
    END AS DistrictName,
    d.id AS district_id, 
    SUM(CASE WHEN j.code LIKE '%BC%' THEN 1 ELSE 0 END) AS BC_Count,
    SUM(CASE WHEN j.code LIKE '%PP%' THEN 1 ELSE 0 END) AS PP_Count,
    SUM(CASE WHEN j.code LIKE '%IP%' THEN 1 ELSE 0 END) AS IP_Count,
    SUM(CASE WHEN j.code LIKE '%FH%' THEN 1 ELSE 0 END) AS FH_Count,
    SUM(CASE WHEN j.code LIKE '%SMM%' THEN 1 ELSE 0 END) AS SMM_Count,
    SUM(CASE WHEN j.code LIKE '%MS%' THEN 1 ELSE 0 END) AS MS_Count,
    SUM(CASE WHEN j.code LIKE '%FP%' THEN 1 ELSE 0 END) AS FP_Count,
    SUM(CASE WHEN j.code LIKE '%ER%' THEN 1 ELSE 0 END) AS ER_Count,
    SUM(CASE WHEN j.code LIKE '%AK%' THEN 1 ELSE 0 END) AS AK_Count,
    SUM(CASE WHEN j.code LIKE '%FM%' THEN 1 ELSE 0 END) AS FM_Count,
    SUM(CASE WHEN j.code LIKE '%वरिष्ठ%' THEN 1 ELSE 0 END) AS वरिष्ठ_Count,
    SUM(CASE WHEN j.code LIKE '%युवा%' THEN 1 ELSE 0 END) AS युवा_Count,
    SUM(CASE WHEN j.code LIKE '%वोटर प्रभारी (10 घर)%' THEN 1 ELSE 0 END) AS वोटर_प्रभारी_Count,
    COUNT(j.id) AS Total_Count,
    SUM(CASE WHEN DATE(j.create_date) = CURDATE() THEN 1 ELSE 0 END) AS Today_Count
    FROM district d
    LEFT JOIN servayapp j ON d.id = j.district
     GROUP BY d.name, d.id WITH ROLLUP
) AS subquery
WHERE district_id IS NOT NULL  
ORDER BY `subquery`.`district_id` ASC");
        $data["districts"] = $query->result(); 
        
        $data["status_count_by_block"] = $this->user_model->getStatusCountByBlock();
        $data["status_count"] = $this->user_model->getStatusCount();
        
     $this->db->select('d.id AS department_id, 
                   d.name AS department_name, 
                   j.work_status as work_statuses,
                   SUM(CASE WHEN j.work_status = "Complete" THEN 1 ELSE 0 END) AS complete_count,
                   SUM(CASE WHEN j.work_status = "Incomplete" THEN 1 ELSE 0 END) AS incomplete_count,
                   SUM(CASE WHEN j.work_status = "In progress" THEN 1 ELSE 0 END) AS inprogress_count,
                   COUNT(j.id) AS total_count');
$this->db->from("department d");
$this->db->join("jansunwai j", "j.department = d.id", "left");

$blockname = $this->input->post("blockname");
if (!empty($blockname)) {
    $this->db->where("j.block >=", $blockname);
}

$start_date = $this->input->post("start_date");
$end_date = $this->input->post("end_date");
if (!empty($start_date)) {
    $this->db->where("j.createdAt >=", $start_date);
}
if (!empty($end_date)) {
    $this->db->where("j.createdAt <=", $end_date);
}

// Group by both department and work status to get individual rows per status
// $this->db->group_by(array('d.id', 'j.work_status'));
$this->db->group_by(array('d.id'));
$query = $this->db->get();
$data["results"] = $query->result();



        
        $data["Allblocks"] = $this->user_model->getAllBlocks(); // Assuming 'your_model' is the name of your model
        $this->loadViews("general/dashboard", $this->global, $data, null);
    }
    public function blockdashboard() {
        $this->global["pageTitle"] = "CodeInsect : Dashboard";
        $this->loadViews("general/blockdashboard", $this->global, [], null);
    }
    function userListing() {
        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            $searchText = "";
            if (!empty($this->input->post("searchText"))) {
                $searchText = $this->security->xss_clean($this->input->post("searchText"));
            }
            $data["searchText"] = $searchText;
            $this->load->library("pagination");
            $count = $this->user_model->userListingCount($searchText);
            $returns = $this->paginationCompress("userListing/", $count, 10);
            $data["userRecords"] = $this->user_model->userListing($searchText, $returns["page"], $returns["segment"]);
            $this->global["pageTitle"] = "CodeInsect : User Listing";
            $this->loadViews("users/users", $this->global, $data, null);
        }
    }
    public function addNewJansunwai() {
        $this->module = "PublicProblems0";
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            // Set form validation rules
            $this->form_validation->set_rules("sector_name", "Sector Name", "required");
            $this->form_validation->set_rules("micro_sector_no", "Micro Sector No.", "required");
            $this->form_validation->set_rules("micro_sector_name", "Micro Sector Name", "required");
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
            $this->form_validation->set_rules("cont_no", "Cont No.", "required|regex_match[/^\d{10}$/]");
            $this->form_validation->set_rules("beneficial", "Beneficial", "required");
            $this->form_validation->set_rules("po", "PO", "required");
            $this->form_validation->set_rules("work_status", "Work Status", "required");
            $this->form_validation->set_rules("remark_goshana", "Remark/Goshana", "required");
            $this->global["pageTitle"] = "CodeInsect : Add New Jansunwai";
            $data["blocks"] = $this->Comman_model->get_all_data("block");
            $data["departments"] = $this->Comman_model->get_all_data("department");
            if ($this->form_validation->run() == false) {
                $this->loadViews("users/addJansunwai", $this->global, $data, null);
            } else {
                // Gather post data
                
                $config['upload_path'] = './uploads/'; // Specify the upload directory
                $config['allowed_types'] = '*'; // Specify allowed file types
                $config['max_size'] = '*'; // Set maximum file size in KB (2MB)
                $this->load->library('upload', $config);



                $data = ["createdAt" => date('Y-m-d H:i:s'),"sector_name" => $this->input->post("sector_name"), "micro_sector_no" => $this->input->post("micro_sector_no"), "micro_sector_name" => $this->input->post("micro_sector_name"), "year" => $this->input->post("year"), "month" => $this->input->post("month"), "date" => date("Y-m-d", strtotime($this->input->post("date"))), "district" => $this->input->post("district"), "assembly" => $this->input->post("assembly"), "block" => $this->input->post("block"), "recommended_letter_no" => $this->input->post("recommended_letter_no"), "booth_no" => $this->input->post("booth_no"), "booth_name" => $this->input->post("booth_name"), "panchayat_name" => $this->input->post("panchayat_name"), "village" => $this->input->post("village"), "majra_faliya" => $this->input->post("majra_faliya"), "work_problem" => $this->input->post("work_problem"), "office" => $this->input->post("office"), "approximate_cost" => $this->input->post("approximate_cost"), "department" => $this->input->post("department"), "priority" => $this->input->post("priority"),
                "ts_no_date" => $this->input->post("ts_no_date"), 
                "as_no_date" =>$this->input->post("as_no_date"),
                
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

                $insert_id = $this->db->insert("jansunwai", $data);
                
                $this->Log_model->log_action("Insert jansunwai", "jansunwai", $insert_id, $data);
                if ($insert_id) {
                    // Redirect or load success view
                    $this->session->set_flashdata("success", "Data added successfully.");
                    redirect("user/jansunwai");
                } else {
                    // Redirect or load failure view
                    $this->session->set_flashdata("error", "Failed to add data.");
                    redirect("user/jansunwai");
                }
            }
        }
    }
    public function editJansunwai($id) {
        $this->module = "PublicProblems0";
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            // Fetch the existing record
            $data["jansunwai"] = $this->db->get_where("jansunwai", ["id" => $id])->row();
            $this->global["pageTitle"] = "CodeInsect : Edit Jansunwai";
            $data["blocks"] = $this->Comman_model->get_all_data("block");
            $data["departments"] = $this->Comman_model->get_all_data("department");
            $this->loadViews("users/editJansunwai", $this->global, $data, null);
        }
    }
    public function updateJansunwai() {
        // Set form validation rules
        $this->form_validation->set_rules("sector_name", "Sector Name", "required");
        $this->form_validation->set_rules("micro_sector_no", "Micro Sector No.", "required");
        $this->form_validation->set_rules("micro_sector_name", "Micro Sector Name", "required");
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
        $this->form_validation->set_rules("cont_no", "Cont No.", "required|regex_match[/^\d{10}$/]");
        $this->form_validation->set_rules("beneficial", "Beneficial", "required");
        $this->form_validation->set_rules("po", "PO", "required");
        // $this->form_validation->set_rules("work_status", "Work Status", "required");
        $this->form_validation->set_rules("remark_goshana", "Remark/Goshana", "required");
        $this->global["pageTitle"] = "CodeInsect : Update Jansunwai";
        if ($this->form_validation->run() == false) {
            // If validation fails, reload the edit form with validation errors
            $id = $this->input->post("id");
            $this->editJansunwai($id);
        } else {
            $config['upload_path'] = './uploads/'; // Specify the upload directory
                $config['allowed_types'] = '*'; // Specify allowed file types
                $config['max_size'] = '*'; // Set maximum file size in KB (2MB)
                $this->load->library('upload', $config);
            // Gather post data
            $id = $this->input->post("id");
            $data = ["sector_name" => $this->input->post("sector_name"), "micro_sector_no" => $this->input->post("micro_sector_no"), "micro_sector_name" => $this->input->post("micro_sector_name"), "year" => $this->input->post("year"), "month" => $this->input->post("month"), "date" => $this->input->post("date"), "district" => $this->input->post("district"), "assembly" => $this->input->post("assembly"), "block" => $this->input->post("block"), "recommended_letter_no" => $this->input->post("recommended_letter_no"), "booth_no" => $this->input->post("booth_no"), "booth_name" => $this->input->post("booth_name"), "panchayat_name" => $this->input->post("panchayat_name"), "village" => $this->input->post("village"), "majra_faliya" => $this->input->post("majra_faliya"), "work_problem" => $this->input->post("work_problem"), "office" => $this->input->post("office"), "approximate_cost" => $this->input->post("approximate_cost"), "department" => $this->input->post("department"), "priority" => $this->input->post("priority"),
            "ts_no_date" => $this->input->post("ts_no_date"), "as_no_date" => $this->input->post("as_no_date"), "type_of_work" => $this->input->post("type_of_work"), "middle_men" => $this->input->post("middle_men"), "cont_no" => $this->input->post("cont_no"), "beneficial" => $this->input->post("beneficial"), "uname" => $this->input->post("beneficial"), "mobile" => $this->input->post("mobile"), "po" => $this->input->post("po"), 
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


            $this->db->where("id", $id);
            $update = $this->db->update("jansunwai", $data);
            $this->Log_model->log_action("Update jansunwai", "jansunwai", $id, $data);
            if ($update) {
                // Redirect or load success view
                $this->session->set_flashdata("success", "Data updated successfully.");
                redirect("user/jansunwai");
            } else {
                // Redirect or load failure view
                $this->session->set_flashdata("error", "Failed to update data.");
                redirect("user/editJansunwai/" . $id);
            }
        }
    }
    public function addNew() {
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $this->load->model("user_model");
            $data["roles"] = $this->user_model->getUserRoles();
            $this->load->model("Block_model");
            $data["blocks"] = $this->Block_model->get_blocks();
            $this->global["pageTitle"] = "CodeInsect : Add New User";
            $this->loadViews("users/addNew", $this->global, $data, null);
        }
    }
    function checkEmailExists() {
        $userId = $this->input->post("userId");
        $email = $this->input->post("email");
        if (empty($userId)) {
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }
        if (empty($result)) {
            echo "true";
        } else {
            echo "false";
        }
    }
    function addNewUser() {
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $this->load->library("form_validation");
            $this->form_validation->set_rules("fname", "Full Name", "trim|required|max_length[128]");
            $this->form_validation->set_rules("email", "Email", "trim|required|valid_email|max_length[128]");
            $this->form_validation->set_rules("password", "Password", "required|max_length[20]");
            $this->form_validation->set_rules("cpassword", "Confirm Password", "trim|required|matches[password]|max_length[20]");
            $this->form_validation->set_rules("role", "Role", "trim|required|numeric");
            $this->form_validation->set_rules("mobile", "Mobile Number", "required|regex_match[/^\d{10}$/]");
            if ($this->form_validation->run() == false) {
                $this->addNew();
            } else {
                $name = ucwords(strtolower($this->security->xss_clean($this->input->post("fname"))));
                $email = strtolower($this->security->xss_clean($this->input->post("email")));
                $password = $this->input->post("password");
                $roleId = $this->input->post("role");
                $mobile = $this->security->xss_clean($this->input->post("mobile"));
                $isAdmin = $this->input->post("isAdmin");
                $block = implode(",",$this->input->post("block"));
              
                // if ($roleId == 4) {
                //     $block = 1;
                // } elseif ($roleId == 5) {
                //     $block = 2;
                // } elseif ($roleId == 6) {
                //     $block = 3;
                // } elseif ($roleId == 7) {
                //     $block = 4;
                // } elseif ($roleId == 8) {
                //     $block = 5;
                // }
                $userInfo = ["email" => $email, "password" => getHashedPassword($password), "roleId" => $roleId, "name" => $name, "mobile" => $mobile, "isAdmin" => $isAdmin, "blockId" => $block, "createdBy" => $this->vendorId, "createdDtm" => date("Y-m-d H:i:s"), ];
                $this->load->model("user_model");
                $result = $this->user_model->addNewUser($userInfo);
                $this->Log_model->log_action("Insert user", "tbl_users", $result, $userInfo);
                if ($result > 0) {
                    $this->session->set_flashdata("success", "New User created successfully");
                } else {
                    $this->session->set_flashdata("error", "User creation failed");
                }
                redirect("addNew");
            }
        }
    }
    function editOld($userId = null) {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            if ($userId == null) {
                redirect("userListing");
            }
            $data["roles"] = $this->user_model->getUserRoles();
            $data["userInfo"] = $this->user_model->getUserInfo($userId);
            $this->global["pageTitle"] = "CodeInsect : Edit User";
            $this->loadViews("users/editOld", $this->global, $data, null);
        }
    }
    function editUser() {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $this->load->library("form_validation");
            $userId = $this->input->post("userId");
            $this->form_validation->set_rules("fname", "Full Name", "trim|required|max_length[128]");
            $this->form_validation->set_rules("email", "Email", "trim|required|valid_email|max_length[128]");
            $this->form_validation->set_rules("password", "Password", "matches[cpassword]|max_length[20]");
            $this->form_validation->set_rules("cpassword", "Confirm Password", "matches[password]|max_length[20]");
            $this->form_validation->set_rules("role", "Role", "trim|required|numeric");
            $this->form_validation->set_rules("mobile", "Mobile Number", "required|min_length[10]");
            if ($this->form_validation->run() == false) {
                $this->editOld($userId);
            } else {
                $name = ucwords(strtolower($this->security->xss_clean($this->input->post("fname"))));
                $email = strtolower($this->security->xss_clean($this->input->post("email")));
                $password = $this->input->post("password");
                $roleId = $this->input->post("role");
                $mobile = $this->security->xss_clean($this->input->post("mobile"));
                $isAdmin = $this->input->post("isAdmin");
                $userInfo = [];
                if (empty($password)) {
                    $userInfo = ["email" => $email, "roleId" => $roleId, "name" => $name, "mobile" => $mobile, "isAdmin" => $isAdmin, "updatedBy" => $this->vendorId, "updatedDtm" => date("Y-m-d H:i:s"), ];
                } else {
                    $userInfo = ["email" => $email, "password" => getHashedPassword($password), "roleId" => $roleId, "name" => ucwords($name), "mobile" => $mobile, "isAdmin" => $isAdmin, "updatedBy" => $this->vendorId, "updatedDtm" => date("Y-m-d H:i:s"), ];
                }
                $result = $this->user_model->editUser($userInfo, $userId);
                $this->Log_model->log_action("Update User", "tbl_users", $userId, $userInfo);
                if ($result == true) {
                    $this->session->set_flashdata("success", "User updated successfully");
                } else {
                    $this->session->set_flashdata("error", "User updation failed");
                }
                redirect("userListing");
            }
        }
    }
    function deleteUser() {
        if (!$this->hasDeleteAccess()) {
            $this->loadThis();
        } else {
            $userId = $this->input->post("userId");
            $userInfo = ["isDeleted" => 1, "updatedBy" => $this->vendorId, "updatedDtm" => date("Y-m-d H:i:s"), ];
            $result = $this->user_model->deleteUser($userId, $userInfo);
            $this->Log_model->log_action("Delete User", "tbl_users", $userId, $userInfo);
            if ($result > 0) {
                echo json_encode(["status" => true]);
            } else {
                echo json_encode(["status" => false]);
            }
        }
    }
    function pageNotFound() {
        $this->global["pageTitle"] = "CodeInsect : 404 - Page Not Found";
        $this->loadViews("general/404", $this->global, null, null);
    }
    function loginHistoy($userId = null) {
        // if(!$this->isAdmin())
        // {
        //     $this->loadThis();
        // }
        // else
        // {
        $userId = $userId == null ? 0 : $userId;
        $searchText = $this->input->post("searchText");
        $fromDate = $this->input->post("fromDate");
        $toDate = $this->input->post("toDate");
        $data["userInfo"] = $this->user_model->getUserInfoById($userId);
        $data["searchText"] = $searchText;
        $data["fromDate"] = $fromDate;
        $data["toDate"] = $toDate;
        $this->load->library("pagination");
        $count = $this->user_model->loginHistoryCount($userId, $searchText, $fromDate, $toDate);
        $returns = $this->paginationCompress("login-history/" . $userId . "/", $count, 10, 3);
        $data["userRecords"] = $this->user_model->loginHistory($userId, $searchText, $fromDate, $toDate, $returns["page"], $returns["segment"]);
        $this->global["pageTitle"] = "CodeInsect : User Login History";
        $this->loadViews("users/loginHistory", $this->global, $data, null);
        // }
        
    }
    function profile($active = "details") {
        $data["userInfo"] = $this->user_model->getUserInfoWithRole($this->vendorId);
        $data["active"] = $active;
        $this->global["pageTitle"] = $active == "details" ? "CodeInsect : My Profile" : "CodeInsect : Change Password";
        $this->loadViews("users/profile", $this->global, $data, null);
    }
    function profileUpdate($active = "details") {
        $this->load->library("form_validation");
        $this->form_validation->set_rules("fname", "Full Name", "trim|required|max_length[128]");
        $this->form_validation->set_rules("mobile", "Mobile Number", "required|regex_match[/^\d{10}$/]");
        $this->form_validation->set_rules("email", "Email", "trim|required|valid_email|max_length[128]|callback_emailExists");
        if ($this->form_validation->run() == false) {
            $this->profile($active);
        } else {
            $name = ucwords(strtolower($this->security->xss_clean($this->input->post("fname"))));
            $mobile = $this->security->xss_clean($this->input->post("mobile"));
            $email = strtolower($this->security->xss_clean($this->input->post("email")));
            $userInfo = ["name" => $name, "email" => $email, "mobile" => $mobile, "updatedBy" => $this->vendorId, "updatedDtm" => date("Y-m-d H:i:s"), ];
            $result = $this->user_model->editUser($userInfo, $this->vendorId);
            $this->Log_model->log_action("Profile update", "tbl_users", $this->vendorId, $userInfo);
            if ($result == true) {
                $this->session->set_userdata("name", $name);
                $this->session->set_flashdata("success", "Profile updated successfully");
            } else {
                $this->session->set_flashdata("error", "Profile updation failed");
            }
            redirect("profile/" . $active);
        }
    }
    function changePassword($active = "changepass") {
        $this->load->library("form_validation");
        $this->form_validation->set_rules("oldPassword", "Old password", "required|max_length[20]");
        $this->form_validation->set_rules("newPassword", "New password", "required|max_length[20]");
        $this->form_validation->set_rules("cNewPassword", "Confirm new password", "required|matches[newPassword]|max_length[20]");
        if ($this->form_validation->run() == false) {
            $this->profile($active);
        } else {
            $oldPassword = $this->input->post("oldPassword");
            $newPassword = $this->input->post("newPassword");
            $resultPas = $this->user_model->matchOldPassword($this->vendorId, $oldPassword);
            if (empty($resultPas)) {
                $this->session->set_flashdata("nomatch", "Your old password is not correct");
                redirect("profile/" . $active);
            } else {
                $usersData = ["password" => getHashedPassword($newPassword), "updatedBy" => $this->vendorId, "updatedDtm" => date("Y-m-d H:i:s"), ];
                $result = $this->user_model->changePassword($this->vendorId, $usersData);
                $this->Log_model->log_action("Change Password", "tbl_users", $this->vendorId, $usersData);
                if ($result > 0) {
                    $this->session->set_flashdata("success", "Password updation successful");
                } else {
                    $this->session->set_flashdata("error", "Password updation failed");
                }
                redirect("profile/" . $active);
            }
        }
    }
    function emailExists($email) {
        $userId = $this->vendorId;
        $return = false;
        if (empty($userId)) {
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }
        if (empty($result)) {
            $return = true;
        } else {
            $this->form_validation->set_message("emailExists", "The {field} already taken");
            $return = false;
        }
        return $return;
    }
    public function servaylisting() {
        $this->module = "MemberList";
        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            $block = $this->input->post("block");
            $year = $this->input->post("year");
            $month = $this->input->post("month");
            $samithi = $this->input->post("samithi");
            $vehicle = $this->input->post("vehicle");
            $code = $this->input->post("code");
            $this->db->select("*");
            $this->db->from("servayapp");
            $this->db->order_by("id", "DESC");
            // Apply filters if provided
            if ($block !== null && $block !== "") {
                $this->db->where("block_name_number", $block);
            }
            if ($year !== null && $year !== "") {
                $this->db->where("YEAR(create_date)", $year);
            }
            if ($month !== null && $month !== "") {
                $this->db->where("MONTH(create_date)", $month);
            }
            if ($samithi !== null && $samithi !== "") {
                $this->db->where("samithi", $samithi);
            }
            if ($vehicle !== null && $vehicle !== "") {
                $this->db->like("vehicle", $vehicle);
            }
            if ($code !== null && $code !== "") {
                $this->db->like("code", $code);
            }
            // Execute the query
            $query = $this->db->get();
            $data["userRecords"] = $query->result();
            // Load the view with the filtered data
            $this->loadViews("users/servaylisting", $this->global, $data, null);
        }
    }
    function userservaylisting() {
        // if(!$this->isAdmin())
        // {
        //     $this->loadThis();
        // }
        // else
        // {
        $dd = $this->db->query("SELECT * FROM `servayapp` ORDER BY `create_date` DESC;");
        $data["userRecords"] = $dd->result();
        $this->loadViews("users/userservaylisting", $this->global, $data, null);
        // }
        
    }
    function ipuserlisting() {
        // if(!$this->isAdmin())
        // {
        //     $this->loadThis();
        // }
        // else
        // {
        $dd = $this->db->query("SELECT * FROM `servayapp` WHERE `code` IN('IP (प्रभावशाली व्यक्ति)') ORDER BY `create_date` DESC;");
        $data["userRecords"] = $dd->result();
        $this->loadViews("users/ipuserlisting", $this->global, $data, null);
        // }
        
    }
    //userservaylisting
    function editservay($userId = null) {
        // if(!$this->isAdmin())
        // {
        //     $this->loadThis();
        // }
        // else
        // {
        if ($userId == null) {
            redirect("servaylisting");
        }
        // $data['roles'] = $this->user_model->getUserRoles();
        $data["userInfo"] = $this->user_model->getservayInfoById($userId);
        $this->global["pageTitle"] = "CodeInsect : Edit User";
        $this->loadViews("users/editservay", $this->global, $data, null);
        // }
        
    }
    function editservayview($userId = null) {
        $this->module = "MemberList";
        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            if ($userId == null) {
                redirect("servaylisting");
            }
            $data["userInfo"] = $this->user_model->getservayInfoById($userId);
            $this->global["pageTitle"] = "CodeInsect : View User";
            $this->loadViews("users/editservayview", $this->global, $data, null);
        }
    }
    function userservayview($userId = null) {
        // if(!$this->isAdmin())
        // {
        //     $this->loadThis();
        // }
        // else
        // {
        if ($userId == null) {
            redirect("servaylisting");
        }
        // $data['roles'] = $this->user_model->getUserRoles();
        $data["userInfo"] = $this->user_model->getservayInfouserById($userId);
        $this->global["pageTitle"] = "CodeInsect : View User";
        $this->loadViews("users/editservayview", $this->global, $data, null);
        // }
        
    }
    function userwiseipuserlisting($user_id) {
        // if(!$this->isAdmin())
        // {
        //     $this->loadThis();
        // }
        // else
        // {
        $dd = $this->db->query("SELECT * FROM `servayapp` WHERE user_id='$user_id' and  `code` IN('IP (प्रभावशाली व्यक्ति)') ORDER BY `create_date` DESC;");
        $data["userRecords"] = $dd->result();
        $this->loadViews("users/ipuserlisting", $this->global, $data, null);
        //}
        
    }
    public function editstatus() {
        // print_r($this->input->post());die;
        $iddd = $this->input->post();
        $uu = $iddd["editstatus"][0];
        if ($uu == 0) {
            $where["editstatus"] = 0;
            $ui = $this->Comman_model->getAllData("servayapp", $where, "id");
            foreach ($ui as $k => $vv) {
                //  print_r($vv) ;
                $editstatus["editstatus"] = "1";
                $id["id"] = $vv->id;
                $this->Comman_model->UpdateRecord("servayapp", $editstatus, $id);
            }
            redirect("ServayListing");
        } else {
            $aa = $this->input->post("editstatus");
            foreach ($aa as $k => $vv) {
                $editstatus["editstatus"] = "1";
                $id["id"] = $vv;
                $this->Comman_model->UpdateRecord("servayapp", $editstatus, $id);
            }
            redirect("ServayListing");
        }
    }
    public function deletestatus($id) {
        $ifd["id"] = $id;
        $this->Comman_model->Deletedata("servayapp", $ifd);
        $this->Log_model->log_action("Delete servay", "servayapp", $ifd, []);
        redirect("ServayListing");
    }
    public function usercount() {
        $this->module = "UserCount";
        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            $data["userRecords"] = $this->user_model->usercountListing();
            $this->global["pageTitle"] = "CodeInsect : User Listing";
            $this->loadViews("users/usercount", $this->global, $data, null);
        }
    }

    function jansunwai() {
     //   echo "<pre>";
       // print_r($this->session->userdata());
        $this->module = "PublicProblems0";
        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            $block = $this->input->post("block");
            $year = $this->input->post("year");
            $month = $this->input->post("month");
            $data["userRecords"] = $this->user_model->jansunwailist($block, $year, $month);
            $this->global["pageTitle"] = "Jansunwai";
            $this->loadViews("users/jansunwailist", $this->global, $data, null);
        }
    }

    function filterJansunwai() {
        $this->module = "PublicProblems0";
        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            $block = $this->input->get("block");
            $stage = $this->input->get("stage");
            $status = $this->input->get("status");
            $department = $this->input->get("department");
            $today = "";
            if ($stage == 4) {
                $today = date("Y-m-d");
            }
            $data["userRecords"] = $this->user_model->filterjansunwailist($block, $stage, $status, $today,$department);
            $this->global["pageTitle"] = "Jansunwai";
            if($stage=='' || $stage== 1 ){
            $this->loadViews("users/jansunwailist", $this->global, $data, null);
            }else if( $stage== 2){
                
            $this->loadViews("users/jansunwailiststage2", $this->global, $data, null);
            
        }else if( $stage== 3){
                
            $this->loadViews("users/jansunwailiststage3", $this->global, $data, null);
        }
            
        }
    }
    function jansunwai2() {
        $this->module = "PublicProblems2";
        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            $data["userRecords"] = $this->user_model->jansunwailist24();
            $this->global["pageTitle"] = "Jansunwai";
            $this->loadViews("users/jansunwailiststage2", $this->global, $data, null);
        }
    }
    function jansunwai3() {
        
        $this->module = "PublicProblems3";
        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            $data["userRecords"] = $this->user_model->jansunwailist48();
            $this->global["pageTitle"] = "Jansunwai";
            $this->loadViews("users/jansunwailiststage3", $this->global, $data, null);
        }
    }
    // function jansunwaicommentview($id) {
        
    //     $this->module = "PublicProblems0";
    //     if (!$this->hasListAccess()) {
    //         $this->loadThis();
    //     } else {
    //       $data["userRecords"] = $this->user_model->jansunwaicommentlist($id);
    //         $this->global["pageTitle"] = "Jansunwai";
    //         $this->loadViews("users/jansunwaicommentview", $this->global, $data, null);
    //     }
         
    // }
    function jansunwaicommentview($id) {
    // Static list of available modules
    $availableModules = ["PublicProblems0", "PublicProblems1", "PublicProblems2"];
    
    foreach ($availableModules as $module) {
        $this->module = $module;

        if (!$this->hasListAccess()) {
            $this->loadThis();
            return; // Exit if access is denied
        } else {
            // Fetch user records for the given ID
            $data["userRecords"] = $this->user_model->jansunwaicommentlist($id);

            // Set the page title
            $this->global["pageTitle"] = "Jansunwai";

            // Load the views with the provided data
            $this->loadViews("users/jansunwaicommentview", $this->global, $data, null);
            return; // Exit after successful loading
        }
    }
    
    // Handle case if no module is processed successfully
    $this->global["pageTitle"] = "Access Denied";
    $this->loadThis();
}

    function department() {
        $this->module = "Department";
        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            $data["userRecords"] = $this->user_model->departmentlist();
            $this->global["pageTitle"] = "department";
            $this->loadViews("users/departmentlist", $this->global, $data, null);
        }
    }
    function party() {
        $this->module = "Party";
        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            $data["userRecords"] = $this->user_model->partylist();
            $this->global["pageTitle"] = "party";
            $this->loadViews("users/partylist", $this->global, $data, null);
        }
    }
    public function partyadd() {
        $this->module = "Party";
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $this->form_validation->set_rules("name", "Name", "trim|required");
            if ($this->form_validation->run() == false) {
                if ($this->form_validation->error_string() != "") {
                    $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                    <i class="fa fa-warning"></i>
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                </div>';
                }
            } else {
                $arrayName = ["name" => $this->input->post("name"), ];
                $ids = $this->Comman_model->insertData("party", $arrayName);
                $this->Log_model->log_action("Party insert", "party", $ids, $arrayName);
                $this->session->set_flashdata("success_req", '<div class="alert alert-success alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Success!</strong> Your request Add successfully...
                                        </div>');
                redirect("user/party");
            }
            $this->global["pageTitle"] = "Add party";
            $this->loadViews("users/partyadd", $this->global, [], null);
        }
    }
    public function vibhagadd() {
        $this->module = "Department";
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $this->form_validation->set_rules("name", "Name", "trim|required");
            if ($this->form_validation->run() == false) {
                if ($this->form_validation->error_string() != "") {
                    $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                    <i class="fa fa-warning"></i>
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                </div>';
                }
            } else {
                $arrayName = ["name" => $this->input->post("name"), ];
                $ids = $this->Comman_model->insertData("department", $arrayName);
                $this->Log_model->log_action("Department insert", "department", $ids, $arrayName);
                $this->session->set_flashdata("success_req", '<div class="alert alert-success alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Success!</strong> Your request Add successfully...
                                        </div>');
                redirect("user/department");
            }
            $this->global["pageTitle"] = "Add Vibhag";
            $this->loadViews("users/departmentadd", $this->global, [], null);
        }
    }
    public function deprtedit($id) {
        $this->module = "Department";
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $this->form_validation->set_rules("name", "Name", "trim|required");
            if ($this->form_validation->run() == false) {
                if ($this->form_validation->error_string() != "") {
                    $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                    <i class="fa fa-warning"></i>
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                </div>';
                }
            } else {
                $arrayName = ["name" => $this->input->post("name"), ];
                $ids = $this->Comman_model->UpdateRecord("department", $arrayName, ["id" => $id]);
                $this->Log_model->log_action("Department update", "department", $ids, $arrayName);
                $this->session->set_flashdata("success_req", '<div class="alert alert-success alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Success!</strong> Your request Add successfully...
                                        </div>');
                redirect("user/department");
            }
            $this->global["pageTitle"] = "Add Vibhag";
            $data["row"] = $this->Comman_model->getdata("department", ["id" => $id, ]);
            $this->loadViews("users/departmentedit", $this->global, $data, null);
        }
    }
    public function partyedit($id) {
        $this->module = "Party";
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $this->form_validation->set_rules("name", "Name", "trim|required");
            if ($this->form_validation->run() == false) {
                if ($this->form_validation->error_string() != "") {
                    $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                    <i class="fa fa-warning"></i>
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> ' . $this->form_validation->error_string() . '
                                </div>';
                }
            } else {
                $arrayName = ["name" => $this->input->post("name"), ];
                $ids = $this->Comman_model->UpdateRecord("party", $arrayName, ["id" => $id, ]);
                $this->Log_model->log_action("Party update", "party", $id, $arrayName);
                $this->session->set_flashdata("success_req", '<div class="alert alert-success alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Success!</strong> Your request Add successfully...
                                        </div>');
                redirect("user/party");
            }
            $this->global["pageTitle"] = "Add Vibhag";
            $data["row"] = $this->Comman_model->getdata("party", ["id" => $id]);
            $this->loadViews("users/partyedit", $this->global, $data, null);
        }
    }
    function partydelete($id) {
        $this->module = "Party";
        if (!$this->hasDeleteAccess()) {
            $this->loadThis();
        } else {
            $data = $this->Comman_model->Deletedata("party", ["id" => $id]);
            $this->Log_model->log_action("Party delete", "party", $id, []);
            redirect("user/party");
        }
    }
    function departdelete($id) {
        $this->module = "Department";
        if (!$this->hasDeleteAccess()) {
            $this->loadThis();
        } else {
            $data = $this->Comman_model->Deletedata("department", ["id" => $id, ]);
            $this->Log_model->log_action("Department delete", "department", $id, []);
            redirect("user/department");
        }
    }
  public function submit_form($id, $stage) {
    $this->global["pageTitle"] = "Jansunwai";
    
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
        $this->loadViews("users/form_view", $this->global, [], null);
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
                $this->loadViews("users/form_view", $this->global, $error, null);
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
        if ($this->db->insert("jansunwaicomment", $data)) {
            // Update work status in the jansunwai table
            $this->db->where("id", $id);
            
            $update = $this->db->update("jansunwai", ['work_status'=> $this->input->post("status"), "updatedAt" => date('Y-m-d H:i:s')]);

            // Log the action
            $this->Log_model->log_action("Jansunwai comment", "jansunwaicomment", $id, $data);
            
            // Redirect based on stage
            if ($stage == 1) {
                redirect("user/jansunwai");
            } else if ($stage == 2) {
                redirect("user/jansunwai2");
            } else if ($stage == 3) {
                redirect("user/jansunwai3");
            }
        } else {
            // Handle the error case
            $this->loadViews("users/form_view", $this->global, ["error" => "Failed to save data"], null);
        }
    }
}

    public function filterServaylisting() {
        $this->module = "MemberList";
        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            $block = $this->input->get("block");
            $code = $this->input->get("code");
            $district_id = $this->input->get("district_id");
            $today = $this->input->get("today");
            $this->db->select("servayapp.*, b.name as block_name"); // Adjust columns as needed
            $this->db->from("servayapp");
            $this->db->join("block b", "b.id = servayapp.block_name_number", "left");
            $this->db->where("b.id !=", 6);
            $this->db->order_by("servayapp.id", "DESC");
               
            if ($district_id !== null && $district_id !== "") {
                $this->db->where("servayapp.district", $district_id);
            }
            if ($block !== null && $block !== "") {
                $this->db->where("servayapp.block_name_number", $block);
            }
            if ($code !== null && $code !== "") {
                $this->db->like("servayapp.code", $code);
            }
            if ($today !== null && $today !== "") {
                $this->db->like("servayapp.createdAt", date("Y-m-d"));
            }
            // Execute the query
            $query = $this->db->get();
            $data["userRecords"] = $query->result();
            // Load the view with the filtered data
            $this->loadViews("users/servaylisting", $this->global, $data, null);
        }
    }
}
?>
