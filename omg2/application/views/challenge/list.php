<div id="navbar">
<?=button("new", "New Challenge", "plusthick", "/challenge/create.html")?> <?=button("back", "Back", "back", ref())?></div>
<h1>Challenge Requests</h1>
<div id="tabs">
        <ul>
                <li><a href="#tabs-1">My Challenges</a></li>
                <li><a href="#tabs-2">Challenge Requests</a></li>
		<li><a href="#tabs-3">Historical Challenges</a></li>
        </ul>
        <div id="tabs-1">
<h3>My Challenges (<sub>Requests I have sent</sub>)</h3>
<table border="0" cellspacing="0" width="100%" id="clanlist" name="clanlist" class="tablesorter">
<thead>
<tr><th>Opposing Team</th><th>Your Team</th><th>Play Date</th><th>Time</th><th>Game</th><th>Mode</th><th>Maps</th><th>Requested By</th><th>Accepted</th></tr>
</thead>
<tbody>
<?
foreach ($challenges as $challenge)
{
?>
<tr style="cursor: pointer;" onclick="goto(<?=$challenge->id?>)">
<td><?=team($challenge->team2)->t_name?></td>
<td><b><?=team($challenge->team1)->t_name?></b></td>
<td><?=datef($challenge->playdate, false)?></td>
<td><?=$challenge->time?></td>
<td><?=$challenge->game?></td>
<td><?=$challenge->mode?></td>
<td><?=$challenge->maps?></td>
<td><?=get_user($challenge->owner)->alias?></td>
<td><?
if ($challenge->accepted == 0)
        echo '<span class="ui-icon ui-icon-close"></span>';
else
        echo '<span class="ui-icon ui-icon-check"></span>';
?></td>
</tr>
<?
}
if (sizeof($challenges) == 0)
        echo "<tr><td colspan='9'>No challenges found.</td></tr>";
?>
</tbody>
</table>
</div>
<div id="tabs-2">
<h3>Challenge requests to your team(s)</h3>
<table border="0" cellspacing="0" width="100%" id="challist" name="challist" class="tablesorter">
<thead>
<tr><th>Opposing Team</th><th>Your Team</th><th>Play Date</th><th>Time</th><th>Game</th><th>Mode</th><th>Maps</th><th>Requested By</th><th>Accepted</th><th>Actions</th></tr>
</thead>
<tbody>
<?
foreach ($challenge_requests[0] as $challenge)
{ ?>
<tr style="cursor: pointer;" onclick="goto(<?=$challenge->id?>)">
<td><?=team($challenge->team1)->t_name?></td>
<td><b><?=team($challenge->team2)->t_name?></b></td><td><?=datef($challenge->playdate, false)?></td><td><?=$challenge->time?></td><td><?=$challenge->game?></td><td><?=$challenge->mode?></td><td><?=$challenge->maps?></td>
<td><?=get_user($challenge->owner)->alias?></td>
<td><?
if ($challenge->accepted == 0)
        echo '<span class="ui-icon ui-icon-close"></span>';
elseif ($challenge->accepted == 1)
        echo '<span class="ui-icon ui-icon-check"></span>';
else
	echo '<span class="ui-icon ui-icon-cancel"></span>';
?></td>
<td>
<?
if ($challenge->accepted == 0) { ?>
<a href="/challenge/accept/<?=$challenge->id?>.html">Accept</a> | <a id="decline" alt="<?=$challenge->id?>" href="#">Decline</a>
<? } ?>
</td>
</tr>
<?
} //end if
if (sizeof($challenge_requests[0]) == 0)
                echo "<tr><td colspan='10'>No challenges found.</td></tr>";
?>
</tbody>
</table>
</div>
<div id="tabs-3">
<h3>Historical Challenges</h3>
<table border="0" cellspacing="0" width="100%" id="historylist" name="historylist" class="tablesorter">
<thead>
<tr><th>Opposing Team</th><th>Your Team</th><th>Play Date</th><th>Time</th><th>Game</th><th>Mode</th><th>Maps</th><th>Requested By</th><th>Accepted</th></tr>
</thead>
<tbody>
<?
foreach ($oldchallenges as $challenge)
{
?>
	<tr style="cursor: pointer;" onclick="goto(<?=$challenge->id?>)">
	 <td><?=team($challenge->team2)->t_name?></td>
	 <td><b><?=team($challenge->team1)->t_name?></b></td>
	 <td><?=datef($challenge->playdate, false)?></td>
	 <td><?=$challenge->time?></td>
	 <td><?=$challenge->game?></td>
	 <td><?=$challenge->mode?></td>
	 <td><?=$challenge->maps?></td>
	 <td><?=get_user($challenge->owner)->alias?></td>
	 <td><?
	 if ($challenge->accepted == 0)
	        echo '<span class="ui-icon ui-icon-close"></span>';
	 else
	        echo '<span class="ui-icon ui-icon-check"></span>';
	 ?></td>
	 </tr>
	 <?
	 }
	 if (sizeof($oldchallenges) == 0)
	        echo "<tr><td colspan='9'>No challenges found.</td></tr>";
	 ?>
	</tbody>
	</table>
</div>
</div>
<div id="dialog-modal" title="Enter reason" style="display: none;">
        <form method="POST" id="reason" action="">
        <p><label>Reason: </label><textarea name="notes"></textarea></p>
        <p><input type="submit" value="Submit" /></p>
        </form>
</div>
        <script>
        $( "#dialog-modal" ).dialog({
                        autoOpen: false,
                        show: "blind",
                        modal: true,
                        hide: "explode"
                });

                $( "#decline" ).click(function() {
			id = $(this).attr("alt");
			action = '/challenge/decline/'+id+'.html';
			$("#reason").attr("action", action)
                        $( "#dialog-modal").dialog( "open" );
                        return false;
                });

        $(function() {
                $("#clanlist").tablesorter({sortList:[[0,1]], widgets: ['zebra']});
                $("#challist").tablesorter({sortList:[[0,1]], widgets: ['zebra']});
		$("#historylist").tablesorter({sortList:[[0,1]], widgets: ['zebra']});
        });

        function goto(id) {
         location.href = '/challenge/view/'+id+'.html';
        }

        </script>

