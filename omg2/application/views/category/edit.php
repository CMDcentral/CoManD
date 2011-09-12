<div id="navbar">
<?=button("delete", "Delete", "plusthick", "/category/delete/".$category->id.".html", "confirmClick")?>
<div style="clear: both;"></div>
<img src="/thumb/index/width/250/height/250?i=<?=$category->cimage?>" />
</div>
<div style="clear: both;"></div>
<?=form_open_multipart("category/save");?>
 <fieldset>
  <legend>Category Information</legend>
   <input type="hidden" name="id" id="id" value="<?=$category->id?>" />
<?
item("Title:", "title", '', $category);
item("Name:", "name", '', $category);
item("Alias:", "alias", '', $category);
upload("Image:", "cimage", 'size="50"', $category);
dropdown("Section:", "section", $sections, $category);
$pub = array(0 => "Not Published", 1 => "Published");
dropdown("Published:", "published", $pub, $category);
item("Ordering:", "ordering", '', $category);
$i = 1;
?>
 <div style="clear: both;"></div>
 <input type="submit" value="Update" />
 </fieldset>
</form>
</div>
