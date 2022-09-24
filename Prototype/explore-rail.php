<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="style/style.css">
        <title>Explore</title>
    </head>
    <body>
        <header><?php include 'header.php'?></header>
        <div id = "main">
            <div class="banner">
                <div id="bannertext">
                    <h1> EXPLORE</h1>
                </div>
                <div class ="NavContainer">
                     <ul class="Breadcrumbs">
                        <li class="BreadcrumbsItem">
                            <a href="Index.php" class="BreadcrumbsURL">Home</a>
                        </li>
                        <li class="BreadcrumbsItem">
                            <a href="Explore.php" class="BreadcrumbsURL">Explore</a>
                        </li>
                        <li class="BreadcrumbsItem">
                            <a href="javascript:window.location.href=window.location.href" class="BreadcrumbsURL BreadcrumbsURLactive">Rail Trails</a>
                        </li>
                     </ul>
                </div>
            </div>

            <div class="explore-rail-description explore-std-padding">
                <h1 class="explore-std-header">RAIL TRAILS</h1>
                <p class="no-top-margin">Cycle your way across Gippsland on the rail trails – a network of disused railways transformed into gently graded paths through bushland and rainforest, past valleys and vineyards, and along the stunning beauty of the coastline. Pedal from town to town, sampling the flavours of the region as you go.</p>
            </div><br>

            <!-- single-row container  -->
            <div class="explore-rail-content-row explore-std-padding">
                <div class="left-location-container">
                    <!-- <div class="location-image-container" style="background-image: url('img/photos/1.jpg'); background-size: contain; background-repeat: no-repeat; width: 100%; height: 0; padding-top: 66.64%; margin-bottom: 0px;"
                        <a/>
                    </div> -->
                    <img src="img/photos/BassCoastRailTrail.jpg" class="no-separation" alt="nothing" width="579" height="390">
                    <div class="location-description">
                        <h3 class="location-container-header">Name: Bass Coast Rail Trail</h3>
                        <p class="location-container-content">Location: Anderson to Wonthaggi</p>
                    </div>
                </div>
                <div class="right-location-container">
                    <img src="img/photos/GreatSouthernRailTrail.jpg" class="no-separation" alt="nothing" width="579" height="390">
                    <div class="location-description">
                        <h3 class="location-container-header">Name: Great Southern Rail Trail</h3>
                        <p class="location-container-content">Location: Leongatha to Port Welshpool</p>
                    </div>
                </div>
            </div>

            <!-- separator  -->
            <div class="location-container-separator">
            </div>

            <!-- single-row container  -->
            <div class="explore-rail-content-row explore-std-padding">
                <div class="left-location-container">
                    <!-- <div class="location-image-container" style="background-image: url('img/photos/1.jpg'); background-size: contain; background-repeat: no-repeat; width: 100%; height: 0; padding-top: 66.64%; margin-bottom: 0px;"
                        <a/>
                    </div> -->
                    <img src="img/photos/sanremo.jpg" class="no-separation" alt="nothing" width="579" height="390">
                    <div class="location-description">
                        <h3 class="location-container-header">Name: San Remo to Cowes Cycling Track</h3>
                        <p class="location-container-content">Location: Phillip Island</p>
                    </div>
                </div>
                <div class="right-location-container">
                    <img src="img/photos/hinterland.jpg" class="no-separation" alt="nothing" width="579" height="390">
                    <div class="location-description">
                        <h3 class="location-container-header">Name: Bass Coast Hinterland Road Cycling</h3>
                        <p class="location-container-content">Location: Inverloch</p>
                    </div>
                </div>
            </div>

            <!-- separator  -->
            <div class="location-container-separator">
            </div>

            <div class='SubExploreMainCont'>  
            <div class='SubExploreImg'><img class="filled-img" style= 'height: 100%; width: 100%; 'src="./img/photos/region.jpg" alt="About Us"/></div>
                <div class='SubExploreTxt'><h1 id="SubExploreHeader">YOUR NEW JOURNEY?</h1>
                    <div class='SubExploreDesc'><p>Explore the surrounds of our region!</p>
                        <a href = "explore-local.php"><button class="button">EXPLORE</button></a>
                    </div>  
                </div>
            </div>
        </div><br><br>
        <footer><?php include 'footer.php'?></footer>
    </body>
</html>
