<!-- All code on this page has been completed by Jake.H 102090870 -->
<?php
    session_start();
    //connection to the database

    include_once("backend-connection.php");
    include_once "utils.php";
    $conn = new DBConnection("customer_table");
?>

<!DOCTYPE html>
<html>
<link rel="stylesheet" href="style/Jake_style.css">

<head>
    <!-- Header -->
    <title> Customers </title>
    <h1 class="header"> <img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo" /> Customers </h1>
</head>

<body>
    <!-- Side navigation -->
    <nav>
        <div class="sideNavigation">
            <a href="Dashboard.php"> <img src="img/icons/bulletin-board.png" alt="Dashboard Logo" /> Dashboard </a> <br>
            <a class="active" href="Customer.php"> <img src="img/icons/account-group.png" alt="Customer Logo" />
                Customer </a> <br>
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
        <h1> All Customers</h1>

        <!-- Search bar with icons -->
        <img src="img/icons/account-search.png" alt="Customer Search Logo" />
        <input type="text" placeholder="Search">

        <!-- Add Customer pop up -->
       
        <button id="CustomerPopUp" class="CustomerPopUp">+ New Customer</button>

        <!-- List of current customers -->
        <table class="TableContent">
            <tr>
                <?php
                    $cols = "user_name, name, phone_number, email, street_address, suburb, post_code, licence_number, state";
                    $rows = $conn->get($cols);
     
                    $tableHeadings = "User Name, Name, Phone Number, Email, Street Address, Suburb, Post Code, Licence Number, State";

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
                    // echo "<form action='customer-update-script.php' method='POST' event.preventDefault() ><td> <button type='submit' id= '$primaryKey' class='UpdateCustomer' name='updateCustomer' 
                    // value='$primaryKey'> Update Customer </button> </td> </form>";
                    // echo "</tr>";

                    echo 
                        "<td>  
                        <div class='dropdown'>
                            <button class='dropbtn' disabled>...</button>
                            <div class='dropdown-content'>
                                <button type='submit' name='deleteLocation' id='deleteLocation' class='deleteLocation'>Delete</button><br/>
                                <form action='customer-update-script.php' method='POST' event.preventDefault() > <button type='submit' id= '$primaryKey' class='UpdateCustomer' name='updateCustomer' 
                                value='$primaryKey'> Update Customer </button> </form>
                            </div>
                        </div>
                        </td>";
                    
                    echo "</tr>";
                }
            ?>
        </table>
    </div>

    <!-- Create the initial window for the pop up -->
    <div id="CustomerModal" class="modal"<?php
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
            <span class="close">&times;</span>
           <!--<form name="createCustomer" action="customer-script.php" method="get" event.preventDefault() onsubmit="return validateForm()> -->
           <form action="customer-script.php" method="POST" event.preventDefault()>
                <h1> Create a customer </h1>
                <div>
                    <h2> User Name: </h2>
                    <input type="text" name="userName">
                    <span class="error"> 
                        <?php 
                            if (isset($_GET["insert"]))
                            {
                                $userName = $_GET["insert"];
                                if ($userName == "userNameEmptyErr")
                                {
                                    echo '<p>* User name cannot be empty</p>';
                                }
                                else if ($userName == "userNameValidErr")
                                {
                                    echo '<p>* 1. User Name must be 8-20 characters </br>
                                               2. Not have any special characters besides / and . </br>
                                               3. / and . must not be used at the start, end, used together or used multiple times </br> </p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <h2> Name: </h2>
                    <input type="text" name="name">
                    <span class="error"> 
                        <?php 
                            if (isset($_GET["insert"]))
                            {
                                $name = $_GET["insert"];
                                if ($name == "nameEmptyErr")
                                {
                                    echo '<p>* Name cannot be empty</p>';
                                }
                                else if ($name == "nameValidErr")
                                {
                                    echo '<p>* Name is not in a valid format</p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <h2> Phone Number: </h2>
                    <input type="text" name="phoneNumber">
                    <span class="error"> 
                        <?php 
                            if (isset($_GET["insert"]))
                            {
                                $phoneNumber = $_GET["insert"];
                                if ($phoneNumber == "phoneNumberEmptyErr")
                                {
                                    echo '<p>* Phone number cannot be empty</p>';
                                }
                                else if ($phoneNumber == "phoneValidErr")
                                {
                                    echo '<p>* Phone number is not in the correct format</p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <h2> Email: </h2>
                    <input type="text" name="email">
                    <span class="error"> 
                        <?php 
                            if (isset($_GET["insert"]))
                            {
                                $email = $_GET["insert"];
                                if ($email == "emailEmptyErr")
                                {
                                    echo '<p>* Email cannot be empty</p>';
                                }
                                else if ($email == "emailValidErr")
                                {
                                    echo '<p>* Email format is not valid</p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <h2> Street Address </h2>
                    <input type="text" name="streetAddress">
                    <span class="error"> 
                        <?php 
                            if (isset($_GET["insert"]))
                            {
                                $streetAddress = $_GET["insert"];
                                if ($streetAddress == "streetAddressEmptyErr")
                                {
                                    echo '<p>* Street Address cannot be empty</p>';
                                }
                                else if ($streetAddress == "streetAddressValidErr")
                                {
                                    echo '<p>* Address format is not valid </p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <h2> Suburb </h2>
                    <input type="text" name="suburb">
                    <span class="error"> 
                        <?php 
                            if (isset($_GET["insert"]))
                            {
                                $suburb = $_GET["insert"];
                                if ($suburb == "suburbEmptyErr")
                                {
                                    echo '<p>* Suburb cannot be empty</p>';
                                }
                                else if ($suburb == "suburbValidErr")
                                {
                                    echo '<p>* Suburb format is not valid</p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <h2> Post Code </h2>
                    <input type="text" name="postCode">
                    <span class="error"> 
                        <?php 
                            if (isset($_GET["insert"]))
                            {
                                $postCode = $_GET["insert"];
                                if ($postCode == "postCodeEmptyErr")
                                {
                                    echo '<p>* Post code cannot be empty</p>';
                                }
                                else if ($postCode == "postCodeValidErr")
                                {
                                    echo '<p>* Post code must be 4 numbers </p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <h2> Licence Number </h2>
                    <input type="text" name="licenceNumber">
                    <span class="error"> 
                        <?php 
                            if (isset($_GET["insert"]))
                            {
                                $licenceNumber = $_GET["insert"];
                                if ($licenceNumber == "licenceNumberEmptyErr")
                                {
                                    echo '<p>* Licence number cannot be empty</p>';
                                }
                                else if ($licenceNumber == "licenceNumberValidErr")
                                {
                                    echo '<p>* Licence number must be 9 numbers </p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <h2> State </h2>
                    <input type="text" name="state">
                    <span class="error"> 
                        <?php 
                            if (isset($_GET["insert"]))
                            {
                                $state = $_GET["insert"];
                                if ($state == "stateEmptyErr")
                                {
                                    echo '<p>* State cannot be empty</p>';
                                }
                                else if ($state == "stateValidErr")
                                {
                                    echo '<p>* State must be an Australian state </p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                </br>
                <div>
                    <button type="submit" name="SubmitCustomer">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <div id="UpdateCustomerModal" class="modal" <?php
            // if(isset($_GET["update"]))
            // {
            //     if ($_GET["update"] == "notEmpty")
            //     {
            //         echo "style = 'display:inline-block'";
            //         //unset($_GET[);
            //     }
            //     else if($_GET["update"] == "empty")
            //     {
            //         echo "style = 'display:none'";
            //         //($_GET[);
            //     }
            // }
            if(isset($_GET["update"]))
            {
                if ($_GET["update"] != "true")
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
        <div class="modal-content" >
        
            <span class="updateFormClose">&times;</span>
            <form action="customer-update-script.php" method="POST" event.preventDefault()>

                <h1> Update a customer </h1>
                <div>
                    <h2> User Name: </h2>
                    <input type="text" name="userName" readonly value = "<?php echo $_SESSION['user_name'];?>">
                </div>
                <div>
                    <h2> Name: </h2>
                    <input type="text" name="name" value = "<?php echo $_SESSION['name'];?>">
                    <span class="error"> 
                        <?php 
                            if (isset($_GET["update"]))
                            {
                                $name = $_GET["update"];
                                if ($name == "nameEmptyErr")
                                {
                                    echo '<p>* Name cannot be empty</p>';
                                }
                                else if ($name == "nameValidErr")
                                {
                                    echo '<p>* Name is not in a valid format</p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <h2> Phone Number: </h2>
                    <input type="text" name="phoneNumber" value = "<?php echo $_SESSION['phone_number'];?>">
                    <span class="error"> 
                        <?php 
                            if (isset($_GET["update"]))
                            {
                                $phoneNumber = $_GET["update"];
                                if ($phoneNumber == "phoneNumberEmptyErr")
                                {
                                    echo '<p>* Phone number cannot be empty</p>';
                                }
                                else if ($phoneNumber == "phoneValidErr")
                                {
                                    echo '<p>* Phone number is not in the correct format</p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <h2> Email: </h2>
                    <input type="text" name="email" value = "<?php echo $_SESSION['email'];?>">
                    <span class="error"> 
                        <?php 
                            if (isset($_GET["update"]))
                            {
                                $email = $_GET["update"];
                                if ($email == "emailEmptyErr")
                                {
                                    echo '<p>* Email cannot be empty</p>';
                                }
                                else if ($email == "emailValidErr")
                                {
                                    echo '<p>* Email format is not valid</p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <h2> Street Address </h2>
                    <input type="text" name="streetAddress" value = "<?php echo $_SESSION['street_address'];?>">
                    <span class="error"> 
                        <?php 
                            if (isset($_GET["update"]))
                            {
                                $streetAddress = $_GET["update"];
                                if ($streetAddress == "streetAddressEmptyErr")
                                {
                                    echo '<p>* Street Address cannot be empty</p>';
                                }
                                else if ($streetAddress == "streetAddressValidErr")
                                {
                                    echo '<p>* Address format is not valid </p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <h2> Suburb </h2>
                    <input type="text" name="suburb" value = "<?php echo $_SESSION['suburb'];?>">
                    <span class="error"> 
                        <?php 
                            if (isset($_GET["update"]))
                            {
                                $suburb = $_GET["update"];
                                if ($suburb == "suburbEmptyErr")
                                {
                                    echo '<p>* Suburb cannot be empty</p>';
                                }
                                else if ($suburb == "suburbValidErr")
                                {
                                    echo '<p>* Suburb format is not valid</p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <h2> Post Code </h2>
                    <input type="text" name="postCode" value = "<?php echo $_SESSION['post_code'];?>">
                    <span class="error"> 
                        <?php 
                            if (isset($_GET["update"]))
                            {
                                $postCode = $_GET["update"];
                                if ($postCode == "postCodeEmptyErr")
                                {
                                    echo '<p>* Post code cannot be empty</p>';
                                }
                                else if ($postCode == "postCodeValidErr")
                                {
                                    echo '<p>* Post code must be 4 numbers </p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <h2> Licence Number </h2>
                    <input type="text" name="licenceNumber" value = "<?php echo $_SESSION['licence_number'];?>">
                    <span class="error"> 
                        <?php 
                            if (isset($_GET["update"]))
                            {
                                $licenceNumber = $_GET["update"];
                                if ($licenceNumber == "licenceNumberEmptyErr")
                                {
                                    echo '<p>* Licence number cannot be empty</p>';
                                }
                                else if ($licenceNumber == "licenceNumberValidErr")
                                {
                                    echo '<p>* Licence number must be 9 numbers </p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <h2> State </h2>
                    <input type="text" name="state" value = "<?php echo $_SESSION['state'];?>">
                    <span class="error"> 
                        <?php 
                            if (isset($_GET["update"]))
                            {
                                $state = $_GET["update"];
                                if ($state == "stateEmptyErr")
                                {
                                    echo '<p>* State cannot be empty</p>';
                                }
                                else if ($state == "stateValidErr")
                                {
                                    echo '<p>* State must be an Australian state </p>';
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


</body>

</html>
<!-- Link the js file needed for pop up -->
<script src="scripts/customer_popup.js"></script>

<?php

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
}

if (isset($_GET["update"]))
{
    if ($_GET["update"] == "true")
    {
        echo "<p class = 'echo' id='tempEcho'>  Record successfuly updated </p>";
    }
    else if ($_GET["insert"] == "false")
    {
        echo "<p class = 'echo' id='tempEcho'> Record was not updated successfuly </p>";
    }
}

?>