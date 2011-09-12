<?php

class Activity extends CI_Controller {

	function Activity()
	{
         parent::__construct();
	 $this->load->model('Activitymodel');
         $this->load->model('Sitemodel');
         $this->load->model('Newsmodel');
	}

	function get() {
	 $li = $this->input->get("lastID");
	 $u = $this->input->get("u");
	 $act = $this->Activitymodel->get($u, $li);
	 activity($act);
	}

	function delete() {
	 $id = $this->uri->segment(3, 0);
	 if ($this->Activitymodel->delete($id))
	  message(ucfirst($this->router->class)." has been deleted.", "message");
	 else
	  message("Unable to delete the ".$this->router->class, "error");
	 redirect(ref());
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
