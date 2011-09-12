<h3>Challenge</h3>
<?
if (sizeof($teams) > 0) { ?>
<form action="/challenge/request.html" method="POST" id="challenge">
<table width="100%">
<thead><tr><th>My Clan/Team</th><th>Challenge Clan/Team</th></tr></thead>
<tr>
<td>
<?

$arr = array();
$arr2 = array();
$arr3 = array();
$arr7 = array();

foreach ($myclan as $clan) {
	 $arr2[$clan->cid] = $clan->name;
}

foreach ($myteams as $team) {
	$arr3[$team->id] = $arr2[$team->clan].  " " . $team->t_name;
}

echo "<p><label>My Team</label>".form_dropdown("team1", $arr3,"", 'id="myteam"'). "</p>";
foreach ($teams as $team)
        $arr7[$team->id] = $team->t_name;

$now = date("Y-m-d");
$arr = array('playdate'=>$now, 'time'=>"", 'game'=>"", 'maps'=>"", 'notes'=>"", 'mode' => "");
item("Game:", "game", "", $arr);
item("Mode:", "mode", "", $arr);
textarea("Maps: <sub>(1 per line)</sub>", "maps", "", $arr);

?>
</td>
<td>
<?

echo  "<p><label>Opposition Team</label>".form_dropdown("team2", $arr7,"","id='oppteam'"). "</p>";
item("Date:", "playdate", "class='datepicker'", $arr);
item("Time:", "time", "", $arr);
?>
</td>
</tr>
</table>
<input type="submit" value="Challenge!" />
</form>
<? }  else { ?>
<h4>No teams to challenge.</h4>
<? } ?>
<script>

$.ajaxSetup({
   jsonp: null,
   jsonpCallback: null
});

$(function() {
                var availableTags = [
                        "Battlefield Bad Company 2",
                        "Battlefield 3",
                        "Warcraft",
                        "Call Of Duty 4",
                        "Call Of Duty 5"
                ];
                $( "#game" ).autocomplete({
                        source: availableTags
                });
});
</script>
