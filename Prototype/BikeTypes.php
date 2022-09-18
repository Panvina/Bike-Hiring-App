<?php
session_start();

date_default_timezone_set('Australia/Melbourne');

include_once("php-scripts/backend-connection.php");

//Linking utility functions associated with inventory
include("php-scripts/utils.php");

//enabling the user privilege of certain tabs. Added by Vina Touch 101928802
include_once "user-privilege.php";

//Establishing database connection using mysqli()
$conn = new mysqli("localhost", "root", "", "bike_hiring_system");
?>

<!DOCTYPE html>
<html>
<link rel="stylesheet" href="style/Jake_style.css">

<head>
    <!-- header -->
    <title> Bike Types </title>
    <h1 class="header"> <a href="index.php"><img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo" /></a> Bike Types </h1>
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

    <!-- Side navigation -->
    <nav>
        <div class="sideNavigation">
            <a href= "Dashboard.php"> <img src= "img/icons/bulletin-board.png" alt="Dashboard Logo" /> Dashboard </a> <br>
            <a href = "Customer.php"> <img src= "img/icons/account-group.png" alt="Customer Logo" />  Customer  </a> <br>
            <?php setOwnerDashboardPrivilege(); ?>
            <!--<a href="accounts.php"> <img src="img/icons/account.png" alt="Account logo"/> Accounts </a> <br>-->
            <a href= "Inventory.php"> <img src= "img/icons/bicycle.png" alt="Inventory Logo" />  Inventory </a> <br>
            <a href="Accessory.php"> <img src="img/icons/accessories.png" alt="Inventory Logo" /> Accessories </a> <br>
            <a class="active" href="BikeTypes.php"> <img src="img/icons/biketypes.png" alt="Bike Types Logo" /> Bike Types </a> <br>
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
        <button type="button" id="AddItem">+ Add Bike</button>

        <!-- List of available bookings -->
        <table class="TableContent">
            <?php
            // Fetching all column data from the bike type table
            $accessoryType = $conn->query("SELECT * FROM bike_type_table");

            echo "
                    <tr>
                        <th> Bike Type ID </th>
                        <th> Bike Type Name </th>
                        <th> Description </th>
                        <th> Action </th>
                    </tr>";

            while ($row = $accessoryType->fetch_assoc()) {

                // Setting the primary key value based on table's primary key
                $primaryKey = $row["bike_type_id"];
                $_SESSION["primaryKey"] = $primaryKey;
                
            ?>
                <tr>
                    <td><?php echo $row["bike_type_id"]; ?></td>
                    <td><?php echo $row["name"]; ?></td>
                    <td><?php echo $row["description"]; ?></td>  
                    <td>
                        <?php
                        echo "
                        <div class='dropdown'>
                        <button class='dropbtn' disabled>...</button>
                            <div class='dropdown-content'>
                            <form action='php-scripts/biketype-modifyscript.php' method='POST' event.preventDefault() > <button type='submit' id= '$primaryKey' class='UpdateItem' name='updateItem' 
                                value='$primaryKey'> Update </button> </form>
                            <form action='php-scripts/biketype-modifyscript.php' method='POST' event.preventDefault()> <button type='submit' id='$primaryKey' name='deleteItem' class='DeleteItem' 
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
    
    <!-- Modal to add inventory records -->
    <div id="AddBikeModal" class="modal"<?php
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
            <span class="Insertclose">&times;</span>
            <form action="php-scripts/biketype-addscript.php" method="post">
                <div>
                <span class="error"> 
                        <?php 
                            if (isset($_GET["insert"]))
                            {   
                                //Checks and prints an error if all fields are empty in the form 
                                if ($_GET["insert"] == "empty")
                                {
                                    echo '<p class = "error">* Please enter data in the fields!</p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <!-- <h2>Bike Type ID</h2> -->
                    <input placeholder="ID of Bike Type..." type="hidden" name="bikeId">
                </div>
                <div>
                    <h2>Bike Type Name</h2>
                    <input placeholder="Name of Bike Type..." type="text" name="name">
                    <span class="error"> 
                        <?php 
                            if (isset($_GET["insert"]))
                            {
                                //Checks and prints an error if the name field empty 
                                $name = $_GET["insert"];
                                if ($name == "emptyName")
                                {
                                    echo '<p class = "error">* Please fill the name field!</p>';
                                }
                                //Checks and prints an error if the name entered is invalid
                                else if ($name == "invalidName")
                                {
                                    echo '<p class = "error">* Name has to only contain alphabets! </p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <h2>Description</h2><br>
                    <textarea style='width: 220px; height: 50px' placeholder="Description about the type of bike..." name="description"></textarea>
                    <span class="error"> 
                        <?php 
                            if (isset($_GET["insert"]))
                            {
                                //Checks and prints an error if the description field empty 
                                $description = $_GET["insert"];
                                if ($description == "emptyDescription")
                                {
                                    echo '<p class = "error">* Please fill the description field!</p>';
                                }
                            }
                        ?>
                    </span>
                </div>
            
            <div>
                    <button type="submit" name="AddItem">Add Bike</button>
            </div>
            </form> 
        </div>
    </div>

    <!-- Modal to update inventory records -->
    <div id="UpdateBikeModal" class="modal" <?php
     // Ensures modal stays open when "update" is set to print errors
                                                    if (isset($_GET["update"])) {
                                                        if ($_GET["update"] != "true") {
                                                            echo "style = 'display:inline-block;'";
                                                        } else if ($_GET["update"] == "true") {
                                                            echo "style = 'display:none;'";
                                                        }
                                                    }
                                                    ?>>
        <div class="modal-content">
            <span class="updateFormClose">&times;</span>
            <form action="php-scripts/biketype-modifyscript.php" method="post" event.preventDefault()>
                <div>
                <span class="error"> 
                        <?php 
                            //Checks and prints an error if all fields are empty in the form 
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
                <div>
                    <h2>Bike Type ID</h2>
                    <input placeholder="ID of the Accessory..." type="text" name="bikeId" readonly value="<?php echo $_SESSION['bike_type_id'] ?>">
                </div>

                <div>
                    <h2>Name</h2>
                    <input placeholder="Name of Bike Type..." type="text" name="name" value="<?php echo $_SESSION['name'] ?>">
                    <span class="error"> 
                        <?php 
                            if (isset($_GET["update"]))
                            {
                                $name = $_GET["update"];
                                //Checks and prints an error if the name field empty 
                                if ($name == "emptyName")
                                {
                                    echo '<p class = "error">* Please fill the name field!</p>';
                                }
                                //Checks and prints an error if the name entered is invalid
                                else if ($name == "invalidName")
                                {
                                    echo '<p class = "error">* Name has to only contain alphabets! </p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <h2>Description</h2><br>
                    
                    <textarea style='width: 220px; height: 50px' iplaceholder="Description about the bike type..." name="description"><?php echo $_SESSION['description'] ?></textarea>
                    <span class="error"> 
                        <?php 
                            if (isset($_GET["update"]))
                            {
                                $description = $_GET["update"];
                                //Checks and prints an error if the description field empty 
                                if ($description == "emptyDescription")
                                {
                                    echo '<p class = "error">* Please fill the description field!</p>';
                                }
                            }
                        ?>
                    </span>
                </div>

                <div>
                    <button type="submit" name="submitUpdateItem">Update Bike</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Modal to delete inventory records -->
    <div id="DeleteBikeModal" class="modal" <?php
         // Ensures modal stays open when "delete" is set to print errors
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
            <h1 style="left: -8%; position: relative;"> Do you wish to delete the bike type? </h1>
            <form action="php-scripts/biketype-modifyscript.php" method="post" event.preventDefault()>
                <div>
                    <div style="text-align: center; background-color: none;">
                    <h2>Bike Type ID :</h2>
                    <?php
                    $primaryKey = $_SESSION["bike_type_id"];
                    echo "<h1 style='left:-10%; position: relative;'> $primaryKey </h1>";?></div><br>
                    <?php
                    echo "<form action='php-scripts/biketype-modifyscript.php' method='POST' event.preventDefault()>
                      <button style='width: 40%; left: -10%; position: relative;' type='submit' id='$primaryKey' value ='$primaryKey' name='submitDeleteItem'>Yes</button>
                      <button style='width: 40%; left: -10%; position: relative; background-color: red;' type='submit' name='cancelDeleteItem'>No</button> </form>";
                    ?>
            </form>
        </div>
    </div>


</body>
<script src="scripts/biketypes-popup.js"></script>

</html>