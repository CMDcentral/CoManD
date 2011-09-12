<? class Todo extends CI_Controller
{

function __construct() {
	parent::__construct();
	$this->load->model("Todomodel");
}
function index() {
 echo "todo";
}

function add() {
 $data['fields'] = $this->Todomodel->fields(); 
 $this->load->view("todo/add", $data);
}

function save() {
 $data = $this->input->post();
 $this->Todomodel->add($data);
 redirect($_SERVER['HTTP_REFERER']);
}
}
?>
