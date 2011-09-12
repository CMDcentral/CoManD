<h1>eGSA Public Server BFBC2 Player Stats</h1>
<div class="note">
<img src="/thumb/index/width/100/height/100?i=<?=$game->image?>" style="float:left;" alt="BFBC2 Logo" title="BFBC2" />
<p>
*[eGSA] eGaming South Africa Battlefield Live Stat Tracking.
</p>
<h5>Stats are collected at the end of each round. Why not try get yourself to the top of the list for possible rewards.</h5>
<div style="clear: both;"></div>
</div>

<?
$con = mysql_pconnect("web2.cmdcentral.co.za", "root", "ryvenapa121");
$db = mysql_select_db("bfbc2");

$SQL = "SELECT p.ClanTag, p.SoldierName, s.playerScore, s.playerKills, s.playerHeadshots, s.playerDeaths, s.playerSuicide, s.playerTKs, s.playerRounds, 
s.playerPlaytime, s.playerScore, s.Killstreak, s.Deathstreak
	FROM tbl_playerdata p, tbl_playerstats s WHERE p.PlayerID = s.StatsID AND p.CountryCode = 'za' ORDER BY s.playerScore DESC";

$result = mysql_query($SQL) or die(mysql_error());
?>
<div id="tabs">
        <ul>
                <li><a href="#tabs-1">Player Stats</a></li>
		<li><a href="/gamestats/clan_stats.html">Clan Stats</a></li>
                <li><a href="/gamestats/dogtags.html">Dogtags</a></li>
        </ul>
        <div id="tabs-1">
<div id="pager" class="pager">
        <form>
                <img src="/images/first.png" class="first"/>
                <img src="/images/prev.png" class="prev"/>
                <input type="text" class="pagedisplay"/>
                <img src="/images/next.png" class="next"/>
                <img src="/images/last.png" class="last"/>
                <select class="pagesize">
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                </select>
        </form>
</div>

<table width="100%" class="tablesorter" id="players">
<thead>
<tr><th>#</th><th>Clan</th><th>Name</th><th>Kills</th><th>Deaths</th><th>Headshots</th><th>Suicides</th><th>Ratio</th><th>Teamkills</th><th>Rounds</th><th>Score</th><th>Killstreak</th><th>Deathstreak</th></tr>
</thead>
<?
$i=1;
while ($row = mysql_fetch_assoc($result))
{
$user = get_user($row['SoldierName']);

if ($user)
	$extra = "<a href='/player/view/".$user->id.".html'>".$row['SoldierName']."</a>";
else
	$extra = "".$row['SoldierName']."";

echo "<tr>
	<td>".$i++."</td>
	<td>".$row['ClanTag']."</td>
        <td>".$extra."</td>
      <td>".$row['playerKills']."</td>
	<td>".$row['playerDeaths']."</td>
        <td>".$row['playerHeadshots']."</td>
        <td>".$row['playerSuicide']."</td>
	<td>".round($row['playerKills'] / $row['playerDeaths'],2)."</td>
	<td>".$row['playerTKs']."</td>
	<td>".$row['playerRounds']."</td>
        <td>".$row['playerScore']."</td>
        <td>".$row['Killstreak']."</td>
        <td>".$row['Deathstreak']."</td>
	</tr>";
?>
<?
}
?>
</table>
</div>
</div>
<script type="text/javascript">
        $(function() {
                $("#players").tablesorter({sortList:[[10,1]], widgets: ['zebra']})
		.tablesorterPager({container: $("#pager")});
        });
</script>

