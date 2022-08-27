// Get modals
var add_booking_main_modal = document.getElementById("add-booking-main-modal");
var add_booking_bikes_modal = document.getElementById("add-booking-bikes-modal");

// Get popup buttons
var add_booking_btn = document.getElementById("add-booking-btn");

// Get the close-btn <span> elements that closes the modal
var close_btns = document.getElementsByClassName("close-btn");

// show the main add booking modal
add_booking_btn.onclick = function()
{
	showModal(add_booking_main_modal);
	hideModal(add_booking_bikes_modal);
}

// When the user clicks on a close button (x), close the modal
for (let i = 0; i < close_btns.length; i++)
{
	close_btns[i].onclick = function()
	{
		hideModal(add_booking_main_modal);
		hideModal(add_booking_bikes_modal);
		window.location.replace("bookings.php");
	}
}

// Set display of a HTML element to block (visible)
function showModal(modalElement)
{
	modalElement.style.display = "block";
}

// Set display of a HTML element to none (hidden)
function hideModal(modalElement)
{
	modalElement.style.display = "none";
}
