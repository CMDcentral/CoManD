<div id="navbar"><?=button("add", "Add Server", "plus", "/server/edit/add.html", "popup");?>
<?=button("back", "Back", "back", ref());?>
</div>
	<script type="text/javascript">
	$(function() {		
		$("#clanlist").tablesorter({sortList:[[0,0]], widgets: ['zebra']})
		.tablesorterPager({container: $("#pager")});
	});	

        function goto(id) {
         location.href = '/clan/view/'+id+'.html';
        }

	</script>

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
if ($server->name == "Battlefield Bad Company 2") {
         $this->bc2conn->connect($server->ip, $server->port);
         $this->bc2conn->loginSecure($server->password);
         $servername = $this->bc2conn->getServerName();
         $players = $this->bc2conn->getCurrentPlayers() . "/" . $this->bc2conn->getMaxPlayers();
         $mode = $this->bc2conn->getCurrentPlaymodeName();
         $map = $this->bc2conn->getCurrentMapName(); }
elseif ($server->name == "Teeworlds") {
	$info = array();
	$stuff = teeworld($server->ip . ":" .$server->port);
	$servername = $stuff['name'];
	$map = $stuff['map'];
	$mode =  $stuff['type'];
	$players = $stuff['player_count_all'] ."/". $stuff['max_players_all'];
}
?>
<tr style="cursor: pointer;">
<td><?=$server->id?></td>
<td><?=$servername?></td>
<td><?=$map?></td>
<td><?=$mode?></td>
<td><?=$players?></td>
<td><?=$server->name?></td>
<td><?=button("book", "Edit", "pencil", "/server/edit/".$server->id.".html", "popup")?></td>
</tr>

<?
}
?>
</tbody>
</table>
