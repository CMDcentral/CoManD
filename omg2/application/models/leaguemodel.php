<?
class Leaguemodel extends CI_Model {

 function get_all($id="", $game=0)
 {
	if ($id != "")
		$extra = " AND g.id = ".$id;
	else
		$extra = "";
	if ($game != 0)
		$extra = " AND t.game = ". $game;
	$query = $this->db->query('SELECT t.prizes, t.minPlayers, t.maxPlayers, t.t_alias, t.name as name, g.name as game, t.id as id, t.descr as `desc`, t.rules, g.abbv FROM jos_bl_tournament t, jos_egsa_game g WHERE t.game = g.id '.$extra);
	return $query->result();
 }

 function get($alias)
 {
	if (is_numeric($alias))
	 $extra = "AND t.id =". $alias;
	else
	 $extra = "AND t.t_alias = '". $alias. "'";
  	$query = $this->db->query('SELECT t.prizes, t.minPlayers, t.maxPlayers, t.sponsor as sponsor, t.descr, g.id as gameid, t.id, g.abbv, t.name, t.t_alias, g.name as game, t.logo, 
g.image, t.rules FROM 
jos_bl_tournament t, jos_egsa_game g WHERE 
t.game = g.id '.$extra);
//	echo $this->db->last_query();
	$tourn = $query->row();
	$tournament['info'] = $tourn;
//	print_r($tournament['info']);
        return $tournament;
 }

 function in_league($team) {
	$this->db->where("team_id", $team);
	$this->load->model("Stagemodel");
	$query = $this->db->get("jos_bl_season_teams");	
	$i=0;
	foreach ($query->result() as $item) {
		$arr[$i]["stage"] = $this->Stagemodel->get($item->season_id);
		$arr[$i]["league"] = $this->get($arr[$i]["stage"]->t_id);
		$i++;
	}
	return $arr;
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
        if ($data['id'] != "") {
	 if (is_numeric($data['id']))
	        $this->db->where('id', $data['id']);
	 else
		$this->db->where('t_alias', $data['t_alias']);
         $this->db->update('jos_bl_tournament', $data);
     	 return $data['t_alias'];
        } else {
         $this->db->insert('jos_bl_tournament', $data);
         $id = $this->db->insert_id();
         return $data['t_alias'];
        }
    }


}
?>
