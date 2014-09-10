var registerForm = 'Member ID: <input type="text" id="member_id"><br>First Name: <input type="text" maxlength="20" id="first_name"><br>Last Name: <input type="text" maxlength="20" id="last_name"><br>Contact: <input type="text" maxlength="50" id="contact"><br><button onclick="register()">register</button>';

// add register() funciton as an event handler to register button
$("document").ready(function(){
	$("#registerButton").click(register)
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
					$("#result").html(result["error"]+"<br><button onclick=backToRegister()>ok</button>");
				} 
				else {
					$("#result").html(
						"<b>Confirmation</b><br>Member ID: "+result["memid"]
						+"<br>First Name: "+result["fname"]
						+"<br>Last Name: "+result["lname"]
						+"<br>Contact: "+result["contact"]
						+"<br><button onclick=backToRegister()>ok</button>"
						);
				}
				// show result
				$("#result").css("display", "");
	 		},
	 		error: function(error){
	 			console.log(error.responseText);
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
}
