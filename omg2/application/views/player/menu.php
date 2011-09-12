<div class="module mod-box mod-box-grey mod-menu mod-menu-box mod-box-header">
                <h3 class="header"><span class="header-2"><span class="header-3">Personal</span></span></h3>
        <div class="box-t1">
                <div class="box-t2">
                        <div class="box-t3"></div>
                </div>
        </div>
        <div class="box-1">
                <div class="box-2 deepest with-header">
                <ul class="menu menu-accordion">
                <?if (!$this->session->userdata("loggedin")) { ?>
                        <li class="level1 item1 first last"><a href="/player.html" class="level1 item1 first last"><span class="bg">Login/Register</span></a></li>
                <? } else { ?>
                        <li class="level1 item1 first"><a href="/player/profile.html" class="level1 item1 first"><span class="bg">Profile</span></a></li>
                        <li class="level1 item2"><a href="/challenge.html" class="level1 item2"><span class="bg">Challenges</span></a></li>
                </ul>

<? if (sizeof($clans) > 0) { ?>

<ul class="menu menu-accordion">
<li class="separator level1 item1 first last parent toggler">
	<span class="separator level1 item1 first last parent"><span class="bg">My Clans</span></span>

<div style="overflow: hidden; display: none;">
	<ul class="accordion level2">
		<? foreach ($clans as $clan) { ?>
		  <li class="level2 item1 first">
			<span class="bg"><sub><a class="level2 item1 first" href="/clan/view/<?=$clan->cid?>.html"><?=$clan->name?></a></sub></span>
		  </li>
		<? } ?>
	</ul>
</div>
</li>
</ul>

                <? } // end sizeof

	 } // end logged in
?>
               </div>
        </div>
        <div class="box-b1">
                <div class="box-b2">
                        <div class="box-b3"></div>
                </div>
        </div>
</div>
