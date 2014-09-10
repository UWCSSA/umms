var findForm = 'Member ID: <input type="text" id="find_member"><br><button onclick="findMember()">find</button>';

$("document").ready(function(){
	$("#find").click(findMember)
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
			// add result
			if (result["error"] !== undefined) {
				$("#result").html(result["error"]+"<br><button onclick=backToFind()>ok</button>");
			} else {
				$("#result").html(
					"Member ID: "+result["memid"]
					+"<br>First Name: "+result["fname"]
					+"<br>Last Name: "+result["lname"]
					+"<br>Contact: "+result["contact"]
					+"<br><button onclick=backToFind()>ok</button>"
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
}

function backToFind() {
	$("#findForm").css("display","");
	$("#result").css("display","none");
}