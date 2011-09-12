<?php

class Homemodel extends CI_Model {

    var $CI;

    function delete($id)
    {
	$this->db->where('id', $id);
        if ($this->db->delete('employee'))
	 return true;
	else
	 return false;
    }

    function get($alias)
    {
	if ($alias == "")
		$alias = "home";
	if (is_numeric($alias))
	 $this->db->where('id', $alias);
	else
     	 $this->db->where('alias', $alias);
        
	$query = $this->db->get('jos_content');
        return $query->result();
    }

    function get_sidebar($id)
    {
	$this->db->where('page', $id);
	$query = $this->db->get('sidebar');
        return $query->result();
    }

    function get_all($limit=0, $offset=0, $s=0, $c=0, $ob="ordering", $type="ASC")
    {
	if ($s!=0)
		$this->db->where('sectionid', $s);
	if ($c!=0)
		 $this->db->where('catid', $c);
	if ($limit != 0)
	 $this->db->limit($limit, $offset);
	$this->db->where('state', 1);
	$this->db->order_by($ob, $type);
        $query = $this->db->get('jos_content');
        return $query->result();
    }

    function save($data)
    {
        if (isset($data['id'])) {
         $this->db->where('id', $data['id']);
         $this->db->update('jos_content', $data);
         return $data['id'];
        } else {
         $this->db->insert('jos_content', $data);
         return $this->db->insert_id();
        }
    }

    function save_auth($data)
    {
	$data['id'] = $data['id'];
	$data['company'] = $this->session->userdata('user')->company;
	$data['PASSWORD'] = $this->_prep_password($data['PASSWORD']);
	$this->db->set('id', $data['id']);
	$this->db->set('group', 1);
	$this->db->set('username', $data['username']);
	$this->db->set('PASSWORD', $data['PASSWORD']);
	if ($this->db->insert('authorised'))
	 return true;
	else
	 return false;
    }

    function deauth($id)
    {
	$user = $this->get($id);
	if ($user['details'][0]->company != $this->session->userdata('user')->company)
		return false;
	$this->db->where('id', $id);
        if ($this->db->delete('authorised'))
         return true;
        else
         return false;
    }

     	function _prep_password($password)
        {
        return sha1($password.$this->config->item('encryption_key'));
        }
}
?>
