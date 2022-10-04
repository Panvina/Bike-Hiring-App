///
/// Project Name: Inverloch Bike Hire
/// Project Description: A website for hiring bikes. Front-end accompanied
///		by an admin dashboard.
/// File Description: Javascript implementation for admin dashboard bookings page.
/// Contributor(s): Dabin Lee @ icelasersparr@gmail.com
///

/**
 * All bookings in bookings.js consist of two parts.
 * 1. Select dates and other non-bike/accessory information
 * 2. Select bikes and accessories for given days
 */

// Get modals
var add_booking_main_modal = document.getElementById("add-booking-main-modal");
var add_booking_bikes_modal = document.getElementById("add-booking-bikes-modal");

var change_booking_main_modal = document.getElementById("change-booking-main-modal");
var change_booking_bikes_modal = document.getElementById("change-booking-bikes-modal");

// Get popup buttons
var add_booking_btn = document.getElementById("add-booking-btn");
var change_booking_btn = document.getElementById("change-booking-btn");

// Get the close-btn <span> elements that closes the modal
var close_btns = document.getElementsByClassName("close-btn");

// show the main add booking modal
add_booking_btn.onclick = function()
{
	showModal(add_booking_main_modal);
	hideModal(add_booking_bikes_modal);
}

// // show main change booking modal
// change_booking_btn.onclick = function()
// {
// 	showModal(change_booking_main_modal);
// 	hideModal(change_booking_bikes_modal);
// }

// When the user clicks on a close button (x), close the modal
for (let i = 0; i < close_btns.length; i++)
{
	close_btns[i].onclick = function()
	{
		hideModal(add_booking_main_modal);
		hideModal(add_booking_bikes_modal);
        hideModal(change_booking_main_modal);
        hideModal(change_booking_bikes_modal);
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
//
// alignAddBtn();
// function alignAddBtn()
// {
//     var headerWidth = document.getElementById('content-header').getBoundingClientRect().width;
//
//     var addBtn = document.getElementById('add-booking-btn');
//     var addBtnInfo = addBtn.getBoundingClientRect();
//     var btnWidth = addBtnInfo.width;
//
//     var tableWidth = document.getElementById('data-table').getBoundingClientRect().width;
//
//     var width = (tableWidth - headerWidth - btnWidth - 3) +  "px";
//
//     addBtn.style.left = width;
// }
//
// window.addEventListener('resize', alignAddBtn);
