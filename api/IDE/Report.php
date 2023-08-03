<!DOCTYPE html>
<html>
	<head>
		<title>Report User | Otorium</title>
		<style>
		body {
		  /*font-family: "Helvetica Neue", Arial, sans-serif;*/
		  font-family: 'Comic Sans MS';
		  background-color: #4682B4;
		  color: white;
		}
		textarea {
		  /*font-family: "Helvetica Neue", Arial, sans-serif !important;*/
		  font-family: 'Comic Sans MS';
		}
		button {
		  /*font-family: "Helvetica Neue", Arial, sans-serif !important;*/
		  font-family: 'Comic Sans MS';
		}
		</style>
	</head>
	<body>
		<div id="sendReport">
			<span style="font-size: 1.1em;">Report a player here if they have been breaking the rules!</span><br />
			<span>Username:</span><br />
			<script>
				var children = window.external.ExecScript('game.Players:getChildren()');
				alert(children);
			</script>
			<select style="padding:10px; width: 98.8%;" id="gamever">
			  <option value="1" selected>2009</option>
			  <option value="2">2011</option>
			  <option value="3">2014</option>
			</select><br /><br />
			<span>Reason:</span><br />
			<textarea style="padding:5px; width: 98.8%;" placeholder="Reason" id="reason" rows="6"></textarea><br /><br />
			<button style="border:1px solid rgb(200,200,200); border-radius:5px; float:right;padding:5px;" onclick="submitReport()">Submit</button>
		</div>
		<div id="sentReport" style="display:none;">
			<span>Succesfully sent report!</span>
		</div>
		<script>
		function submitReport(){
			document.getElementById("sendReport").style.display = 'none';
			document.getElementById("sentReport").style.display = 'block';
			//window.external.ExecScript('print("test")');
		}
		</script>
	</body>
</html>