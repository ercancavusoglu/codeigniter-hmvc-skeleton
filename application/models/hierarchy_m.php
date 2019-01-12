<?php
class hierarchy_m extends MY_Model {
    protected $_table_name = 'hierarchy';
    protected $_primary_key = 'user_id';
    protected $_primary_key_mode = 'manual';
    protected $_order_by = 'user_id';
    protected $_timestamps = FALSE;
}