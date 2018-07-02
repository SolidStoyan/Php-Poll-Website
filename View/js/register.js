/**
 * 
 */

var errorMessage = "";

function regCall() {
	
	var username = document.getElementById("username").value;
	var password = document.getElementById("pass").value;
	var rpassword = document.getElementById("rpass").value;
	
	if(checkEmptyFields(username, password, rpassword) && checkSpecialChars(username, password, rpassword)) {
		
		var ajax = new XMLHttpRequest();
		ajax.open("POST", "../Controller/regHandler.php", true);
		ajax.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		ajax.onreadystatechange = function() {
			  if (this.readyState == 4 && this.status == 200) {
				  var response = JSON.parse(this.responseText);
				  showResponseMessage(response);
				  
				  
			  }
		
		};
		ajax.send("username="+username+"&password="+password+"&rpass="+rpassword);
	}
	else {
		console.log(errorMessage);
		showResponseMessage(errorMessage);
	}
	
}

function showResponseMessage(error) {
	document.getElementById("errorList").innerHTML = error;
	
}

function checkSpecialChars(username, pass, rpass) {
	var format = /[ !@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;
	
	if(format.test(username)) {
		
		errorMessage = "Please remove any special characters from the username!";
		return false;
	}
	else if(format.test(pass)) {
		
		errorMessage = "Please remove any special characters from the password!";
		return false;
	}
	else if(format.test(rpass)) {
		
		errorMessage = "Please remove any special characters from the repeated password!";
		return false;
	}
	else {
		return true;
	}
	
}

function checkEmptyFields(username, password, rpassword) {
	
	if(username == null || username == "", password == null || password == "", rpassword == null || rpassword == "") {
		
		errorMessage = "Please fill out all of the fields!";
		return false;
	}
	else {
		
		return true;
	}
	
	
}