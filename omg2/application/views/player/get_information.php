 <fieldset>
  <legend><?=$tab->title?></legend>
  <table id="infotable" border="0" cellspacing="0" cellpadding="0" width="100%">
  <thead><th></th><th></th></thead>
  <tbody>
<?
$user = get_user($player);
$ua = (array) $user;
$i = 0;
foreach ($fields as $field)
{
if ($ua[$field->name] != "") {
if ($i % 2 == 0)
	$class = "#CCC";
else
	$class = "#FFF";
if ($field->type == "image") {
	$val = $ua[$field->name];
	$ua[$field->name] = '<img src="/thumb/index/width/200/height/200?i=/images/profile/'.$val.'" />';
}
$CI = &get_instance();
$CI->load->model("Playermodel");
$items = $CI->Playermodel->get_values($field->fieldid);
if ($items) {
?>
<tr style="background-color: <?=$class?>;"><td><?=$field->title?></td><td><?=nl2br($items[$ua[$field->name]])?></td></tr>
<? } else { ?>
<tr style="background-color: <?=$class?>;"><td><?=$field->title?></td><td><?=nl2br($ua[$field->name])?></td></tr>
<?
}
$i++;
}
}
?>
 </tbody>
 </table>
 </fieldset>
        <script type="text/javascript">
        $(function() {
                $("#infotable").tablesorter({ widgets: ['zebra']});
        });
        </script>

