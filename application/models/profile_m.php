<?php
class profile_m extends MY_Model {
    protected $_table_name = 'profiles';
    protected $_primary_key = 'user_id';
    protected $_primary_key_mode = 'manual';
    protected $_order_by = 'fullname';
    protected $_timestamps = TRUE;
    protected $_update_timestamp_field = 'modified_on';
    protected $_save_timestamp_field = 'created_on';

    public $rules = array(
        'fullname' => array(
            'field' => 'fullname',
            'label' => 'Ad Soyad',
            'rules' => 'trim|required'
        ),
        'iban' => array(
            'field' => 'iban',
            'label' => 'IBAN',
            'rules' => 'trim|required'
        )
    );
}