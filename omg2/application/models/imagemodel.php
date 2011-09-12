<?
class Imagemodel extends CI_Model {

 function __construct(){
  parent::__construct();
 }

 function get($id=0)
 {
  $this->db->order_by('id', "DESC");
  if ($id != 0)
	$this->db->where('id', $id);
  $query = $this->db->get('gallery');
  return $query->result();
 }

 function addimage($data)
 {
  $this->db->insert('images', $data);
 }

 function get_images($id) {
  $this->db->order_by('added', "DESC");
  $this->db->where('album', $id);
  $query = $this->db->get('images');
  return $query->result();
 }

 function get_all_images() {
  $this->db->order_by("RAND()");
  $query = $this->db->get('images');
  return $query->result();
 }


 function get_image($id)
 {
  $this->db->where('id', $id);
  $query = $this->db->get('images');
  return $query->result();
 }

    function save($data)
    {
        if (isset($data['id'])) {
         $this->db->where('id', $data['id']);
         $this->db->update('images', $data);
         return $data['id'];
        } else {
         $this->db->insert('images', $data);
         return $this->db->insert_id();
        }
    }

    function delete($id)
    {
     	$item = $this->get_image($id);
        $this->db->where('id', $id);
        if ($this->db->delete('images')) {
         unlink(getcwd()."/images/gallery/".$item[0]->album."/".$item[0]->filename);
         return true; }
        else
         return false;
    }


}
