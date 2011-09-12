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

	function Pages()
	{
         parent::__construct();
	 $this->load->model('Pagesmodel');
         $this->load->model('Newsmodel');
         $this->load->model('Gallerymodel');
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
         $this->layout->view('welcome_message', $data);

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

	function sidebar($id)
	{
	 $output = "<h3>Sub-menu</h3><ul id='submenu'>";
	 foreach ($this->Pagesmodel->get_sidebar($id) as $item)
	 {
	  $output .="<li>".anchor($item->alias, $item->title)."</li>";
	 }
	  $output .= "</ul>";	
	 return $output;
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

	function news()
	{
         $output = "<h3>News</h3>";
         foreach ($this->Newsmodel->get_all() as $item)
         {
          $output .="<div>".$item->added. "<br/>" . $item->title . "<br/><sub>" . anchor("news/view/".$item->id, "read more...")."</sub></div><hr/>";
         }
          $output .= "";
         return $output;
	}

	function slider($i)
	{

	 $images = $this->Gallerymodel->get_all_images();	

	 $slider = '<ul id="slide'.$i.'" class="slideshow"> ';
	 foreach ($images as $image)
    		$slider .= '<li ><a class="popup" href="/images/gallery/'.$image->album.'/'.$image->filename.'"><img src="/thumb/gen/image/'.$image->filename.'/width/350/height/250/folder/gallery-'.$image->album.'/"/></a></li>';
	 $slider .= '</ul>';
	return $slider;
	}

        function save() {	
        $id = $this->Pagesmodel->save($this->input->post());
                if ($id != 0) {
                 message("Page changes have been successfully recorded", 'message');
                 redirect("/pages/view/".$id);
                }
        }

}
