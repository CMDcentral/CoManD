<?
class Gallerymodel extends CI_Model {

 function __construct(){
  parent::__construct();
 }

 function get($id=0)
 {

  if (!lin() || get_user(user_id())->level != 100)
	$this->db->where('level', 1);

 if ($id !=0)
          $this->db->where('id', $id);


  $this->db->order_by('ordering');
  $query = $this->db->get('gallery');
//  echo $this->db->last_query();
  return $query->result();
 }

 function addimage($data)
 {
  $this->db->insert('images', $data);
 }

 function get_images($id) {
  $this->db->order_by('ordering');
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
	unset($data['submit']);
        if (isset($data['id'])) {
         $this->db->where('id', $data['id']);
         $this->db->update('gallery', $data);
         return $data['id'];
        } else {
         $this->db->insert('gallery', $data);
         return $this->db->insert_id();
        }
    }

    function delete($id)
    {
	$this->db->where("id", $id);
	if ($this->db->delete("gallery"))
	 return true;
	else
	 return false;
    }

    function delete_images($id)
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
