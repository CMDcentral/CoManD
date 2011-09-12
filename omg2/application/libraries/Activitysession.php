<?
class Activitysession {

function __construct() {
	if (lin()) {
	$CI = &get_instance();
	$time = date("Y-m-d H:i:s");
	$data['id'] = user_id();
	$data['last_activity'] = $time;
	$data['lastvisitDate'] = $time;
	$class = $CI->router->class ."/".$CI->router->method;
	$data['last_seen'] = $class;
	$CI->load->model("Playermodel");
	$CI->Playermodel->save($data);
	}
}

}
?>
