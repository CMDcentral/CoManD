<?php

class Clientmodel extends CI_Model {

    function get($id)
    {
     	$this->db->where('id', $id);
        $query = $this->db->get('client');
        return $query->row();
    }

	
    function get_all()
    {
        $query = $this->db->get('client');
        return $query->result();
    }

    function authenticate($username, $password) {
     $this->db->where('username', $username);
     $this->db->where('password', $this->_prep_password($password));
 
     $query = $this->db->get('client', 1);
 
     if ( $query->num_rows() == 1)
     {
	   $user = $query->result();
	   $id = $user[0]->id;
	   $user = $this->get($id);
           // set your cookies and sessions etc here
	   $this->session->set_userdata('client', $user);
	   $this->session->set_userdata('loggedinclient', true);
           return true;
     }
     else
      return false;

    }

    function save($data)
    {
	unset($data['submit']);
	if ($data['password'] != "")
	 $data['password'] = $this->_prep_password($data['password']);
	else
	 unset($data['password']);	
     	if (isset($data['id'])) {
         $this->db->where('id', $data['id']);
         $this->db->update('client', $data);
         return $data['id'];
        } else {
         $this->db->insert('client', $data);
         return $this->db->insert_id();
        }
    }

	function _prep_password($password)
	{
     	return sha1($password.$this->config->item('encryption_key'));
	}
}
?>
