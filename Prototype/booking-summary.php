<?php
    if(!isset($_SESSION)){ 
        session_start();     
    }
    if(!isset($_SESSION["login-type"]) || $_SESSION["login-type"] != "customer"){
        header("location: index.php?Error403:AccessDenied");
        exit;
    }else{
        if(isset($_SESSION["user-details"]) && $_SESSION["user-details"] == "no"){
        header("location: no-user-details.php");
        exit;
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
    include 'person-dto.php';
    include 'booking-dto.php';
    $email = $_SESSION["login-email"];
    if (isset($_POST['cancelBookingID'])){
        $cancelBookingID = $_POST['cancelBookingID'];
        $bookingDBConn = new BookingsDBConnection();
        $bookingDBConn->deleteBooking($cancelBookingID);
    }
    $bookingDetail = new BookingDTO($email);
    $userDetail = new PersonDTO($email);
    $userDetail->getDetails();
    $name = $userDetail->getName();
    $pnum = $userDetail->getPhoneN();
    $address = $userDetail->getAddress();
    $email = $userDetail->getEmail();

    echo "<h1 id='greet-heading'>Hey $name, <br></h1>";?>
    <div class='section'> 
        <div class='col' id='col1'>
            <h2>Your Current Booking/s:</h2>
           <?php $bookingDetail->getDetails($email)?>
        </div>
        <div class='col' id='col2'>
            <h3>Your Booking Details:</h3>
            <div class='text'>
                <div class='text-col2'><h4>Name:</h4>
                    <?php echo "<p class='beforeUpdate'>$name</p><br>
                    <h4>Address:</h4>
                    <p class='beforeUpdate'>$address</p></div>
                <div class='text-col'><h4>Phone Number:</h4>
                    <p class='beforeUpdate'>$pnum</p><br>
                    <h4>Email:</h4>
                    <p class='beforeUpdate'>$email</p></div>" ?>
            </div>
        </div>
    </div>
    <footer><?php include 'footer.php'?></footer>
</body>
</html>