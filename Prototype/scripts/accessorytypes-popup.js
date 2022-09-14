/* Reference = https://www.w3schools.com/howto/howto_css_modals.asp */
/* Code completed by Aadesh Jagannathan - 102072344*/

// Getting the modal for each Add, Create and Delete
var addPopup = document.getElementById("AddAccessoryModal");
var updatePopup = document.getElementById("UpdateAccessoryModal");
var deletePopup = document.getElementById("DeleteAccessoryModal");

// Getting the button for each modal
var addBtn = document.getElementById("AddItem");
var updateBtn = document.getElementsByClassName("UpdateItem");
var deleteBtn = document.getElementsByClassName("DeleteItem");

// Getting the close buttons for each modal
var closeBtn = document.getElementsByClassName("Insertclose")[0];
var updateCloseBtn = document.getElementsByClassName("updateFormClose")[0];
var deleteCloseBtn = document.getElementsByClassName("closeDeleteForm")[0];

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

// Closing the modals based on button click
closeBtn.onclick = function(){
    addPopup.style.display = "none";
    window.location.replace("AccessoryTypes.php");
    $_SESSION["ret"] = null;
}

updateCloseBtn.onclick = function(){
    updatePopup.style.display = "none";
    window.location.replace("AccessoryTypes.php");
    $_SESSION["ret"] = null;
  }

  deleteCloseBtn.onclick = function(){
    deletePopup.style.display = "none";
    window.location.replace("AccessoryTypes.php");
    $_SESSION["ret"] = null;
  }