<?php
    session_start();
    //connection to the database

    include("backend-connection.php");
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
                $primaryKey = "Jake";
                

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
                    //echo $_SESSION["primaryKey"];
                    //print_r($_SESSION["primaryKey"]);
                    
                    //echo "<td>  <button id= '$primaryKey' class='UpdateCustomer' name='$primaryKey'> 
                    //Update Customer</button> </td> ";
                    // echo "<td>  <input type='submit' id= '$primaryKey' class='UpdateCustomer' name='$primaryKey' 
                    // value='Update Customer'> </td> </form>";
                    
                    //$update = $_SESSION["update"];
                    //echo $update;
                    //echo "<form action='customer-update-script.php' method='post' event.preventDefault() ><td>  <button type='submit' id= '$primaryKey' class='UpdateCustomer' name='updateCustomer' 
                    //value='$primaryKey'> Update Customer </button> </td> </form>";
                    echo "<form action='customer-update-script.php' method='post' event.preventDefault() ><td>  <button type='submit' id= '$primaryKey' class='UpdateCustomer' name='updateCustomer' 
                    value='$primaryKey'> Update Customer </button> </td> </form>";
                    echo "</tr>";
                }
            ?>
        </table>
    </div>

    <!-- Create the initial window for the pop up -->
    <div id="CustomerModal" class="modal">

        <!-- Creates the content within the pop up -->
        <div class="modal-content">
            <span class="close">&times;</span>
           <!--<form name="createCustomer" action="customer-script.php" method="get" event.preventDefault() onsubmit="return validateForm()> -->
           <form action="customer-script.php" method="get" event.preventDefault()>
                <h1> Create a customer </h1>
                <div>
                    <h2> User Name: </h2>
                    <input type="text" name="userName">
                    <span class="error"> 
                        <?php 
                            if (isset($_GET["insert"]))
                            {
                                $userName = $_GET["insert"];
                                if ($userName == "userName")
                                {
                                    echo 'var createCustomerModel = document.getElementById("CustomerModal");';
                                    echo 'createCustomerModel.style.display = "block";';
                                    echo '<p class="error">* Invalid user name</p>';
                                }
                            }
                        ?>
                    </span>
                </div>
                <div>
                    <h2> Name: </h2>
                    <input type="text" name="name" required>
                </div>
                <div>
                    <h2> Phone Number: </h2>
                    <input type="text" name="phoneNumber" required>
                </div>
                <div>
                    <h2> Email: </h2>
                    <input type="text" name="email" required>
                </div>
                <div>
                    <h2> Street Address </h2>
                    <input type="text" name="streetAddress" required>
                </div>
                <div>
                    <h2> Suburb </h2>
                    <input type="text" name="suburb" required>
                </div>
                <div>
                    <h2> Post Code </h2>
                    <input type="text" name="postCode" required>
                </div>
                <div>
                    <h2> Licence Number </h2>
                    <input type="text" name="licenceNumber" required>
                </div>
                <div>
                    <h2> State </h2>
                    <input type="text" name="state" required>
                </div>
                </br>
                <div>
                    <button type="submit" name="SubmitCustomer">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <div id="UpdateCustomerModal" class="modal" <?php
            if(isset($_GET["update"]))
            {
                if ($_GET["update"] == "true")
                {
                    echo "style = 'display:inline-block'";
                    unset($_GET);
                }
                else if($_GET["update"] == "false")
                {
                    echo "style = 'display:none'";
                    unset($_GET);
                }
            }
        ?>>

        <!-- Creates the content within the pop up -->
        <div class="modal-content" >
        
            <span class="updateFormClose">&times;</span>
            <form action="customer-update-script.php" method="get" event.preventDefault()>

                <h1> Update a customer </h1>
                <div>
                    <h2> User Name: </h2>
                    <input type="text" name="userName" disabled value = "<?php echo $_SESSION['user_name'];?>">
                </div>
                <div>
                    <h2> Name: </h2>
                    <input type="text" name="name" value = "<?php echo $_SESSION['name'];?>">
                </div>
                <div>
                    <h2> Phone Number: </h2>
                    <input type="text" name="phoneNumber" value = "<?php echo $_SESSION['phone_number'];?>">
                </div>
                <div>
                    <h2> Email: </h2>
                    <input type="text" name="email" value = "<?php echo $_SESSION['email'];?>">
                </div>
                <div>
                    <h2> Street Address </h2>
                    <input type="text" name="streetAddress" value = "<?php echo $_SESSION['street_address'];?>">
                </div>
                <div>
                    <h2> Suburb </h2>
                    <input type="text" name="suburb" value = "<?php echo $_SESSION['suburb'];?>">
                </div>
                <div>
                    <h2> Post Code </h2>
                    <input type="text" name="postCode" value = "<?php echo $_SESSION['post_code'];?>">
                </div>
                <div>
                    <h2> Licence Number </h2>
                    <input type="text" name="licenceNumber" value = "<?php echo $_SESSION['licence_number'];?>">
                </div>
                <div>
                    <h2> State </h2>
                    <input type="text" name="state" value = "<?php echo $_SESSION['state'];?>">
                </div>
                </br>
                    <button type="submit" name="SubmitCustomer"
                    <?php
                        unset($_GET);
                    ?>>Submit</button>
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