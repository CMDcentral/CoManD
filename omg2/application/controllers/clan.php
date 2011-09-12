<?php

class Clan extends CI_Controller {

	var $ref;

	function Clan()
	{
	 parent::__construct();
	 $this->load->model("Clanmodel");
         $this->load->model("Teammodel");
	 $this->load->model("Sitemodel");
	}
	
	function challenge()
	{
	 $clan = $this->uri->segment(3);
	 $data['clan'] = $this->Clanmodel->get($clan);
	 $data['teams'] = $this->Clanmodel->get_teams($clan);
	 $data['myclan'] = $this->Clanmodel->myclans();
	 $data['myteams'] = $this->Clanmodel->myteams();
	 $this->load->view("clan/challenge", $data);
	}

	function teams()
	{
	 $clan = $this->uri->segment(3);
	 $data['clan'] = $this->Clanmodel->get($clan);
	 $data['teams'] = $this->Clanmodel->get_teams($clan);
	 $this->load->view("clan/teams", $data);
	}

	function addteam()
	{
	 $clan = $this->uri->segment(3);
	 $data['title'] = "Create Team";
         $data['games'] = $this->Sitemodel->get_games();
	 $data['clan'] = $this->Clanmodel->get($clan);
	 $data['members'] =  $this->Clanmodel->get_members($clan);
	 $this->layout->view("clan/addteam", $data);
	}

	function request() {
	 $clan = $this->uri->segment(3);
	 $data['clan'] = $this->Clanmodel->get($clan);
	 $data['games'] = $this->Sitemodel->get_games();
	 $data['user'] = get_user(user_id());
	 $this->load->view("clan/request", $data);
	}

	function join() {
	 $clanid = $this->uri->segment(3);
	 $clan = $this->Clanmodel->get($clanid);
	 if ($this->input->post("password") == $clan->password) {
		 $this->Clanmodel->join($clanid);
		 message("You have now joined the clan ".$clan->name, "message");
	 }
	 else
		message("The password you entered to join the clan is incorrect.", "error");
	 redirect($_SERVER['HTTP_REFERER']);
	}

        function leave() {
         $clanid = $this->uri->segment(3);
         $clan = $this->Clanmodel->get($clanid);
         if ($this->Clanmodel->leave($clanid)) {
	        message("You have successfully left the clan ".$clan->name, "message");
	 }
         redirect(ref());
        }


	function index() {
	 $data['title'] = "Login / Register";
	 $this->layout->view('login', $data);
	}

	function view() {
	 $data['clan'] = $this->Clanmodel->get($this->uri->segment(3));
	 $data['teams'] = $data['clan']->teams;
	 $data['members'] = $data['clan']->members;
	 $data['inclan'] = $this->Clanmodel->inclan(user_id(), $data['clan']->id);
 	 $data['countries'] = $this->Sitemodel->get_countries();
	 if (sizeof($data['clan']) == 0)
		redirect("home");
	 $data['title'] = $data['clan']->tag . " - " . $data['clan']->name;
	 $this->layout->view("clan/view", $data);
	}

	function listing() {
	 $url = $this->uri->uri_to_assoc();
	 if (!isset($url['filter']))
		$filter = "";
	 else
		$filter = $url['filter'];
	 $data['filter'] = $filter;
	 $data['clans'] = $this->Clanmodel->get_all($filter);
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
	 $data['clan'] = $this->Clanmodel->get($this->uri->segment(3));
	 if (!clanadmin($data['clan']->id))
		redirect("home");
	 $data['members'] = $this->Clanmodel->get_members($this->uri->segment(3));
	 $data['editor'] = true;
	 $data['countries'] = $this->Sitemodel->get_countries();
	 $data['teams'] = $this->Clanmodel->get_teams($this->uri->segment(3));
	 $data['action'] = "edit";
	 $data['title'] = "Edit Clan";
	 $this->layout->view("clan/edit", $data);
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
		message("Clan changes have been updated successfully", "message");
		$data = $this->input->post();

		if (!isset($data['id'])) {
		 $this->form_validation->set_rules('name', 'Clan name', 'trim|required|min_length[3]|max_length[50]|xss_clean|unique[jos_bl_clan.name]');
                 $this->form_validation->set_rules('tag', 'Clan tag', 'trim|required|min_length[2]|max_length[10]|xss_clean|unique[jos_bl_clan.tag]');
	         if ($this->form_validation->run() == FALSE)
        	 {
                  message(validation_errors(), "error");
                  redirect(ref());
	         }
		}

		$id = $this->Clanmodel->save($data);
//		print_r($_FILES);
		if ($_FILES['t_logo']['name'])
			$this->do_upload($id);
		if (!isset($data['id']))
			$this->Clanmodel->join($id);
		message("Clan changes have been updated successfully", "message");
		redirect("clan/edit/".$id);
	}

	function role_save() {
		message("Clan changes have been updated successfully", "message");
		$data = $this->input->post();
		$id = $this->Clanmodel->role_save($data);
	}
	function saveteam() {
         message("Team changes have been updated successfully", "message");
	 $data = $this->input->post();
	 $data['clan'] = $this->uri->segment(3);
	 $team = $this->Teammodel->save($data);
	 foreach ($data['player'] as $player)
		if (isset($player['player_id'])) {
			$pid = $player['player_id'];
			$role = $player['role'];
		$this->Clanmodel->playerteam_save($team, $pid, $role);
		}
	redirect("/team/edit/".$team);
	}

        function do_upload($id)
        {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']     = '500';

        $this->load->library('upload', $config);

         foreach ($_FILES as $key => $value)
                $field = $key;

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
                        $id = $this->Clanmodel->save($data);
                }
        redirect(ref());
        }


}
