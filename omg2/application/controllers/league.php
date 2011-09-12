<?php

class League extends CI_Controller {
        var $ckeditor = array(
                        'id'    =>	'rules',
                        'path'  =>	'js/ckeditor',
                        'config' => array(
                                'toolbar'	=>	"Full",         //Using the Full toolbar
                                'width'         =>	"700px",        //Setting a custom width
                                'height'        =>	'500px',        //Setting a custom height

                        ),
                        'styles' => array(
                                'style 1' => array (
                                        'name'          =>	'Blue Title',
                                        'element'	=>	'h2',
                                        'styles' => array(
                                                'color'         =>	'Blue',
                                                'font-weight'   =>	'bold'
                                        )
                                ),
                                'style 2' => array (
                                        'name'  =>	'Red Title',
                                        'element'	=>	'h2',
                                        'styles' => array(
                                                'color'                 =>	'Red',
                                                'font-weight'           =>	'bold',
                                                'text-decoration'	=>	'underline'
                                        )
                                )
                        )
                );

	var $ref;

	function League()
	{
	 parent::__construct();
	 $this->load->model("Leaguemodel");
         $this->load->model("Gamemodel");
         $this->load->model("Stagemodel");
         $this->load->model("Sitemodel");
	 $this->load->model("Clanmodel");
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

	function info()
	{
	 $t = $this->Leaguemodel->get($this->uri->segment(3));
	 $data['title'] = $t['info']->name;
	 $data['tournament'] = $t;
	 $this->layout->view("league/rules", $data);
	}

	function rules()
	{
	 $this->info();
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
         $data['games'] = $this->Sitemodel->get_games();
	 $data['clan'] = $this->Clanmodel->get($clan);
	 $data['members'] =  $this->Clanmodel->get_members($clan);
	 $this->load->view("clan/addteam", $data);
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
	 $data['title'] = "eGSA League's";
	 $data['games'] = $this->Gamemodel->get_all(true);
	 $data['league'] = $this->Leaguemodel->get_all();
	 $this->layout->view('league/index', $data);
	}

	function view() {
	 $league = $this->Leaguemodel->get($this->uri->segment(3));
	 $data['league'] = $league['info'];
	 $data['stages'] = $this->Stagemodel->get_all($league['info']->id);
	 $data['title'] = $league['info']->name;
	 $this->layout->view("league/view", $data);
	}

	function game() {
	 $data['title'] = "Active Leagues";
	 $data['game'] = $this->Gamemodel->get($this->uri->segment(3));
	 $data['leagues'] = $this->Leaguemodel->get_all("", $data['game']->id);
//	 echo $this->db->last_query();
	 $this->layout->view("league/game", $data);
	}

	function listing() {
	 $data['clans'] = $this->Clanmodel->get_all($this->input->post('search'));
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
	 $this->add("edit");
	}

	function add($method="add")
	{
         if (!admin())
                redirect("home");
         $data['league'] = $this->Leaguemodel->get($this->uri->segment(3));
	 $data['games'] = $this->Sitemodel->get_games();
	 $data['ckeditor'] = $this->ckeditor;
	 $data['editor'] = true;
         $data['method'] = $method;
         $data['title'] = "League Management";
         $this->layout->view("league/edit", $data);
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
                message("League has been updated successfully", "message");
                $data = $this->input->post();
                $id = $this->Leaguemodel->save($data);
//                $this->do_upload($id);
                redirect("league/edit/".$id);
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
	 $team = $this->Clanmodel->team_save($data);
	 foreach ($data['player'] as $player)
		if (isset($player['player_id'])) {
			$pid = $player['player_id'];
			$role = $player['role'];
		$this->Clanmodel->playerteam_save($team, $pid, $role);
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
                        $info = $this->upload->data();
                        $data[$field] = "/uploads/".$info["file_name"];
                        $id = $this->Leaguemodel->save($data);
                }
        }

}
