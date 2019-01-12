<?php
class MY_Model extends CI_Model {
    protected $_table_name = '';
    protected $_primary_key = 'id';
    protected $_primary_key_mode = 'auto';
    protected $_primary_filter = 'intval';
    protected $_order_by = '';
    public $_rules = array();
    protected $_timestamps = FALSE;
    protected $_update_timestamp_field = '';
    protected $_save_timestamp_field = '';

    function __construct() {
        parent::__construct();
    }

    public function get_fields($id = NULL, $fields = NULL , $single = FALSE) {
        if ($id != NULL) {
            $filter = $this->_primary_filter;
            $id = $filter($id);
            $this->db->where($this->_primary_key, $id);
            $method = 'row';
        }
        elseif ($single == TRUE) {
            $method = 'row';
        }
        else {
            $method = 'result';
        }
        if ($fields != NULL) {
            $this->db->select($fields, FALSE);
        }

        if(!count($this->db->ar_orderby)) {
            $this->db->order_by($this->_order_by);
        }
        return $this->db->get($this->_table_name)->$method();
    }

    public function get($id = NULL, $single = FALSE) {
        if ($id != NULL) {
            $filter = $this->_primary_filter;
            $id = $filter($id);
            $this->db->where($this->_primary_key, $id);
            $method = 'row';
        }
        elseif ($single == TRUE) {
            $method = 'row';
        }
        else {
            $method = 'result';
        }

        if(!count($this->db->ar_orderby)) {
            $this->db->order_by($this->_order_by);
        }
        return $this->db->get($this->_table_name)->$method();
    }

    public function get_by($where, $single = TRUE) {
        $this->db->where($where);
        return $this->get(NULL, $single);
    }

    public function save($data, $id = NULL) {
        if ($this->_timestamps == TRUE) {
            $now = date('Y-m-d H:i:s');
            $id || $data[$this->_save_timestamp_field] = $now;
            $this->_update_timestamp_field == '' || $data[$this->_update_timestamp_field] = $now;
        }

        //Insert
        if ($id === NULL) {
            !($this->_primary_key_mode == 'auto' && isset($data[$this->_primary_key])) || $data[$this->_primary_key] = NULL;

            $this->db->set($data);
            $this->db->insert($this->_table_name);
            $id = $this->db->insert_id();
        }
        //Update
        else {
            $filter = $this->_primary_filter;
            $id = $filter($id);
            $this->db->set($data);
            $this->db->where($this->_primary_key, $id);
            $this->db->update($this->_table_name);
        }

        return $id;
    }

    public function delete($id) {
        if (!$id) return FALSE;

        $filter = $this->_primary_filter;
        $id = $filter($id);

        $this->db->where($this->_primary_key, $id);
        $this->db->limit(1);
        $this->db->delete($this->_table_name);

    }
} 