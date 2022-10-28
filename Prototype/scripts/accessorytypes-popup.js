/* Reference = https://www.w3schools.com/howto/howto_css_modals.asp */

/* Code completed by Aadesh Jagannathan - 102072344*/
/* File contains all Accessory pop-up related JS functions  */

// Getting the modal for each Add, Create and Delete
var addPopup = document.getElementById("AddAccessoryModal");
var updatePopup = document.getElementById("UpdateAccessoryModal");
var deletePopup = document.getElementById("DeleteAccessoryModal");

// Getting the button for each modal
var addBtn = document.getElementById("AddItem");
var updateBtn = document.getElementsByClassName("UpdateItem");
var deleteBtn = document.getElementsByClassName("DeleteItem");

// Get the close-btn <span> elements that closes the modal
var close_btns = document.getElementsByClassName("close-btn");

// When the user clicks on a close button (x), close the modal
for (let i = 0; i < close_btns.length; i++)
{
	close_btns[i].onclick = function()
	{
        addPopup.style.display = "none";
        updatePopup.style.display = "none";
        deletePopup.style.display = "none";
        window.location.replace("AccessoryTypes.php");
        $_SESSION["ret"] = null;
	}
}

alignAddBtn();
function alignAddBtn()
{
    var headerWidth = document.getElementById('content-header').getBoundingClientRect().width;

    var addBtn = document.getElementById('AddItem');
    var addBtnInfo = addBtn.getBoundingClientRect();
    var btnWidth = addBtnInfo.width;

    var tableWidth = document.getElementById('data-table').getBoundingClientRect().width;

    var width = (tableWidth - headerWidth - btnWidth - 3) +  "px";

    addBtn.style.left = width;
}

window.addEventListener('resize', alignAddBtn);

// Opening the modals based on button click
addBtn.onclick = function(){
    addPopup.style.display="block";
}

for (var i = 0; i < updateBtn.length; i++)
{
  updateBtn[i].onclick = function(event) {
    updatePopup.style.display = "block";
  }
}

for (var i = 0; i < deleteBtn.length; i++)
{
  deleteBtn[i].onclick = function(event) {
    deletePopup.style.display = "block";
  }
}
