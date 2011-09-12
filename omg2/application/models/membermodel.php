<?php

class Membermodel extends CI_Model {

    var $CI;

    function delete($id)
    {
	$this->db->where('id', $id);
        if ($this->db->delete('employee'))
	 return true;
	else
	 return false;
    }

    function get($id)
    {
	$this->db->where('id', $id);
	$query = $this->db->get('members');
        return $query->result();
    }

    function get_all()
    {
        $query = $this->db->get('members');
        return $query->result();
    }

    function save($data)
    {
	unset($data['submit']);
        if ($data['id'] != "") {
         $this->db->where('id', $data['id']);
         $this->db->update('members', $data);
         return $data['id'];
        } else {
         $this->db->insert('members', $data);
         return $this->db->insert_id();
        }
    }

     	function _prep_password($password)
        {
        return sha1($password.$this->config->item('encryption_key'));
        }
}
?>
