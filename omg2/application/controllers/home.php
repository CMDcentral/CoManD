<?
class Home extends CI_Controller {

 function __construct()
 {
	parent::__construct();
	$config['base_url'] = '/home/index/';
	$this->load->model("Newsmodel");
        $this->load->model("Productmodel");
        $this->load->model("Activitymodel");
 }

 function index() {
	$this->load->model("Homemodel");

	$offset=$this->uri->segment(3);
        $limit=5;

	$slider = $this->Homemodel->get_all(4,0,1);
	$data['maintop'] = true;
	$config["total_rows"] = $this->Newsmodel->get_count(2);
        $config["per_page"] = $limit;
        $config['base_url'] = '/home/index/';

	$ig['categories'] = $this->Newsmodel->get_categories(4, true, true);
//	$ig['articles'] = $this->Homemodel->get_all($limit, $offset ,4);
//	$data['infogrid'] = $this->load->view("home/infogrid", $ig, TRUE);
	$data['subarticles'] = $this->Homemodel->get_all($limit, $offset , 5, 0, "created", "DESC");
        $this->pagination->initialize($config);

        $data['articles'] = $this->Homemodel->get_all($limit, $offset , 2);
		
	$data['products'] = $this->Productmodel->get_all(0, 3);
	$data2['articles'] = $slider;
	$data['slider'] = $this->load->view("home/slider", $data2, TRUE);
	$data['title'] = "Luxury web services.";
        $this->layout->view('home/index', $data);
 }

 function newsfeed() {
        $this->db->order_by('added', 'desc');
        $items = $this->Activitymodel->get();
	$data['title'] = "Newsfeed";
	$data['newsfeed'] = $items;
	$this->layout->view("home/newsfeed", $data);
 }
}
?>
