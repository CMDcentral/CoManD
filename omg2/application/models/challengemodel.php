<?php

class Challengemodel extends CI_Model {

    function get($id)
    {
        //$this->db->where("playdate >=", date("Y-m-d"));
     	$this->db->where('id', $id);
        $query = $this->db->get('jos_bl_challenge');
	$item = $query->row();
        return $item;
    }

    function join($clan)
    {
	$userid = $this->session->userdata("user")->id;
	$data['playerid'] = $userid;
	$data['cid'] = $clan;
	$this->db->insert('jos_bl_clanmembers', $data);
	$c = $this->get($clan);
        $data2['info'] = "<a href='/player/view/".$userid.".html'>".user()->alias . "</a> has joined the clan <a href='/clan/view/".$clan.".html'>".$c->tag . " " .$c->name."</a>";
        log_info($data2);
        return $this->db->insert_id();
    }

    function get_role($id)
    {
        $this->db->where('roleid', $id);
        $query = $this->db->get('jos_bl_roles');
	return $query->row();
    }

    function get_by_team($team)
    {
	$arr = array();
	$this->db->where("playdate >=", date("Y-m-d"));
        $this->db->where('team2', $team);
        $this->db->where('owner !=', user_id());
        $query = $this->db->get('jos_bl_challenge');
        return $query->result();
    }

    function myclans()
    {
	$pid = user()->id;
	$query = $this->db->query('SELECT *, c.id as cid FROM jos_bl_clan c, jos_bl_clanmembers cm WHERE cm.playerid = '.$pid.' AND c.id=cm.cid');
	$clan['clans'] = $query->result();
	$clan['teams'] = $this->myteams();
	return $clan;
    }

    function myteams()
    {
	$pid = user()->id;
	//$this->db->where('player_id', $pid);
        $query = $this->db->query('SELECT * FROM jos_bl_players_team pt, jos_bl_teams t WHERE t.id=pt.team_id  AND player_id = '.$pid);
	return $query->result();
    }

    function inclan($id=0)
    {
	if ($id==0) { }
	$pid = $this->session->userdata("user")->id;
	$this->db->where('playerid', $pid);
        $query = $this->db->get('jos_bl_clanmembers');
	if ($query->num_rows() > 0)
		return true;
	else
		return false;
    }

    function get_teammembers($team)
    {
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

    function get_member($clan)
    {
        $this->db->where('cid', $clan);
	$this->db->where('playerid', $this->session->userdata("user")->id);
        $query = $this->db->get('jos_bl_clanmembers');
        return $query->row();
    }
	
    function get_all()
    {
	$this->db->where("playdate >=", date("Y-m-d"));
	$this->db->where('owner', user_id());
        $query = $this->db->get('jos_bl_challenge');
        return $query->result();
    }

    function get_historical()
    {
        $this->db->where("playdate <=", date("Y-m-d"));
        $this->db->where('owner', user_id());
        $query = $this->db->get('jos_bl_challenge');
        return $query->result();
    }


    function save($data)
    {
     	if (isset($data['id'])) {
         $this->db->where('id', $data['id']);
         $this->db->update('jos_bl_challenge', $data);
         return $data['id'];
        } else {
         $this->db->insert('jos_bl_challenge', $data);
	 $id = $this->db->insert_id();
         return $id;
        }
    }

    function team_save($data)
    {
	 $data['created_by'] = $this->session->userdata("user")->id;
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
