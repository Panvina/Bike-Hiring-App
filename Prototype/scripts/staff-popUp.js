// Get the modal
var staffInsertModal = document.getElementById("staffInsertModal");
var updateModal = document.getElementById("UpdateStaffModal");
var deleteModal = document.getElementById("DeleteStaffModal");

// Get the button that opens the modal
var insertBtn = document.getElementById("staffInsertPopUp");
var updateBtn = document.getElementsByClassName("UpdateButton");
var deleteBtn = document.getElementsByClassName("deleteButton");

// Get the <span> element that closes the modal
var staffInsertSpan = document.getElementsByClassName("Insertclose")[0];
var updateSpan = document.getElementsByClassName("updateFormClose")[0];
var deleteSpan = document.getElementsByClassName("closeDeleteForm")[0];
var noDeleteButton = document.getElementById("CancelDeleteCustomer");

// When the user clicks on the button, open the modal
insertBtn.onclick = function() {
    staffInsertModal.style.display = "block";
}

for (var i = 0; i < updateBtn.length; i++)
{
  updateBtn[i].onclick = function(event) {
    updateModal.style.display = "block";
  }
}

for (var i = 0; i < deleteBtn.length; i++)
{
  deleteBtn[i].onclick = function(event) {
    deleteModal.style.display = "block";
  }
}

// When the user clicks on <span> (x), close the modal
staffInsertSpan.onclick = function() {
  staffInsertModal.style.display = "none";
  window.location.replace("staff.php");
  $_SESSION["ret"] = null;
}

updateSpan.onclick = function() {
  updateModal.style.display = "none";
  window.location.replace("staff.php");
  $_SESSION["ret"] = null;
}

deleteSpan.onclick = function() {
  deleteModal.style.display = "none";
  window.location.replace("staff.php");
  $_SESSION["ret"] = null;
}



// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == staffInsertModal) {staffInsertSpan.onclick = function() {
    staffInsertModal.style.display = "none";
  window.location.replace("staff.php");
  $_SESSION["ret"] = null;
}
    staffInsertModal.style.display = "none";
    window.location.replace("staff.php");
  }
  else if(event.target == updateModal){
    updateModal.style.display = "none";
    window.location.replace("staff.php");
  }
  else if(event.target == deleteModal){
    deleteModal.style.display = "none";
    window.location.replace("staff.php");
  }
}