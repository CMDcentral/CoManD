<?
$legal_teams = array();
$legal_game = $league['info']->gameid;
foreach ($teams as $team) {
	if ($team->gameid == $legal_game && $team->role >= 4) {
		$legal_teams[$team->id] = $team->t_name;
		}
}
?>
<h1 class="title">Select Team</h1>
<?
if (sizeof($legal_teams) > 0) {
echo form_open("stage/join_stage", 'id="stageJoin"');
echo form_hidden("season_id", $stage->s_id);
echo dropdown("Valid teams:", "team_id", $legal_teams, "");
echo form_submit("submit", "Enter");
echo form_close();
}
else {
echo "<div id='info'>You manage no teams that are valid for this tournament</div>";
}


?>
