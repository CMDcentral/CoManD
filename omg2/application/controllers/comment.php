<?php

class Comment extends CI_Controller {

	var $ref;

	function Comment()
	{
	 parent::__construct();
	 $this->load->model("Commentmodel");
	 loggedin("home");
	}

	function delete() {
	 $id = $this->uri->segment(3);
	 $comment = $this->Commentmodel->get_by_id($id);
	 if ($comment->user_id == user_id())
		$this->Commentmodel->delete($comment->id);
	 redirect(ref()."#comments");
	}

	function save()
	{

		$data = $this->input->post();
		message("Comment has been added.", "message");
		$d = $this->input->post();
		unset($d['newsfeed']);
		$this->Commentmodel->save($d);
		$this->email("new_comment", $this->input->post());
	

		if ($this->input->post("newsfeed") == "on") {
		        $data2['owner'] = user_id();
			$user = get_user(user_id());
			$comment = substr($data['comment'], 0, 20)."...";
		        $data2['info'] = "<a href='/player/view/".$user->id.".html'>".$user->alias. 
			"</a> commented '".$comment."' on ".$this->checkifvowel($data['controller'])."
			<a href='/".$data['controller']."/view/".$data['oid'].".html'>".$data['controller']."</a>";
		        log_info($data2);
		}
		redirect(ref()."#comments");
	}

	function dropbox()
	{
		$data['clients'] = $this->Clientmodel->get_all();
		$this->load->view("client/dropbox", $data);
	}

        function email($template="chall_request", $data)
        {
	$comments = $this->Commentmodel->get($data['controller'], $data['oid']);
	foreach ($comments as $comment) {
	 if (user_id() != $comment->user_id) {
	 $user = get_user($comment->user_id);
	 $info['recipient'] = $user->email;
	 $content = $this->parser->parse("email/".$template, $data , true);
	 $info['msg'] = $content;
	 $info['subject'] = "eGamingSA - New comment posted";
	 email($info);
	 } // end if
	}
        }

function checkifvowel($string) {
  if(preg_match('/^[aeiou]|s\z/i', $string))
  {
    return 'an';
  }else{
    return 'a';
  }
}

}
