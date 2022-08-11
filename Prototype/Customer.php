<?php
    //connection to the database
    include("backend-connection.php");
    $conn = new DBConnection("localhost", "root", "", "bike_hiring_system");
?>


<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="style/Jake_style.css">
    <head>
        <!-- Header -->
        <title> Customers </title>
        <h1 class="header"> <img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo"/> Customers </h1>
    </head>
    <body>
        <!-- Side navigation -->
        <nav>
            <div class = "sideNavigation">
                <a href = "Dashboard.php"> <img src= "img/icons/bulletin-board.png" alt="Dashboard Logo" /> Dashboard </a> <br>
                <a class="active" href = "Customer.php"> <img src= "img/icons/account-group.png" alt="Customer Logo" />  Customer  </a> <br>
                <a href= "Inventory.php"> <img src= "img/icons/bicycle.png" alt="Inventory Logo" />  Inventory </a> <br>
                <a href= "Bookings.php"> <img src= "img/icons/book-open-blank-variant.png" alt="Bookings Logo" /> Bookings </a> <br>
                <a href= "Block_Out_Date.php"> <img src= "img/icons/calendar.png" alt="Block out date Logo" /> Block Out Dates </a> <br>
                <a href= "Locations.php"> <img src= "img/icons/earth.png" alt="Locations Logo" /> Locations </a> <br>
            </div>
         </nav>

         
         <!-- Block of content in center -->
         <div class="Content">
           <h1> All Customers</h1>

           <!-- Search bar with icons --> 
           <img src="img/icons/account-search.png" alt="Customer Search Logo"/>
           <input type="text"  placeholder="Search">

           <!-- Add Customer pop up -->
           <button id="login-launch-btn">+ New Customer</button>

           <div id="login-overlay" class="modal-overlay" >
                <div class="modal-content">

                </div>
           </div>


           <!-- Trigger/Open The Modal -->
        <button  id="login-launch-btn">Login</button>
        <br/>
        <button style="margin-top: 10px;" id="create-account-launch-btn">Create Account</button>

        <!-- Login Popup -->
        <div id="login-overlay" class="modal-overlay">
            <!-- Login Popup Content -->
            <div class="modal-content">
                <span class="close-btn">&times;</span>
                <p class="centre-text modal-content-header">SIGN IN</p>
                <?php
                    if (isset($_GET["login"]))
                    {
                        $loginVar = $_GET["login"];

                        if ($loginVar == "empty")
                        {
                            echo '<p class="error">Empty inputs</p>';
                        }
                        elseif ($loginVar == "email")
                        {
                            echo '<p class="error">Invalid email</p>';
                        }
                    }
                ?>
                <form action="login-script.php" method="POST">
                    <input
                        name="login-email"
                        class="centre-element input-window-format"
                        type="text"
                        placeholder="EMAIL ADDRESS"
                        style="margin-bottom: 7px;"
                        <?php
                            if (isset($_SESSION["login-email"]))
                            {
                                $email = $_SESSION["login-email"];
                                echo "value='$email'";
                            }
                        ?>
                    />
                    <br>
                    <input
                        name="login-password"
                        class="centre-element input-window-format"
                        type="password"
                        placeholder="PASSWORD"
                    />
                    <p style="margin-top: 0px; transform: translate(0, -15px);" class="centre-text"><a href="https://blank.org" class="no-text-decoration">Forgot Password</a></p>
                    <button type="submit" name="login-submit" >LOGIN</button>
                </form>
                <p class="decorated-lines no-vertical-margins" style="transform: translate(0, -10px);">OR</p>
                <button id="login-create-account-btn" style="margin-top: 15px;" class="centre-element modal-btn create-account-option-btn">CREATE AN ACCOUNT</button>
            </div>
        </div>

           <!-- List of current customers -->
           <table class="TableContent">
                <tr>
                    <th> Name </th>
                    <th> Phone Number </th>
                    <th> Email </th>
                    <th> Address </th>
                    <th> Licence Number </th>
                    <th> Username </th>
                </tr>
                <tr>
                    <td> John Smith </td>
                    <td> 012345678 </td>
                    <td> JohnSmith@gmail.com </td>
                    <td> Johns Address </td>
                    <td> 0123456 </td>
                    <td> JohhnySmithy </td>
                </tr>
           </table>
        </div>
        <script src="scripts/customer_popUp.js"></script>

        <script src="scripts/login-js.php"></script>
        <script>
            <?php
                if (isset($_GET["login"]))
                {
                    $loginVar = $_GET["login"];

                    if ($loginVar != "success")
                    {
                        echo 'var login_modal = document.getElementById("login-overlay");';
                        echo 'login_modal.style.display = "block";';
                    }
                }
                elseif (isset($_GET["ca"]))
                {
                    $caVar = $_GET["ca"];

                    if ($caVar != "success")
                    {
                        echo 'var create_account_modal = document.getElementById("create-account-overlay");';
                        echo 'create_account_modal.style.display = "block";';
                    }
                }
            ?>
        </script>
    </body>
</html>