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
        $this->obj->load->model("Leaguemodel");
        $this->obj->load->model("Playermodel");
 	$this->obj->load->model("Clanmodel");
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
	if (lin()) {
	$data3['avatar'] = "<img src='/thumb/profile_gen/width/60/height/60/player/".user_id()."' />";
	$data3['alias'] = get_user(user_id())->alias;
	if (admin())
		$loadedData['adminmenu'] = $this->obj->parser->parse("admin/menu", array(), true);	
	$data4['clans'] = $this->obj->Clanmodel->myclans();

	}
	$loadedData['usersidemenu'] = $this->obj->parser->parse("player/menu", $data4, true);
	$gMenu['items'] = $this->obj->Menumodel->MenuInfo(1);
        $loadedData['gamemenu'] = $this->obj->load->view("menu/block", $gMenu, true);
        $loadedData['usermenu'] = $this->obj->parser->parse("users/menu", $data3 , true);
        $loadedData['posts'] = $this->obj->parser->parse("home/posts", array(), true);
//	$loadedData['leagues'] = $this->obj->Leaguemodel->get_all();
	$usersonline = $this->obj->Playermodel->users_online();
	$info['online'] = $usersonline;
	$ok = $this->obj->parser->parse("home/online", $info, TRUE);
	$loadedData['online'] = $ok;
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
