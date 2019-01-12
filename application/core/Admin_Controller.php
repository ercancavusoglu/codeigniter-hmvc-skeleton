<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
class Admin_Controller extends Authenticated_Controller {
    public $context = 'admin';

    public function __construct()
    {
        parent::__construct();

        $this->load->model('role_m');
        $this->data['meta_title'] = 'Admin Paneli';
        $this->data['useDatatables'] = FALSE;

        $this->data['modules'] = array(
            'dashboard' =>      array('title' => 'Dashboard',            'icon' => 'dashboard',      'perm_req' => FALSE),
            'tree' =>       array('title' => 'Paketler',       'icon' => 'paket.png',               'perm_req' => FALSE),
            'member' =>         array('title' => 'Ortak Yönetimi',         'icon' => '',               'perm_req' => TRUE),
            'package' =>       array('title' => 'Paketler 1',       'icon' => 'paket.png',               'perm_req' => TRUE)
        );

        $this->check_permission();
        $this->data['active_module'] = $this->router->fetch_class();

        $leftmenu_base = array(
            array('title' => 'Ortaklar', 'subitems' => array(
                array('module' => 'member'),
                array('title' => 'Yeni Üyeler', 'module' => 'member', 'action' => 'new_members')
            )),
            array('module' => 'package')
        );


        $this->data['leftmenu'] = $this->filter_menu_items($leftmenu_base);
    }
}