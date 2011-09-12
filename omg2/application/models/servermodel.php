<?
class Servermodel extends CI_Model {

	function get_all($bookable=1)
	{
	 if ($bookable == 2)
		$extra = "";
	 else
		$extra = "AND bookable = ".$bookable;
	 $query = $this->db->query("SELECT s.bookable, s.id, s.ip, s.port, s.password, s.name as sname, g.name 
				    FROM jos_egsa_server s, jos_egsa_game g WHERE s.game = g.id ".$extra);
	 return $query->result();
	}

	function get($id) {
	 $this->db->where('id', $id);
	 $query = $this->db->get("jos_egsa_server");
	 return $query->row();
	}

	function get_password()
	{
	 $query = $this->db->get("jos_egsa_password");
	 return $query->result_array();
	}

    function delete($id)
    {
        $this->db->where('id', $id);
        if ($this->db->delete('jos_egsa_server')) {
	 $this->db->where('server', $id);
	 $this->db->delete('server_booking');
         return true;
	}
        else
         return false;
    }

    function save($data)
    {
        unset($data['submit']);
        if ($data['id'] != "") {
         $this->db->where('id', $data['id']);
         $this->db->update('jos_egsa_server', $data);
         return $data['id'];
        } else {
         $this->db->insert('jos_egsa_server', $data);
         return $this->db->insert_id();
        }
    }

	function check_booking($start, $end, $server) {
         $query = $this->db->query("SELECT * FROM server_booking WHERE '$start' BETWEEN `start` AND `end` AND '$end' BETWEEN `start` AND `end` AND server = $server");
         return $query->num_rows();
	}


}
