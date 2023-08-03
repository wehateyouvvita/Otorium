function reactivate() {
	$("#reactbtn").addClass("disabled");
	
	$.post('https://otorium.xyz/api/core/activateAccount.php',{activate:"true"},
	function(data)
	{
		
		var message = $(data).filter("#message").html();
		
		var success = $(data).filter("#success").html();
		
		document.getElementById("result").innerHTML = message;
		document.getElementById("result").style.display = 'block';
		
		if(success = "t") {
			document.getElementById("banContent").style.display = 'none';
			document.getElementById("reactbtn").style.display = 'none';
			setTimeout(function(){
				window.location.href = "https://otorium.xyz/home.php";
			}, 4000);
		}
		
		$("#reactbtn").removeClass("disabled");
		
	});
}