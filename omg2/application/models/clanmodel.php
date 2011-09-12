<?php

class Clanmodel extends CI_Model {

    function Clanmodel() {
	$this->load->model("Teammodel");
    }

    function get($id)
    {
	if (is_numeric($id))
	     	$this->db->where('id', $id);
	else
		$this->db->where('url_key', $id);
        $query = $this->db->get('jos_bl_clan');
	$item = $query->row();
	if (!$item) {
		message("An error occurred proccesing your request.", "error");
		redirect(ref());
	}
 	$members = $this->get_members($item->id);
     	$item->members = $members;
	$item->member_count = sizeof($members);
	$teams = $this->get_teams($item->id);
        $item->team_count = sizeof($teams);
	$item->teams = $teams;
        return $item;
    }

    function join($clan)
    {
	$userid = user_id();
	$data['playerid'] = $userid;
	$data['cid'] = $clan;
	$this->db->insert('jos_bl_clanmembers', $data);
	$c = $this->get($clan);
        $data2['info'] = "<a href='/player/view/".$userid.".html'>".get_user(user_id())->alias. "</a> has joined the clan <a href='/clan/view/".$clan.".html'>".$c->tag . " " .$c->name."</a>";
        log_info($data2);
        return $this->db->insert_id();
    }

    function leave($clan)
    {
     	$userid = user_id();
        $data['playerid'] = $userid;
        $data['cid'] = $clan;
	$this->db->where('playerid', user_id());
	$this->db->where('cid', $clan);
        $this->db->delete('jos_bl_clanmembers', $data);
        $c = $this->get($clan);
        $data2['info'] = "<a href='/player/view/".$userid.".html'>".get_user(user_id())->alias . "</a> has left the clan <a href='/clan/view/".$clan.".html'>".$c->tag . " " .$c->name."</a>";
        log_info($data2);
        return true;
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
        $query = $this->db->query('SELECT g.abbv, t.t_name, t.id, t.t_descr, t.clan, g.name as game, g.image, t.added 
				   FROM jos_bl_teams t, jos_egsa_game g WHERE g.id = t.t_game AND clan = '.$clan);
	foreach ($query->result() as $item)
	{
	 $item->members = $this->Teammodel->get_teammembers($item->id);
	 $arr[] = $item;
	}
        return $arr;
    }

    function myclans($pid=0)
    {
	$arr = array();
	if ($pid == 0)
		$pid = user_id();
	$query = $this->db->query('SELECT *, c.id as cid FROM jos_bl_clan c, jos_bl_clanmembers cm WHERE cm.playerid = '.$pid.' AND c.id=cm.cid');
	foreach ($query->result() as $item)
	{
	$members = sizeof($this->get_members($item->cid));
	if (clanadmin($item->cid))
	 $item->admin = true;
	else
	 $item->admin = false;
        $item->members = $members;
        $item->teams = sizeof($this->get_teams($item->cid));
	$arr[] = $item;
	}
	//$clan['clans'] = $query->result();
	//$clan['teams'] = $this->myteams();
	return $arr;
    }

    function myteams($pid=0)
    {
	if ($pid == 0)
		$pid = user_id();
        $query = $this->db->query('SELECT g.id as gameid, t.id, t.t_name, t.clan, t.added, pt.added as joined, c.name as clanname, pt.role, pt.team_id, c.tag, g.name as game
				   FROM jos_bl_players_team pt, jos_bl_teams t, jos_bl_clan c, jos_egsa_game g 
			   	   WHERE c.id = t.clan AND t.id=pt.team_id  AND g.id = t.t_game AND player_id = '.$pid);
	return $query->result();
    }

    function inclan($id=0, $clanid=0)
    {
	if ($id==0) { }
	$pid = user_id();
	$this->db->where('playerid', $pid);
	if ($clanid != 0)
	 $this->db->where('cid', $clanid);
        $query = $this->db->get('jos_bl_clanmembers');
	if ($query->num_rows() > 0)
		return true;
	else
		return false;
    }

//    function get_teammembers($team)
//    {
//     	$this->db->where('team_id', $team);
//        $query = $this->db->get('jos_bl_players_team');
//        return $query->result();
//    }

    function get_members($clan)
    {
	$this->db->where('cid', $clan);
        $query = $this->db->get('jos_bl_clanmembers');
        return $query->result();
    }

    function get_member($clan)
    {
        $this->db->where('cid', $clan);
	$this->db->where('playerid', user_id());
        $query = $this->db->get('jos_bl_clanmembers');
        return $query->row();
    }

    function get_all($search)
    {
	if ($search != "")
		$this->db->like('name', $search, 'after');
        $query = $this->db->get('jos_bl_clan');
   	foreach ($query->result() as $item) {
         $members = sizeof($this->get_members($item->id));
	 $item->members = $members;
	 $item->teams = sizeof($this->get_teams($item->id));
	 $arr[] = $item;
	}
        return $arr;
    }

    function save($data)
    {
	unset($data['submit']);
     	if (isset($data['id'])) {
         $this->db->where('id', $data['id']);
         $this->db->update('jos_bl_clan', $data);
         return $data['id'];
        } else {
         $this->db->insert('jos_bl_clan', $data);
	 $id = $this->db->insert_id();
	 $user = get_user(user_id());
         $data2['info'] = "<a href='/player/view/".user_id().".html'>".$user->alias . "</a> created a new clan named <a href='/clan/view/".$id.".html'>".$data['tag'] . " " . $data['name']."</a>";
         log_info($data2);
         return $id;
        }
    }

    function team_save($data)
    {
	 $data['created_by'] = user_id();
	 unset($data['player']);
	 $this->db->insert('jos_bl_teams', $data);
         return $this->db->insert_id();
    }

    function playerteam_save($team, $player, $role)
    {
         $data['team_id'] = $team;
	 $data['player_id'] = $player;
	 $data['role'] = $role;
         $this->db->insert('jos_bl_players_team', $data);
         return $this->db->insert_id();
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
