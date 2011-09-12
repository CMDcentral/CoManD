<?php

class Stage extends CI_Controller {
        var $ckeditor = array(
                        'id'    =>	'rules',
                        'path'  =>	'js/ckaeditor',
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

	function Stage()
	{
	 parent::__construct();
	 $this->load->model("Leaguemodel");
         $this->load->model("Stagemodel");
         $this->load->model("Sitemodel");
	 $this->load->model("Clanmodel");
	}
	
	function join() {
	 $stageid = $this->uri->segment(3);
	 $data['stage'] = $this->Stagemodel->get($stageid);
	 $data['league'] = $this->Leaguemodel->get($data['stage']->t_id);
	 $data['teams'] = $this->Clanmodel->myteams();
	 $this->load->view("stage/join", $data);
	}

        function join_stage()
        {
                $data = $this->input->post();
		//print_r($data);
		$stage = $this->Stagemodel->get($data['season_id']);
		$team = $this->Teammodel->get($data['team_id']);
		$league = $this->Leaguemodel->get($stage->t_id);
		if ( count($team->members) >= $league['info']->minPlayers && count($team->members) <= $league['info']->maxPlayers ) {
		if ($this->Stagemodel->save_teamseason($data))
			message("Your team has been successfully entered into the Tournament", "message");
		else
			message("Your team already appears to be participating in this Tournament", "error");
		}
		else {
			message("Your submitted team does not meet the requirements<br/>Min Players: ".$league['info']->minPlayers . "<br/>Max Players: ".$league['info']->maxPlayers."<br/>Your team: ".count($team->members), "error");
		}
                redirect(ref());
        }

	function index() {
	}

	function view() {
	 $stageid = $this->uri->segment(3);
         $data['stage'] = $this->Stagemodel->get($stageid);
         $data['league'] = $this->Leaguemodel->get($data['stage']->t_id);
	 $data['title'] = $data['league']['info']->name . " " . $data['stage']->s_name;
	 $this->layout->view("stage/view", $data);
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

	function edit()
	{
	 $this->add("edit");
	}

	function add($method="add")
	{
         if (!admin())
                redirect("home");
	 $data['stage'] = $this->Stagemodel->get($this->uri->segment(3));
         $data['leagues'] = $this->Leaguemodel->get_all();
	 foreach ($data['leagues'] as $league)
		$arr[$league->id] = $league->name;

	 $data['leaguedropdown'] = $arr;
         $data['method'] = $method;
	 $data['editor'] = true;
         $data['title'] = "League Stage Management";
         $this->layout->view("stage/edit", $data);
	}

	function save()
	{
		message(ucfirst($this->router->class). " has been updated successfully", "message");
		$data = $this->input->post();
		$id = $this->Stagemodel->save($data);
		redirect("stage/edit/".$id);
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
                        $id = $this->Categorymodel->save($data);
                }
        redirect(ref());
        }

}
