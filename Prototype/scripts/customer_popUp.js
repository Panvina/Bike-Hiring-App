// Get the modal
var modal = document.getElementById("CustomerModal");
var updateModal = document.getElementById("UpdateCustomerModal");


var tempEcho = document.getElementById("tempEcho");

// Get the button that opens the modal
var btn = document.getElementById("CustomerPopUp");
//var updateBtn = document.getElementById("UpdateCustomer");
var updateBtn = document.getElementsByClassName("UpdateCustomer");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
var updateSpan = document.getElementsByClassName("updateFormClose")[0];

// When the user clicks on the button, open the modal
btn.onclick = function() {
  modal.style.display = "block";
}

for (var i = 0; i < updateBtn.length; i++)
{
  updateBtn[i].onclick = function() {
    updateModal.style.display = "block";
  }
}


// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
  $_SESSION["ret"] = null;
}

updateSpan.onclick = function() {
  updateModal.style.display = "none";
  $_SESSION["ret"] = null;
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
  else if(event.target == updateModal){
    updateModal.style.display = "none";
  }
}

