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
<style type="text/css">
    
    span{
    padding-right: 10px;
    line-height: 1.9;
    font-size: 18px;
    color: #172026;
    font-family: Comfortaa;
}


.bottomnavbar {
  overflow: hidden;
  background-color: lightgrey;
  position: fixed;
  bottom: 0;
  width: 100%;
}

/* Style the navbar */
#topnavbar {
  overflow: hidden;
  background-color: red;
}

/* Navbar links */
#topnavbar a {
  float: left;
  display: block;
  color: #f2f2f2;
  text-align: center;
  padding: 14px;
  text-decoration: none;
}

/* Page content */
.content {
  padding: 16px;
}

/* The sticky class is added to the navbar with JS when it reaches its scroll position */
.sticky {
  position: fixed;
  top: 0;
  width: 100%;
}

/* Add some top padding to the page content to prevent sudden quick movement (as the navigation bar gets a new position at the top of the page (position:fixed and top:0) */
.sticky + .content {
  padding-top: 60px;
}


</style>
<body>
    <div id="topnavbar">
        <center><p style="color:white;font-size: 24px;">EDIT MODE</p></center>
        <a href="editpages.php" style="font-size: 32px;padding: 10px;">Go Back To Dashboard</a>
    </div>
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
                        echo '<div class="HomeImg"><img id="home_image_id" style= "height: 100%; width: 100%;" src="' . $edit_content . '" alt="About Us"/></div>';
                    }
                    ?>
            <!--<div class='HomeImg'><img style= "height: 100%; width: 100%;" src="./img/photos/5.jpg" alt="About Us"/></div>-->
            <div class='HomeTxt'><h1 id="HomeHeader"> ABOUT US</h1>

                <?php
                $locationQuery = $conn->query("SELECT * FROM content_editing_table WHERE edit_name = 'home_about_us_text'");
                    while ($row = $locationQuery->fetch_assoc()) {
                        $edit_name = $row["edit_name"];
                        $edit_content = $row["edit_content"];
                        echo '<div style="outline:none;" class="HomeDesc"><span id="text_span" style="outline:none;" contenteditable="true">' . $edit_content . '</span></div>';
                    }
                    ?>
                <button style="margin-left:25px;" onclick="updateForm()">Update</button>

                <!--<div class='HomeDesc'><p>Explore the area and Rail Trails in comfort and style on an electric bike. We also have a range of standard bikes to suit your needs with a range of accessories available. We are a local family owned and operated business and pride ourselves on providing you with a unique experience while you enjoy what Inverloch and the sounding region has to offer. Whether your family have been holidaying here for years, you’re are having a weekend away or just simply visiting for the day we have an experience to suit everyone’s tastes and abilities.</p></div>-->
            </div>
        </div>

        <div class='HomeMainCont'>
            <div class='HomeTxt'><h1 id="HomeHeader">NEED HELP?</h1>
                <div class='HomeDesc'><p>Feel free to contact us and we are more than happy to help you plan the perfect bike hire experience!</p>
                <a href = "contactus.php"><button class="button">Contact Us</button></a>
                </div>
            </div>  
            <div class='HomeImg'><img style= "height: 100%; width: 100%;" src="./img/photos/2.jpg" alt="About Us"/></div>
        </div> 

        <div class='HomeMainCont'>  
            <div class='HomeImg'><img style= "height: 100%; width: 100%;" src="./img/photos/6.jpg" alt="About Us"/></div>
            <div class='HomeTxt'><h1 id="HomeHeader">NEW TO INVERLOCH?</h1>
                <div class='HomeDesc'><p>With so much to explore in the Bass Coast and South Gippsland, you are truly spoilt for choice. Take a trek up to Eagle’s Nest for a magnificent coastal outlook, or how about a re-energising walk along the beach that stretches as far as the eye can see.</p>
                <a href = "About.php"><button class="button">Learn More</button></a>
                </div>  
            </div>
        </div>
    </div>
    <div class="bottomnavbar">
        <form action="editindexinsert.php" method="post">
            <div id="contentEditFormDiv">
            </div>
            <?php
                $locationQuery = $conn->query("SELECT * FROM content_editing_table WHERE edit_name = 'home_about_us_text'");
                    while ($row = $locationQuery->fetch_assoc()) {
                        $edit_name = $row["edit_name"];
                        $edit_content = $row["edit_content"];
                        echo '<input id="edit_content_text" type="text" name="edit_content_text" value="' . $edit_content . '">';
                    }
                    ?>
            <input type="submit" value="Save Changes">
        </form>
        <br><br>
    </div>
    <script type="text/javascript">


function updateForm(){
    var currentText =  document.getElementById("text_span").innerHTML;
    document.getElementById("edit_content_text").value = currentText;
    //var currentImage =  document.getElementById("home_image_id").src;
    //document.getElementById("edit_content_image").value = currentImage;
}


window.onload = function() {
    // Set variables
    var elements = document.getElementsByTagName("span"),
        i,
        element;
    // Loop through elements
    for (i = 0; i < elements.length; ++i) {
        element = elements[i];
        // Check if contentEditable true 
        if (element.contentEditable) {
        // Check if text loses focus
            span.onblur = function() {
            // Set text to current text
                var text = this.innerHTML;
                // Replace old text with new text
                text = text.replace(/&/g, "&amp").replace(/</g, "&lt;");
            };
        }
    }
};




</script>   
<script type="text/javascript">
    
// When the user scrolls the page, execute myFunction
window.onscroll = function() {myFunction()};

// Get the navbar
var navbar = document.getElementById("topnavbar");

// Get the offset position of the navbar
var sticky = navbar.offsetTop;

// Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}

</script>
</body>
</html>
