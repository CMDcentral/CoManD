<? echo form_open_multipart("player/save"); ?>
 <fieldset>
  <legend><?=$tab->title?></legend>
   <input type="hidden" name="id" id="id" value="<?=user_id()?>" />
<?
$user = get_user(user_id());
foreach ($fields as $field)
{
if ($field->type == "textarea")
 textarea($field->title, $field->name, '', $user);
elseif ($field->type == "image") {
 upload($field->title, $field->name, '', $user)."<br/>";
}
elseif ($field->type == "select") {
 $CI = &get_instance();
 $CI->load->model("Playermodel");
 $items = $CI->Playermodel->get_values($field->fieldid);
 dropdown($field->title, $field->name, $items, $user)."<br/>";
}
 else {
 if ($field->readonly)
	$extra = "readonly='readonly'";
 else
	$extra = "";
 item($field->title, $field->name, $extra, $user);
 }
}
?>
 <div style="clear: both;"></div>
 <input type="submit" value="Update" />
 </fieldset>
</form>
 <script>
 jQuery('#dob').datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true, numberOfYears: 40, showButtonPanel: true });
 </script>

