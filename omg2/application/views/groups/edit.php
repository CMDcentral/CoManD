<div id="navbar">
<?=button("delete", "Delete", "plusthick", "/groups/delete/".$group->id.".html", "confirmClick")?>
<div style="clear: both;"></div>
</div>
<div style="clear: both;"></div>
<?=form_open_multipart("group/save");?>
 <fieldset>
  <legend>Group Information</legend>
   <input type="hidden" name="id" id="id" value="<?=$group->id?>" />
<?
item("Name:", "group_name", '', $group);
item("Stage ID:", "s_id", '', $group);
item("Ordering:", "ordering", '', $group);
$i = 1;
?>
 <div style="clear: both;"></div>
 <input type="submit" value="Update" />
 </fieldset>
</form>
</div>
