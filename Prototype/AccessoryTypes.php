<?php
session_start();

date_default_timezone_set('Australia/Melbourne');

include_once("php-scripts/backend-connection.php");

//Linking utility functions associated with inventory
include("php-scripts/inventory-util.php");

// dashboard side menu import (Dabin)
include_once("php-scripts/dashboard-menu.php");

//Establishing database connection using mysqli()
$conn = new mysqli("localhost", "root", "", "bike_hiring_system");
?>

<html>
<link rel="stylesheet" href="style/dashboard-style.css">
<link rel="stylesheet" href="style/popup.css">
<!-- Styling unique to Inventory pages-->
<link rel="stylesheet" href="style/inventory-style.css">

<head>
    <!-- header -->
    <title> Accessory Types </title>
    <div class ="flexDisplay">
        <h1 class="header"> <a href="index.php"><img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo" /></a> Accessory Types</h1>
        <a id="webpageDirect" name = "webpageDirect" href= 'index.php'> Back to website </a>
    </div>
</head>

<body>
    <div class="grid-container">
    	<div class="menu">
    		<?php printMenu("accessorytype"); ?>
    	</div>
    	<div class="main">
        <?php
            //checks to see if inserting was successful and provides input
            if (isset($_GET["insert"])) {
                if ($_GET["insert"] == "true") {
                    echo "<p class = 'echo-success' id='tempEcho'>  Record successfully created! </p>";
                } else if ($_GET["insert"] == "false") {
                    echo "<p class = 'echo-fail'>  Record was not created! </p>";
                }
            }

            //checks to see if updating was successful and provides input
            if (isset($_GET["update"])) {
                if ($_GET["update"] == "true") {
                    echo "<p class = 'echo-success' id='tempEcho'>  Record successfully updated! </p>";
                } else if ($_GET["update"] == "false") {
                    echo "<p class = 'echo-fail' id='tempEcho'> Record was not updated successfuly </p>";
                }
            }

            //checks to see if deleting was successful and provides input
            if (isset($_GET["delete"])) {
                if ($_GET["delete"] == "true") {
                    echo "<p class = 'echo-success' id='tempEcho'>  Record successfully deleted! </p>";
                } else if ($_GET["delete"] == "false") {
                    echo "<p class = 'echo-fail' id='tempEcho'> Record was not deleted successfully! </p>";
                }
            }
        ?>
            <!-- Page Title -->
            <h1 id="content-header"> All Accessory Types </h1>
            <!-- Page Search Bar  - Concept adopted from Alex-->    
            <div class="midbar">
                    <form id="midbar-form" action='php-scripts/accessorytype-addscript.php' method='POST'>
                        <input type="text" name="search" placeholder="Search (Accessory Type Name)"></input>
                        <button type="submit" name="search-btn"> Search </button>
                    </form>
                    <!-- Add Item pop up -->
                    <button type="button" id="AddItem">+ Add Accessory Type</button>
            </div>

            <!-- List of available bookings -->
            <table class="TableContent" id="data-table">
                <?php
                // create new DB connection and fetch rows
                if (isset($_GET["search"]))
                {
                    $search = $_GET['search'];
                    $accessoryType = $conn->query("SELECT * FROM accessory_type_table WHERE accessory_type_table.name LIKE '%$search%'");
                }
                else
                {
                    // Fetching all column data from the Accessory type table
                    $accessoryType = $conn->query("SELECT * FROM accessory_type_table");
                }  
               
                echo "
                        <tr>
                            <th> Accessory Type ID </th>
                            <th> Accessory Type Name </th>
                            <th> Description </th>
                            <th> Edit </th>
                        </tr>";

                while ($row = $accessoryType->fetch_assoc()) {

                    // Setting the primary key value based on table's primary key
                    $primaryKey = $row["accessory_type_id"];
                    $_SESSION["primaryKey"] = $primaryKey;

                ?>
                    <tr>
                        <td><?php echo $row["accessory_type_id"]; ?></td>
                        <td><?php echo $row["name"]; ?></td>
                        <td><?php echo $row["description"]; ?></td>
                        <td class="editcolumn">
                            <?php
                            echo "
                            <div class='dropdown'>
                            <button class='dropbtn' disabled>...</button>
                                <div class='dropdown-content'>
                                <form action='php-scripts/accessorytype-modifyscript.php' method='POST' event.preventDefault() > <button type='submit' id= '$primaryKey' class='dropdown-element' name='updateItem'
                                    value='$primaryKey'> Update </button> </form>
                                <form action='php-scripts/accessorytype-modifyscript.php' method='POST' event.preventDefault()> <button type='submit' id='$primaryKey' name='deleteItem' class='dropdown-element'
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
            <form action="php-scripts/accessorytype-addscript.php" method="post">
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
                <h2>Add Accessory Type</h2>
                <div>
                    <!-- <label>Accessory Type ID</label> -->
                    <input placeholder="ID of accessory type..." type="hidden" name="accessoryId">
                </div>
                <div>
                    <label>Name</label><br>
                    <?php
                        if (isset($_SESSION["tempName"]))
                        {
                        ?>            
                            <input placeholder="Name of accessory type..." type="text" name="name" value=<?php echo $_SESSION["tempName"];?>>
                        <?php
                        }
                        else
                        {
                        ?>
                            <input placeholder="Name of accessory type..." type="text" name="name">
                        <?php
                        }
                    ?>
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
                <br>
                <div>
                    <label>Description</label><br>
                    <?php    
                    if(isset($_SESSION["tempDescription"]))
                    {
                    ?>
                        <textarea placeholder="Description about the type of accessory..." name="description"><?php echo $_SESSION['tempDescription'] ?></textarea>
                    <?php
                    }
                    else
                    {
                    ?>
                        <textarea placeholder="Description about the type of accessory..." name="description"></textarea>
                    <?php
                    }
                    ?>
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
                </div><br>

            <div>
                    <button type="submit" name="AddItem">Add</button>
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
            <form action="php-scripts/accessorytype-modifyscript.php" method="post" event.preventDefault()>
                <div>
                <span class="error">
                        <?php
                            if (isset($_GET["update"]))
                            {
                                if ($_GET["update"] == "empty")
                                {
                                    echo '<p class = "error">* Please do not leave the fields empty!</p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <h2>Update Accessory Type</h2>
                <div>
                    <label>Accessory Type ID</label><br>
                    <input placeholder="ID of the accessory..." type="text" name="accessoryId" readonly value="<?php echo $_SESSION['accessory_type_id'] ?>">
                </div>
                <br>            
                <div>
                    <label>Name</label><br>
                    <input placeholder="Name of accessory type..." type="text" name="name" value="<?php echo $_SESSION['name'] ?>">
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
                <br>
                <div>
                    <label>Description</label><br>
                    <textarea placeholder="Description about the accessory type..." name="description"><?php echo $_SESSION['description'] ?></textarea>
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
                </div><br>

                <div>
                    <button type="submit" name="submitUpdateItem">Update</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal to delete inventory records -->
    <div id="DeleteAccessoryModal" class="modal-overlay" <?php

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
            <h2 > Do you wish to delete the accessory type? </h2>
            <form action="php-scripts/accessorytype-modifyscript.php" method="post" event.preventDefault()>
                <div>
                    <div style="text-align: center; background-color: none;">
                        <label>Accessory Type ID:</label>
                        <?php
                            $primaryKey = $_SESSION["accessory_type_id"];
                            echo "<label> $primaryKey </label>";
                        ?>
                    </div><br>
                    <?php
                    echo "<form action='php-scripts/accessorytype-modifyscript.php' method='POST' event.preventDefault()>
                      <button style='width: 40%;' type='submit' id='$primaryKey' value ='$primaryKey' name='submitDeleteItem'>Yes</button>
                      <button style='width: 40%; background-color: red;' type='submit' name='cancelDeleteItem'>No</button> </form>";
                    ?>
                </div>
            </form>
        </div>
    </div>


</body>
<script src="scripts/accessorytypes-popup.js"></script>

</html>
