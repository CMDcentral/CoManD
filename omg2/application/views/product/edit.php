<div id="navbar"><?=button("view", "View", "search",  "/product/view/".$product->id.".html"). " " 
.button("delete", "Delete", "minusthick",  "/product/delete/".$product->id.".html", "confirmClick");?></div>
<?=form_open_multipart("product/save");
echo form_hidden('id', $product->id);
echo "<img style='float: right' src='/thumb/gen/width/200/height/200/folder/news/image/".$product->images."' />";
echo "<p><label for='name'>Name:</label>".form_input('name', $product->name)."</p>";
echo "<p><label for='alias'>Alias:</label>".form_input('alias', $product->alias)." (This will be generated from the title if left blank)</p>";
echo "<p><label for='price'>Price:</label>".form_input('price', $product->price)."</p>";
echo "<p><label for='service'>Service:</label><div id='cat'>".form_dropdown("service", $services, $product->service)."</div></p>";
echo "<p><label for='images'>Image:</label>".form_upload("file")."</p>";
?>
<input type="submit" value="Save" />
<h3>Description</h3>
<textarea rows="40" cols="50" name="description" id="content22" ><?=$product->description;?></textarea>
<?php echo display_ckeditor($ckeditor);
echo form_close();
?>
<script>
$('#section').change(function() {
	val = $('#section').val();
	$("#cat").load("/article/getcat/"+val);
});
</script>
