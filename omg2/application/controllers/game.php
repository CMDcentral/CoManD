<?php

class Game extends CI_Controller {

	function Game()
	{
         parent::__construct();
	 $this->load->model('Gamemodel');
         $this->load->model('Sitemodel');
         $this->load->model('Newsmodel');
	}

        function do_upload($id)
        {
        $config['upload_path'] = './images/games/';
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
                        $data[$field] = "/images/games/".$info["file_name"];
                        $id = $this->Gamemodel->save($data);
                }
        redirect(ref());
        }

	function listing() {
         $data['title'] = "eGaming South Africa Games List";
         $data['games'] = $this->Gamemodel->get_all();
         $this->layout->view('game/listing', $data);
	}

	function index()
	{
	 $data['title'] = "eGaming South Africa Games List";
	 $data['games'] = $this->Gamemodel->get_all();	
         $this->layout->view('game/index', $data);
	}

	function view()
	{
	 $id = $this->uri->segment(3);
	 $member = $this->Membermodel->get($id);
	 if (sizeof($member) == 0)
		redirect("member");
	 $data['title'] = $member[0]->name;
	 $data['member'] = $member[0];
         $this->layout->view('member/view', $data);
	}

	function edit()
	{
         if (!admin())
            redirect('home');
	 $data['title'] = "Edit Game";
	 $id = $this->uri->segment(3, 0);
	 $data['game'] = $this->Gamemodel->get($id);
	 $this->load->view("game/edit", $data);
	}

	function save() {
 	$id = $this->Gamemodel->save($this->input->post());
	$this->do_upload($id);
                if ($id != 0) {
                 message(ucfirst($this->router) ." changes saved successfully", 'message');
                 redirect(ref());
          	}
	}
	
	function contacts($id)
	{
	 echo form_dropdown('clientContact', $this->Clientmodel->contactlist($this->uri->segment(3, 0)), "");
	}
	
	function delete() {
	 $ref = $this->agent->referrer();
	 $id = $this->uri->segment(3, 0);
	 if ($this->Categorymodel->delete($id))
	  message("Category has been deleted.", "message");
	 else
	  message("Unable to delete the category", "error");;
	 redirect($ref);
	}

	function auth()
	{
	 $id = $this->uri->segment(3, 0);
	 $users = $this->Employeemodel->get_authorised_count();	 
	 $limit = $this->Employeemodel->get_user_limit();
	 if ($users >= $limit)
	 { echo "Current user limit of $limit has been reached"; }
	 else {
	  $user = $this->Employeemodel->get($id);
	  $data['user'] = $user['details'];
	  $this->parser->parse('employee/auth', $data);
	}
	}

}
