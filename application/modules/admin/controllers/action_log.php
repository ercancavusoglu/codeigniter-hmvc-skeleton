<?php
class Action_log extends Admin_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('action_log_m');
        $this->load->library('datatables');
    }

    public function index()
    {
        $this->load->helper('datatables');
        $this->data['subview'] = 'admin/action_log/list';
        $this->data['useDatatables'] = TRUE;
        $this->data['sAjaxSource'] = 'admin/action_log/datatable';
        $this->load->view('common/_layouts/main', $this->data);
    }

    function datatable()
    {
        $this->load->helper('datatables');
        $this->datatables->select("DATE_FORMAT(action_on, '%d.%m.%Y %H:%i:%s') as action_on, user_id, ip, action_detail", FALSE)
            ->from('site_action_log');

        $this->output->set_output($this->datatables->generate());
    }
}
