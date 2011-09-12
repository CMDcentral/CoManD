<?
class Commentmodel extends CI_Model {

 function get($controller, $oid)
 {
	$this->db->where("controller", $controller);
	$this->db->where("oid", $oid);
	$this->db->order_by("id", "ASC");
	$query = $this->db->get("jos_bl_comments");
	return $query->result();
 }

 function get_by_id($id)
 {
        $this->db->where("id", $id);
        $query = $this->db->get("jos_bl_comments");
        return $query->row();
 }

 function delete($id) 
 {
	$this->db->where("id", $id);
	$this->db->delete("jos_bl_comments");
	return true;
 }

 function save($data) {
	$data['user_id'] = user_id();
	if ($this->db->insert("jos_bl_comments", $data))
		return true;
	else
		return false;
 }

}
