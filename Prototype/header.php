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
    //added a session to retrieve an active state of which page has been clicked by the user
    $activeLink="";
    if(isset($_SESSION['active'])){
        $activeLink=$_SESSION['active'];
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
                        <a href="index.php"><img class="logo" src="img/photos/IBH_top_logo.png" alt="business logo - a bike wheel is covered with waves. 'Inverloch bike hire' is written underneath" height= "100px"></a>
                    </div>
                    <div class="column nav-wrapper">
                        <nav class="mainNav">
                            <ul id="menu">
                                <li><a class="nav-text <?php if($activeLink=="index"){echo'nav-active';} ?>" href="index.php">Home</a></li>
                                <li><a class="nav-text <?php if($activeLink=="hire"){echo'nav-active';} ?>" href="makeabooking.php">Hire</a></li>
                                <li><a class="nav-text <?php if($activeLink=="about"){echo'nav-active';} ?>" href="about.php">About Inverloch</a></li>
                                <li><a class="nav-text explore-link <?php if($activeLink=="explore"){echo'nav-active';} ?>" href="explore.php">About Cycling</a>
                                    <ul id="subNav">
                                        <li><a href="explore-local.php">Cycling in Our Region</a></li>
                                        <li><a href="explore-rail.php">Rail Trails</a></li>
                                    </ul>
                                </li>
                                <li><a class="nav-text <?php if($activeLink=="contact"){echo'nav-active';} ?>" href="contactus.php">Contact Us</a></li>
                                <?php 
                                    if(!isset($_SESSION["login-type"])){
                                        include 'login.php';
                                    }else if($_SESSION["login-type"] != "customer"){
                                        echo "<li><a href='dashboard.php'><button class='acc-button' type='text'>Dashboard</button></a></li>";
                                    }else{
                                        $x ="";
                                        if($activeLink=="booking-sum"){
                                            $x ="nav-active";
                                        }
                                        echo "<li> <a class='nav-text $x' href='booking-summary.php'>My Bookings</a></li>";
                                        echo "<li>
                                        <form action='user-privilege.php' method='post'>
                                        <form action='header.php' method='post'>
                                            <input type='hidden' name='logout' value='logout'>
                                            <button class='acc-button' type='submit'>Logout</button>
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
        //Resource: https://www.w3schools.com/
        // Get the navbar
        var navbar = document.getElementById('nav');

        // When the user scrolls the page, execute function
        window.onscroll = function() {stickyMenu()};
        // Get the offset position of the navbar
        var sticky = navbar.offsetTop;

        // Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
        function stickyMenu() {
        if (window.pageYOffset > sticky) {
            navbar.classList.add("sticky");
            document.getElementById('subNav').style.background.color= "red";
        } else {
            navbar.classList.remove("sticky");
        }
        }
        </script>
    </body>
</html>
