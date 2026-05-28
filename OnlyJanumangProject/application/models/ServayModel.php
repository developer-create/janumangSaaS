<?php
class ServayModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Insert survey data into the table
    public function insertServay($data) {
        $this->db->insert('servayapp', $data);
        return $this->db->insert_id(); // Return the inserted ID
    }

    // Get survey details by id (for editing)
    public function getServayById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('servayapp');
        return $query->row(); // Returns a single row as an associative array
    }

    // Update survey data by id
    public function updateServay($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('servayapp', $data);
    }

    // Get all surveys (for listing)
    public function getAllSurveys() {
        $query = $this->db->get('servayapp');
        return $query->result_array(); // Returns all records as an array of associative arrays
    }
}
