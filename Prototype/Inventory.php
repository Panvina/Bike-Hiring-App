<?php
/* Code entirely completed by Aadesh Jagannathan - 102072344*/

/* Reference = https://www.w3schools.com/howto/howto_css_modals.asp */
/* Styling reused from Jake's dashboard pages*/

// Enabling session
session_start();

$_SESSION["CurrentPage"] = "inventory";

// Setting the timezone to local timezone to compare booking availabilities
date_default_timezone_set('Australia/Melbourne');

//Linking utility functions associated with inventory
include_once("php-scripts/inventory-util.php");

// dashboard side menu import (Dabin)
include_once("php-scripts/dashboard-menu.php");
// include_once("php-scripts/backend-connection.php");

//Establishing database connection using mysqli()
$conn = new mysqli("localhost", "root", "", "bike_hiring_system");
?>

<html>
<!-- Styling reused from Jake's dashboard pages -->
<link rel="stylesheet" href="style/dashboard-style.css">
<link rel="stylesheet" href="style/popup.css">
<!-- Styling unique to Inventory pages-->
<link rel="stylesheet" href="style/inventory-style.css">

<head>
    <!-- header -->
    <title> Inventory </title>
    <div class ="flexDisplay">
        <h1 class="header"> <a href="index.php"><img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo" /></a> Bike Inventory </h1>
        <a id="webpageDirect" name = "webpageDirect" href= 'index.php'> Back to website </a>
    </div>
</head>

<body>
    <div class="grid-container">
        <div class="menu">
            <?php printMenu("inventory"); ?>
        </div>
        <div class="main">
        <?php
            //Prints message based on success of record insertion
            if (isset($_GET["insert"])) {
                if ($_GET["insert"] == "true") {
                    echo "<p class = 'echo-success' id='tempEcho'>  Record successfully created! </p>";
                } else if ($_GET["insert"] == "false") {
                    echo "<p class = 'echo-fail'>  Record was not created successfully! </p>";
                }
            }

            //Prints message based on success of record updation
            if (isset($_GET["update"])) {
                if ($_GET["update"] == "true") {
                    echo "<p class = 'echo-success' id='tempEcho'>  Record successfully updated! </p>";
                } else if ($_GET["update"] == "false") {
                    echo "<p class = 'echo-fail' id='tempEcho'> Record was not updated successfully! </p>";
                }
            }

            //Prints message based on success of record deletion
            if (isset($_GET["delete"])) {
                if ($_GET["delete"] == "true") {
                    echo "<p class = 'echo-success' id='tempEcho'>  Record successfully deleted! </p>";
                } else if ($_GET["delete"] == "false") {
                    echo "<p class = 'echo-fail' id='tempEcho'> Record was not deleted successfully! </p>";
                }
            }
        ?>
            <!-- Page Title -->
            <h1 id="content-header"> All Bikes </h1>
            <!-- Page Search Bar  - Concept adopted from Alex--> 
            <div class="midbar">
                    <form id="midbar-form" action='php-scripts/inventory-addscript.php' method='POST'>
                        <input type="text" name="search" placeholder="Search (Bike Name)"></input>
                        <button type="submit" name="search-btn"> Search </button>
                    </form>
                    <!-- Add Item pop up -->
                    <button type="button" id="addItem">+ Add Bike</button>
            </div>

            <!-- List of available bookings -->
            <table class="TableContent" id="data-table">
                <?php
                // create new DB connection and fetch rows
                if (isset($_GET["search"]))
                {
                    $search = $_GET['search'];
                    $bikeInventory = $conn->query("SELECT * FROM bike_inventory_table WHERE bike_inventory_table.name LIKE '%$search%'");
                }
                else
                {
                    // Fetching all column data from the bike inventory table
                    $bikeInventory = $conn->query("SELECT * FROM bike_inventory_table");
                }

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
                            <th> Edit </th>
                        </tr>";
                        
                // Populating table when data is is found to be present in the database table
                if($bikeInventory->num_rows != 0) 
                {
                    // Printing data of all table columns by fetching from database
                    while ($row = $bikeInventory->fetch_assoc()) {
                        // Print Safety Inspection based on 0 or 1 values
                        $safetyStatus = safety_check($row["safety_inspect"]);

                        // Fetching bike type data from the bike_type_table
                        $biketype = $row["bike_type_id"];
                        if ($biketype == "")
                        {
                            $bookingStatus = "BikeTypeNull";
                            $availabilityStatusColour = "#EF6E6E";
                            $safetyStatusColour = "#EF6E6E";
                            $primaryKey = $row["bike_id"];
                            $_SESSION["primaryKey"] = $primaryKey;
                        }
                        else
                        {
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
                        }


                    ?>
                        <tr>
                            <td><?php echo $row["bike_id"]; ?></td>
                            <td><?php echo $row["name"]; ?></td>
                            <td><?php
                                if (isset($bikeTypeInventory))
                                {
                                    echo $bikeTypeInventory["name"];
                                }
                                else
                                {
                                    echo "[Deleted Item]";
                                }
                            ?></td>
                            <td><?php echo $row["price_ph"]; ?></td>
                            <?php echo "<td style=\"background-color:$availabilityStatusColour\"> <span style=\"font-weight:bold\">$bookingStatus</span></td>";?>
                            <?php echo "<td style=\"background-color:$safetyStatusColour\"> <span style=\"font-weight:bold\">$safetyStatus</span></td>";?>
                            <td><?php echo $row["description"]; ?></td>
                        <!--  <td>
                                <a href="inventory-process.php?delete=<//?php echo $row["bike_id"]; ?>">Delete</a>
                            </td> -->
                            <td class="editcolumn">
                                <!--Buttons added to the table to update and delete records-->
                                <?php
                                echo "
                                <div class='dropdown'>
                                <button class='dropbtn' disabled>...</button>
                                    <div class='dropdown-content'>
                                    <!-- Yes or No selection as dropdown for safety check -->
                                    <form action='php-scripts/inventory-updatescript.php' method='POST' event.preventDefault() > <button type='submit' id= '$primaryKey' class='dropdown-element' name='updateItem'
                                        value='$primaryKey'> Update </button> </form>
                                    <form action='php-scripts/inventory-deletescript.php' method='POST' event.preventDefault()> <button type='submit' id='$primaryKey' name='deleteItem' class='dropdown-element'
                                        value = '$primaryKey'> Delete </button> </form>
                                    </div>
                                </div>";
                                ?>
                            </td>
                        </tr>

                    <?php
                    }
                }
                // Populating table with NULL when no data is present in database table
                else
                {
                    ?>
                    <td><?php echo "NULL"; ?></td>
                    <td><?php echo "NULL"; ?></td>
                    <td><?php echo "NULL"; ?></td>
                    <td><?php echo "NULL"; ?></td>
                    <td><?php echo "NULL"; ?></td>
                    <td><?php echo "NULL"; ?></td>
                    <td><?php echo "NULL"; ?></td>
                    <td><?php echo "NULL"; ?></td>
                <?php    
                }
                ?>
            </table>
        </div>
    </div>

    <?php
    /*Retreiving accessory data to display in the form*/
    $accessoryId = $conn->query("SELECT * FROM accessory_inventory_table WHERE accessory_type_id=1");
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
    <div id="AddInventoryModal" class="modal-overlay"<?php
            // Ensures modal stays open when "insert" is set to print errors
            if (isset($_GET["insert"])) {
                if ($_GET["insert"] == "false") {
                    echo "style = 'display:none;'";
                }
                else if ($_GET["insert"] != "true") {
                    echo "style = 'display:inline-block;'";
                } 
            }
        ?>>
        <!-- Content within popup -->
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <form action="php-scripts/inventory-addscript.php" method="post">
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
                <h2>Add Bike</h2>
                <div>
                    <!-- <label>Bike ID</label> -->
                    <input placeholder="ID of the Bike..." type="hidden" name="bikeId">
                </div>
                <div>
                    <label>Name</label><br>
                    <?php
                        if (isset($_SESSION["tempName"]))
                        {
                        ?>
                            <input placeholder="Bike's name..." type="text" name="name" value=<?php echo $_SESSION["tempName"];?>>
                        <?php
                        }
                        else
                        {
                        ?>
                            <input placeholder="Bike's name..." type="text" name="name">
                        <?php
                        }
                    ?>
                    <span class="error">
                        <?php
                            if (isset($_GET["name"]))
                            {
                                $name = $_GET["name"];
                                if ($name == "empty")
                                {
                                    echo '<p class = "error">* Please fill the name field!</p>';
                                }
                                else if ($name == "invalid")
                                {
                                    echo '<p class = "error">* Name can only contain alphabets, integers, - and _</p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <!-- Bike type options displayed as a dropdown by fetching from bike type table in db-->
                    <label>Bike Type ID</label><br>
                    <?php
                        if (isset($_SESSION["tempBikeTypeId"]))
                        {
                            ?>
                            <select placeholder="Bike's Type..." name="bikeTypeId" type="submit" value="<?php echo $_SESSION['tempBikeTypeId'][0] ?>">
                            <?php
                            if($_SESSION['tempBikeTypeId'][0]==null)
                            {
                            ?>
                              <option value ="">Select bike type</option>
                            <?php
                            }
                            foreach ($bikeTypeOption as $option) {
                                $selected = $_SESSION['tempBikeTypeId'][0]===$option['bike_type_id'] ? 'selected' : '';
                                ?>
                                    <option <?php echo $selected ?>><?php
                                            echo $option['bike_type_id'];
                                            echo "-";
                                            echo  $option['name'];
                                             ?> </option>
                            <?php
                            }
                            ?>
                            </select> <?php
                        }
                        else
                        {
                            ?>
                            <select placeholder="Bike's Type..." name="bikeTypeId" type="submit" >
                            <option value ="">Select bike type</option>
                            <?php
                            foreach ($bikeTypeOption as $option) {
                            ?>
                                <option><?php
                                        echo $option['bike_type_id'];
                                        echo "-";
                                        echo  $option['name']; ?> </option>
                            <?php
                            }
                            ?>
                            </select> <?php
                        }
                    ?>
                    <span class="error">
                        <?php
                            if (isset($_GET["type"]))
                            {
                                $bikeTypeId = $_GET["type"];
                                if ($bikeTypeId == "empty")
                                {
                                    echo '<p class = "error">* Please select a bike type!</p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <!-- Helmet options displayed as a dropdown by fetching from accessory type table in db-->
                    <label>Helmet ID</label><br>
                    <?php
                     if (isset($_SESSION["tempHelmetId"]))
                     {
                        ?>
                        <select placeholder="Helmet's ID..." name="helmetId" type="submit" value="<?php echo $_SESSION['tempHelmetId'][0] ?>">
                        <?php
                            if($_SESSION['tempHelmetId'][0]==null)
                            {
                            ?>
                              <option value ="">Select helmet</option>
                            <?php
                            }
                        foreach ($bikeAccessoryOption as $option) {
                        $selected = $_SESSION['tempHelmetId'][0]===$option['accessory_id'] ? 'selected' : '';
                        ?>
                            <option <?php echo $selected ?>><?php echo $option['accessory_id'];
                                    echo "-";
                                    echo  $option['name']; ?> </option>
                        <?php
                        }
                        ?>
                        </select>
                       <?php
                     }
                     else
                     {
                        ?>
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
                        <?php
                     }
                    ?>
                    <span class="error">
                        <?php
                            if (isset($_GET["helmet"]))
                            {
                                $helmetId = $_GET["helmet"];
                                if ($helmetId == "empty")
                                {
                                    echo '<p class = "error">* Please select a helmet!</p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <label>Price p/h</label><br>
                    <?php
                    if(isset($_SESSION["tempPrice"]))
                    {
                    ?>
                        <input placeholder="Price per hour..." type="text" name="price" value="<?php echo $_SESSION["tempPrice"]; ?>">
                    <?php
                    }
                    else
                    {
                    ?>
                        <input placeholder="Price per hour..." type="text" name="price">
                    <?php
                    }
                    ?>
                    <span class="error">
                    <?php
                            if (isset($_GET["price"]))
                            {
                                $price = $_GET["price"];
                                if ($price == "empty")
                                {
                                    echo '<p class = "error">* Please fill the price field!</p>';
                                }
                                else if ($price == "invalid")
                                {
                                    echo '<p class = "error">* Price can only contain integers or decimals! </p>';
                                }
                            }
                     ?>
                    <span>
                </div>
                <br>
                <!-- Old styled check box for safety status-->
                <!-- <div>
                    <label>Safety Inspect</label>
                    <select placeholder="Safety status..." name="safetyInspect" type="submit">
                        <option>Inspection status</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div> -->
                <div style="margin-top: 10px;">
                    <label>Safety Status</label>
                    <?php
                    if(isset($_SESSION["tempSafetyInspect"]))
                    {
                    ?>
                       <label class="switch"  id="inventory-safety-switch" >
                        <input type="hidden" name="safetyInspect" value="0">
                        <input type="checkbox" name="safetyInspect" value="1" <?php echo ($_SESSION['tempSafetyInspect']==1 ? 'checked' : '');?>>
                        <span class="slider round"></span>
                        </label>
                    <?php
                    }
                    else
                    {
                    ?>
                        <label class="switch"  id="inventory-safety-switch" >
                        <input type="hidden" name="safetyInspect" value="0">
                        <input type="checkbox" name="safetyInspect" value="1" checked>
                        <span class="slider round"></span>
                        </label>
                    <?php
                    }
                    ?>
                </div>
                <br>
                <div>
                    <label>Description</label><br>
                    <?php
                    if(isset($_SESSION["tempDescription"]))
                    {
                    ?>
                        <textarea placeholder="Description about the bike..." name="description"><?php echo $_SESSION['tempDescription'] ?></textarea>
                    <?php
                    }
                    else
                    {
                    ?>
                        <textarea placeholder="Description about the bike..." name="description"></textarea>
                    <?php
                    }
                    ?>
                </div>
                <span class="error">
                        <?php
                            if (isset($_GET["desc"]))
                            {
                                $description = $_GET["desc"];
                                if ($description == "empty")
                                {
                                    echo '<p class = "error">* Please fill the description field!</p>';
                                }
                            }
                        ?>
                </span>
                <br>
                <div>
                    <button type="submit" name="AddItem">Add</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal to update inventory records -->
    <div id="UpdateInventoryModal" class="modal-overlay" 
    <?php

        if (isset($_GET["update"])) {
            if ($_GET["update"] == "false") {
                echo "style = 'display:none;'";
            }
            else if ($_GET["update"] != "true") {
                echo "style = 'display:inline-block;'";
            } 
        } 
    ?>>
        <!-- Content within popup -->
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <form action="php-scripts/inventory-updatescript.php" method="post" event.preventDefault()>
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
                <h2>Update Bike</h2>
                <br>
                <div>
                    <label>Bike ID</label><br>
                    <input placeholder="ID of the Bike..." type="text" name="bikeId" readonly value="<?php echo $_SESSION['bike_id'] ?>">
                </div>
                <div>
                    <label>Name</label><br>
                    <input placeholder="Bike's name..." type="text" name="name" value="<?php echo $_SESSION['name'] ?>">
                    <span class="error">
                        <?php
                            if (isset($_GET["name"]))
                            {
                                $name = $_GET["name"];
                                if ($name == "empty")
                                {
                                    echo '<p class = "error">* Please fill the name field!</p>';
                                }
                                else if ($name == "invalid")
                                {
                                    echo '<p class = "error">* Name can only contain alphabets, integers, - and _</p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <!-- Bike type options displayed as a dropdown by fetching from bike type table in db-->
                    <label>Bike Type ID</label><br>
                    <select placeholder="Bike's Type..." name="bikeTypeId" type="submit" value="<?php echo $_SESSION['bike_type_id'] ?>">
                        <!-- <option style = 'background-color:#8DEF6E' selected=selected><//?php echo $_SESSION['bike_type_id'];
                        echo "-";
                        echo $tempBikeTypeOption['name'];?></option> -->
                        <?php
                        foreach ($bikeTypeOption as $option) {
                        $selected = $_SESSION['bike_type_id']===$option['bike_type_id'] ? 'selected' : '';
                        ?>
                            <option <?php echo $selected ?>><?php
                                    echo $option['bike_type_id'];
                                    echo "-";
                                    echo  $option['name'];
                                     ?> </option>
                        <?php
                        }
                        ?>
                    </select>
                    <span class="error">
                        <?php
                            if (isset($_GET["type"]))
                            {
                                $bikeTypeId = $_GET["type"];
                                if ($bikeTypeId == "empty")
                                {
                                    echo '<p class = "error">* Please select a bike type!</p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <!-- Helmet options displayed as a dropdown by fetching from accessory type table in db-->
                    <label>Helmet ID</label><br>
                    <select placeholder="Helmet's ID..." name="helmetId" type="submit" value="<?php echo $_SESSION['helmet_id'] ?>">
                        <?php
                        foreach ($bikeAccessoryOption as $option) {
                        $selected = $_SESSION['helmet_id']===$option['accessory_id'] ? 'selected' : '';
                        ?>
                            <option <?php echo $selected ?>><?php echo $option['accessory_id'];
                                    echo "-";
                                    echo  $option['name']; ?> </option>
                        <?php
                        }
                        ?>
                    </select>
                    <span class="error">
                        <?php
                            if (isset($_GET["helmet"]))
                            {
                                $helmetId = $_GET["helmet"];
                                if ($helmetId == "empty")
                                {
                                    echo '<p class = "error">* Please select a helmet!</p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <label>Price p/h</label><br>
                    <input placeholder="Price per hour..." type="text" name="price" value="<?php echo $_SESSION['price_ph'] ?>">
                    <span class="error">
                    <?php
                            if (isset($_GET["price"]))
                            {
                                $price = $_GET["price"];
                                if ($price == "empty")
                                {
                                    echo '<p class = "error">* Please fill the price field!</p>';
                                }
                                else if ($price == "invalid")
                                {
                                    echo '<p class = "error">* Price can only contain integers or decimals! </p>';
                                }
                            }
                     ?>
                    <span>
                </div>
                <br>
                <!-- <div>
                    <label>Safety Inspect</label>
                    <select placeholder="Safety status..." name="safetyInspect" type="text" value="<//?php echo $_SESSION['safety_inspect'] ?>">
                        <option selected=selected><//?php echo safety_check($_SESSION['safety_inspect']); ?></option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>-->

                <!-- Yes or No selection as dropdown for safety check -->
                <div style="margin-top: 10px;">
                    <label>Safety Status</label>
                    <label class="switch" id="inventory-safety-switch">
                    <input type="hidden" name="safetyInspect" value="0">
                    <input type="checkbox" name="safetyInspect" value="1" <?php echo ($_SESSION['safety_inspect']==1 ? 'checked' : '');?>>
                    <span class="slider round"></span>
                    </label>
                </div>
                <br>
                <div>
                    <label>Description</label><br>
                    <textarea placeholder="Description about the bike..." name="description"><?php echo $_SESSION['description'] ?></textarea>
                <span class="error">
                        <?php
                            if (isset($_GET["desc"]))
                            {
                                $description = $_GET["desc"];
                                if ($description == "empty")
                                {
                                    echo '<p class = "error">* Please fill the description field!</p>';
                                }
                            }
                        ?>
                </span>
                </div><br>
                <div>
                    <button type="submit" name="submitUpdateItem">Update</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal to delete inventory records -->
    <div id="DeleteInventoryModal" class="modal-overlay" 
    <?php
    if (isset($_GET["delete"])) {
        if ($_GET["delete"] == "false") {
            echo "style = 'display:none;'";
        }
        else if ($_GET["delete"] != "true") {
            echo "style = 'display:inline-block;'";
        } 
    }
    ?>>
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2> Do you wish to delete the bike? </h2>
            <form action="php-scripts/inventory-deletescript.php" method="post" event.preventDefault()>
                <div>
                    <div>
                        <label>Bike ID :</label>
                        <?php
                            $primaryKey = $_SESSION["bike_id"];
                            echo "<label> $primaryKey </label>";
                        ?>
                    </div><br>
                    <?php
                    echo "<form action='php-scripts/inventory-deletescript.php' method='POST' event.preventDefault()>
                      <button style='width: 40%;' type='submit' id='$primaryKey' value ='$primaryKey' name='submitDeleteItem'>Yes</button>
                      <button style='width: 40%; background-color: red;' type='submit' name='cancelDeleteItem'>No</button> </form>";
                    ?>
                </div>
            </form>
        </div>
    </div>
</body>
<!--Script responsible for the popup functionality is linked-->
<script src="scripts/inventory-popup.js"></script>

</html>
