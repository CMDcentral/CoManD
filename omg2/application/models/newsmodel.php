<?php

class Newsmodel extends CI_Model {

    function delete($id)
    {
	$this->db->where('id', $id);
        if ($this->db->delete('jos_content'))
	 return true;
	else
	 return false;
    }

    function get_count($s=0)
    {
        if ($s!=0)
                $this->db->where('catid', $s);
	$this->db->where('state', 1);
        $this->db->order_by('ordering');
        $query = $this->db->get('jos_content');
        return $query->num_rows();
    }

    function get_rating($id) {
	$this->db->where('content_id', $id);
	$query = $this->db->get('jos_content_rating');
	return $query->row();
    }

    function save_rating($data) {

	if (isset($data['existing'])) 
	{
                unset($data['existing']);
		$this->db->where('content_id', $data['content_id']);
		$this->db->update('jos_content_rating', $data);
		return $data['content_id'];
	}
	else {
	        $this->db->insert('jos_content_rating', $data);
		return $this->db->insert_id();	
	}
    }

    function get_categories($id=0, $all=false, $pub=false)
    {
	 $this->db->order_by("ordering");
	 if ($id != 0)
		 $this->db->where("section", $id);
	 if ($pub)
		$this->db->where("published", 1);
         $query = $this->db->get('jos_categories');
	if (!$all) {
         foreach ($query->result() as $sect)
                $arr[$sect->id] = $sect->title;
         return $arr;
	}
	else
	return $query->result();
    }


    function get_sections()
    {
	 $query = $this->db->get('jos_sections');
	 foreach ($query->result() as $sect)
		$arr[$sect->id] = $sect->title;
	 return $arr;
    }

    function get($alias)
    {
	if (is_numeric($alias))
	 $this->db->where('id', $alias);
        else
	 $this->db->where('alias', $alias);

	$query = $this->db->get('jos_content');
	$item = $query->row();
	$rating = $this->get_rating($item->id);
	if ($rating->rating_sum != 0 && $rating->rating_count != 0) {
	$rate = $rating->rating_sum / $rating->rating_count;
	}
	if ($rate == "")
		$rate = 0;
	$item->rating = $rate;
	return $item;
    }

    function get_all($s=0)
    {
	if ($s!=0)
		$this->db->where('sectionid', $s);
	$this->db->order_by('ordering');
//	$this->db->limit();
        $query = $this->db->get('jos_content');
        return $query->result();
    }

    function save($data)
    {
        if ($data['id'] != "") {
	 $now = date("Y-m-d H:i:s");
         $this->db->where('id', $data['id']);
	 $data['modified'] = $now;

         if ($this->db->update('jos_content', $data))
	         return $data['id'];
	 else
		return false;
        } else {
	 $data['created_by'] = user_id();
         $this->db->insert('jos_content', $data);
         return $this->db->insert_id();
        }
    }
}
?>
