<?php

class Page extends CI_Controller {

 function Page()
 {
  $this->load->model('Pagemodel');
 }

 function index()
 {
  echo "wtf";
  $this->layout->view('welcome_message');
 }

}
