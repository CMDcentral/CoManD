<?
class Menu extends CI_Controller {

function __construct() {
	parent::__construct();
	$this->load->model("Menumodel");
}

function index() {

	if (isset($_GET['action'])) 
	{
	switch ($_GET['action'])
	{
	 case "delete":
		$menu->Delete($_GET['id']);
	 break;
	 case "edit":
		$menu->editing = true;
		$menu->GetItem($_GET['id']);
	 break;
	 case "moveup":
		$menu->GetItem($_GET['id']);
		if ($menu->display_order > 1)
			$menu->Order("menu_items", $_GET['id'], $menu->display_order, $menu->display_order-1, $_GET['parent']);
	 break;
	 case "movedown":
		$menu->GetItem($_GET['id']);
		$menu->Order("menu_items", $_GET['id'], $menu->display_order,  $menu->display_order+1, $_GET['parent']);
	 break;
	 }
	}
	 $data['title'] = "Menu Editor";
	 $data['menu'] = $this->Menumodel->get($this->uri->segment(3));
	 $data['structure'] = $this->Menumodel->MenuInfo();
	 $data['menudisp'] = $this->Menumodel->buildMenu(0, "dropdown dropdown-horizontal", "dir");
	 $data['get_options'] = $this->Menumodel->get_cat_selectlist(0,0);
	 $this->layout->view("menu/edit", $data);
	}

        function save() {
        $id = $this->Menumodel->save($this->input->post());
                if ($id != 0) {
                 message(ucfirst($this->router->class) ." changes saved successfully", 'message');
                 redirect(ref());
                }
        }

        function delete() {
         $ref = $this->agent->referrer();
         $id = $this->uri->segment(3, 0);
         if ($this->Menumodel->delete($id))
          message(ucfirst($this->router->class) . " has been deleted.", "message");
         else
          message("Unable to delete item", "error");;
         redirect($ref);
        }

} // end class
