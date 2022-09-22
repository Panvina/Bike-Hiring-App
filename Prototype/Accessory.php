<?php
session_start();

//enabling the user privilege of certain tabs. Added by Vina Touch 101928802
include_once "user-privilege.php";

date_default_timezone_set('Australia/Melbourne');

include_once("php-scripts/backend-connection.php");


//Linking utility functions associated with inventory
include("php-scripts/inventory-util.php");



//Establishing database connection using mysqli()
$conn = new mysqli("localhost", "root", "", "bike_hiring_system");
?>

<html>
    <link rel="stylesheet" href="style/dashboard-style.css">
    <link rel="stylesheet" href="style/popup.css">
    <head>
        <!-- header -->
        <title> Accessories </title>
        <h1 class="header"> <a href="index.php"><img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo" /></a> Accessories </h1>
    </head>

    <body>
        <?php
            //checks to see if inserting was successful and provides input
            if (isset($_GET["insert"])) {
                if ($_GET["insert"] == "true") {
                    echo "<p class = 'echo' id='tempEcho'>  Record successfully created! </p>";
                } else if ($_GET["insert"] == "false") {
                    echo "<p class = 'echo'>  Record was not created successfully! </p>";
                }
            }

            //checks to see if updating was successful and provides input
            if (isset($_GET["update"])) {
                if ($_GET["update"] == "true") {
                    echo "<p class = 'echo' id='tempEcho'>  Record successfully updated! </p>";
                } else if ($_GET["update"] == "false") {
                    echo "<p class = 'echo' id='tempEcho'> Record was not updated successfuly </p>";
                }
            }

            //checks to see if deleting was successful and provides input
            if (isset($_GET["delete"])) {
                if ($_GET["delete"] == "true") {
                    echo "<p class = 'echo' id='tempEcho'>  Record successfully deleted! </p>";
                } else if ($_GET["delete"] == "cancel") {
                    echo "<p class = 'echo' id='tempEcho'> Record was not deleted successfully! </p>";
                }
            }
        ?>

        <div class="grid-container">
        	<div class="menu">
        		<a href= "Dashboard.php"> <img src= "img/icons/bulletin-board.png" alt="Dashboard Logo" /> Dashboard </a> <br>
        		<a href = "Customer.php"> <img src= "img/icons/account-group.png" alt="Customer Logo" />  Customer  </a> <br>
        		<?php setOwnerDashboardPrivilege(); ?>
        		<a href= "Inventory.php"> <img src= "img/icons/bicycle.png" alt="Inventory Logo" />  Inventory </a> <br>
        		<a class="active"  href="Accessory.php"> <img src="img/icons/accessories.png" alt="Inventory Logo" /> Accessories </a> <br>
        		<a href="BikeTypes.php"> <img src="img/icons/biketypes.png" alt="Bike Types Logo" /> Bike Types </a> <br>
        		<a href="AccessoryTypes.php"> <img src="img/icons/accessorytypes.png" alt="Bike Types Logo" /> Accessory Types </a> <br>
        		<a href= "bookings.php"> <img src= "img/icons/book-open-blank-variant.png" alt="Bookings Logo" /> Bookings </a> <br>
        		<a href= "Block_Out_Date.php"> <img src= "img/icons/calendar.png" alt="Block out date Logo" /> Block Out Dates </a> <br>
        		<a href= "Locations.php"> <img src= "img/icons/earth.png" alt="Locations Logo" /> Locations </a> <br>
        		<a href= "editpages.php"> <img src= "img/icons/bulletin-board.png" alt="Edit Pages Logo" /> Edit </a> <br>
        		<?php setLogoutButton()?>
        	</div>
        	<div class="main">
                <h1 id="content-header"> All Items </h1>

                <!-- Add Item pop up -->
                <button type="button" id="addItem">+ Add Accessory</button>

                <!-- List of available bookings -->
                <table class="TableContent" id="data-table">
                    <?php
                    // Fetching all column data from the bike inventory table
                    $accessoryInventory = $conn->query("SELECT * FROM accessory_inventory_table");

                    echo "
                            <tr>
                                <th> Accessory ID </th>
                                <th> Accessory Name </th>
                                <th> Accessory Type </th>
                                <th> Accessory Price ($ p/h)</th>
                                <th> Availability Status</th>
                                <th> Safety Status </th>
                                <th> Action </th>
                            </tr>";

                    while ($row = $accessoryInventory->fetch_assoc()) {
                        // Print Safety Inspection based on 0 or 1 values
                        $safetyStatus = safety_check($row["safety_inspect"]);

                        // Fetch bike type data from the bike_type_table
                        $accessorytype = $row["accessory_type_id"];
                        $accessoryTypeInventory = $conn->query("SELECT name FROM accessory_type_table WHERE accessory_type_id=$accessorytype")->fetch_assoc();

                        // Booking availbility check for bikes
                        $bookingStatus = accessory_availability_check($row["accessory_id"]);

                        //Set the availability status colour based on the availability status
                        $availabilityStatusColour = "#000000";
                        $availabilityStatusColour = availabilityStatusColour($bookingStatus);

                        //Set the availability status colour based on the availability status
                        $safetyStatusColour = "#000000";
                        $safetyStatusColour = safetyStatusColour($safetyStatus);

                        // Setting the primary key value based on table's primary key
                        $primaryKey = $row["accessory_id"];
                        $_SESSION["primaryKey"] = $primaryKey;

                    ?>
                        <tr>
                            <td><?php echo $row["accessory_id"]; ?></td>
                            <td><?php echo $row["name"]; ?></td>
                            <td><?php echo $accessoryTypeInventory["name"]; ?></td>
                            <td><?php echo $row["price_ph"]; ?></td>
                            <!--<td><//?php echo "<span style=\"color: $availabilityStatusColour\">$bookingStatus</span>" ?></td>
                            <td><//?php echo "<span style=\"color: $safetyStatusColour\">$safetyStatus</span>" ?></td> -->
                            <?php echo "<td style=\"background-color:$availabilityStatusColour\"> <span style=\"font-weight:bold\">$bookingStatus</span></td>";?>
                            <?php echo "<td style=\"background-color:$safetyStatusColour\"> <span style=\"font-weight:bold\">$safetyStatus</span></td>";?>
                            <td class="editcolumn">
                                <?php
                                echo "
                                <div class='dropdown'>
                                <button class='dropbtn' disabled>...</button>
                                    <div class='dropdown-content'>
                                    <form action='php-scripts/accessory-updatescript.php' method='POST' event.preventDefault() > <button type='submit' id= '$primaryKey' class='dropdown-element' name='updateItem'
                                        value='$primaryKey'> Update </button> </form>
                                    <form action='php-scripts/accessory-deletescript.php' method='POST' event.preventDefault()> <button type='submit' id='$primaryKey' name='deleteItem' class='dropdown-element'
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
        </div>


        <?php
        /*Retreiving accessory data to display in the form*/
        $accessoryId = $conn->query("SELECT * FROM accessory_type_table");
        if ($accessoryId->num_rows > 0) {
            $accessoryAccessoryOption = mysqli_fetch_all($accessoryId, MYSQLI_ASSOC);
        }
        /*Retreiving bike type data to display in the form*/
        $accessoryType = $conn->query("SELECT * FROM accessory_type_table");
        if ($accessoryType->num_rows > 0) {
            $accessoryTypeOption = mysqli_fetch_all($accessoryType, MYSQLI_ASSOC);
        }
        ?>
        <div id="AddAccessoryModal" class="modal-overlay"<?php
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
            <div class="modal-content">
                <span class="close-btn">&times;</span>
                <form action="php-scripts/accessory-addscript.php" method="post">
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
                        <!-- <label>Accessory ID</label> -->
                        <input placeholder="ID of the Accessory..." type="hidden" name="accessoryId">
                    </div>
                    <div>
                        <label>Name</label>
                        <input placeholder="Accessory's name..." type="text" name="name">
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
                        <label>AccessoryTypeID</label><br>
                        <select placeholder="Accessory's Type..." name="accessoryTypeId" type="submit">
                            <option value ="">Select accessory type</option>
                            <?php
                            foreach ($accessoryTypeOption as $option) {
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
                                if (isset($_GET["insert"]))
                                {
                                    $accessoryTypeId = $_GET["insert"];
                                    if ($accessoryTypeId == "emptyType")
                                    {
                                        echo '<p class = "error">* Please select an accessory type!</p>';
                                    }
                                }
                            ?>
                        </span>
                    </div>

                    <div>
                        <label>Price p/h</label>
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
                        <label>Safety Inspect</label>
                        <select placeholder="Safety status..." name="safetyInspect" type="submit">
                            <option>Inspection status</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div> -->

                    <div>
                        <label>Safety Status</label>
                        <label class="switch"  style='left: 10px; bottom:14px;' >
                        <input type="hidden" name="safetyInspect" value="0">
                        <input type="checkbox" name="safetyInspect" value="1">
                        <span class="slider round"></span>
                        </label>
                    </div>

                <div>
                        <button type="submit" name="AddItem">Add Item</button>
                </div>
                </form>
            </div>
        </div>

        <!-- Modal to update inventory records (In progress) -->
        <div id="UpdateAccessoryModal" class="modal-overlay" <?php

                                                        if (isset($_GET["update"])) {
                                                            if ($_GET["update"] != "true") {
                                                                echo "style = 'display:inline-block;'";
                                                            } else if ($_GET["update"] == "true") {
                                                                echo "style = 'display:none;'";
                                                            }
                                                        }
                                                        ?>>
            <div class="modal-content">
                <span class="close-btn">&times;</span>
                <form action="php-scripts/accessory-updatescript.php" method="post" event.preventDefault()>
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
                        <label>Accessory ID</label>
                        <input placeholder="ID of the Accessory..." type="text" name="accessoryId" readonly value="<?php echo $_SESSION['accessory_id'] ?>">
                    </div>

                    <div>
                        <label>Name</label>
                        <input placeholder="Accessory's name..." type="text" name="name" value="<?php echo $_SESSION['name'] ?>">
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
                        <label>Accessory Type ID</label><br>
                        <select placeholder="Accessory's Type..." name="accessoryTypeId" type="submit" value="<?php echo $_SESSION['accessory_type_id'] ?>">
                            <?php
                            foreach ($accessoryTypeOption as $option) {
                            $selected = $_SESSION['accessory_type_id']===$option['accessory_type_id'] ? 'selected' : '';
                            ?>
                                <option <?php echo $selected ?>><?php echo $option['accessory_type_id'];
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
                                    $accessoryTypeId = $_GET["update"];
                                    if ($accessoryTypeId == "emptyType")
                                    {
                                        echo '<p class = "error">* Please select an accessory type!</p>';
                                    }
                                }
                            ?>
                        </span>
                    </div>

                    <div>
                        <label>Price p/h</label>
                        <input placeholder="Price per hour..." type="text" name="price" value="<?php echo $_SESSION['price_ph'] ?>">
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
                    </div>

                    <div>
                        <!-- <label>Safety Inspect</label>
                        <select placeholder="Safety status..." name="safetyInspect" type="text" value="<//?php echo $_SESSION['safety_inspect'] ?>">
                            <option selected=selected><//?php echo safety_check($_SESSION['safety_inspect']); ?></option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select> -->

                        <label>Safety Status</label>
                        <label class="switch"  style='left: 10px; bottom: 14px;' >
                        <input type="hidden" name="safetyInspect" value="0">
                        <input type="checkbox" name="safetyInspect" value="1" <?php echo ($_SESSION['safety_inspect']==1 ? 'checked' : '');?>>
                        <span class="slider round"></span>
                        </label>
                    </div>

                    <div>
                        <button type="submit" name="submitUpdateItem">Update Item</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal to delete inventory records -->
        <div id="DeleteAccessoryModal" class="modal-overlay"
        <?php
            if (isset($_GET["delete"])) {
                if ($_GET["delete"] != "true") {
                    echo "style = 'display:inline-block;'";
                } else if ($_GET["delete"] == "true") {
                    echo "style = 'display:none;'";
                }
            }
        ?>>
            <div class="modal-content">
                <span class="close-btn">&times;</span>
                <h2 style="left: -8%; position: relative;"> Do you wish to delete the item? </h2>
                <form action="php-scripts/accessory-deletescript.php" method="post" event.preventDefault()>
                    <div>
                        <div style="text-align: center; background-color: none;">
                        <label>Accessory ID :</label>
                        <?php
                        $primaryKey = $_SESSION["accessory_id"];
                        echo "<h2 style='left:-10%; position: relative;'> $primaryKey </h2>";?></div><br>
                        <?php
                        echo "<form action='php-scripts/accessory-deletescript.php' method='POST' event.preventDefault()>
                          <button style='width: 40%; left: -10%; position: relative;' type='submit' id='$primaryKey' value ='$primaryKey' name='submitDeleteItem'>Yes</button>
                          <button style='width: 40%; left: -10%; position: relative; background-color: red;' type='submit' name='cancelDeleteItem'>No</button> </form>";
                        ?>
                </form>
            </div>
        </div>

    </body>
    <script src="scripts/accessory-popup.js"></script>
</html>
