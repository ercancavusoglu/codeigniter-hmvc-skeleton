<?php
class User extends Authenticated_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->data['useDatatables'] = TRUE;
        $this->data['subview'] = 'admin/user/list';
        $this->data['sAjaxSource'] = 'admin/user/datatable';
        $this->load->view('common/_layouts/main', $this->data);
    }

    public function login() {

        $rules = $this->user_m->rules_login;
        $this->form_validation->set_rules($rules);

        if($this->form_validation->run() == TRUE || $this->is_logged_in() == TRUE) {
            // Try login

            if (parent::login($this->input->post('username'), $this->input->post('password')) == TRUE) {
                redirect($this->session->userdata('user_type') . '/dashboard');
            }
            else {
                $this->data['error'] = 'Geçersiz giriş! Kullanıcı adınız yada şifreniz yanlış.';
                //redirect('public/user/login', 'refresh');
                $this->session->sess_destroy();
                //die;
            };
        }

        $this->data['meta_title'] = 'Giriş';
        $this->load->view('public/user/login', $this->data);
    }

    public function logout() {
        parent::logout();
        redirect('public/user/login');
    }

}