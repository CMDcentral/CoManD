	<style>
	#sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; font-size: 8px; }
	#sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 15px;  border: 1px solid black; background: #CCC }
	#sortable li span { position: absolute; margin-left: -1.3em; }
	</style>


	<script>
	$(function() {
	//	$( "#sortable" ).sortable();
//		$( "#sortable" ).disableSelection();
	});


  $("#sortable").sortable({ 
    update : function () { 
      var order = $('#sortable').sortable('serialize'); 
      $("#info").load("/admin/saveitem.html?"+order); 
    } 
  }); 

	</script>
<div id="info" class="info" >Drag drop to rearrange order of articles.</div>
<ul id="sortable">
<input type="hidden" value="Servicesmodel" id="db_Servicesmodel" />
{news}
<li id="listItem_{id}" class="ui-state-default"><a href="/service/edit/{id}.html">{name}</a></li>
{/news}
</ul>
