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
                            <a href="javascript:window.location.href=window.location.href" class="BreadcrumbsURL BreadcrumbsURLactive">Cycling In Our Region</a>
                        </li>
                     </ul>
                </div>
            </div>

            <div class="explore-rail-description explore-std-padding">
                <h1 class="explore-std-header">CYCLING IN OUR REGION</h1>
                <p class="no-top-margin">Discover sights unseen from the highways, and fill your basket with gourmet treats from small producers all across Gippsland. Sit a while on riverbanks and seashores, and experience the beauty of the peaceful surroundings.</p>
            </div><br>

            <!-- single-row container  -->
            <div class="explore-rail-content-row explore-std-padding">
                <div class="left-location-container">
                    <!-- <div class="location-image-container" style="background-image: url('img/photos/1.jpg'); background-size: contain; background-repeat: no-repeat; width: 100%; height: 0; padding-top: 66.64%; margin-bottom: 0px;"
                        <a/>
                    </div> -->
                    <img src="img/photos/coastal.jpg" class="no-separation" alt="nothing" width="579" height="390">
                    <div class="location-description" >
                        <h3 class="location-container-header">Name: Inverloch Coast Ride to Screw Creek Nature Walk</h3>
                        <p class="location-container-content">Location: Inverloch </p>
                    </div>
                </div>
                <div class="right-location-container">
                    <img src="img/photos/screwcreekboard.jpg" class="no-separation" alt="nothing" width="579" height="390">
                    <div class="location-description">
                        <h3 class="location-container-header">Name: Screw Creek Nature Walk</h3>
                        <p class="location-container-content">Location: Inverloch</p>
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
                    <img src="img/photos/ayrcreek.jpg" class="no-separation" alt="nothing" width="579" height="390">
                    <div class="location-description">
                        <h3 class="location-container-header">Name: Inverloch Ayr Creek Trail (Ride, Walk, Dog Friendly)</h3>
                        <p class="location-container-content">Location: Inverloch</p>
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
            <div class='SubExploreImg'><img class="filled-img" style= 'height: 100%; width: 100%; 'src="./img/photos/railtrail.jpg" alt="About Us"/></div>
                <div class='SubExploreTxt'><h1 id="SubExploreHeader">Feeling Adventurous?</h1>
                    <div class='SubExploreDesc'><p>Explore the rail trails next!</p>
                        <a href = "explore-local.php"><button class="button">Discover More</button></a>
                    </div>  
                </div>
            </div>
        </div><br><br>
        <footer><?php include 'footer.php'?></footer>
    </body>
</html>
