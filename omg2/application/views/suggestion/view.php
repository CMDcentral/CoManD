<div id="navbar"><?=button("add", "Add Comment", "plusthick")?> <?=button("view", "Suggestions", "search", "/suggestion.html")?></div>
<h1><?=$suggestion->title?></h1>
<hr class="dotted" />
<?
if (user_id() == $suggestion->owner) {
echo form_open("suggestion/save");
}
echo form_hidden('id', $suggestion->id);
echo "<p><label for='title'>Title:</label>".form_input('title', $suggestion->title)." - could possibly be the feature name.</p>";
?>
<p><label>Status:</label><?=$suggestion->status?></p>
<p><label>Requested by:</label><?=get_user($suggestion->owner)->alias?></p>
<p><label>Information / Functionality: </label><textarea name="content" id="content22" rows="15" cols="40"><?=$suggestion->content;?></textarea></p>
<?
if (user_id() == $suggestion->owner) { ?>
<input type="submit" value="Save">
<?
echo form_close();
}
?>
</ul>

<?=comments($comments, $suggestion->id);?>
