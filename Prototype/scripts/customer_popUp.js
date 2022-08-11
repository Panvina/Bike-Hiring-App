// Get modals
var login_modal = document.getElementById("login-overlay");
var create_account_modal = document.getElementById("create-account-overlay");

// Get popup buttons
var login_popup_button = document.getElementById("login-launch-btn");
var create_account_popup_button = document.getElementById("create-account-launch-btn");

var login_create_account_button = document.getElementById("login-create-account-btn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close-btn");

// When the user clicks the button, open the modal
login_popup_button.onclick = function()
{
	login_modal.style.display = "block";
}

create_account_popup_button.onclick = function()
{
	create_account_modal.style.display = "block";
}

login_create_account_button.onclick = function()
{
	login_modal.style.display = "none";
	create_account_modal.style.display = "block";
}

for (let i = 0; i < span.length; i++)
{
	// When the user clicks on <span> (x), close the modal
	span[i].onclick = function()
	{
		login_modal.style.display = "none";
		create_account_modal.style.display = "none";
	}
}
