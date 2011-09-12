<?
class Admin extends CI_Controller {

 var $data;

 function Admin()
 {
	parent::__construct();
	if (!admin())
		redirect("/");
	$this->load->model("Pagesmodel");	
	$this->load->model("Gallerymodel");
        $this->load->model("Servicesmodel");
        $this->load->model("Imagemodel");
        $this->load->model("Clientmodel");
        $this->load->model("Playermodel");
        $this->load->model("Newsmodel");
        $this->load->model("Usermodel");
	$this->data['ckeditor'] = array(
			'id' 	=> 	'content',
			'path'	=>	'js/ckeditor',
			'config' => array(
				'toolbar' 	=> 	"Full", 	//Using the Full toolbar
				'width' 	=> 	"550px",	//Setting a custom width
				'height' 	=> 	'100px',	//Setting a custom height
 
			),
			'styles' => array(
				'style 1' => array (
					'name' 		=> 	'Blue Title',
					'element' 	=> 	'h2',
					'styles' => array(
						'color' 	=> 	'Blue',
						'font-weight' 	=> 	'bold'
					)
				),
				'style 2' => array (
					'name' 	=> 	'Red Title',
					'element' 	=> 	'h2',
					'styles' => array(
						'color' 		=> 	'Red',
						'font-weight' 		=> 	'bold',
						'text-decoration'	=> 	'underline'
					)
				)				
			)
		);
 }

 function index()
 {
  $this->data['title'] = "Admin Section";
  $this->data['sidebar'] = "<h3>Admin Menu</h3>".anchor('admin/pages', "Edit Pages");
  $this->data['sidebar'] .= "<br/>".anchor('pages/add', "Add Page");
  $this->data['sidebar'] .= "<h3>News Menu</h3>".anchor('admin/news', "View News");
  $this->data['sidebar'] .= "<br/>".anchor('news/add', "Add News");
  $this->layout->view("admin/index", $this->data);
 }

 function pages()
 {
  $this->data['pages'] = $this->Pagesmodel->get_all();
  $this->data['sidebar'] = "<h3>Current Pages <sub>select to edit</sub></h3>";
  foreach ($this->data['pages'] as $page)
	$this->data['sidebar'] .= "<p>".anchor("pages/edit/$page->alias", $page->title) . "</p>";

  $this->data['sidebar'] .= "<p>".anchor("admin", "back") . "</p>";
  $this->layout->view("admin/pages", $this->data);
 }

 function newslist() {
	$data['news'] = $this->Newsmodel->get_all();
	$this->parser->parse("admin/newslist", $data);
 }

 function servicelist() {
        $data['news'] = $this->Servicesmodel->get_all();
        $this->parser->parse("admin/servicelist", $data);
 }

 function news()
 {
 }

 function addgallery()
 {
  $data['title'] = "Add Gallery";
  $data['action'] = "gallery";
  //$data['gallery'] = $this->Gallerymodel->get($gallery);
  $data['level'] = array(1 => 'Registered', 2 => 'Admin', 3 => 'Not sure yet');
  $this->layout->view('admin/addgallery', $data);  
 }

 function gallery()
 {
  $data['title'] = "Select Gallery";
  $gal = $this->Gallerymodel->get();
  foreach ($gal as $g)
	$arr[$g->id] = $g->name;
  $data['gallery'] = $arr;
  $this->layout->view('admin/selectgallery', $data);
 }

 function editgallery()
 {
  $gal = $this->uri->segment(3);
  if (isset($gal))
	$gallery = $gal;
  else
	$gallery = $this->input->post('gallery');
  $data['title'] = "Edit Gallery";
  $data['level'] = array(1 => 'Registered', 2 => 'Admin', 3 => 'Not sure yet');
  $this->session->set_userdata('gallery', $gallery);
  $data['gallery'] = $this->Gallerymodel->get($gallery);
  $this->layout->view('admin/uploadimage', $data);
 }

 function users()
 {
	$data['users'] = $this->Playermodel->get_all();
	$this->layout->view("admin/userlist", $data); 
 }

 function clients()
 {
	$data['title'] = "Client list";
        $data['users'] = $this->Clientmodel->get_all();
        $this->layout->view("admin/clientlist", $data);
 }


        function do_upload()
        {

        if (!empty($_FILES)) {
        $tempFile = $_FILES['file']['tmp_name'];
        $filename = $_FILES['file']['name'];

                $gallery = $this->session->userdata('gallery');
                $directory = getcwd().'/images/gallery/'.$gallery;
                if (!file_exists($directory))
                 mkdir($directory, 0700);

		$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);  //figures out the extension
   
   		$newFileName = md5($tempFile).'.'.$ext; //generates random filename, then adds the file extension
		
                //$targetFile = $directory.'/'.$filename;
		$targetFile = $directory.'/'.$newFileName;
                move_uploaded_file($tempFile, $directory.'/'.$newFileName);
                $data['owner'] = user_id();
                //$data['filename'] = $filename;
                $data['filename'] = $newFileName;
                $data['description'] = $filename;
		$data['album'] = $gallery;
                $id[] = $this->Gallerymodel->addimage($data);
                echo $this->db->last_query();
                echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
        }
        }


	function saveitem()
	{
	$db = $this->input->get("db");
	$db = $db[0];
		$my_foo = $db;
		$a = new $my_foo();
		$i=1;
		foreach ($this->input->get("listItem") as $item)
		{
		 $data['ordering'] = $i;
		 $data['id'] = $item;
		 $i++;
		 $a->save($data);
		}
	echo "Updated";
	}

}

?>
