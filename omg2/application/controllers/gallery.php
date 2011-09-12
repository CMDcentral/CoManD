<?
class Gallery extends CI_Controller {

function Gallery() {
 parent::__construct();
 $this->load->model('Gallerymodel');
}

 function addgallery()
 {
  $data['title'] = "Add Gallery";
  $data['type'] = "player";
  $data['level'] = array(1 => 'All');
  $this->layout->view('admin/addgallery', $data);
 }

 function editgallery() {
  $gal = $this->uri->segment(3);
  if (isset($gal))
        $gallery = $gal;
  else
        $gallery = $this->input->post('gallery');

  $data['title'] = "Edit Gallery";
  $data['level'] = array(1 => 'All');
  $this->session->set_userdata('gallery', $gallery);
  $data['gallery'] = $this->Gallerymodel->get($gallery);
  if (!admin()) {
  if ($data['gallery'][0]->owner != user_id())
	redirect("home");
  }
  $this->layout->view('admin/uploadimage', $data);
 }

function index() {
 $data['title'] = "Albums";
 $data['gallery'] = $this->Gallerymodel->get(0, $this->router->class);
 $this->layout->view('gallery/index', $data);
}

function save()
{
 $data = $this->input->post();
 $id = $this->Gallerymodel->save($data);
 $this->session->set_userdata('gallery', $id);
 redirect("gallery/editgallery/".$id);
}

function images() {
 $gallery = $this->uri->segment(3);
 $data['gallery'] = $this->Gallerymodel->get($gallery);
 $data['images'] = $this->Gallerymodel->get_images($gallery);
 $this->load->view("gallery/images", $data);
}

function view()
{
 $gallery = $this->uri->segment(3);
 $data['gallery'] = $this->Gallerymodel->get($gallery);
 $data['images'] = $this->Gallerymodel->get_images($gallery);
 $data['title'] = $data['gallery'][0]->name;
 $this->layout->view("gallery/images", $data);
}

        function image_delete() {
         $id = $this->uri->segment(3, 0);
         $this->Gallerymodel->delete_images($id);
         redirect(ref());
        }

        function delete() {
         $id = $this->uri->segment(3, 0);
         $this->Gallerymodel->delete($id);
         redirect("gallery");
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


}
?>
