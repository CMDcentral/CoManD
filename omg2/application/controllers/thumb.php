<?
error_reporting(0);
class Thumb extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->library('image_lib');
    }

    public function index($img="") {
        $url = $this->uri->uri_to_assoc();
	$image = $_GET['i'];
        $config['source_image'] = getcwd()."/".$image;
        $config['width'] = $url['width'];
        $config['height'] = $url['height'];
        $config['maintain_ratio'] = TRUE;
        $config['dynamic_output'] = true;
        $this->image_lib->initialize($config);
	$this->image_lib->resize();
    }

    function online() {
        $url = $this->uri->uri_to_assoc();
        $image = $_GET['i'];
        $config['source_image'] = getcwd()."/".$image;
        $config['width'] = $url['width'];
        $config['height'] = $url['height'];
        $config['maintain_ratio'] = TRUE;
        $config['dynamic_output'] = true;
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
    }

    public function gen()
    {
	$url = $this->uri->uri_to_assoc();
	$folder = explode("-", $url['folder']);
	if (sizeof($folder)>1)
        $config['source_image'] = getcwd()."/images/".$folder[0]."/".$folder[1]."/".$url['image'];
	else
	$config['source_image'] = getcwd()."/".$url['f2']."/".$folder[0]."/".$url['image'];
        $config['width'] = $url['width'];
        $config['height'] = $url['height'];
	$config['maintain_ratio'] = TRUE;
        $config['dynamic_output'] = true;
 
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
    }

    function profile_gen()
    {
    	$url = $this->uri->uri_to_assoc();
	$player = $url['player'];
	$user = get_user($player);
        $config['source_image'] = getcwd(). "/images/profile/".$user->avatar;
        $config['width'] = $url['width'];
        $config['height'] = $url['height'];
        $config['maintain_ratio'] = TRUE;
        $config['dynamic_output'] = true;

        $this->image_lib->initialize($config);
        $this->image_lib->resize();

    }
 
}
?>
