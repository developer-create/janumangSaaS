<?php
class Village_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // Get all villages
  public function get_villages() {
    $this->db->select('village.*, block.name as block_name, booth.name as booth_name, booth.year, panchayat.name as panchayat_name');
    $this->db->from('village');
    $this->db->join('block', 'village.blockid = block.id');
    $this->db->join('booth', 'village.boothid = booth.id');
    $this->db->join('panchayat', 'village.panchayatid = panchayat.id');
    $query = $this->db->get();
    return $query->result_array();
}

    // Get a single village by ID
    public function get_village($id) {
        $query = $this->db->get_where('village', array('id' => $id));
        return $query->row_array();
    }

    // Insert a new village
    public function create_village($data) {
        return $this->db->insert('village', $data);
    }

    // Update a village
    public function update_village($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('village', $data);
    }

    // Delete a village
    public function delete_village($id) {
        return $this->db->delete('village', array('id' => $id));
    }

    // Get villages by panchayat ID
    public function get_villages_by_panchayat($panchayat_id) {
        $this->db->select('*');
        $this->db->from('village');
        $this->db->where('panchayatid', $panchayat_id);
        $query = $this->db->get();
        return $query->result_array();
    }
}
?>
