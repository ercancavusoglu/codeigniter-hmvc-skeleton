<?php
class Dashboard extends Admin_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Datatables');
    }

    public function index()
    {
        $this->data['subview'] = 'admin/dashboard/main';
        $this->load->view('common/_layouts/main', $this->data);
    }
}

