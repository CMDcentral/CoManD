<?
class Ajax extends CI_Controller {

	function __construct() {
	 parent::__construct();
	 $this->load->model("Sitemodel");
	 $this->load->model("Teammodel");
	 $this->load->model("Clanmodel");
	 $this->load->model("Playermodel");
	}

	function search() {
	 $clans = $this->Clanmodel->get_all($this->input->get("term"));
	 $i=0;
	 foreach ($clans as $clan) {
		$arr[$i]['id'] = $clan->id;
		$arr[$i]['value'] = $clan->name;
		$arr[$i]['label'] = $clan->name;
		$arr[$i]['type'] = "clan";
		$i++;
	 }

	$arr[$i]['id'] = "";
	$arr[$i]['value'] = "Players";
	$arr[$i]['label'] = "Players";
	$i++;

         $clans = $this->Playermodel->get_all($this->input->get("term"));
         foreach ($clans as $clan) {
                $arr[$i]['id'] = $clan->id;
                $arr[$i]['value'] = $clan->alias;
                $arr[$i]['label'] = $clan->alias;
                $arr[$i]['type'] = "player";
                $i++;
         }

        $arr[$i]['id'] = "";
        $arr[$i]['value'] = "Teams";
        $arr[$i]['label'] = "Teams";
        $i++;

         $teams = $this->Teammodel->get_all($this->input->get("term"));
         foreach ($teams as $clan) {
                $arr[$i]['id'] = $clan->id;
                $arr[$i]['value'] = $clan->t_name;
                $arr[$i]['label'] = $clan->t_name;
                $arr[$i]['type'] = "team";
                $i++;
         }

	

	 echo json_encode($arr);
	}

}
