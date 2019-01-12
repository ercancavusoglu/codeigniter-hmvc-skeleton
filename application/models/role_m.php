<?php

class role_m extends MY_Model {
    protected $_table_name = 'site_roles';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'name';

    public $rules = array(
        'name' => array(
            'field' => 'name',
            'label' => 'Role Adı',
            'rules' => 'trim|required|callback__unique_name'
        ),
        'status' => array(
            'field' => 'status',
            'label' => 'Durum',
            'rules' => ''
        )
    );
} 