<link rel="stylesheet" type="text/css" href="/css/flip.css" />
<script type="text/javascript" src="/js/jquery.flip.min.js"></script>
<script type="text/javascript" src="/js/flip.js"></script>
<div id="leaguemain">
	<div class="sponsorListHolder">	
        <?php
			foreach($games as $game)
			{
				if ($game->leagues > 0)
					$extra = $game->leagues . " Active League(s)";
				else
					$extra = "";
				echo'
				<div style="'.$extra.'" class="sponsor" title="Click to flip">
					<div class="sponsorFlip">
						<img src="/thumb/index/width/140/height/140?i='.$game->image.'" alt="'.$game->name.'" />
						'.$extra.'
					</div>
					
					<div class="sponsorData">
						<div class="sponsorDescription">';
						echo "Currently Active Tournaments<br/>";
			$CI = &get_instance();
			$CI->load->model("Leaguemodel");
			$leagues = $CI->Leaguemodel->get_all($game->id);
			foreach ($leagues as $league)
				echo "<a href='/league/view/".$league->t_alias.".html'>".$game->abbv . " " .$league->name."</a><br/>";
			if (sizeof($leagues) == 0)
				echo "No active tournaments";
				

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
