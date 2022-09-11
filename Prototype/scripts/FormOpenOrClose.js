// JavaScript Document
// Project Name: Inverloch Bike Hire
// Project Description: A website for hiring bikes. Front-end accompanied by an admin dashboard.
// File Description: This is for the form to pop out when needed
// Contributor:
// 	- Clement Cheung @ 103076376@student.swin.edu.au


// This page is completely done by Clement
function init()
{
	if (document.URL.includes("Locations"))
	{
		// Get the modal
		var modal = document.getElementById("myModal");
		
		// Get the button that opens the modal
		var btn = document.getElementById("myBtn");
		
		// Get the <span> element that closes the modal
		var span = document.getElementsByClassName("close")[0];
		
		// When the user clicks on the button, open the modal
		btn.onclick = function() {
			modal.style.display = "block";
		}
		
		// When the user clicks on <span> (x), close the modal
		span.onclick = function() {
			modal.style.display = "none";
		}
		
		// When the user clicks anywhere outside of the modal, close it
		window.onclick = function(event) {
			if (event.target == modal) {
				modal.style.display = "none";
			}
		} 
			
			
	}
	


			
}

window.onload = init;