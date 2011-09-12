<?
function loggedin($controller="home")
{
	$CI = &get_instance();
	$controller2 = $CI->uri->segment(1);
	$method = $CI->uri->segment(2);
	$param = $CI->uri->segment(3);
         if (!$CI->session->userdata('loggedin'))
         {
	    message("You need to be logged in to view this page", "error");
            header("Location: /".$controller.".html?ref=/".$controller2."/".$method."/".$param);
         }
}

function ref() { 
 if (isset($_SERVER['HTTP_REFERER']))
	return $_SERVER['HTTP_REFERER'];
 else
	return "";
 }

function lin()
{
$CI = &get_instance();
if (!$CI->session->userdata('loggedin'))
	return false;
else
	return true;
}

function user_id() {
        $CI = &get_instance();
	return $CI->session->userdata('user');
}

function admin()
{
	$CI = &get_instance();
	if ($CI->session->userdata("user")) {
	if (get_user(user_id())->level == 100) 
		return true;
	else
		return false;
	}
	else
	 return false;
}

function get_user($id)
{
        $CI = &get_instance();
	$CI->load->model("Playermodel");
	return $CI->Playermodel->get($id);
}

function get_role($id)
{
	$roles = roles();
	$output = array();
	$a = array_flatten($roles);
	return $a[$id];
}

function array_flatten($input){
	foreach($input as $key=>$value){
		if(is_array($value)){
			//loop through the array
			foreach($value as $sub){
				$output[] = $sub;
			}
		} else {
			//push this value into the output
			$output[] = $value;
		}
	}
	return $output;
}

function message($msg, $type)
{
	$CI = &get_instance();
	$html = '<div class="info">'.$msg.'</div>';
	$CI->session->set_flashdata('msg', $html);
}

function clanadmin($clanid)
{
	$a = array('role'=>0);
	$member = (object) $a;
 	$CI = &get_instance();
	$clan = $CI->Clanmodel->get($clanid);
	if ($CI->session->userdata("user")) {
		$member = $CI->Clanmodel->get_member($clanid);
		if (sizeof($member) == 0)
			$member = (object) $a;
		$id = user_id();
	} else {
		$member->role=0;
		$id = -1;
	}
	if (sizeof($clan) > 0) {
	if ($clan->owner == $id || $member->role == 5) {
		return true;
	}
	}
	return false;
}

function _prep_password($password)
{
	$CI = &get_instance();
        return sha1($password.$CI->config->item('encryption_key'));
}

function age_from_dob($dob) {
    list($y,$m,$d) = explode('-', $dob);
    if (($m = (date('m') - $m)) < 0) {
        $y++;
    } elseif ($m == 0 && date('d') - $d < 0) {
        $y++;
    }
    return date('Y') - $y . "yrs";
}

function item($name, $id, $additional="", $user2)
{
$user2 = (array) $user2;
?>
   <p>
     <label for="<?=$id?>"><?=$name?> </label>
     <input <?=$additional?> name="<?=$id?>" size="25" minlength="2" value="<?=$user2[$id]?>" />
   </p>
   <div style="clear: both;"></div>
<?
}

function textarea($name, $id, $additional="", $user2) {
$user2 = (array) $user2;
?>
   <p>
     <label for="<?=$id?>"><?=$name?> </label>
     <textarea id="<?=$id?>" <?=$additional?> name="<?=$id?>" rows="5" cols="25" ><?=$user2[$id]?></textarea>
   </p>
   <div	style="clear: both;"></div>
<?
}

function upload($name, $id, $additional="", $user2) {
$user2 = (array) $user2;
?>
   <p>
     <label for="<?=$id?>"><?=$name?> </label>
     <input type="file" id="<?=$id?>" <?=$additional?> name="<?=$id?>" value="<?=$user2[$id]?>" />
   </p>
   <div	style="clear: both;"></div>
<?
}

function dropdown($name, $id, $additional="", $user2) {
$user2 = (array) $user2;
?>
   <p>
     <label for="<?=$id?>"><?=$name?> </label>
     <?=form_dropdown($id, $additional, $user2[$id]);?>
   </p>
   <div	style="clear: both;"></div>
<?
}


function roles() {
	return array("Reserve" => array(0 => "Reserve"), "Normal" => array(1 => "Private", 2 => "Corporal", 3 => "Officer"), "Clan Admins" =>array(4 => "General of the Army", 5 => "Commander"));
}

function log_info($data)
{
	$CI = &get_instance();
	if (!isset($data['owner']))
		$data['owner'] = user_id();
        $CI->db->insert('log', $data);
}

function newsfeed()
{
        $CI = &get_instance();
	$CI->db->limit(5);
	$CI->db->order_by('added', 'desc');
        $items = $CI->db->get('log')->result();
	$out = "<ul>";
	foreach ($items as $item)
		$out .= "<li>".$item->info." <sub> " . nicetime($item->added) . "</sub></li>";
	$out .= "</ul>";
	echo $out;
}

function nicetime($date)
{
    if(empty($date)) {
        return "No date provided";
    }
    $periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
    $lengths         = array("60","60","24","7","4.35","12","10");
    $now             = time();
    $unix_date         = strtotime($date);
       // check validity of date
    if(empty($unix_date)) {    
        return "Bad date";
    }
    // is it future date or past date
    if($now > $unix_date) {    
        $difference     = $now - $unix_date;
        $tense         = "ago";
    } else {
        $difference     = $unix_date - $now;
        $tense         = "from now";
    }
    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
        $difference /= $lengths[$j];
    }
    $difference = round($difference);
    if($difference != 1) {
        $periods[$j].= "s";
    }    
    return "$difference $periods[$j] {$tense}";
}

function inclan()
{
	$CI = &get_instance();	
	if ($CI->session->userdata("user")) {
 	 if ($CI->Clanmodel->inclan())
		return true;
	 else
		return false;
	}
	return false;
}

function team($id) {
        $CI = &get_instance();
	$CI->load->model("Teammodel");
	$team = $CI->Teammodel->get($id);
	return $team;
}

function clan($id) {
        $CI = &get_instance();
        $CI->load->model("Clanmodel");
        $team = $CI->Clanmodel->get($id);
        return $team;
}

function button($id, $text, $icon, $link="", $class="")
{
//   onClick="window.location=\''.$link.'\';return false;"
return '<a id="'.$id.'" href="'.$link.'" class="'.$class.'" ><button class="ui-state-default ui-corner-all" id="'.$id.'">
	<div style="float: left;" class="ui-icon ui-icon-'.$icon.'"></div>'.$text.'</button></a>';
}

function fb_share($alias)
{
$fb= "<a 
href=\"javascript:var%20d=document,f='http://www.facebook.com/share',l=d.location,e=encodeURIComponent,p='.php?src=bm&v=4&i=1216453911&u='+e(l.href)+'&t='+e(d.title);1;try{if%20(!/^(.*\.)?facebook\.[^.]*$/.test(l.host))throw(0);share_internal_bookmarklet(p)}catch(z)%20{a=function()%20{if%20(!window.open(f+'r'+p,'sharer','toolbar=0,status=0,resizable=1,width=626,height=436'))l.href=f+p};if%20(/Firefox/.test(navigator.userAgent))setTimeout(a,0);else{a()}}void(0)\">
<img 
src=\"http://www.insidefacebook.com/wp-content/uploads/2011/02/share.png\" border=\"0\"></a>";
$twit = '<a href="http://twitter.com/share" data-url="/news/view/<?=$alias?>.html" class="twitter-share-button" data-count="none">Tweet</a><script type="text/javascript" 
src="http://platform.twitter.com/widgets.js"></script>';
return $fb . " " . $twit;
}

function email($data, $from="")
{
    $CI = &get_instance();
    $CI->email->to($data['recipient']);
    if ($from == "")
	$CI->email->from("no-reply@egamingsa.co.za", "eGaming South Africa");
    else
	$CI->email->from($from['email'], $from['name']);
    $CI->email->subject($data['subject']);
    $CI->email->message($data['msg']);
    $CI->email->send();
}


function teeworld($server) {
	$socket = stream_socket_client('udp://'.$server , $errno, $errstr, 1); 
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
		fclose($socket);		
		return $tmp;
		
	} else {
		fclose($socket);
		return FALSE;
	}
}

function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

	function datef($date, $time=true) {
		$datetime = strtotime($date);
		if ($time)
		 $mysqldate = date("d F Y g:i A", $datetime);
		else
		 $mysqldate = date("d F Y", $datetime);
		return $mysqldate;
	}

function source_query($ip)
{
    $result = "";
    $name = "";
    $map = "";
    $info = array();
    $cut = explode(":", $ip);
    $HL2_address = $cut[0];
    $HL2_port = $cut[1];
    $HL2_stats = "";
    $HL2_command = "\377\377\377\377TSource Engine Query\0";

    $HL2_socket = fsockopen("udp://" . $HL2_address, $HL2_port, $errno, $errstr, 3);
    fwrite($HL2_socket, $HL2_command);
    $JunkHead = fread($HL2_socket, 4);
    $CheckStatus = socket_get_status($HL2_socket);

    if ($CheckStatus["unread_bytes"] == 0)
        return 0;

    $do = 1;
    while ($do) {
        $str = fread($HL2_socket, 1);
        $HL2_stats .= $str;
        $status = socket_get_status($HL2_socket);
        if ($status["unread_bytes"] == 0) {
            $do = 0;
        }
    }
    fclose($HL2_socket);
    $x = 0;
    while ($x <= strlen($HL2_stats)) {
        $x++;
        $result .= substr($HL2_stats, $x, 1);
    }

    // ord ( string $string );
    $result = str_split($result);
    $info['network'] = ord($result[0]);
    $char = 1;
    while (ord($result[$char]) != "%00") {
        $info['name'] .= $result[$char];
        $char++;
    }
    $char++;
    while (ord($result[$char]) != "%00") {
        $info['map'] .= $result[$char];
        $char++;
    }
    $char++;
    while (ord($result[$char]) != "%00") {
        $info['dir'] .= $result[$char];
        $char++;
    }
    $char++;
    while (ord($result[$char]) != "%00") {
        $info['description'] .= $result[$char];
        $char++;
    }
    $char++;
    $info['appid'] = ord($result[$char] . $result[($char + 1)]);
    $char += 2;
    $info['players'] = ord($result[$char]);
    $char++;
    $info['max'] = ord($result[$char]);
    $char++;
    $info['bots'] = ord($result[$char]);
    $char++;
    $info['dedicated'] = ord($result[$char]);
    $char++;
    $info['os'] = chr(ord($result[$char]));
    $char++;
    $info['password'] = ord($result[$char]);
    $char++;
    $info['secure'] = ord($result[$char]);
    $char++;
    while (ord($result[$char]) != "%00") {
        $info['version'] .= $result[$char];
        $char++;
    }

    return $info;
}

function status($bool) {
if ($bool || $bool==1)
	return '<a class="ui-icon ui-icon-check"></a>';
else
	return '<a class="ui-icon ui-icon-closethick"></a>';
}

function comments($comments, $id) {
	$CI = &get_instance();
?>
<div id="contentbottom">
        <div class="horizontal float-left width100"><div class="module mod-box mod-box-templatecolor  first last">
        <div class="box-t1">
        <div class="box-t2">
        <div class="box-t3"></div>
        </div>
	</div>
	<div class="box-1">
        <div class="box-2 deepest" style="min-height: 80px;">
	<a id="comments"></a>
        <div id="navbar"><?=button("addComment", "Add Comment", "plusthick", "");?></div>
        <h3 class="header"><span class="header-2"><span class="header-3"><span class="color"><?=ucfirst($CI->router->class)?></span> Comments</span></span></h3>
         <table width="100%" class="hovertable">
        <?
        foreach ($comments as $comment) {
	if (user_id() == $comment->user_id)
		$extra = button("delete", "", "closethick", "/comment/delete/".$comment->id.".html");
	else
		$extra = "";
        $time = nicetime($comment->date_time);
        $user = get_user($comment->user_id);
	$img = "<img src='".cropper($user->avatar, "/images/profile/", 100, 100)."' title='".$user->alias."' />";
//        $img = "<img src='/thumb/profile_gen/width/75/height/75/player/".$comment->user_id."' />";
        echo "<tr class='even'><td width='50px'><a href='/player/view/".$user->id.".html'>".$img."<br/>".$user->alias."</a><br/><sub>".$time."</sub></td>";
        echo "<td>".nl2br($comment->comment)."</td><td width='10px;'>".$extra."</td></tr>";
	} 
	if (sizeof($comments) == 0)
		echo "<tr><td colspan='2'>No comments.</td></tr>";
	?>
 </table>
<? if (lin()) { ?>
	<a id="enterPost"></a>
        <form method="POST" id="commentForm" style="display: none;" action="/comment/save.html">
        <input type="hidden" name="controller" value="<?=$CI->router->class?>" />
        <input type="hidden" name="oid" value="<?=$id?>" />
        <p><label>Comment: </label><textarea name="comment" rows="3" cols="50"></textarea></p>
	<p><label>Add to newsfeed:</label><input type="checkbox" name="newsfeed" checked="checked" /></p>
        <p><input type="submit" value="Add Comment" /></p>
        </form>
<? } else { "<div id='commentForm'><h3>You need to be logged in to comment.</h3></div>"; } ?>
                </div>
        </div>
        <div class="box-b1">
                <div class="box-b2">
                        <div class="box-b3"></div>
                </div>
  	</div>

</div>
</div>
</div>
<?
}

/**
* Change password
*
* @param string $username
* @param string $newPassword
* @return boolean
*/
function user_edit($username, $newPassword)
{
 global $db, $user, $auth, $config, $phpbb_root_path, $phpEx;

 if (empty($username) || empty($newPassword))
 {
   return false;
 }

 $sql = 'UPDATE ' . USERS_TABLE . ' SET user_password=\'' . $db->sql_escape($newPassword) . '\' WHERE user_email = \''.$username.'\'';
 $db->sql_query($sql);

 return true;
}

function comment_count($id, $controller) {
	$CI = &get_instance();
	$CI->load->model("Commentmodel");
	$query = $CI->Commentmodel->get($controller, $id);
	return sizeof($query);
}

function activity($activity) {
	$i = 0;
if (sizeof($activity) > 0) {
       foreach ($activity as $item) {
        $user = get_user($item->owner);
        $img = cropper($user->avatar, "/images/profile/", 60, 60);
	if ($i == 0)
		echo "<hr class='dotted' />";
	?>
        <div class="act" id="<?=$item->id?>">
	<?
	if ($item->owner == user_id()) {
		echo "<div style='float: right;'>".button("del", "", "close", "/activity/delete/".$item->id.".html", "confirmClick")."</div>";
	}
	?>
 	<img style="padding-right: 5px; float: left;" src="<?=$img?>" title="<?=$user->alias?>" class="tooltip" />
  	<a href="/player/view/<?=$user->id?>"><?=$user->alias?></a><br style="clear:none;"/>
        <?=$item->info?><br style="clear:none;"/>
  	<sub><?=nicetime($item->added)?></sub>
 	<div style="clear: both;"></div>
  	</div>
	<? 
	if ($i != sizeof($activity) -1) { ?>
        <hr class="dotted" />
	<?
	}
        $i++;
	}
}
}

function sec2hms ($sec, $padHours = false) 
  {
    // start with a blank string
    $hms = "";
    // do the hours first: there are 3600 seconds in an hour, so if we divide
    // the total number of seconds by 3600 and throw away the remainder, we're
    // left with the number of hours in those seconds
    $hours = intval(intval($sec) / 3600); 
    // add hours to $hms (with a leading 0 if asked for)
    $hms .= ($padHours) 
          ? str_pad($hours, 2, "0", STR_PAD_LEFT). ":"
          : $hours. ":";
    // dividing the total seconds by 60 will give us the number of minutes
    // in total, but we're interested in *minutes past the hour* and to get
    // this, we have to divide by 60 again and then use the remainder
    $minutes = intval(($sec / 60) % 60); 
    // add minutes to $hms (with a leading 0 if needed)
    $hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ":";
    // seconds past the minute are found by dividing the total number of seconds
    // by 60 and using the remainder
    $seconds = intval($sec % 60); 
    // add seconds to $hms (with a leading 0 if needed)
    $hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);
    // done!
    return $hms; 
  }

function update_status($username, $password, $message)  
{  
    $url = 'http://twitter.com/statuses/update.xml';
    $ch = curl_init($url);  
  
    curl_setopt($ch, CURLOPT_POST, 1);  
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'status='.urlencode($message));  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
    curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $password);  
    curl_exec($ch);  
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
    // if we were successfull we need to update our last_message  
    if ($httpcode == '200')  
    {  
	echo "Updated";
        return TRUE;  
    }  
  
    else  
    {  
	echo "Error";
        return FALSE;  
    }  
}  

function get_theme() {
	$CI = &get_instance();
	$CI->db->where('key', 'theme');
	$query = $CI->db->get('settings');
	$info = $query->row();
	return $info->value;
}

function get_theme_path() {
	$CI = &get_instance();
	return "/themes/".get_theme();
}

?>
