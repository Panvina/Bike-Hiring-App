<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="./style/style.css">
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
        </div>
                               
        </div>
        <div class='AboutMainCont'>
            <div class='AboutTxt'><h1 id="AboutHeader"> POPULAR SPOTS</h1>
                <div class='AboutDesc'><p>There is also the Inverloch Jetty, a great spot to throw in a line or if you are lucky enough see the majestic stingrays that frequent the jetty waters. Or for the adventurers, why not take in the sights and try one of the region’s popular walks; Screw Creek Townsend Bluff Estuary Walk, George Bass Coastal Walk, or Bass Coast Rail Trail (which is great for cycling). For those who like to shop you’ll find a variety of on-trend fashion, handmade and bespoke home wares as well as local crafts. Or if you’d like to grab a good book, there’s a great range at the newsagency. Join in a yoga session on the beach and then take a ride on a coastal path/trail or tour the inland local rail trails and visit and of local hidden gems such a Loch.</p></div>
            </div>  
            <div class='AboutImg'><img style= 'height: 100%; width: 100%; 'src="./img/photos/2.jpg" alt="About Us"/></div>
        </div> 

        <div class='AboutMainCont'>  
            <div class='AboutImg'><img style= 'height: 100%; width: 100%; 'src="./img/photos/2.jpg" alt="About Us"/></div>
            <div class='AboutTxt'><h1 id="AboutHeader"> TASTE</h1>
                <div class='AboutDesc'><p>From aromatic coffee, exquisite wineries, breweries, and distilleries to cuisines from around the world, the Inverloch region is a mecca for foodies and wine lovers alike. With a huge range of fresh, local produce on offer throughout the eateries in town and at the local farmer’s markets, it’s very much about delicious flavours and a wonderful culinary experience. A short drive from Inverloch will lead you to the quaint, artisan townships of Loch and Meeniyan, and also to Korumburra where you will find a range of yummy delicacies. Don’t forget the Kongwak Market open every Sunday with a range of artisan goods, food and second hand treasures to be found.</p></div>
            </div>
        </div> 
        
        <h1 id="AboutH1"> MORE FROM OUR AREA!</h1>
        <div class ="main-carousel" id = "carousel">
            <div class="cell"><img src = "img/photos/3.jpg"></div>
            <div class="cell"><img src = "img/photos/3.jpg"></div>
            <div class="cell"><img src = "img/photos/3.jpg"></div>
            <div class="cell"><img src = "img/photos/3.jpg"></div>
            <div class="cell"><img src = "img/photos/3.jpg"></div>
            <div class="cell"><img src = "img/photos/3.jpg"></div>
        </div>
        <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
        <script type = "text/javascript">
        $('.main-carousel').flickity({
        cellAlign: 'left',
        wrapAround:true,
        freeScroll:true
        });</script>
    </div>
</body>
</html>