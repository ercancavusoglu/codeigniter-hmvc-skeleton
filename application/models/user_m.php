<?php
class user_m extends MY_Model {
    protected $_table_name = 'users';
    protected $_order_by = 'username';
    protected $_timestamps = TRUE;
    protected $_login_timestamp_field = 'last_login';
    protected $_update_timestamp_field = 'modified_on';
    protected $_save_timestamp_field = 'created_on';

    public $rules_login = array(
        'username' => array(
            'field' => 'username',
            'label' => 'Kullanıcı Adı',
            'rules' => 'trim|required'
        ),
        'password' => array(
            'field' => 'password',
            'label' => 'Şifre',
            'rules' => 'trim|required'
        )
    );

    public $rules_admin = array(
        'username' => array(
            'field' => 'username',
            'label' => 'Kullanıcı Adı',
            'rules' => 'trim|required|callback__unique_username'
        ),
        'password' => array(
            'field' => 'password',
            'label' => 'Şifre',
            'rules' => 'trim|matches[password_confirm]'
        ),
        'password' => array(
            'field' => 'password_confirm',
            'label' => 'Şifre (Tekrar)',
            'rules' => 'trim|matches[password]'
        )
    );

    public $rules_profile = array(
    );

    public $rules_member = array(
        'email' => array(
            'field' => 'email',
            'label' => 'E-mail',
            'rules' => 'trim|required'
        ),
        'password' => array(
            'field' => 'password',
            'label' => 'Şifre',
            'rules' => 'trim|matches[password_confirm]'
        ),
        'password' => array(
            'field' => 'password_confirm',
            'label' => 'Şifre (Tekrar)',
            'rules' => 'trim|matches[password]'
        )
    );

    public function on_login($user) {
        $backup = $this->_update_timestamp_field;
        $this->_update_timestamp_field = $this->_login_timestamp_field;
        $data = array (
        'last_ip' => $this->session->userdata('ip_address')
        );
        $this->save($data, $user->id);
        $this->_update_timestamp_field = $backup;
    }

    public function hash($string) {
        //return hash('sha512', $string . config_item('encrpytion_key'));
		return md5($string);
    }
}