<?
class Solusvm extends CI_Controller {

	function index() {

	$url = "http://monitor.cmdcentral.co.za:5353/api/admin";
	$postfields["id"] = "ZJQfkFVTGip7sL5qRlZz";
	$postfields["key"] = "moU3oahjxTrnr8sCBem9";

	foreach ($this->input->get() as $key => $value)
		$postfields[$key] = $value;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url . "/command.php");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 20);
	curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Expect:"));
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
	$data = curl_exec($ch);
	curl_close($ch);
	preg_match_all('/<(.*?)>([^<]+)<\/\\1>/i', $data, $match);
	$result = array();
	foreach ($match[1] as $x => $y)
	{
	 $result[$y] = $match[2][$x];
	}
	echo json_encode($result);
	}

}
?>
