<?
class Server extends CI_Controller {

	function times()
	{
	$start = 00.00*60+0;
	$end = 23.59*60+0;
	$output = "";
	for($time = $start; $time<=$end; $time += 30)
	{
	    $minute = $time%60;
	    $hour = ($time-$minute)/60;
	    $shits = sprintf('%02d:%02d', $hour, $minute);
	    $shite = sprintf('%02d:%02d', $hour, $minute);
	    $output .="<option value='$shits'>". $shits ."</option>";
	}
	return $output;
	}

	function booking_list() {
	 $data['title'] = "Booking List";
	 $data['servers'] = $this->Servermodel->get_all(1);
	 $this->layout->view("server/booking_list", $data);
	}

	function get_maps() {
	 $data['game'] = $this->uri->segment(4);
	 $data['mode'] = $this->uri->segment(3);
	 $info = $this->Gamemodel->get_maps($data);
	 echo form_dropdown("map", $info, "");
	}

        function info() {
         $id = $this->uri->segment(3);
         $data['server'] = $this->Servermodel->get($id);
	 $data['game'] = $this->Gamemodel->get($data['server']->game);
         $this->load->view("server/info_".$data['server']->game, $data);
        }

	function edit() {	
	 $id = $this->uri->segment(3);
	 $data['server'] = $this->Servermodel->get($id);
	 $data['games'] = $this->Sitemodel->get_games();
	 $this->load->view("server/edit", $data);
	}

	function extra($ajax=false) {
	$data = array();
	$error = "";
	if (isset($_POST))
	{
	 $start = $_POST['date'] . " " . $_POST['sb_starttime'];
	 $end = $_POST['date'] . " " . $_POST['sb_endtime'];
	 $diff = abs(strtotime($end) - strtotime($start))/60;
	 $now = date("Y-m-d H:i:s");
	 if ($_POST['sb_endtime'] < $_POST['sb_starttime'])
	  $error = "End time can not be less than the start time.";
	 elseif ($_POST['sb_endtime'] == $_POST['sb_starttime'])
	  $error = "Start time and end time can't be the same.";
	 elseif ($start < $now)
	  $error = "You cannot book in the past";
	 elseif ($diff > 120)
	  $error = "You cannot book the server for longer than 2 hour sessions";
	else
	 {
	 $data['date'] = $_POST['date'];
	 $data['start'] = $_POST['sb_starttime'];
	 $data['end'] = $_POST['sb_endtime'];
	 $data['password'] = $_POST['password'];
	 $data['teamleader'] = user_id();
	 if ($this->check_me_first() > 0)
	 {
	 $error = "The server has already been booked for this slot.";
	 }
	 else {
	 $data['start'] = $data['date'] . " " . $data['start'];
	 $data['end'] = $data['date'] . " " . $data['end'];
	 $data['server'] = $_POST['server'];

	 if (!$ajax) {

	  if ($this->db->insert("server_booking", $data))
	    message('Booking successful.', "message");
	  else
	    $error = "The server has already been booked for this slot.";
	 } // end if ajax

	 }
	}
	}
	if (!$ajax) {
	if ($error != "")
	 message($error, "error");
	redirect(ref());
	} else {
		echo $error; }
	}

	function __construct()	{
	 parent::__construct();
	 $this->load->model("Servermodel");
         $this->load->model("Sitemodel");
	 $this->load->model("Gamemodel");
	}

	function index() {
	 $data['servers'] = $this->Servermodel->get_all(2);
	 $data['title'] = "Game Server List";
	 $this->layout->view("server/list", $data);
	}

	function management() {
	 if (!admin()) redirect("home");
         $data['servers'] = $this->Servermodel->get_all();
         $data['title'] = "Game Server List";
         $this->layout->view("server/management", $data);
	}

	function processbooking() {

	$this->form_validation->set_rules('password', 'Password', 'required');
	$this->form_validation->set_rules('date', 'Date', 'required');
	 if ($this->form_validation->run() == FALSE)
		$this->book();

	 $this->extra();
	}

	function check() {
        $this->form_validation->set_rules('date', 'Date', 'required');
         if ($this->form_validation->run() == FALSE)
                $this->book();

         $this->extra(true);
	}

	function check_me_first()
	{
	 $date = $_POST['date'];
	 $server = $_POST['server'];
	 $start = $date . " " . $_POST['sb_starttime'];
	 $end = $date . " " . $_POST['sb_endtime'];
	 $query = $this->db->query("SELECT * FROM server_booking WHERE '$start' BETWEEN `start` AND `end` AND '$end' BETWEEN `start` AND `end` AND server = $server");
	 return $query->num_rows();
	}

	function control()
	{
	 $this->check_first();
	 $data['title'] = "Server Control";
	 $data['booking'] = $this->uri->segment(3);
	 $this->db->where("id", $data['booking']);
	 $query = $this->db->get("server_booking");
	 $book = $query->row();
	 $server = $this->Servermodel->get($book->server);
	 $data['game'] = $server->game;
	 $data['server'] = $book->server;
	 $this->bc2conn->connect($server->ip, $server->port);
         $this->bc2conn->loginSecure($server->password);
	 $data['info'] = $this->bc2conn;
	 $data['modes'] = $this->Gamemodel->game_mode($server->game);
	 $this->layout->view("server/control_".$server->game, $data);
	}


	function book()
	{
         loggedin("player");
         $data['mybookings'] = $this->mybookings();
	 $data['times'] = $this->times();
	 $data['title'] = "Server Booking";
	 if ($this->uri->segment(3))
		$data['server'] = $this->uri->segment(3);
	 foreach ($this->Servermodel->get_password() as $pass)
		$passwords[$pass['value']] = $pass['value'];
	 $data['password'] = $passwords;
	 foreach ($this->Servermodel->get_all() as $serv) {
		if ($serv->bookable == 1)
			$servers[$serv->id] = $serv->sname;
	 }
	 $data['servers'] = $servers;
	 $this->layout->view("server/booking", $data);
	}

function mybookings()
{
 $now = date("Y-m-d H:i:s");
 $result = $this->db->query("SELECT sb.password, sb.id, DATE_FORMAT(sb.start, '%l %p') as start, DATE_FORMAT(sb.end, '%l %p') as end, DATE_FORMAT(sb.date, '%W %D %M') as date, s.name, sb.teamleader  FROM 
server_booking 
sb, 
jos_egsa_server s 
WHERE  
sb.end > '".$now."' AND
sb.server = 
s.id 
AND 
teamleader = 
".user_id());
 return $result->result();
}

	function cancel_booking() {
	 $id = $this->uri->segment(3);	
	 $userid = user_id();
	 $this->db->where('id', $id);
	 $this->db->where('teamleader', $userid);
	 if ($this->db->delete("server_booking"))
		message("The booking has been successfully cancelled", "message");
	 else
		message("We were unable to delete the booking, please contact a site admin", "error");
	redirect(ref());
	}




function check_first()
{
 $now = date("Y-m-d H:i:00");
 $userid = user_id();
 $bookingid = $this->uri->segment(3);
 if (!is_numeric($bookingid)) {
  message("Yeah like, you trying to hack me or something", "error");
  redirect(ref());
 }
 $query = $this->db->query("SELECT * FROM server_booking WHERE '$now' BETWEEN `start` AND `end` AND teamleader = '$userid' AND id = $bookingid");
 $num = $query->num_rows();
 if ($num > 0)
 {
  $row = $query->row();
  if ($userid != $row->teamleader) {
   echo "You are not in control now";
   exit();
  }
}
 else {
	message("You are not allowed to admin now", "error");
	redirect(ref());
 }
}


        function delete() {
         $ref = $this->agent->referrer();
         $id = $this->uri->segment(3, 0);
         if ($this->Servermodel->delete($id))
          message("Server and all associated bookings have been deleted.", "message");
         else
          message("Unable to delete server", "error");;
         redirect($ref);
        }

        function save() {
        $id = $this->Servermodel->save($this->input->post());
                if ($id != 0) {
                 message(ucfirst($this->router->class) ." changes saved successfully", 'message');
                 redirect(ref());
                }
        }
	
	function sendcmd() {
		loggedin("home");
		$this->check_first();
		$server = $this->Servermodel->get($this->input->post("server"));
		if ($server->game == 1) {
			$this->bfbc2($server);
		 }
	}

	function bfbc2($server) {
         $this->bc2conn->connect($server->ip, $server->port);
         $this->bc2conn->loginSecure($server->password);

	if (isset($_POST['change']))
        {
         $map = $_POST['map'];
         $this->bc2conn->adminSetPlaylist($_POST['mode']);
         $this->bc2conn->adminVarSet3dSpotting(false);
         $this->bc2conn->adminMaplistClear();
         $this->bc2conn->adminMaplistAppend($map);
         $this->bc2conn->adminMaplistSave();
         message('Yelling: Server is changing maps in 5 seconds<br/>', "message");
         $this->bc2conn->adminYellMessage("Server is changing maps in 5 seconds");
         sleep(5);
         $this->bc2conn->adminRunNextLevel();
         	message('Server has been changed to '.$map.' with mode '.$_POST['mode'], "message");
        }
        elseif (isset($_POST['restart']))
        {
                message('Yelling: Server is restarting in 5 seconds<br/>', "message");
                $this->bc2conn->adminYellMessage("Server is restarting in 5 seconds");
                sleep(5);
                $this->bc2conn->adminRestartMap();
        }
	elseif (isset($_POST['yell'])) {
		message("Command has been executed.", "message");
		$this->bc2conn->adminYellMessage($this->input->post("msg"));
	}
	elseif (isset($_POST['say'])) {
		message("Command has been executed.", "message");
		$this->bc2conn->adminSayMessageToAll($this->input->post("msg"));
        }
	        redirect(ref());
	}

}
?>
