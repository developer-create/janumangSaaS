<?php
class Booth_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // Get all booths
  public function get_booths() {
    $this->db->select('booth.*, block.name as block_name'); // Select columns from both tables
    $this->db->from('booth');
    $this->db->join('block', 'block.id = booth.blockid', 'left'); // Join block table on blockid
    $this->db->order_by('booth.year DESC, booth.blockid ASC');
    $query = $this->db->get();
    return $query->result_array();
}


   public function getvillageBypanchayat($blockId) {
   $this->db->where('panchayatid', $blockId);
    $query = $this->db->get('village');
    return $query->result_array();
}


  public function getpanchayatidByBooth($blockId) {
   $this->db->where('boothid', $blockId);
    $query = $this->db->get('panchayat');
    return $query->result_array();
}



public function getBoothsByBlock($blockId = null, $year = null) {
    $this->db->select('booth.*, block.name as block_name');
    $this->db->from('booth');
    $this->db->join('block', 'block.id = booth.blockid', 'left');
    
    if ($blockId) {
        $this->db->where('booth.blockid', $blockId);
    }
    if ($year) {
        $this->db->where('booth.year', $year);
    }
    
    $this->db->order_by('booth.year DESC, booth.blockid ASC');
    $query = $this->db->get();
    return $query->result_array();
}


    // Get a single booth by ID
    public function get_booth($id) {
        $query = $this->db->get_where('booth', array('id' => $id));
        return $query->row_array();
    }

    // Insert a new booth
    public function create_booth($data) {
        return $this->db->insert('booth', $data);
    }

    // Update a booth
    public function update_booth($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('booth', $data);
    }

    // Delete a booth
    public function delete_booth($id) {
        return $this->db->delete('booth', array('id' => $id));
    }

    // Get unique years from booth table
    public function get_unique_years() {
        $this->db->select('DISTINCT(year) as year');
        $this->db->from('booth');
        $this->db->where('year IS NOT NULL');
        $this->db->where('year !=', '');
        $this->db->order_by('year', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
}
?>
