<!-- The entire file is written by Vina Touch 101928802!-->
<?php 
    if(!isset($_SESSION)){ 
        session_start();     
    }
    if(isset($_POST['logout'])==true){
        $_SESSION = array();
        session_destroy();
        header("location: index.php");
        exit;
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Inverloch Bike Hire</title>
        <link rel="stylesheet" href="style/footer-header.css" type="text/css"/>
        <link rel="stylesheet" href="style/font-change.css" type="text/css"/>
    </head>
    <body>
        <header id="h">
            <div class="row">
                <div  id="nav">
                    <div class="column" id="logo">
                        <img class="logo" src="img/photos/IBH_top_logo.png" alt="business logo - a bike wheel is covered with waves. 'Inverloch bike hire' is written underneath" width="250px">
                    </div>
                    <div class="column">
                        <nav class="mainNav">
                            <ul id="menu">
                                <li><a href="index.php">Home</a></li>
                                <li><a href="makeabooking.php">Hire</a></li>
                                <li><a href="about.php">About Inverloch</a></li>
                                <li><a href="explore.php">About Cycling</a>
                                    <ul id="subNav">
                                        <li><a href="explore-local.php">Cycling in Out Region</a></li>
                                        <li><a href="explore-rail.php">Rail Trails</a></li>
                                    </ul>
                                </li>
                                <li><a href="contactus.php">Contact Us</a></li>
                                <?php 
                                    if(!isset($_SESSION["login-type"]) || $_SESSION["login-type"] != "customer"){
                                        echo include 'login.php';
                                    }else{
                                        echo "<li> <a href='booking-summary.php'>My Bookings</a></li>";
                                        echo "<li>
                                                <form action='header.php' method='post'>
                                                    <input type='hidden' name='logout' value='logout'>
                                                    <button type='submit'>Logout</button>
                                                </form></li>";
                                    }     
                                ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </header>
        <script>
        // Get the navbar
        var navbar = document.getElementById("nav");
        var menu = document.getElementById("menu");

        // When the user scrolls the page, execute myFunction
        window.onscroll = function() {stickyMenu()};
        // Get the offset position of the navbar
        var sticky = navbar.offsetTop;

        // Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
        function stickyMenu() {
        if (window.pageYOffset >= sticky) {
            navbar.classList.add("sticky")
        } else {
            navbar.classList.remove("sticky");
        }
        }
        </script>
    </body>
</html>
