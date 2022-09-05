// Get the modal
var customerInsertModal = document.getElementById("CustomerModal");
var updateModal = document.getElementById("UpdateCustomerModal");
var deleteModal = document.getElementById("DeleteCustomerModal");

// Get the button that opens the modal
var btn = document.getElementById("CustomerPopUp");
var updateBtn = document.getElementsByClassName("UpdateCustomer");
var deleteBtn = document.getElementsByClassName("deleteCustomer");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("Insertclose")[0];
var updateSpan = document.getElementsByClassName("updateFormClose")[0];
var deleteSpan = document.getElementsByClassName("closeDeleteForm")[0];
var noDeleteButton = document.getElementById("CancelDeleteCustomer");

// When the user clicks on the button, open the modal
btn.onclick = function() {
  customerInsertModal.style.display = "block";
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
span.onclick = function() {
  customerInsertModal.style.display = "none";
  window.location.replace("Customer.php");
  $_SESSION["ret"] = null;
}

updateSpan.onclick = function() {
  updateModal.style.display = "none";
  window.location.replace("Customer.php");
  $_SESSION["ret"] = null;
}

deleteSpan.onclick = function() {
  deleteModal.style.display = "none";
  window.location.replace("Customer.php");
  $_SESSION["ret"] = null;
}



// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == customerInsertModal) {span.onclick = function() {
    customerInsertModal.style.display = "none";
  window.location.replace("Customer.php");
  $_SESSION["ret"] = null;
}
    customerInsertModal.style.display = "none";
    window.location.replace("Customer.php");
  }
  else if(event.target == updateModal){
    updateModal.style.display = "none";
    window.location.replace("Customer.php");
  }
  else if(event.target == deleteModal){
    deleteModal.style.display = "none";
    window.location.replace("Customer.php");
  }
}
