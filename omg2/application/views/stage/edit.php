<div id="navbar">
<?=button("tm", "Team Management", "plus", "/groupteams/index/".$stage->s_id.".html");?>&nbsp;
<?=button("gm", "Group Management", "plus", "/group/index/".$stage->s_id.".html");?>&nbsp;
<?=button("view", "View League", "search", "/league/view/".$stage->t_id.".html");?> <?=button("stage", "Add Stage", "plus", "/stage/edit/add.html");?> <?=button("back", 
"Back", 
"back", 
ref());?>
</div>
<h1>Stage Management</h1>
<?php
echo form_open_multipart("stage/save", "id='stage'");
$item = $stage;
echo form_hidden("s_id", $item->s_id);
item("Stage Name:", "s_name", "",  $item);
textarea("Stage Description:", "s_descr", "", $item);
dropdown("League:", "t_id", $leaguedropdown, $item);
dropdown("Published:", "published", array(0 => 'No', 1 => 'Yes'), $item);
item("Win Points:", "s_win_point", "",  $item);
item("Draw points:", "s_draw_point", "",  $item);
item("Loss Points:", "s_lost_point", "",  $item);
dropdown("Groups:", "s_groups", array(0 => 'No', 1 => 'Yes'), $item);
dropdown("Registration:", "s_reg", array(0 => 'No', 1 => 'Yes'), $item);
item("Reg Open:", "reg_start", "class='datepicker'",  $item);
item("Reg Close:", "reg_end", "class='datepicker'",  $item);
item("Stage Start:", "start", "class='datepicker'",  $item);
item("Stage End:", "end", "class='datepicker'",  $item);
textarea("Sponsor:", "s_rules", "class='editor'", $item);
echo form_submit("submit", "Submit");
?>
<? echo form_close();?>
