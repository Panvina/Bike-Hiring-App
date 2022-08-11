<?php
    class DBConnection
    {
        private $conn = null;

        public function __construct($servername, $username, $password, $dbname)
        {
            $this->conn = new mysqli($servername, $username, $password, $dbname);
        }


    }

?>


<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="style/Jake_style.css">
    <head>
        <title> Customers </title>
        <h1 class="header"> <img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo"/> Customers </h1>
    </head>
    <body>
        <nav>
            <div class = "sideNavigation">
                <a href = "Dashboard.php"> <img src= "img/icons/bulletin-board.png" alt="Dashboard Logo" /> Dashboard </a> <br>
                <a class="active" href = "Customer.php"> <img src= "img/icons/account-group.png" alt="Customer Logo" />  Customer  </a> <br>
                <a href= "Inventory.php"> <img src= "img/icons/bicycle.png" alt="Inventory Logo" />  Inventory </a> <br>
                <a href= "Bookings.php"> <img src= "img/icons/book-open-blank-variant.png" alt="Bookings Logo" /> Bookings </a> <br>
                <a href= "Block_Out_Date.php"> <img src= "img/icons/calendar.png" alt="Block out date Logo" /> Block Out Dates </a> <br>
                <a href= "Locations.php"> <img src= "img/icons/earth.png" alt="Locations Logo" /> Locations </a> <br>
            </div>
         </nav>

         <div class="Content">
           <h1> All Customers</h1>
           <img src="img/icons/account-search.png" alt="Customer Search Logo"/>
           <input type="text"  placeholder="Search">
           <button type="button">+ New Customer</button> 
           <table class="TableContent">
                <tr>
                    <th> Name </th>
                    <th> Phone Number </th>
                    <th> Email </th>
                    <th> Address </th>
                    <th> Licence Number </th>
                    <th> Username </th>
                </tr>
                <tr>
                    <td> John Smith </td>
                    <td> 012345678 </td>
                    <td> JohnSmith@gmail.com </td>
                    <td> Johns Address </td>
                    <td> 0123456 </td>
                    <td> JohhnySmithy </td>
                </tr>
           </table>
        </div>

    </body>
</html>