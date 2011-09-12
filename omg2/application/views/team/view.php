<div id="navbar"><?
if (clanadmin($clan->id))
        echo button("edit", "Edit Team", "pencil", "/team/edit/".$teams->id.".html"). " ";

echo button("view", "View Clan", "search", "/clan/view/".$clan->id.".html")?> <?=button("back", "Back", "back", $_SERVER['HTTP_REFERER'])?></div>
<div style="clear: both;"></div>
<h1 class="title"><?=$clan->tag . " " . $teams->t_name?></h1>
<div class="note">
<img style="float: right;" src="<?=cropper($teams->def_img, "/uploads/", 120,100);?>" />
<sub>clan </sub><?=$clan->name?><br/>
<sub>created </sub><?=nicetime($teams->added)?><br/>
<sub>Game </sub><?=$teams->game?>
<div style="clear: both;"></div>
</div>
<hr class="dotted" />
<div id="accordion">
                <h3><a href="#"><?=$teams->t_name?></a> </h3>
                <div>
                <div class="note">
                <sub>Description:</sub>
                <?=$teams->t_descr;?>
                </div>
       <table width="100%" id="members" class="tablesorter" border="0" cellpadding="0" cellspacing="0">
        <thead><tr><th>Alias</th><th>Name</th><th>Location</th><th>Age</th><th>Role</th></tr></thead>
        <tbody>
        <? foreach ($teams->members as $member) {
                $user = get_user($member->player_id);
                echo '<tr style="cursor: pointer;" onClick="goto('.$user->id.')"><td>';
                echo "<a href='/player/view/".$user->id.".html'>".$clan->tag. " " .$user->alias."</a></td><td>".$user->firstname . " ".$user->lastname."</td><td>".$user->cb_city."</td><td>";
                echo age_from_dob($user->dob)."</td><td>".get_role($member->role)."</td></tr>";
        }
        ?>
        </tbody>
        </table>

                </div>
		<h3><a href="#">Leagues</a></h3>
		<div>
			<h4>Active Leagues</h4>
			<? foreach ($leagues as $league) {
			 echo "<a href='/league/view/".$league['league']['info']->t_alias.".html'>".$league['league']['info']->name."</a><br/>";
			}
			if (sizeof($leagues) == 0)
			 echo "Currently not participating in any active leagues";
			?>
		</div>
</div>
<script type="text/javascript">
        $(function() {
                $( "#accordion" ).accordion();
        });

        $(function() {
                $("#members").tablesorter({sortList:[[4,0]], widgets: ['zebra']});        });


</script>
