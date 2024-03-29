﻿<?php 
    //added a session to store an active state of which page has been clicked by the user - Vina Touch
    if (!isset($_SESSION)){
        session_start();
    }
    $_SESSION['active']="explore";
    /********************************/ 
?>
<!-- All code completed on this page by Aadesh Jagannathan - 102072344 -->

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="./style/style.css">
    <title>Explore</title>
</head>
<body>
    <?php include 'header.php'?>
    <!-- All the images and web contend were modified by Vina Touch 101928802!-->
    <div id = "main">
        <div class="banner">
            <div id="bannertext">
                <h1> EXPLORE</h1>
            </div>
            <!-- Breadcrumbs Navigation completed by Aadesh Jagannathan - 102072344-->
            <div class ="NavContainer">
                     <ul class="Breadcrumbs">
                        <li class="BreadcrumbsItem">
                            <a href="Index.php" class="BreadcrumbsURL">Home</a>
                        </li>
                        <li class="BreadcrumbsItem">
                            <a href="javascript:window.location.href=window.location.href" class="BreadcrumbsURL BreadcrumbsURLactive">Explore</a>
                        </li>
                     </ul>
                </div>
            </div>
        </div>
        
        <div class='ExploreMainCont'>  
            <div class='ExploreImg'><img style= 'height: 100%; width: 100%; 'src="./img/photos/region.jpg" alt="About Us"/></div>
            <div class='ExploreTxt'><h1 id="ExploreHeader">CYCLING IN OUR REGION</h1>
                <div class='ExploreDesc'><p>Discover sights unseen from the highways, and fill your basket with gourmet treats from small producers all across Gippsland. Sit a while on riverbanks and seashores, and experience the beauty of the peaceful surroundings.</p>
                <a href = "explore-local.php"><button class="button">Learn More</button></a>
                </div>  
            </div>
        </div>

        <div class='ExploreMainCont'>
            <div class='ExploreTxt'><h1 id="ExploreHeader">RAIL TRAILS</h1>
                <div class='ExploreDesc'><p>Cycle your way across Gippsland on the rail trails – a network of disused railways transformed into gently graded paths through bushland and rainforest, past valleys and vineyards, and along the stunning beauty of the coastline. Pedal from town to town, sampling the flavours of the region as you go.</p>
                <a href = "explore-rail.php"><button style="padding: bottom 20px;"class="button">Learn More</button></a>
                </div>
            </div>  
            <div class='ExploreImg'><img style= 'height: 100%; width: 100%; 'src="./img/photos/railtrail.jpg" alt="About Us"/></div>
        </div> 
    </div>
    <?php include 'footer.php'?>
</body>
</html>