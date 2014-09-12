
$("document").ready(function(){
	// add event handlers
	$("#registerButton").click(register);
	$(".back").click(backToRegister);
	// hide the result and error area to overwirte user agent's style sheet settings
	$("#result").css("display","none");
	$("#error").css("display","none");
	// if mobile device used, make brand font smaller for better appearance
	if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
		$(".navbar-brand").css("font-size","10px");
	}
})

// collect and validate form data
function collectFormData(){
	var formData = {};
	var input = $("input");
	for (var i = 0; i < input.length; i++) {
		formData[input[i].id]=input[i].value;
	}
	//validate data
	var memid = parseInt(formData["memid"]);
	if (isNaN(memid)) {
		throw "Member ID must be a valid number";
	}
	return formData;
}

function register(){
	try {
		var data = collectFormData();
		$.ajax({
			type: "POST",
			url: "php/register.php",
			async: false,
			data: data,
			dataType: "json",
			success: function(result){
				// reset and hide form
				$("input").val("");
				$("#registerForm").css("display","none");
				// change result content
				if (result["error"] !== undefined) {
					$("#err_msg").html(result["error"]+"<br><br>");
					$("#error").css("display","");
				} 
				else {
					$("#memid_result").html(result["memid"]);
					$("#fname_result").html(result["fname"]);
					$("#lname_result").html(result["lname"]);
					$("#email_result").html(result["email"]);
					$("#result").css("display","");
				}
	 		},
	 		error: function(error){
	 			$("input").val("");
				$("#findForm").css("display","none");
				$("#err_msg").html(error["responseText"]+"<br><br>");
				$("#error").css("display","");
	 		},
	 		complete: function(){
	 			console.log("complete");
	 		}
 		});
	} catch(err) {
		alert(err);
	}
}

function backToRegister() {
	// reset input value
	$("input").val("");
	// display form and hide result
	$("#registerForm").css("display","");
	$("#result").css("display", "none");
	$("#error").css("display","none");

}
