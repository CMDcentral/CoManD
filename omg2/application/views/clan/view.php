<?
$edit = "";
if ($clan->recruiting == 1)
	echo button("r2j", "Request To Join", "plusthick", "/clan/request/".$clan->id.".html", "popup"). " ";
if (lin()) {
        if ($inclan)
                $join = button("leave", "Leave Clan", "minusthick", "/clan/leave/".$clan->id.".html", "confirmClick");
        else
                $join = button("add", "Join Clan", "plusthick", "#");
 if (clanadmin($clan->id))
        $edit=  button("edit", "Edit Clan", "pencil", "/clan/edit/".$clan->id);
}
else {
 $join = "";
 $edit = "";
}
?>
<div id="navbar"><?=$edit?> <?=$join?> <?=button("view", "Back", "triange-1-w", ref());?></div>
<div id="dialog-modal" title="Enter password to join clan" style="display: none;">
	<form method="POST" action="/clan/join/<?=$clan->id?>.html">
        <p><label>Password: </label><input type="text" name="password" /></p>
	<p><input type="submit" value="Join" /></p>
	</form>
</div>
<h1 class="title"><?=$clan->tag?> <?=$clan->name?></h1>
<hr class="dotted" />
<div class="note">
<img style="float: left;" src="/thumb/index/width/150/height/150?i=/uploads/<?=$clan->t_logo?>" />
<ol>
    <li>Website: <a href="<?=$clan->url?>" target="_blank"><?=$clan->name?></a></li>
    <li>Location: <?=$clan->location?></li>
    <li>Joined: <?=datef($clan->created)?></li>
    <li>Established: <?=datef($clan->formed, false)?></li>
    <li>Owner: <?=get_user($clan->owner)->alias?></li>
    <li>Members: <?=$clan->member_count?></li>
    <li>Teams: <?=$clan->team_count?></li>
    <li>Country: <?=$countries[$clan->country]?></li>
</ol>

<div style="clear: both;"></div>
</div>

<div id="tabs">
	<ul>
		<li><a href="#tabs-1">About</a></li>
		<li><a href="#tabs-2">Sponsors</a></li>
		<li><a href="#tabs-3">Members</a></li>
		<li><a href="/clan/teams/<?=$clan->id?>.html">Teams</a></li>
		<?  if (inclan()) { ?><li><a href="/clan/challenge/<?=$clan->id?>.html">Challenge</a></li><? }; ?>
	</ul>
	<div id="tabs-1">
<fieldset>
<legend>About</legend>
<span class="note"><?=$clan->about?></span>
</fieldset>
	</div>
	<div id="tabs-2">
<fieldset>
<legend>Sponsors</legend>
<span class="note"><?=$clan->sponsors?></span>
</fieldset>
	</div>
	<div id="tabs-3">
	<table width="100%" id="members" class="tablesorter" border="0" cellpadding="0" cellspacing="0">
	<thead><tr><th>Alias</th><th>Name</th><th>Location</th><th>Age</th><th>Role</th></tr></thead>
	<tbody>
	<? foreach ($members as $member) {
		$user =  get_user($member->playerid);
		echo '<tr style="cursor: pointer;" onClick="goto('.$user->id.')"><td>';
		echo "<a href='/player/view/".$user->id.".html'>".$clan->tag . " " .$user->alias."</a></td><td>".$user->firstname . " 
		".$user->lastname."</td><td>".$user->cb_city."</td><td>".age_from_dob($user->dob)."</th><td>".get_role($member->role)."</td>";
	}
	?>
	</tbody>
	</table>
	</div>
	</div>

	<script>
	$( "#dialog-modal" ).dialog({
			autoOpen: false,
			show: "blind",
			modal: true,
			hide: "explode"
		});

		$( "#add" ).click(function() {
			$( "#dialog-modal").dialog( "open" );
			return false;
		});

        $(function() {
                $("#members").tablesorter({sortList:[[1,0]], widgets: ['zebra']});
        });

	function goto(id) {
	 location.href = "/player/view/"+id+".html";
	}

	</script>
