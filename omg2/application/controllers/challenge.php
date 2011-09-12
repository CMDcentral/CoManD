<?php

class Challenge extends CI_Controller {

	var $ref;

	function Challenge()
	{
	 parent::__construct();
	 $this->load->model("Challengemodel");
         $this->load->model("Clanmodel");
	 $this->load->model("Teammodel");
         $this->load->model("Commentmodel");
	 $this->load->library('layout', 'layout_main');
	 loggedin("player");
	}
	
	function accept() {
	 $data['id'] = $this->uri->segment(3);
	 $chal = $this->Challengemodel->get($data['id']);
	 $data['accepted'] = 1;
	 $data['accepteddate'] = date("Y-m-d H:i:s");
	 $this->Challengemodel->save($data);
	 $data2['info'] = "<a href='/team/view/".$chal->team2.".html'>".team($chal->team2)->t_name . "</a> has agreed to challenge <a href='/team/view/".$chal->team1.".html'>" . team($chal->team1)->t_name . "</a> to a friendly ".$chal->mode." ".$chal->game." game on " . $chal->playdate;
	 log_info($data2);
	 $this->email("chall_accept", $data['id']);
	 redirect($_SERVER['HTTP_REFERER']);
	}

	function create() {
	 $data['title'] = "New Challenge";
	 $this->layout->view("challenge/create", $data);
	}

	function decline() {
         $data['id'] = $this->uri->segment(3);
         $data['accepted'] = 2;
	 $data['notes'] = $this->input->post("notes");
         $data['accepteddate'] = date("Y-m-d H:i:s");
         $this->Challengemodel->save($data);
         $this->email("chall_reject", $data['id']);
         redirect($_SERVER['HTTP_REFERER']);
	}

	function request()
	{
	 $data = $this->input->post();
	 $data['owner'] = user_id();
	 if ($data['team1'] == $data['team2'])
	 {
		message("You can not challenge yourself", "error");
		redirect(ref());
	 }
	 $id = $this->Challengemodel->save($data);
	 $this->email("chall_request", $id);
	 message("You challenge request has been sent", "message");
	 redirect($_SERVER['HTTP_REFERER']);
	}

	function test_email() {
		$this->email("comment", 16);
	}

	function email($template="chall_request", $id)
	{
	$chall = $this->Challengemodel->get($id);
	$leaders = $this->Teammodel->get_teamleaders($chall->team2);
	if ($template == "chall_request") {
	$leaders = $this->Teammodel->get_teamleaders($chall->team2);
	$opp = team($chall->team1);
	$team = team($chall->team2);
	} elseif ($template == "comment") {
	 $leaders =  $this->Teammodel->get_teamleaders($chall->team1, $chall->team2);
         $opp = team($chall->team2);
         $team = team($chall->team1);
	}
	else {
	$leaders = $this->Teammodel->get_teamleaders($chall->team1);
        $opp = team($chall->team2);
        $team = team($chall->team1);
	}
	$data['notes'] = $chall->notes;
	$data['url'] = "www.egamingsa.co.za";
	foreach ($leaders as $leader) {
		$data['requester'] = get_user($chall->owner)->alias;
		$user = get_user($leader->player_id);
		$data['name'] = $user->firstname . " " . $user->lastname;
		$data['clan'] = clan($opp->clan)->name;
		$data['team'] = $team->t_name;
		$data['opponent'] = $opp->t_name;
		$data['time'] = $chall->time;
		$data['id'] = $chall->id;
		$data['game'] = $chall->game;
		$data['controller'] = $this->router->class;
		$data['date'] = $chall->playdate;
		$data['mode'] = $chall->mode;
		$data['maps'] = $chall->maps;
		$content = $this->parser->parse("email/".$template, $data , true);
		mail($user->email, "Challenge Request", $content);
	}
	}

	function join() {
	 $clanid = $this->uri->segment(3);
	 $clan = $this->Clanmodel->get($clanid);
	 if ($this->input->post("password") == $clan->password) {
		 message("You have now joined the clan ".$clan->name, "message");
		 $this->Clanmodel->join($clanid);
	 }
	 else
		message("The password you entered to join the clan is incorrect.", "error");
	 redirect($_SERVER['HTTP_REFERER']);
	}

	function index() {
		$chall = array();
		$data['challenges'] = $this->Challengemodel->get_all();
		$data['oldchallenges'] = $this->Challengemodel->get_historical();
		$teams = $this->Clanmodel->myteams();
		foreach ($teams as $team)
			$chall['teams'][] =  $this->Challengemodel->get_by_team($team->id);

		$data['challenge_requests'] = $chall['teams'];
		$data['title'] = "Challenges";
		$this->layout->view("challenge/list", $data);
	}

	function view() {
	 $data['challenge'] = $this->Challengemodel->get($this->uri->segment(3));
	 $data['comments'] = $this->Commentmodel->get($this->router->class, $this->uri->segment(3));
	 $data['title'] = "Challenge Request";
	 $this->layout->view("challenge/view", $data);
	}

	function comment() {
                message("Comment has been added.", "message");
		$info = $this->input->post();
		$this->email("comment", $info['oid']);
                $this->Commentmodel->save($info);
                redirect(ref());
	}

	function listing() {
	 $data['clans'] = $this->Clanmodel->get_all();
	 $data['title'] = "Clan Listing";
	 $this->layout->view("clan/list", $data);
	}

}
