
<?
$bc = $this->bc2conn;
$bc->connect($server->ip, $server->port);
$bc->loginSecure($server->password);
?>
<div id="holder">
<h2><?=$bc->getServerName()?></h2>
<div class="note">
<img src="/thumb/index/width/100/height/100?i=<?=$game->image?>" style="float: left;" title="<?=$game->name?>"/>
<?
$Map = $bc->getCurrentMap();
$find = array("GR","CQ","SR","SDM","Levels","/","levels","gr","cq","sr","sdm","r","R");
$replace = array("","","","","","","","","","","","","");
$Map = str_replace($find, $replace, $Map);
$Map = strtoupper($Map);
?>
<img src="/playerstats/img/maps/<?=$Map?>.jpg" style="float: right;" title="Map Image" />
<ol>
    <li><b>Game:</b> <?=$game->name?></li>
    <li><b>Mode:</b> <?=$bc->getCurrentPlayMode()?></li>
    <li><b>Map:</b> <?=$bc->getCurrentMapName()?></li>
    <li><b>Round:</b> <?=$bc->getCurrentGameRound()?> / <?=$bc->getGameMaxRounds( );?></li>
    <li><b>Players:</b> <?=$bc->getCurrentPlayers() . "/" . $bc->getMaxPlayers()?></li>
    <li><b>Ranked:</b> <?=status($bc->adminVarGetRanked()) ?></li>
    <li><b>Punkbuster:</b> <?=status($bc->adminVarGetPunkbuster()) ?></li>
    <li><b>Server IP:</b> <?=$bc->getServerIP( );?></li>
</ol>

<div style="clear: both;"></div>
</div>
<hr class="dotted" />
<h3>Players</h3>
<table width="100%" id="players" class="tablesorter" border="0">
<thead>
<tr><th>Clan Tag</th><th>Name</th><th>Team</th><th>Squad</th><th>Kills</th><th>Deaths</th><th>Score</th><th>Ping</th></tr>
</thead>
<?
$ServerData =$bc->getPlayerlist();
        $ii = 0;
        for ($i = 12; $i < count($ServerData); $i+=9){
	$teamid = $ServerData[$i+3];
	$team = $bc->getTeamName($bc->getCurrentMap(), $bc->getCurrentPlayMode() , $teamid);
                ++$ii;
	echo 
"<tr><td>".$ServerData[$i]."</td><td>".$ServerData[$i+1]."</td><td>".$team."</td><td>".$ServerData[$i+4]."</td><td>".$ServerData[$i+5]."</td><td>".$ServerData[$i+6]."</td><td>".$ServerData[$i+7]."</td><td>".$ServerData[$i+8]."</td></tr>";
        }

if (!$ServerData[12])
	echo "<tr><td colspan='8'>No Players online</td></tr>";
?>
</table>
</div>
<script type="text/javascript">
        $(function() {
                $("#players").tablesorter({sortList:[[6,1]], widgets: ['zebra']});
        });        
</script>

