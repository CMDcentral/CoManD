<?

class Cron extends CI_Controller {

function Cron() {
	parent::__construct();
	$this->load->model("Servermodel");
        $this->load->model("Playermodel");
	$this->load->model("Clanmodel");
}

function test() {
	$this->config->set_item('theme', 'cmdcentral-new');
}

function tweet() {
  $this->load->library('RSSParser', array('url' => 'http://feeds.gawker.com/kotaku/vip?format=xml', 'life' => 0));
  $data = $this->rssparser->getFeed(5);
  foreach ($data as $item) :
	print_r($item);
  endforeach; 
}

function meh() {
	$this->leaderboard();
	$this->setup_server();
//	$this->gamefeed();
}

function gamefeed() {
        $this->load->library('xfire');
	$players = $this->Playermodel->get_all();
	foreach ($players as $player) {
	if ($player->cb_xfire != "") {
	echo "<b>".$player->alias."</b><br/>";
        $this->xfire->set( $player->cb_xfire );
        print_r($this->xfire->GetLive());
	echo "<br/><br/>";
	 }
	}
}

function leaderboard()
{
	$con = mysql_connect("localhost", 'egamings_ezstat', "KoGQRmbRMKa");
        $db = mysql_select_db('egamings_ezstat');

	$players = $this->Playermodel->get_all();
	foreach ($players as $player) {
		if ($player->cb_bfbc2soldiername != "") {

		// get the users clan tag
		$clans = $this->Clanmodel->myclans($player->id);

		$SQL = "SELECT * FROM ezstats_players WHERE name = '$player->cb_bfbc2soldiername'";
		$result = mysql_query($SQL);
		$count = mysql_num_rows($result);
		$tag = $clans[0]->tag;
		$row = mysql_fetch_row($result);
		$id = $row[0];
		$name = $row[1];
		if ($count == 0) {
		$SQL = "INSERT INTO ezstats_players VALUES (NULL, '$player->cb_bfbc2soldiername', 0)";
		$result = mysql_query($SQL) or die(mysql_error());
		if ($result) {
			echo "Added ". $player->alias. "<br/>";
			$name = $player->alias;
			$id = mysql_insert_id();
			$SQL = "INSERT INTO ezstats_playernames VALUES ($id, '$tag $name')";
			$result = mysql_query($SQL) or die(mysql_error());
		}
		else
			echo "Error adding " . $player->alias. "<br/>";
		} // end if for count
		else {
		 echo "Updating " . $tag . " " . $name. "<br/>";
		 $SQL = "UPDATE ezstats_playernames SET name = '".$tag. " " .$name."' WHERE ID = $id";
	         $result = mysql_query($SQL) or die(mysql_error());
		} // end if 1 update tag
		}
	}
}


function setup_server()
{
$changed=false;
$now = date("Y-m-d H:i:00");
$body = "Selecting booking with start time of " .$now . "\n";

$servers = $this->db->query("SELECT * FROM server_booking WHERE `start` = '$now'");

foreach ($servers->result() as $server) {
$body = "";
$body .= "Server " . $server->server. " is now being setup for booking: " . $server->id . "\n\n";
$body .= "The server password is: " . $server->password . "\n\n";

$s = $this->Servermodel->get($server->server);
$this->bc2conn->connect($s->ip, $s->port);
$this->bc2conn->loginSecure($s->password);
$pass = $server->password;
$this->bc2conn->adminVarSetGamepassword("$pass");
$this->bc2conn->logout();
$changed=true;
if ($changed)
 mail('clanadmin@nsd.za.net', 'eGSA Server Change', $body);
}
}

}
