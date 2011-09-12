<div id="navbar"><?=button("view", "View Clan", "search","/clan/view/$clan->id.html");?> <?=button("view", "Back", "back", "/clan/view/$clan->id.html");?></div>
<h1>Create Team</h1>
<hr class="dotted" />
<?
if (isset($action)) {
if ($action == "edit")
	echo "<h3>Edit Team</h3>";
else
	echo "<h3>Add Team</h3>";
}
$i=1;
?>
<form action="/clan/saveteam/<?=$clan->id?>.html" method="POST">
<!--<input type="hidden" name="team_id" value="<?=$team->team_id?>" /> -->
<p><label>Name: </label><input type="text" name="t_name" /></p>
<p><label>Description: </label><input type="text" name="t_descr" /></p>
<p><label>City: </label><input type="text" name="t_city" /></p>
<? echo "<p><label>Game:</label>".form_dropdown("t_game", $games, "")."</p>";
?>
<fieldset>
 <legend>Members</legend>
 <table width="100%">
 <thead><tr><th></th><th>Alias</th><th>Name</th><th>Role</th></tr></thead>
 <tbody>
<?
foreach ($members as $member)
{
	$user = get_user($member->playerid);
	echo "<tr>
	      <td><input type='checkbox' name='player[".$i."][player_id]' value='".$user->id."' /></td>
	      <td>".$user->alias."</td>
	      <td>".$user->firstname." " .$user->lastname."</td>
	      <td>".form_dropdown("player[".$i."][role]", roles(), 1)."</td>
	      </tr>";
$i++;
}
?>
 </tbody>
</table>
</fieldset>
<input type="submit" value="Save" />
</form>
