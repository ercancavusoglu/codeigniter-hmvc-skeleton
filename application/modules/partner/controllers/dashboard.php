<?php
class Dashboard extends Partner_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Datatables');
    }

    public function index()
    {
        $this->data['subview'] = 'partner/dashboard/main';
        $this->load->view('common/_layouts/main', $this->data);
    }
}

