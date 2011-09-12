<link rel="stylesheet" type="text/css" href="/css/flip.css" />
<script type="text/javascript" src="/js/jquery.flip.min.js"></script>
<script type="text/javascript" src="/js/flip.js"></script>
<div class="info">
<b>Click on a game below to see additional information. (eg. Leagues, Leaderboards, Matches, Challenges.)</b>
</div>
<div id="leaguemain">
	<div class="sponsorListHolder">	
        <?php
			foreach($games as $game)
			{
				echo'
				<div class="sponsor" title="Click to flip">
					<div class="sponsorFlip">
						<img src="/thumb/index/width/140/height/140?i='.$game->image.'" alt="'.$game->name.'" />
					</div>
					
					<div class="sponsorData">
						<div class="sponsorDescription">';
						if ($game->leagues > 0)
	                                                echo "<a title='Active Leagues' href='/league/game/".$game->id.".html'>Leagues</a><br/>";
						if ($game->hasLeaderboard == 1)
							echo "<a title='Leaderboard' href='".$game->statsURL."'>Leaderboard</a><br/>";
                                                if ($game->sStats != "")
                                                        echo "<a title='Server Stats' href='".$game->sStats."'>Server Stats</a>";
				echo '		</div>
						<div class="sponsorURL">
							<a href="'.$company[2].'">'.$company[2].'</a>
						</div>
					</div>
				</div>
				
				';
			}
		?>
    	<div class="clear"></div>
    </div>
</div>
