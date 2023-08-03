function submitQuery() {
	$("#submitq").addClass("disabled");
	var reason = $("#rsn").val();
	$("#rsn").addClass("disabled");
	$.post('https://otorium.xyz/api/core/bsQ1tu.php',{reason:reason},
	function(data)
	{
		
		var message = $(data).filter("#message").html();
		
		var success = $(data).filter("#success").html();
		
		document.getElementById("result").innerHTML = message;
		document.getElementById("result").style.display = 'block';
		
		$("#submitq").removeClass("disabled");
		$("#rsn").removeClass("disabled");
		
	});
}