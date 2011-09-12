<?
class Dropbox extends CI_Controller {

 var $data;

 function Dropbox()
 {
	parent::__construct();
	$this->load->model("Pagesmodel");	
	$this->load->model("Dropboxmodel");
 }

 function index()
 {
         if (!$this->session->userdata('loggedin'))
         {
            redirect('/');
         }
  $this->data['title'] = "DropBox";
  $this->data['files'] = $this->Dropboxmodel->get();
  $this->data['folders'] = $this->folders();
        $tmpl = array ( 'table_open'  => '<table border="0" width="100%" cellpadding="0" cellspacing="1" id="project" class="tablesorter">' );
        $this->table->set_template($tmpl);
        $this->table->set_heading('ID', 'Filename', 'Added', 'Owner');

         foreach($this->Dropboxmodel->get() as $row)
         {
          $date = date("d M Y H:i:s" , strtotime($row->added));
          $this->table->add_row($row->id, "<a href='/dropbox/".$row->filename."'>".$row->filename."</a>", $date, $row->owner, anchor('dropbox/delete/'.$row->id, 'Delete', array('class' => 'confirmClick', 'title' => $row->filename)));
         }
  $this->data['table'] = $this->table->generate();
  $this->layout->view("dropbox/index", $this->data);
 }

 function addgallery()
 {
  $data['title'] = "Add Gallery";
  //$data['gallery'] = $this->Gallerymodel->get($gallery);
  $this->layout->view('admin/addgallery', $data);  
 }
 
 function addfolder($name)
 {
  $data['name'] = $this->input->post('name');
  $data['owner'] = $this->session->userdata('user')->id;
  $this->db->insert('folder', $data);
 }
 
 function folders()
 {
  $query = $this->db->get('folder');
  return $query->result();
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
         if (!$this->session->userdata('loggedin'))
         {
            redirect('/');
         }
  $gal = $this->uri->segment(3);
  if (isset($gal))
	$gallery = $gal;
  else
	$gallery = $this->input->post('gallery');
  $data['title'] = "Edit Gallery";
  $this->session->set_userdata('gallery', $gallery);
  $data['gallery'] = $this->Gallerymodel->get($gallery);
  $this->layout->view('admin/uploadimage', $data);
 }

 function delete()
 {
  $ref = $_SERVER['HTTP_REFERER'];
  $id = $this->uri->segment(3);
  $this->Dropboxmodel->delete($id);
  $this->session->set_flashdata('message', '<div class="success">File has been deleted.</div>');
  redirect($ref);
 }

 function do_upload()
        {
	$ref = $_SERVER['HTTP_REFERER'];
        if (!empty($_FILES)) {
        $tempFile = $_FILES['file']['tmp_name'];
        $filename = $_FILES['file']['name'];
                $directory = getcwd().'/dropbox/';
                if (!file_exists($directory))
                 mkdir($directory, 0700);

                $targetFile = $directory.'/'.$filename;
                move_uploaded_file($tempFile, $directory.'/'.$filename);
                $data['owner'] = $this->session->userdata('user')->id;
                $data['filename'] = $filename;
		$data['folder'] = $this->input->post('folder');
                $id[] = $this->Dropboxmodel->add($data);
		$this->session->set_flashdata('message', '<div class="success">File upload complete.</div>');
		redirect($ref);

        }
        }

 function login()
 {
  $data['title'] = "Dropbox Login";
  $this->layout->view("dropbox/login", $data);
 }

 function getfolders()
 {
	$output = '<select name="folder">';
	foreach ($this->folders() as $folder)
	 $output .= '<option value="'.$folder->id.'">'.$folder->name.'</option>';
	$output .= "</select>";
	echo $output;
 }

 function get_results()
 {
	$folder = $this->uri->segment(3);
        $tmpl = array ( 'table_open'  => '<table border="0" width="100%" cellpadding="0" cellspacing="1" id="project" class="tablesorter">' );
        $this->table->set_template($tmpl);
        $this->table->set_heading('ID', 'Filename', 'Added', 'Owner');

         foreach($this->Dropboxmodel->get(0, $folder) as $row)
         {
          $date = date("d M Y H:i:s" , strtotime($row->added));
          $this->table->add_row($row->id, "<a href='/dropbox/".$row->filename."'>".$row->filename."</a>", $date, $row->owner, anchor('dropbox/delete/'.$row->id, 'Delete', array('class' => 'confirmClick', 'title' => $row->filename)));
         }
  echo $this->table->generate();
 }

}

?>
