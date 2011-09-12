<?
class Stagemodel extends CI_Model {

 function get_all($id="")
 {
	$this->db->where("t_id", $id);
	$query = $this->db->get('jos_bl_seasons');
	foreach ($query->result() as $item) {
		$entrants = $this->get_entrants($item->s_id);
		$item->entrants = sizeof($entrants);
		$items->entries = $entrants;
		$arr[] = $item;
	}
	return $arr;
 }

 function get($alias)
 {
	$this->db->where('s_id', $alias);
  	$query = $this->db->get('jos_bl_seasons');
	$entrants = $this->get_entrants($alias);
	$item = $query->row();
	$item->entries = $entrants;
	$item->entrants = sizeof($entrants);
        return $item;
 }

 function get_groups($stage) {
	$this->db->where('s_id', $stage);
	$query = $this->db->get('jos_bl_groups');
	return $query->result();
 }

 function get_entrants($stage) {
	$this->db->where('season_id', $stage);
        $query = $this->db->get('jos_bl_season_teams');
        return $query->result();
 }

 function get_entrant($stage, $team) {
        $this->db->where('season_id', $stage);
	$this->db->where('team_id', $team);
        $query = $this->db->get('jos_bl_season_teams');
        return $query->row();
 }


 function rules($id)
 {
  	$this->db->where("t_id", $id);
        $query = $this->db->get('egsa_rules');
	return $query->row();
 }

    function save($data) 
    {
        unset($data['submit']);
        if ($data['s_id'] != "") {
         $this->db->where('s_id', $data['s_id']);
         $this->db->update('jos_bl_seasons', $data);
     	 return $data['s_id'];
        } else {
         $this->db->insert('jos_bl_seasons', $data);
         $id = $this->db->insert_id();
         return $id;
        }
    }

    function save_teamseason($data)
    {
     	unset($data['submit']);
	 if (sizeof($this->get_entrant($data['season_id'], $data['team_id'])) < 1) {
         if ($this->db->insert('jos_bl_season_teams', $data))
		return true;
	 else
		return false;
	 }
	  else { return false; }
    }



}
?>
