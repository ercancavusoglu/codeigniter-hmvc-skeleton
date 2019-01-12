<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
class Partner_Controller extends Authenticated_Controller {
    public $context = 'partner';

    public function __construct()
    {
        parent::__construct();

        $this->load->model('role_m');
        $this->data['meta_title'] = 'Ortak Paneli';
        $this->data['useDatatables'] = FALSE;

        $this->data['modules'] = array(
            'dashboard' =>      array('title' => 'Dashboard',            'icon' => '',      'perm_req' => FALSE),
            'partner' =>         array('title' => 'Ortaklar',         'icon' => 'uye.png',               'perm_req' => FALSE)
        );

        $this->check_permission();
        $this->data['active_module'] = $this->router->fetch_class();

        $leftmenu_base = array(
            array('title' => 'Profilim', 'icon' => 'bilgi.png',  'module' => 'partner', 'action' => 'edit'),
            array('module' => 'partner'),
            array('title' => 'Ağaç Gösterimi', 'module' => 'partner', 'action' => 'tree')
        );

        $this->data['leftmenu'] = $this->filter_menu_items($leftmenu_base);
    }

}