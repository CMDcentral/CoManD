<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Layout
{
    
    var $obj;
    var $layout;
    
    function Layout($layout = "index")
    {
        $this->obj =& get_instance();
        $this->layout = $layout;
	$this->obj->load->model("Menumodel");
    }

    function setLayout($layout)
    {
      $this->layout = $layout;
    }
    
    function view($view, $data=null, $return=false)
    {
	$data3 = array();
        $loadedData = array();
        $loadedData['content_for_layout'] = $this->obj->load->view($view,$data,true);
        $loadedData['menu'] = $this->obj->Menumodel->buildMenu(0, "dropdown dropdown-horizontal", "dir");

        if($return)
        {
            $output = $this->obj->load->view($this->layout, $loadedData, true);
            return $output;
        }
        else
        {
            $this->obj->load->view($this->layout, $loadedData, false);
        }
    }
}
?>
