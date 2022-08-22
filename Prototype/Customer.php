<?php
    session_start();
    //connection to the database
    include("backend-connection.php");
    $conn = new DBConnection("localhost", "root", "", "bike_hiring_system");

   

   // $sqlQry = "INSERT INTO customer_table VALUES $name, $phoneNumber, $email, $streetAdress, $suburb, $postCode, $licenceNumber";

    //$conn->insert("customer_table", "Name, Phone Number, Email, Street Address, Suburb, Post Code, Licence Number" , "$name, $phoneNumber, $email, $streetAdress, $suburb, $postCode, $licenceNumber");

    //$conn->insert("bike_type_table", "Name, Description", "'Hydro', 'Non-existent'");

    //if ($conn->query($sqlQry) === TRUE) {
       // echo "New record created successfully";
     //} else {
      //  echo "Error: " . $sql . "<br>" . $conn->error;
    // }
    
?>


<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="style/Jake_style.css">
    <head>
        <!-- Header -->
        <title> Customers </title>
        <h1 class="header"> <img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo"/> Customers </h1>
    </head>
    <body>
        <!-- Side navigation -->
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

         
         <!-- Block of content in center -->
         <div class="Content">
           <h1> All Customers</h1>

           <!-- Search bar with icons --> 
           <img src="img/icons/account-search.png" alt="Customer Search Logo"/>
           <input type="text"  placeholder="Search">

            <!-- Add Customer pop up -->
           <button id="CustomerPopUp">+ New Customer</button>

           <!-- List of current customers -->
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

        <!-- Create the initial window for the pop up -->
        <div id="CustomerModal" class="modal">

            <!-- Creates the content within the pop up -->
            <div class ="modal-content">
                <span class="close">&times;</span>
                <form action="customer-script.php" method="get" event.preventDefault()>
                    <h1> Create a customer </h1>
                    <div>
                        <h2> Name: </h2>
                        <input type="text" name="name">
                    </div>
                    <div>
                        <h2> Phone Number: </h2>
                        <input type="text" name="phoneNumber">'
                    </div>
                    <div>
                        <h2> Email: </h2>
                        <input type="text" name="email">
                    </div>
                    <div>
                        <h2> Street Address </h2>
                        <input type="text" name="streetAddress">
                    </div>
                    <div>
                        <h2> Suburb </h2>
                        <input type="text" name="suburb">
                    </div>
                    <div>
                        <h2> Post Code </h2>
                        <input type="text" name="postCode">
                    </div>
                    <div>
                        <h2> Licence Number </h2>
                        <input type="text"name="licenceNumber">
                    </div>
                    </br>
                    <div>
                        <button type= "submit" name="SubmitCustomer" >Submit</button>
                    </div>
                </form>
            </div>
        </div>

        
    </body>
</html>
<!-- Link the js file needed for pop up -->
<script src="scripts/customer_popup.js"></script>

<?php

    if (isset($_SESSION["ret"]))
    {
        if ($_SESSION["ret"] == "true")
        {
            echo "<p style = 'color: red; font-size: 25px;display:block;margin-left: 45%; position: fixed; z-index: 1; left: 0; top: 0; padding-top: 5%;'> Record successfuly created </p>";
            $_SESSION["ret"] = null;
        }
        else if ($_SESSION["ret"] == "false")
        {
            echo "<p style = 'color: red; font-size: 25px;display:block;margin-left: 45%; position: fixed; z-index: 1; left: 0; top: 0; padding-top: 5%;'>  Unable to insert record </p>";
            $_SESSION["ret"] = null;
        }
    }
   
?>