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
			<span>Username:</span><br />
			<input style="padding:5px; width: 96.5%;" id="gamever" /><br /><br />
			<span>Reason:</span><br />
			<textarea style="padding:5px; width: 96.5%;" placeholder="Reason" id="reason" rows="2"></textarea><br /><br />
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