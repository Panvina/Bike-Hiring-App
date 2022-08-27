<?php
    include "bookings-db.php";
?>

<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="style/Jake_style.css">
    <head>
        <!-- Header -->
        <title> Bookings </title>
        <h1 class="header"> <img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo"/> Bookings </h1>
    </head>
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
                    <?php
                        $cols = "Booking ID,Bike Name,Customer Name,Start Date,Start Time,End Date,End Time,Duration,Pick Up,Drop Off,Price";
                        $cols = explode(',', $cols);
                        $count = count($cols);
                        // print_r($cols);
                        // echo "<br>";
                        for($x = 0; $x < $count; $x++)
                        {
                            $col = trim($cols[$x]);
                            echo "<th> $col </th>";
                        }
                    ?>
                    <!-- <th> Booking Id </th>
                    <th> Bike Name </th>
                    <th> Customer Name </th>
                    <th> Phone Number </th>
                    <th> From </th>
                    <th> To </th>
                    <th> Duration </th>
                    <th> Pick-up-Location </th> -->
                </tr>
                <?php
                   $conn = new BookingsDBConnection();
                   $rows = $conn->getBookingRows();
                   if ($rows == null)
                   {
                       $rows = array();
                       $tmp = array();
                       for($x = 0; $x < count($cols); $x++)
                       {
                           array_push($tmp, "null");
                       }
                       array_push($rows, $tmp);
                   }

                   $keys = array_keys($rows[0]);
                   for($x = 0; $x < count($rows); $x++)
                   {
                       echo "<tr>";
                       for($y = 0; $y < count($keys); $y++)
                       {
                           $row = $rows[$x];
                           $key = $keys[$y];
                           $data = $row[$key];
                           echo "<td> $data </td>";
                       }
                       echo "</tr>";
                   }
                ?>
            </table>
        </div>

    </body>
</html>
