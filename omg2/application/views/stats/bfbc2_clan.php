<h1>eGSA Clan Server BFBC2 Player Stats</h1>
<div class="note">
<img src="/thumb/index/width/100/height/100?i=<?=$game->image?>" style="float:left;" alt="BFBC2 Logo" title="BFBC2" />
<p>
*[eGSA] eGaming South Africa Battlefield Live Stat Tracking.
</p>
<h5>Stats are collected at the end of each round. Why not try get yourself to the top of the list for possible rewards.</h5>
<div style="clear: both;"></div>
</div>

<?
$con = mysql_connect("web2.cmdcentral.co.za", "root", "ryvenapa121");
$db = mysql_select_db("bfbc2_clan");

$SQL = "SELECT p.ClanTag, p.SoldierName, s.playerScore, s.playerKills, s.playerHeadshots, s.playerDeaths, s.playerSuicide, s.playerTKs, s.playerRounds, 
	s.playerPlaytime, s.playerScore, s.Killstreak, s.Deathstreak, s.FirstSeenOnServer, s.LastSeenOnServer 
	FROM tbl_playerdata p, tbl_playerstats s WHERE p.PlayerID = s.StatsID AND p.CountryCode = 'za' ORDER BY s.playerScore DESC";

$result = mysql_query($SQL) or die(mysql_error());
?>

<table width="100%" class="tablesorter" id="players">
<thead>
<tr><th>#</th><th>Clan</th><th>Name</th><th>Kills</th><th>Deaths</th><th>HS</th><th>Suicides</th><th>Ratio</th><th>Teamkills</th><th>Rounds</th><th>Playtime</th><th>Score</th><th>KS</th><th>DS</th><th>Last 
seen</th></tr>
</thead>
<?
$i=1;
while ($row = mysql_fetch_assoc($result))
{
$arr[] = (object) $row;
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
	<td>".$row['playerRounds']."</td>
        <td>".sec2hms($row['playerPlaytime'], true)."</td>
        <td>".$row['playerScore']."</td>
        <td>".$row['Killstreak']."</td>
        <td>".$row['Deathstreak']."</td>
        <td>".$row['LastSeenOnServer']."</td>
	</tr>";
}
mysql_free_result($result);
mysql_close($con);
$stuff = json_encode($arr);

$con = mysql_connect("localhost", "root", "ryvenapa121") or die(mysql_error());
$db = mysql_select_db("egamings_joomla") or die(mysql_error());
$SQL = "INSERT INTO game_results VALUES (NULL, '$stuff', 0)";
$result = mysql_query($SQL);
?>
</table>
<script type="text/javascript">
        $(function() {
                $("#players").tablesorter({sortList:[[11,1]], widgets: ['zebra']});
        });
</script>

