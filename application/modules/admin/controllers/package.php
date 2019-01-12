<?php
class package extends Admin_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('package_m');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('datatables');
    }

    public function index()
    {
        $this->load->helper('datatables');
        $this->load->helper("file");
        $this->data['subview'] = 'admin/package/list';
        $this->data['useDatatables'] = TRUE;
        $this->data['sAjaxSource'] = 'admin/package/datatable';
        $this->load->view('common/_layouts/main', $this->data);
    }

    public function edit($id = NULL)
    {
        $rules = $this->package_m->rules;
        $this->form_validation->set_rules($rules);

        if($this->form_validation->run() == TRUE) {

            if (!empty($_FILES['picture']['name'])) {

                $picture_name = random_string('alnum', 24) . '.' . strtolower(end(explode(".", $_FILES['picture']['name'])));

                if ($id != NULL) {
                    $package = $this->package_m->get($id);
                    if(!empty($package->picture))
                        $picture_name = $package->picture;
                }

                $config['file_name'] = $picture_name;
                $config['upload_path'] = 'assets/images/packages/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['overwrite'] = true;
                $this->load->library('upload', $config);
                $this->upload->set_allowed_types('*');
                $this->upload->initialize($config);
                $data['error'] = '';
                if (!$this->upload->do_upload('picture')) {
                    $data['error'] = array('msg' => $this->upload->display_errors());
                    //print_r($data['error']);
                    //$picture_name = '';
                } else {
                    $data = array('msg' => "Upload success!");
                    $data['upload_data'] = $this->upload->data();
                    //print_r($data['upload_data']);
                    //die;
                }
            }

            $record = array (
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'price' => $this->input->post('price'),
                'picture' => $picture_name,
                'status' => $this->input->post('status')
            );

            $rec_id = $this->package_m->save($record, $id);

            redirect('admin/package');
        }

        if ($id) {
            $this->data['package'] = $this->package_m->get($id);
            if(!file_exists('assets/images/packages/' . $this->data['package']->picture)) {
                $this->data['package']->picture = '';
            }
        }

        $this->data['subview'] = 'admin/package/edit';
        $this->load->view('common/_layouts/main', $this->data);
    }

    public function delete($id)
    {
        return;
        $this->package_m->delete($id);
        unlink('assets/images/packages/' . $id . ".jpg");
        redirect('admin/package');
    }

    function datatable()
    {
        $this->load->helper('datatables');
        $this->datatables->select("id, title, description, price, picture, status", FALSE)
            ->unset_column('id')
            ->edit_column('title', link_content('/admin/package/edit/$1', '$2'), 'id, title')
            ->edit_column('picture', show_pic(site_url('assets/images/packages/$1'), 'width: 90px; height:90px'), 'picture')
            ->add_column('actions', btn_edit('/admin/package/edit/$1'), 'id')
            ->from('packages_v2');

        $this->output->set_output($this->datatables->generate());
    }

    public function _unique_name() {
        $id = $this->input->post('id');
        $this->db->where('name', $this->input->post('name'));
        !$id || $this->db->where('id != '. $id);
        $fms = $this->package_m->get();

        if(count($fms)) {
            $this->form_validation->set_message('_unique_name', 'Bu paket adı zaten kullanılıyor!');
            return FALSE;
        }

        return TRUE;
    }

}
