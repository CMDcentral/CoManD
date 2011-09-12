<?php

class User extends CI_Controller {

	var $ref;

	function User()
	{
	 parent::__construct();
	 $this->load->model("Usermodel");
         //parent::__construct();
	 $this->load->library('layout', 'layout_main');  
	}

	function index() {
	 $this->layout->view('login');
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
	  $ref = "/admin/";
          $user = $this->input->post('user');
          if ($this->Usermodel->authenticate($user['email'], $user['password']))
         {
          $this->session->set_userdata('loggedin', true);
	  $this->session->set_flashdata('message', '<div class="success">Login successful.</div>');
         }
	 else
	  $this->session->set_flashdata('message', '<div class="error">Login unsuccessful, please check your credentials and try again.</div>');
        
	 redirect($ref);
       }

    	function logout()
    	{
         $this->session->unset_userdata('loggedin');
         redirect('/');
    	}

	function edit()
	{
	 $data['user'] = $this->Usermodel->get($this->uri->segment(3));
	 $data['action'] = "edit";
	 $this->load->view("users/edit", $data);
	}

        function add()
        {
         $data['action'] = "add";
         $this->load->view("users/edit", $data);
        }

	function save()
	{
		print_r($this->input->post());
		success("User changes have been successfully recorded", "success");
		$ref = $_SERVER['HTTP_REFERER'];
		$this->Usermodel->save($this->input->post());
		redirect($ref);
	}

}
