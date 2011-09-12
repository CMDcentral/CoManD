<?
class Video extends CI_Controller {

function Video() {
 parent::__construct();
 $this->load->model('Videomodel');
 $this->load->model('Commentmodel');
 $this->load->model('Newsmodel');
}

function edit() {
         if (!admin())
         {
            redirect('home');
         }
         $data['title'] = "Edit/Add Video";
         $data['categories'] = $this->Newsmodel->get_categories(6, true);
	 $data['video'] = $this->Videomodel->get($this->uri->segment(3));
         $this->load->view("video/edit", $data);
}

function index() {
 $data['title'] = "Gallery";
 $data['category'] = $this->Newsmodel->get_categories(6, true);
 $data['videos'] = $this->Videomodel->get_all();
 $this->layout->view('video/index', $data);
}

function listing() {
 $data['title'] = "Video List";
 $data['category'] = $this->Newsmodel->get_categories(6, true);
 $data['videos'] = $this->Videomodel->get_all();
 $this->layout->view('video/list', $data);
}


function save()
{
 $data = $this->input->post();
 $id = $this->Videomodel->save($data);
 redirect(ref());
}

function view()
{
 $gallery = $this->uri->segment(3);
 $data['video'] = $this->Videomodel->get($gallery);
 $data['comments'] = $this->Commentmodel->get($this->router->class, $gallery);
 $data['title'] = $data['video']->title;
 $this->layout->view("video/view", $data);
}

        function image_delete() {
         $id = $this->uri->segment(3, 0);
         $this->Videomodel->delete($id);
         redirect(ref());
        }

        function delete() {
         $id = $this->uri->segment(3, 0);
         $this->Videomodel->delete($id);
         redirect(ref());
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
