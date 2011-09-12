<div id="navbar">
<?=button("delete", "Delete", "plusthick", "/game/delete/".$game->id.".html", "confirmClick")?>
<?=button("view", "Back", "back", "/clan/view/$clan->id.html");?></div>
<div style="clear: both;"></div>
<img style="float: left" src="/thumb/index/width/140/height/140?i=<?=$game->image?>" />
<div id="addteam"></div>
</div>
<div style="clear: both;"></div>
<?=form_open_multipart("game/save");?>
 <fieldset>
  <legend>Game Information</legend>
   <input type="hidden" name="id" id="id" value="<?=$game->id?>" />
<?
item("Name:", "name", '', $game);
item("Abbv:", "abbv", '', $game);
upload("Image:", "image", 'size="50"', $game);
?>
 <div style="clear: both;"></div>
 <input type="submit" value="Update" />
 </fieldset>
</form>
</div>
