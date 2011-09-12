<div id="navbar"><?=button("view", "View", "search", "/pages/view/".$page[0]->alias);?></div>
<?=form_open("pages/save");
echo form_hidden('id', $page[0]->id);
echo "<p><label for='title'>Title:</label>".form_input('title', $page[0]->title)."</p>";
echo "<p><label for='alias'>Alias:</label>".form_input('alias', $page[0]->alias)."</p>";
?>
<input type="submit" value="Save">
<textarea name="content" id="content22" ><?=$page[0]->content;?></textarea>
<?
echo form_close();
echo display_ckeditor($ckeditor);
