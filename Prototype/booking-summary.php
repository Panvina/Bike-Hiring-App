<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="./style/cus-account-view.css">
    <link rel="stylesheet" href="./style/style.css"/>
    <title>Booking Summary</title>
</head>
<body>
    <header><?php include 'header.php'?></header>
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
    $email = $_SESSION["login-email"];

    $userDetail = new PersonDTO($email);
    $userDetail->getDetails();
    echo "<h1 id='greet-heading'>Hey $email, <br></h1>";?>
    <div class="section"> 
        <div class="col" id="col1">
            <h3>Your Current Booking/s:</h3>
            <p>sdasdas</p>
        </div>
        <div class="col" id="col2">
            <h3>Your Booking Details:</h3>
            <div class="text">
                <div class="text-col"><h4>Name:</h4>
                    <h4>Address:</h4></div>
                <div class="text-col"><h4>Phone Number:</h4>
                    <h4>Email:</h4></div>
            </div>
        </div>
    </div>
    <footer><?php include 'footer.php'?></footer>
</body>
</html>