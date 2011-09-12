<h4>Under Construction</h4>
<!-- <div id="tabs">
        <ul>
	        <li><a href="#tabs-1">Challenge Team</a></li>
                <li><a href="#tabs-2">Challenge Individual</a></li>
        </ul>
        <div id="tabs-1">
	</div>
        <div id="tabs-2">
        </div>
</div>
-->
<div class="note">
This can be used to arrange a challenge against an individual or team that is a member to eGaming South Africa.<br/>
Once the challenge has been created, maps and other decisions can be made using the challenge thread.
</div>
<form method="POST" action="/challenge/save.html">
<fieldset class="singleRow">
<p><label>Game: </label><input id="game" name="game" type="text" size="30" /></p>
<p><label>Mode: </label><input id="mode" name="mode" type="text" size="30" /></p>
<p><label>Date: </label><input id="playdate" name="playdate" class="datepicker" type="text" size="30" /></p>
<p><label>Time: </label><input id="time" name="time" placeholder="20:00" type="text" size="30" /></p>
<p><label>Opposition: </label><input id="tags" name="tags" type="text" size="30" /></p>
<input name="team2" type="hidden" id="team2" />
<p><label>Opp Type: </label><input id="class" name="class" readonly="readonly" type="text" size="30" /></p>
<p><label>Notes: </label><textarea id="notes" name="notes" rows="10" cols="20"></textarea></p>
</fieldset>
<fieldset class="singleRow">
<p><label>Game: </label><input id="game" name="game" type="text" size="30" /></p>
<p><label>Mode: </label><input id="mode" name="mode" type="text" size="30" /></p>
</fieldset>
<div style="clear: both;"></div>
<p><input type="submit" name="Challenge!" /></p>
</form>
        <script>

$.ajaxSetup({
   jsonp: null,
   jsonpCallback: null
});
        $(function() {
                function split( val ) {
                        return val.split( / \s*/ );
                }
                function extractLast( term ) {
                        return split( term ).pop();
                }

                var myArray = new Array();

                $('#set').click(function() {
                  terms = $("#statusForm").serialize();
                  $("#status").load("/player/status.html?"+terms);
                });
                $("#clear").click(function() {
                  $("#tags").val("");
                  $("#status").load("/player/status.html?tags=");
                });

                $( "#tags" )
                        // don't navigate away from the field on tab when selecting an item
                        .bind( "keydown", function( event ) {
                                if ( event.keyCode === $.ui.keyCode.TAB &&
                                                $( this ).data( "autocomplete" ).menu.active ) {
                                        event.preventDefault();
                                }
                        })
                        .autocomplete({
                                minLength: 0,
                                source: function( request, response ) {
                                        $.getJSON( "/ajax/search.html", {
                                                term: extractLast( request.term )
                                        }, response );
                                },
                                focus: function() {
                                        // prevent value inserted on focus
                                        return false;
                                },
                                select: function( event, ui ) {
                                        var terms = split( this.value );
                                        // remove the current input
                                        terms.pop();
					$("#class").val(ui.item.type);
					$("#team2").val(ui.item.id);
                                        // add the selected item
                                        terms.push( ui.item.value );
                                        // add placeholder to get the comma-and-space at the end
                                        terms.push( "" );
                                        this.value = terms.join( "" );
                                        return false;
                                }
                        });
        });
        </script>

