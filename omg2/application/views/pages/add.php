<?=form_open("pages/save");
echo "<p><label for='title'>Title:</label>".form_input('title', "")."</p>";
echo "<p><label for='alias'>Alias:</label>".form_input('alias', "")."</p>";
?>
<textarea name="content" id="content22" ></textarea>
<?php echo display_ckeditor($ckeditor);
echo form_close();
