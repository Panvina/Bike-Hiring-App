<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="style/Jake_style.css">
    <head>
        <!-- header -->
        <title> Inventory </title>
        <h1 class="header"> <img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo"/> Inventory </h1>
    </head>
    <?php
    /*
    include 'backend-connection.php';
    
    $conn = new DBConnection("localhost", "root", "", "bike_hiring_system");

    if(!$conn){
        echo 'Connection error: ' . mysqli_connect_error();
    }

    else{
        echo 'SUCCESS';
    }
    */?>
    <body>
        <!-- Side navigation -->
        <nav>
            <div class = "sideNavigation">
                <a href = "Dashboard.php"> <img src= "img/icons/bulletin-board.png" alt="Dashboard Logo" /> Dashboard </a> <br>
                <a href = "Customer.php"> <img src= "img/icons/account-group.png" alt="Customer Logo" />  Customer  </a> <br>
                <a class="active" href= "Inventory.php"> <img src= "img/icons/bicycle.png" alt="Inventory Logo" />  Inventory </a> <br>
                <a href= "Bookings.php"> <img src= "img/icons/book-open-blank-variant.png" alt="Bookings Logo" /> Bookings </a> <br>
                <a href= "Block_Out_Date.php"> <img src= "img/icons/calendar.png" alt="Block out date Logo" /> Block Out Dates </a> <br>
                <a href= "Locations.php"> <img src= "img/icons/earth.png" alt="Locations Logo" /> Locations </a> <br>
            </div>
         </nav>
         
         <!-- Block of content in center -->
         <div class="Content">
            <h1> All Items </h1>

            <!-- Search bar with icons -->
            <img src="img/icons/magnify.png" alt="Search Logo"/>
            <input type="text"  placeholder="Search">

            <!-- Add Item pop up -->
            <button type="button">+ Add Item</button> 

            <!-- Filter information pop up -->
            <button type="button">Filter:</button> 

            <!-- List of available bookings -->
            <table class="TableContent">
                <?php
                echo "
                <tr>
                    <th> Item ID </th>
                    <th> Item Name </th> 
                    <th> Item Type </th>
                    <th> Item Status </th>
                    <th> Safety Check </th>
                    <th> Description </th>
                </tr>
                <tr>
                    <td> 0001 </td>
                    <td> First bike </td>
                    <td> Road bike </td>
                    <td> Available </td>
                    <td> Checked </td>
                    <td> Perfect bike to be used for your first time </td>
                </tr>";

                include 'backend-connection.php';
                    $conn = new mysqli("localhost", "root", "", "bike_hiring_system");
                    $sql = "SELECT * FROM bike_inventory_table";
                    $result = $conn->query($sql);
                    
                    echo"
                    <tr>
                            <th> Item ID </th>
                            <th> Item Name </th> 
                            <th> Item Type </th>
                            <th> Item Status </th>
                            <th> Safety Check </th>
                            <th> Description </th>
                    </tr>";
                        
                    while($row = $result->fetch_assoc()){   
                        // Print Safety Inspection based on 0 or 1 values        
                        if($row["Safety Inspect"] == 1 ){
                            $row["Safety Inspect"] = "Yes";
                        }
                        else{
                            $row["Safety Inspect"] = "No";
                        }

                        switch($row["BikeTypeID"]){
                            case 1:
                                $row["BikeTypeID"] = "Helmet";
                                break;
                            case 2:
                                $row["BikeTypeID"] = "Carrier";
                                break;
                            default:
                                $row["BikeTypeID"] = "Unknown";

                        }
                    

                        echo "
                        <tr>
                            <td>" . $row["BikeID"] . "</td>
                            <td>" . $row["Name"] . "</td>
                            <td>" . $row["BikeTypeID"] . "</td>
                            <td>" . $row["Safety Inspect"] . "</td>
                            <td>" . $row["Safety Inspect"] . "</td>
                            <td>" . $row["Description"] . "</td>
                        </tr>";

                    }
                ?>  
           </table>
        </div>

    </body>
</html>