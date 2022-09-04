<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Choose your Bike</title>
</head>
<style type="text/css">
  


/* Main Container */

.maincontainer{
    padding-left: 10%;
    padding-right: 10%;
    padding-top: 10px;
}

/* SECOND NAV TABS */


/* Style the tab content */
.tabcontent {
  display: none;
  border-top: none;
}


/* Add a black background color to the top navigation */
.topnav {
    overflow: hidden;
    font-family:Calibri;
    border-bottom:7.5px solid black;

}

/* Style the links inside the navigation bar */
.topnav a {
  float: left;
  color: black;
  text-align: center;
  padding-left: 5px;
  padding-right: 5px;
  padding-top: 5px;
  padding-bottom: 5px;
  text-decoration: none;
  font-size: 17px;
  background-color: #e9f7f7;
  margin-left:10px;
}

/* Change the color of links on hover */
.topnav a:hover {
  background-color: #ddd;
  color: black;
}

/* Add a color to the active/current link */
.topnav a.active {
  background-color: #aaecd0;
  color: black;
  padding-left: 10px;
  padding-right: 10px;
  padding-top: 10px;
  padding-bottom: 10px;
}

/* Right-aligned section inside the top navigation */
.topnav-right {
  float: right;
}

.topnav-right a{
  background-color: black;
  color:white;
  right:10px;
  z-index: 0;
}


/* Bike Columns */

#bikecontainer {
    width: 100%;
    margin: 0 auto;
    background-color: #aaecd0;
    height: 250px;
}

#bikecolumn1 {
    float: left;
    width: 30%;
  
}

#bikecolumn2 {
    float: left;
    width: 60%;
}

#bikecolumn3 {
    float: left;
    width: 10%;
}



/*center div */

.centercontainer {
  height: 250px;
  position: relative;
}

.vertical-center {
  margin: 0;
  position: absolute;
  top: 50%;
  -ms-transform: translateY(-50%);
  transform: translateY(-50%);
}

/* Page number selector */

.pagenumbers {
  float: right;
  display: inline-block;
}

.pagenumbers a {
  color: black;
  float: left;
  padding: 8px 16px;
  text-decoration: none;
}


</style>
<body>
    <?php include 'header.php'?>    
    <div id = "main">
        <div class="banner">
            <div id="bannertext">
                <h1>CHOOSE YOUR BIKE</h1>
            </div>
            <div class ="NavContainer">
                    <ul class="Breadcrumbs">
                        <li class="BreadcrumbsItem">
                            <a href="Index.php" class="BreadcrumbsURL">Home</a>
                        </li>
                        <li class="BreadcrumbsItem">
                            <a href="javascript:window.location.href=window.location.href" class="BreadcrumbsURL BreadcrumbsURLactive">Hire</a>
                        </li>
                    </ul>
            </div>
        </div>
        
       <div class="maincontainer">


  <div class="topnav">
    <a  id="defaultOpen" class="active" href="javascript:openTab(event, 'Tab1')">MOUNTAIN</a>
    <a style="margin-top:10px;" href="javascript:openTab(event, 'Tab2')">BIKE TYPE 1</a>
    <a style="margin-top:10px;" href="javascript:openTab(event, 'Tab3')">BIKE TYPE 2</a>
    <div style="margin-top:10px;" class="topnav-right">
      <a href="">Current Bookings</a>
    </div>
  </div>


    <div id="Tab1" class="tabcontent">
      <h1 style="font-size:40px;"><u>MOUNTAIN BIKES</u></h1>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>



    <div id="bikecontainer">
        <div id="bikecolumn1">
            <img src="img/photos/1.jpg" width="350">
        </div>
        <div id="bikecolumn2">
            <h1 style=""><strong>MERIDA BIG SEVEN</strong></h1>
            <p><strong>Our classic hardtails are the backbone of our range and showcase the enormous wealth and experience we've gained in half a century of bike production and manufacturing. The BIG NINE range symbolises the symbiosis between modern frame technology, attention to detail and craftmanship that 'Made in Taiwan' signifies.</strong></p>
        </div>
        <div id="bikecolumn3">
            <div class="centercontainer">
          <div class="vertical-center">
            <p style="text-align: right;font-weight: bold;">FROM AUD</p>
            <p style="text-align: right;font-weight: bold;">$$$$$$</p>
            <a href="" style="color:white;background-color: black;padding: 5px;text-decoration: none;">BOOK NOW</a>
          </div>
        </div>
        </div>
    </div>
    <br>
    <br>
    <div id="bikecontainer">
        <div id="bikecolumn1">
            <img src="img/photos/1.jpg" width="350">
        </div>
        <div id="bikecolumn2">
            <h1 style=""><strong>NORCO STORM</strong></h1>
            <p><strong>Lightweight, durable aluminium frame and forks combine with a quality component selection that fits young riders perfectly and lets them build their skills and a love for riding that'll last a lifetime.
              <br>Every storm features quality brakes with short reach levers that are easy to pull with kid-sized hands. That way, when they need to stop or slow down, it doesen't take every once of energy they've got.</strong></p>
        </div>
        <div id="bikecolumn3">
            <div class="centercontainer">
          <div class="vertical-center">
            <p style="text-align: right;font-weight: bold;">FROM AUD</p>
            <p style="text-align: right;font-weight: bold;">$$$$$$</p>
            <a href="" style="color:white;background-color: black;padding: 5px;text-decoration: none;">BOOK NOW</a>
          </div>
        </div>
        </div>
    </div>
    <div class="pagenumbers">
       <a href="#"><strong>&#60;</strong></a>
       <a style="background-color: black;color:white;" href="#">1</a>
       <a href="#">2</a>
       <a href="#">3</a>
       <a href="#">4</a>
       <a href="#">5</a>
       <a href="#">6</a>
       <a href="#"><strong>&#62;</strong></a>
    </div>



    </div>

    <div id="Tab2" class="tabcontent">
      <h3>Tab2</h3>
      <p>Lorem Ipsum</p> 
    </div>

    <div id="Tab3" class="tabcontent">
      <h3>Tab3</h3>
      <p>Lorem Ipsum</p> 
    </div>





  </div>
 <br>
<br>

<br>
<br>
<br>
<br>
<br>




        <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
        <script type = "text/javascript">
        $('.main-carousel').flickity({
        cellAlign: 'left',
        wrapAround:true,
        freeScroll:true
        });</script>
    </div>
    <?php include 'footer.php'?>
<script>
document.getElementById("defaultOpen").click();
function openTab(evt, tabName) 
{
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) 
  {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) 
  {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>  
</body>
</html>