<div id="navbar"><?
if (admin())
 echo button("edit", "Edit League", "pencil", "/league/edit/".$league->t_alias.".html"). " ";

echo button("view", "Back", "triange-1-w", "/clan/listing.html");
?></div>
<span id="addteam"></span>
<img src="/thumb/index/width/50/height/50?i=<?=$league->image?>" style="float: left;" />
<h1 class="title"><?=$league->abbv?> <?=$league->name?></h1>
<hr class="dotted" />
<!-- <div class="note">
<img style="float: left" src="/thumb/index/width/150/height/150?i=<?=$league->logo?>" />
<img src="/thumb/index/width/100/height/100?i=<?=$league->image?>" style="float: right;" />
<ol>
    <li>Game: <?=$league->game?></li>
    <li>Description: <?=$league->descr?></li>
</ol>
<div style="clear: both;"></div>
</div> -->
<?
if (sizeof($stages) == 0)
        echo "<h4>No stages</h4>";
foreach ($stages as $stage)
{
?>
<fieldset>
 <legend><a href="/stage/view/<?=$stage->s_id?>.html"><?=$stage->s_name?></a></legend>
 <div id="navbar">
<?
if (admin())
        echo button("edit", "Edit Stage", "pencil", "/stage/edit/".$stage->s_id.".html"). " ";
echo " ".button("view", "View Stage", "search", "/stage/view/".$stage->s_id.".html");
?>
 </div>
 <div class="note"><?=$stage->s_descr?></div>
<?
if ($stage->s_reg  == 1)
        echo "<p><label>Entries Close: </label> ".datef($stage->reg_end, false)."</p>";
?>
 <p><label>Start Date: </label> <?=datef($stage->start, false)?></p>
 <p><label>End Date: </label> <?=datef($stage->end, false)?></p>
 <p><label>Entries: </label> <b><?=$stage->entrants?> team(s)</b></p>
<?
$regend = strtotime($stage->reg_end);
$now = strtotime(date("Y-m-d"));
if ($now > $regend || $stage->s_reg == 0) {
	echo "<p><label>Status:</label><b>Closed</b></p>";
	$open = false;
} else {
	$open = true;
	echo "<p><label>Status:</label><b>Open</b></p>";
}
if ($open && lin())
	echo "<center>".button("enter", "<b>Enter Tournament</b>", "plus", "/stage/join/".$stage->s_id, "popup")."</center>";

?>
</fieldset>
<?
}
?>
<div id="tabs">
	<ul>
                <li><a href="#tabs-prizes">Prizes</a></li>
		<li><a href="#tabs-1">Rules</a></li>
		<li><a href="#tabs-2">Sponsors</a></li>
	</ul>
	<div id="tabs-prizes">
	<?=nl2br($league->prizes);?>
	</div>
	<div id="tabs-1">
	<fieldset>
	 <legend>Rules</legend>
	 <span class="note"><?=$league->rules?></span>
	</fieldset>
	</div>
	<div id="tabs-2">
	<fieldset>
	 <legend>Sponsors</legend>
	 <span class="note"><?=$league->sponsor?></span>
	</fieldset>
	</div>
</div>

<script>
	$(function() {
		$( "#tabs" ).tabs( { cookie: 1 });
	});
	function goto(id) {
	 location.href = "/player/view/"+id+".html";
	}
</script>
