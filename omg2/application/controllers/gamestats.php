<?
class Gamestats extends CI_Controller {

function __construct() {
	parent::__construct();
	$this->load->model("Gamemodel");
}

function teeworlds() {
	$data['title'] = "eGSA Teeworld Server Stats";
	$data['game'] = $this->Gamemodel->get(6);
	$this->layout->view("stats/teeworld", $data);
}

function bfbc2() {
        $data['title'] = "eGSA Bad Company 2 Stats";
        $data['game'] = $this->Gamemodel->get(1);
	$this->layout->view("stats/bfbc2", $data);
}

function bfbc2_clan() {
        $data['title'] = "eGSA Bad Company 2 Stats";
        $data['game'] = $this->Gamemodel->get(1);
        $this->layout->view("stats/bfbc2_clan", $data);
}

function clan_stats() {
	$this->load->view("stats/results");
	}

function dogtags() {
        $this->load->view("stats/dogtags");
        }
}
?>
