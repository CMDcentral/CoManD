<div id="toolbar">
<?
if (admin())
                 echo anchor("member/edit/".$member->id, "edit")
?>
</div>
<img class="ds" style="float: right;" src="/thumb/gen/width/300/height/250/folder/uploads/image/<?=$member->image; ?>" title="<?=$member->name?>" />
<h1><?=$member->name?></h1>
<h2><?=$member->position?></h2>
<h3><sub><? //$date = date("d M Y" , strtotime($member->dob))?></sub></h3>
<div id="information">
<?=$member->name . " " . $member->information;?>
</div>
