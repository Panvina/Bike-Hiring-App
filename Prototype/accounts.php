<!-- All code on this page has been completed by Jake.H 102090870 -->
<?php
    //start the session with the database
    session_start();
    //include database functions
    include_once "php-scripts\bike-inventory-db.php";
    include_once "php-scripts\utils.php";
    //create the connection with the database
    $conn = new DBConnection("accounts_table");
?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" href="style/Jake_style.css">

<head>
    <!-- Header -->
    <title> Accounts </title>
    <h1 class="header"> <img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo" /> Accounts </h1>
</head>

<body>
    <!-- Side navigation -->
    <nav>
        <div class="sideNavigation">
            <a href="Dashboard.php"> <img src="img/icons/bulletin-board.png" alt="Dashboard Logo" /> Dashboard </a> <br>
            <a href="Customer.php"> <img src="img/icons/account-group.png" alt="Customer Logo" /> Customer </a> <br>
            <a href="staff.php"> <img src="img/icons/staff.png" alt="Staff Logo" /> Staff </a> <br> 
            <a class="active" href="accounts.php"> <img src="img/icons/account.png" alt="Account logo"/> Accounts </a> <br> 
            <a href="Inventory.php"> <img src="img/icons/bicycle.png" alt="Inventory Logo" /> Inventory </a> <br>
            <a href="bookings.php"> <img src="img/icons/book-open-blank-variant.png" alt="Bookings Logo" /> Bookings
            </a> <br>
            <a href="Block_Out_Date.php"> <img src="img/icons/calendar.png" alt="Block out date Logo" /> Block Out Dates
            </a> <br>
            <a href="Locations.php"> <img src="img/icons/earth.png" alt="Locations Logo" /> Locations </a> <br>
        </div>
    </nav>
    
    <!-- Block of content in center -->
    <div class="Content">
        <h1> All Accounts</h1>

        <!-- List of current customers -->
        <table class="TableContent">
            <tr>
                <?php
                    //Fetch data done by Alex, altered by Jake for customer table
                    //establishes the collumns in the table to be used in the query
                    $cols = "user_name, role_id, password";
                    //get the data from the table
                    $rows = $conn->get($cols);

                    //establish the headings that will be used to display the data in the table
                    $tableHeadings = "User Name, Role, Password";

                    //data validation to remove ',' for querying and displaying data in the table
                    $cols = explode(',', $cols);
                    $tableHeadings = explode(',', $tableHeadings);

                    $count = count($cols);
                    for($x = 0; $x < $count; $x++)
                    {
                        $col = trim($tableHeadings[$x]);
                        echo "<th> $col </th>";
                    }
                    echo "<th> Edit </th>"
                ?> 
            </tr>
            <?php       
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

                $primaryColumn = "user_name";
        
                for($x = 0; $x < count($rows); $x++)
                {
                    echo "<tr>";
                    for($y = 0; $y < count($keys); $y++)
                    {
                        $row = $rows[$x];
                        $key = $keys[$y];
                        $data = $row[$key];
                        echo "<td> $data </td>";

                        if($key == $primaryColumn)
                        {
                            $primaryKey = $data;
                        }
                    }
                    $_SESSION["primaryKey"] = $primaryKey;
                    //Creates the dropdown box with the buttons used for updating and deleting
                    //Clemeant created the drop down box. Jake repurposed it and changed the style and functionality to suit current methods
                    echo 
                        "<td>  
                        <div class='dropdown'>
                            <button class='dropbtn' disabled>...</button>
                            <div class='dropdown-content'>
                                <form action='accounts-update-script.php' method='POST' event.preventDefault() > <button type='submit' id= '$primaryKey' class='AccountUpdateButton' name='UpdateButton' 
                                value='$primaryKey'> Update Account </button> </form>
                                <form action='account-delete-script.php' method='POST' event.preventDefault()> <button type='submit' name='deleteButton' id='$primaryKey' class='deleteButton' 
                                value = '$primaryKey'>Delete Customer</button> </form>
                            </div>
                        </div>
                        </td>";
                    
                    echo "</tr>";
                }
            ?>
        </table>
    </div>

     <!-- Create the initial window for the pop up -->
    <div id="UpdateCustomerModal" class="modal" <?php
            //checks to see if there was any errors and if there was, it will continue to display the modal
            if(isset($_GET["update"]))
            {
                if ($_GET["update"] != "true")
                {
                    echo "style = 'display:inline-block'";
                }
                else if($_GET["update"] == "true")
                {
                    echo "style = 'display:none'";
                }
            }
        ?>>

        <!-- Creates the content within the pop up -->
        <div class="modal-content" >
        
            <span class="updateFormClose">&times;</span>
            <form action="accounts-update-script.php" method="POST" event.preventDefault()>

                <h1> Update a customer </h1>
                <div>
                    <!-- //Made User name not editable to ensure database intergrity  -->
                    <h2> User Name: </h2>
                    <input type="text" name="userName" readonly value = "<?php echo $_SESSION['user_name'];?>">
                </div>
                <div>
                    <!-- Name input validation, checks based on error and displays accurate error message -->
                    <h2> roleID: </h2>
                    <input type="text" name="role_id" readonly value = "<?php echo $_SESSION['role_id'];?>">
                    <span class="error"> 
                        <?php 
                         
                        ?>
                    </span>
                </div>
                
                <div>
                    <!-- Name input validation, checks based on error and displays accurate error message -->
                    <h2> Password: </h2>
                    <input type="password" name="password" value = "">
                    <span class="error"> 
                        <?php 
                            if (isset($_GET["update"]))
                            {
                                $password = $_GET["update"];
                                if ($password == "passwordValidErr")
                                {
                                    echo '<p class = "error">* 1. password must be 8-20 characters </br>
                                    2. Not have any special characters besides / and . </br>
                                    3. / and . must not be used at the start, end, used together or used multiple times </br> </p>';
                                }
                                else if ($password == "passwordEmptyErr")
                                {
                                    echo '<p class = "error">* password must not be empty</p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                 
                </br>
                    <button type="submit" name="submitUpdateCustomer">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Create the initial window for the pop up -->                        
    <div id="DeleteCustomerModal" class="modal" 
        <?php
            //Used to redirect back to the form once the first button has been pressed
            if(isset($_GET["delete"]))
            {
                if ($_GET["delete"] != "true")
                {
                    echo "style = 'display:inline-block'";
                }
                else if($_GET["delete"] == "true")
                {
                    echo "style = 'display:none'";
                }
            }
        ?>>
        <!-- Creates the content within the pop up -->
        <div class="modal-content" >
            <span class="closeDeleteForm">&times;</span>
            <h1 style="left: -8%; position: relative;"> Do you wish to delete the following customer? </h1>
            <!-- creates the yes and no button and parses the primary key back to be deleted  -->
            <?php
                $pk = $_SESSION["user_name"];
                echo "<h1 style='left: 20%; position: relative;'> $pk </h1>";
                echo "<form action='account-delete-script.php' method='POST' event.preventDefault()>
                      <button style='width: 40%; left: -10%; position: relative;' type='submit' id='$pk' value ='$pk' name='submitDeleteAccount'>Yes</button>
                      <button style='width: 40%; left: -10%; position: relative; background-color: red;' type='submit' name='CancelDeleteAccount'>No</button> </form>";
            ?>  
        </div>
    </div>


</body>

</html>
<!-- Link the js file needed for pop up -->
<script src="scripts/accounts-popUp.js"></script>

<?php

//checks to see if updating was successful and provides input
if (isset($_GET["update"]))
{
    if ($_GET["update"] == "true")
    {
        echo "<p class = 'echo' id='tempEcho'>  Record successfuly updated </p>";
    }
    else if ($_GET["update"] == "false")
    {
        echo "<p class = 'echo' id='tempEcho'> Record was not updated successfuly </p>";
    }
}

//checks to see if deleting was successful and provides input
if (isset($_GET["delete"]))
{
    if ($_GET["delete"] == "true")
    {
        echo "<p class = 'echo' id='tempEcho'>  Record successfuly deleted </p>";
    }
    else if ($_GET["delete"] == "false")
    {
        echo "<p class = 'echo' id='tempEcho'> Record was not deleted successfuly </p>";
    }
}

?>