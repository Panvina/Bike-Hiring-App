<!-- The entirety of this file is created and written by Vina Touch 101928802 -->
<?php
    if(!isset($_SESSION)){ 
        session_start();     
    }
    //if anyone other than the customer tries to this page in the url, they will be redirected.
    if(!isset($_SESSION["login-type"]) || $_SESSION["login-type"] != "customer"){
        header("location: index.php?Error403:AccessDenied");
        exit;
    }else{      //otherwise, show this page
        if(isset($_SESSION["user-details"]) && $_SESSION["user-details"] == "no"){
        header("location: no-user-details.php");
        exit;
        }
    } 

    include 'person-dto.php';
    include 'booking-dto.php';
    $email = $_SESSION["login-email"];
    $bookingDetail = new BookingDTO($email);
    $userDetail = new PersonDTO($email);
    $msg="";
    if (isset($_GET['msg'])){
        $msg = $_GET['msg'];
        if ($msg=="success"){
            $msg="<p class='success'>Your details have been updated!</p>";
        }
    }
    if (isset($_POST['updateDatabaseButton'])){
        if(isset($_POST['name']) || isset($_POST['pnum']) || isset($_POST['street_address']) || isset($_POST['suburb']) || isset($_POST['post_code']) 
        || isset($_POST['state']) || isset($_POST['email'])){
            $name = $_POST['name'];
            $number = $_POST['pnum'];
            $street = $_POST['street_address'];
            $suburb = $_POST['suburb'];
            $pcode = $_POST['post_code'];
            $state = $_POST['state'];
            $email = $_POST['email'];
            $msg = $userDetail->updateDetails($userDetail->getDetails(),$name,$number,$street,$suburb, $pcode,$state,$email);
            if ($msg=="true"){
                header("Location: booking-summary.php?msg=success");
                exit();
            }else{
                $msg="<p>Your details cannot be updated!</p>".$msg;
            }
        }
    }
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="./style/cus-account-view.css">
    <link rel="stylesheet" href="./style/style.css"/>
    <title>Booking Summary</title>
</head>
<body>
    <header><?php include_once 'header.php'?></header>
    <div id = "main">
        <div class="banner">
            <div id="bannertext">
                <h1> Booking Summary</h1>
            </div>
            <div class ="NavContainer">
                    <ul class="Breadcrumbs">
                        <li class="BreadcrumbsItem">
                            <a href="Index.php" class="BreadcrumbsURL">Home</a>
                        </li>
                        <li class="BreadcrumbsItem">
                            <a href="javascript:window.location.href=window.location.href" class="BreadcrumbsURL BreadcrumbsURLactive">Booking Summary</a>
                        </li>
                    </ul>
            </div>
        </div>
    </div>

    <?php 

    //if the user clicks the cancel buttton, a function from BookingsDBConnection class will delete the booking
    if (isset($_POST['cancelBookingID'])){
        $cancelBookingID = $_POST['cancelBookingID'];
        $bookingDBConn = new BookingsDBConnection();
        $bookingDBConn->deleteBooking($cancelBookingID);
    }
    $userDetail->getDetails();
    $name = $userDetail->getName();
    $pnum = $userDetail->getPhoneN();
    $address = $userDetail->getAddress();
    $pcode = $userDetail->getPostCode();
    $state = $userDetail->getState();
    $suburb = $userDetail->getSuburb();
    $email = $userDetail->getEmail();

    $wholeAddress= "$address " . "$suburb " . "$pcode " . " $state ";
   
    echo "<h1 id='greet-heading'>Hey $name, <br></h1>";?>
    <div class='section'> 
        <div class='col' id='col1'>
            <h2>Your Current Booking/s:</h2>
           <?php $bookingDetail->getDetails($email)?>
        </div>
        <div class='col' id='col2'>
            <h2>Your Booking Details:</h2>
            <?php
            if (empty($msg)){
                echo "<h3>To protect your private information, please contact us to update your driver's licence number.</h3>";
            }else{
                echo "$msg";
            }
            if (!isset($_POST['updateButton'])){
                echo "<div class='text' id=toUserDetails''>
                        <div class='text-col2'><h4>Name:</h4><p>$name</p><br>
                        <h4>Residential Address:</h4>
                        <p>$wholeAddress</p></div>
                        <div class='text-col'><h4>Phone Number:</h4>
                        <p>0$pnum</p><br>
                        <h4>Email:</h4>
                        <p>$email</p></div>
                    </div><br>";
                echo "<form action = 'booking-summary.php' method = 'POST' >
                    <button class='acc-button' type='submit' name='updateButton'>Update my Details</button>
                    </form>";
            }else{
                echo "<form action = 'booking-summary.php' method = 'POST' >
                <div class='text'>
                        
                        <div class='text-col2'><h4>Name:</h4>
                            <input type='text' name='name' value='$name'/>
                            <h4>Residential Address:</h4>
                            <input type='text' name ='street_address' placeholder='street' value='$address'/><br>
                            <input class='addressBox' type='text' name ='suburb' placeholder='suburb' value='$suburb'/>
                            <input class='addressBox' type='text' name ='post_code' placeholder='post code' value='$pcode'/>      
                            <input class='addressBox' type='text' name ='state' placeholder='state' value='$state'/></div>
                        <div class='text-col' id='text-field-col-2'><h4>Phone Number:</h4>
                            <input type='text' name='pnum' value='0$pnum'/><br>
                            <h4>Email:</h4>
                            <input type='text' name='email' value='$email'/></div>        

                </div>
                <button class='acc-button' type='submit' name='updateDatabaseButton'>Update</button>
                <a href='booking-summary.php'><button class='acc-button' type='text'>Cancel</button></a><br>
                </form>";
            }?>
        </div>
    </div>
    <footer><?php include 'footer.php'?></footer>
</body>
</html>