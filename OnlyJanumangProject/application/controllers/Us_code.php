<?php
require APPPATH . '/libraries/BaseController.php';

class Us_code extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->isLoggedIn();
        $this->load->model('UsCode_model');
        $this->load->library('form_validation');
        $this->module = 'US-Code';
        $this->setup();
    }

    // Setup database table if it doesn't exist
    private function setup() {
        // Check if table exists
        if (!$this->db->table_exists('us_code')) {
            $this->create_table();
        }
    }

    // Create US Code table with default data
    private function create_table() {
        $sql = "CREATE TABLE IF NOT EXISTS `us_code` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `code` varchar(100) NOT NULL UNIQUE,
          `description` varchar(255),
          `status` tinyint(1) DEFAULT 1,
          `created_by` int(11),
          `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
          `updated_by` int(11),
          `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

        $this->db->query($sql);

        // Insert default codes
        $codes = array(
            array('code' => 'SC', 'description' => 'SC', 'status' => 1),
            array('code' => 'YC', 'description' => 'YC', 'status' => 1),
            array('code' => 'WC', 'description' => 'WC', 'status' => 1),
            array('code' => 'PA', 'description' => 'PA', 'status' => 1),
            array('code' => 'SM', 'description' => 'SM', 'status' => 1),
            array('code' => 'EO', 'description' => 'EO', 'status' => 1),
            array('code' => 'GS', 'description' => 'GS', 'status' => 1),
            array('code' => 'DCC', 'description' => 'DCC', 'status' => 1),
            array('code' => 'PW', 'description' => 'PW', 'status' => 1),
            array('code' => 'NL', 'description' => 'NL', 'status' => 1),
            array('code' => 'FR', 'description' => 'FR', 'status' => 1),
            array('code' => 'SO', 'description' => 'SO', 'status' => 1),
            array('code' => 'ST', 'description' => 'ST', 'status' => 1),
            array('code' => 'REF', 'description' => 'REF', 'status' => 1),
            array('code' => 'US', 'description' => 'US', 'status' => 1),
            array('code' => 'SMW', 'description' => 'SMW', 'status' => 1),
            array('code' => 'DYC', 'description' => 'DYC', 'status' => 1),
            array('code' => 'OBC', 'description' => 'OBC', 'status' => 1),
            array('code' => 'DT', 'description' => 'DT', 'status' => 1),
            array('code' => 'DP', 'description' => 'DP', 'status' => 1),
            array('code' => 'MLA', 'description' => 'MLA', 'status' => 1),
            array('code' => 'AVP', 'description' => 'AVP', 'status' => 1),
            array('code' => 'MEET', 'description' => 'MEET', 'status' => 1),
            array('code' => 'MEDIA', 'description' => 'MEDIA', 'status' => 1),
            array('code' => 'X MLA', 'description' => 'X MLA', 'status' => 1),
            array('code' => 'BC (बूथ कमेटी)', 'description' => 'BC (बूथ कमेटी)', 'status' => 1),
            array('code' => 'PP (पेज प्रभारी)', 'description' => 'PP (पेज प्रभारी)', 'status' => 1),
            array('code' => 'IP (प्रभावशाली व्यक्ति)', 'description' => 'IP (प्रभावशाली व्यक्ति)', 'status' => 1),
            array('code' => 'FH (परिवार का मुखिया)', 'description' => 'FH (परिवार का मुखिया)', 'status' => 1),
            array('code' => 'SMM (सोशल मीडिया मित्र)', 'description' => 'SMM (सोशल मीडिया मित्र)', 'status' => 1),
            array('code' => 'MS (महिला समिति)', 'description' => 'MS (महिला समिति)', 'status' => 1),
            array('code' => 'FP (फलिया प्रभारी)', 'description' => 'FP (फलिया प्रभारी)', 'status' => 1),
            array('code' => 'ER (चुनाव प्रभारी)', 'description' => 'ER (चुनाव प्रभारी)', 'status' => 1),
            array('code' => 'वरिष्ठ', 'description' => 'वरिष्ठ', 'status' => 1),
            array('code' => 'युवा', 'description' => 'युवा', 'status' => 1),
            array('code' => 'वोटरप्रभारी(१० घर)', 'description' => 'वोटरप्रभारी(१० घर)', 'status' => 1),
            array('code' => 'BLA (बूथ लेवल एजेंट)', 'description' => 'BLA (बूथ लेवल एजेंट)', 'status' => 1)
        );

        foreach ($codes as $code) {
            $this->db->insert('us_code', $code);
        }
    }

    // List all US codes
    public function index() {
        // Allow admin users
        if (!$this->isAdmin()) {
            if (!$this->hasListAccess()) {
                $this->loadThis();
                return;
            }
        }

        $this->global['pageTitle'] = 'US Code Management';
        $data['codes'] = $this->UsCode_model->get_all_codes();
        $this->loadViews("us_code/index", $this->global, $data, NULL);
    }

    // Create new code form
    public function create() {
        if (!$this->isAdmin()) {
            if (!$this->hasCreateAccess()) {
                $this->loadThis();
                return;
            }
        }

        $this->global['pageTitle'] = 'Add US Code';
        $this->loadViews("us_code/create", $this->global, [], NULL);
    }

    // Store new code
    public function store() {
        if (!$this->isAdmin()) {
            if (!$this->hasCreateAccess()) {
                $this->loadThis();
                return;
            }
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('code', 'Code', 'required|trim|is_unique[us_code.code]');
        $this->form_validation->set_rules('description', 'Description', 'trim');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
            return;
        }

        $data = array(
            'code' => $this->input->post('code'),
            'description' => $this->input->post('description'),
            'status' => 1,
            'created_by' => $this->vendorId,
            'created_at' => date('Y-m-d H:i:s')
        );

        $id = $this->db->insert('us_code', $data);
        if ($id) {
            $this->logActivity('add', 'us_code', $this->db->insert_id(), $data, null, 'US Code created: ' . $data['code']);
            $this->session->set_flashdata('success', 'US Code created successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to create US Code');
        }

        redirect('us_code');
    }

    // Edit code form
    public function edit($id) {
        if (!$this->isAdmin()) {
            if (!$this->hasUpdateAccess()) {
                $this->loadThis();
                return;
            }
        }

        $this->global['pageTitle'] = 'Edit US Code';
        $data['code'] = $this->UsCode_model->get_code($id);
        
        if (!$data['code']) {
            $this->session->set_flashdata('error', 'US Code not found');
            redirect('us_code');
            return;
        }

        $this->loadViews("us_code/edit", $this->global, $data, NULL);
    }

    // Update code
    public function update($id) {
        if (!$this->isAdmin()) {
            if (!$this->hasUpdateAccess()) {
                $this->loadThis();
                return;
            }
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('code', 'Code', 'required|trim');
        $this->form_validation->set_rules('description', 'Description', 'trim');

        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
            return;
        }

        $data = array(
            'code' => $this->input->post('code'),
            'description' => $this->input->post('description'),
            'updated_by' => $this->vendorId,
            'updated_at' => date('Y-m-d H:i:s')
        );

        $this->db->where('id', $id);
        if ($this->db->update('us_code', $data)) {
            $this->logActivity('edit', 'us_code', $id, $data, null, 'US Code updated: ' . $data['code']);
            $this->session->set_flashdata('success', 'US Code updated successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to update US Code');
        }

        redirect('us_code');
    }

    // Delete code
    public function delete($id) {
        if (!$this->isAdmin()) {
            if (!$this->hasDeleteAccess()) {
                echo json_encode(['success' => false, 'message' => 'Access denied']);
                return;
            }
        }

        $code = $this->UsCode_model->get_code($id);
        if (!$code) {
            echo json_encode(['success' => false, 'message' => 'US Code not found']);
            return;
        }

        if ($this->UsCode_model->delete_code($id)) {
            $this->logActivity('delete', 'us_code', $id, $code, null, 'US Code deleted: ' . $code['code']);
            echo json_encode(['success' => true, 'message' => 'US Code deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete US Code']);
        }
    }
}
?>
