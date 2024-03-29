<?php
/* Code entirely completed by Aadesh Jagannathan - 102072344*/

session_start();

date_default_timezone_set('Australia/Melbourne');

include_once("php-scripts/backend-connection.php");

//Linking utility functions associated with inventory
include("php-scripts/utils.php");

// dashboard side menu import (Dabin)
include_once("php-scripts/dashboard-menu.php");

$_SESSION["CurrentPage"] = "bikeType";

//Establishing database connection using mysqli()
$conn = new mysqli("localhost", "root", "", "bike_hiring_system");
?>

<!DOCTYPE html>
<html>
<link rel="stylesheet" href="style/dashboard-style.css">
<link rel="stylesheet" href="style/popup.css">
<!-- Styling unique to Inventory pages-->
<link rel="stylesheet" href="style/inventory-style.css">

<head>
    <!-- header -->
    <title> Bike Types </title>
    <div class ="flexDisplay">
        <h1 class="header"> <a href="index.php"><img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo" /></a> Bike Types </h1>
        <a id="webpageDirect" name = "webpageDirect" href= 'index.php'> Back to website </a>
    </div>
</head>

<body>
    <div class="grid-container">
    	<div class="menu">
    		<?php printMenu("biketype"); ?>
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
                    echo "<p class = 'echo-fail' id='tempEcho'> Record was not updated successfuly </p>";
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
            <h1 id="content-header"> All Bike Types </h1>
            <!-- Page Search Bar  - Concept adopted from Alex--> 
            <div class="midbar">
                    <form id="midbar-form" action='php-scripts/biketype-addscript.php' method='POST'>
                        <input type="text" name="search" placeholder="Search (Bike Type Name)"></input>
                        <button type="submit" name="search-btn"> Search </button>
                    </form>
                    <!-- Add Item pop up -->
                    <button type="button" id="AddItem">+ Add Bike Type</button>
            </div>
 
            <!-- List of available bookings -->
            <table class="TableContent" id="data-table">
                <?php
                // create new DB connection and fetch rows
                if (isset($_GET["search"]))
                {
                    $search = $_GET['search'];
                    $bikeType = $conn->query("SELECT * FROM bike_type_table WHERE bike_type_table.name LIKE '%$search%'");
                }
                else
                {
                    // Fetching all column data from the bike type table
                    $bikeType = $conn->query("SELECT * FROM bike_type_table");
                }    
                
                echo "
                        <tr>
                            <th> Bike Type ID </th>
                            <th> Bike Type Name </th>
                            <th> Picture ID </th>
                            <th> Description </th>
                            <th> Edit </th>
                        </tr>";
                // Populating table when data is found to be present in the database table
                if($bikeType->num_rows != 0) 
                {
                    while ($row = $bikeType->fetch_assoc()) {

                        // Setting the primary key value based on table's primary key
                        $primaryKey = $row["bike_type_id"];
                        $_SESSION["primaryKey"] = $primaryKey;

                    ?>
                        <tr>
                            <td><?php echo $row["bike_type_id"]; ?></td>
                            <td><?php echo $row["name"]; ?></td>
                            <td><?php echo $row["picture_id"]; ?></td>
                            <td><?php echo $row["description"]; ?></td>
                            <td class="editcolumn">
                                <?php
                                echo "
                                <div class='dropdown'>
                                <button class='dropbtn' disabled>...</button>
                                    <div class='dropdown-content'>
                                    <form action='php-scripts/biketype-modifyscript.php' method='POST' event.preventDefault() > <button type='submit' id= '$primaryKey' class='dropdown-element' name='updateItem'
                                        value='$primaryKey'> Update </button> </form>
                                    <form action='php-scripts/biketype-modifyscript.php' method='POST' event.preventDefault()> <button type='submit' id='$primaryKey' name='deleteItem' class='dropdown-element'
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
                <?php  
                }
                ?>
            </table>
    	</div>
    </div>

    <!-- Modal to add inventory records -->
    <div id="AddBikeModal" class="modal-overlay"<?php
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
                <h2>Add Bike Type</h2>
                <div>
                    <!-- <label>Bike Type ID</label> -->
                    <input placeholder="ID of Bike Type..." type="hidden" name="bikeId">
                </div>              
                <div>
                    <label>Name</label><br>
                    <?php
                        if (isset($_SESSION["tempName"]))
                        {
                        ?>            
                            <input placeholder="Name of Bike Type..." type="text" name="name" value=<?php echo $_SESSION["tempName"];?>>
                        <?php
                        }
                        else
                        {
                        ?>
                            <input placeholder="Name of Bike Type..." type="text" name="name">
                        <?php
                        }
                    ?>
                    <span class="error">
                        <?php
                            if (isset($_GET["name"]))
                            {
                                //Checks and prints an error if the name field empty
                                $name = $_GET["name"];
                                if ($name == "empty")
                                {
                                    echo '<p class = "error">* Please fill the name field!</p>';
                                }
                                //Checks and prints an error if the name entered is invalid
                                else if ($name == "invalid")
                                {
                                    echo '<p class = "error">* Name can only contain alphabets, integers, - and _ </p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <br>
                <div>
                    <label>Picture ID </label><br>
                    <?php
                     if (isset($_SESSION["tempPictureId"]))
                     {                     
                     ?>
                     <select placeholder="Picture's ID..." name="pictureId" type="submit">
                     <?php
                                if(!isset($_SESSION['tempPictureId'][0]))
                                {
                                ?>
                                    <option value="">Select Picture ID</option>  
                                <?php
                                }
                                ?>
                        
                        <option value="1" <?php if($_SESSION['tempPictureId'] == 1)echo 'selected'; ?>>1 - E-bike(StepThrough)</option>
                        <option value="2" <?php if($_SESSION['tempPictureId'] == 2)echo 'selected'; ?>>2 - E-bike(StepOver)</option>
                        <option value="3" <?php if($_SESSION['tempPictureId'] == 3)echo 'selected'; ?>>3 - Standard(StepThrough)</option>
                        <option value="4" <?php if($_SESSION['tempPictureId'] == 4)echo 'selected'; ?>>4 - Standard(StepOver)</option>
                        <option value="5" <?php if($_SESSION['tempPictureId'] == 5)echo 'selected'; ?>>5 - Mountain-bike(HardTail)</option>
                        </select>       
                     <?php
                     }
                     else
                     {
                     ?>
                        <select placeholder="Picture's ID..." name="pictureId" type="submit">
                        <option value="">Picture ID</option>
                        <option value="1">1 - E-bike(StepThrough)</option>
                        <option value="2">2 - E-bike(StepOver)</option>
                        <option value="3">3 - Standard(StepThrough)</option>
                        <option value="4">4 - Standard(StepOver)</option>
                        <option value="5">5 - Mountain-bike(HardTail)</option>
                        </select>
                     <?php
                     }
                     ?> 
                     <span class="error">
                        <?php
                            if (isset($_GET["insert"]))
                            {
                                //Checks and prints an error if the picture id has not been selected
                                $pictureId = $_GET["picId"];
                                if ($pictureId == "empty")
                                {
                                    echo '<p class = "error">* Please select a picture ID!</p>';
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
                        <textarea placeholder="Description about the type of bike..." name="description"><?php echo $_SESSION['tempDescription'] ?></textarea>
                    <?php
                    }
                    else
                    {
                    ?>
                        <textarea placeholder="Description about the type of bike..." name="description"></textarea>
                    <?php
                    }
                    ?>
                    <span class="error">
                        <?php
                            if (isset($_GET["desc"]))
                            {
                                //Checks and prints an error if the description field empty
                                $pictureId = $_GET["desc"];
                                if ($pictureId == "empty")
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

    <!-- Modal to update inventory records -->
    <div id="UpdateBikeModal" class="modal-overlay" <?php
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
            <span class="close-btn">&times;</span>
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
                <h2>Update Bike Type</h2>
                <div>
                    <label>Bike Type ID</label><br>
                    <input placeholder="ID of the Accessory..." type="text" name="bikeId" readonly value="<?php echo $_SESSION['bike_type_id'] ?>">
                </div>
                <br>            
                <div>
                    <label>Name</label><br>
                    <input placeholder="Name of Bike Type..." type="text" name="name" value="<?php echo $_SESSION['name'] ?>">
                    <span class="error">
                        <?php
                            if (isset($_GET["name"]))
                            {
                                $name = $_GET["name"];
                                //Checks and prints an error if the name field empty
                                if ($name == "empty")
                                {
                                    echo '<p class = "error">* Please fill the name field!</p>';
                                }
                                //Checks and prints an error if the name entered is invalid
                                else if ($name == "invalid")
                                {
                                    echo '<p class = "error">* Name can only contain alphabets, integers, - and _</p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <br>
                <div>
                    <label>Picture ID</label><br>
                    <select placeholder="Picture's ID..." name="pictureId" type="submit">
                        <option value="1" <?php if($_SESSION['pictureId'] == 1)echo 'selected'; ?>>1 - E-bike(StepThrough)</option>
                        <option value="2" <?php if($_SESSION['pictureId'] == 2)echo 'selected'; ?>>2 - E-bike(StepOver)</option>
                        <option value="3" <?php if($_SESSION['pictureId'] == 3)echo 'selected'; ?>>3 - Standard(StepThrough)</option>
                        <option value="4" <?php if($_SESSION['pictureId'] == 4)echo 'selected'; ?>>4 - Standard(StepOver)</option>
                        <option value="5" <?php if($_SESSION['pictureId'] == 5)echo 'selected'; ?>>5 - Mountain-bike(HardTail)</option>
                    </select> 
                    <span class="error">
                        <?php
                            if (isset($_GET["picId"]))
                            {
                                //Checks and prints an error if the picture id is not selected
                                $pictureId = $_GET["picId"];
                                if ($pictureId == "empty")
                                {
                                    echo '<p class = "error">* Please select a picture ID!</p>';
                                }
                            }
                        ?>
                    </span>      
                </div>
                <br>
                <div>
                    <label>Description</label><br>

                    <textarea placeholder="Description about the bike type..." name="description"><?php echo $_SESSION['description'] ?></textarea>
                    <span class="error">
                        <?php
                            if (isset($_GET["desc"]))
                            {
                                $description = $_GET["desc"];
                                //Checks and prints an error if the description field empty
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
    <div id="DeleteBikeModal" class="modal-overlay" <?php
         // Ensures modal stays open when "delete" is set to print errors
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
            <h2> Do you wish to delete the bike type? </h2>
            <form action="php-scripts/biketype-modifyscript.php" method="post" event.preventDefault()>
                <div>
                    <div>
                        <label>Bike Type ID :</label>
                        <?php
                            $primaryKey = $_SESSION["bike_type_id"];
                            echo "<label> $primaryKey </label>";
                        ?>
                    </div><br>
                    <?php
                    echo "<form action='php-scripts/biketype-modifyscript.php' method='POST' event.preventDefault()>
                      <button style='width: 40%;' type='submit' id='$primaryKey' value ='$primaryKey' name='submitDeleteItem'>Yes</button>
                      <button style='width: 40%; background-color: red;' type='submit' name='cancelDeleteItem'>No</button> </form>";
                    ?>
                </div>
            </form>
        </div>
    </div>


</body>
<!--Script responsible for the popup functionality is linked-->
<script src="scripts/biketypes-popup.js"></script>

</html>
