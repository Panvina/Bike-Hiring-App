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
//added a session to store an active state of which page has been clicked by the user - Vina Touch 
if (!isset($_SESSION)) {
  session_start();
}
$_SESSION['active'] = "contact";
/**************************************/
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
    <?php include 'header.php'; ?>
  </header>
  <main>
    <!-- The banner is created by aadesh and implemented the BreadCrumbs program in -->
    <!-- Breadcrumbs Navigation completed by Aadesh Jagannathan - 102072344-->
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
      <p>For questions, bookings or just to chat about eBikes, contact us today<br />
        or check Our <a href="#faq">FAQ'S</a>.</p>
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
                      <a id="mail" href="mailto:invenlochbikes@gmail.com">invenlochbikes@gmail.com</a><br>
                      0411 234 321
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
            <button id="submit" class="submitbutton"> Send </button>
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
          <button type="button" class="collapsible">HOW MUCH?</button>
          <div class="content">
            <p>Please note that the maximum hire period for our E-bikes is six hours.</p>
            <p><strong>‘E-BIKES’</strong> (18 years+)</p>
            <p>1 HOUR – $50</p>
            <p>2 HOURS – $60</p>
            <p>4 HOURS – $75</p>
            <p>6 HOURS – $90</p>
            <p><strong>‘STANDARD BIKES’</strong></p>
            <p>1 HOUR – $45</p>
            <p>2 HOURS – $55</p>
            <p>4 HOURS – $60</p>
            <p>6 HOURS – $70</p>
            <p>Free delivery anywhere within the Inverloch township includes both drop off and pick up at the end of your ride.</p>
            <p>Fees apply for all other deliveries outside the Inverloch township:</p>
            <ul>
              <li>Out of town – within 20 kms of Inverloch: $25 delivery fee.</li>
              <li>Out of town&nbsp; – 20 kms plus from Inverloch: $50 delivery fee.</li>
              <li>Over 30 kms from Inverloch… give us a call and we’ll do our best to make it work for you.</li>
            </ul>
            <p>Need help working out where you are…find out <a href="https://2kmfromhome.com/20km"><strong>here</strong>.</a></p>
          </div>

          <button type="button" class="collapsible">WHO CAN HIRE OUR E-BIKES?</button>
          <div class="content">
            <p>Anyone 18+ with a sence of adventure!</p>
            <p>Along with those essentials, you must also know the
              <a href="https://www.vicroads.vic.gov.au/safety-and-road-rules/road-rules/a-to-z-of-road-rules/bicycles.">Road Rules</a>
              and importantly, you must know how to ride a bike safely.
            </p>
          </div>

          <button type="button" class="collapsible">HOW DO I HIRE A BIKE?</button>
          <div class="content">
            <p>Simply go to our <strong><a href="https://www.inverlochbikes.com/hire/">hire</a> </strong>page and follow these five easy steps.</p>
            <ol>
              <li><strong>Select your times and dates.</strong></li>
              <li><strong>Select your bike, how many you need and any extras if required.</strong></li>
              <li><strong>Enter your delivery address.</strong></li>
              <li><strong>Enter your details, check out our <a href="http://inverlochbikes.com/waiver/" data-type="URL" data-id="inverlochbikes.com/waiver/">T&amp;C’s</a> and then book your ride.</strong></li>
              <li><strong>Select your choice of payment and you’re done.</strong></li>
            </ol>
            <p>You will then receive an email confirming your booking. You will need to access this email and provide us with a digital signature before you take off.</p>
            <p>Once you select your bike, don’t forget to let us know how many you need under the ‘SIZES &amp; QUANTITIES’ menu.</p>
            <p>If you have any questions don’t hesitate to <a href="http://www.inverlochbikes.com/contact-us/" data-type="URL" data-id="http://www.inverlochbikes.com/contact-us/"><strong>contact us</strong></a>.</p>

          </div>

          <button type="button" class="collapsible">WHERE DO I PICK UP MY BIKES?</button>
          <div class="content">
            <p>We bring them to you, or you can come to us…whatever is easiest for you!</p>
            <p>Simply let us know when you make your on-line booking.</p>
            <p>We offer a free ‘click &amp; collect’ service to anywhere within the Inverloch township. When you make your booking, tell us where and when you want your bikes, and we will deliver them to you free anywhere within the Inverloch township.</p>
            <p>Then once you’re all pedaled out, we come back and pick them up as well.</p>
            <p>If those options don’t suit, you can meet up with us at our favourite haunt and designated meeting place – the Inverloch pier. You can find us there most days.</p>
            <p>Note that fees do apply for all deliveries and pick-ups outside the Inverloch township.</p>
            <p>When booking more than one bike for delivery outside the Inverloch township, only one delivery &amp; pick up fee applies – see ‘<em>how much?</em>‘</p>
          </div>

          <button type="button" class="collapsible">WHAT MUST I BRING & WHAT SHOULD I BRING?</button>
          <div class="content">
            <p>Along with your sense of adventure, there are just three things you must bring; photo ID, enclosed footwear and importantly, a mobile phone – just in case you need our assistance or become geographically challenged along the way.</p>
            <p>We also recommend that you bring a backpack, a drink-bottle and sunscreen. We supply everything else, including your bikes, locks, helmets and a pen…you must read and sign our <strong><a href="https://www.inverlochbikes.com/waiver/" data-type="URL" data-id="https://www.inverlochbikes.com/waiver/">T&amp;C’s</a></strong> and <strong><a href="https://www.inverlochbikes.com/waiver/" data-type="URL" data-id="https://www.inverlochbikes.com/waiver/">Waiver</a></strong> prior to embarking.&nbsp; Once that’s done, you’re on your way.</p>

          </div>

          <button type="button" class="collapsible">WHAT TYPE OF BIKE WILL I BE RIDING?</button>
          <div class="content">
            <p>We run a fleet of <strong><em>Electra Townie Go! 7D E-Bikes</em></strong>. Our Townies are exclusively designed for comfort and cruising. They discreetly house an integrated battery and electric motor which is connected to a control switch on your handlebars. You simply pedal your bike as you normally would, and then… when you’re ready, activate the pedal assist. You have the choice of three levels of pedal assist… the more assistance you choose, the more wind in your hair!</p>
            <p>We also have a selection of old school <strong><em>Electra Cruiser 7D </em></strong>standard bikes.&nbsp; No motor, no matter – they’re still an awesome ride.</p>
            <p>Check them all out on our hire page…what you book is what you get.</p>

          </div>

          <button type="button" class="collapsible">WHAT IS THE DIFFERENCE BETWEEN A ‘STEP-THRU’ AND A ‘STEP-OVER’?</button>
          <div class="content">
            <p>The main difference between the two is the horizontal tube which runs from under your seat to the front of your bike.&nbsp; One you “step over” to mount your bike, the other you simply “step through”. That’s it.&nbsp; Everything else is the same including the controls, the motors and the pedal assistance.</p>
            <p>So, depending on your ability… and maybe flexibility, you get to choose the ride which best suits you. &nbsp;Whichever one you decide, they’re both awesome!</p>
          </div>

          <button type="button" class="collapsible">I’VE NEVER USED AN E-BIKE BEFORE – WHAT’S IT LIKE?</button>
          <div class="content">
            <p>Imagine being towed non-stop as you ride! We will take you through everything you need to know from start to finish.&nbsp; Then once you’re comfortable, and we’re comfortable, off you go.</p>
          </div>

          <button type="button" class="collapsible">WHAT DO I GET WITH MY HIRE?</button>
          <div class="content">
            <p>An awesome bike to start with.</p>
            <p>As a bonus, we’ll throw in some expert local knowledge, a detailed safety briefing, a full run down on your bike, a fully charged battery, an adjustable helmet perfectly sized to fit your head, a bike lock and a map.</p>
            <p>You also get the peace of mind knowing that all of our bikes are serviced and maintained daily by our very own accredited bicycle mechanic.</p>
            <p>If we have missed anything please let us know.</p>
          </div>

          <button type="button" class="collapsible">WHERE TO?</button>
          <div class="content">
            <p><strong><u>Inverloch Foreshore Path</u></strong></p>
            <p>No visit to Inverloch is complete without taking in the stunning ocean views from our famous foreshore path. Stretching four kilometres from Cuttriss Street to the Surf Beach, this gentle ride is undoubtedly the jewel in our coastal crown. Take a few moments to stop along the way and fully appreciate the scene which stretches uninterrupted from Eagles Nest, across Bass Straight, to Anderson Inlet. It is simply breathtaking!</p>
            <p>Keep an eye out for our resident koalas and vast array of birdlife which inhabit our foreshore trees. Public amenities and rest areas are conveniently located throughout the entire length of this stunning pathway. <em>Note that this is a shared pathway intended for use by both cyclists and pedestrians. It can become very busy during the warmer months, so please, use your bell and be considerate to others.</em></p>
            <p><strong><u>Ayr Creek Trail</u></strong></p>
            <p>The Ayr Creek Trail is one of many hidden green-belts which intersect our amazing foreshore path. You can find the start of the Ayr Creek Trail at marker post #13 on the foreshore path. Once you’ve found that marker, you’ve found the Ayr Creek Trail – a birdwatcher’s paradise. This narrow, winding track extends 1.7 kilometres north to the Bass Highway and is popular amongst locals. <em>Note that you must cross Toorak Road which can also be busy during the summer months</em>.</p>
            <p>Once you reach the end of the trail you can either turn back and return to the foreshore… or head to town in search of some of other hidden gems – in the form of our hotels, cafes, galleries and wineries.</p>
            <p>If you make your way back towards town via Toorak Road be sure to stop and take in the view overlooking Anderson Inlet…it is always spectacular and never the same!</p>
            <p><strong><u>Other Options:</u></strong></p>
            <p>We’re so lucky to have so many other magical paths and hidden trails just waiting to be explored… you just need to know where they are. Make your way to the Surf Life Saving Club, head up Goroke Street and then right into beautiful Lohr Avenue. From there you will discover an amazing network of secluded tracks and trails. They’re fun, they’re peaceful and they’re waiting for you.</p>
            <p>You can then make your way back to the pier where you are guaranteed unrivaled entertainment – whether its checking out the catch of the day, being hypnotized by the grace of our majestic stingrays or simply enjoying a nautical moment with our daily flotilla of boats, you’re guaranteed to cruise away with a smile on your face.</p>
            <p>For those looking further afield, check out our <strong><a href="https://www.visitbasscoast.com.au/experiences/walk-bikes-trails">Bass Coast Walks &amp; Trails.</a></strong> If you find one you like, book on-line or give us a call.</p>
          </div>

          <button type="button" class="collapsible">WHAT HAPPENS IF I GET A PUNCTURE OR BREAK DOWN?</button>
          <div class="content">
            <p>Call us immediately on 0455 896 240 and we will do everything we can to get you back on two wheels as soon as possible.</p>
          </div>

          <button type="button" class="collapsible">HOW LONG DOES MY BATTERY LAST?</button>
          <div class="content">
            <p>That depends on a few things such as terrain, wind, kgs over the saddle and the level of speed assist you are using.</p>
            <p>Consider this, if you’re continually pedaling up hills, into the wind, carrying a heavy back-pack whilst using the highest speed assist setting available… then you could reasonably expect to reach up to 40-50 kilometres travel/or around four hours riding time – on a fully charged battery.</p>
            <p>However, if the terrain is easy, the day is calm and you are gently cruising around on a lower speed setting, you could safely expect to cover 80 kilometres plus/or around six hours riding time.</p>
            <p>Ours are like any other electric motor – the harder they work, the quicker they drain.</p>
            <p>Then once you’re done coasting around, it takes us around four hours to completely re-change our E-bike batteries. And it is for this reason that we can only offer a six hour/half day hire with our E-bikes.</p>
            <p>We would much prefer to play it safe and ensure you had an awesome time enjoying the E in our E-bikes!</p>
            <p>Whichever way you roll, you can always monitor your battery life on your LED controller.&nbsp; And if you happen to run out of charge, don’t stress…your electric-bike then becomes just, well, an acoustic-bike!</p>
          </div>

          <button type="button" class="collapsible">WHERE CAN I RIDE AND WHERE CAN’T I RIDE?</button>
          <div class="content">
            <p>You can ride on designated bike paths, shared paths and carriageways, which includes most of our scenic foreshore path – <em>note that there is short but designated dismount area opposite Pensioners Point. You MUST disembark and walk your bike here or alternatively ride on the adjacent road.</em></p>
            <p>You can also ride on public roads, most rail trails and on most public spaces.</p>
            <p>However, laws restrict the riding of bikes on footpaths in Victoria. This includes our very busy CBD around A’Beckett Street. So please do not ride on our footpaths – you could receive a fine or even worse, injure yourself or someone else.</p>
            <p>It is also against the law to ride any motorised vehicle on any of our beaches and significant fines do apply. Our pristine beaches are closely monitored, which is why they remain so pristine. So please do not ride through water, across the dunes or on our beaches. Along with a possible fine, you will also incur the additional expense of dismantling, cleaning and replacing parts damaged by sand or salt water.</p>
          </div>

          <button type="button" class="collapsible">WHAT HAPPENS IF BIKES OR EQUIPMENT ARE DAMAGED, LOST OR STOLEN?</button>
          <div class="content">
            <p>If something happens during your ride, no matter how minor, please let us know ASAP!&nbsp;The main reason is that we don’t want to put someone else on a bike without knowing it has been dropped or damaged during your hire. You are entirely responsible and liable for all bikes and equipment that you have hired.&nbsp; In the unfortunate circumstance where there has been damage or loss of gear during your hire, let us know. Flat tyres happen – a missing bike is another story. Either way we will sort something out as quickly and fairly as possible.</p>
          </div>

          <button type="button" class="collapsible">WHAT IF IT THE WEATHER TURNS BAD?</button>
          <div class="content">
            <p>Inclement weather and sudden changes can sometimes occur, especially here on the coast, so check the forecast and dress accordingly for the conditions.</p>
            <p>However, if you are suddenly caught out by a rouge storm during your ride, give us a call and we will arrange to collect you as soon as possible.&nbsp; If this occurs, we are happy to reschedule your hire or issue you with a credit for another date.</p>
            <p>We can’t control the weather, but we can try and make your time with us the best experience possible…this year and the next.</p>
          </div>

          <button type="button" class="collapsible">HAVE WE MISSED ANYTHING?</button>
          <div class="content">
            <p>If you have a FAQ for us or we can do anything else to help – please let us know.</p>
            <p>From all of us here at Inverloch Bike Hire, enjoy your time on our beautiful coast … and have a great ride!</p>
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