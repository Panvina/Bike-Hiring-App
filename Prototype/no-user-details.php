<!--The entirety of this file is completed by Vina Touch: 101928802-->
<?php 
    if(!isset($_SESSION)){ 
        session_start();     
    }
    if(!isset($_SESSION["login-type"]) || $_SESSION["login-type"] != "customer" || !isset($_SESSION["user-details"]) || $_SESSION["user-details"] == "yes"){
        header("location: index.php?Error403:AccessDenied");
        exit;
    }

    include_once 'person-dto.php';
    include_once "php-scripts/backend-connection.php" ;
    include_once 'php-scripts/utils.php';
    $error = "none";
    if(isset($_POST['number']) || isset($_POST['street_address']) || isset($_POST['suburb']) || isset($_POST['post_code']) 
    || isset($_POST['state']) || isset($_POST['licence_number'])){
        $error = "";
        $number = $_POST['number'];
        $street = $_POST['street_address'];
        $suburb = $_POST['suburb'];
        $pcode = $_POST['post_code'];
        $state = $_POST['state'];
        $licence = $_POST['licence_number'];
        if (!validMobileNumber($number) || empty($_POST['number'])){
            $error = $error . "The phone number is invalid.<br>";
        }
        if (!validAddress($street) || empty($_POST['street_address'])){
            $error = $error . "The street address is invalid.<br>";
        }
        if (!validName($suburb) || empty($_POST['suburb'])){
            $error = $error . "The suburb is invalid.<br>";
        }
        if (!validPostCode($pcode)|| empty ($_POST['post_code'])){
            $error = $error . "The post code is invalid.<br>";
        }
        if (!validState($state) || empty($_POST['state'])){
            $error = $error . "The state is invalid.<br>";
        }
        if (!validLicenceNumber( $licence)||empty ($_POST['licence_number'])){
            $error = $error . "The licence number is invalid.<br>";
        }
        if (empty($error) || isset($_GET['cusID'])){
            $cusID = $_SESSION['cusID'];
            $user = new PersonDTO($cusID);
            $cusID = $user->getUsername();
            $conn = new DBConnection("customer_table");
            if ($conn->update("user_name", "'$cusID'", "phone_number, street_address, suburb, post_code, licence_number, state",
            "$number,  $street, $suburb, $pcode, $licence, $state") == true){
                $_SESSION["user-details"] = "yes";
                header("Location: booking-summary.php?update=success");
                exit();
            }
        }
    }
?>
<html>
    <head>
        <link rel="stylesheet" href="style/cus-account-view.css" type="text/css"/>
        <link rel="stylesheet" href="style/style.css" type="text/css"/>
    </head>
    <body>
        <header><?php include 'header.php'?></header>
        <div id = "main">
        <div class="banner">
            <div id="bannertext">
                <h1>Welcome </h1>
            </div>
        </div>
    </div>
        <div class="form-div"><?php 
            if ($error == "none"){
                echo "<h3 class='no-details-form'>Before you proceed, we require more of your details. These will be used for your future bookings.</h3><br><br>";
            }else{
                echo "<p class='no-details-form' style='color:red;font-size: 12px;'>$error</p>";
            }
        ?> 
        <form class="no-details-form" action = "no-user-details.php" method = "POST" >
            <label for="phone_number">Phone Number: </label> 
            <input type="text" name="number"/><br><br>
            <label for="street_address">Street Address: </label>
            <input type="text" name ="street_address"/><br><br>
            <label for="suburb">Suburb: </label>
            <input type="text" name ="suburb"/><br><br>
            <label for="post_code">Post Code:</label>
            <input type="text" name ="post_code"/><br><br>        
            <div id='state'>
            <label for="state">State: </label>
            <select name="state">
            <option value="" selected disabled hidden>---</option>
            <option value="ATC">ACT</option>
            <option value="NSW">NSW</option>
            <option value="NT">NT</option>
            <option value="QLD">QLD</option>
            <option value="SA">SA</option>
            <option value="TAS">TAS</option>
            <option value="VIC">VIC</option>
            <option value="WA">WA</option>
            </select></div><br>
            <label for="licence_number">Licence Number: </label>
            <input type="text" name ="licence_number"/><br><br>
            <input id="sub-button" type="submit" value="Submit"/><br><br>
        </form></div></div>
        <footer><?php include 'footer.php'?></footer>
    </body>
</html>