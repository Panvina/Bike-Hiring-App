<?php
/* Reference = https://www.w3schools.com/howto/howto_css_modals.asp */
/* Code completed by Aadesh Jagannathan - 102072344*/
/* Styling reused from Jake's dashboard pages*/

// Enabling session
session_start();

// Setting the timezone to local timezone to compare booking availabilities
date_default_timezone_set('Australia/Melbourne');

//Linking utility functions associated with inventory
include("php-scripts/inventory-util.php");

//enabling the user privilege of certain tabs. Added by Vina Touch 101928802
include_once "user-privilege.php";

//Establishing database connection using mysqli()
$conn = new mysqli("localhost", "root", "", "bike_hiring_system");
?>

<!DOCTYPE html>
<html>
<!-- Styling reused from Jake's dashboard pages -->
<link rel="stylesheet" href="style/Jake_style.css">

<head>
    <!-- header -->
    <title> Inventory </title>
    <h1 class="header"> <a href="index.php"><img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo" /></a> Inventory </h1>
</head>

<body>
    <?php
    //Prints message based on success of record insertion
    if (isset($_GET["insert"])) {
        if ($_GET["insert"] == "true") {
            echo "<p class = 'echo' id='tempEcho'>  Record successfully created! </p>";
        } else if ($_GET["insert"] == "false") {
            echo "<p class = 'echo'>  Record was not created successfully! </p>";
        }
    }

    //Prints message based on success of record updation
    if (isset($_GET["update"])) {
        if ($_GET["update"] == "true") {
            echo "<p class = 'echo' id='tempEcho'>  Record successfully updated! </p>";
        } else if ($_GET["update"] == "false") {
            echo "<p class = 'echo' id='tempEcho'> Record was not updated successfuly </p>";
        }
    }

    //Prints message based on success of record deletion
    if (isset($_GET["delete"])) {
        if ($_GET["delete"] == "true") {
            echo "<p class = 'echo' id='tempEcho'>  Record successfully deleted! </p>";
        } else if ($_GET["delete"] == "false") {
            echo "<p class = 'echo' id='tempEcho'> Record was not deleted successfully! </p>";
        }
    }
    ?>

    <!-- Side navigation -->
    <nav>
        <div class="sideNavigation">
            <a href= "Dashboard.php"> <img src= "img/icons/bulletin-board.png" alt="Dashboard Logo" /> Dashboard </a> <br>
            <a href = "Customer.php"> <img src= "img/icons/account-group.png" alt="Customer Logo" />  Customer  </a> <br>
            <?php setOwnerDashboardPrivilege(); ?>
            <!--<a href="accounts.php"> <img src="img/icons/account.png" alt="Account logo"/> Accounts </a> <br>-->
            <a class="active" href= "Inventory.php"> <img src= "img/icons/bicycle.png" alt="Inventory Logo" />  Inventory </a> <br>
            <a href="Accessory.php"> <img src="img/icons/accessories.png" alt="Inventory Logo" /> Accessories </a> <br>
            <a href="BikeTypes.php"> <img src="img/icons/biketypes.png" alt="Bike Types Logo" /> Bike Types </a> <br>
            <a href="AccessoryTypes.php"> <img src="img/icons/accessorytypes.png" alt="Bike Types Logo" /> Accessory Types </a> <br>
            <a href= "bookings.php"> <img src= "img/icons/book-open-blank-variant.png" alt="Bookings Logo" /> Bookings </a> <br>
            <a href= "Block_Out_Date.php"> <img src= "img/icons/calendar.png" alt="Block out date Logo" /> Block Out Dates </a> <br>
            <a href= "Locations.php"> <img src= "img/icons/earth.png" alt="Locations Logo" /> Locations </a> <br>
            <a href= "editpages.php"> <img src= "img/icons/bulletin-board.png" alt="Edit Pages Logo" /> Edit </a> <br>
            <?php setLogoutButton()?>
        </div>
    </nav>

    <!-- Block of content in center -->
    <div class="Content">
        <h1> All Items </h1>

        <!-- Add Item pop up -->
        <button type="button" id="addItem">+ Add Bike</button>

        <!-- List of available bookings -->
        <table class="TableContent">
            <?php
            // Fetching all column data from the bike inventory table
            $bikeInventory = $conn->query("SELECT * FROM bike_inventory_table");

            // Printing heading of all table columns
            echo "
                    <tr>
                        <th> Bike ID </th>
                        <th> Bike Name </th>
                        <th> Bike Type </th>
                        <th> Bike Price ($ p/h)</th>
                        <th> Bike Status </th>
                        <th> Safety Check </th>
                        <th> Description </th>
                        <th> Action </th>
                    </tr>";

            // Printing data of all table columns by fetching from database
            while ($row = $bikeInventory->fetch_assoc()) {
                // Print Safety Inspection based on 0 or 1 values        
                $safetyStatus = safety_check($row["safety_inspect"]);

                // Fetching bike type data from the bike_type_table
                $biketype = $row["bike_type_id"];
                $bikeTypeInventory = $conn->query("SELECT name FROM bike_type_table WHERE bike_type_id=$biketype")->fetch_assoc();
                
                // Booking availbility check for bikes using custom utility functions
                $bookingStatus = bike_availability_check($row["bike_id"]);

                //Set the availability status colour based on the availability status
                $availabilityStatusColour = "#000000";
                $availabilityStatusColour = availabilityStatusColour($bookingStatus);

                //Set the availability status colour based on the availability status
                $safetyStatusColour = "#000000";
                $safetyStatusColour = safetyStatusColour($safetyStatus);
                
                // Setting the primary key value based on table's primary key
                $primaryKey = $row["bike_id"];
                $_SESSION["primaryKey"] = $primaryKey;
                
            ?>
                <tr>
                    <td><?php echo $row["bike_id"]; ?></td>
                    <td><?php echo $row["name"]; ?></td>
                    <td><?php echo $bikeTypeInventory["name"]; ?></td>
                    <td><?php echo $row["price_ph"]; ?></td>
                    <?php echo "<td style=\"background-color:$availabilityStatusColour\"> <span style=\"font-weight:bold\">$bookingStatus</span></td>";?>
                    <?php echo "<td style=\"background-color:$safetyStatusColour\"> <span style=\"font-weight:bold\">$safetyStatus</span></td>";?>
                    <td><?php echo $row["description"]; ?></td>
                   <!--  <td>
                        <a href="inventory-process.php?delete=<//?php echo $row["bike_id"]; ?>">Delete</a>
                    </td> -->
                    <td>
                        <!--Buttons added to the table to update and delete records-->
                        <?php
                        echo "
                        <div class='dropdown'>
                        <button class='dropbtn' disabled>...</button>
                            <div class='dropdown-content'>
                            <!-- Yes or No selection as dropdown for safety check -->
                            <form action='inventory-updatescript.php' method='POST' event.preventDefault() > <button type='submit' id= '$primaryKey' class='UpdateItem' name='updateItem' 
                                value='$primaryKey'> Update </button> </form>
                            <form action='inventory-deletescript.php' method='POST' event.preventDefault()> <button type='submit' id='$primaryKey' name='deleteItem' class='DeleteItem' 
                                value = '$primaryKey'> Delete </button> </form>
                             </div>
                        </div>";
                        ?>
                    </td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>

    <?php
    /*Retreiving accessory data to display in the form*/
    $accessoryId = $conn->query("SELECT * FROM accessory_inventory_table");
    if ($accessoryId->num_rows > 0) {
        $bikeAccessoryOption = mysqli_fetch_all($accessoryId, MYSQLI_ASSOC);
    }
    /*Retreiving bike type data to display in the form*/
    $bikeType = $conn->query("SELECT * FROM bike_type_table");
    if ($bikeType->num_rows > 0) {
        $bikeTypeOption = mysqli_fetch_all($bikeType, MYSQLI_ASSOC);
    }
    ?>
    <!-- Modal to add inventory records -->
    <div id="AddInventoryModal" class="modal"<?php
            // Ensures modal stays open when "insert" is set to print errors
            if(isset($_GET["insert"]))
            {
                if ($_GET["insert"] != "true")
                {
                    echo "style = 'display:inline-block'";
                }
                else if($_GET["insert"] == "true")
                {
                    echo "style = 'display:none'";
                }
            }
        ?>>
        <!-- Content within popup -->
        <div class="modal-content">
            <span class="Insertclose">&times;</span>
            <form action="inventory-addscript.php" method="post">
                <div>
                <span class="error"> 
                        <?php 
                            if (isset($_GET["insert"]))
                            {
                                if ($_GET["insert"] == "empty")
                                {
                                    echo '<p class = "error">* Please enter data in the fields!</p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <!-- <h2>Bike ID</h2> -->
                    <input placeholder="ID of the Bike..." type="hidden" name="bikeId">
                </div>

                <div>
                    <h2>Name</h2>
                    <input placeholder="Bike's name..." type="text" name="name">
                    <span class="error"> 
                        <?php 
                            if (isset($_GET["insert"]))
                            {
                                $name = $_GET["insert"];
                                if ($name == "emptyName")
                                {
                                    echo '<p class = "error">* Please fill the name field!</p>';
                                }
                                else if ($name == "invalidName")
                                {
                                    echo '<p class = "error">* Name has to only contain alphabets! </p>';
                                }
                            }
                        ?>
                    </span>
                </div>

                <div>
                    <!-- Bike type options displayed as a dropdown by fetching from bike type table in db-->
                    <h2>Bike Type ID</h2>
                    <select placeholder="Bike's Type..." name="bikeTypeId" type="submit">
                        <option value ="">Select bike type</option>
                        <?php
                        foreach ($bikeTypeOption as $option) {
                        ?>
                            <option><?php echo $option['bike_type_id'];
                                    echo "-";
                                    echo  $option['name']; ?> </option>
                        <?php
                        }
                        ?>
                    </select>
                    <span class="error"> 
                        <?php 
                            if (isset($_GET["insert"]))
                            {
                                $bikeTypeId = $_GET["insert"];
                                if ($bikeTypeId == "emptyType")
                                {
                                    echo '<p class = "error">* Please select a bike type!</p>';
                                }
                            }
                        ?>
                    </span>
                </div>

                <div>
                    <!-- Helmet options displayed as a dropdown by fetching from accessory type table in db-->
                    <h2>Helmet ID</h2>
                    <select placeholder="Helmet's ID..." name="helmetId" type="submit">
                        <option value ="">Select helmet</option>
                        <?php
                        foreach ($bikeAccessoryOption as $option) {
                        ?>
                            <option><?php echo $option['accessory_id'];
                                    echo "-";
                                    echo  $option['name']; ?> </option>
                        <?php
                        }
                        ?>
                    </select>
                    <span class="error"> 
                        <?php 
                            if (isset($_GET["insert"]))
                            {
                                $helmetId = $_GET["insert"];
                                if ($helmetId == "emptyHelmet")
                                {
                                    echo '<p class = "error">* Please select a helmet!</p>';
                                }
                            }
                        ?>
                    </span>
                </div>

                <div>
                    <h2>Price p/h</h2>
                    <input placeholder="Price per hour..." type="text" name="price">
                    <span class="error">
                    <?php 
                            if (isset($_GET["insert"]))
                            {
                                $price = $_GET["insert"];
                                if ($price == "emptyPrice")
                                {
                                    echo '<p class = "error">* Please fill the price field!</p>';
                                }
                                else if ($price == "invalidPrice")
                                {
                                    echo '<p class = "error">* Price can only contain integers or decimals! </p>';
                                }
                            }
                     ?>
                    <span>
                </div>

                <!-- <div>
                    <h2>Safety Inspect</h2>
                    <select placeholder="Safety status..." name="safetyInspect" type="submit">
                        <option>Inspection status</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div> -->

                <div>
                    <h2>Safety Status</h2>
                    <label class="switch"  style='left: 10px; bottom:5px;' >
                    <input type="hidden" name="safetyInspect" value="0">
                    <input type="checkbox" name="safetyInspect" value="1">
                    <span class="slider round"></span>
                    </label>
                </div>

                <div>
                    <h2>Description</h2>
                    <textarea placeholder="Description about the bike..." name="description"></textarea>
                </div>
                <span class="error"> 
                        <?php 
                            if (isset($_GET["insert"]))
                            {
                                $description = $_GET["insert"];
                                if ($description == "emptyDescription")
                                {
                                    echo '<p class = "error">* Please fill the description field!</p>';
                                }
                            }
                        ?>
                </span>

                <div>
                    <button type="submit" name="AddItem">Add Bike</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal to update inventory records -->
    <div id="UpdateInventoryModal" class="modal" <?php

                                                    if (isset($_GET["update"])) {
                                                        if ($_GET["update"] != "true") {
                                                            echo "style = 'display:inline-block;'";
                                                        } else if ($_GET["update"] == "true") {
                                                            echo "style = 'display:none;'";
                                                        }
                                                    }
                                                    ?>>
        <!-- Content within popup -->
        <div class="modal-content">
            <span class="updateFormClose">&times;</span>
            <form action="inventory-updatescript.php" method="post" event.preventDefault()>
                <div>
                <span class="error"> 
                        <?php 
                            if (isset($_GET["update"]))
                            {
                                if ($_GET["update"] == "empty")
                                {
                                    echo '<p class = "error">* Please enter data in the fields!</p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <h2>BikeID</h2>
                    <input placeholder="ID of the Bike..." type="text" name="bikeId" readonly value="<?php echo $_SESSION['bike_id'] ?>">
                </div>

                <div>
                    <h2>Name</h2>
                    <input placeholder="Bike's name..." type="text" name="name" value="<?php echo $_SESSION['name'] ?>">
                    <span class="error"> 
                        <?php 
                            if (isset($_GET["update"]))
                            {
                                $name = $_GET["update"];
                                if ($name == "emptyName")
                                {
                                    echo '<p class = "error">* Please fill the name field!</p>';
                                }
                                else if ($name == "invalidName")
                                {
                                    echo '<p class = "error">* Name has to only contain alphabets! </p>';
                                }
                            }
                        ?>
                    </span>
                </div>

                <div>
                    <!-- Bike type options displayed as a dropdown by fetching from bike type table in db-->
                    <h2>BikeTypeID</h2>
                    <select placeholder="Bike's Type..." name="bikeTypeId" type="submit" value="<?php echo $_SESSION['bike_type_id'] ?>">
                        <option selected=selected><?php echo $_SESSION['bike_type_id'] ?></option>
                        <?php
                        foreach ($bikeTypeOption as $option) {
                        ?>
                            <option><?php echo $option['bike_type_id'];
                                    echo "-";
                                    echo  $option['name']; ?> </option>
                        <?php
                        }
                        ?>
                    </select>
                    <span class="error"> 
                        <?php 
                            if (isset($_GET["update"]))
                            {
                                $bikeTypeId = $_GET["update"];
                                if ($bikeTypeId == "emptyType")
                                {
                                    echo '<p class = "error">* Please select a bike type!</p>';
                                }
                            }
                        ?>
                    </span>
                </div>

                <div>
                    <!-- Helmet options displayed as a dropdown by fetching from accessory type table in db-->
                    <h2>HelmetID</h2>
                    <select placeholder="Helmet's ID..." name="helmetId" type="submit" value="<?php echo $_SESSION['helmet_id'] ?>">
                        <option selected=selected><?php echo $_SESSION['helmet_id'] ?></option>
                        <?php
                        foreach ($bikeAccessoryOption as $option) {
                        ?>
                            <option><?php echo $option['accessory_type_id'];
                                    echo "-";
                                    echo  $option['name']; ?> </option>
                        <?php
                        }
                        ?>
                    </select>
                    <span class="error"> 
                        <?php 
                            if (isset($_GET["update"]))
                            {
                                $helmetId = $_GET["update"];
                                if ($helmetId == "emptyHelmet")
                                {
                                    echo '<p class = "error">* Please select a helmet!</p>';
                                }
                            }
                        ?>
                    </span>
                </div>

                <div>
                    <h2>Price p/h</h2>
                    <input placeholder="Price per hour..." type="text" name="price" value="<?php echo $_SESSION['price_ph'] ?>">
                    <span class="error">
                    <?php 
                            if (isset($_GET["update"]))
                            {
                                $price = $_GET["update"];
                                if ($price == "emptyPrice")
                                {
                                    echo '<p class = "error">* Please fill the price field!</p>';
                                }
                                else if ($price == "invalidPrice")
                                {
                                    echo '<p class = "error">* Price can only contain integers or decimals! </p>';
                                }
                            }
                     ?>
                    <span>
                </div>

                <!-- <div>  
                    <h2>Safety Inspect</h2>
                    <select placeholder="Safety status..." name="safetyInspect" type="text" value="<//?php echo $_SESSION['safety_inspect'] ?>">
                        <option selected=selected><//?php echo safety_check($_SESSION['safety_inspect']); ?></option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>-->

                <!-- Yes or No selection as dropdown for safety check -->
                <div>
                    <h2>Safety Status</h2>
                    <label class="switch"  style='left: 10px; bottom:5px;' >
                    <input type="hidden" name="safetyInspect" value="0">
                    <input type="checkbox" name="safetyInspect" value="1" <?php echo ($_SESSION['safety_inspect']==1 ? 'checked' : '');?>>
                    <span class="slider round"></span>
                    </label>
                </div>            

                <div>
                    <h2>Description</h2>
                    <textarea iplaceholder="Description about the bike..." name="description"><?php echo $_SESSION['description'] ?></textarea>
                <span class="error"> 
                        <?php 
                            if (isset($_GET["update"]))
                            {
                                $description = $_GET["update"];
                                if ($description == "emptyDescription")
                                {
                                    echo '<p class = "error">* Please fill the description field!</p>';
                                }
                            }
                        ?>
                </span>
                </div>

                <div>
                    <button type="submit" name="submitUpdateItem">Update Item</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal to delete inventory records -->
    <div id="DeleteInventoryModal" class="modal" <?php

                                                    if (isset($_GET["delete"])) {
                                                        if ($_GET["delete"] != "true") {
                                                            echo "style = 'display:inline-block;'";
                                                        } else if ($_GET["delete"] == "true") {
                                                            echo "style = 'display:none;'";
                                                        }
                                                    }
                                                    ?>>
        <div class="modal-content">
            <span class="closeDeleteForm">&times;</span>
            <h1 style="left: -8%; position: relative;"> Do you wish to delete the item? </h1>
            <form action="inventory-deletescript.php" method="post" event.preventDefault()>
                <div>
                    <h2>BikeID</h2>
                    <?php
                    $primaryKey = $_SESSION["bike_id"];
                    echo "<h1 style='left: 25%; position: relative;'> $primaryKey </h1>";
                    echo "<form action='inventory-deletescript.php' method='POST' event.preventDefault()>
                      <button style='width: 40%; left: -10%; position: relative;' type='submit' id='$primaryKey' value ='$primaryKey' name='submitDeleteItem'>Yes</button>
                      <button style='width: 40%; left: -10%; position: relative; background-color: red;' type='submit' name='cancelDeleteItem'>No</button> </form>";
                    ?>
            </form>
        </div>
    </div>
</body>
<!--Script responsible for the popup functionality is linked-->
<script src="scripts/inventory-popup.js"></script>

</html>