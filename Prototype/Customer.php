<!-- All code on this page has been completed by Jake.H 102090870 -->
<?php
    //start the session with the database
    session_start();
    //include database functions
    include_once("php-scripts/backend-connection.php");
    include_once("php-scripts/customer-db.php");
    include_once "php-scripts/utils.php";

    // dashboard side menu import (Dabin)
    include_once("php-scripts/dashboard-menu.php");

    //create the connection with the database
    $conn = new CustomerDBConnection();
?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" href="style/dashboard-style.css">
<link rel="stylesheet" href="style/popup.css">
<head>
    <!-- Header -->
    <title> Customers </title>
    <div class ="flexDisplay">
        <h1 class="header"> <a href="index.php"><img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo" /></a> Customers </h1>
        <a id="webpageDirect" name = "webpageDirect" href= 'index.php'> Back to website </a>
    </div>
</head>

<body>
    <div class="grid-container">
        <div class="menu">
            <?php printMenu("customer"); ?>
        </div>
        <div class="main">
            <?php
            //checks to see if inserting was successful and provides input
            if (isset($_GET["insert"]))
            {
                if ($_GET["insert"] == "true")
                {
                    echo "<p class = 'echo' id='tempEcho'>  Record successfuly created </p>";
                }
                else if ($_GET["insert"] == "false")
                {
                    echo "<p class = 'echo'>  Record was not created successfuly </p>";
                }
                else if ($_GET["insert"] == "duplicatePrimaryKey")
                {
                    echo "<p class = 'echo'> Primary Key is already taken </p>";
                }
            }

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
            <h1 id="content-header"> All Customers</h1>

            <!-- Add Customer pop up -->
            <button id="CustomerPopUp" class="CustomerPopUp">+ New Customer</button>

            <!-- List of current customers -->
            <table class="TableContent" id="data-table">
                <tr>
                    <?php
                        //Fetch data done by Alex, altered by Jake for customer table
                        //establishes the collumns in the table to be used in the query
                        $cols = "user_name, name, phone_number, email, street_address, suburb, post_code, licence_number, state";
                        //get the data from the table
                        $rows = $conn->get($cols);

                    //establish the headings that will be used to display the data in the table
                    $tableHeadings = "User Name, Name, Phone Number, Email, Residential Address, Suburb, Post Code, Drivers Licence Number, State";

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
                                        <form action='php-scripts/customer-update-script.php' method='POST' event.preventDefault() > <button type='submit' id= '$primaryKey' class='dropdown-element' name='UpdateButton'
                                        value='$primaryKey'> Update</button> </form>
                                        <form action='php-scripts/customer-delete-script.php' method='POST' event.preventDefault()> <button type='submit' name='deleteButton' id='$primaryKey' class='dropdown-element'
                                        value = '$primaryKey'>Delete</button> </form>
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
    <div id="CustomerModal" class="modal-overlay"<?php
            //checks to see if there was any errors and if there was, it will continue to display the modal
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

        <!-- Creates the content within the pop up -->
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <form action="php-scripts/customer-script.php" method="POST" event.preventDefault()>
                <div>
                    <span class="modal-error-v2">
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
                <h2> Create a customer </h2>
                <div>
                    <!-- User name input validation, checks based on error and displays accurate error message -->
                    <label> User Name: </label>
                    <!-- Recieves the current value of field that was used instead of wiping it clear -->
                    <?php
                        if (isset($_SESSION["customerInsertUserName"]))
                        {
                            $userName = $_SESSION["customerInsertUserName"];
                            echo "<input type='text' name='userName' value='$userName'>";
                        }
                        else
                        {
                            echo '<input type="text" name="userName">';
                        }
                    ?>
                    <span class="modal-error-v2">
                        <?php
                            if (isset($_GET["insert"]))
                            {
                                $userName = $_GET["insert"];
                                if ($userName == "userNameEmptyErr")
                                {
                                    echo '<p class = "modal-error-v2">* User name cannot be empty</p>';
                                }
                                else if ($userName == "userNameValidErr")
                                {
                                    echo '<p class = "modal-error-v2">* 1. User Name must be 8-20 characters </br>
                                               2. Not have any special characters besides / and . </br>
                                               3. / and . must not be used at the start, end, used together or used multiple times </br> </p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <!-- Name input validation, checks based on error and displays accurate error message -->
                    <label> Name: </label>
                     <!-- Recieves the current value of field that was used instead of wiping it clear -->
                    <?php
                        if (isset($_SESSION["customerInsertName"]))
                        {
                            $name = $_SESSION["customerInsertName"];
                            echo "<input type='text' name='name' value='$name'>";
                        }
                        else
                        {
                            echo '<input type="text" name="name">';
                        }
                    ?>
                    <span class="modal-error-v2">
                        <?php
                            if (isset($_GET["insert"]))
                            {
                                $name = $_GET["insert"];
                                if ($name == "nameEmptyErr")
                                {
                                    echo '<p class = "modal-error-v2">* Name cannot be empty</p>';
                                }
                                else if ($name == "nameValidErr")
                                {
                                    echo '<p class = "modal-error-v2">* Name is not in a valid format</p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <!-- Phone Number input validation, checks based on error and displays accurate error message -->
                    <label> Phone Number: </label>
                    <!-- Recieves the current value of field that was used instead of wiping it clear -->
                    <?php
                        if (isset($_SESSION["customerInsertPhoneNumber"]))
                        {
                            $phoneNumber = $_SESSION["customerInsertPhoneNumber"];
                            echo "<input type='text' name='phoneNumber' value='$phoneNumber'>";
                        }
                        else
                        {
                            echo '<input type="text" name="phoneNumber">';
                        }
                    ?>
                    <span class="modal-error-v2">
                        <?php
                            if (isset($_GET["insert"]))
                            {
                                $phoneNumber = $_GET["insert"];
                                if ($phoneNumber == "phoneNumberEmptyErr")
                                {
                                    echo '<p class = "modal-error-v2">* Phone number cannot be empty</p>';
                                }
                                else if ($phoneNumber == "phoneValidErr")
                                {
                                    echo '<p class = "modal-error-v2">* Phone number is not in the correct format</p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <!-- Email input validation, checks based on error and displays accurate error message -->
                    <label> Email: </label>
                    <!-- Recieves the current value of field that was used instead of wiping it clear -->
                    <?php
                        if (isset($_SESSION["customerInsertEmail"]))
                        {
                            $email = $_SESSION["customerInsertEmail"];
                            echo "<input type='text' name='email' value='$email'>";
                        }
                        else
                        {
                            echo '<input type="text" name="email">';
                        }
                    ?>
                    <span class="modal-error-v2">
                        <?php
                            if (isset($_GET["insert"]))
                            {
                                $email = $_GET["insert"];
                                if ($email == "emailEmptyErr")
                                {
                                    echo '<p class = "error">* Email cannot be empty</p>';
                                }
                                else if ($email == "emailValidErr")
                                {
                                    echo '<p class = "error">* Email format is not valid</p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <!-- Street Address input validation, checks based on error and displays accurate error message -->
                    <label> Residential Address: </label>
                    <!-- Recieves the current value of field that was used instead of wiping it clear -->
                    <?php
                        if (isset($_SESSION["customerInsertStreetAddress"]))
                        {
                            $streetAddress = $_SESSION["customerInsertStreetAddress"];
                            echo "<input style='width: 43%;' type='text' name='streetAddress' value='$streetAddress'>";
                        }
                        else
                        {
                            echo '<input style="width: 43%;" type="text" name="streetAddress">';
                        }
                    ?>
                    <span class="modal-error-v2">
                        <?php
                            if (isset($_GET["insert"]))
                            {
                                $streetAddress = $_GET["insert"];
                                if ($streetAddress == "streetAddressEmptyErr")
                                {
                                    echo '<p class = "error">* Street Address cannot be empty</p>';
                                }
                                else if ($streetAddress == "streetAddressValidErr")
                                {
                                    echo '<p class = "error">* Address format is not valid </p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <!-- Suburb input validation, checks based on error and displays accurate error message -->
                    <label> Suburb </label>
                    <!-- Recieves the current value of field that was used instead of wiping it clear -->
                    <?php
                        if (isset($_SESSION["customerInsertSuburb"]))
                        {
                            $suburb = $_SESSION["customerInsertSuburb"];
                            echo "<input type='text' name='suburb' value='$suburb'>";
                        }
                        else
                        {
                            echo '<input type="text" name="suburb">';
                        }
                    ?>
                    <span class="modal-error-v2">
                        <?php
                            if (isset($_GET["insert"]))
                            {
                                $suburb = $_GET["insert"];
                                if ($suburb == "suburbEmptyErr")
                                {
                                    echo '<p class = "error">* Suburb cannot be empty</p>';
                                }
                                else if ($suburb == "suburbValidErr")
                                {
                                    echo '<p class = "error">* Suburb format is not valid</p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <!-- Post Code input validation, checks based on error and displays accurate error message -->
                    <label> Post Code </label>
                    <!-- Recieves the current value of field that was used instead of wiping it clear -->
                    <?php
                        if (isset($_SESSION["customerInsertPostCode"]))
                        {
                            $postCode = $_SESSION["customerInsertPostCode"];
                            echo "<input type='text' name='postCode' value='$postCode'>";
                        }
                        else
                        {
                            echo '<input type="text" name="postCode">';
                        }
                    ?>
                    <span class="modal-error-v2">
                        <?php
                            if (isset($_GET["insert"]))
                            {
                                $postCode = $_GET["insert"];
                                if ($postCode == "postCodeEmptyErr")
                                {
                                    echo '<p class = "error">* Post code cannot be empty</p>';
                                }
                                else if ($postCode == "postCodeValidErr")
                                {
                                    echo '<p class = "error">* Post code must be 4 numbers </p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <!-- Licence number input validation, checks based on error and displays accurate error message -->
                    <label> Drivers Licence Number: </label>
                    <!-- Recieves the current value of field that was used instead of wiping it clear -->
                    <?php
                        if (isset($_SESSION["customerInsertLicenceNumber"]))
                        {
                            $licenceNumber = $_SESSION["customerInsertLicenceNumber"];
                            echo "<input style='width: 29%;' type='text' name='licenceNumber' value='$licenceNumber'>";
                        }
                        else
                        {
                            echo '<input style="width: 29%;" type="text" name="licenceNumber">';
                        }
                    ?>
                    <span class="modal-error-v2">
                        <?php
                            if (isset($_GET["insert"]))
                            {
                                $licenceNumber = $_GET["insert"];
                                if ($licenceNumber == "licenceNumberEmptyErr")
                                {
                                    echo '<p class = "error">* Licence number cannot be empty</p>';
                                }
                                else if ($licenceNumber == "licenceNumberValidErr")
                                {
                                    echo '<p class = "error">* Licence number must be 9 numbers </p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <!-- State input validation, checks based on error and displays accurate error message -->
                    <label> State </label>
                    <!-- Recieves the current value of field that was used instead of wiping it clear -->
                    <?php
                        if (isset($_SESSION["customerInsertState"]))
                        {
                            $state = $_SESSION["customerInsertState"];
                            printStates($state);
                        }
                        else
                        {
                            printStates("");
                        }
                    ?>
                    <span class="modal-error-v2">
                        <?php
                            if (isset($_GET["insert"]))
                            {
                                $state = $_GET["insert"];
                                if ($state == "stateEmptyErr")
                                {
                                    echo '<p class = "error">* State cannot be empty</p>';
                                }
                                else if ($state == "stateValidErr")
                                {
                                    echo '<p class = "error">* State must be an Australian state </p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                </br>
                <div>
                    <button id="formButton" type="submit" name="SubmitCustomer">Add</button>
                </div>
            </form>
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
            <form action="php-scripts/customer-update-script.php" method="POST" event.preventDefault()>
                <span class="modal-error-v2">
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
                <h2> Update a customer </h2>
                <div>
                    <!-- //Made User name not editable to ensure database intergrity  -->
                    <label> User Name: </label>
                    <input type="text" name="userName" readonly value = "<?php echo $_SESSION['user_name'];?>">
                </div>
                <div>
                    <!-- Name input validation, checks based on error and displays accurate error message -->
                    <label> Name: </label>
                    <input type="text" name="name" value = "<?php echo $_SESSION['name'];?>">
                    <span class="modal-error-v2">
                        <?php
                            if (isset($_GET["update"]))
                            {
                                $name = $_GET["update"];
                                if ($name == "nameEmptyErr")
                                {
                                    echo '<p class = "error">* Name cannot be empty</p>';
                                }
                                else if ($name == "nameValidErr")
                                {
                                    echo '<p class = "error">* Name is not in a valid format</p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <!-- Phone number validation, checks based on error and displays accurate error message -->
                    <label> Phone Number: </label>
                    <input type="text" name="phoneNumber" value = "<?php echo $_SESSION['phone_number'];?>">
                    <span class="modal-error-v2">
                        <?php
                            if (isset($_GET["update"]))
                            {
                                $phoneNumber = $_GET["update"];
                                if ($phoneNumber == "phoneNumberEmptyErr")
                                {
                                    echo '<p class = "error">* Phone number cannot be empty</p>';
                                }
                                else if ($phoneNumber == "phoneValidErr")
                                {
                                    echo '<p class = "error">* Phone number is not in the correct format</p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <!-- Email input validation, checks based on error and displays accurate error message -->
                    <label> Email: </label>
                    <input type="text" name="email" value = "<?php echo $_SESSION['email'];?>">
                    <span class="modal-error-v2">
                        <?php
                            if (isset($_GET["update"]))
                            {
                                $email = $_GET["update"];
                                if ($email == "emailEmptyErr")
                                {
                                    echo '<p class = "error">* Email cannot be empty</p>';
                                }
                                else if ($email == "emailValidErr")
                                {
                                    echo '<p class = "error">* Email format is not valid</p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <!-- Street address input validation, checks based on error and displays accurate error message -->
                    <label> Residential Address: </label>
                    <input style="width: 43%;" type="text" name="streetAddress" value = "<?php echo $_SESSION['street_address'];?>">
                    <span class="modal-error-v2">
                        <?php
                            if (isset($_GET["update"]))
                            {
                                $streetAddress = $_GET["update"];
                                if ($streetAddress == "streetAddressEmptyErr")
                                {
                                    echo '<p class = "error">* Street Address cannot be empty</p>';
                                }
                                else if ($streetAddress == "streetAddressValidErr")
                                {
                                    echo '<p class = "error">* Address format is not valid </p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <!-- Suburb input validation, checks based on error and displays accurate error message -->
                    <label> Suburb: </label>
                    <input type="text" name="suburb" value = "<?php echo $_SESSION['suburb'];?>">
                    <span class="modal-error-v2">
                        <?php
                            if (isset($_GET["update"]))
                            {
                                $suburb = $_GET["update"];
                                if ($suburb == "suburbEmptyErr")
                                {
                                    echo '<p class = "error">* Suburb cannot be empty</p>';
                                }
                                else if ($suburb == "suburbValidErr")
                                {
                                    echo '<p class = "error">* Suburb format is not valid</p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <!-- Post code input validation, checks based on error and displays accurate error message -->
                    <label> Post Code: </label>
                    <input type="text" name="postCode" value = "<?php echo $_SESSION['post_code'];?>">
                    <span class="modal-error-v2">
                        <?php
                            if (isset($_GET["update"]))
                            {
                                $postCode = $_GET["update"];
                                if ($postCode == "postCodeEmptyErr")
                                {
                                    echo '<p class = "error">* Post code cannot be empty</p>';
                                }
                                else if ($postCode == "postCodeValidErr")
                                {
                                    echo '<p class = "error">* Post code must be 4 numbers </p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <!-- Licence Number input validation, checks based on error and displays accurate error message -->
                    <label>Drivers Licence Number: </label>
                    <input style='width: 29%;' type="text" name="licenceNumber" value = "<?php echo $_SESSION['licence_number'];?>">
                    <span class="modal-error-v2">
                        <?php
                            if (isset($_GET["update"]))
                            {
                                $licenceNumber = $_GET["update"];
                                if ($licenceNumber == "licenceNumberEmptyErr")
                                {
                                    echo '<p class = "error">* Licence number cannot be empty</p>';
                                }
                                else if ($licenceNumber == "licenceNumberValidErr")
                                {
                                    echo '<p class = "error">* Licence number must be 9 numbers </p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <!-- State input validation, checks based on error and displays accurate error message -->
                    <label> State: </label>
                    <?php
                        if (isset($_SESSION["state"]))
                        {
                            $state = $_SESSION["state"];
                            printStates($state);
                        }
                        else
                        {
                            printStates("");
                        }
                    ?>
                    <span class="modal-error-v2">
                        <?php
                            if (isset($_GET["update"]))
                            {
                                $state = $_GET["update"];
                                if ($state == "stateEmptyErr")
                                {
                                    echo '<p class = "error">* State cannot be empty</p>';
                                }
                                else if ($state == "stateValidErr")
                                {
                                    echo '<p class = "error">* State must be an Australian state </p>';
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
                echo "<label> $pk </label>";
                echo "<form action='php-scripts/customer-delete-script.php' method='POST' event.preventDefault()>
                      <button style='width: 40%;' type='submit' id='$pk' value ='$pk' name='submitDeleteCustomer'>Yes</button>
                      <button style='width: 40%; background-color: red;' type='submit' name='CancelDeleteCustomer'>No</button> </form>";
            ?>
        </div>
    </div>


</body>

</html>
<!-- Link the js file needed for pop up -->
<script src="scripts/customer_popup.js"></script>
