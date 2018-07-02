/**
 * 
 */

var response;
var counter = 0;
var answers = [];

//Sends the category to the server and returns the required data
function loadData() {
	
	answers = [];
	response = [];
	var state = document.getElementById("dropdown").value;
	console.log(state);
	var ajax = new XMLHttpRequest();
	ajax.open("GET", "../Controller/dataHandler.php?value="+state, true);
	ajax.onreadystatechange = function() {
		  if (this.readyState == 4 && this.status == 200) {
			  response = JSON.parse(this.responseText);
			  console.log(response);
			  document.getElementById("questionLabel").innerHTML = response[0][0];
			  document.getElementById("TextA").innerHTML = "A) "+response[1][0];
			  document.getElementById("TextB").innerHTML = "B) "+response[1][1];
			  document.getElementById("TextC").innerHTML = "C) "+response[1][2];
			  document.getElementById("TextD").innerHTML = "D) "+response[1][3];
			  
		  }
	
	}
	ajax.send();
}

//Logic for using the next/previous buttons
function leftShift() {
	
	if(counter == 0) {
		
		  counter = response[0].length - 1;
		  document.getElementById("questionLabel").innerHTML = response[0][counter];
		  document.getElementById("TextA").innerHTML = "A) "+response[1][counter*4];
		  document.getElementById("TextB").innerHTML = "B) "+response[1][counter*4+1];
		  document.getElementById("TextC").innerHTML = "C) "+response[1][counter*4+2];
		  document.getElementById("TextD").innerHTML = "D) "+response[1][counter*4+3];
	}
	else {
		
		counter--;
		document.getElementById("questionLabel").innerHTML = response[0][counter];
		document.getElementById("TextA").innerHTML = "A) "+response[1][counter*4];
		document.getElementById("TextB").innerHTML = "B) "+response[1][counter*4+1];
		document.getElementById("TextC").innerHTML = "C) "+response[1][counter*4+2];
		document.getElementById("TextD").innerHTML = "D) "+response[1][counter*4+3];
	}
}

function rightShift() {
	
	if(counter == response[0].length-1) {
		
		  counter = 0;
		  document.getElementById("questionLabel").innerHTML = response[0][counter];
		  document.getElementById("TextA").innerHTML = "A) "+response[1][counter*4];
		  document.getElementById("TextB").innerHTML = "B) "+response[1][counter*4+1];
		  document.getElementById("TextC").innerHTML = "C) "+response[1][counter*4+2];
		  document.getElementById("TextD").innerHTML = "D) "+response[1][counter*4+3];
	}
	else {
		
		counter++;
		document.getElementById("questionLabel").innerHTML = response[0][counter];
		document.getElementById("TextA").innerHTML = "A) "+response[1][counter*4];
		document.getElementById("TextB").innerHTML = "B) "+response[1][counter*4+1];
		document.getElementById("TextC").innerHTML = "C) "+response[1][counter*4+2];
		document.getElementById("TextD").innerHTML = "D) "+response[1][counter*4+3];
	}
}

//Gets the currently answered question into an array
function getAnswer() {

	var buttonValues = document.getElementsByName("answer");
	var checkedButton;
	for(var i = 0; i < buttonValues.length; i++) {
		
		if(!buttonValues[i].checked) continue

		checkedButton = buttonValues[i].value;
		break;
			
	}
	answers[counter] = checkedButton;
	console.log(answers);
	
}

//Shows how the user answered
function showResults() {
	
	var message = "You have answered the following questions: ";
	for(var i = 0; i < answers.length; i++) {
		switch (answers[i]) {
		
			case "0":
				i = i+1;
				message = message + "Question "+ i + " - A) / ";
				i = i-1;
				break;
			case "1":
				i = i+1;
				message = message + "Question "+ i + " - B) / ";
				i = i-1;
				break;
			case "2":
				i = i+1;
				message = message + "Question "+ i + " - C) / ";
				i = i-1;
				break;
			case "3":
				i = i+1;
				message = message + "Question "+ i + " - D) / ";
				i = i-1;
				break;
			case undefined:
				i = i+1;
				message = message + "Question "+ i + " - unanswered / ";
				i = i-1;
				break;
				
			default:
				break;
			
		
		}
		
	}
	document.getElementById("textField").innerHTML = message;
	
}

