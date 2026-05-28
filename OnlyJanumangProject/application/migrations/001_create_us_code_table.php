<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_us_code_table extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ),
            'code' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'unique' => TRUE
            ),
            'description' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ),
            'status' => array(
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1
            ),
            'created_by' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ),
            'created_at' => array(
                'type' => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP'
            ),
            'updated_by' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ),
            'updated_at' => array(
                'type' => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
                'on_update' => 'CURRENT_TIMESTAMP'
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('us_code');

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

        $this->db->insert_batch('us_code', $codes);
    }

    public function down() {
        $this->dbforge->drop_table('us_code');
    }
}
?>
