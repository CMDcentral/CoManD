<?
$user = get_user(user_id());
?>
<div id="navbar"><?=button("back", "Back", "back", ref()). " " .button("view", "View Profile", "search", "/player/view/".urlencode($user->id).".html");?></div>
<h1>Edit Profile</h1>
<form id="statusForm" onSubmit="$('#set').click(); return false;">
<p><input name="tags" id="tags" placeholder="What's on your mind?" size="60" value="<?=$user->cb_status?>" />
<input type="button" name="set" id="set" value="Set" /><input type="button" name="set" id="clear" value="Clear" /> <div id="status"></div></p>
</form>
<div id="tabs">
	<ul>
<?
foreach ($tabs as $tab) 
{
?>
 <li><a href="/player/information/<?=$tab->tabid?>.html"><?=$tab->title?></a></li>
<?
}
?>
		<li><a href="#tabs-1">Portrait</a></li>
                <li><a href="#tabs-2">Password</a></li>
<!--                <li><a href="/player/gallery.html">Albums</a></li> -->
                <li><a href="#tabs-3">Activity</a></li>
	</ul>
	<div id="tabs-1">
	<h3>Upload Image</h3>
	<img src="/thumb/profile_gen/width/300/height/300/player/<?=user_id()?>" />
	 <form name="newad" method="post" enctype="multipart/form-data"  action="/player/do_upload.html">
	 <table>
 	<tr><td><input type="file" name="avatar"></td></tr>
 	<tr><td><input name="Submit" type="submit" value="Upload image"></td></tr>
	 </table>	
	 </form>
	</div>
	<div id="tabs-2">
<form action="/player/save.html" method="POST" id="chpass">
 <fieldset>
  <legend>Change Password</legend>
   <input type="hidden" name="id" id="id" value="<?=user_id()?>" />
   <p>
     <label for="password">Password <em>*</em></label>
     <input id="password" name="password" type="password" size="25" minlength="2" />
   </p>
   <p>
     <label for="password2">Confirm Password <em>*</em></label>
     <input id="password2" type="password" name="password2" size="25" minlength="2" />
   </p>
                        <div class="clear"></div>
                        <br />
     <input style="margin: -20px 0 0 287px;" class="button" type="submit" value="Change Password"/>
 </fieldset>	
</form>
        </div>
	<div id="tabs-3">
	<?=activity($activity)?>
	<div class="note" style="cursor: pointer;" onClick="lastPostFunc()" id="loadMore"><center>Click here to load older posts.</center></div>
	<script>
	function lastPostFunc()
	{
	    $("div#lastPostsLoader").html('<center><img src="/images/loader.gif"/></center>');
	    $.post("/activity/get.html?u=<?=user_id()?>&lastID=" + $(".act:last").attr("id"),
	    function(data){
	        if (data != "") {
	        $(".act:last").after(data);
	        }
	        $("div#lastPostsLoader").empty();
	    });
	};
	</script>

	</div>
</div>
<script>
                $('#set').click(function() {
                  terms = $("#statusForm").serialize();
                  $("#status").load("/player/status.html?"+terms);
                });
                $("#clear").click(function() {
                  $("#tags").val("");
                  $("#status").load("/player/status.html?tags=");
                });
</script>
