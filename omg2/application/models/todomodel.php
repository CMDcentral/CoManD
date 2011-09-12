<?
class Todomodel extends CI_Model {

    function fields()
    {
     	$fields = $this->db->field_data('todo');
	unset($fields[0]);
        return $fields;
    }

    function add($data)
    {
     	if (isset($data['id'])) {
         $this->db->where('id', $data['id']);
         $this->db->update('todo', $data);
         return $data['id'];
        } else {
         $data['owner'] = user_id();
         $this->db->insert('todo', $data);
         return $this->db->insert_id();
        }
    }

        function get_task($date) {
         $user = $this->session->userdata('user')->id;
         $query = $this->db->query("SELECT * FROM todo WHERE '$date' BETWEEN start AND end AND owner = $user");
         return $query->result();
        }

     	function get_tasks() {
         $user = $this->session->userdata('user')->id;
	 $date = date("Y-m-d");
         $query = $this->db->query("SELECT * FROM todo WHERE owner = $user AND start >= '$date' ORDER BY start ASC");
         return $query->result();
        }

	function get_all_tasks() {
         $query = $this->db->query("SELECT * FROM todo ORDER BY start ASC");
         return $query->result();
	}


}
?>
