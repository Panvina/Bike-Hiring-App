<!-- All code on this page has been completed by Jake.H 102090870 -->
<?php
    //start the session with the database
    session_start();
    //include database functions
    include_once "php-scripts\bike-inventory-db.php";
    include_once "php-scripts\utils.php";

    // dashboard side menu import (Dabin)
    include_once("php-scripts/dashboard-menu.php");
    if($_SESSION["login-type"] == "employee"){
        header("location: dashboard.php?Error403:AccessDenied");
        exit;}
    //create the connection with the database
    $conn = new DBConnection("accounts_table");
?>
<html>
<link rel="stylesheet" href="style/dashboard-style.css">
<link rel="stylesheet" href="style/popup.css">
<head>
    <!-- Header -->
    <title> Accounts </title>
    <div class ="flexDisplay">
        <h1 class="header"> <a href="index.php"><img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo" /></a> Accounts </h1>
        <a id="webpageDirect" name = "webpageDirect" href= 'index.php'> Back to website </a>
    </div>
</head>

<body>
    <div class="grid-container">
        <div class="menu">
            <?php printMenu("account"); ?>
        </div>
        <div class="main">
            <h1> Roles </h1>
                <table class="TableContent">
                    <tr>
                        <th> Role </th>
                        <th> Description </th>
                    </tr>
                    <!-- Print roles (Dabin) -->
                    <?php
                        // Get roles
                        $tmpCon = new DBConnection("authorisation_table");
                        $rows = $tmpCon->get("*");
                        for($i = 0; $i < count($rows); $i++)
                        {
                            $row = $rows[$i];

                            $roleId = $row["role_id"];
                            $desc = $row["description"];
                            echo "<tr>";
                            echo "<td>$roleId</td>";
                            echo "<td>$desc</td>";
                            echo "</tr>";
                        }
                    ?>
                </table>
            <h1> All Accounts</h1>

            <!-- List of current customers -->
            <table class="TableContent" id="data-table">
                <tr>
                    <?php
                        //Fetch data done by Alex, altered by Jake for customer table
                        //establishes the collumns in the table to be used in the query
                        $cols = "user_name, role_id";
                        //get the data from the table
                        $rows = $conn->get($cols);

                        //establish the headings that will be used to display the data in the table
                        $tableHeadings = "User Name, Role";

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
                            "<td class='editcolumn'>
                            <div class='dropdown'>
                                <button class='dropbtn' disabled>...</button>
                                <div class='dropdown-content'>
                                    <form action='php-scripts\accounts-update-script.php' method='POST' event.preventDefault() > <button type='submit' id= '$primaryKey' class='dropdown-element' name='UpdateButton'
                                    value='$primaryKey'> Update </button> </form>
                                    <form action='php-scripts\account-delete-script.php' method='POST' event.preventDefault()> <button type='submit' name='deleteButton' id='$primaryKey' class='dropdown-element'
                                    value = '$primaryKey'> Delete </button> </form>
                                </div>
                            </div>
                            </td>";

                        echo "</tr>";
                    }
                ?>
            </table>
        </div>
    </div>

     <!-- Create the initial window for the pop up -->
    <div id="UpdateCustomerModal" class="modal-overlay" <?php
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

            <span class="close-btn">&times;</span>
            <form action="php-scripts\accounts-update-script.php" method="POST" event.preventDefault()>

                <h2> Update a customer </h2>
                <div>
                    <!-- //Made User name not editable to ensure database intergrity  -->
                    <label> User Name: </label>
                    <input type="text" name="userName" readonly value = "<?php echo $_SESSION['user_name'];?>">
                </div>
                <div>
                    <!-- Name input validation, checks based on error and displays accurate error message -->
                    <label> roleID: </label>
                    <input type="text" name="role_id" value = "<?php echo $_SESSION['role_id'];?>">
                    <span class="error">
                        <?php
                            if (isset($_GET["update"]))
                            {
                                $roleID = $_GET["update"];
                                if ($roleID == "roleIDValidErr")
                                {
                                    echo '<p class = "error">* RoleID Can only either be 1 (owner), 2 (employee) or 3 (customer) </br> </p>';
                                }
                                else if ($roleID == "roleIDEmptyErr")
                                {
                                    echo '<p class = "error">* RoleID must not be empty</p>';
                                }
                            }
                        ?>
                    </span>
                </div>

                <div>
                    <!-- Name input validation, checks based on error and displays accurate error message -->
                    <label> Password: </label>
                    <input type="password" name="password" value = "<?php echo $_SESSION['password'];?>">
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
                    <button id="formButton" type="submit" name="submitUpdateCustomer">Update</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Create the initial window for the pop up -->
    <div id="DeleteCustomerModal" class="modal-overlay"
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
            <span class="close-btn">&times;</span>
            <h2> Do you wish to delete the following customer? </h2>
            <!-- creates the yes and no button and parses the primary key back to be deleted  -->
            <?php
                $pk = $_SESSION["user_name"];
                echo "<label style='word-wrap: break-word;'> $pk </label>";
                echo "<form action='php-scripts\account-delete-script.php' method='POST' event.preventDefault()>
                      <button style='width: 40%;' type='submit' id='$pk' value ='$pk' name='submitDeleteAccount'>Yes</button>
                      <button style='width: 40%; background-color: red;' type='submit' name='CancelDeleteAccount'>No</button> </form>";
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
