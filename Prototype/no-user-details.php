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
            $error = $error . "<p class='error'>The phone number is invalid.</p>";
        }
        if (!validAddress($street) || empty($_POST['street_address'])){
            $error = $error . "<p class='error'>The street address is invalid.</p>";
        }
        if (!validName($suburb) || empty($_POST['suburb'])){
            $error = $error . "<p class='error'>The suburb is invalid.</p>";
        }
        if (!validPostCode($pcode)|| empty ($_POST['post_code'])){
            $error = $error . "<p class='error'>The post code is invalid.</p>";
        }
        if (!validState($state) || empty($_POST['state'])){
            $error = $error . "<p class='error'>The state is invalid.</p>";
        }
        if (!validLicenceNumber( $licence)||empty ($_POST['licence_number'])){
            $error = $error . "<p class='error'>The licence number is invalid.</p>";
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
    <head></head>
    <body>
        <header><?php include 'header.php'?></header>
        <div id = "main">
        <div class="banner">
            <div id="bannertext">
                <h1>Welcome </h1>
            </div>
        </div>
    </div>
        <?php 
            if ($error == "none"){
                echo "<h3>Before you proceed, we require more of your details. These will be used for your future bookings.</h3>";
            }else{
                echo "<p style='color:red;font-size: 12px;'>$error</p>";
            }
        ?> 
        <form action = "no-user-details.php" method = "POST" >
            <label for="phone_number">Phone Number: </label> 
            <input type="text" name="number"/><br><br>
            <label for="street_address">Street Address: </label>
            <input type="text" name ="street_address"/><br><br>
            <label for="suburb">Suburb: </label>
            <input type="text" name ="suburb"/><br><br>
            <label for="post_code">Post Code:</label>
            <input type="text" name ="post_code"/><br><br>        
            <label for="state">State: </label>
            <input type="text" name ="state"/><br><br>
            <label for="licence_number">Licence Number: </label>
            <input type="text" name ="licence_number"/><br><br>
            <input type="submit" value="Submit"/>
        </form>
        <footer><?php include 'footer.php'?></footer>
    </body>
</html>