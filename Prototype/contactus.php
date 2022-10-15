<!--
Project Name: Inverloch Bike Hire
Project Description: A website for hiring bikes. Front-end accompanied
	   by an admin dashboard.
File Description: reusable functions for the project
Contributor:
	- Clement Cheung @ 103076376@student.swin.edu.au
	- Vina Touch @ 101928802@student.swin.edu.au
	- Aadesh Jagannathan @ 102072344@student.swin.edu.au
-->
<?php 
    if (!isset($_SESSION)){
      session_start();
    }
      $_SESSION['active']="contact";
?>
<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta charset="utf-8">
  <title>Contact Us Page</title>
  <link rel="shortcut icon" href="./img/photos/logo-no-text.png" />
  <!--temp name till real logo is placed in here-->
  <link rel="stylesheet" href="./style/ContactUsStyle.css" />
  <link rel="stylesheet" href="./style/style.css" />
  <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="scripts/SendMailTo.js"></script>
</head>

<body>
  <header>
    <!-- This is done by Vina where the header includes the logo of the company and links to other pages-->
    <?php include 'header.php';?>
  </header>
  <main>
    <!-- The banner is created by aadesh and implemented the BreadCrumbs program in -->
    <div class="banner">
      <div id="bannertext">
        <h1>Contact Us</h1>
      </div>
      <div class="NavContainer">
        <ul class="Breadcrumbs">
          <li class="BreadcrumbsItem"><a href="Index.php" class="BreadcrumbsURL">Home</a></li>
          <li class="BreadcrumbsItem"><a href="javascript:window.location.href=window.location.href" class="BreadcrumbsURL BreadcrumbsURLactive">Contact Us</a></li>
        </ul>
      </div>
    </div>

    <!-- From ths onwards, this is done by Clement -->
    <!-- This is for people to see the page and can jump to FAQ quickly if needed -->
    <div id="headercomment" class="contactmargin">
      <h2>For questions, bookings or just to chat about eBikes, contact us today.<br />
        Or Check Our<a href="#faq">FAQ'S</a>.</h2>
    </div>
    <!-- This is the contact information of the company from here onwards - Clement -->
    <div id="contactUsInfo" class="contactmargin">
      <div id="contactbox">
        <div class="Contactbox" id="Conactbox1">
          <div id="contactInfo" class="textcentral">
            <h2>Contact Information</h2>
            <p>We are a 'Click &amp; Collect' Service. Book a location and pick-up time online and your bike/s will be waiting for you.</p>
            <table width="100%" border="0">
              <tbody>
                <tr>
                  <td><img src="img/icons/calandar.png" alt="" width="59" height="55" class="imgpadding" /></td>
                  <td>
                    <p>TRADING HOURS<br>
                      Open -Days a week;<br>
                      9am-5pm</p>
                  </td>
                </tr>
                <tr>
                  <td><img src="img/icons/phone.png" alt="" width="56" height="59" class="imgpadding" /></td>
                  <td>
                    <p>INVERLOCH BIKE HIRE&nbsp;<br>
                      <a href="mailto:invenlochbikes@gmail.com">invenlochbikes@gmail.com</a><br>
                      Mob:0455 896 240
                    </p>
                  </td>
                </tr>
              </tbody>
            </table>
            <p>We look foward to hearing from you.&nbsp;</p>
          </div>
        </div>
        <!-- This is a contact us form where if someone fill the form out and then send it, it will work, done by Clement -->
        <div class="Contactbox" id="Conactbox2">
          <form action="contactus.php" method="post" id="emailform" name="emailform" class="textcentral">
            <p>
              <label for="name">Your Name (Required):</label>
              <br>
              <input name="name" type="text" required="required" id="name" class="fourmsize" />
            </p>
            <p>
              <label for="emailinput">Your Email (Required):</label>
              <br>
              <input name="email" type="text" required="required" id="email" class="fourmsize" />
            </p>
            <p>
              <label for="subject">Subject:</label>
              <br>
              <input name="subject" type="text" id="subject" class="fourmsize" />
            </p>
            <p>
              <label for="msg">Your Message:</label>
              <br>
              <textarea name="msg" rows="10" id="msg" class="fourmsize" maxlength="500000"></textarea>
            </p>
            <button id="submit" class="submitbutton"><span>Send</span></button>
          </form>
        </div>
      </div>
    </div>

    <!-- The class="collapsibles" are using buttons function so when click, the dropbox can open or close. and this section is done by Clement -->
    <div id="faqfloat">
      <div id="faq" class="contactmargin">
        <h2>FAQ'S</h2>
        <p><em>If you can't find the answer to your questions bellow, feel free to get in touch.</em></p>
        <div id="mainfaq">
          <button type="button" class="collapsible">Do I need a license to ride on an eBike?</button>
          <div class="content">
            <p class="content-size">For most electric bikes, you do not need a licence of anykind to use.</p>
          </div>
          <button type="button" class="collapsible">I've never ridden an eBike is it difficult?</button>
          <div class="content">
            <p>Lorem ipsum...</p>
          </div>
          <button type="button" class="collapsible">How fast does an eBike go?</button>
          <div class="content">
            <p>eBikes go as fast as 25km/h to abide with Australian eBike Laws</p>
          </div>
          <button type="button" class="collapsible">What is a cargo bike?</button>
          <div class="content">
            <p>A cargo bike is a human powered vehicle designed and constructed specifically for transporting loads.</p>
          </div>
          <button type="button" class="collapsible">Where should we ride?</button>
          <div class="content">
            <p>Around Inverloch</p>
          </div>
          <button type="button" class="collapsible">My partner doesn't ride much. Will they be fit enough?</button>
          <div class="content">
            <p>Lorem ipsum...</p>
          </div>
          <button type="button" class="collapsible">What brand are your eBikes?</button>
          <div class="content">
            <p>Lorem ipsum...</p>
          </div>
          <button type="button" class="collapsible">Do you sell eBikes?</button>
          <div class="content">
            <p>No</p>
          </div>
          <button type="button" class="collapsible">We have small kids, do you have trailers or tagalongs?</button>
          <div class="content">
            <p>Yes</p>
          </div>
          <button type="button" class="collapsible">We are a large group, how many bikes do you have?</button>
          <div class="content">
            <p>Lorem ipsum...</p>
          </div>
          <button type="button" class="collapsible">Do you just have eBikes?</button>
          <div class="content">
            <p>No, we have other bikes around</p>
          </div>
          <button type="button" class="collapsible">Does the hire price include supply of helmets and locks?</button>
          <div class="content">
            <p>Lorem ipsum...</p>
          </div>
        </div>
      </div>
    </div>
  </main>
  <footer>
    <!-- This is done by Vina where it is the footer of the page-->
    <?php include 'footer.php' ?>
  </footer>

</body>

</html>