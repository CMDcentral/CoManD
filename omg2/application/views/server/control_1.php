<fieldset>
 <legend>Server Info</legend>
 <p><label>Mode:</label> <?=$info->getCurrentPlaymodeName(); ?></p>
 <p><label>Map:</label> <?=$info->getCurrentMapName(); ?></p>
 <p><label>Players:</label> <?=$info->getCurrentPlayers(); ?> / <?=$info->getMaxPlayers(); ?></p>
</fieldset>
<form action="/server/sendcmd/<?=$booking?>.html" method="POST">
<fieldset>
 <legend>Server Controls</legend>
<fieldset class="singleRow">
 <legend>Map Control</legend>
<input type="hidden" value="<?=$server?>" name="server" />
<p><label>Mode:</label><? echo form_dropdown("mode", $modes, $info->getCurrentPlaymode(), "id='mode'"); ?></p>
<p><label>Map:</label><div id="maps">Select Mode Above.</div></p>
<p><input name="change" type="submit" value="Change Map" /></p>
</fieldset>
<fieldset class="singleRow">
<legend>Restart Round</legend>
<input name="restart" type="submit" value="Restart" />
</fieldset>

<div style="clear: both;"></div>
<fieldset>
<legend>Message</legend>
<input name="msg" type="text" placeholder="message..." value="" />
<input name="say" type="submit" value="Say" />
<input name="say" type="submit" value="Yell" />
</fieldset>


</fieldset>
</form>
<div id="output"></div>

<script>
$('#mode').change(function() {
game = this.value;
$('#maps').load("/server/get_maps/"+game+"/<?=$game?>.html");
});
game = $("#mode").val();
$('#maps').load("/server/get_maps/"+game+"/<?=$game?>.html");
</script>
