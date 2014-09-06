var findForm = 'Member ID: <input type="text" id="find_member"><br><button onclick="findMember()">find</button>';

$("document").ready(function(){
	$("#find").click(findMember)
})

function findMember() {
	var memid = $("#find_member").val();
	$.ajax({
		type: "POST",
		url: "php/find.php",
		async: false,
		data: {
			memid: memid
		},
		dataType: "json",
		success: function(data){
			if (data.memid === -1) {
				$("#findForm").html("member not found"+"<br><button onclick=backToFind()>ok</button>");
			} else {
    		$("#findForm").html(
					"<br>Member ID: "+data.memid
					+"<br>First Name: "+data.fname
					+"<br>Last Name: "+data.lname
					+"<br>Contact: "+data.contact
					+"<br><button onclick=backToFind()>ok</button>"
				);
    	}
 		},
 		error: function(error){
 			console.log(error);
 		},
 		complete: function(){
 			console.log("complete");
 		}
 	});
}

function backToFind() {
	$('#findForm').html(findForm);
}