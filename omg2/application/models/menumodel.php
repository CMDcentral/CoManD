<?
class Menumodel extends CI_Model {

var $name;
var $id;
var $stmt;
var $link;
var $conn;
var $alias;
var $type;
var $description;
var $pageid;
var $path;
var $display_order;
var $lists;
var $editing = false;
var $items;

        function ItemCount($parent)
        {
                $rs = $this->db->query("SELECT * FROM menu_items WHERE parent = $parent");
                return $rs->num_rows()+1;
        }

	function Menumodel()
	{
		parent::__construct();
		//$this->items = $this->MenuInfo();
	}

	function get($id) {
	 $this->db->where('id', $id);
	 $query = $this->db->get("menu_items");
	 return $query->row();
	}


        function GetItem($id)
        {
                if ($id != "")
                {
                $rs = $this->db->query("SELECT * FROM menu_items WHERE id = $id");
                if ($rs->num_rows() > 0)
                {
		$item = $rs->row();
                $this->name = $item->name;
                $this->description = $item->description;
                $this->id = $item->id;
                $this->alias = $item->alias;
                $this->type = $item->type;
                $this->link = $item->link;
                $this->parent = $item->parent;
                $this->pageid = $item->pageid;
                $this->ordering = $item->ordering;
                $pos = strpos($this->link, ".");
                $this->module = substr($this->link, 0, $pos);
                }
                }
        }

        function buildMenu($parentId, $class, $sub, $active="active")
        {
         global $i;
         $html = '';
	 $menuData = $this->MenuInfo();
	 if (isset($menuData['parents'][$parentId]))
    	 {
                if ($i == 0) {
                        $html = '<ul class="'.$class.'">';
                        $i = 10;
                }
                else
                        $html = '<ul>';
	 $i = 1;
         foreach ($menuData['parents'][$parentId] as $itemId)
         {
                $this->path = '';
                $item = NULL;
		$extra = "";
                //$this->GetMenuPath($itemId);
                $link = str_replace("&", "%26", "".$menuData['items'][$itemId]['link']);
                $desc = $menuData['items'][$itemId]['description'];
		if ($this->uri->segment(3) == $menuData['items'][$itemId]['alias'])
			$extra = "current";
                if ($this->hasKids($itemId))
                        $html .= '<li class="'.$extra.'"><a class="'.$sub.' ' .$class.'" '.$extra.'  href="'.$link.'">' . $menuData['items'][$itemId]['name'].'</a>';
                else
                if ($menuData['items'][$itemId]['parent'] == 0) {
				$html .= '<li class="'.$extra.'"><a class="'.$extra.'" href="'.$link.'"><span class="bg">'.$menuData['items'][$itemId]['name'].'</span></a></li>';
		}
		 else
                    	$html .= '<li class="'.$extra.'"><a href="'.$link.'">' .$menuData['items'][$itemId]['name'].'</a>';
            // find childitems recursively
            $html .= $this->buildMenu($itemId, $class, $sub);
            $html .= '</li>';
	    $i++;
        }
        $html .= '</ul>';
    }
        return $html;
        }

	 function MenuInfo($menu=0)
        {
		if (admin())
			$extra = " AND level = 0 OR level = 100";
		else
			$extra = " AND level = 0";
                $rs = $this->db->query("SELECT * FROM menu_items WHERE visible = 1 AND menu = ".$menu." ".$extra." ORDER BY parent, ordering");

                                $menuData = array(
                        'items' => array(),
                        'parents' => array()
                );

                foreach ($rs->result_array() as $menuItem)
                {
                        $menuData['items'][$menuItem['id']] = $menuItem;
                        $menuData['parents'][$menuItem['parent']][] = $menuItem['id'];
                }
                return $menuData;
        }

        function GetMenuPath($id)
	{
         $this->GetItem($id);
         if ($this->parent == 0) {
                $this->path="";
                $this->lists[] = $this->alias;
                for ($i=sizeof($this->lists)-1;$i>0;$i--)
                {
                $this->path .= $this->lists[$i] . "/";
                }
                $this->lists = "";
                }
         else {
                $this->path="";
                $this->lists[] = $this->alias;
                $this->GetMenuPath($this->parent);
         }
	}

function hasKids($parent)
{
        $rs = $this->db->query("SELECT * FROM menu_items WHERE parent = $parent");
        if ($rs->num_rows() > 0)
                return true;
        else
                return false;
}

function get_kids($parent)
{
        $rs = $this->db->query("SELECT * FROM menu_items WHERE parent = $parent AND visible = 1");
        if ($rs->num_rows() > 0)
		return $rs->result();
}

function get_cat_selectlist($current_cat_id, $count) {
	static $option_results;
	$indent_flag ="";
	// if there is no current category id set, start off at the top level (zero)
	if (!isset($current_cat_id)) {
	$current_cat_id =0;
	}
	// increment the counter by 1
	$count = $count+1;
	$query = $this->db->query('SELECT * from menu_items where parent = '.$current_cat_id. ' ORDER BY ordering');
	
	$get_options = $query->result();
	$num_options = $query->num_rows();
	if ($num_options > 0) {
//	while (list($cat_id, $cat_name) = $get_options) {
	foreach ($get_options as $option) {
	// if its not a top-level category, indent it to
	//show that its a child category
	
	if ($current_cat_id!=0) {
	$indent_flag =  '&nbsp;&nbsp;&nbsp;&nbsp;';
	for ($x=2; $x<=$count; $x++) {
	$indent_flag .=  '&nbsp;&nbsp;&nbsp;&nbsp;';
	}
	}
	$name = $indent_flag.' - '.$option->name;
	$option_results[$option->id] = $name;
	$this->get_cat_selectlist($option->id, $count);
		} // end foreach
//	}
	}
	return $option_results;
}

    function save($data)
    {
        unset($data['submit']);
        if ($data['id'] != "") {
         $this->db->where('id', $data['id']);
         $this->db->update('menu_items', $data);
         return $data['id'];
        } else {
         $this->db->insert('menu_items', $data);
         return $this->db->insert_id();
        }
    }

    function delete($id)
    {
        $this->db->where('id', $id);
        if ($this->db->delete('menu_items'))
         return true;
        else
         return false;
    }



}
?>
