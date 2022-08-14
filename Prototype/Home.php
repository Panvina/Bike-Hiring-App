<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="./style/style.css">
    <title>Home</title>
</head>
<body>
    <?php include 'header.php'?>
    <div id = "main">
        <div class="Homebanner">
            <div id="homebannertext">
                <h1 id="bannerH1"> Inverloch Bike Hire</h1>
                <p id="bannerP"> Start your adventure with us</p> 
                <button class="button">Hire now!</button>
            </div>
        </div>
        <div class='HomeMainCont'>  
            <div class='HomeImg'><img style= 'height: 100%; width: 100%; 'src="./img/photos/2.jpg" alt="About Us"/></div>
            <div class='HomeTxt'><h1 id="HomeHeader"> ABOUT US</h1>
                <div class='HomeDesc'><p>Explore the area and Rail Trails in comfort & style on an electric bike. We also have a range of standard bikes to suit your needs with a range of accessories available. We are a local family owned and operated business and pride ourselves on providing you with a unique experience while you enjoy what Inverloch and the sounding region has to offer. Whether your family have been holidaying here for years, you’re are having a weekend away or just simply visiting for the day we have an experience to suit everyone’s tastes and abilities.</p></div>
            </div>
        </div>

        <div class='HomeMainCont'>
            <div class='HomeTxt'><h1 id="HomeHeader">NEED HELP?</h1>
                <div class='HomeDesc'><p>Feel free to contact us and we are more than happy to help you plan the perfect bike hire experience!</p>
                <a href = "Explore.php"><button class="button">Contact Us</button></a>
                </div>
            </div>  
            <div class='HomeImg'><img style= 'height: 100%; width: 100%; 'src="./img/photos/2.jpg" alt="About Us"/></div>
        </div> 

        <div class='HomeMainCont'>  
            <div class='HomeImg'><img style= 'height: 100%; width: 100%; 'src="./img/photos/2.jpg" alt="About Us"/></div>
            <div class='HomeTxt'><h1 id="HomeHeader">NEW TO INVERLOCH?</h1>
                <div class='HomeDesc'><p>With so much to explore in the Bass Coast and South Gippsland, you are truly spoilt for choice. Take a trek up to Eagle’s Nest for a magnificent coastal outlook, or how about a re-energising walk along the beach that stretches as far as the eye can see.</p>
                <a href = "About.php"><button class="button">Learn More</button></a>
                </div>  
            </div>
        </div>
    </div>
    <?php include 'footer.php'?>
</body>
</html>
