
$("document").ready(function(){
	// add event handler
	$("#find").click(findMember);
	$(".back").click(backToFind);
	// hide the result and error area to overwirte user agent's style sheet settings
	$("#result").css("display","none");
	$("#error").css("display","none");
})

function findMember() {
	//validate data
	var memid = parseInt($("#memid").val());
	if (isNaN(memid)) {
		alert("Member ID must be a valid number");
		return;
	}
	$.ajax({
		type: "POST",
		url: "php/find.php",
		async: false,
		data: {
			memid: memid
		},
		dataType: "json",
		success: function(result){
			// reset and hide form
			$("input").val("");
			$("#findForm").css("display","none");
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
				$("#credit_result").html(result["credit"]);
				$("#result").css("display", "");
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
}

function backToFind() {
	// reset input value
	$("input").val("");
	// display form and hide result and error
	$("#findForm").css("display","");
	$("#result").css("display","none");
	$("#error").css("display","none");
}