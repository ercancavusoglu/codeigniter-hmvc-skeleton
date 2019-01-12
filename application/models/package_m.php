<?php

class package_m extends MY_Model {
    protected $_table_name = 'packages_v2';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'title';

    public $rules = array(
        'title' => array(
            'field' => 'title',
            'label' => 'Başlık',
            'rules' => 'trim|required'
        ),
        'description' => array(
            'field' => 'description',
            'label' => 'Açıklama',
            'rules' => 'trim|required'
        ),
        'address' => array(
            'field' => 'price',
            'label' => 'Hediye Süre',
            'rules' => 'trim|required'
        ),
        'address' => array(
            'field' => 'status',
            'label' => 'Durum',
            'rules' => ''
        )
    );
} 