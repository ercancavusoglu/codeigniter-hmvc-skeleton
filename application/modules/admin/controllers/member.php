<?php
class Member extends Admin_Controller {
    const UPLOAD_PATH = 'assets/img/members/';
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
        $this->data['subview'] = 'admin/member/list';
        $this->data['sAjaxSource'] = 'admin/member/datatable';
        $this->load->view('common/_layouts/main', $this->data);
    }

    public function new_members()
    {
        $this->data['useDatatables'] = TRUE;
        $this->data['subview'] = 'admin/member/list';
        $this->data['sAjaxSource'] = 'admin/member/datatable_new';
        $this->load->view('common/_layouts/main', $this->data);
    }

    public function edit($id = NULL)
    {
        $rules = $this->user_m->rules_member;
        $this->form_validation->set_rules($rules);

        if($this->form_validation->run() == TRUE) {
            $parent_id = $this->input->post('parent_id');
            $parent_id = (!empty($parent_id) ? $this->input->post('parent_id') : 0);
            $pos = NULL;

            $user_data = array (
                'parent_id' => $parent_id,
                'username' => $this->input->post('email'),
                'email' => $this->input->post('email'),
                'status' => $this->input->post('status')
            );

            $password = $this->input->post('password');
            if (!empty($password)) {
                $user_data = array_merge($user_data , array ('password_hash' => $this->user_m->hash($password)));
            }
            $pkid = $this->user_m->save($user_data, $id);

            $profile_data = array(
                'user_id' => $pkid,
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

            if (!empty($_FILES['picture']['name'])) {
                $picture_name = $pkid . '_' .  random_string('alnum', 24) . '.' . strtolower(end(explode(".", $_FILES['picture']['name'])));

                if ($id != NULL) {
                    $profile = $this->profile_m->get($id);

                    if(!empty($profile->picture) && file_exists (Member::UPLOAD_PATH . $profile->picture)) {
                        unlink(Member::UPLOAD_PATH . $profile->picture);
                    }
                }

                $config['file_name'] = $picture_name;
                $config['upload_path'] = Member::UPLOAD_PATH;
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

                    $profile_data = array_merge($profile_data , array ('picture' => $picture_name));
                }
            }
            $this->profile_m->save($profile_data, $id);

            if($parent_id != NULL) {
                $pos = $this->user_m->get($parent_id)->coworkers + 1;
                $sql = "update users set coworkers = coworkers + 1 where id = " . $parent_id;
                $this->db->query($sql);

            }

            $record = array (
                'user_id' => $pkid,
                'parent_id' => $parent_id,
                'pos' => $pos
            );
            $this->hierarchy_m->save($record, $id);

            redirect('admin/member');
        }

        $member_list_sql = "select p.user_id, p.fullname from users as u, profiles as p where u.id = p.user_id order by fullname" ; //" and u.coworkers < 2

        if ($id != NULL) {
            $this->data['member'] = $this->user_m->get($id);
            $this->data['profile'] = $this->profile_m->get($id);
            //$member_list_sql .= " and u.id != " . $id;
        };

        $result = $this->db->query($member_list_sql);
        $this->data['member_list'] = $result->result();

        $this->data['subview'] = 'admin/member/edit';
        $this->load->view('common/_layouts/main', $this->data);
    }

    public function tree($id = NULL)
    {
        $org_data = $this->get_org_data($id);
        $this->data['org_data'] = $this->nested2ul(array($this->makeRecursive($org_data,$org_data[0]['parent_id'])));
        $this->data['subview'] = 'admin/member/tree';
        $this->load->view('common/_layouts/main', $this->data);
    }

    public function delete($id)
    {
        $member = $this->user_m->get($id);
        if (!empty($member->parent_id)) {
            $sql = "update users set coworkers = coworkers - 1 where id = " . $member->parent_id;
            $this->db->query($sql);
        }

        $this->user_m->delete($id);
        $this->profile_m->delete($id);
        $this->hierarchy_m->delete($id);
        redirect('admin/member');
    }

    public function datatable()
    {
        $this->load->library('datatables');
        $this->load->helper('datatables');

        $this->datatables->select("id, p.fullname as fullname, email, status", FALSE)
            ->edit_column('fullname', link_content('/admin/member/edit/$1', '$2'), 'id, fullname')
            ->add_column('actions', btn_edit('/admin/member/edit/$1') . '&nbsp;' . btn_delete('/admin/member/delete/$1', TRUE), 'id')
            ->from('users as u')
            ->join('profiles as p', 'u.id = p.user_id', 'left')
            ->where("user_type = 'partner' and status = 'active'");

        $this->output->set_output($this->datatables->generate());
    }

    public function datatable_new()
    {
        $this->load->library('datatables');
        $this->load->helper('datatables');

        $this->datatables->select("id, p.fullname as fullname, email, status", FALSE)
            ->edit_column('fullname', link_content('/admin/member/edit/$1', '$2'), 'id, fullname')
            ->add_column('actions', btn_edit('/admin/member/edit/$1') . '&nbsp;' . btn_delete('/admin/member/delete/$1', TRUE), 'id')
            ->from('users as u')
            ->join('profiles as p', 'u.id = p.user_id', 'left')
            ->where("user_type = 'partner' and status = 'pending'");

        $this->output->set_output($this->datatables->generate());
    }

    public function get_org_data($id = 1) {
        /*
        $sql = "SELECT node.user_id as id, IFNULL(node.parent_id, 0) parent_id, 0 as pos, 0 as level, node.user_id as name, picture
                FROM hierarchy AS node, hierarchy AS parent
                WHERE node.sub_left BETWEEN parent.sub_left AND parent.sub_right
                    AND parent.user_id = '" . $id . "'
                ORDER BY node.sub_left";
*/
        $sql = "SELECT  hi.id, hi.parent_id, pos, ho.level, fullname as name, picture
            FROM    (
                      SELECT  id, 0 AS level from users where id = '" . $id . "'
                      union
                    SELECT  users_connect_by_parent_eq_prior_id(id) AS id, @level AS level
                    FROM    (
                            SELECT  @start_with := '" . $id . "',
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

    public function get_org_data_() {
        $orgData[] = array('id' => 1, 'parent_id' => 0, 'level' => 0,  'pos' => 1, 'name' => 'Müşteri 1');

        $max_depth = 4;
        $parents = array(1);
        $new_parents = array();
        $children_count = 2;
        $id = 2;

        $pos = 1;
        for ($depth = 1; $depth <= $max_depth; $depth++) {
            foreach ($parents as $parent) {
                //echo 'parent: ' . $parent;
                for ($k = 1; $k <= $children_count; $k++) {
                    $orgData[$id] = array('id' => $id, 'parent_id' => $parent,'level' => $depth, 'pos' => ($depth == $max_depth ? $pos++ : '') , 'name' => ($depth == $max_depth ? 'Satış' : 'Müşteri ' . $id ));
                    $new_parents[] = $id;

                    ++$id;
                }
            }
            $pos = 1;
            $parents = $new_parents;
            $new_parents = array();
        }
        return $orgData;
    }

    public function find_parent_by_level($id, $level, $orgData) {
        $curr_id = $id;
        $parent_id = $orgData[$id]['parent'];

        for ($i = 1; $i <= $level; $i++) {
            $parent_id = $orgData[$curr_id]['parent'];
            $curr_id = $parent_id;
        }

        return $parent_id;
    }

    public function get_peers_($id, $orgData) {
        $level =  $orgData[$id]['level'];
        $pos =  $orgData[$id]['pos'];
        $peers = array();

        for ($i = 1; $i <= $level; $i++) {
            $lindex = $level - $i;
            $pow = pow(2, $i - 1);
            $count = $pow * 2;

            if ($i == 1) {
                $peers[$lindex] = ($pos % 2 == 0 ? $pos - 1 : $pos + 1 );
            } else {
                if (($pos % $count) <= ($pow)) {
                    $peers[$lindex] = $pos + $pow;
                } else {
                    $peers[$lindex] = $pos - $pow;
                }
            }

            //echo 'level: ' . $lindex . ' pos: ' . $pos . ' count: ' . $count . ' pow: ' . $pow . ' (pos % count): ' . $pos % $count . ' peer: ' . $peers[$lindex] . '<br>';
            echo 'level: ' . $lindex . ' peer: ' . $peers[$lindex] . ' boss: ' . find_parent_by_level($id, $i, $orgData) . '<br>';
        }

        return $peers;
    }

    public function get_peers($id, $orgData) {


        $mod4 = array(-2 , 2, 2, -2);
        $level =  $orgData[$id]['level'];
        $pos =  $orgData[$id]['pos'];
        $peers = array();

        for ($i = 1; $i <= $level; $i++) {
            $lindex = $level - $i;

            $pow = pow(2, $i - 1);

            $count = $pow * 2;
            if ($pos % $count == 0) {
                $peers[$lindex] = $pos - $pow;
                //} else if ($i == 1) {
                //    $peers[$lindex] = ($pos % 2 == 0 ? $pos - 1 : $pos + 1 );
            } else {

                if (($pos % $count) <= ($pow)) {
                    $peers[$lindex] = $pos + $pow;
                } else {
                    $peers[$lindex] = $pos - $pow;
                }
            }

            //echo 'level: ' . $lindex . ' pos: ' . $pos . ' count: ' . $count . ' pow: ' . $pow . ' (pos % count): ' . $pos % $count . ' peer: ' . $peers[$lindex] . '<br>';
        }

        return $peers;
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
                    '<li class="big" data-level="' . $entry['level'] . '" data-pos="' . $entry['pos'] . '" id="' . $entry['id'] . '">%s<a href="../edit/' . $entry['id'] . '">%s</a> %s</li>',
                    (!empty($entry['picture']) ? '<img title="' . $entry['name'] . '" src="' . site_url('assets/img/members/' . $entry['picture']) . '"/><br>' : ''),
                    $entry['name'],
                    $this->nested2ul($entry['children'])
                );
            }
            $result[] = '</ul>';
        }

        return implode($result);
    }

    public function _unique_name() {
        $id = $this->input->post('id');
        $this->db->where('name', $this->input->post('username'));
        !$id || $this->db->where('id != '. $id);
        $member = $this->user_m->get();

        if(count($member)) {
            $this->form_validation->set_message('_unique_name', 'Bu üye adı zaten kullanılıyor!');
            return FALSE;
        }

        return TRUE;
    }

    public function _unique_display_name() {
        $id = $this->input->post('id');
        $this->db->where('name', $this->input->post('nickname'));
        !$id || $this->db->where('id != '. $id);
        $member = $this->user_m->get();

        if(count($member)) {
            $this->form_validation->set_message('_unique_name', 'Bu üye adı zaten kullanılıyor!');
            return FALSE;
        }

        return TRUE;
    }
}
