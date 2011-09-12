<?php

class Gamemodel extends CI_Model {

    function get($id)
    {
     	$this->db->where('id', $id);
        $query = $this->db->get('jos_egsa_game');
        return $query->row();
    }

    function delete($id)
    {
        $this->db->where('id', $id);
        if ($this->db->delete('jos_egsa_game'))
         return true;
        else
         return false;
    }

    function game_mode($id) {
	$arr = array();
	$this->db->where("game", $id);
	$query = $this->db->get("egsa_game_mode");
	$i = 0;
	$arr[""] = "-- Select Mode --";
	foreach ($query->result() as $row) {
		$arr[$row->mode] = $row->name;
	}
	return $arr;
    }

    function get_maps($data) {
	$arr = array();
	$this->db->where("game", $data['game']);
	$this->db->where("mode", $data['mode']);
	$query = $this->db->get("egsa_game_mode");
	$info = $query->row();
	if (!$info) {
		$arr[""] = "None";
		return $arr;
	}
	$lines = explode("\n", $info->maps);
	$i = 0;
	foreach ($lines as $line) {
		$info = explode(",", $line);
		if ($line !="") {
			$arr[$info[0]] = trim($info[1]);
		$i++;
		}
	}
	return $arr;
    }
	
    function get_all()
    {
        $query = $this->db->get('jos_egsa_game');
	foreach ($query->result() as $row)
	{
		$item = $row;
		$leagues = $this->db->query("SELECT * FROM jos_bl_tournament WHERE game = $row->id");
		$item->leagues = $leagues->num_rows();
		$arr[] = $item;
	}
        return $arr;
    }

    function save($data)
    {
	unset($data['submit']);
     	if ($data['id'] != "") {
         $this->db->where('id', $data['id']);
         $this->db->update('jos_egsa_game', $data);
         return $data['id'];
        } else {
         $this->db->insert('jos_egsa_game', $data);
         return $this->db->insert_id();
        }
    }

}
?>
