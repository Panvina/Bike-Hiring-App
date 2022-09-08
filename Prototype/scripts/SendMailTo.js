// JavaScript Document
// Project Name: Inverloch Bike Hire
// Project Description: A website for hiring bikes. Front-end accompanied by an admin dashboard.
// File Description: This page is to send an contactus email from the customer's email to the bike hire email about any enquiries
// Contributor:
// 	- Clement Cheung @ 103076376@student.swin.edu.au

// This page is completely done by Clement
"use strict";

//This is a security function to make sure that any input, especially hacking code is changed into a safe code. 
//idea from https://futurestud.io/tutorials/split-a-string-into-a-list-of-lines-in-javascript-or-node-js#:~:text=You%20can%20split%20a%20long,in%20other%20languages%3A%20%5Cn%20.
//protection from https://stackoverflow.com/questions/20855482/preventing-html-and-script-injections-in-javascript
function lines(text) {  
	text = text.replace(/</g, "&lt;").replace(/>/g, "&gt;");
  return text.split('\n')
}

function sendmail() //this function is to both retrieve, manage data and then send email
{
	var errMsg = "";
	var result = true;
	
	//this is to retrieve values from the form
	var name = document.getElementById("name").value.trim();
	var emailin = document.getElementById("email").value.trim();
	var subject = document.getElementById("subject").value;
	var message = document.getElementById("msg").value;
	var emailto = "s103076376@gmail.com";
	
	//This is to validate email when needed
	var emailvalidate =
  /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
	var LinesArray;
	
	//This is to validate name
	if(name == ""){
		errMsg += "The First Name cannot be empty.\n";
	} else if(!name.match(/^[A-Za-z]{1,25}$/)){
		errMsg += "The First name need to be in alphabetical order and must be less than 25 characters.\n";
		result=false;
	}
	
	//this is to validate email
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
	
	//this is to make sure the message is valid and put them into one string so it can work in MailTo Form
	var fullmessage = "";
	if(message == ""){
		errMsg += "The message cannot be empty. \n";
		result=false;
	}
	else
	{
		LinesArray = lines(message);
		var stringLength = LinesArray.length;
		for(let i=0; i < stringLength; i++)
		{
			fullmessage += LinesArray[i];
			fullmessage += "%0D%0A"
		}
	}
	
	//check if there is any errors
	if (errMsg != ""){
		alert (errMsg);
		result = false;
	}
	
	//this is to put message together fully with the sender and email.
	var completemessage="";
	//https://stackoverflow.com/questions/22765834/insert-a-line-break-in-mailto-body making new lines
	completemessage=fullmessage + "%0D%0ASender: " +name+"%0D%0AEmail: "+emailin; 
	
	//to send the email to the reciever
	if (result){
		var sendcompletemail = "mailto:" +emailto+"?subject="+subject+"&body="+completemessage;
		window.location.href = sendcompletemail;
	}
	return result;
}


//this is operational and for the animation dropdown
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


function init()
{
	//this is to initiate the email form after it recieve data from contactus
	if (document.URL.includes("contactus"))
	{
		var emailform = document.getElementById("emailform");
		emailform.onsubmit  = sendmail;
	}
	//this is for collapsibles to be working right when you enter the website
		collapsibles();
}

window.onload = init;