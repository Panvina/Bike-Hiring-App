<?php
session_start();

date_default_timezone_set('Australia/Melbourne');

include_once("php-scripts/backend-connection.php");

//Linking utility functions associated with inventory
include("php-scripts/utils.php");

//Establishing database connection using mysqli()
$conn = new mysqli("localhost", "root", "", "bike_hiring_system");
?>
<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="./style/style.css">
    <title>Home</title>
</head>
<body>
    <header><?php include 'header.php' ?></header>
    <div id = "main">
        <div class="Homebanner">
            <div id="homebannertext">
                <h1 id="bannerH1"> Inverloch Bike Hire</h1>
                <p id="bannerP"> Start your adventure with us</p> 
                <button class="button">Hire now!</button>
            </div>
        </div>
        <div class='HomeMainCont'>  
            <?php
                $locationQuery = $conn->query("SELECT * FROM content_editing_table WHERE edit_name = 'home_about_us_image'");
                    while ($row = $locationQuery->fetch_assoc()) {
                        $edit_name = $row["edit_name"];
                        $edit_content = $row["edit_content"];
                        echo '<div class="HomeImg"><img class="filled-img" style= "height: 100%; width: 100%;" src="' . $edit_content . '" alt="About Us"/></div>';
                    }
                    ?>
            <!--<div class='HomeImg'><img style= "height: 100%; width: 100%;" src="./img/photos/5.jpg" alt="About Us"/></div>-->
            <div class='HomeTxt'><h1 id="HomeHeader"> ABOUT US</h1>
                <?php
                $locationQuery = $conn->query("SELECT * FROM content_editing_table WHERE edit_name = 'home_about_us_text'");
                    while ($row = $locationQuery->fetch_assoc()) {
                        $edit_name = $row["edit_name"];
                        $edit_content = $row["edit_content"];
                        echo '<div class="HomeDesc"><p>' . $edit_content . '</p></div>';
                    }
                    ?>
                <!--<div class='HomeDesc'><p>Explore the area and Rail Trails in comfort and style on an electric bike. We also have a range of standard bikes to suit your needs with a range of accessories available. We are a local family owned and operated business and pride ourselves on providing you with a unique experience while you enjoy what Inverloch and the sounding region has to offer. Whether your family have been holidaying here for years, you’re are having a weekend away or just simply visiting for the day we have an experience to suit everyone’s tastes and abilities.</p></div>-->
            </div>
        </div>

        <div class='HomeMainCont'>
            <div class='HomeTxt'><h1 id="HomeHeader">NEED HELP?</h1>
                <div class='HomeDesc'><p>Feel free to contact us and we are more than happy to help you plan the perfect bike hire experience!</p>
                <a href = "contactus.php"><button class="button">Contact Us</button></a>
                </div>
            </div>  
            <div class='HomeImg'><img class="filled-img" style= "height: 100%; width: 100%;" src="./img/photos/needhelp.jpg" alt="need help?
            "/></div>
        </div> 

        <div class='HomeMainCont'>  
            <div class='HomeImg'><img class="filled-img" style= "height: 100%; width: 100%;" src="./img/photos/new-to-inverloch.jpg" alt="About Us"/></div>
            <div class='HomeTxt'><h1 id="HomeHeader">NEW TO INVERLOCH?</h1>
                <div class='HomeDesc'><p>With so much to explore in the Bass Coast and South Gippsland, you are truly spoilt for choice. Take a trek up to Eagle’s Nest for a magnificent coastal outlook, or how about a re-energising walk along the beach that stretches as far as the eye can see.</p>
                <a href = "About.php"><button class="button">Learn More</button></a>
                </div>  
            </div>
        </div>
    </div>
    <footer><?php include 'footer.php'?></footer>
</body>
</html>
