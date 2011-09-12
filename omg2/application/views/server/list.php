<?
//$oTest = new clsRcon('host.istreet.co.za', 27015, 'egsa121password');
//$oTest->connect();
//$aResponse = $oTest->rcon('players');
//print_r($aResponse);
//var_dump($aResponse[0]['String1']);  
?>
	<script type="text/javascript">
	$(function() {		
		$("#clanlist").tablesorter({sortList:[[5,0]], widgets: ['zebra']})
		.tablesorterPager({container: $("#pager")});
	});	

	</script>

<span class="info">eGamingSA has <?=sizeof($servers)?> active game servers.</span>

<div id="pager" class="pager">
        <form>
                <img src="/images/first.png" class="first"/>
                <img src="/images/prev.png" class="prev"/>
                <input type="text" class="pagedisplay"/>
                <img src="/images/next.png" class="next"/>
                <img src="/images/last.png" class="last"/>
                <select class="pagesize">
                        <option value="30">30</option>
                        <option value="60">60</option>
                        <option value="100">100</option>
                </select>
        </form>
</div>
<table border="0" cellpadding="0" cellspacing="0" width="100%" id="clanlist" name="clanlist" class="tablesorter">
<thead>
<tr><th>ID</th><th>Name</th><th>Map</th><th>Mode</th><th>Players</th><th>Game</th><th>Actions</th></tr>
</thead>
<tbody>
<?
foreach ($servers as $server)
{
//print_r($server);
if ($server->name == "Battlefield Bad Company 2") {
         $this->bc2conn->connect($server->ip, $server->port);
         $this->bc2conn->loginSecure($server->password);
         $servername = $this->bc2conn->getServerName();
         $players = $this->bc2conn->getCurrentPlayers() . "/" . $this->bc2conn->getMaxPlayers();
         $mode = $this->bc2conn->getCurrentPlaymodeName();
         $map = $this->bc2conn->getCurrentMapName(); 
//	 $this->bc2conn->close();
}
elseif ($server->name == "Teeworlds") {
	$info = array();
	$stuff = teeworld($server->ip.":".$server->port);
	$servername = $stuff['name'];
	$map = $stuff['map'];
	$mode =  $stuff['type'];
	$players = $stuff['player_count_all'] ."/". $stuff['max_players_all'];
}
elseif ($server->name == "Team Fortress 2") {
	$info = source_query($server->ip.":".$server->port);
	$servername = $info['name'];
	$map = $info['map'];
	$mode = "";
	$players = $info['players'] . "/" . $info['max'];
}

?>
<tr style="cursor: pointer;">
<td><A class="popup" href="/server/info/<?=$server->id?>"><?=$server->id?></a></td>
<td><A class="popup" href="/server/info/<?=$server->id?>"><?=$servername?></a></td>
<td><?=$map?></td>
<td><?=$mode?></td>
<td><?=$players?></td>
<td><?=$server->name?></td>
<td><?
if ($server->bookable == 1)
	echo button("book", "Book", "clock", "/server/book/".$server->id.".html")?>
</td>
</tr>

<?
}
?>
</tbody>
</table>
