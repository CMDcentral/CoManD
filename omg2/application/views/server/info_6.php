<?
$info = teeworld($server->ip.":".$server->port);
?>
<div id="holder">
<h2><?=$info['name']?></h2>
<div class="note">
<img src="/thumb/index/width/100/height/100?i=<?=$game->image?>" style="float: left;" title="<?=$game->name?>"/>
<ol>
    <li><b>Game:</b> <?=$game->name?></li>
    <li><b>Mode:</b> <?=$info['type'];?></li>
    <li><b>Map:</b> <?=$info['map'];?></li>
    <li><b>Players:</b> <?=$info['player_count_all'] . "/" . $info['max_players_all'];?></li>
    <li><b>Spectators:</b> <?=$info['player_count_spectator']?></li>
    <li><b>Max Players Online:</b> <?=$info['max_players_ingame']; ?></li>
    <li><b>Allowed Spectators:</b> <?=$info['max_players_spectator']?></li>
    <li><b>Server IP:</b> <?=$server->ip;?></li>
    <li><b>Stats:</b> <a href="/gamestats/teeworlds.html" class="popup">View Stats</a></li>
</ol>

<div style="clear: both;"></div>
</div>
<hr class="dotted" />
<h3>Players</h3>
<table width="100%" id="players" class="tablesorter" border="0">
<thead>
<tr><th>Clan Tag</th><th>Name</th><th>Flag</th><th>Team</th><th>Score</th></tr>
</thead>
<tr>
<?

foreach ($info['players'] as $player)
{
	echo "<tr><td>".$player['clan']."</td><td>".$player['name']."</td><td>".$player['flag']."</td><td>".$player['team']."</td><td>".$player['score']."</td></tr>";
}

if (sizeof($info['players'] > 0))
	echo "<tr><td colspan='5'>No Players online</td></tr>";
?>
</tr>
</table>
</div>
<script type="text/javascript">
        $(function() {
                $("#players").tablesorter({sortList:[[6,0]], widgets: ['zebra']});
        });        
</script>

