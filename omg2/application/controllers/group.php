<?php

class Group extends CI_Controller {

	function Group()
	{
         parent::__construct();
	 $this->load->model('Groupmodel');
         $this->load->model('Sitemodel');
         $this->load->model('Newsmodel');
	 if (!admin())
		redirect("home");
	}

        function do_upload($id)
        {
        $config['upload_path'] = './images/category/';
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
                        $data[$field] = "/images/category/".$info["file_name"];
                        $id = $this->Categorymodel->save($data);
                }
        redirect(ref());
        }


	function index()
	{
	 $id = $this->uri->segment(3);
	 $data['title'] = "Group Management";
	 $data['groups'] = $this->Groupmodel->get_all($id);	
         $this->layout->view('groups/index', $data);
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
	 $data['title'] = "Edit Group";
	 $id = $this->uri->segment(3, 0);
	 $data['group'] = $this->Groupmodel->get($id);
	 $this->load->view("groups/edit", $data);
	}

	function save() {
 	$id = $this->Groupmodel->save($this->input->post());
         if ($id != 0) {
                 message("Group changes saved successfully", 'message');
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
