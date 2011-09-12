<?php

class Services extends CI_Controller {
        var $ckeditor;

	function __construct()
	{
	 parent::__construct();
	 $this->load->model("Servicesmodel");
	 $this->load->model("Productmodel");
         $this->load->model("Commentmodel");
         $this->load->model("Homemodel");
	}

	function qrcode() {
	 $message = $this->input->post('message');
	 $type = $this->input->post('type');
	 $qr = new qrcode();
	 $data['title'] = "QR Code Generator";
	 if ($type == "text")
		 $qr->text($message);
	 else
		 $qr->link($message);
	 $data['link'] = $qr->get_link(500);
	 $data['message'] = $message;
	 $data['type'] = $type;
	 $this->layout->view("services/qrcode", $data);
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
        $data['title'] = "Services";
	$data['services'] = $this->Servicesmodel->get_all();
        $this->layout->view('services/index', $data);
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
        $data['categories'] = $this->Newsmodel->get_categories(5, true, true);
        $this->pagination->initialize($config);
	if (isset($cat))
	        $data['articles'] = $this->Homemodel->get_all($limit, $offset, 0, $cat);
        $data['title'] = "Archive";
        $this->layout->view('news/index', $data);
        }

	
	function view()
	{
	 $id = $this->uri->segment(3);
	 $data['service'] = $this->Servicesmodel->get($id);
	 $data['products'] = $this->Productmodel->get_all($data['service']->id);
         $data['comments'] = $this->Commentmodel->get($this->router->class, $view['id']);
	 $data['title'] = $data['service']->name;
         $this->layout->view("services/view", $data);
	}

	function edit()
        {
	 if (!admin())
		redirect("home");
	 $data['ckeditor'] = $this->ck("content22");
	 $data['ckeditor2'] = $this->ck("content222");
         $data['title'] = "Edit Service";   
         $service = $this->uri->segment(3);
	 $data['service'] = $this->Servicesmodel->get($service);
	 $service = $data['article'];
	 $this->layout->view("services/edit", $data);
	}

        function sub_edit()
        {
         if (!admin())
                redirect("home");
         $data['ckeditor'] = $this->ck("content22");
         $data['ckeditor2'] = $this->ck("content222");
         $data['title'] = "Edit/Add Sub-service";
         $service = $this->uri->segment(3);
         $data['service'] = $this->Servicesmodel->get($service);
         $data['sservice'] = $this->Servicesmodel->get_sub($service);
         $service = $data['article'];
         $this->layout->view("services/edit", $data);
        }


	function save()
	{
	 $ref = $_SERVER['HTTP_REFERER'];
	 $data = $this->input->post();
	 if ($data['alias'] == "")
		$data['alias'] = strtolower(str_replace(array(" ", "'", "`", "\""),array("-", "", "", ""), $data['name']));
	 $id = $this->Servicesmodel->save($data);
	 if ( $id != false ) {
		$this->do_upload($id);
		message("Services have been successfully updated", "message");
	 }
	 else { message("Error updating services", "error"); }
	 redirect("services/view/".$id);
	}

        function save_sub()
        {
         $ref = $_SERVER['HTTP_REFERER'];
         $data = $this->input->post();
         if ($data['alias'] == "")
                $data['alias'] = strtolower(str_replace(array(" ", "'", "`", "\""),array("-", "", "", ""), $data['name']));
         $id = $this->Servicesmodel->save_sub($data);
         if ( $id != false ) {
                $this->do_upload($id);
                message("Service has been successfully updated", "message");
         }
         else { message("Error updating services", "error"); }
         redirect("services/view/".$data['service']);
        }

	function delete()
	{
	 $this->Servicesmodel->delete($this->uri->segment(3));
	 redirect("news");
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
                $data['images'] = $newFileName;
                $id = $this->Servicesmodel->save($data);
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
