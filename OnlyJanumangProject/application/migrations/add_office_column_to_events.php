<?php

class Migration_Add_office_column_to_events extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_column('events', array(
            'office' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE,
                'default' => 'NA'
            )
        ));
    }

    public function down()
    {
        $this->dbforge->drop_column('events', 'office');
    }
}
?>
