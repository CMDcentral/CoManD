<?
class Dropboxmodel extends CI_Model {

 function __construct(){
  parent::__construct();
 }

 function get($id=0, $folder="")
 {
  $this->db->order_by('id', "DESC");
  if ($id != 0)
	$this->db->where('id', $id);

  if ($folder !="")
	 $this->db->where('folder', $folder);

  $query = $this->db->get('dropbox');
  return $query->result();
 }

 function add($data)
 {
  $this->db->insert('dropbox', $data);
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
        $item = $this->get($id);
        $this->db->where('id', $id);
        if ($this->db->delete('dropbox')) {
         unlink(getcwd()."/dropbox/".$item[0]->filename);
         return true; }
        else
         return false;
    }


}
