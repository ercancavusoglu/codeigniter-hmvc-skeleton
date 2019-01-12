<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_tables extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'userid' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'password' => array(
                'type' => 'VARCHAR',
                'constraint' => '128',
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'surname' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
        ));

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('users');

        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'address' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'status' => array(
                'type' => 'VARCHAR',
                'constraint' => '10',
            ),
        ));

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('fms');
    }

    public function down()
    {
        $this->dbforge->drop_table('users');
        $this->dbforge->drop_table('fms');
    }
}