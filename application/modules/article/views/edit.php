<div id="navbar"><?=button("view", "View", "search",  "/article/view/".$article->id.".html"). " " 
.button("delete", "Delete", "minusthick",  "/article/delete/".$article->id.".html", "confirmClick");?></div>
<?=form_open_multipart("article/save");
echo form_hidden('id', $article->id);
echo "<img style='float: right' src='/thumb/index/width/200/height/200?i=/images/news/".$article->images."' />";
echo "<p><label>Image URL:</label>/images/news/".$article->images."</p>";
echo "<p><label for='title'>Title:</label>".form_input('title', $article->title)."</p>";
echo "<p><label for='alias'>Alias:</label>".form_input('alias', $article->alias)." (This will be generated from the title if left blank)</p>";
//echo "<p><label for='brief'>Brief:</label>".form_textarea('brief', $article->brief)."</p>";
echo "<p><label for='images'>Image:</label>".form_upload("file")."</p>";
echo "<p><label for='state'>State:</label>".form_dropdown("state", array('1' => "Published", '0' => "Not Published"), $article->state)."</p>";
echo "<p><label for='state'>Section:</label>".form_dropdown("sectionid", $sections, $article->sectionid, "id='section'")."</p>";
echo "<p><label for='state'>Category:</label><div id='cat'>".form_dropdown("catid", $categories, $article->catid)."</div></p>";
echo "<sub>".$article->modified."</sub>";
?>
<input type="submit" value="Save" />
<h3>Intro text</h3>
<textarea rows="40" cols="50" name="introtext" id="content22" ><?=$article->introtext;?></textarea>
<?php echo display_ckeditor($ckeditor); ?>

<h3>Full text</h3>
<textarea rows="40" cols="50" name="fulltext" id="content222" ><?=$article->fulltext;?></textarea>
<?php echo display_ckeditor($ckeditor2);
echo form_close();
?>
<script>
$('#section').change(function() {
	val = $('#section').val();
	$("#cat").load("/article/getcat/"+val);
});
</script>
