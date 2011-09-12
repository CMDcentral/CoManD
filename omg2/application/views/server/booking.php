<h1>Server Bookings</h1>
<div class="info">Please fill in the information required to book the server.<br/><br/>You can use the 
"Check Booking" button to see if the selected server is available for that slot.</div>
<hr class="dotted" />
<form action="/server/processbooking.html" id="bookingform" name="book" method="POST">
<table width="100%" border="0" cellspacing="1" cellpadding="2">
<tr>
<td>
</td>
</tr>
<tr>
<td width="200" nowrap>Date:</td>
<td>
<p><input id="datepicker" type="text" name="date" value="<?php if (isset($_POST['date'])) { echo $_POST['date']; } else { echo date("Y-m-d"); } ?>"></p>
</td>
</tr>
<tr>
<td width="200" nowrap>Start Time:</td>
<td>
<input type="text" value="<?=date("H:00");?>" name="sb_starttime" class="timepicker" readonly="readonly" />
</td>
</tr>
<tr>
<td width="200" nowrap>End Time:</td>
<td>
<input type="text" value="<?=date("H:00");?>" name="sb_endtime" class="timepicker" readonly="readonly" />
</td>
</tr>
<tr>
<td width="200" nowrap>Server Password:</td>
<td>
<?
echo set_value('date');
echo set_value('sb_starttime');
//echo form_dropdown("password", $password, set_value('password'));
echo form_input("password", "");
?>
<sub>Choose a password that is easy to remember.</sub>
</td>
</tr>
<tr><td>Server:</td>
<td>
<?
if (!isset($server)) { $server=""; }
echo form_dropdown("server", $servers, $server);?>
( View Bookings )
</td>
</tr>
<td width="100">&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td width="100">
<a style="cursor: pointer;" id="check">Check Booking</a>
</td>
<td> <input name="sbbooking" type="submit" id="add" value="Confirm Booking"></td>
</tr>
</table>
</form>
<h1>My Bookings</h1>
<div id="pager" class="pager">
        <form>
                <img src="/images/first.png" class="first"/>
                <img src="/images/prev.png" class="prev"/>
                <input type="text" class="pagedisplay"/>
                <img src="/images/next.png" class="next"/>
                <img src="/images/last.png" class="last"/>
                <select class="pagesize">
                        <option value="30">30</option>
                        <option value="60">60</option>
                        <option value="100">100</option>
                </select>
        </form>
</div>
<table border="0" cellpadding="0" cellspacing="0" width="100%" id="clanlist" name="clanlist" class="tablesorter">
<thead>
<tr><th>ID</th><th>Date</th><th>Start</th><th>End</th><th>Password</th><th>Server</th><th>Actions</th></tr>
</thead>
<tbody>
<?
if (sizeof($mybookings) == 0)
	echo '<tr><td colspan="7">No server bookings found.</td></tr>';
foreach ($mybookings as $booking)
{
?>
<tr style="">
<td><?=$booking->id?></td>
<td><?=$booking->date?></td>
<td><?=$booking->start?></td>
<td><?=$booking->end?></td>
<td><?=$booking->password?></td>
<td><?=$booking->name?></td>
<td>
<?=button("cancel", "Cancel", "closethick", "/server/cancel_booking/".$booking->id, "confirmClick"); ?>
&nbsp;<?=button("control", "Control", "search", "/server/control/".$booking->id); ?>
</td>
</tr>
<?
}
?>
</tbody>
</table>
<div id="dialog-modal" title="Booking Information" style="display: none;">
	<div class="info" id="error"></div>
</div>
        <script>
        $( "#dialog-modal" ).dialog({
                        autoOpen: false,
                        show: "blind",
                        modal: true,
                        hide: "explode"
                });

        $(function() {
                $("#clanlist").tablesorter({sortList:[[0,0]], widgets: ['zebra']})
                .tablesorterPager({container: $("#pager")});
        });

        function goto(id) {
         location.href = '/server/view_booking/'+id+'.html';
        }

$('.timepicker').timepicker({
	showSecond: false,
	showMinute: false,
	timeFormat: 'hh:mm',
	stepHour: 1,
	stepMinute: 30
});

$('#check').click(function() {
  str = $("#bookingform").serialize();

$.ajax({
  type: 'POST',
  url: "/server/check.html",
  data: str,
  success: successF
});

function successF(dt)
{
if (dt.toString() == "")
	$( "#error" ).html("The server is available for this timeslot, please Confirm Booking below to complete the booking.");
else
        $( "#error" ).html(dt.toString());
$( "#dialog-modal").dialog( "open" );
return false;
}


});
</script>

