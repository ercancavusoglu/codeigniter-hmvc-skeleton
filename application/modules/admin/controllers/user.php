<?php
class User extends Admin_Controller {
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

    public function thanks() {

        $this->data['message'] = "Kayıt işleminiz yapılmıştır. Yönetici onayından sonra siteye giriş yapabileceksiniz.";
        $this->load->view('admin/user/message', $this->data);
    }

    public function unauthorized() {
        $this->data['message'] = "Kullanıcınız yönetici onayı beklemektedir.";
        $this->load->view('admin/user/message', $this->data);
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

            redirect('admin/user/thanks');
        }

        $this->load->view('admin/user/register', $this->data);
    }
/*
    public function login() {
        $this->data['meta_title'] = 'Giriş';
        $dashboard = 'admin/dashboard';
        $this->is_logged_in() == FALSE || redirect($dashboard);
        $rules = $this->user_m->rules_login;
        $this->form_validation->set_rules($rules);

        if($this->form_validation->run() == TRUE) {
            // Try login

            if (parent::login($this->input->post('username'), $this->input->post('password')) == TRUE) {
                //if($this->session->userdata('user_type') == 'dealer') {
                //    redirect('member/dashboard');
                //}

                redirect($dashboard);
            }
            else {
                $this->session->set_flashdata('error', 'Geçersiz giriş! Kullanıcı adınız yada şifreniz yanlış.');
                redirect('admin/user/login', 'refresh');
            };
        }

        $this->load->view('admin/user/login', $this->data);
    }
*/

    public function edit($id = NULL)
    {
        $this->data['subview'] = 'admin/user/edit';
        !$id || ( $this->data['user'] = $this->user_m->get($id) );

        $this->data['role_list'] = $this->role_m->get_by("status = 'active'", FALSE);

        $rules = $this->user_m->rules_user;
        $this->form_validation->set_rules($rules);

        if($this->form_validation->run() == TRUE) {
            $record = array (
                'user_type' => 'admin',
                'username' => $this->input->post('username'),
                'role_id' => $this->input->post('role'),
                'email' => $this->input->post('email'),
                'password_hash' =>  $this->user_m->hash($this->input->post('password'))
            );

            $this->user_m->save($record, $id);
            redirect('admin/user');
        }

        $this->load->view('common/_layouts/main', $this->data);
    }

    public function delete($id)
    {
        $this->user_m->delete($id);
        redirect('admin/user');
    }

    public function datatable()
    {
        $this->load->library('datatables');
        $this->load->helper('datatables');

        $this->datatables->select("u.id as id, u.username as username, ifnull(r.name, 'Süper Admin') as name", FALSE)
            ->unset_column('id')
            ->edit_column('username', link_content('/admin/user/edit/$1', '$2'), 'id, username')
            ->add_column('actions', btn_edit('/admin/user/edit/$1') . '&nbsp;' . btn_delete('/admin/user/delete/$1', TRUE), 'id')
            ->from('users as u')
            ->where("user_type = 'admin'")
            ->join('site_roles as r', 'r.id = u.role_id', 'left');

        $this->output->set_output($this->datatables->generate());
    }

    public function _unique_email() {
        $id = $this->input->post('user_id');
        $this->db->where('email', $this->input->post('email'));
        !$id || $this->db->where('id != '. $id);
        $user = $this->user_m->get();

        if(count($user)) {
            $this->form_validation->set_message('_unique_email', 'Bu email adresi zaten kullanılıyor!');
            return FALSE;
        }

        return TRUE;
    }

    public function _unique_username() {
        $id = $this->input->post('user_id');
        $this->db->where('username', $this->input->post('username'));
        !$id || $this->db->where('id != '. $id);
        $user = $this->user_m->get();

        if(count($user)) {
            $this->form_validation->set_message('_unique_username', 'Bu kullanıcı adı zaten kullanılıyor!');
            return FALSE;
        }

        return TRUE;
    }
}