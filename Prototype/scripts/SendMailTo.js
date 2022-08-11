// JavaScript Document

"use strict";
function sendmail()
{
	var errMsg = "";
	var result = true;
	
	var name = document.getElementById("name").value.trim();
	var emailin = document.getElementById("email").value.trim();
	var subject = document.getElementById("subject").value;
	var message = document.getElementById("msg").value;
	var emailto = "s103076376@gmail.com";
	
	var emailvalidate =
  /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
	
	
	if(name == ""){
		errMsg += "The First Name cannot be empty.\n";
	} else if(!name.match(/^[A-Za-z]{1,25}$/)){
		errMsg += "The First name need to be in alphabetical order and must be less than 25 characters.\n";
		result=false;
	}
	
	if(emailin == ""){
		errMsg += "The email cannot be empty. \n";
		result=false;
	} else if(!emailin.match(emailvalidate)){
		result = false;
		errMsg += "The email address you entered is invalid.\n"
	}
	if(subject == ""){
		errMsg += "The subject cannot be empty. \n";
		result=false;
	}
	
	if(message == ""){
		errMsg += "The message cannot be empty. \n";
		result=false;
	}
	
	if (errMsg != ""){
		alert (errMsg);
		result = false;
	}
	var completemessage="";
	//https://stackoverflow.com/questions/22765834/insert-a-line-break-in-mailto-body making new lines
	completemessage=message + "%0D%0AFrom: " +name+"%0D%0A"+emailin; 
	if (result){
		var sendcompletemail = "mailto:" +emailto+"?subject="+subject+"&body="+completemessage;
		window.location.href = sendcompletemail;
	}
	
	
	
	
	return result;
}

function init()
{
	if (document.URL.includes("contactus"))
	{
		var emailform = document.getElementById("emailform");
		emailform.onsubmit  = sendmail;
	}
	
		collapsibles();
}

window.onload = init;


//this is operational and fdor the animation dropdown
function collapsibles()
{
	var coll = document.getElementsByClassName("collapsible");
	var i;
	for (i = 0; i < coll.length; i++) {
		coll[i].addEventListener("click", function() {
			this.classList.toggle("active");
			var content = this.nextElementSibling;
			if (content.style.maxHeight){
				content.style.maxHeight = null;
			} else {
				content.style.maxHeight = content.scrollHeight + "px";
			}
		});
	}
}

