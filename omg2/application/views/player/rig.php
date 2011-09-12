<? 
global $user;
$user = $this->session->userdata("user"); ?>
<form action="/player/save.html" method="POST">
 <fieldset>
  <legend>Gaming Rig</legend>
   <input type="hidden" name="id" id="id" value="<?=$user->id?>" />
   <p>
     <label for="cb_processor">Processor: </label>
     <input id="cb_processor" name="cb_processor" size="25" minlength="2" value="<?=$user->cb_processor?>" />
   </p>
   <p>
     <label for="cb_processor">Memory: </label>
     <input id="cb_memory" name="cb_memory" size="25" minlength="2" value="<?=$user->cb_memory?>" />
   </p>
   <p>
     <label for="cb_graphicscards">Graphic Cards: </label>
     <input id="cb_graphicscards" name="cb_graphicscards" size="25" minlength="2" value="<?=$user->cb_graphicscards?>" />
   </p>
   <p>
     <label for="cb_motherboard">Motherboard: </label>
     <input id="cb_motherboard" name="cb_motherboard" size="25" minlength="2" value="<?=$user->cb_motherboard?>" />
   </p>
<?
item("CPU Cooling:", "cb_cooling", "", $user);
item("Other Cooling:", "cb_othercooling", "", $user);
item("Keyboard:", "cb_keyboard", "", $user);
item("Mouse:", "cb_mouse", "", $user);
item("Monitor:", "cb_monitor", "", $user);
item("PSU:", "cb_psu", "", $user);
item("Hard Drives:", "cb_hdds", "", $user);
item("ISP:", "cb_isp", "", $user);
item("ADSL Line:", "cb_adsl", "", $user);
?>
 <div style="clear: both;"></div>
 <input type="submit" value="Update" />
 </fieldset>
</form>
