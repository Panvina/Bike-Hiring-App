<?php

// Edit Index Page - Created by Eamon Kearney 102093549 //

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
    <title>Edit Home</title>
</head>
<style type="text/css">

body{
    margin: 0;
}

span{
    padding-right: 10px;
    line-height: 1.9;
    font-size: 18px;
    color: #172026;
    font-family: Comfortaa;
}

/*Style bottom navbar */

.bottomnavbar {
  overflow: hidden;
  background-color: rgba(255,0,0,0.5);
  position: fixed;
  bottom: 0;
  width: 100%;

}

/* Style the navbar */
#topnavbar {
  background-color: rgba(255,0,0,0.5);
  margin: 0, padding:0;
  position: fixed;
  width: 100%;
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

/* Style edit area */

fieldset {
    border: 1px dashed red;
    color:red;
    font-size:24px;
}

</style>
<body>
    <div id="topnavbar">
        <a href="editpages.php" style="color:black;font-size: 20px;padding: 10px;float:left;position: fixed;margin-top: 10px;font-weight: bold;">&larr; Back To Dashboard</a>
        <center>
            <h2>Editing Home Page</h2>
        </center>
    </div>
    <br><br><br>
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
                //SQL query to get display image from database
                $editImageQuery = $conn->query("SELECT * FROM content_editing_table WHERE edit_name = 'home_about_us_image'");
                    while ($row = $editImageQuery->fetch_assoc()) {
                        //Assign values to variables
                        $edit_name = $row["edit_name"];
                        $edit_content = $row["edit_content"];
                        // Echo to display image
                        echo '<div class="HomeImg"><img class="filled-img" id="home_image_id" style= "height: 100%; width: 100%;" src="' . $edit_content . '" alt="About Us"/></div>';
                    }
                    ?>
            <div class='HomeTxt'><h1 id="HomeHeader"> ABOUT US</h1>
                <?php
                //SQL query to get about text  from database
                $editTextQuery = $conn->query("SELECT * FROM content_editing_table WHERE edit_name = 'home_about_us_text'");
                    while ($row = $editTextQuery->fetch_assoc()) {
                        //assign values to variables
                        $edit_name = $row["edit_name"];
                        $edit_content = $row["edit_content"];
                        //print about us in editable field
                        echo '<fieldset>';
                        echo '<legend>EDIT HERE</legend>';
                        echo '<div style="outline:none;" class="HomeDesc"><span id="text_span" style="outline:none;" contenteditable="true">' . $edit_content . '</span></div>';
                        echo '</fieldset>';
                    }
                    ?>
                    <br>
                <button style="font-size: 32px;" onclick="updateForm()">Save Changes</button>
            </div>
        </div>
        <!-- Mirror of Index Page -->
        <div class='HomeMainCont'>
            <div class='HomeTxt'><h1 id="HomeHeader">NEED HELP?</h1>
                <div class='HomeDesc'><p>Feel free to contact us and we are more than happy to help you plan the perfect bike hire experience!</p>
                <a href = "contactus.php"><button class="button">Contact Us</button></a>
                </div>
            </div>  
            <div class='HomeImg'><img class="filled-img" style= "height: 100%; width: 100%;" src="./img/photos/needhelp.jpg" alt="About Us"/></div>
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
    <br><br><br><br>
    <div class="bottomnavbar" style="visibility: hidden;">
        <form id="formTest" action="editindexinsert.php" method="post">
            <?php
                $editTextQuery2 = $conn->query("SELECT * FROM content_editing_table WHERE edit_name = 'home_about_us_text'");
                    while ($row = $editTextQuery2->fetch_assoc()) {
                        $edit_name = $row["edit_name"];
                        $edit_content = $row["edit_content"];
                        echo '<input style="display:none" id="edit_content_text" type="text" name="edit_content_text" value="' . $edit_content . '">';
                        echo '<textarea id="edit_content_text2" style="resize:none;width:87%;" rows="5" readonly>' . $edit_content. '</textarea>';
                    }
                    ?>
            <input id="submitButton" style="float: right;font-size: 32px;height: 75px;" type="submit" value="Save Change">
            <p style="float: right; font-size: 24px;padding-right: 10px;">(Make sure to select <strong>Update Change</strong> before selecting <strong>Save Change</strong>)</p>
        </form>
    </div>
    <script type="text/javascript">
     //Function to update submit form with new text   
    function updateForm(){
        //Get new value from text form
        var currentText =  document.getElementById("text_span").innerHTML;
        //Set new value to submit form
        document.getElementById("edit_content_text").value = currentText;
        document.getElementById("edit_content_text2").value = currentText;
        //Submit form
        document.getElementById("formTest").submit();
    }

    // Function to make text field editable
    window.onload = function() {
        // Set variables
        var elements = document.getElementsByTagName("span"),i,element;
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
</body>
</html>
