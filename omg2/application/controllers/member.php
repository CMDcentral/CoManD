<?php

class Member extends CI_Controller {

        var $ckeditor = array(
                        'id'    =>	'information',
                        'path'  =>	'js/ckeditor',
                        'config' => array(
                                'toolbar'	=>	"Full",         //Using the Full toolbar
                                'width'         =>	"740px",        //Setting a custom width
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


	function Member()
	{
         parent::__construct();
	 $this->load->model('Membermodel');
	}

	function index()
	{
	 $data['title'] = "Members";
	 $data['members'] = $this->Membermodel->get_all();	
         $this->layout->view('member/index', $data);
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

	function add() {
	 $ref = $this->agent->referrer();
	 $data['title'] = 'Add Page';
	 $data['ckeditor'] = $this->ckeditor;
         $data['options'] = array(
                  'yes'  => 'Yes', 'no' => 'No'
                );

	 $this->layout->view('pages/add', $data);
	}

	function _admin_menu()
	{
	return $menu;
	}

	function edit()
	{
         if (!$this->session->userdata('loggedin'))
         {
            redirect('/');
         }
	 $data['title'] = "Edit Member";
	 $id = $this->uri->segment(3, 0);
	 $data['member'] = $this->Membermodel->get($id);
	 $data['ckeditor'] = $this->ckeditor;
	 $this->layout->view("member/edit", $data);
	}

	function save() {
 	$id = $this->Membermodel->save($this->input->post());
        if ( $id != false ) {
                $this->do_upload($id);
                message("Services have been successfully updated", "message");
         }
        redirect("/member/view/".$id);
	}

        function do_upload($id)
        {
        if (!empty($_FILES)) {
        $tempFile = $_FILES['file']['tmp_name'];
        $filename = $_FILES['file']['name'];
        if ($filename != "") {
                $directory = getcwd().'/uploads/';
                if (!file_exists($directory))
                 mkdir($directory, 0700);
                $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);  //figures out the extension
          	$newFileName = md5($tempFile).'.'.$ext; //generates random filename, then adds the file extension
                $targetFile = $directory.'/'.$newFileName;
                move_uploaded_file($tempFile, $directory.'/'.$newFileName);
         	$data['id'] = $id;
                $data['image'] = $newFileName;
                $id = $this->Membermodel->save($data);
        }
        }
        }
	
	function contacts($id)
	{
	 echo form_dropdown('clientContact', $this->Clientmodel->contactlist($this->uri->segment(3, 0)), "");
	}
	
	function delete() {
	 $ref = $this->agent->referrer();
	 $id = $this->uri->segment(3, 0);
	 if ($this->Employeemodel->delete($id))
	  $this->session->set_flashdata('message', '<div class="success">Employee has been deleted.</div>');
	 else
	  $this->session->set_flashdata('message', '<div class="error">Unable to delete employee</div>');
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

	function slider()
	{
	 return '   <ul class="slideshow">
    <li class="show"><a href="#"><img src="http://www.piaprojects.com/thumb/gen/image/slide1.jpg/width/977/height/800"/></a></li>
    <li><a href="#"><img src="http://www.piaprojects.com/thumb/gen/image/slide2.jpg/width/977/height/800" /></a></li>
    <li><a href="#"><img src="http://www.piaprojects.com/thumb/gen/image/slide3.jpg/width/977/height/800" /></a></li>
   </ul>
';
	}
}
