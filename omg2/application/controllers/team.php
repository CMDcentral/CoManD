<?php

class Team extends CI_Controller {

	var $ref;

	function Team()
	{
	 parent::__construct();
	 $this->load->model("Teammodel");
         $this->load->model("Leaguemodel");
         $this->load->model("Clanmodel");
         $this->load->model("Sitemodel");
	 $this->load->library('layout', 'layout_main');  
	}

	function teams()
	{
	 $clan = $this->uri->segment(3);
	 $data['clan'] = $clan;
	 $data['teams'] = $this->Clanmodel->get_teams($clan);
	 $this->load->view("clan/teams", $data);
	}

	function addteam()
	{
	 $clan = $this->uri->segment(3);
	 $data['games'] = $this->Sitemodel->get_games();
	 $data['clan'] = $this->Clanmodel->get($clan);
	 $data['members'] =  $this->Clanmodel->get_members($clan);
	 $this->load->view("clan/addteam", $data);
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
	 $data['title'] = "Login / Register";
	 $this->layout->view('login', $data);
	}

	function view() {
	 $id = $this->uri->segment(3);	
	 $data['teams'] = $this->Teammodel->get($id);
	 $data['leagues'] = $this->Leaguemodel->in_league($id);
	 $data['clan'] = $this->Clanmodel->get($data['teams']->clan);
	 $data['title'] = "View Team";
	 $this->layout->view("team/view", $data);
	}

	function listing() {
	 $data['clans'] = $this->Clanmodel->get_all();
	 $data['title'] = "Clan Listing";
	 $this->layout->view("clan/list", $data);
	}

	function login()
	{
	global $ref;
	$ref = $this->agent->referrer();
	//echo $this->Usermodel->_prep_password("piadavid");
	 $data = array(
               'title' => 'My Title',
               'heading' => 'My Heading',
               'message' => 'My Message'
          );
	   $this->parser->parse('login', $data);
	}


	 function validate()
    	 {
          $user = $this->input->post('player');
          if ($this->Playermodel->authenticate($user['email'], $user['password']))
         {
		message("You have been successfully logged in", "message");
         }
	 else
	 	message("Login unsuccessful, please check your credentials and try again", "error");
        
	 redirect("player/profile");
       }

    	function logout()
    	{
         $this->session->unset_userdata('loggedin');
         redirect('/');
    	}

	function information()
	{
	 $this->load->view("player/information");
	}

	function rig()
	{
	 $this->load->view("player/rig");
	}

	function edit()
	{
	 $data['team'] = $this->Teammodel->get($this->uri->segment(3));
         if (!clanadmin($data['team']->clan))
         {
          message("nice try", "error");
          redirect("home");
         }
	 $this->session->set_userdata('clan', $data['team']->clan);
	 $data['members'] = $this->Teammodel->get_members($data['team']->clan);
	 $data['action'] = "edit";
	 $data['games'] = $this->Sitemodel->get_games();
	 $data['title'] = "Edit Team " . $data['team']->t_name;
	 $this->layout->view("team/edit", $data);
	}

	function delete()
	{
	message("The team has been deleted successfully", "message");
	$id = $this->uri->segment(3);
	$team = $this->Teammodel->get($id);
	$this->Teammodel->delete($id);
	redirect("clan/view/".$team->clan);
	}

	function delete_member()	
	{
	 $id = $this->uri->segment(3);
	 $clan = $this->session->userdata("clan");
	 if (!clanadmin($clan))
         {
          message("nice try", "error");
          redirect($_SERVER['HTTP_REFERER']);
         }
	 $data['id'] = $id;
	 $this->Teammodel->delete_member($data);
	 message("Player has been remove from the team", "message");
	 redirect($_SERVER['HTTP_REFERER']);
	}

        function register()
        {
	 loggedin("player");
         $data['action'] = "add";
	 $data['title'] = "Register Clan";
         $this->layout->view("clan/register", $data);
        }

	function profile()
	{
	 $data['title'] = "Edit Your Details";
	 $this->layout->view("player/profile", $data);
	}

	function save()
	{
		message("Team changes have been updated successfully", "message");
		$data = $this->input->post();
		$id = $this->Teammodel->save($data);
		//$this->do_upload($id);
		redirect("clan/view/".$id);
	}

	function role_save() {
		message("Clan changes have been updated successfully", "message");
		$data = $this->input->post();
		$id = $this->Clanmodel->role_save($data);
	}
	function saveteam() {
         message("Team changes have been updated successfully", "message");
	 $data = $this->input->post();
	 $team = $this->Teammodel->team_save($data);
	 $data['clan'] = $this->session->userdata("clan");
	 $this->do_upload($team);
	 foreach ($data['player'] as $player) {
		$player['team_id'] = $team;
		if (isset($player['player_id']) || isset($player['id'])) {
			$this->Teammodel->playerteam_save($player);
		}
	}
	 redirect($_SERVER['HTTP_REFERER']);
	 }

        function do_upload($id)
        {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']     = '500';

        $this->load->library('upload', $config);

         foreach ($_FILES as $key => $value)
                $field = $key;

        if ($_FILES[$field]['size'] == 0)
                return false;

        if (!$this->upload->do_upload($field))
                {
                        $error = array('error' => $this->upload->display_errors());
                        message( $this->upload->display_errors(), "error");
                        redirect(ref());
                }
                else
                {
                        message("File uploaded successfully", "message");
                        $data['id'] = $id;
                        $info =  $this->upload->data();
                        $data[$field] = $info["file_name"];
                        $id = $this->Teammodel->save($data);
                }
        redirect(ref());
        }


}
