<?
Class Image extends CI_Controller {

 function __construct() {
	parent::__construct();
	$this->load->model("Imagemodel");
        $this->load->model("Commentmodel");
 }

 function view() {
	$id = $this->uri->segment(3);
	$image = $this->Imagemodel->get_image($id);
	$data['image'] = $image[0];
	$data['title'] = "Image View";
	$data['comments'] = $this->Commentmodel->get($this->router->class, $id);
        if (isset($_GET['ajax']))
		$this->load->view("image/view", $data);
	else
		$this->layout->view("image/view", $data);
 }

}
?>
