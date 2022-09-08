// JavaScript Document
// Project Name: Inverloch Bike Hire
// Project Description: A website for hiring bikes. Front-end accompanied by an admin dashboard.
// File Description: This is to make the items have simple animation when there is dropdown hapepning
// Contributor:
// 	- Clement Cheung @ 103076376@student.swin.edu.au

// This page is completely done by Clement
"use strict";

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

//initialise functions here
function init(){
	collapsibles();
	
}


window.onload = init;