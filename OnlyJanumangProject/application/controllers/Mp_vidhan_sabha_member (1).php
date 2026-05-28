<?php
require APPPATH . '/libraries/BaseController.php';

class Mp_vidhan_sabha_member extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('Mp_vidhan_sabha_member_model');
        $this->load->helper('url');
        $this->load->model('user_model');
        $this->load->model('Comman_model');
        $this->isLoggedIn();
        $this->load->model('Log_model');
        $this->load->library('form_validation');
        $this->module = 'MP-Vidhan-Sabha-Member';
    }

    // Display all members
    public function index() {
        if(!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            // Get filter values from GET request
            $filter_district = $this->input->get('filter_district');
            $filter_block = $this->input->get('filter_block');
            $filter_vidhan_sabha = $this->input->get('filter_vidhan_sabha');
            $filter_month = $this->input->get('filter_month');
            $filter_year = $this->input->get('filter_year');
            
            // Get all members
            $all_members = $this->Mp_vidhan_sabha_member_model->get_members();
            
            // Apply filters
            $filtered_members = $all_members;
            
            if (!empty($filter_district)) {
                $filtered_members = array_filter($filtered_members, function($member) use ($filter_district) {
                    return $member['district_id'] == $filter_district;
                });
            }
            
            if (!empty($filter_block)) {
                $filtered_members = array_filter($filtered_members, function($member) use ($filter_block) {
                    return $member['block_id'] == $filter_block;
                });
            }
            
            if (!empty($filter_vidhan_sabha)) {
                $filtered_members = array_filter($filtered_members, function($member) use ($filter_vidhan_sabha) {
                    return $member['vidhan_sabha_id'] == $filter_vidhan_sabha;
                });
            }
            
            if (!empty($filter_month)) {
                $filtered_members = array_filter($filtered_members, function($member) use ($filter_month) {
                    return !empty($member['date']) && date('m', strtotime($member['date'])) == str_pad($filter_month, 2, '0', STR_PAD_LEFT);
                });
            }
            
            if (!empty($filter_year)) {
                $filtered_members = array_filter($filtered_members, function($member) use ($filter_year) {
                    return !empty($member['date']) && date('Y', strtotime($member['date'])) == $filter_year;
                });
            }
            
            // Load dropdown data
            $this->load->model('District_model');
            $this->load->model('Block_model');
            $this->load->model('Vidhan_sabha_model');
            
            $data['members'] = array_values($filtered_members);
            $data['districts'] = $this->District_model->get_districts();
            $data['blocks'] = $this->Block_model->get_blocks();
            $data['vidhan_sabhas'] = $this->Vidhan_sabha_model->get_vidhan_sabhas();
            
            // Pass filter values to view
            $data['filter_district'] = $filter_district;
            $data['filter_block'] = $filter_block;
            $data['filter_vidhan_sabha'] = $filter_vidhan_sabha;
            $data['filter_month'] = $filter_month;
            $data['filter_year'] = $filter_year;
            
            $this->global['pageTitle'] = 'Datacollector : MP Vidhan Sabha Member';
            $this->loadViews("mp_vidhan_sabha_member/index", $this->global, $data, NULL);
        }
    }

    // Show a form to create a new member
    public function create() {
        if(!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $this->load->model('District_model');
            $this->load->model('Block_model');
            $this->load->model('Panchayat_model');
            $this->load->model('Vidhan_sabha_model');
            $this->load->model('Village_model');
            
            $data['districts'] = $this->District_model->get_districts();
            $data['blocks'] = $this->Block_model->get_blocks();
            $data['panchayats'] = $this->Panchayat_model->get_panchayats();
            $data['vidhan_sabhas'] = $this->Vidhan_sabha_model->get_vidhan_sabhas();
            $data['villages'] = $this->Village_model->get_villages();
            
            $this->global['pageTitle'] = 'Datacollector : Add MP Vidhan Sabha Member';
            $this->loadViews("mp_vidhan_sabha_member/create", $this->global, $data, NULL);
        }
    }

    // Insert a new member
    public function store() {
        if(!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $this->form_validation->set_rules('name', 'Name', 'required|trim');

            if ($this->form_validation->run() == FALSE) {
                $this->create();
            } else {
                $data = array(
                    'month' => $this->input->post('month'),
                    'date' => $this->input->post('date'),
                    'block_id' => !empty($this->input->post('block_id')) ? (int)$this->input->post('block_id') : null,
                    'panchayat_id' => !empty($this->input->post('panchayat_id')) ? (int)$this->input->post('panchayat_id') : null,
                    'vidhan_sabha_id' => !empty($this->input->post('vidhan_sabha_id')) ? (int)$this->input->post('vidhan_sabha_id') : null,
                    'district_id' => !empty($this->input->post('district_id')) ? (int)$this->input->post('district_id') : null,
                    'village_id' => !empty($this->input->post('village_id')) ? (int)$this->input->post('village_id') : null,
                    'name' => $this->input->post('name'),
                    'position' => $this->input->post('position'),
                    'mobile_no' => $this->input->post('mobile_no'),
                    'bg' => $this->input->post('bg') ? 1 : 0,
                    'bc' => $this->input->post('bc') ? 1 : 0,
                    'er' => $this->input->post('er') ? 1 : 0,
                    'br' => $this->input->post('br') ? 1 : 0,
                    'ip' => $this->input->post('ip') ? 1 : 0,
                    'sc' => $this->input->post('sc') ? 1 : 0,
                    'sa' => $this->input->post('sa') ? 1 : 0,
                    'yc' => $this->input->post('yc') ? 1 : 0,
                    'ap' => $this->input->post('ap') ? 1 : 0,
                    'fp' => $this->input->post('fp') ? 1 : 0,
                    'pp' => $this->input->post('pp') ? 1 : 0,
                    'wc' => $this->input->post('wc') ? 1 : 0,
                    'pa' => $this->input->post('pa') ? 1 : 0,
                    'pc' => $this->input->post('pc') ? 1 : 0,
                    'ak' => $this->input->post('ak') ? 1 : 0,
                    'fm' => $this->input->post('fm') ? 1 : 0,
                    'zp' => $this->input->post('zp') ? 1 : 0,
                    'vp' => $this->input->post('vp') ? 1 : 0,
                    'sr' => $this->input->post('sr') ? 1 : 0,
                    'in_field' => $this->input->post('in_field') ? 1 : 0,
                    'eo' => $this->input->post('eo') ? 1 : 0,
                    'gs' => $this->input->post('gs') ? 1 : 0,
                    'us' => $this->input->post('us') ? 1 : 0,
                    'pw' => $this->input->post('pw') ? 1 : 0,
                    'nl' => $this->input->post('nl') ? 1 : 0,
                    'fr' => $this->input->post('fr') ? 1 : 0,
                    'so' => $this->input->post('so') ? 1 : 0,
                    'st' => $this->input->post('st') ? 1 : 0,
                    'ob' => $this->input->post('ob') ? 1 : 0,
                    'smw' => $this->input->post('smw') ? 1 : 0,
                    'smtw' => $this->input->post('smtw') ? 1 : 0,
                    'it' => $this->input->post('it') ? 1 : 0,
                    'test' => $this->input->post('test') ? 1 : 0,
                    'dyc' => $this->input->post('dyc') ? 1 : 0,
                    'dcc' => $this->input->post('dcc') ? 1 : 0,
                    'obc' => $this->input->post('obc') ? 1 : 0,
                    'cell_mp' => $this->input->post('cell_mp') ? 1 : 0,
                    'dt' => $this->input->post('dt') ? 1 : 0,
                    'dp' => $this->input->post('dp') ? 1 : 0,
                    'avp' => $this->input->post('avp') ? 1 : 0,
                    'meet' => $this->input->post('meet') ? 1 : 0,
                    'media' => $this->input->post('media') ? 1 : 0,
                    'mla_x_mla' => $this->input->post('mla_x_mla') ? 1 : 0,
                    'vech' => $this->input->post('vech') ? 1 : 0,
                    'it_cell_exp' => $this->input->post('it_cell_exp') ? 1 : 0,
                    'info' => $this->input->post('info') ? 1 : 0,
                    'nsui' => $this->input->post('nsui') ? 1 : 0,
                    'imp' => $this->input->post('imp') ? 1 : 0,
                    'advise' => $this->input->post('advise') ? 1 : 0,
                    'ref' => $this->input->post('ref') ? 1 : 0,
                    'remark' => $this->input->post('remark'),
                    'locksabha' => $this->input->post('locksabha'),
                    'year' => $this->input->post('year'),
                    'created_by' => $this->session->userdata('userId'),
                    'added_by' => $this->session->userdata('userId')
                );

                $insert_id = $this->Mp_vidhan_sabha_member_model->create_member($data);
                if ($insert_id) {
                    $this->logActivity('add', 'mp_vidhan_sabha_member', $insert_id, $data, null, 'MP Vidhan Sabha Member created with ID: ' . $insert_id . ' (Name: ' . $data['name'] . ')');
                    $this->session->set_flashdata('success', 'Member created successfully.');
                } else {
                    $this->session->set_flashdata('error', 'Failed to create Member.');
                }

                redirect('mp_vidhan_sabha_member');
            }
        }
    }

    // Show a form to edit a member
    public function edit($id) {
        if(!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $data['member'] = $this->Mp_vidhan_sabha_member_model->get_member($id);
            if (empty($data['member'])) {
                $this->session->set_flashdata('error', 'Member not found.');
                redirect('mp_vidhan_sabha_member');
            }
            
            $this->load->model('District_model');
            $this->load->model('Block_model');
            $this->load->model('Panchayat_model');
            $this->load->model('Vidhan_sabha_model');
            $this->load->model('Village_model');
            
            $data['districts'] = $this->District_model->get_districts();
            $data['blocks'] = $this->Block_model->get_blocks();
            $data['panchayats'] = $this->Panchayat_model->get_panchayats();
            $data['vidhan_sabhas'] = $this->Vidhan_sabha_model->get_vidhan_sabhas();
            $data['villages'] = $this->Village_model->get_villages();
            
            $this->global['pageTitle'] = 'Datacollector : Edit MP Vidhan Sabha Member';
            $this->loadViews("mp_vidhan_sabha_member/edit", $this->global, $data, NULL);
        }
    }

    // Update a member
    public function update($id) {
        if(!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $this->form_validation->set_rules('name', 'Name', 'required|trim');

            if ($this->form_validation->run() == FALSE) {
                $this->edit($id);
            } else {
                $data = array(
                    'month' => $this->input->post('month'),
                    'date' => $this->input->post('date'),
                    'block_id' => !empty($this->input->post('block_id')) ? (int)$this->input->post('block_id') : null,
                    'panchayat_id' => !empty($this->input->post('panchayat_id')) ? (int)$this->input->post('panchayat_id') : null,
                    'vidhan_sabha_id' => !empty($this->input->post('vidhan_sabha_id')) ? (int)$this->input->post('vidhan_sabha_id') : null,
                    'district_id' => !empty($this->input->post('district_id')) ? (int)$this->input->post('district_id') : null,
                    'village_id' => !empty($this->input->post('village_id')) ? (int)$this->input->post('village_id') : null,
                    'name' => $this->input->post('name'),
                    'position' => $this->input->post('position'),
                    'mobile_no' => $this->input->post('mobile_no'),
                    'bg' => $this->input->post('bg') ? 1 : 0,
                    'bc' => $this->input->post('bc') ? 1 : 0,
                    'er' => $this->input->post('er') ? 1 : 0,
                    'br' => $this->input->post('br') ? 1 : 0,
                    'ip' => $this->input->post('ip') ? 1 : 0,
                    'sc' => $this->input->post('sc') ? 1 : 0,
                    'sa' => $this->input->post('sa') ? 1 : 0,
                    'yc' => $this->input->post('yc') ? 1 : 0,
                    'ap' => $this->input->post('ap') ? 1 : 0,
                    'fp' => $this->input->post('fp') ? 1 : 0,
                    'pp' => $this->input->post('pp') ? 1 : 0,
                    'wc' => $this->input->post('wc') ? 1 : 0,
                    'pa' => $this->input->post('pa') ? 1 : 0,
                    'pc' => $this->input->post('pc') ? 1 : 0,
                    'ak' => $this->input->post('ak') ? 1 : 0,
                    'fm' => $this->input->post('fm') ? 1 : 0,
                    'zp' => $this->input->post('zp') ? 1 : 0,
                    'vp' => $this->input->post('vp') ? 1 : 0,
                    'sr' => $this->input->post('sr') ? 1 : 0,
                    'in_field' => $this->input->post('in_field') ? 1 : 0,
                    'eo' => $this->input->post('eo') ? 1 : 0,
                    'gs' => $this->input->post('gs') ? 1 : 0,
                    'us' => $this->input->post('us') ? 1 : 0,
                    'pw' => $this->input->post('pw') ? 1 : 0,
                    'nl' => $this->input->post('nl') ? 1 : 0,
                    'fr' => $this->input->post('fr') ? 1 : 0,
                    'so' => $this->input->post('so') ? 1 : 0,
                    'st' => $this->input->post('st') ? 1 : 0,
                    'ob' => $this->input->post('ob') ? 1 : 0,
                    'smw' => $this->input->post('smw') ? 1 : 0,
                    'smtw' => $this->input->post('smtw') ? 1 : 0,
                    'it' => $this->input->post('it') ? 1 : 0,
                    'test' => $this->input->post('test') ? 1 : 0,
                    'dyc' => $this->input->post('dyc') ? 1 : 0,
                    'dcc' => $this->input->post('dcc') ? 1 : 0,
                    'obc' => $this->input->post('obc') ? 1 : 0,
                    'cell_mp' => $this->input->post('cell_mp') ? 1 : 0,
                    'dt' => $this->input->post('dt') ? 1 : 0,
                    'dp' => $this->input->post('dp') ? 1 : 0,
                    'avp' => $this->input->post('avp') ? 1 : 0,
                    'meet' => $this->input->post('meet') ? 1 : 0,
                    'media' => $this->input->post('media') ? 1 : 0,
                    'mla_x_mla' => $this->input->post('mla_x_mla') ? 1 : 0,
                    'vech' => $this->input->post('vech') ? 1 : 0,
                    'it_cell_exp' => $this->input->post('it_cell_exp') ? 1 : 0,
                    'info' => $this->input->post('info') ? 1 : 0,
                    'nsui' => $this->input->post('nsui') ? 1 : 0,
                    'imp' => $this->input->post('imp') ? 1 : 0,
                    'advise' => $this->input->post('advise') ? 1 : 0,
                    'ref' => $this->input->post('ref') ? 1 : 0,
                    'remark' => $this->input->post('remark'),
                    'locksabha' => $this->input->post('locksabha'),
                    'year' => $this->input->post('year'),
                    'updated_time' => date('Y-m-d H:i:s')
                );

                $oldData = $this->Mp_vidhan_sabha_member_model->get_member($id);
                
                $result = $this->Mp_vidhan_sabha_member_model->update_member($id, $data);
                if ($result) {
                    $this->logActivity('edit', 'mp_vidhan_sabha_member', $id, $data, (array)$oldData, 'MP Vidhan Sabha Member updated with ID: ' . $id . ' (Name: ' . $data['name'] . ')');
                    $this->session->set_flashdata('success', 'Member updated successfully.');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update Member.');
                }

                redirect('mp_vidhan_sabha_member');
            }
        }
    }

    // Delete a member
    public function delete($id) {
        if(!$this->hasDeleteAccess()) {
            $this->loadThis();
        } else {
            $member = $this->Mp_vidhan_sabha_member_model->get_member($id);
            if (empty($member)) {
                $this->session->set_flashdata('error', 'Member not found.');
            } else {
                $result = $this->Mp_vidhan_sabha_member_model->delete_member($id);
                if ($result) {
                    $this->logActivity('delete', 'mp_vidhan_sabha_member', $id, (array)$member, null, 'MP Vidhan Sabha Member deleted with ID: ' . $id . ' (Name: ' . (!empty($member['name']) ? $member['name'] : 'N/A') . ')');
                    $this->session->set_flashdata('success', 'Member deleted successfully.');
                } else {
                    $this->session->set_flashdata('error', 'Failed to delete Member.');
                }
            }
            redirect('mp_vidhan_sabha_member');
        }
    }

    // Show bulk upload form
    public function bulk_upload() {
        if(!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $this->load->model('District_model');
            $this->load->model('Block_model');
            $this->load->model('Panchayat_model');
            $this->load->model('Vidhan_sabha_model');
            $this->load->model('Village_model');
            
            $data['districts'] = $this->District_model->get_districts();
            $data['blocks'] = $this->Block_model->get_blocks();
            $data['panchayats'] = $this->Panchayat_model->get_panchayats();
            $data['vidhan_sabhas'] = $this->Vidhan_sabha_model->get_vidhan_sabhas();
            $data['villages'] = $this->Village_model->get_villages();
            
            $this->global['pageTitle'] = 'Datacollector : Bulk Upload MP Vidhan Sabha Members';
            $this->loadViews("mp_vidhan_sabha_member/bulk_upload", $this->global, $data, NULL);
        }
    }

    // Process bulk upload
    public function process_bulk_upload() {
        if(!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $config['upload_path'] = './uploads/bulk/';
            $config['allowed_types'] = 'csv';
            $config['max_size'] = 10240; // 10MB
            
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0755, true);
            }
            
            $this->load->library('upload', $config);
            
            if (!$this->upload->do_upload('bulk_file')) {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('mp_vidhan_sabha_member/bulk_upload');
            } else {
                $upload_data = $this->upload->data();
                $file_path = $upload_data['full_path'];
                
                // Set PHP locale and MySQL charset explicitly for Hindi support
                setlocale(LC_ALL, 'en_US.UTF-8');
                $this->db->query("SET NAMES 'utf8mb4'");
                
                $csv_file = fopen($file_path, 'r');
                if ($csv_file) {
                    // Check for and skip BOM if present
                    $bom = fread($csv_file, 3);
                    if ($bom !== "\xEF\xBB\xBF") {
                        rewind($csv_file);
                    }

                    $header = fgetcsv($csv_file);
                    if (!$header) {
                        $this->session->set_flashdata('error', 'Unable to read CSV header.');
                        redirect('mp_vidhan_sabha_member/bulk_upload');
                        return;
                    }

                    // Clean headers
                    $header = array_map(function($h) {
                        return strtolower(trim(str_replace([' ', '*'], ['_', ''], $h)));
                    }, $header);

                    $success_count = 0;
                    $error_count = 0;
                    $errors = array();
                    $row_idx = 1;

                    $this->load->helper('bulk_upload');

                    while (($row = fgetcsv($csv_file)) !== FALSE) {
                        $row_idx++;
                        if (empty(array_filter($row))) continue;

                        $data_raw = array_combine($header, array_pad($row, count($header), ''));
                        
                        // Helper to get value by various possible header names
                        $get_val = function($keys) use ($data_raw) {
                            if (is_string($keys)) $keys = [$keys];
                            foreach ($keys as $key) {
                                $key = strtolower(str_replace([' ', '*'], ['_', ''], $key));
                                if (isset($data_raw[$key])) return trim($data_raw[$key]);
                            }
                            return '';
                        };

                        // Encoding check for each field
                        $process_text = function($text) {
                            if (empty($text)) return '';
                            $enc = mb_detect_encoding($text, 'UTF-8, ISO-8859-1, Windows-1252', true);
                            if ($enc && $enc !== 'UTF-8') {
                                return mb_convert_encoding($text, 'UTF-8', $enc);
                            }
                            // If it's not valid UTF-8, it's likely Windows-1252 or similar from Excel
                            if (!mb_check_encoding($text, 'UTF-8')) {
                                return mb_convert_encoding($text, 'UTF-8', 'Windows-1252');
                            }
                            return $text;
                        };

                        // Improved ID/Name resolution logic
                        $d_val = $get_val(['District ID', 'District Name', 'District']);
                        $district_id = is_numeric($d_val) ? (int)$d_val : null;
                        $district_name = !is_numeric($d_val) ? $process_text($d_val) : '';
                        
                        if (!$district_id && !empty($district_name)) {
                            $district_id = get_id_by_name($this, 'district', 'name', $district_name);
                        }

                        $b_val = $get_val(['Block ID', 'Block Name', 'Block']);
                        $block_id = is_numeric($b_val) ? (int)$b_val : null;
                        $block_name = !is_numeric($b_val) ? $process_text($b_val) : '';
                        
                        if (!$block_id && !empty($block_name)) {
                            $block_id = get_id_by_name($this, 'block', 'name', $block_name);
                        }

                        $vs_val = $get_val(['Vidhan Sabha ID', 'Vidhan Sabha Name', 'Vidhan Sabha']);
                        $vs_id = is_numeric($vs_val) ? (int)$vs_val : null;
                        $vs_name = !is_numeric($vs_val) ? $process_text($vs_val) : '';
                        
                        if (!$vs_id && !empty($vs_name)) {
                            $vs_id = get_id_by_name($this, 'vidhan_sabha', 'vidhan_sabha_name', $vs_name);
                        }

                        $p_val = $get_val(['Panchayat ID', 'Panchayat Name', 'Panchayat']);
                        $panchayat_id = is_numeric($p_val) ? (int)$p_val : null;
                        $panchayat_name = !is_numeric($p_val) ? $process_text($p_val) : '';
                        
                        if (!$panchayat_id && !empty($panchayat_name)) {
                            $panchayat_id = get_id_by_name($this, 'panchayat', 'name', $panchayat_name, 'blockid', $block_id);
                            if (empty($panchayat_id)) {
                                $this->db->insert('panchayat', ['name' => $panchayat_name, 'blockid' => $block_id ?: 0]);
                                $panchayat_id = $this->db->insert_id();
                            }
                        }

                        $v_val = $get_val(['Village ID', 'Village Name', 'Village']);
                        $village_id = is_numeric($v_val) ? (int)$v_val : null;
                        $village_name = !is_numeric($v_val) ? $process_text($v_val) : '';
                        
                        if (!$village_id && !empty($village_name)) {
                            $village_id = get_id_by_name($this, 'village', 'name', $village_name, 'blockid', $block_id);
                            if (empty($village_id)) {
                                $this->db->insert('village', ['name' => $village_name, 'blockid' => $block_id ?: 0, 'panchayatid' => $panchayat_id ?: 0]);
                                $village_id = $this->db->insert_id();
                            }
                        }

                        $data = array(
                            'month' => $get_val('Month'),
                            'date' => !empty($get_val('Date')) ? date('Y-m-d', strtotime($get_val('Date'))) : null,
                            'district_id' => $district_id,
                            'block_id' => $block_id,
                            'panchayat_id' => $panchayat_id,
                            'vidhan_sabha_id' => $vs_id,
                            'village_id' => $village_id,
                            'name' => $process_text($get_val('Name')),
                            'position' => $process_text($get_val('Position')),
                            'mobile_no' => $get_val('Mobile No'),
                            'bg' => $get_val('BG') ? 1 : 0,
                            'bc' => $get_val('BC') ? 1 : 0,
                            'er' => $get_val('ER') ? 1 : 0,
                            'br' => $get_val('BR') ? 1 : 0,
                            'ip' => $get_val('IP') ? 1 : 0,
                            'sc' => $get_val('SC') ? 1 : 0,
                            'sa' => $get_val('SA') ? 1 : 0,
                            'yc' => $get_val('YC') ? 1 : 0,
                            'ap' => $get_val('AP') ? 1 : 0,
                            'fp' => $get_val('FP') ? 1 : 0,
                            'pp' => $get_val('PP') ? 1 : 0,
                            'wc' => $get_val('WC') ? 1 : 0,
                            'pa' => $get_val('PA') ? 1 : 0,
                            'pc' => $get_val('PC') ? 1 : 0,
                            'ak' => $get_val('AK') ? 1 : 0,
                            'fm' => $get_val('FM') ? 1 : 0,
                            'zp' => $get_val('ZP') ? 1 : 0,
                            'vp' => $get_val('VP') ? 1 : 0,
                            'sr' => $get_val('SR') ? 1 : 0,
                            'in_field' => $get_val('In Field') ? 1 : 0,
                            'eo' => $get_val('EO') ? 1 : 0,
                            'gs' => $get_val('GS') ? 1 : 0,
                            'us' => $get_val('US') ? 1 : 0,
                            'pw' => $get_val('PW') ? 1 : 0,
                            'nl' => $get_val('NL') ? 1 : 0,
                            'fr' => $get_val('FR') ? 1 : 0,
                            'so' => $get_val('SO') ? 1 : 0,
                            'st' => $get_val('ST') ? 1 : 0,
                            'ob' => $get_val('OB') ? 1 : 0,
                            'smw' => $get_val('SMW') ? 1 : 0,
                            'smtw' => $get_val('SMTW') ? 1 : 0,
                            'it' => $get_val('IT') ? 1 : 0,
                            'test' => $get_val('Test') ? 1 : 0,
                            'dyc' => $get_val('DYC') ? 1 : 0,
                            'dcc' => $get_val('DCC') ? 1 : 0,
                            'obc' => $get_val('OBC') ? 1 : 0,
                            'cell_mp' => $get_val(['cell_mp', 'cell', 'mp', 'cell/mp']) ? 1 : 0,
                            'dt' => $get_val('DT') ? 1 : 0,
                            'dp' => $get_val('DP') ? 1 : 0,
                            'avp' => $get_val('AVP') ? 1 : 0,
                            'meet' => $get_val('Meet') ? 1 : 0,
                            'media' => $get_val('Media') ? 1 : 0,
                            'mla_x_mla' => $get_val('MLA X MLA') ? 1 : 0,
                            'vech' => $get_val('Vech') ? 1 : 0,
                            'it_cell_exp' => $get_val('IT Cell Exp') ? 1 : 0,
                            'info' => $get_val('Info') ? 1 : 0,
                            'nsui' => $get_val('NSUI') ? 1 : 0,
                            'imp' => $get_val('IMP') ? 1 : 0,
                            'advise' => $get_val('Advise') ? 1 : 0,
                            'ref' => $get_val('Ref') ? 1 : 0,
                            'remark' => $process_text($get_val('Remark')),
                            'locksabha' => $process_text($get_val(['locksabha', 'lok sabha'])),
                            'year' => $process_text($get_val('Year')),
                            'created_by' => $this->session->userdata('userId'),
                            'added_by' => $this->session->userdata('userId')
                        );

                        if (empty($data['name'])) {
                            $errors[] = "Row $row_idx: Name is required";
                            $error_count++;
                            continue;
                        }

                        if ($this->Mp_vidhan_sabha_member_model->create_member($data)) {
                            $success_count++;
                        } else {
                            $errors[] = "Row $row_idx: Database insert failed";
                            $error_count++;
                        }
                    }
                    fclose($csv_file);
                    unlink($file_path);

                    $message = "Bulk upload completed. Success: $success_count, Errors: $error_count";
                    if (!empty($errors)) $message .= "\nErrors: " . implode(", ", array_slice($errors, 0, 5));
                    
                    $this->session->set_flashdata($success_count > 0 ? 'success' : 'error', $message);
                } else {
                    $this->session->set_flashdata('error', 'Unable to open uploaded file.');
                }
                redirect('mp_vidhan_sabha_member');
            }
        }
    }

    // Download sample CSV template
    public function download_template() {
        $filename = 'mp_vidhan_sabha_member_template.csv';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        // CSV headers
        $headers = array(
            'Month', 'Date', 'District Name', 'Block Name', 'Panchayat Name', 'Vidhan Sabha Name', 'Village ID',
            'Name', 'Position', 'Mobile No', 'BG', 'BC', 'ER', 'BR', 'IP', 'SC', 'SA', 'YC', 'AP', 'FP', 'PP', 'WC',
            'PA', 'PC', 'AK', 'FM', 'ZP', 'VP', 'SR', 'In Field', 'EO', 'GS', 'US', 'PW', 'NL', 'FR', 'SO', 'ST',
            'OB', 'SMW', 'SMTW', 'IT', 'Test', 'DYC', 'DCC', 'OBC', 'Cell', 'MP', 'DT', 'DP', 'AVP', 'Meet', 'Media',
            'MLA x MLA', 'Vech', 'IT Cell Exp', 'Info', 'NSUI', 'IMP', 'Advise', 'Ref', 'Remark', 'Lok Sabha', 'Year'
        );
        
        fputcsv($output, $headers);
        
        // Sample data row
        $sample = array(
            'August', '23-08-2024', 'Dhar', 'GANDHWANI', '', 'DHAR', 'Gandhwani', 'रविन्द्र जैन', 'Position', '9876543210',
            '1', '0', '1', '0', '1', '0', '1', '0', '1', '0', '1', '0', '1', '0', '1', '0', '1', '0', '1', '0',
            '1', '0', '1', '0', '1', '0', '1', '0', '1', '0', '1', '0', '1', '0', '1', '0', '1', '0', '1', '0',
            '1', '0', '1', '0', '1', '0', '1', '0', '1', '0', 'Sample remark', 'Sample Lok Sabha', '2026'
        );
        
        fputcsv($output, $sample);
        fclose($output);
    }

    // Get Vidhan Sabha by District (AJAX endpoint)
    public function get_vidhan_sabhas_by_district() {
        $this->load->model('Vidhan_sabha_model');
        
        $district_id = $this->input->post('district_id');
        $vidhan_sabhas = $this->Vidhan_sabha_model->get_vidhan_sabhas_by_district($district_id);
        
        header('Content-Type: application/json');
        echo json_encode($vidhan_sabhas);
    }

    public function get_panchayats_by_block() {
        $this->load->model('Panchayat_model');
        
        $block_id = $this->input->post('block_id');
        if ($block_id) {
            $panchayats = $this->Panchayat_model->get_panchayats_by_block($block_id);
            header('Content-Type: application/json');
            echo json_encode(array('error' => false, 'panchayats' => $panchayats));
        } else {
            header('Content-Type: application/json');
            echo json_encode(array('error' => true, 'message' => 'Block ID is required'));
        }
    }

    public function get_villages_by_panchayat() {
        $this->load->model('Village_model');
        
        $panchayat_id = $this->input->post('panchayat_id');
        if ($panchayat_id) {
            $villages = $this->Village_model->get_villages_by_panchayat($panchayat_id);
            header('Content-Type: application/json');
            echo json_encode(array('error' => false, 'villages' => $villages));
        } else {
            header('Content-Type: application/json');
            echo json_encode(array('error' => true, 'message' => 'Panchayat ID is required'));
        }
    }
}
