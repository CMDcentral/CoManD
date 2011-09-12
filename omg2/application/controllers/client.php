<?php

class Client extends CI_Controller {

	var $ref;

	function Client()
	{
	 parent::__construct();
	 $this->load->model("Clientmodel");
	 $this->load->library('layout', 'layout_main');  
	}

	function login()
	{
	global $ref;
	$ref = $this->agent->referrer();
	$data = array(
               'title' => 'My Title',
               'heading' => 'My Heading',
               'message' => 'My Message'
          );
	   $this->parser->parse('login', $data);
	}


	 function validate()
    	 {
	  $ref = "/client/";
          $user = $this->input->post('user');
          if ($this->Clientmodel->authenticate($user['email'], $user['password']))
         {
          $this->session->set_userdata('loggedinclient', true);
	  success("Login successful", "success");
         }
	 else
	  success("Login unsuccessful, please check your credentials and try again", "error");
        
	 redirect($ref);
       }

    	function logout()
    	{
         $this->session->unset_userdata('loggedinclient');
         redirect('/');
    	}

	function edit()
	{
	 $data['user'] = $this->Clientmodel->get($this->uri->segment(3));
	 $data['action'] = "edit";
	 $this->load->view("client/edit", $data);
	}

        function add()
        {
         $data['action'] = "add";
         $this->load->view("client/edit", $data);
        }

	function save()
	{
		success("User changes have been successfully recorded", "success");
		$ref = $_SERVER['HTTP_REFERER'];
		$this->Clientmodel->save($this->input->post());
		redirect($ref);
	}

	function dropbox()
	{
		$data['clients'] = $this->Clientmodel->get_all();
		$this->load->view("client/dropbox", $data);
	}

}
