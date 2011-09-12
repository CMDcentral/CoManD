<?
foreach ($categories as $cat) {
	$arr[$cat->id] = $cat->name;
}
?>
<div id="navbar">
<?=button("delete", "Delete", "plusthick", "/video/delete/".$video->id.".html", "confirmClick")?>
<div style="clear: both;"></div>

</div>
<div style="clear: both;"></div>
<?=form_open_multipart("video/save");?>
 <fieldset>
  <legend>Video Information</legend>
   <input type="hidden" name="id" id="id" value="<?=$video->id?>" />
<?
item("Title:", "title", '', $video);
item("YouTube ID:", "youtubeid", '', $video);
dropdown("Category:", "category", $arr, $video);
item("Ordering:", "ordering", '', $video);
$i = 1;
?>
 <div style="clear: both;"></div>
 <input type="submit" value="Update" />
 </fieldset>
</form>
</div>
