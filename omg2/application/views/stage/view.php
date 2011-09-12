<div id="navbar">
<?=button("enter", "<b>Enter Tournament</b>", "plus", "/stage/join/".$stage->s_id, "popup");
echo " ".button("view", "View League", "search", "/league/view/".$league['info']->t_alias.".html");?> <?=button("view", "Back", "triange-1-w", ref());?></div>
<h1 class="title"><?=$stage->s_name?></h1>
<hr class="dotted" />
<div class="note">
<img style="float: left" src="/thumb/index/width/150/height/150?i=<?=$league['info']->image?>" />
<ol>
    <div class="info"><?=$stage->s_descr?></div>
    <li><b>Start Date</b>: <?=datef($stage->start, false)?></li>
    <li><b>End Date</b>: <?=datef($stage->end, false)?></li>
    <li><b>Entries Open</b>: <?=datef($stage->reg_start, false)?></li>
    <li><b>Entries Close</b>: <?=datef($stage->reg_end, false)?></li>
    <li><b>Game</b>: <?=$league['info']->game?></li>
    <li><b>Tournament</b>: <a href="/league/view/<?=$league['info']->t_alias?>.html"><?=$league['info']->abbv . " " . $league['info']->name?></a></li>
    <li><b>Entrants</b>: <?=$stage->entrants?> team(s)</li>
</ol>

<div style="clear: both;"></div>
</div>

<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Sponsors</a></li>
	 	<li><a href="#tabs-3">Prizes</a></li>
		<li><a href="#tabs-2">Teams</a></li>
	</ul>
	<div id="tabs-1">
<fieldset>
<legend>Sponsors</legend>
<span class="note"><?=$stage->s_rules?></span>
</fieldset>
	</div>
	<div id="tabs-3">
	<?=nl2br($league['info']->prizes)?>
	</div>
	<div id="tabs-2">
<table border="0" cellpadding="0" cellspacing="0" width="100%" id="teamlist" name="teamlist" class="tablesorter">
<thead>
<tr><th>Clan</th><th>Tag</th><th>Name</th><th>Members</th><th>Game</th><th>Formed</th><th>Status</tr>
</thead>
<tbody>
<?
$i = 1;
if (sizeof($stage->entries) == 0)
        echo "<tr><td colspan='6'>No participants as of yet.</td></tr>";
foreach ($stage->entries as $item)
{
$clan = team($item->team_id);
?>
<tr style="cursor: pointer;" onClick="goto('<?=$clan->id?>')">
<td><?=$i++?>. <a href="/team/view/<?=$clan->id?>.html"><?=$clan->clanname?><a/></td>
<td><?=$clan->tag?></td><td><?=$clan->t_name?></td>
<td><?=sizeof($clan->members)?></td>
<td><?=$clan->game?></td><td><?=nicetime($clan->added)?></td>
<td>
<?
if ($item->status == 1 && sizeof($clan->members) >= $league['info']->minPlayers && sizeof($clan->members) <= $league['info']->maxPlayers)
	echo "<a class='tooltip' title='Team matches required criteria'>Active</a>";
else
	echo "<a class='tooltip' title='Team does not match required criteria<br/>Min Players: ".$league['info']->minPlayers."<br/>Max Players: ".$league['info']->maxPlayers."'>Inactive</a>";
?>
</td>
</tr>
<?
}
?>
</tbody>
</table>

	</div>
</div>
	<script>
	$( "#dialog-modal" ).dialog({
			autoOpen: false,
			show: "blind",
			modal: true,
			hide: "explode"
		});

		$( "#add" ).click(function() {
			$( "#dialog-modal").dialog( "open" );
			return false;
		});
	$(function() {
		$( "#tabs" ).tabs( { cookie: 1 });
	});
        $(function() {
                $("#teamlist").tablesorter({sortList:[[1,0]], widgets: ['zebra']});
        });
	function goto(id) {
	 location.href = "/team/view/"+id+".html";
	}
	</script>
