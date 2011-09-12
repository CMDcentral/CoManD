<?php

class Article extends CI_Controller {
        var $ckeditor;

	function Article()
	{
	 parent::__construct();
	 $this->load->model("Newsmodel");
         $this->load->model("Commentmodel");
         $this->load->model("Categorymodel");
         $this->load->model("Homemodel");
	}

	function getcat() {
	 $id = $this->uri->segment(3);
	 $cat = $this->Newsmodel->get_categories($id);
	 echo form_dropdown("catid", $cat);
	}

	

	function ck($id) {
	 $this->ckeditor =  array(
                        'id'    =>      $id,
                        'path'  =>      'js/ckeditor',
                        'config' => array(
                                'toolbar'       =>      "Full",         //Using the Full toolbar
                                'width'         =>      "740px",        //Setting a custom width
                                'height'        =>      '500px',        //Setting a custom height

                        ),
                        'styles' => array(
                                'style 1' => array (
                                        'name'          =>      'Blue Title',
                                        'element'       =>      'h2',
                                        'styles' => array(
                                                'color'         =>      'Blue',
                                                'font-weight'   =>      'bold'
                                        )
                                ),
                                'style 2' => array (
                                        'name'  =>      'Red Title',
                                        'element'       =>      'h2',
                                        'styles' => array(
                                                'color'                 =>      'Red',
                                                'font-weight'           =>      'bold',
                                                'text-decoration'       =>      'underline'
                                        )
                                )
                        )
                );
		return $this->ckeditor;
	}

	function index()
	{
        $this->load->model("Homemodel");
        $offset=$this->uri->segment(3);
        $limit=10;
        $config["total_rows"] = $this->Newsmodel->get_count();
        $config["per_page"] = $limit;
        $config['base_url'] = '/article/index/';
	$data['categories'] = $this->Newsmodel->get_categories(5, true, true);
        $this->pagination->initialize($config);
        $data['articles'] = $this->Homemodel->get_all($limit, $offset);
        $data['title'] = "Archive";
        $this->layout->view('news/index', $data);
	}

        function category()
        {
        $this->load->model("Homemodel");
	$cat = $this->uri->segment(3);
        $offset= $this->uri->segment(5);
        $limit=10;
        $config["total_rows"] = $this->Newsmodel->get_count($cat);
	$config['uri_segment'] = 5;
        $config["per_page"] = $limit;
        $config['base_url'] = '/article/category/'.$cat.'/page/';
	$data['cat'] = $this->Categorymodel->get($cat);
	$catid = $data['cat']->id;
        $data['categories'] = $this->Newsmodel->get_categories(5, true, true);
        $this->pagination->initialize($config);
	$data['articles'] = $this->Homemodel->get_all($limit, $offset, 0, $catid);
        $data['title'] = "Article archive";
        $this->layout->view('news/index', $data);
        }

	
	function view()
	{
	 $id = $this->uri->segment(3);
	 $data['news'] = $this->Newsmodel->get($id);
	 $hits = $data['news']->hits + 1;
	 if ($data['news']) {
	 $view['hits'] = $hits;
	 $view['id'] = $data['news']->id;
	 $this->Newsmodel->save($view);
	 }
         $data['comments'] = $this->Commentmodel->get($this->router->class, $view['id']);
	 $data['title'] = $data['news']->title;
         $this->layout->view("news/view", $data);

	}

	function edit()
        {
	 if (!admin())
		redirect("home");
	 $data['ckeditor'] = $this->ck("content22");
	 $data['ckeditor2'] = $this->ck("content222");
	 $data['sections'] = $this->Newsmodel->get_sections();
         $data['title'] = "Edit News Article";   
         $article = $this->uri->segment(3);
	 $data['article'] = $this->Newsmodel->get($article);
	 $art = $data['article'];
         $data['categories'] =  $this->Newsmodel->get_categories($art->sectionid);
	 $this->layout->view("news/edit", $data);
	}

	function save()
	{
	 $ref = $_SERVER['HTTP_REFERER'];
	 $data = $this->input->post();
	 if ($data['alias'] == "")
		$data['alias'] = strtolower(str_replace(array(" ", "'", "`", "\""),array("-", "", "", ""), $data['title']));
	 $id = $this->Newsmodel->save($data);
	 if ( $id != false ) {
		$this->do_upload($id);
		message("News article has been successfully updated", "message");
	 }
	 else { message("Error updating", "error"); }
	 redirect("article/view/".$id);
	}

	function delete()
	{
	 message("Article has been deleted", "message");
	 $this->Newsmodel->delete($this->uri->segment(3));
	 redirect("article");
	}

        function do_upload($id)
        {
        if (!empty($_FILES)) {
        $tempFile = $_FILES['file']['tmp_name'];
        $filename = $_FILES['file']['name'];
	if ($filename != "") {
                $directory = getcwd().'/images/news/';
                if (!file_exists($directory))
                 mkdir($directory, 0700);
                $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);  //figures out the extension
                $newFileName = md5($tempFile).'.'.$ext; //generates random filename, then adds the file extension
                $targetFile = $directory.'/'.$newFileName;
                move_uploaded_file($tempFile, $directory.'/'.$newFileName);
                $data['id'] = $id;
                $data['images'] = $newFileName;
                $id = $this->Newsmodel->save($data);
        }
        }
	}


	function rating() {
		$rate = $this->input->post("rate");
		$id = $this->input->post("idBox");
		$userIP =  $_SERVER['REMOTE_ADDR'];

                $data['content_id'] = $id;
                $data['lastip'] = $userIP;
                $data['rating_sum'] = $rate;
                $data['rating_count'] = 1;

		$rating = $this->Newsmodel->get_rating($id);

                if ( $rate >= 1 && $rate <= 5)
                {
                        if (!$rating)
                        {
				echo "New Rating";
                                // There are no ratings yet, so lets insert our rating
				if ($this->Newsmodel->save_rating($data))
					message("error", "error");
			}
			else
			{

                                if ($userIP != ($rating->lastip))
                                {

                                  // We weren't the last voter so lets add our vote to the ratings totals for the article
				   $data['existing'] = true;
				   $data['rating_count'] = $rating->rating_count + 1;
				   $data['rating_sum'] = $rating->rating_sum + $rate;
				   $this->Newsmodel->save_rating($data);
				echo "Update a rater";
				} else
				{
				 return false;
				}
			}
               }
		
	}


// end class
}
