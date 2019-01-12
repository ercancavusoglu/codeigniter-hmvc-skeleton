<?php
class Profile extends Partner_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('profile_m');
        //$this->load->helper('string');
    }

    public function edit() {
        $rules = $this->user_m->rules_member;
        $this->form_validation->set_rules($rules);
        $id = $this->session->userdata('user_id');

        if($this->form_validation->run() == TRUE) {
            if (!empty($_FILES['picture']['name'])) {
                $picture_name = random_string('alnum', 24) . '.' . strtolower(end(explode(".", $_FILES['picture']['name'])));

                if ($id != NULL) {
                    $profile = $this->profile_m->get($id);

                    if(!empty($profile->picture))
                        $picture_name = $profile->picture;
                }

                //$picture_name = $pkid . '_' . random_string('alnum', 16) . ".jpg";
                $config['file_name'] = $picture_name;
                $config['upload_path'] = 'assets/images/members/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['overwrite'] = true;
                $this->load->library('upload', $config);
                $this->upload->set_allowed_types('*');
                $this->upload->initialize($config);
                $data['error'] = '';
                if (!$this->upload->do_upload('picture')) {
                    $data['error'] = array('msg' => $this->upload->display_errors());
                } else {
                    $data = array('msg' => "Upload success!");
                    $data['upload_data'] = $this->upload->data();
                }
            }

            $record = array (
                'picture' => $picture_name,
                'fullname' => $this->input->post('fullname'),
                'gender' => $this->input->post('gender'),
                'idnumber' => $this->input->post('idnumber'),
                'birthdate' => date('Y-m-d',date_create_from_format("d/m/Y", $this->input->post('birthdate'))->getTimestamp()),
                'gender' => $this->input->post('gender'),
                'iban' => $this->input->post('iban'),
                'phonenumber' => $this->input->post('phonenumber'),
                'address1' => $this->input->post('address1'),
                'address2' => $this->input->post('address2'),
                'district' => $this->input->post('district'),
                'city' => $this->input->post('city'),
                'country' => $this->input->post('country')
            );
            $this->profile_m->save($record, $id);
        }

        if ($id != NULL) {
            $this->data['profile'] = $this->profile_m->get($id);
        };

        $this->data['subview'] = 'partner/partner/edit';
        $this->load->view('common/_layouts/main', $this->data);
    }
}
