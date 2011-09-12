<?
if (sizeof($teams) == 0) { ?>
<h4>No teams found.</h4>
<? } ?>
       <div id="accordion">
         <? foreach ($teams as $team) { 
if (clanadmin($clan->id))
        $edit = "<a style='float: right;' href='/team/edit/$team->id.html'>Edit</a>";
else
    	$edit = "";
?>
                <h3><a href="#"><?=$team->t_name?> (<?=$team->abbv?>)</a></h3>
                <div>
		<?=$edit?>
		<?=button("view", "View Team", "search", "/team/view/".$team->id);?>
                <div class="note">
                <sub>Description:</sub>
                <?=$team->t_descr;?><br/>
                <sub>Game:</sub>
                <?=$team->game;?>
                </div>
       <table width="100%" id="members" class="tablesorter" border="0" cellpadding="0" cellspacing="0">
        <thead><tr><th>Alias</th><th>Name</th><th>Location</th><th>Age</th><th>Role</th></tr></thead>
        <tbody>
        <? foreach ($team->members as $member) {
                $user = get_user($member->player_id);
                echo '<tr style="cursor: pointer;" onClick="goto('.$user->id.')"><td>';
                echo "<a href='/player/view/".$user->id.".html'>".$clan->tag. " " .$user->alias."</a></td><td>".$user->firstname . " ".$user->lastname."</td><td>".$user->cb_city."</td><td>";
                echo age_from_dob($user->dob)."</td><td>".get_role($member->role)."</td></tr>";
        }
        ?>
        </tbody>
        </table>
                </div>
        <? } ?>
        </div>
<script type="text/javascript">
        $(function() {
                $( "#accordion" ).accordion();
        });
        $(function() {
                $("#members").tablesorter({sortList:[[0,1]], widgets: ['zebra']});
        });

</script>
