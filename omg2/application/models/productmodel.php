<?php

class Productmodel extends CI_Model {

    function delete($id)
    {
	$this->db->where('id', $id);
        if ($this->db->delete('products'))
	 return true;
	else
	 return false;
    }

    function get($alias)
    {
	if (is_numeric($alias))
	 $this->db->where('id', $alias);
        else
	 $this->db->where('alias', $alias);

	$query = $this->db->get('products');
	$item = $query->row();
	return $item;
    }

    function get_all($service=0, $limit=0)
    {
	if ($service != 0)
		$this->db->where('service', $service);
	if ($limit != 0)
		$this->db->limit($limit);
	$this->db->order_by("RAND()");
        $query = $this->db->get('products');
        return $query->result();
    }

    function save($data)
    {
        if ($data['id'] != "") {
         $this->db->where('id', $data['id']);

         if ($this->db->update('products', $data))
	         return $data['id'];
	 else
		return false;
        } else {
         $this->db->insert('products', $data);
         return $this->db->insert_id();
        }
    }
}
?>
