<?
class Calendar extends CI_Controller {

function __construct() {
 parent::__construct();
 $this->load->model("Eventmodel");
 $this->load->model("Todomodel");
}

function index() {
	$month = $this->uri->segment(3);
	$year = $this->uri->segment(4);
	$data['calendar'] = $this->drawcalendar($month,$year);
	$data['controls'] = $this->controls($month, $year);
	$this->layout->view("calendar/index", $data);
}

function controls($month, $year)
{
$select_month_control = '<select name="month" id="month">';
for($x = 1; $x <= 12; $x++) {
  $select_month_control.= '<option value="'.$x.'"'.($x != $month ? '' : ' selected="selected"').'>'.date('F',mktime(0,0,0,$x,1,$year)).'</option>';
}
$select_month_control.= '</select>';

/* select year control */
$year_range = 7;
$select_year_control = '<select name="year" id="year">';
for($x = ($year-floor($year_range/2)); $x <= ($year+floor($year_range/2)); $x++) {
  $select_year_control.= '<option value="'.$x.'"'.($x != $year ? '' : ' selected="selected"').'>'.$x.'</option>';
}
$select_year_control.= '</select>';

/* "next month" control */
$next_month_link = '<a href="/calendar/index/'.($month != 12 ? $month + 1 : 1).'/'.($month != 12 ? $year : $year + 1).'" class="control">Next Month 
>></a>';

/* "previous month" control */
$previous_month_link = '<a href="/calendar/index/'.($month != 1 ? $month - 1 : 12).'/'.($month != 1 ? $year : $year - 1).'" class="control"><< Previous Month</a>';

$todoadd = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;       ++ <a href="/todo/add.html" class="control">Add Task</a>';

/*z bringing the controls together */
$controls = '<form method="get">'.$select_month_control.$select_year_control.'&nbsp;<input type="submit" name="submit" value="Go"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$previous_month_link.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$next_month_link.$todoadd.' </form>';
return $controls;
}

function drawcalendar($month,$year){

  /* draw table */
  $calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

  /* table headings */
  $headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
  $calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

  /* days and weeks vars now ... */
  $running_day = date('w',mktime(0,0,0,$month,1,$year));
  $days_in_month = date('t',mktime(0,0,0,$month,1,$year));
  $days_in_this_week = 1;
  $day_counter = 0;
  $dates_array = array();

  /* row for week one */
  $calendar.= '<tr valign="top" class="calendar-row">';

  /* print "blank" days until the first of the current week */
  for($x = 0; $x < $running_day; $x++):
    $calendar.= '<td class="calendar-day-np">&nbsp;</td>';
    $days_in_this_week++;
  endfor;

  /* keep going with days.... */
  for($list_day = 1; $list_day <= $days_in_month; $list_day++):
    $dmy = $list_day."-".$month."-".$year;
//    echo $dmy . " " . date("j-m-y");
    if ($dmy == date("j-m-y"))
	$class = "today";
    else
	$class = "";
    $calendar.= '<td class="calendar-day '.$class.'">';
      /* add in the day number */
      $calendar.= '<div class="day-number">'.$list_day.'</div>';
      $calendar.= '<div style="clear: both;"></div>';
      /** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
	$events = $this->Eventmodel->get_event($year."-".$month."-".$list_day);
	foreach ($events as $event) {
	 $col = $event->colour;
      	 $calendar.= '<a href="/event/view/'.$event->jobID.'" title="'.$event->name.'"><div style="background: '.$col.';" id="event"><span id="et">'.substr($event->name, 0,28).'</span></div></a>';
	}
//	$tasks = $this->Todomodel->get_task($year."-".$month."-".$list_day);
//	foreach ($tasks as $event) {
//         $col = "magenta";
//         $calendar.= '<a href="/todo/view/'.$event->id.'.html" class="popup" title="'.$event->description.'"><div style="background: '.$col.';" id="task"></div></a>';
//        }
    $calendar.= '</td>';
    if($running_day == 6):
      $calendar.= '</tr>';
      if(($day_counter+1) != $days_in_month):
        $calendar.= '<tr valign="top" class="calendar-row">';
      endif;
      $running_day = -1;
      $days_in_this_week = 0;
    endif;
    $days_in_this_week++; $running_day++; $day_counter++;
  endfor;

  /* finish the rest of the days in the week */
  if($days_in_this_week < 8):
    for($x = 1; $x <= (8 - $days_in_this_week); $x++):
      $calendar.= '<td class="calendar-day-np">&nbsp;</td>';
    endfor;
  endif;

  /* final row */
  $calendar.= '</tr>';

  /* end the table */
  $calendar.= '</table>';
  
  /* all done, return result */
  return $calendar;
 }

}
