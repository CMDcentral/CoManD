<h1>eGSA Match Stats</h1>
<div class="note">
<img src="/thumb/index/width/100/height/100?i=<?=$game->image?>" style="float:left;" alt="BFBC2 Logo" title="BFBC2" />
<p>
*[eGSA] eGaming South Africa Battlefield Live Stat Tracking.
</p>
<h5>Stats are collected at the end of each round.</h5>
HS: Headshots
KS: Killstreak
DS: Deathstreak
<div style="clear: both;"></div>
</div>

<table width="100%" class="tablesorter" id="players">
<thead>
<tr><th>#</th><th>Clan</th><th>Name</th><th>Kills</th><th>Deaths</th><th>HS</th><th>Suicides</th><th>Ratio</th><th>Teamkills</th><th>Score</th><th>KS</th><th>DS</th><th>Last 
seen</th></tr>
</thead>
<?
$i=1;
$players = json_decode($info->stats);
foreach ($players as $row)
{
$row = (array) $row;
echo "<tr>
	<td>".$i++."</td>
	<td>".$row['ClanTag']."</td>
        <td>".$row['SoldierName']."</td>
        <td>".$row['playerKills']."</td>
	<td>".$row['playerDeaths']."</td>
        <td>".$row['playerHeadshots']."</td>
        <td>".$row['playerSuicide']."</td>
	<td>".round($row['playerKills'] / $row['playerDeaths'],2)."</td>
	<td>".$row['playerTKs']."</td>
        <td>".$row['playerScore']."</td>
        <td>".$row['Killstreak']."</td>
        <td>".$row['Deathstreak']."</td>
        <td>".$row['LastSeenOnServer']."</td>
	</tr>";
}
?>
</table>
<script type="text/javascript">
        $(function() {
                $("#players").tablesorter({sortList:[[9,1]], widgets: ['zebra']});
        });
</script>

