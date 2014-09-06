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
	var memid = parseInt(formData["member_id"]);
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
			$("#registerForm").html(
				"<b>Confirmation</b><br>Member ID: "+result["member_id"]
				+"<br>First Name: "+result["first_name"]
				+"<br>Last Name: "+result["last_name"]
				+"<br>Contact: "+result["contact"]
				+"<br><button onclick=backToRegister()>ok</button>"
				);
 		},
 		error: function(error){
 			console.log(error);
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
	$('#registerForm').html(registerForm);
}
