<?php
class Teeworlds {
	private $fp = null;
	public $ip;
	public $port;
	public $ping = -1;
	public $version = null;
	public $name = null;
	public $map = null;
	public $gametype = null;
	public $numplayers = 0;
	public $maxplayers = 0;
	public $players = array();
	
	public function connect($ip, $port) {
		$this->ip = $ip;
		$this->port = $port;
	}

	function query() {
   
	$socket = stream_socket_client('udp://'.$ip.':'.$port , $errno, $errstr, 1); 
	fwrite($socket, "\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\x67\x69\x65\x33\x05");
	$response = fread($socket, 2048);
	
	if ($response){
		$info = explode("\x00",$response);
		
		$players = array();
		for ($i = 0; $i <= $info[8]*5-5 ; $i += 5) {
			
			$teams = Array("Zuschauer","Spieler");
			$team = $teams[$info[$i+14]];
			
			$flags = Array();
			
			$flags[] = Array("default", "-1");
			$flags[] = Array("XEN", "901");
			$flags[] = Array("XNI", "902");
			$flags[] = Array("XSC", "903");
			$flags[] = Array("XWA", "904");
			$flags[] = Array("AR", "32");
			$flags[] = Array("AU", "36");
			$flags[] = Array("AT", "40");
			$flags[] = Array("BY", "112");
			$flags[] = Array("BE", "56");
			$flags[] = Array("BR", "76");
			$flags[] = Array("BG", "100");
			$flags[] = Array("CA", "124");
			$flags[] = Array("CL", "152");
			$flags[] = Array("CN", "156");
			$flags[] = Array("CO", "170");
			$flags[] = Array("HR", "191");
			$flags[] = Array("CZ", "203");
			$flags[] = Array("DK", "208");
			$flags[] = Array("EG", "818");
			$flags[] = Array("SV", "222");
			$flags[] = Array("EE", "233");
			$flags[] = Array("FI", "246");
			$flags[] = Array("FR", "250");
			$flags[] = Array("DE", "276");
			$flags[] = Array("GR", "300");
			$flags[] = Array("HU", "348");
			$flags[] = Array("IN", "356");
			$flags[] = Array("ID", "360");
			$flags[] = Array("IR", "364");
			$flags[] = Array("IL", "376");
			$flags[] = Array("IT", "380");
			$flags[] = Array("KZ", "398");
			$flags[] = Array("LV", "428");
			$flags[] = Array("LT", "440");
			$flags[] = Array("LU", "442");
			$flags[] = Array("MX", "484");
			$flags[] = Array("NL", "528");
			$flags[] = Array("NO", "578");
			$flags[] = Array("PK", "586");
			$flags[] = Array("PH", "608");
			$flags[] = Array("PL", "616");
			$flags[] = Array("PT", "620");
			$flags[] = Array("RO", "642");
			$flags[] = Array("RU", "643");
			$flags[] = Array("SA", "682");
			$flags[] = Array("RS", "688");
			$flags[] = Array("SK", "703");
			$flags[] = Array("ZA", "710");
			$flags[] = Array("ES", "724");
			$flags[] = Array("SE", "752");
			$flags[] = Array("CH", "756");
			$flags[] = Array("TR", "792");
			$flags[] = Array("UA", "804");
			$flags[] = Array("GB", "826");
			$flags[] = Array("US", "840");

			$flag = "";
			
			foreach ($flags as $flag_tmp) 
			{
				if($flag_tmp[1] == $info[$i+12])
				{
					$flag = $flag_tmp[0];
				}
			}
			

			$players[] = array(
						"name" => htmlentities($info[$i+10], ENT_QUOTES, "UTF-8"),
						"clan" => htmlentities($info[$i+11], ENT_QUOTES, "UTF-8"),
						"flag" => $flag,
						"score" => $info[$i+13],
						"team" => $team);
		}
		
		if($info[9] == $info[7])
		{
			$specslots = $info[9];
		}else{
			$specslots = $info[9] - $info[7];
		}
		$tmp = array(
		"name" => $info[2],
		"map" => $info[3],
		"type" => $info[4],
		"flags" => $info[5],
		"player_count_ingame" => $info[6],
		"max_players_ingame" => $info[7],
		"player_count_spectator" => $info[8] - $info[6],
		"max_players_spectator" => $specslots,
		"player_count_all" => $info[8],
		"max_players_all" => $info[9],
		"players" => $players);
		print_r($tmp);		
		return $tmp;
		
	} else {
		return FALSE;
	}
}
	
	private function readString() {
		$buf = "";
		do {
			$b = fread($this->fp, 1);
			if ($b != chr(0)) $buf .= $b;
		} while ($b != chr(0));
		return $buf;
	}
	
	public function queryInfo($timeout = 3) {
		$this->fp = fsockopen("udp://$this->ip", $this->port, $errno, $errstr, $timeout);
		@socket_set_timeout($this->fp, $timeout);
		$packet = chr(255).chr(255).chr(255).chr(255).chr(255).chr(255).chr(255).chr(255).chr(255).chr(255)."gief";
		$reqtime = microtime(true);
		fwrite($this->fp, $packet);
		fread($this->fp,10);
		$restime = microtime(true);
		$info = fread($this->fp,4); // "info"
		if ($info != "info") return false;
		$this->ping = round(1000*($restime-$reqtime));
		$this->version = $this->readString();
		$this->name = $this->readString();
		$this->map = $this->readString();
		$this->gametype = $this->readString();
		$this->readString(); // unknown
		$this->readString(); // unknown
		$this->numplayers = $this->readString();
		$this->maxplayers = $this->readString();
		$this->players = array();
		for ($i=0; $i<$this->numplayers; $i++) {
			$player = new TeeworldsPlayer();
			$player->name = $this->readString();
			$player->score = intval($this->readString());
			$this->players[] = $player;
		}
		fclose($this->fp);
		return true;
	}
}
?>
