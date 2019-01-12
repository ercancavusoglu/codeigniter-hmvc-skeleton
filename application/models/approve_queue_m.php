<?php

class approve_queue_m extends MY_Model {
    protected $_table_name = 'site_approve_queue';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'id';
    protected $_timestamps = TRUE;
    protected $_save_timestamp_field = 'queued_on';
}