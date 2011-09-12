<?php

class Groupteammodel extends CI_Model {

    function get($id)
    {
     	$this->db->where('id', $id);
        $query = $this->db->get('jos_bl_groups');
        return $query->row();
    }

    function delete($id)
    {
        $this->db->where('id', $id);
        if ($this->db->delete('jos_bl_groups'))
         return true;
        else
         return false;
    }

    function add($data) {
	$this->db->insert('jos_bl_grteams', $data);
        return $this->db->insert_id();
    }
	
    function get_all($id)
    {
	$this->db->where('s_id', $id);
        $query = $this->db->get('jos_bl_groups');
        return $query->result();
    }

    function get_teams($id) {
	
    }

    function save($data)
    {
	unset($data['submit']);
     	if ($data['id'] != "") {
         $this->db->where('id', $data['id']);
         $this->db->update('jos_bl_groups', $data);
         return $data['id'];
        } else {
         $this->db->insert('jos_bl_groups', $data);
         return $this->db->insert_id();
        }
    }

}
?>
