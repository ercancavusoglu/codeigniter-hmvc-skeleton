<?php
class Partner extends Partner_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->root_id = ' id="organisation"';
        $this->load->model('profile_m');
        $this->load->model('hierarchy_m');
        //$this->load->helper('string');
    }

    public function index()
    {
        $this->data['useDatatables'] = TRUE;
        $this->data['subview'] = 'partner/partner/list';
        $this->data['sAjaxSource'] = 'partner/partner/datatable';
        $this->load->view('common/_layouts/main', $this->data);
    }

    public function tree($id = NULL)
    {
        $org_data = $this->get_org_data($id);
        $this->data['org_data'] = $this->nested2ul(array($this->makeRecursive($org_data,$org_data[0]['parent_id'])));
        $this->data['subview'] = 'partner/partner/tree';
        $this->load->view('common/_layouts/main', $this->data);
    }


        /*
        SELECT  hi.id, hi.parent_id, pos, ho.level, fullname as name, picture
            FROM    (
                SELECT  id, 0 AS level from users where id = '" . $this->session->userdata('user_id') . "'
                      union
                    SELECT  users_connect_by_parent_eq_prior_id(id) AS id, @level AS level
                    FROM    (
                        SELECT  @start_with := '" . $this->session->userdata('user_id') . "',
                                    @id := @start_with,
                                    @level := 0
                            ) vars, users
                    WHERE   @id IS NOT NULL
                    ) ho
            JOIN    users hi ON      hi.id = ho.id
            JOIN    profiles p ON      p.user_id = ho.id
            order by level asc"
        */

    public function datatable()
    {
        $this->load->library('datatables');
        $this->load->helper('datatables');

        $this->db->_protect_identifiers=false;
        $this->datatables->select("ho.id, fullname, pa.title, packagestatus_id", FALSE)
            ->from("(
                    SELECT  users_connect_by_parent_eq_prior_id(id) AS id, @level AS level
                    FROM    (
                        SELECT  @start_with := '" . $this->session->userdata('user_id') . "',
                                    @id := @start_with,
                                    @level := 0
                            ) vars, users
                    WHERE   @id IS NOT NULL
                    ) ho ", FALSE)
            ->join('profiles as p', 'ho.id = p.user_id', 'left outer')
            ->join('orders as o', 'ho.id = o.user_id', 'left outer')
            ->join('packages_v2 as pa', 'o.packagetype_id = pa.id', 'left outer')
            ->where('ho.id is not null');

        $this->output->set_output($this->datatables->generate());
        $this->db->_protect_identifiers=true;
    }

    public function edit() {
        $rules = $this->profile_m->rules;
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

    public function get_org_data() {
        /*
        $sql = "SELECT node.user_id as id, IFNULL(node.parent_id, 0) parent_id, 0 as pos, 0 as level, node.user_id as name, picture
                FROM hierarchy AS node, hierarchy AS parent
                WHERE node.sub_left BETWEEN parent.sub_left AND parent.sub_right
                    AND parent.user_id = '" . $id . "'
                ORDER BY node.sub_left";
*/
        $sql = "SELECT  hi.id, hi.parent_id, pos, gender, ho.level, fullname as name, picture
            FROM    (
                      SELECT  id, 0 AS level from users where id = '" . $this->session->userdata('user_id') . "'
                      union
                    SELECT  users_connect_by_parent_eq_prior_id(id) AS id, @level AS level
                    FROM    (
                            SELECT  @start_with := '" . $this->session->userdata('user_id') . "',
                                    @id := @start_with,
                                    @level := 0
                            ) vars, users
                    WHERE   @id IS NOT NULL
                    ) ho
            JOIN    users hi ON      hi.id = ho.id
            JOIN    hierarchy h ON      h.user_id = ho.id
            JOIN    profiles p ON      p.user_id = ho.id
            order by level asc";

        $result = $this->db->query($sql);

        return $result->result_array();
    }

    public function makeRecursive($d, $r = 0, $pk = 'parent_id', $k = 'id', $c = 'children') {
        $m = array();
        foreach ($d as $e) {
            isset($m[$e[$pk]]) ?: $m[$e[$pk]] = array();
            isset($m[$e[$k]]) ?: $m[$e[$k]] = array();
            $m[$e[$pk]][] = array_merge($e, array($c => &$m[$e[$k]]));
        }

        return $m[$r][0]; // remove [0] if there could be more than one root nodes
    }

    public function nested2ul($orgData) {
        $result = array();

        if (sizeof($orgData) > 0) {
            $result[] = '<ul' . $this->root_id . '>';
            $this->root_id = '';
            foreach ($orgData as $entry) {
                $result[] = sprintf(
                    '<li class="node" data-level="' . $entry['level'] . '" data-pos="' . $entry['pos'] . '" id="' . $entry['id'] . '">%s %s %s</li>',
                    '<img class="musteri ' . ($entry['gender'] == 1 ? 'kadin' : 'erkek' ) . '" title="' . $entry['name'] . '" src="' . site_url('assets/img/members/' . (empty($entry['picture']) ? ($entry['gender'] == 1 ? 'women.jpg' : 'men.jpg' ) : $entry['picture'] ) . '"/><br>'),
                    $entry['name'],
                    $this->nested2ul($entry['children'])
                );
            }
            $result[] = '</ul>';
        }

        return implode($result);
    }
}
