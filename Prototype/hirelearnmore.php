<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Specs and Info</title>
</head>
<style type="text/css">
  


/* Main Container */

.maincontainer{
    padding-left: 10%;
    padding-right: 10%;
}



#bottomContainer {
    width: 100%;
    margin: 0 auto;
    background-color: #ebf7f7;
    height: 250px;
}

#bottomColumn1 {
    float: left;
    width: 70%;
    background-image: url('img/photos/2.jpg');
    background-size: cover;
    background-position: 0px -75px;
    height:250px;
    opacity: 0.5;
}

#bottomColumn2 {
    float: left;
    width: 25%;
    padding-left: 25px;
  
}


.centerContainer {
  height: 250px;
  position: relative;
}

.verticalCenter {
  margin: 0;
  position: absolute;
  top: 50%;
  -ms-transform: translateY(-50%);
  transform: translateY(-50%);
}



</style>
<body>
    <?php include 'header.php'?>    
    <div id = "main">
        <div class="banner">
            <div id="bannertext">
                <h1>SPECS AND INFO</h1>
            </div>
            <div class ="NavContainer">
                    <ul class="Breadcrumbs">
                        <li class="BreadcrumbsItem">
                            <a href="Index.php" class="BreadcrumbsURL">Home</a>
                        </li>
                        <li class="BreadcrumbsItem">
                            <a href="javascript:window.location.href=window.location.href" class="BreadcrumbsURL BreadcrumbsURLactive">Hire</a>
                        </li>
                        <li class="BreadcrumbsItem">
                            <a href="javascript:window.location.href=window.location.href" class="BreadcrumbsURL BreadcrumbsURLactive">Mountain</a>
                        </li>
                        <li class="BreadcrumbsItem">
                            <a href="javascript:window.location.href=window.location.href" class="BreadcrumbsURL BreadcrumbsURLactive">MERIDA Big Seven</a>
                        </li>
                    </ul>
            </div>
        </div>
        
       <div class="maincontainer">
    <h1><u>MERIDA BIG SEVEN</u></h1>
    <p style="font-size: 20px;">SPECS &amp; INFORMATION</p>
    <table style="font-family: Calibri;font-size: 18px;">
      <tr>
        <td style="font-weight: bold;">Lorem ipsum:</td>
        <td style="padding-left: 50px;">Lorem ipsum dolor sit ame</td>
      </tr>
      <tr>
        <td style="font-weight: bold;">Dolor sit amet:</td>
        <td style="padding-left: 50px;">Consectetur adipiscing elit</td>
      </tr>
      <tr>
        <td style="font-weight: bold;">Ded do eiusmod tempor:</td>
        <td style="padding-left: 50px;">Incididunt ut labore et dolore</td>
      </tr>
      <tr>
        <td style="font-weight: bold;">Ut enim ad minim veniam:</td>
        <td style="padding-left: 50px;">Ea commodo consequat</td>
      </tr>
      <tr>
        <td style="font-weight: bold;">Duis aute irure dolor in repreh:</td>
        <td style="padding-left: 50px;">Enderit in voluptate</td>
      </tr>
      <tr>
        <td style="font-weight: bold;">Mcillum dolore eu fugiat null:</td>
        <td style="padding-left: 50px;">Excepteur sint occaecat</td>
      </tr>
      <tr>
        <td style="font-weight: bold;">Ut enim ad minim veniam:</td>
        <td style="padding-left: 50px;">Ea commodo consequat</td>
      </tr>
      <tr>
        <td style="font-weight: bold;">Duis aute irure dolor in repreh:</td>
        <td style="padding-left: 50px;">Enderit in voluptate</td>
      </tr>
      <tr>
        <td style="font-weight: bold;">Mcillum dolore eu fugiat null:</td>
        <td style="padding-left: 50px;">Excepteur sint occaecat</td>
      </tr>
    </table>
    <br>

    <div id="bottomContainer">
        <div id="bottomColumn1">
        </div>
        <div id="bottomColumn2">
            <div class="centerContainer">
          <div class="verticalCenter">
            <p style="text-align: left;font-weight: bold;font-size:40px;">Interested?</p>
            <p style="text-align: left;font-weight: bold;font-size:16px;">Start Hiring Now!</p>
            <a href="" style="color:white;background-color: black;padding: 5px;text-decoration: none;">BOOK</a>
          </div>
        </div>
        </div>
    </div>



  </div>
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

</body>
</html>