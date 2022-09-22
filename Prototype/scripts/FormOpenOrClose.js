// JavaScript Document
// Project Name: Inverloch Bike Hire
// Project Description: A website for hiring bikes. Front-end accompanied by an admin dashboard.
// File Description: This is for the form to pop out when needed
// Contributor:
// 	- Clement Cheung @ 103076376@student.swin.edu.au


// This page is completely done by Clement
		// Get the modal
		var addmodal = document.getElementById("addModal");
		var updateModal = document.getElementById("updateModal");
		var deleteModal = document.getElementById("deleteModal");
		
		// Get the button that opens the modal
		var addBtn = document.getElementById("addLocationModal");
		var updateBtn = document.getElementsByClassName("updateLocationModal");
		var deleteBtn = document.getElementsByClassName("deleteLocationModal");
		
		// Get the <span> element that closes the modal
		var addspan = document.getElementsByClassName("addclose")[0];
		var updatespan = document.getElementsByClassName("updateclose")[0];
		var deletespan = document.getElementsByClassName("deleteclose")[0];
		
		// When the user clicks on the button, open the modal
		addBtn.onclick = function() {
			addmodal.style.display = "block";
		}
		
		for (var i = 0; i < updateBtn.length; i++)
		{
			updateBtn[i].onclick = function(event) {
				updateModal[i].style.display = "block";
				  }
		}

		for (var i = 0; i < deleteBtn.length; i++)
		{
			deleteBtn[i].onclick = function(event) {
				deleteModal[i].style.display = "block";
			}
		}
		
		
		// When the user clicks on <span> (x), close the modal
		addspan.onclick = function() {
			addmodal.style.display = "none";
			window.location.replace("Locations.php");
		}
		updatespan.onclick = function() {
			updateModal.style.display = "none";
			window.location.replace("Locations.php?update=false");
		}
		deletespan.onclick = function() {
			deleteModal.style.display = "none";
			window.location.replace("Locations.php");
		}
		
		// When the user clicks anywhere outside of the modal, close it
		window.onclick = function(event) {
			if (event.target == addmodal) {
				addmodal.style.display = "none";
				window.location.replace("Locations.php");
			}
			else if (event.target == updateModal) {
				updateModal.style.display = "none";
				window.location.replace("Locations.php");
			}
			else if (event.target == deleteModal) {
				deleteModal.style.display = "none";
				window.location.replace("Locations.php");
			}
		} 
		