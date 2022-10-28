<!--The entirety of this file is completed by Vina Touch: 101928802-->
<?php 
    if(!isset($_SESSION)){ 
        session_start();     
    }
    //if anyone thats not the customer tries to access this page, redirect them back to the homepage
    if(!isset($_SESSION["login-type"]) || $_SESSION["login-type"] != "customer" || !isset($_SESSION["user-details"]) || $_SESSION["user-details"] == "yes"){
        header("location: index.php?Error403:AccessDenied");
        exit;
    }

    //include the files to instantiate objects
    include_once 'php-scripts/person-dto.php';
    include_once "php-scripts/backend-connection.php" ;
    include_once 'php-scripts/utils.php';
    $error = "";
    if(isset($_POST['number']) || isset($_POST['street_address']) || isset($_POST['suburb']) || isset($_POST['post_code']) 
    || isset($_POST['state']) || isset($_POST['licence_number'])){
        //also set the input details in sessions just so when they put in invalid data, they dont have to redo the whole form
        $number = $_POST['number'];
        $_SESSION["user-num"] = $number;
        $street = $_POST['street_address'];
        $_SESSION["user-street"] = $street;
        $suburb = $_POST['suburb'];
        $_SESSION["user-sub"] = $suburb;
        $pcode = $_POST['post_code'];
        $_SESSION["user-pcode"] = $pcode;
        $state = $_POST['state'];
        $_SESSION["user-state"] = $state;
        $licence = $_POST['licence_number'];
        $_SESSION["user-licence"] = $licence;

        //utilising validation functions from utils.php
        if (!validMobileNumber($number) || empty($_POST['number'])){
            $errNum = "The phone number has to be 10 digit numbers starting with 0.<br>";
            $error = "error";
        }
        if (!validAddress($street) || empty($_POST['street_address'])){
            $errSt ="The street address has to contain valid street names.<br>";
            $error = "error";
        }
        if (!validName($suburb) || empty($_POST['suburb'])){
            $errSub = "The suburb has to contain valid names.<br>";
            $error = "error";
        }
        if (!validPostCode($pcode)|| empty ($_POST['post_code'])){
            $errPC = "The post code has to contain 4 digit numbers.<br>";
            $error = "error";
        }
        if (empty($_POST['state'])){
            $errState="The state has to contain valid names.<br>";
            $error = "error";
        }
        if (!validLicenceNumber( $licence)||empty ($_POST['licence_number'])){
            $errLic="The licence number has to contain 10 digit numbers.<br>";
            $error = "error";
        }

        //if no errros are detected, update the details in the database for that customer IDD
        if (empty($error) || isset($_GET['cusID'])){
            $cusID = $_SESSION['cusID'];
            $user = new PersonDTO($cusID);
            $cusID = $user->getUsername();  //get the logged in customer ID
            $conn = new DBConnection("customer_table");
            if ($conn->update("user_name", "'$cusID'", "phone_number, street_address, suburb, post_code, licence_number, state",
            "$number,  $street, $suburb, $pcode, $licence, $state") == true){
                $_SESSION["user-details"] = "yes";      //to let the system know that the logged in user is no longer a new user
                header("Location: booking-summary.php?update=success");     //redirect them to the booking-summary page
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
        <div class="form-div">
        <h3 class='no-details-form'>Before you proceed, we require more of your details. These will be used for your future bookings.</h3><br><br> 

        <form class="no-details-form" action = "no-user-details.php" method = "POST" >
            <label for="phone_number">Phone Number: </label> 
            <input type="text" name="number" required value="<?php if(isset($_SESSION["user-num"])){echo $_SESSION["user-num"];} ?>"/><br>
            <p class="no-details-error"><?php (!empty($errNum)) ?  print_r($errNum) : ""; ?></p>
            <label for="street_address">Street Address: </label>
            <input type="text" name ="street_address" required value="<?php if(isset($_SESSION["user-street"])){echo $_SESSION["user-street"];} ?>"/><br>
            <p class="no-details-error"><?php (!empty($errSt)) ?  print_r($errSt) : ""; ?></p>
            <label for="suburb">Suburb: </label>
            <input type="text" name ="suburb" required value="<?php if(isset($_SESSION["user-sub"])){echo $_SESSION["user-sub"];} ?>"/><br>
            <p class="no-details-error"><?php (!empty($errSub)) ?  print_r($errSub) : ""; ?></p>
            <label for="post_code">Post Code:</label>
            <input type="text" name ="post_code" required value="<?php if(isset($_SESSION["user-pcode"])){echo $_SESSION["user-pcode"];} ?>"/><br>      
            <p class="no-details-error"><?php (!empty($errPC)) ?  print_r($errPC) : ""; ?></p>
            <div id='state'>
            <label for="state">State: </label>
            <select name="state">
            <option value="" selected disabled hidden>---</option>
            <option value="<?php if(isset($_SESSION["user-state"])){echo $_SESSION["user-state"];} ?>" selected hidden><?php if(isset($_SESSION["user-state"])){echo $_SESSION["user-state"];}?></option>
            <option value="ACT">ACT</option>
            <option value="NSW">NSW</option>
            <option value="NT">NT</option>
            <option value="QLD">QLD</option>
            <option value="SA">SA</option>
            <option value="TAS">TAS</option>
            <option value="VIC">VIC</option>
            <option value="WA">WA</option>
            </select></div>
            <p class="no-details-error"><?php (!empty($errState)) ?  print_r($errState) : ""; ?></p>
            <label for="licence_number">Licence Number: </label>
            <input type="text" name ="licence_number" required value="<?php if(isset($_SESSION["user-licence"])){echo $_SESSION["user-licence"];} ?>"/><br>
            <p class="no-details-error"><?php (!empty($errLic)) ?  print_r($errLic) : ""; ?></p>
            <br><input id="sub-button" type="submit" value="Submit"/><br><br>
        </form></div></div>
        <footer><?php include 'footer.php'?></footer>
    </body>
</html>