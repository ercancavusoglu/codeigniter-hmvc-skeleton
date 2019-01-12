<?php

class action_log_m extends MY_Model {
    protected $_table_name = 'site_action_log';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'id';
    protected $_timestamps = TRUE;
    protected $_save_timestamp_field = 'action_on';

    public function add_log($action_detail) {
        $record = array (
            'user_id' => $this->session->userdata('username'),
            'ip' => $this->session->userdata('ip_address'),
            'action_detail' => $action_detail
        );

        $this->action_log_m->save($record);
    }
} 