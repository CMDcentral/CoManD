<?
class Email extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("Clanmodel");
		$this->load->model("Sitemodel");
	}

	function index() {
		$data['title'] = "Contact Us";
		$this->layout->view("contact/email", $data);
	}

	function request() {
		$data = $this->input->post();
		//subject, message, recipient;
		$clan = $this->Clanmodel->get($data['clan']);
		$owner = get_user($clan->owner);
		$data['owner'] = $owner->firstname . " " . $owner->lastname;
		$data['clan'] = $clan->name;
		$data['clanid'] = $clan->id;
		$games = $this->Sitemodel->get_games();
		$data['game'] = $games[$data['game']];
		$user = get_user(user_id());
		$data['email'] = $user->email;
		$message = $this->parser->parse("email/request", $data, true);
		$tosend['msg'] = $message;
		$tosend['recipient'] = $owner->email;
		$tosend['subject'] = $data['clan'] . " player application from eGSA";
		$from['name'] = $user->firstname.  " " . $user->lastname;
		$from['email'] = $user->email;
		email($tosend, $from);
		message("Your application has been sent to the clan owner.", "message");
		redirect(ref());
	}

	function contact() {
		$data = $this->input->post();
                $tosend['msg'] = $data['message'];
                $tosend['recipient'] = "calvin@istreet.co.za";
                $tosend['subject'] = $data['subject'];
                $from['name'] = $data['first_name'] . " " . $data['last_name'];
                $from['email'] = $data['email'];
                email($tosend, $from);
		message("Your e-mail has been sent, thank you for your enquiry.", "message");
		redirect(ref());
	}
}
?>
