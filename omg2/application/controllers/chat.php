<?php

class Chat extends CI_Controller{
	
	function chat(){
		parent::__construct();
		loggedin("player");
	}
	
	function index(){		
		$data['title'] = "Chat";
		$this->layout->view('chatty', $data);		
	}
	
	function backend(){
		
		$store_num = 10;
		$display_num = 10;
		
		
		header("Content-type: text/xml");
		header("Cache-Control: no-cache");
		
		foreach($_POST AS $key => $value) {
		    ${$key} = mysql_real_escape_string($value);
		}				
		if(@$action == "postmsg"){
			$message = $this->input->post("message");
			$current = time();
			$name = user()->alias;
			$this->db->query("INSERT INTO messages SET user='$name', msg='$message', time='$current'");		
			$delid = mysql_insert_id() - $store_num;
			$this->db->query("DELETE FROM messages WHERE id <= $delid");
		}		
		
		if (empty($time)){
			$sql = "SELECT * FROM messages ORDER BY id ASC LIMIT $display_num";
		}else{
			$sql = "SELECT * FROM messages WHERE time > $time ORDER BY id ASC LIMIT $display_num";
		}
		
		$query = $this->db->query("$sql");
		
		if($query->num_rows()==0){
			$status_code = 2;
		}else{
			$status_code = 1;
		}
				
		echo "<?xml version=\"1.0\"?>\n";
		echo "<response>\n";
		echo "\t<status>$status_code</status>\n";
		echo "\t<time>".time()."</time>\n";
		
		if($query->num_rows()>0){
			foreach($query->result() as $row){				
				$escmsg = htmlspecialchars(stripslashes($row->msg));
				echo "\t<message>\n";
				echo "\t\t<author>$row->user</author>\n";
				echo "\t\t<text>$escmsg</text>\n";
				echo "\t</message>\n";
			}
		}
		echo "</response>";
		
		
	}
	
}
?>
