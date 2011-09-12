<?php

class Suggestionmodel extends CI_Model {

    function get($id)
    {
     	$this->db->where('id', $id);
        $query = $this->db->get('suggestions');
        return $query->row();
    }

    function delete($id)
    {
        $this->db->where('id', $id);
        if ($this->db->delete('suggestions'))
         return true;
        else
         return false;
    }
	
    function get_all()
    {
//	$this->db->where("owner", user_id());
        $query = $this->db->get('suggestions');
        return $query->result();
    }

    function save($data)
    {
	unset($data['submit']);
     	if ($data['id'] != "") {
         $this->db->where('id', $data['id']);
         $this->db->update('suggestions', $data);
         return $data['id'];
        } else {
	 $data['owner'] = user_id();
         $this->db->insert('suggestions', $data);
         return $this->db->insert_id();
        }
    }

}
?>
