<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Jansunwai extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('upload');
        date_default_timezone_set('Asia/Kolkata');
    
        $this->isLoggedIn();
      
        
    }

   

  public function upload_csv() {
       
        
            $this->global['pageTitle'] = 'Datacollector :booth';
            $this->loadViews("upload_csv", $this->global, [], NULL);
        
    }
    
    public function import_csv() {
        if (!empty($_FILES['csv_file']['name'])) {
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'csv';
            $config['file_name'] = time() . '_jansunwai.csv';

            $this->upload->initialize($config);

            if ($this->upload->do_upload('csv_file')) {
                $file_data = $this->upload->data();
                $file_path = './uploads/' . $file_data['file_name'];

                if ($this->process_csv($file_path)) {
                    $this->session->set_flashdata('success', 'CSV file imported successfully.');
                } else {
                    $this->session->set_flashdata('error', 'Failed to import CSV file.');
                }
                redirect('jansunwai/upload_csv');
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('jansunwai/upload_csv');
            }
        } else {
            $this->session->set_flashdata('error', 'Please select a CSV file.');
            redirect('jansunwai/upload_csv');
        }
    }

   private function process_csv($file_path) {
    $csv_file = fopen($file_path, 'r');

    if ($csv_file) {
        $header = fgetcsv($csv_file); // Read the first row as the header

        while (($row = fgetcsv($csv_file)) !== FALSE) {
            $data = array_combine($header, $row); // Combine header and row data

            // Map the CSV data to table columns 
            $insert_data = [
                'uname' => $data['uname'] ?? null,
                'mobile' => $data['mobile'] ?? null,
                'lat' => $data['lat'] ?? 0,
                'lng' => $data['lng'] ?? 0,
                'createdBy' => date('Y-m-d H:i:s'),
                'sector_name' => $data['sector_name'] ?? null,
                'micro_sector_no' => $data['micro_sector_no'] ?? null,
                'micro_sector_name' => $data['micro_sector_name'] ?? null,
                'year' => $data['year'] ?? null,
                'month' => $data['month'] ?? null,
                'date' =>date("Y-m-d", strtotime($data['date'])) ?? null,
                'district' => $data['district'] ?? null,
                'assembly' => $data['assembly'] ?? null,
                'booth_no' => $data['booth_no'] ?? null,
                'booth_name' => $data['booth_name'] ?? null,
                'panchayat_name' => $data['panchayat_name'] ?? null,
                'village' => $data['village'] ?? null,
                'majra_faliya' => $data['majra_faliya'] ?? null,
                'work_problem' => $data['work_problem'] ?? null,
                'address' => $data['address'] ?? null,
                'office' => $data['office'] ?? null,
                'approximate_cost' => $data['approximate_cost'] ?? 0,
                'department' => $data['department'] ?? null,
                'priority' => $data['priority'] ?? null,
                'ts_no_date' => $data['ts_no_date'] ?? null,
                'as_no_date' => $data['as_no_date'] ?? null,
                'type_of_work' => $data['type_of_work'] ?? null,
                'middle_men' => $data['middle_men'] ?? null,
                'cont_no' => $data['cont_no'] ?? null,
                'beneficial' => $data['beneficial'] ?? null,
                'po' => $data['po'] ?? null,
                'work_status' => $data['work_status'] ?? 'Incomplete',
                'remark' => $data['remark'] ?? null,
                'uploaded_file' => $data['uploaded_file'] ?? null,
                'block' => $data['block'] ?? null,
                'recommended_letter_no' => $data['recommended_letter_no'] ?? null,
                'remark_goshana' => $data['remark_goshana'] ?? null,
                'current_stage' =>2,
                'updatedBy' => $data['updatedBy'] ?? null
            ];

            // Insert data into the database
            $this->db->insert('jansunwai', $insert_data);
        }
        fclose($csv_file);
        return true;
    }
    return false;
}

}
