<h1>eGSA Teeworld Server Stats</h1>
<div class="note">
<img src="/thumb/index/width/100/height/100?i=<?=$game->image?>" style="float:left;" alt="TW Logo" title="Teeworlds" />
All stats are recorded accross all of our Teeworld servers, see if you can get yourself to the top to reward yourself with some prizes.
<p><b>PS. Game alias needs to match site alias.</b></p>
<div style="clear: both;"></div>
</div>

<?
$con = mysql_pconnect("host.istreet.co.za", "tw", "egsateeworlds");
$db = mysql_select_db("teeworlds");

$SQL = "SELECT
    t1.killer AS name,
    COUNT(t1.killer) AS kills,
    (SELECT COUNT(t2.victim) FROM teeworlds.tw_kill t2 WHERE t2.victim LIKE t1.killer && t2.weapon != -3) AS death,
    (SELECT COUNT(t3.killer) FROM teeworlds.tw_kill t3 WHERE t3.killer LIKE t1.killer && t3.killer LIKE t3.victim && t3.weapon != -3) AS suicide,
    ROUND(IF((COUNT(t1.killer)/(SELECT COUNT(t4.victim) FROM teeworlds.tw_kill t4 WHERE t4.victim LIKE t1.killer && t4.weapon != -3) IS NULL),
        COUNT(t1.killer),
        COUNT(t1.killer)/(SELECT COUNT(t4.victim) FROM teeworlds.tw_kill t4 WHERE t4.victim LIKE t1.killer && t4.weapon != -3)),3)
    AS ratio,
    (SELECT t5.weapon FROM teeworlds.tw_kill t5 WHERE t5.killer LIKE t1.killer && weapon != -3 && weapon != -1 GROUP BY t5.weapon ORDER BY COUNT(t5.weapon) DESC, t5.date DESC LIMIT 1) AS 
fav_weapon,
    (SELECT date FROM teeworlds.tw_kill t7 WHERE t1.killer IN (t7.killer, t7.victim) ORDER BY date DESC LIMIT 1) AS last_seen
FROM
    teeworlds.tw_kill t1
WHERE
    t1.killer NOT LIKE '%nameless tee%' AND
    t1.weapon != -3 AND
    t1.weapon != -1
GROUP BY 1
HAVING
    kills >= 10 AND
    DATEDIFF(CURRENT_TIMESTAMP, last_seen) <= 14
ORDER BY 2 DESC, 5 DESC";

$result = mysql_query($SQL);
?>

<table width="100%" class="tablesorter" id="players">
<thead>
<tr><th>#</th><th>Name</th><th>Kills</th><th>Deaths</th><th>Suicides</th><th>Ratio</th><th>Favorite Weapon</th><th>Last Seen</th></tr>
</thead>
<?
$i=1;
while ($row = mysql_fetch_assoc($result))
{
echo "<tr>
	<td>".$i++."</td>
	<td>".$row['name']."</td>
      <td>".$row['kills']."</td>
      <td>".$row['death']."</td>
	<td>".$row['suicide']."</td>
	<td>".$row['ratio']."</td>
	<td>".$row['fav_weapon']."</td>
	<td>".$row['last_seen']."</td></tr>";
?>
<?
}
?>
</table>
<script type="text/javascript">
        $(function() {
                $("#players").tablesorter({sortList:[[2,1]], widgets: ['zebra']});
        });
</script>

