<?
foreach ($members as $member)
{
?>
<div id="member" style="width: 300px; float: left; text-align: center; padding: 5px;">
<a href="member/view/<?=$member->id?>" >
<img class="ds" src="/thumb/gen/width/250/height/180/folder/uploads/image/<?if ($member->image !="") { echo $member->image; } else { echo "none.jpg"; } ; ?>" 
title="<?=$member->name?>" />
<br/>
<?=anchor("member/view/".$member->id, $member->name);?>
<br/>
<b><?=$member->position?></b>
</a>
</div>
<?
}
?>
