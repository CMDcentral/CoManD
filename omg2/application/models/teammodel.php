<?php

class Teammodel extends CI_Model {

    function get($id)
    {
//	$query = $this->db->query('SELECT g.id as gameid, t.id, t.t_name, t.clan, t.added, pt.added as joined, c.name as clanname, pt.role, pt.team_id, c.tag, g.name as game, t.t_descr, t.t_city 
//                             	   FROM jos_bl_players_team pt, jos_bl_teams t, jos_bl_clan c, jos_egsa_game g
//                                 WHERE c.id = t.clan AND t.id=pt.team_id  AND g.id = t.t_game AND t.id = '.$id);

      $query = $this->db->query('SELECT g.id as gameid, t.id, t.t_name, t.clan, t.added, c.name as clanname, c.tag, g.name as game, t.t_descr, t.t_city, t.def_img
                                 FROM jos_bl_teams t, jos_bl_clan c, jos_egsa_game g
                                 WHERE c.id = t.clan AND g.id = t.t_game AND t.id = '.$id);

	$item = $query->row();
	$item->members = $this->get_teammembers($id);
        return $item;
    }

    function delete_member($data)
    {
	$this->db->where('id', $data['id']);
	if ($this->db->delete('jos_bl_players_team', $data))
		return true;
	else
		return false;
    }

    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('jos_bl_teams');
	$this->db->where('team_id', $id);
	if ($this->db->delete('jos_bl_players_team'))
		return true;
	else
		return false;
    }

    function join($clan)
    {
	$userid = $this->session->userdata("user")->id;
	$data['playerid'] = $userid;
	$data['cid'] = $clan;
	$this->db->insert('jos_bl_clanmembers', $data);
        return $this->db->insert_id();
    }

    function get_role($id)
    {
        $this->db->where('roleid', $id);
        $query = $this->db->get('jos_bl_roles');
	return $query->row();
    }

    function get_teams($clan)
    {
	$arr = array();
        $this->db->where('clan', $clan);
        $query = $this->db->get('jos_bl_teams');
	foreach ($query->result() as $item)
	{
	 $item->members = $this->get_teammembers($item->id);
	 $arr[] = $item;
	}
        return $arr;
    }

    function get_teamleaders($team, $team2="0")
    {
       $this->db->where('team_id', $team);
       if ($team2 != 0)
        $this->db->or_where('team_id', $team2);
       $this->db->where('role >=', 4);
       $query = $this->db->get('jos_bl_players_team');
       return $query->result();
    }

    function is_teamleader($data) {
       $this->db->where('team_id', $data['team']);
       $this->db->where('player_id', $data['player']);
       $this->db->where('role >=', 4);
       $query = $this->db->get('jos_bl_players_team');
       if ($query->num_rows() > 0)
	return true;
       else
	return false;
    }

    function get_teammembers($team)
    {
	$this->db->order_by('role', "DESC");
     	$this->db->where('team_id', $team);
        $query = $this->db->get('jos_bl_players_team');
        return $query->result();
    }

    function get_members($clan)
    {
	$this->db->where('cid', $clan);
        $query = $this->db->get('jos_bl_clanmembers');
        return $query->result();
    }
	
    function get_all($search="")
    {
	if ($search == "")
	        $query = $this->db->get('SELECT t.t_name, t.id, t.t_descr, t.clan, g.name as game, g.image, t.added FROM jos_bl_teams t, jos_egsa_game g WHERE g.id = t.t_game');
	else
		$query = $this->db->query('SELECT t.t_name, t.id, t.t_descr, t.clan, g.name as game, g.image, t.added FROM jos_bl_teams t, jos_egsa_game g WHERE g.id = t.t_game AND t.t_name LIKE "%'.$search.'%"');
   	foreach ($query->result() as $item) {
         $members = sizeof($this->get_members($item->id));
	 $item->members = $members;
	 $arr[] = $item;
	}
        return $arr;
    }

    function save($data)
    {
	unset($data['submit']);
     	if (isset($data['id'])) {
         $this->db->where('id', $data['id']);
         $this->db->update('jos_bl_teams', $data);
         return $data['id'];
        } else {
        unset($data['player']);
	$data['created_by'] = user_id();
        $this->db->insert('jos_bl_teams', $data);
        $id = $this->db->insert_id();
	$this->load->model("Sitemodel");
	$games = $this->Sitemodel->get_games();	
	$name = $data['t_name'];
	$user = get_user(user_id());
	$game = $games[$data['t_game']];
	$data2['info'] = "<a href='/player/view/".user_id().".html'>".$user->alias . "</a> created a new <a href='/game/listing.html'>".$game."</a> team called '<a href='/team/view/".$id.".html'>". $data['t_name']."'</a>";
        log_info($data2);
        return $id;
        }
    }

    function team_save($data)
    {
	 unset($data['player']);
	 if (isset($data['id'])) {
	  $this->db->where('id', $data['id']);
	  $this->db->update('jos_bl_teams', $data);
	  return $data['id'];
	 } else {
	  $data['create_by'] = $this->session->userdata("user")->id;
	  $this->db->insert('jos_bl_teams', $data);
          return $this->db->insert_id();
	 }
    }

    function playerteam_save($data)
    {
        if (isset($data['id'])) {
	 $this->db->where('id', $data['id']);
	 $this->db->update('jos_bl_players_team', $data);
//	 echo "<br/>".$this->db->last_query();
	 return $data['id'];
	}
	else {
         $this->db->insert('jos_bl_players_team', $data);
         return $this->db->insert_id();
	}
    }


    function role_save($data)
    {
	foreach ($data['player'] as $item) {
         $this->db->where('id', $item['id']);
         $this->db->update('jos_bl_clanmembers', $item);
	}
	redirect($_SERVER['HTTP_REFERER']);
    }

	function _prep_password($password)
	{
     	return sha1($password.$this->config->item('encryption_key'));
	}


}
?>
