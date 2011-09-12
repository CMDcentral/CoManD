<?php

class Pages extends CI_Controller {

	var $ckeditor = array(
                        'id'    =>	'content22',
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

	function __construct()
	{
         parent::__construct();
	 $this->load->model('Pagesmodel');
	}

	function view()
	{
        $alias = $this->uri->segment(3);
        $page = $this->Pagesmodel->get($alias);
         if (sizeof($page) == 0)
                show_404('page');
         $data['alias'] = $page[0]->alias;
         $data['title'] = $page[0]->title;

         $data['content'] = $page[0]->content;
         $this->template->build('view', $data);

	}

	function index()
	{	
	 $alias = $this->uri->segment(2);
	 echo $alias;
	 $page = $this->Pagesmodel->get($alias);
	 if (sizeof($page) == 0)
		show_404('page');

	 if ($page[0]->imageslider == 'yes') {
		$slider = $this->slider(1);
		$slider2 =  $this->slider(2);
		$slider3 = $this->slider(3);
	 }
	 else {
		$slider = "";
		$slider2 = "";
		$slider3 = "";
	 }


	 $sidebar = $this->sidebar($page[0]->id);
	 $data['alias'] = $page[0]->alias;
	 $data['sidebar'] = $sidebar;
	 $data['sidebar'] .= $this->news();
	 $data['slider'] = $slider;
         $data['slider2'] = $slider2;
         $data['slider3'] = $slider3;
	 $data['title'] = $page[0]->title;

	 $data['content'] = $page[0]->content;
         $this->layout->view('welcome_message', $data);
	}

	function edit()
	{
         if (!admin())
         {
            redirect('/');
         }
	 $data['title'] = "Edit Page";
	 $data['options'] = array(
                  'yes'  => 'Yes', 'no' => 'No'
		);

	 $alias = $this->uri->segment(3);
	 $data['sidebar'] = "<h3>Admin Menu</h3>".anchor("admin/pages", "Edit Pages");
	 $data['sidebar'] .= "<br/>".anchor('pages/add', "Add Page");
	 $data['sidebar'] .= "<h3>Main Menu</h3>".anchor("admin", "Admin Section");
	 $data['page'] = $this->Pagesmodel->get($alias);
	 $data['ckeditor'] = array(
                        'id'    =>	'content22',
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
                );;
	 $this->layout->view("pages/edit", $data);
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

        function save() {	
        $id = $this->Pagesmodel->save($this->input->post());
                if ($id != 0) {
                 message("Page changes have been successfully recorded", 'message');
                 redirect("/pages/view/".$id);
                }
        }

}
