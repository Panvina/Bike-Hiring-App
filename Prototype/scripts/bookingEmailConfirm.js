// JavaScript Document

"use strict";

function sendbooking()
{	
	var result = true;
	//this is to retrieve values from the form or in this case, having default values
	var bikeType = "Merida Big 7";
	var name = "John Smith";
	var price = "25";
	var quantity = "1";
	var pickUpLocation = "Inverloch Pier";
	var dropOffLocation = "Inverloch Pier";
	var duration = "Overnight";
	var startDate = "1/06/22";
	var endDate = "2/06/22";
	var pickUpTime = "9:00AM";
	var dropOffTime = "9:00AM";
	var emailto = "s103076376@gmail.com";
	var subject = "BOOKING CONFIRMATION";
		
	//this is to put message together fully with the sender and email.
	var completemessage="";
	//https://stackoverflow.com/questions/22765834/insert-a-line-break-in-mailto-body making new lines
	completemessage="BOOKING CONFIRMATION: %0D%0ABike Type: " +bikeType
		+" %0D%0ACustomer Info: "+name
		+" %0D%0APrice: $"+price
		+"AUD %0D%0AQuantity: "+quantity
		+" %0D%0APick Up Location: "+pickUpLocation
		+" %0D%0ADrop Off Location: "+dropOffLocation
		+" %0D%0ADuration: "+duration
		+" %0D%0AStart Date: "+startDate
		+" %0D%0AEnd Date: "+endDate
		+" %0D%0APickUp Time: "+pickUpTime
		+" %0D%0ADropOff Time: "+dropOffTime
		+" %0D%0AEnjoy the ride!"
	; 
	
	//to send the email to the reciever
		var sendcompletemail = "mailto:" +emailto+"?subject="+subject+"&body="+completemessage;
		window.location.href = sendcompletemail;
	return result;
}

function init()
{
	//this is so when the form is send, the confirmation email is send
	var bookingForm = document.getElementById("bookingForm");
	bookingForm.onsubmit  = sendbooking();
}

window.onload = init;
