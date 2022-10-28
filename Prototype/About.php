<?php 
    //added a session to store an active state of which page has been clicked by the user - Vina Touch
    if (!isset($_SESSION)){
        session_start();
    }
    $_SESSION['active']="about";
    /********************************/ 
?>

<!-- All code completed on this page by Aadesh Jagannathan - 102072344 -->
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="./style/carousel-style.css">
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>About Inverloch</title>
</head>
<body>
    <?php include 'header.php'?>
    <div id = "main">
        <div class="banner">
            <div id="bannertext">
                <h1> ABOUT INVERLOCH</h1>
            </div>
            <!-- Breadcrumbs Navigation completed by Aadesh Jagannathan - 102072344-->
            <div class ="NavContainer">
                    <ul class="Breadcrumbs">
                        <li class="BreadcrumbsItem">
                            <a href="Index.php" class="BreadcrumbsURL">Home</a>
                        </li>
                        <li class="BreadcrumbsItem">
                            <a href="javascript:window.location.href=window.location.href" class="BreadcrumbsURL BreadcrumbsURLactive">About Inverloch</a>
                        </li>
                    </ul>
            </div>
        </div>
        <div class='AboutMainCont'>
            <div class='AboutTxt'><h1 id="AboutHeader"> POPULAR SPOTS</h1>
                <div class='AboutDesc'><p>There is also the Inverloch Jetty, a great spot to throw in a line or if you are lucky enough see the majestic stingrays that frequent the jetty waters. Or for the adventurers, why not take in the sights and try one of the region’s popular walks; Screw Creek Townsend Bluff Estuary Walk, George Bass Coastal Walk, or Bass Coast Rail Trail (which is great for cycling). For those who like to shop you’ll find a variety of on-trend fashion, handmade and bespoke home wares as well as local crafts. Or if you’d like to grab a good book, there’s a great range at the newsagency. Join in a yoga session on the beach and then take a ride on a coastal path/trail or tour the inland local rail trails and visit and of local hidden gems such a Loch.</p></div>
            </div>
            <div class='AboutImg'><img style= 'height: 100%; width: 100%; 'src="./img/photos/inverloch.jpg" alt="About Us"/></div>
        </div>

        <div class='AboutMainCont'>
            <div class='AboutImg'><img style= 'height: 100%; width: 100%; 'src="./img/photos/taste.jpg" alt="About Us"/></div>
            <div class='AboutTxt'><h1 id="AboutHeader"> TASTE</h1>
                <div class='AboutDesc'><p>From aromatic coffee, exquisite wineries, breweries, and distilleries to cuisines from around the world, the Inverloch region is a mecca for foodies and wine lovers alike. With a huge range of fresh, local produce on offer throughout the eateries in town and at the local farmer’s markets, it’s very much about delicious flavours and a wonderful culinary experience. A short drive from Inverloch will lead you to the quaint, artisan townships of Loch and Meeniyan, and also to Korumburra where you will find a range of yummy delicacies. Don’t forget the Kongwak Market open every Sunday with a range of artisan goods, food and second hand treasures to be found.</p></div>
            </div>
        </div>

        <h1 id="AboutH1"> MORE FROM OUR AREA!</h1>
        <div class ="main-carousel" id = "carousel">
            <div class="cell"><img id="img1" src = "img/photos/1.jpg"></div>
            <div class="cell"><img id="img2" src = "img/photos/2.jpg"></div>
            <div class="cell"><img id="img3" src = "img/photos/3.jpg"></div>
            <div class="cell"><img id="img4" src = "img/photos/4.jpg"></div>
            <div class="cell"><img id="img5" src = "img/photos/5.jpg"></div>
            <div class="cell"><img id="img6" src = "img/photos/6.jpg"></div>
            <div class="cell"><img id="img7" src = "img/photos/7.jpg"></div>
        </div>

        <div id="img-one" class="modal">
            <!-- Button to close modal -->
            <span class="close-btn">&times;</span>
            <!-- Image popup -->
            <img class="carousel-img" id="img1" src="img/photos/1.jpg">           
        </div>
        <div id="img-two" class="modal">
            <span class="close-btn">&times;</span>
            <img class="carousel-img" id="img1" src="img/photos/2.jpg">           
        </div>
        <div id="img-three" class="modal">
            <span class="close-btn">&times;</span>
            <img class="carousel-img" id="img1" src="img/photos/3.jpg">           
        </div>
        <div id="img-four" class="modal">
            <span class="close-btn">&times;</span>
            <img class="carousel-img" id="img1" src="img/photos/4.jpg">           
        </div>
        <div id="img-five" class="modal">
            <span class="close-btn">&times;</span>
            <img class="carousel-img" id="img1" src="img/photos/5.jpg">           
        </div>
        <div id="img-six" class="modal">
            <span class="close-btn">&times;</span>
            <img class="carousel-img" id="img1" src="img/photos/6.jpg">           
        </div>
        <div id="img-seven" class="modal">
            <span class="close-btn">&times;</span>
            <img class="carousel-img" id="img1" src="img/photos/7.jpg">           
        </div>

        <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
        <script type = "text/javascript">
        $('.main-carousel').flickity({
        cellAlign: 'left',
        wrapAround:true,
        freeScroll:true
        });</script>
    </div><br><br><br>
    <?php include 'footer.php'?>
    <!-- Adding carousel popup control script-->
    <script src="scripts/carousel-popup.js"></script>
</body>
</html>
