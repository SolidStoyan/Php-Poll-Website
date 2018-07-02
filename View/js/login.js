/**
 * 
 */
var errorMessage = "";

function loginCall() {
	
	var username = document.getElementById("uname").value;
	var password = document.getElementById("psw").value;

	if(checkEmptyFields(username, password) && checkSpecialChars(username, password)) {
		
		var ajax = new XMLHttpRequest();
		ajax.open("POST", "../Controller/loginHandler.php", true);
		ajax.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		ajax.onreadystatechange = function() {
			  if (this.readyState == 4 && this.status == 200) {
				  var response = JSON.parse(this.responseText);
				  console.log(response);
				  if(response == true) {
					  window.location.assign("../Controller/indexController.php?page=main");
				  }
				  else {
					  showResponseMessage(response);
				  }
				  
				  
			  }
		
		};
		ajax.send("username="+username+"&password="+password);
	}
	else {
		showResponseMessage(errorMessage);
	}
}

function showResponseMessage(error) {
	document.getElementById("loginErrorField").innerHTML = error;
	
}


function checkEmptyFields(username, password) {
	
	if(username == null || username == "", password == null || password == "") {
		
		errorMessage = "Please fill out all of the fields!";
		return false;
	}
	else {
		
		return true;
	}
	
}


function checkSpecialChars(username, pass) {
	var format = /[ !@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;
	
	if(format.test(username)) {
		
		errorMessage = "Please remove any special characters from the username!";
		return false;
	}
	else if(format.test(pass)) {
		
		errorMessage = "Please remove any special characters from the password!";
		return false;
	}
	else {
		return true;
	}
	
}
