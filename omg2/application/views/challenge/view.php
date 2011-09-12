<div id="navbar"><?=button("add", "Add Comment", "plusthick"). " " .button("back", "Back", "back", ref())?></div>
<h3>Challenge Request</h3>
<hr class="dotted" />
<fieldset>
 <legend>Challenge Information</legend>

 <fieldset>
	<legend>Teams</legend>
 <p><label>Team 1:</label><?=clan(team($challenge->team1)->clan)->name. " - " .team($challenge->team1)->t_name?></p>
 <p><label>Team 2:</label><?=clan(team($challenge->team2)->clan)->name. " - " .team($challenge->team2)->t_name?></p>
 </fieldset>
 <p><label>Game:</label><?=$challenge->game?></p>
 <p><label>Mode:</label><?=$challenge->mode?></p>
 <p><label>Maps:</label><?=$challenge->maps?></p>
 <p><label>Date:</label><?=datef($challenge->playdate, false)?></p>
 <p><label>Time:</label><?=$challenge->time?></p>
 <p><label>Notes:</label><?=$challenge->notes?></p><br/>
 <p><label>Requested By:</label><?=get_user($challenge->owner)->alias?></p>
 <p><label>Status:</label>
<?
if ($challenge->accepted == 2)
	echo "Declined";
elseif ($challenge->accepted == 1)
	echo "Accepted";
else
	echo "Pending";
?>
</p>
</fieldset>
<div id="dialog-modal" title="Enter Comment" style="display: none;">
        <form method="POST" id="reason" action="/challenge/comment.html">
	<input type="hidden" name="controller" value="<?=$this->router->class?>" />
        <input type="hidden" name="oid" value="<?=$challenge->id?>" />
        <p><label>Comment: </label><textarea name="comment"></textarea></p>
        <p><input type="submit" value="Submit" /></p>
        </form>
</div>

<div id="contentbottom">
	<div class="horizontal float-left width100" style="width: 380px;"><div class="module mod-box mod-box-templatecolor  first last">
	<div class="box-t1">
		<div class="box-t2">
			<div class="box-t3"></div>
		</div>
	</div>
	<div class="box-1">
		<div class="box-2 deepest" style="min-height: 80px;">
<h3 class="header"><span class="header-2"><span class="header-3"><span class="color">Challenge</span> Comments</span></span></h3>
 <table width="100%" class="hovertable">
<?
foreach ($comments as $comment) {
        $time = nicetime($comment->date_time);
        $img = "<img src='/thumb/profile_gen/width/75/height/75/player/".$comment->user_id."' />";
        $user = get_user($comment->user_id);
        echo "<tr class='even'><td width='50px'><a href='/player/view/".$user->alias.".html'>".$img."<br/>".$user->alias."</a><br/><sub>".$time."</sub></td>";
        echo "<td>".$comment->comment."</td></tr>";
} ?>


 </table>


		</div>
	</div>

	<div class="box-b1">
		<div class="box-b2">
			<div class="box-b3"></div>
		</div>
	</div>
		
</div></div>													</div>


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
                $("#clanlist").tablesorter({sortList:[[0,1]], widgets: ['zebra']});
                $("#challist").tablesorter({sortList:[[0,1]], widgets: ['zebra']});
        });

        function goto(id) {
         location.href = '/challenge/view/'+id+'.html';
        }

        </script>

