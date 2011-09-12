<?php

class Player extends CI_Controller {

	var $ref;

	function Player()
	{
	 parent::__construct();
	 $this->load->model("Playermodel");
         $this->load->model("Activitymodel");
         $this->load->model("Sitemodel");
         $this->load->model("Clanmodel");
         $this->load->model("Gallerymodel");
	}

	function forgot() {
	 $data['title'] = "Forgot your Password?";
	 $this->layout->view("player/forgot", $data);
	}

	function status() {
	 $status = $this->input->get("tags");
	 $status = strip_tags($status);
	 $data['cb_status'] = $status;
	 $data['id'] = user_id();
	 if ($this->Playermodel->save($data)) {
		echo "Updated";
	if ($data['cb_status']	!= "") {
	 $user = get_user(user_id());
	 $data2['owner'] = $user->id;
         $data2['info'] = "<a href='/player/view/".$user->id.".html'>".$user->alias. "</a> says '".$user->cb_status."'";
         log_info($data2);
	}
	 }
	 else
		echo "Error updating status";
	}

	function processforgot() {
	 $email = $this->input->post("email");
	 $user = $this->Playermodel->get($email);
	 $data['id'] = $user->id;
	 $data['password'] = uniqid();	 
	 $this->Playermodel->save($data);
	 $data['alias'] = $user->alias;
	 $data['email'] = $user->email;
	 $this->email("forgot", $data);
	 message("An e-mail has been sent to ". $email ." with a temporary password.");
	 redirect(ref());
	}

	function activate() {
		$key = $this->uri->segment(3);
		$user = $this->Playermodel->get_by_key($key);
		if ($user) {
		$data['approved'] = 1;
		$data['id'] = $user->id;
		$data['cbactivation'] = "";
		$this->Playermodel->save($data);
			message("Your account has now been activated, you may now login", "message");
		}
		else {
			message("Your account has already been approved", "error");
		}
		redirect("home");
	}

	function view() {
	 loggedin("player");
	 $id = $this->uri->segment(3);
	 $data['player'] = $this->Playermodel->get($id);
	 if (!$this->uri->segment(4)) {
		$a = $data['player']->alias;
		$a = str_replace(array("$", "|", "!", "@", "*", "=", "&", " "), array("S","", "", ".at.","","","","-"), $a);
		$alias = html_entity_decode($a, ENT_QUOTES, "UTF-8");
		//echo $alias;
		redirect("player/view/".$id."/".$a);
	 }
         $data['tabs'] = $this->Playermodel->get_tabs();
	 $data['clans'] = $this->Clanmodel->myclans($data['player']->id);
	 $data['teams'] = $this->Clanmodel->myteams($data['player']->id);
	 $data['activity'] = $this->Activitymodel->get($data['player']->id);
	 $data['title'] = $data['player']->alias;
	 $this->layout->view("player/view", $data);
	}

	function listing() {
	 $url = $this->uri->uri_to_assoc();
	 $data['title'] = "Member List";
	 if (!isset($url['filter']))
		$filter = "";
	 else
		$filter = $url['filter'];
	 $data['players'] = $this->Playermodel->get_all($filter);
	 $this->layout->view('player/list', $data);
 	}

	function index() {
	 $data['title'] = "Login / Register";
	 $this->layout->view('login', $data);
	}

	function login()
	{
	global $ref;
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
		redirect($user['ref']);
//		redirect("player/profile");
		}
	 else {
	 	message("Login unsuccessful, please check your credentials and try again", "error");        
		redirect(ref());
		}
       }

    	function logout()
    	{
         $data['id'] = user_id();
         $data['last_activity'] = "0000-00-00 00:00:00";
         $this->session->unset_userdata('loggedin');
	 $this->session->unset_userdata('user');
	 $this->Playermodel->save($data);
	 message("You have successfully been logged out", "message");
         redirect("home");
    	}

	function information()
	{
	 $id = $this->uri->segment(4);
	 $data['tab'] = $this->Playermodel->get_tab($this->uri->segment(3));
	 $data['fields'] = $this->Playermodel->fields($this->uri->segment(3));
	 if ($id == "")
		 $this->load->view("player/information", $data);
	 else {
		$data['fields'] = $this->Playermodel->fields($this->uri->segment(3), true);
		$data['player'] = $id;
		$this->load->view("player/get_information", $data);
	 }
	}

	function rig()
	{
	 $this->load->view("player/rig");
	}

	function edit()
	{
	 $data['user'] = $this->Usermodel->get($this->uri->segment(3));
	 $data['action'] = "edit";
	 $this->load->view("users/edit", $data);
	}

        function register()
        {
         $data['title'] = "Login / Register";
         $this->layout->view('login', $data);
        }

	function profile()
	{
	 loggedin("player");
	 $data['title'] = "Edit Your Details";
	 $data['activity'] = $this->Activitymodel->get(user_id());
	 $data['tabs'] = $this->Playermodel->get_tabs();
	 $this->layout->view("player/profile", $data);
	}

	function do_register() {
		$data = $this->input->post();
		$user = $this->Playermodel->get($data['email']);
		$this->session->set_userdata('temp_user',$data);
		if (!$user)
		{
                        $data['cbactivation'] = uniqid();
                        $this->email("welcome", $data);
			unset($data['password2']);
			$this->Playermodel->save($data);
			$this->session->unset_userdata('temp_user');
                        message("An e-mail has been sent to the address you specified upon sign-up.<br/>Once your have approved your account you will be able to login", "message");
                }
		else {
			message("A user with that email address already exists", "error");
		}
		 redirect(ref());
	}

	function save()
	{
		message("Profile changes have been updated successfully", "message");
		$data = $this->input->post();
		if (sizeof($_FILES) > 0)
			$this->do_upload();
		unset($data['password2']);
		$id = $this->Playermodel->save($data);
		redirect(ref());
	}

        function do_upload()    
        {                       
	$config['upload_path'] = './images/profile/';
	$config['allowed_types'] = 'gif|jpg|png';
	$config['max_size']	= '500';

	$this->load->library('upload', $config);

	 foreach ($_FILES as $key => $value)
                $field = $key;

	if ($_FILES[$key]['size'] == 0)
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
		        $data['id'] = user_id();
			$info =  $this->upload->data();
	                $data[$field] = $info["file_name"];
        	        $id = $this->Playermodel->save($data);
		}
	redirect(ref());
        }


	function test_email()
	{
		$data['cbactivation'] = uniqid();
		$data['email'] = "calvin@istreet.co.za";
		$this->email("welcome", $data);
	}

        function email($template="chall_request", $data)
        {
	$data['url'] = "www.egamingsa.co.za";
	$to = $data['email'];
        $content = $this->parser->parse("email/".$template, $data , true);
	$info['recipient'] = $data['email'];
	$info['msg'] = $content;
	$info['subject'] = "Welcome to eGaming South Africa";
	email($info);
        //mail($data['email'], "Welcome to eGaming South Africa", $content);
        }

	function gallery() {
	 $data['title'] = "Albums";
	 $data['gallery'] = $this->Gallerymodel->get(0, $this->router->class, $this->uri->segment(3));
	 $this->load->view('gallery/index', $data);
	}

	
}
