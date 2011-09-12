<?php

class Activitymodel extends CI_Model {

    function get($id="", $lastId="") {
        $this->db->order_by('added', "DESC");
        $this->db->limit(15);

	if ($id != "")
	        $this->db->where("owner", $id);
	if ($lastId != "") {
		$this->db->where("id <", $lastId);
	}
        $query = $this->db->get("log");
        return $query->result();
    }

    function delete($id)
    {
        $this->db->where('id', $id);
     	$this->db->where('owner', user_id());
        if ($this->db->delete('log'))
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
