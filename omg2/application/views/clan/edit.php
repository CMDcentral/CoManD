<div id="navbar"><?=button("add-2", "Add Team", "plusthick", "/clan/addteam/".$clan->id.".html")?> <?=button("view", "View Clan", "search", 
"/clan/view/$clan->id.html");?> 
<?=button("view", "Back", "back", "/clan/view/$clan->id.html");?></div>
<div style="clear: both;"></div>
<img style="float: left" src="/thumb/gen/f2/uploads/image/<?=$clan->t_logo?>" />
<div style="float: left"><?=$clan->name?>
<div id="addteam"></div>
<br/><?=$clan->tag?>
</div>
<div style="clear: both;"></div>
<div id="tabs">
        <ul>
                <li><a href="#tabs-1">Clan Information</a></li>
                <li><a href="#tabs-2">Members</a></li>
                <li><a href="/clan/teams/<?=$clan->id?>.html">Teams</a></li>
        </ul>
        <div id="tabs-1">
<?=form_open_multipart("clan/save");?>
 <fieldset>
  <legend>Clan Information</legend>
   <input type="hidden" name="id" id="id" value="<?=$clan->id?>" />
<?
item("Tag:", "tag", 'size="5"', $clan);
item("Name:", "name", '', $clan);
upload("Logo:", "t_logo", 'size="50"', $clan);
item("URL Key: <sub>www.egamingsa.co.za/clan/</sub>", "url_key", 'size="5"', $clan);
item("URL:", "url", '', $clan);
echo "<p><label>Country:</label>".form_dropdown("country" , $countries, $clan->country)."</p>";
item("Location:", "location", 'size="50"', $clan);
textarea("Sponsors:", "sponsors", '', $clan);
textarea("About:", "about", "class='editor'", $clan);
item("Password:", "password", '', $clan);
item("Formed:", "formed", '', $clan);
$item = array('1' => "Yes", 0 => "No");
dropdown("Recruiting?:", "recruiting", $item, $clan);
$i = 1;
?>
 <div style="clear: both;"></div>
 <input type="submit" value="Update" />
 </fieldset>
</form>
	</div>
	<div id="tabs-2">
	<form action="/clan/role_save/<?=$clan->id?>.html" method="POST">
        <table width="100%" id="members" class="tablesorter" border="0" cellpadding="0" cellspacing="0">
        <thead><tr><th>Name</th><th>Role</th></tr></thead>
        <tbody>
        <? foreach ($members as $member) {
                $user = get_user($member->playerid);
                echo "<tr><td>";
		echo form_hidden('player['.$i.'][id]', $member->id);
		echo $user->firstname . " ( " . $user->alias . " ) " . $user->lastname."</td><td>".form_dropdown("player[".$i."][role]", roles(), $member->role)."</td>";
		$i++;
        }
        ?>
	</tbody>
	</table>
	<input type="submit" value="Save" />
	</form>
	</div>
</div>
 <script>
 $('#formed').datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true, numberOfYears: 40, showButtonPanel: true });
 $(function() {
                $( "#tabs" ).tabs( { cookie: 1, ajaxOptions: {
                                error: function( xhr, status, index, anchor ) {
                                        jQuery( anchor.hash ).html("Couldn't load this tab. We'll try to fix this as soon as possible.");
                                }
                        } });
 });

$(document).ready(function(){
var dialogOpts = {
      title: "Add Team", 
      modal: true,
      bgiframe: true,
      autoOpen: false,
      height: 500,
      width: 500,
      draggable: true,
      resizeable: true,
   };
$("#addteam").dialog(dialogOpts);   //end dialog   
   $('#add').click(
      function() {
         $("#addteam").load("/clan/addteam/<?=$clan->id?>", [], function(){
               $("#addteam").dialog("open");
            }
         );
         return false;
      }
   );
   
});

	$(function() {
		$( "#accordion" ).accordion();
	});

 </script>

