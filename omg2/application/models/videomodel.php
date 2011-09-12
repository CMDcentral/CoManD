<?
class Videomodel extends CI_Model {

 function __construct(){
  parent::__construct();
 }

 function get($id)
 {
  $this->db->where("id", $id);
  $query = $this->db->get('videos');
  return $query->row();
 }

 function addimage($data)
 {
  $this->db->insert('images', $data);
 }

 function get_all() {
  $query = $this->db->get('videos');
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
        if ($data['id'] != "") {
         $this->db->where('id', $data['id']);
         $this->db->update('videos', $data);
         return $data['id'];
        } else {
     	 $data2['owner'] = user_id();
         $data2['info'] = "A new video titled <b>".$data['title']."</b> has been added to <a href='/video.html'>videos</a>, check it out <a class='video' href='http://www.youtube.com/watch?v=".$data['youtubeid']."&feature=player_embedded'>here</a>";
         log_info($data2);
         $this->db->insert('videos', $data);
         return $this->db->insert_id();
        }
    }

    function delete($id)
    {
	$this->db->where("id", $id);
	if ($this->db->delete("videos"))
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
