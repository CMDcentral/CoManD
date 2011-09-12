<div id="navbar"><?=button("view", "View", "search",  "/services/view/".$service->id.".html"). " " 
.button("delete", "Delete", "minusthick",  "/services/delete/".$service->id.".html", "confirmClick");?></div>
<?=form_open_multipart("services/save");
echo form_hidden('id', $service->id);
echo "<img style='float: right' src='/thumb/gen/width/200/height/200/folder/news/image/".$service->images."' />";
echo "<p><label for='name'>Name:</label>".form_input('name', $service->name)."</p>";
echo "<p><label for='alias'>Alias:</label>".form_input('alias', $service->alias)." (This will be generated from the title if left blank)</p>";
echo "<p><label for='images'>Image:</label>".form_upload("file")."</p>";
?>
<p><label>Brief:</label><textarea rows="5" cols="50" name="brief" id="" ><?=$service->brief;?></textarea></p>
<h3>Description</h3>
<textarea rows="40" cols="50" name="description" id="content22" ><?=$service->description;?></textarea>
<input type="submit" value="Save" />
<?php echo display_ckeditor($ckeditor);
echo form_close();
?>
<script>
$('#section').change(function() {
	val = $('#section').val();
	$("#cat").load("/article/getcat/"+val);
});
</script>
