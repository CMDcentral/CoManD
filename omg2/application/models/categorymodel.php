<?php

class Categorymodel extends CI_Model {

    function get($id)
    {
	if (is_numeric($id))
	     	$this->db->where('id', $id);
	else
		$this->db->where('alias', $id);
        $query = $this->db->get('jos_categories');
        return $query->row();
    }

    function delete($id)
    {
        $this->db->where('id', $id);
        if ($this->db->delete('jos_categories'))
         return true;
        else
         return false;
    }
	
    function get_all()
    {
        $query = $this->db->get('jos_categories');
        return $query->result();
    }

    function save($data)
    {
	unset($data['submit']);
     	if ($data['id'] != "") {
         $this->db->where('id', $data['id']);
         $this->db->update('jos_categories', $data);
         return $data['id'];
        } else {
         $this->db->insert('jos_categories', $data);
         return $this->db->insert_id();
        }
    }

}
?>
