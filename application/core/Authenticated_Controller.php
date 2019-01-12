<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
class Authenticated_Controller extends MY_Controller {
    public $context = '';
    public $exception_uris;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_m');
        $this->load->model('profile_m');
        $this->load->library('session');
        $this->data['context'] = $this->context;

        //$this->exception_uris = array('public/');
        if (strpos(uri_string(), 'public/') === 0) {
            return;
        }

        if($this->is_logged_in() == FALSE && (uri_string() != 'public/user/login'))  {
            redirect('public/user/login');
        }

        if ($this->session->userdata('user_type') != $this->context) {
            redirect($this->session->userdata('user_type') . '/dashboard');
        }
    }

    protected function get_data($user) {
        $phpdate = strtotime( $user->last_login );
        $profile = $this->profile_m->get($user->id);
        return array(
            'fullname' => $profile->fullname,
            'picture' => $profile->picture,
            'user_id' => $user->id,
            'user_type' => $user->user_type,
            'username' => $user->username,
            'display_name' => $user->nickname,
            'role_id' => $user->role_id,
            'role_name' => '',
            'email' => $user->email,
            'last_login' => date('d.m.Y H:i', $phpdate),
            'last_ip' => $user->last_ip,
            'loggedin' => TRUE,
            'granted_permissions' => array(),
            'status' => $user->status
        );
    }

    protected function login($username, $password) {
        $user = $this->user_m->get_by(array(
            'username' => $username,
            'password_hash' => $this->user_m->hash($password)
        ), FALSE);

        if (count($user) > 0) {
            $this->load->model('user_m');
            if ((isset($user->status) && ($user->status == 'pending'))) {
                $this->session->sess_destroy();
                redirect('public/user/unauthorized');
                return FALSE;
            }

            if ((isset($user->status) && ($user->status == 'rejected' || $user->status == 'banned' || $user->status == 'suspended'))) {
                // redirect to ban/reject page
                $this->session->sess_destroy();
                redirect('public/user/unauthorized');
                return FALSE;
            }

            $data = $this->get_data($user[0]);



            $this->session->set_userdata($data);
            $this->user_m->on_login($user);
            return TRUE;
        }

        return FALSE;
    }

    protected function decode_permissions ($permissions) {
        $modules_raw = explode('|', $permissions);

        $new_array = array();
        foreach ($modules_raw as $perms_raw) {
            $tmp_array = explode(':', $perms_raw);
            $new_array[$tmp_array[0]] = (count($tmp_array) > 1 ? array() : TRUE );
            foreach (array_slice ( $tmp_array , 1) as $perm) {
                $new_array[$tmp_array[0]][$perm] = TRUE;
            }
        }

        return $new_array;
    }

    public function thanks() {
        $this->data['message'] = "Kayıt işleminiz yapılmıştır. Yönetici onayından sonra siteye giriş yapabileceksiniz.";
        $this->load->view('public/user/message', $this->data);
    }

    public function unauthorized() {
        $this->data['message'] = "Kullanıcınız yönetici onayı beklemektedir.";
        $this->load->view('public/user/message', $this->data);
    }

    public function register() {
        $this->data['meta_title'] = 'Kayıt Formu';
        $rules = $this->user_m->rules_user_register;
        $this->form_validation->set_rules($rules);

        if($this->form_validation->run() == TRUE) {
            $record = array (
                'username' => $this->input->post('email'),
                'email' => $this->input->post('email'),
                'password_hash' =>  $this->user_m->hash($this->input->post('password'))
            );

            $this->user_m->save($record);

            redirect('public/user/thanks');
        }

        $this->load->view('public/user/register', $this->data);
    }

    protected function check_permission() {
        if (!$this->has_permission($this->router->fetch_class())) {
            echo "Bu sayfaya erişmeye yetkili degilsiniz!";
            die;
        } else return TRUE;
    }

    protected function filter_menu_items($menu) {
        foreach ($menu as $key => $item) {
            if (isset($item['module']) && (!isset($this->data['modules'][$item['module']]) || !$this->has_permission($item['module']))) {
                unset($menu[$key]);
            }

            if (isset($item['subitems'])) {
                $menu[$key]['subitems'] = $this->filter_menu_items($item['subitems']);
            }
        }
        return $menu;
    }

    protected function has_permission($module, $action = NULL) {
        if (!$this->data['modules'][$module]['perm_req'] || $this->session->userdata('role_id') == 0) return TRUE;
        $result = FALSE;
        $permissions = $this->session->userdata('granted_permissions');

        if ($action == NULL) {
            $result = (isset($permissions[$module]) == TRUE ? TRUE : FALSE);
        } else {
            $result = isset($permissions[$module][$action]) == TRUE;
        }

        return $result;
    }

    protected function is_logged_in() {
        return (bool) $this->session->userdata('loggedin');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('public/user/login');
    }
}
