<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_rejection_status extends CI_Migration {

    public function up() {
        // Modify jansunwai table to add Reject status
        $this->db->query("ALTER TABLE jansunwai MODIFY COLUMN work_status ENUM('Incomplete', 'In progress', 'Complete', 'Reject') DEFAULT 'Incomplete'");
    }

    public function down() {
        // Revert back to original enum values
        $this->db->query("ALTER TABLE jansunwai MODIFY COLUMN work_status ENUM('Incomplete', 'In progress', 'Complete') DEFAULT 'Incomplete'");
    }
}
