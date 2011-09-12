<div id="navbar"><?=button("view", "View Team", "search", "/team/view/".$team->id.".html"). " " .button("edit", "Edit Clan", "pencil", "/clan/edit/".$team->clan.".html"). " " . 
button("delete", "Delete Team", "minusthick", "/team/delete/".$team->id.".html", "confirmClick")?></div>
<form enctype="multipart/form-data" action="/team/saveteam.html" method="POST">
<input type="hidden" value="<?=$team->id?>" name="id" />
<?
item("Name:", "t_name", "", $team);
item("Description:", "t_descr",	"", $team);
item("City:", "t_city", "", $team);
upload("Logo:", "def_img", '', $team);
echo "<p><label>Game:</label>".form_dropdown("t_game", $games, $team->gameid)."</p>";
?>
<fieldset>
 <legend>Members</legend>
 <table width="100%">
 <thead><tr><th></th><th>Alias</th><th>Name</th><th>Role</th></tr></thead>
 <tbody>
<?
$i=1;
$arr = array();
foreach ($team->members as $mem) {
	$arr[$mem->player_id] = $mem;
}
foreach ($members as $member)
{
        $user = get_user($member->playerid);
	if (isset($arr[$user->id])) {
		$dropdown = '<a class="tooltip" title="Remove Player" href="/team/delete_member/'.$arr[$user->id]->id.'.html"><span class="ui-icon ui-icon-closethick"></span></a>';
		$dropdown .= "<input type='hidden' name='player[".$i."][id]' value='".$arr[$user->id]->id."' />";
		$role = $arr[$user->id]->role;
	}
	else {
		$dropdown = "<input type='checkbox' name='player[".$i."][player_id]' value='".$user->id."' />";
		$role = "";
	}
        echo "<tr><td>".$dropdown."</td><td>".$user->alias."</td><td>".$user->firstname." " .$user->lastname."</td>";
        echo "<td>".form_dropdown("player[".$i."][role]", roles(), $role)."</td></tr>";
$i++;
}
?>
 </tbody>
</table>
</fieldset>
<input type="submit" value="save" />
</form>
