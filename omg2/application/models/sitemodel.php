<?
class Sitemodel extends CI_Model
{
function get_games($all=false) {
	$query = $this->db->get('jos_egsa_game');

	if (!$all) {
	foreach ($query->result() as $game)
		$games[$game->id] = $game->name;
	return $games; }
	else
	 return $query->result();
}

function get_countries() {
        $query = $this->db->get('jos_bl_countries');
        foreach ($query->result() as $c)
                $games[$c->id] = $c->country;
        return $games;
}
}
?>
