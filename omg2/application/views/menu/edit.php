<div id="navbar"><?=button("add", "Add Item", "plus", "/menu/index.html");?> <?=button("delete", "Delete Item", "minus", "/menu/delete/".$this->uri->segment(3).".html");?></div>
<h2>Manage Menu</h2>
<form id="form1" name="form1" method="post" action="/menu/save.html">
<h3>Add/Edit Menu Item</h3>
  <table width="100%" border="0">
    <tr>
      <td rowspan="7">Parent:</td>
      <td rowspan="7"><select id="item" name="parent" size="20">
          <option value="0">Root</option>
          <? //$get_options = $menu->get_cat_selectlist(0, 0);
	print_r($get_options);
if (count($get_options) > 0){
$CI = &get_instance();
$CI->load->model("Menumodel");
foreach ($get_options as $key => $value) {
$options .="<option value=\"$key\"";
$parent_item = $menu->parent;
// show the selected items as selected in the listbox
if ($_POST['cboParent'] == "$key" || $parent_item == "$key") {
$options .=" selected=\"selected\"";
}
$options .=">$value</option>\n";
}
}
echo $options;
 ?>
      </select></td>
      <td style="display: none;">Type:</td>
      <td style="display: none;"><label>
        <select onchange="changeType(this.value);" name="type" id="cboType">
          <option disabled="disabled">--select--</option>
          <option value="category">category</option>
          <option value="page">page</option>
          <option value="package">package</option>
          <option value="external">external</option>
          <option value="list">list</option>
          <option value="other">other</option>
        </select>
        <input type="hidden" name="id" id="txtId" value="<?=$menu->id;?>" />
        <input type="hidden" name="pageid" id="txtPageId" value="<?=$menu->pageid;?>" />
        <input type="text" name="type" hidden="hidden" id="txtType" value="<?=$menu->type;?>" />
        <a href="#" onClick="Open();">Properties</a>
      </label></td>
    </tr>
    <tr>
      <td>Name:</td>
      <td><label>
        <input type="text" name="name" id="txtName" value="<?=$menu->name;?>" />
      </label></td>
    </tr>
    <tr>
      <td>Alias:</td>
      <td><input type="text" name="alias" id="txtAlias"  value="<?=$menu->alias;?>" /></td>
    </tr>
    <tr>
      <td>Link:</td>
      <td><input name="link" type="text" id="txtLink" value="<?=$menu->link;?>" /></td>
    </tr>
    <tr>
      <td>Description:</td>
      <td><label>
        <textarea name="description" id="txtDesc" cols="45" rows="5"><?=$menu->description;?></textarea>
      </label></td>
    </tr>
      <td>Visible:</td>
      <td><label>
        <?
$item = array('1' => "Yes", 0 => "No");
echo form_dropdown("visible", $item, $menu->visible);
?>
      </label></td>
    <tr>
      <td>Order:</td>
      <td><label>
        <input name="ordering" type="text" value="<?=$menu->ordering;?>" />
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><label>
        <input type="submit" name="submit" id="btnUpdate" value="save" />
      </label></td>
    </tr>
  </table>
</form>

<h3>Manage Menu</h3>
<img src="images/color.jpg" width="1000" height="1" /><br />
<? echo $menudisp; ?>
<script>
$("#item").dblclick( function () { location.href = "/menu/index/"+$("#item").val()  });
</script>
