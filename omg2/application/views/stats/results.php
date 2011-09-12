<?

$con = mysql_pconnect("web2.cmdcentral.co.za", "root", "ryvenapa121");
$db = mysql_select_db("bfbc2");

$result = mysql_query("SELECT
                      a.ClanTag,
                      SUM(b.playerScore)
                    FROM tbl_playerdata a
                     INNER JOIN tbl_playerstats b ON b.StatsID = a.PlayerID
                    WHERE
                     a.ClanTag != ''
                    AND
                     b.playerScore >= 100
                    GROUP BY
                     a.ClanTag");
$num_rows = mysql_num_rows($result);

?>
<table width="100%" class="tablesorter" id="clans">
<thead>
<tr><th>#</th><th>Players</th><th>Clan</th><th>Time</th><th>Rounds</th><th>Kills</th><th>Deaths</th><th>K/D</th><th>Headshots</th><th>Points</th></tr>
</thead>
<?
$i=1;

                 $query = "SELECT
                             d.ClanTag,
                             SUM(s.playerScore) AS playerScore,
                             SUM(s.playerKills) AS playerKills,
                             SUM(s.playerDeaths) AS playerDeaths,
                             SUM(s.playerHeadshots) AS playerHeadshots,
                             SUM(s.playerRounds) AS playerRounds,
                             SUM(s.playerPlaytime) AS playerPlaytime
                           FROM tbl_playerstats s
                 INNER JOIN tbl_playerdata d ON d.PlayerID = s.StatsID
               WHERE
                 d.ClanTag != ''
               AND
                 s.playerScore >= 100
               GROUP BY
                 d.ClanTag
               ORDER BY
                 playerScore DESC";

        $result = mysql_query($query);
        $num_rows = mysql_num_rows($result);


while ($row = mysql_fetch_assoc($result))
{

$user = get_user($row['SoldierName']);

if ($user)
        $extra = "<a href='/player/view/".$user->id.".html'>".$row['SoldierName']."</a>";
else
        $extra = "".$row['SoldierName']."";
                $pClantag = mysql_escape_string($row['ClanTag']);
                $pSql = "
                 SELECT a.PlayerID, a.ClanTag, count(a.PlayerID) AS pPlayers FROM tbl_playerdata a
        WHERE a.ClanTag = '{$pClantag}'
        GROUP BY a.ClanTag";
        $pResult = mysql_query($pSql);
        $players = mysql_fetch_assoc($pResult);

        $time = sprintf("%02dh",$row['playerPlaytime']/60/60);

        if ($row['playerDeaths'] == 0){
                        $KD = '0';
                }else{
                  $KD = ($row['playerKills']/$row['playerDeaths']);
              }

               if ($KD > 1){
             $KD = "<span class='positiv'>" . number_format($KD, 2, '.', '.') . "</span>";
            }else{
             $KD = "<span class='negativ'>" . number_format($KD, 2, '.', '.') . "</span>";
         }

?>
        <tr class="hov">
                <td class="result" style="text-align:left;">&nbsp;<?php echo $i++; ?></td>
                 <td class="result" style="text-align:center;"><?php echo  number_format($players['pPlayers'], 0, ',', ' '); ?></td>
                  <td class="result" style="text-align:center;"><?php echo htmlspecialchars ($row['ClanTag']); ?></td>
                   <td class="result" style="text-align:center;"><?php echo $time; ?></td>
                    <td class="result" style="text-align:center;"><?php echo  number_format($row['playerRounds'], 0, ',', ' '); ?></td>
                     <td class="result" style="text-align:center;"><?php echo  number_format($row['playerKills'], 0, ',', ' '); ?></td>
                    <td class="result" style="text-align:center;"><?php echo  number_format($row['playerDeaths'], 0, ',', ' '); ?></td>
                   <td class="result" style="text-align:center;"><?php echo $KD; ?></td>
                  <td class="result" style="text-align:center;"><?php echo  number_format($row['playerHeadshots'], 0, ',', ' '); ?></td>
                 <td class="result" style="text-align:center;"><?php echo  $row['playerScore']; ?></td>
        </tr>

<?
}
?>
</table>

<script type="text/javascript">
        $(function() {
                $("#clans").tablesorter({sortList:[[9,1]], widgets: ['zebra']});
        });
</script>

