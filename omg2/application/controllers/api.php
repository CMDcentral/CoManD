<?
class Api extends CI_Controller {

function __construct() {
	parent::__construct();
	$this->load->model("Clanmodel");
}

function get_clans() {
	$i=0;
	$clan = $this->Clanmodel->get_all();
	foreach ($clan as $c) {
		$a['name'] = $c->name;
		$a['tag'] = $c->tag;
		$a['members'] = $c->members;
		$a['url'] = $c->url;
		$thearray[$i] = $a;
		$i++;
	}
		
	echo json_encode($thearray);
}

} //end class
?>
