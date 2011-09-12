<div id="toolbar">
 <?=anchor($_SERVER['HTTP_REFERER'], "back")?>
</div>
<?
echo form_open_multipart("member/save");
echo form_hidden('id', $member[0]->id);
echo "<p><label>Name: </label>".form_input('name', $member[0]->name)."</p>";
echo "<p><label for='images'>Image:</label>".form_upload("file")."</p>";
echo "<p><label>Position: </label>".form_input('position', $member[0]->position)."</p>";
echo "<p><label>Birth: </label>".form_input('dob', $member[0]->dob)."</p>";
echo "<p><label>Information: </label>".form_textarea('information', $member[0]->information)."</p>";
echo display_ckeditor($ckeditor);
echo form_submit("submit", "Submit");
echo form_close();
?>
