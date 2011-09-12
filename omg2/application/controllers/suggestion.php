<?php

class Suggestion extends CI_Controller {

	function Suggestion()
	{
         parent::__construct();
	 $this->load->model('Suggestionmodel');
         $this->load->model('Commentmodel');
         $this->load->model('Newsmodel');
	 loggedin("home");
	}

	function index()
	{
	 $data['title'] = "Site suggestions";
	 $data['suggestions'] = $this->Suggestionmodel->get_all();
         $this->layout->view('suggestion/edit', $data);
	}

	function view()
	{
	 $id = $this->uri->segment(3);
	 $member = $this->Suggestionmodel->get($id);
	 if (sizeof($member) == 0)
		redirect("suggestion");
	 $data['comments'] = $this->Commentmodel->get($this->router->class, $this->uri->segment(3));
	 $data['title'] = $member->title;
	 $data['suggestion'] = $member;
         $this->layout->view('suggestion/view', $data);
	}

	function edit()
	{
         if (!$this->session->userdata('loggedin'))
         {
            redirect('/');
         }
	 $data['title'] = "Edit Category";
	 $id = $this->uri->segment(3, 0);
	 $data['category'] = $this->Categorymodel->get($id);
	 $data['sections'] = $this->Newsmodel->get_sections();
	 $this->load->view("category/edit", $data);
	}

	function save() {
 	$id = $this->Suggestionmodel->save($this->input->post());
                if ($id != 0) {
                 message("Suggestion has been saved successfully", 'message');
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
