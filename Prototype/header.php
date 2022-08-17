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
                            <li><a class="remove-link-decorations" href="index.php">Home</a></li>
                            <li><a class="remove-link-decorations" href="">Hire</a></li>
                            <li><a class="remove-link-decorations" href="about.php">About Inverloch</a></li>
                            <li><a class="remove-link-decorations" href="explore.php">About Cycling</a>
                                <ul id="subNav">
                                    <li><a class="remove-link-decorations" href="explore-local.php">Cycling in Out Region</a></li>
                                    <li><a class="remove-link-decorations" href="explore-rail.php">Rail Trails</a></li>
                                </ul>
                            </li>
                            <li><a class="remove-link-decorations" href="contactus.php">Contact Us</a></li>
                            <!--<li id="login">Login</li>-->
                            <li><?php include 'login.php'?></li>
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
        window.onscroll = function() {myFunction()};
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
