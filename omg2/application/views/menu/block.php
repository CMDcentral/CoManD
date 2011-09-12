<div class="module mod-box mod-box-grey mod-menu mod-menu-box mod-box-header">
                <h3 class="header"><span class="header-2"><span class="header-3">Games</span></span></h3>
        <div class="box-t1">
                <div class="box-t2">
                        <div class="box-t3"></div>
                </div>
        </div>
        <div class="box-1">
                <div class="box-2 deepest with-header">
                <ul id="block" class="menu menu-accordion sortable">
		<span id="db_Menumodel"></span>
		<?
		$i = 1;
		foreach ($items['items'] as $item) { 
		$item = (object) $item;
		if ($i==1)
			$extra = "first";
		elseif ($i == count($items))
			$extra = "last";
		else
			$extra = "";
		?>
		  <li id="listItem_<?=$item->id?>" class="level1 item<?=$i?> <?=$extra?>"><a href="<?=$item->link?>" class="level1 item<?=$i?> <?=$extra?>"><span class="bg"><?=$item->name?></span></a></li>
		<?
		 $i++; 
		} ?>
                </ul>
               </div>
        </div>
        <div class="box-b1">
                <div class="box-b2">
                        <div class="box-b3"></div>
                </div>
        </div>
</div>
<div id="info"></div>
<script>
  $(".sortable").sortable({
    update : function () {
      var order = $('#block').sortable('serialize');
      $("#info").load("/admin/saveitem.html?"+order);
    }
  });
</script>

