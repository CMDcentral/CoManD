<h1>Chat</h1>
	<script type="text/javascript">
		$(document).ready(function(){
			timestamp = 0;
			updateMsg();
			hideLoading();
			$("form#chatform").submit(function(){
				showLoading();								
				$.post("/chat/backend",{
							message: $("#content22").val(),
							action: "postmsg",
							time: timestamp
						}, function(xml) {
					addMessages(xml);
					$("#content22").val("");
					hideLoading();
					$("#content22").focus();
				});		
				return false;
			});
		});
		function rmContent(){
			
		}
		function showLoading(){
			$("#contentLoading").show();
			$("#txt").hide();
			$("#author").hide();
		}
		function hideLoading(){
			$("#contentLoading").hide();
			$("#txt").show();
			$("#author").show();
		}
		function addMessages(xml) {
			if($("status",xml).text() == "2") return;
			timestamp = $("time",xml).text();
			$("message",xml).each(function(id) {
				message = $("message",xml).get(id);
				$("#messagewindow").prepend("<b>"+$("author",message).text()+
											"</b>: "+$("text",message).text()+
											"<br />");
			});

			
		}
		function updateMsg() {
			$.post("/chat/backend",{ time: timestamp }, function(xml) {
				$("#loading").remove();				
				addMessages(xml);
			});
			setTimeout('updateMsg()', 4000);
		}
	</script>
	<style type="text/css">
		#messagewindow {
			height: 250px;
			border: 1px solid;
			padding: 5px;
			overflow: auto;
		}
		#wrapper {
			margin: auto;
			width: 100%;
		}
	</style>
	<div id="wrapper">
	<p id="messagewindow"><span id="loading">Loading...</span></p>
	<form id="chatform">
	<div id="txt">
	Message: <input size="100" type="text" name="content" id="content22" value="" />
	</div>
	<div id="contentLoading" class="contentLoading">  
	<img src="/images/blueloading.gif" alt="Loading data, please wait...">  
	</form>
	</div>
	</div>
