<div id="navbar">
<?=button("delete", "Delete", "plusthick", "/server/delete/".$server->id.".html", "confirmClick")?>
<div style="clear: both;"></div>
<div id="addteam"></div>
</div>
<div style="clear: both;"></div>
<?=form_open_multipart("server/save");?>
 <fieldset>
  <legend>server Information</legend>
   <input type="hidden" name="id" id="id" value="<?=$server->id?>" />
<?
item("Name:", "name", '', $server);
item("IP:", "ip", '', $server);
item("Password:", "password", '', $server);
item("Port:", "port", '', $server);
dropdown("Game:", "game", $games, $server);
?>
 <div style="clear: both;"></div>
 <input type="submit" value="Update" />
 </fieldset>
</form>
</div>
