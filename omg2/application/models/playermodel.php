<?php

class Playermodel extends CI_Model {

    function Playermodel() {
	parent::__construct();
	$this->db->cache_off();
    }

    function get($id)
    {
	if (is_numeric($id))
     	 $this->db->where('id', $id);
	else {
	 $pos = strpos($id, "@");
	 if (!$pos)
		 $this->db->where('alias', $id);
	 else
		 $this->db->where('email', $id);
	}
        $query = $this->db->get('jos_comprofiler');
        return $query->row();
    }

    function get_by_key($id)
    {
        $this->db->where('cbactivation', $id);
        $query = $this->db->get('jos_comprofiler');
        return $query->row();
    }

    function users_online() {
        $ten_minutes_ago = time() - (60 * 5);
        $datetime = date("Y-m-d H:i:s", $ten_minutes_ago);
	$query = $this->db->query("SELECT avatar, id, alias, last_activity FROM jos_comprofiler WHERE last_activity >= '$datetime'");
	return $query->result();
    }
	
    function get_all($search="")
    {
	if ($search != "")
	 $this->db->like('alias', $search, 'after');
        $query = $this->db->get('jos_comprofiler');
        return $query->result();
    }

    function authenticate($username, $password) {
     $this->db->where('email', $username);
     $this->db->where('approved', 1);
     $this->db->where('password', $this->_prep_password($password));
 
     $query = $this->db->get('jos_comprofiler', 1);

     if ( $query->num_rows() > 0)
     {
	   $user = $query->row();
	   $this->session->set_userdata('user', $user->id);
	   $this->session->set_userdata('loggedin', true);
           return true;
     }
     else
      return false;
    }

    function save($data)
    {
	unset($data['submit']);
	if (isset($data['password'])) {
	$pass = $data['password'];
	if ($data['password'] != "") {
	 $data['password'] = $this->_prep_password($data['password']);
	 $user = get_user(user_id());
	 $this->phpbb->user_edit($user->email, phpbb_hash($pass)); 
	}
	else
	 unset($data['password']);
	}
	
     	if (isset($data['id'])) {
         $this->db->where('id', $data['id']);
         $this->db->update('jos_comprofiler', $data);
         $user = $this->get($data['id']);
         return $data['id'];
        } else {
         $this->db->insert('jos_comprofiler', $data);
	 $userid = $this->db->insert_id();
	 $this->authenticate($data['alias'], $pass);
	 $data2['owner'] = $userid;
         $data2['info'] = "<a href='/player/view/".$userid.".html'>".$data['alias']. "</a> has now registered to the eGamingSA website.";
         log_info($data2);
	 $this->phpbb->user_add($data['email'], $data['alias'], $pass);	
 	 return $userid;
        }
    }

	function get_tabs() {
	 $arr = array();
	 $this->db->where("enabled", 1);
	 $this->db->order_by("ordering", "ASC");
	 $query = $this->db->get("jos_comprofiler_tabs");
	 foreach ($query->result() as $tab)
	 {
		$item = $tab;
		$item->fields = $this->fields($tab->tabid);
		$arr[] = $item;
	 }
	 return $arr;
	}

	function get_values($fieldid) {
	 $this->db->where("fieldid", $fieldid);
         $this->db->order_by("ordering", "ASC");
         $query = $this->db->get("jos_comprofiler_field_values");
	 foreach ($query->result() as $item)
		$arr[$item->fieldvalueid] = $item->fieldtitle;
	 return $arr;
	}

	function get_tab($id) {
	 $this->db->where("tabid", $id);
	 $query = $this->db->get("jos_comprofiler_tabs");
	 return $query->row();
	}

	function fields($tab, $profile=false) {
	 $this->db->where("tabid", $tab);
	 $this->db->where("published", 1);
	 if ($profile)
		 $this->db->where("profile >=", 1);
	 $this->db->order_by("ordering", "ASC");
	 $query = $this->db->get("jos_comprofiler_fields");
	 return $query->result();
	}

	function _prep_password($password)
	{
     	return sha1($password.$this->config->item('encryption_key'));
	}


}
?>
