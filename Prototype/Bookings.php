<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="style/Jake_style.css">
    <head>
        <!-- Header -->
        <title> Bookings </title>
        <h1 class="header"> <img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo"/> Bookings </h1>
    </head>
    <?php
        include "bookings-db.php";
    ?>
    <body>
        <!-- Side navigation -->
        <nav>
            <div class = "sideNavigation">
                <a href = "Dashboard.php"> <img src= "img/icons/bulletin-board.png" alt="Dashboard Logo" /> Dashboard </a> <br>
                <a href = "Customer.php"> <img src= "img/icons/account-group.png" alt="Customer Logo" />  Customer  </a> <br>
                <a href= "Inventory.php"> <img src= "img/icons/bicycle.png" alt="Inventory Logo" />  Inventory </a> <br>
                <a class="active" href= "Bookings.php"> <img src= "img/icons/book-open-blank-variant.png" alt="Bookings Logo" /> Bookings </a> <br>
                <a href= "Block_Out_Date.php"> <img src= "img/icons/calendar.png" alt="Block out date Logo" /> Block Out Dates </a> <br>
                <a href= "Locations.php"> <img src= "img/icons/earth.png" alt="Locations Logo" /> Locations </a> <br>
            </div>
         </nav>
         <!-- Block of content in center -->
         <div class="Content">
            <h1> All Bookings </h1>

            <!-- Search bar with icons -->
            <img src="img/icons/account-search.png" alt="Customer Search Logo"/>
            <input type="text"  placeholder="Search">

            <!-- Add Booking pop up -->
            <button type="button">+ Add Booking</button>

            <!-- List of available bookings -->
            <table class="TableContent">
                 <tr>
                     <th> Booking Id </th>
                     <th> Bike Name </th>
                     <th> Customer Name </th>
                     <th> Customer Number </th>
                     <th> From </th>
                     <th> To </th>
                     <th> Quantity </th>
                     <th> Duration </th>
                     <th> Pick-up-Location </th>
                 </tr>
                 <tr>
                     <td> 00001 </td>
                     <td> Outback wizard </td>
                     <td> John Stevenson </td>
                     <td> 5837 </td>
                     <td> 11:00AM </td>
                     <td> 4:00PM </td>
                     <td> 1 </td>
                     <td> 5 Hours </td>
                     <td> Inverloch Libary </td>
                 </tr>
            </table>
        </div>

    </body>
</html>
