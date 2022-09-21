// Get the modal
var customerInsertModal = document.getElementById("CustomerModal");
var updateModal = document.getElementById("UpdateCustomerModal");
var deleteModal = document.getElementById("DeleteCustomerModal");

// Get the button that opens the modal
var btn = document.getElementById("CustomerPopUp");
var updateBtn = document.getElementsByClassName("UpdateCustomer");
var deleteBtn = document.getElementsByClassName("deleteCustomer");

// Get the close-btn <span> elements that closes the modal
var close_btns = document.getElementsByClassName("close-btn");
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

// When the user clicks on a close button (x), close the modal
for (let i = 0; i < close_btns.length; i++)
{
	close_btns[i].onclick = function()
	{
        customerInsertModal.style.display = "none";
        updateModal.style.display = "none";
        deleteModal.style.display = "none";
        window.location.replace("Customer.php");
        $_SESSION["ret"] = null;
	}
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

alignAddBtn();
function alignAddBtn()
{
    var headerWidth = document.getElementById('content-header').getBoundingClientRect().width;

    var addBtn = document.getElementById('CustomerPopUp');
    var addBtnInfo = addBtn.getBoundingClientRect();
    var btnWidth = addBtnInfo.width;

    var tableWidth = document.getElementById('data-table').getBoundingClientRect().width;

    var width = (tableWidth - headerWidth - btnWidth - 3) +  "px";

    addBtn.style.left = width;
}

window.addEventListener('resize', alignAddBtn);
