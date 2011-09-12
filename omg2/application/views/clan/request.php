<h4><?=$clan->tag. " " . $clan->name ?></h4>
<hr class="dotted" />
<form action="/email/request.html" style="width: 350px" method="POST">
<fieldset>
 <legend>Clan Request Application</legend>
<input type="hidden" name="clan" value="<?=$clan->id?>" />
<p><label for="name">Name:</label><input type="text" name="name" value="<?=$user->firstname . " " . $user->lastname?>" /></p>
<p><label>Game:</label><?=form_dropdown("game", $games)?></p>
<p><label>Alias:</label><input type="text" name="alias" value="<?=$user->alias ?>" /></p>
<p><label>Reason</label><textarea cols="15" rows="5" name="reason"></textarea></p>
<p><input type="submit" name="submit" value="Request To Join" /></p>
</fieldset>
</form>
