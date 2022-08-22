<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Make a Booking</title>
</head>
<style type="text/css">
    

.mainheader {
    position: relative; 
    height: 150px;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.mainheader::before {    
      content: "";
      background-image: url('../img/mainheaderimg.jpg');
      background-size: cover;
      position: absolute;
      top: 0px;
      right: 0px;
      bottom: 0px;
      left: 0px;
      opacity: 0.5;
}

.mainheader p {
  position: relative;
  color: black;  
  font-size: 40px;
  line-height: 0.9;
  text-align: center;
  font-family: calibri;
}


/* Main Container */

.maincontainer{
    padding-left: 10%;
    padding-right: 10%;
    padding-top: 10px;
}

#dateContainer{
    box-sizing: border-box;
}


/* Bike Columns */

#dualContainer {
    width: 100%;
    margin: 0 auto;
    background-color: white;
    height: 1000px;
}

#dualColumn1 {
    float: left;
    width: 75%;
}

#dualColumn2 {
    float: left;
    width: 25%;
}



ul {list-style-type: none;}


.month {
  padding: 10px 25px;
  text-align: center;
  color:black;
  border-top:1px solid black;
  border-left:1px solid black;
  border-right:1px solid black;
}

.month ul {
  margin: 0;
  padding: 0;
  color:black;
}

.month ul li {
  color: black;
  font-size: 20px;
}

.month .prev {
  float: left;
  padding-top: 10px;
}

.month .next {
  float: right;
  padding-top: 10px;
}

.weekdays {
  margin: 0;
  padding: 10px 0;
  background-color: white;
  padding-left: 10px;
  border-left:1px solid black;
  border-right:1px solid black;
}

.weekdays li {
  display: inline-block;
  width: 12%;
  color: black;
  text-align: center;
}

.days {
  padding: 10px 0;
  background: white;
  margin: 0;
  padding-left: 10px;
  border-left:1px solid black;
  border-right:1px solid black;
  border-bottom:1px solid black;
}

.days li {
  list-style-type: none;
  display: inline-block;
  width: 12%;
  text-align: center;
  margin-bottom: 5px;
  font-size:12px;
  color: black;
}

.days li .blockout {
  color: grey !important
}

.date {
  border: none;
  outline: none;
  cursor: pointer;
  padding: 5px;
}

.active, .date:hover {
  background-color: #666;
  color: white;
}


</style>
<body>
    <?php include 'header.php'?>    
    <div id = "main">
        <div class="banner">
            <div id="bannertext">
                <h1>MAKE A BOOKING</h1>
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
                        <li class="BreadcrumbsItem">
                            <a href="javascript:window.location.href=window.location.href" class="BreadcrumbsURL BreadcrumbsURLactive">Book</a>
                        </li>
                    </ul>
            </div>
        </div>
        
        <div class="maincontainer">
        <div id="dualContainer">
            <div id="dualColumn1">
                <h1><strong>MERIDA Big Seven</strong></h1>
                <img src="img/photos/4.jpg" style="width:50%;">
                <p>Price Per: $$</p>
                <p>Duration: MIN 2 Hrs<p>
                <h1><strong>Details</strong></h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                <p style="padding-left: 25px;">- Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                <p style="padding-left: 25px;">- Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                <p style="padding-left: 25px;">- Duis aute irure dolor in reprehenderit in voluptate</p>
                <p style="padding-left: 25px;">- Cillum dolore eu fugiat nulla pariatur</p>
            </div>
            <div id="dualColumn2">
                <p><strong>Select Date:</strong></p>
                <div class="month">      
                  <ul>
                    <li class="prev">&#10094;</li>
                    <li class="next">&#10095;</li>
                    <li style="font-size:14px">MAY<br>
                      <span style="font-size:14px">2022</span>
                    </li>
                  </ul>
                </div>

                <ul class="weekdays">
                  <li>M</li>
                  <li>T</li>
                  <li>W</li>
                  <li>T</li>
                  <li>F</li>
                  <li>S</li>
                  <li>S</li>
                </ul>
                <div id="dateContainer">
                <ul class="days">  
                  <a href="javascript:changeDate()"><li><span class="date active">1</span></li></a>
                  <a href="javascript:changeDate()"><li><span class="date">2</span></li></a>
                  <a href="javascript:changeDate()"><li><span class="date">3</span></li></a>
                  <a href="javascript:changeDate()"><li><span class="date">4</span></li></a>
                  <a href="javascript:changeDate()"><li><span class="date">5</span></li></a>
                  <a href="javascript:changeDate()"><li><span class="date">6</span></li></a>
                  <a href="javascript:changeDate()"><li><span class="date">7</span></li></a>
                  <a href="javascript:changeDate()"><li><span class="date">8</span></li></a>
                  <a href="javascript:changeDate()"><li><span class="date">9</span></li></a>
                  <a href="javascript:changeDate()"><li><span class="date">10</span></li></a>
                  <a href="javascript:changeDate()"><li><span class="date">11</span></li></a>
                  <a href="javascript:changeDate()"><li><span class="date">12</span></li></a>
                  <a href="javascript:changeDate()"><li><span class="date">13</span></li></a>
                  <a href="javascript:changeDate()"><li><span class="date">14</span></li></a>
                  <a href="javascript:changeDate()"><li><span class="date">15</span></li></a>
                  <a href="javascript:changeDate()"><li><span class="date">16</span></li></a>
                  <a href="javascript:changeDate()"><li><span class="date">17</span></li></a>
                  <a href="javascript:changeDate()"><li><span class="date">18</span></li></a>
                  <a href="javascript:changeDate()"><li><span class="date">19</span></li></a>
                  <a href="javascript:changeDate()"><li><span class="date">20</span></li></a>
                  <a href="javascript:changeDate()"><li><span class="date">21</span></li></a>
                  <a href="javascript:changeDate()"><li><span class="date">22</span></li></a>
                  <a href="javascript:changeDate()"><li><span class="date">23</span></li></a>
                  <a href="javascript:changeDate()"><li><span class="date">24</span></li></a>
                  <a href="javascript:changeDate()"><li><span class="date">25</span></li></a>
                  <a href="javascript:changeDate()"><li><span class="date">26</span></li></a>
                  <a href="javascript:changeDate()"><li><span class="date">27</span></li></a>
                  <a href="javascript:changeDate()"><li><span class="date">28</span></li></a>
                  <a href="javascript:changeDate()"><li><span class="date">29</span></li></a>
                  <a href="javascript:changeDate()"><li><span class="date">30</span></li></a>
                  <a href="javascript:changeDate()"><li><span class="date">31</span></li></a>
                </ul>
                </div>
                <br>
                <form action="insert.php" method="post"> 
                  <input class="" type="text" id="bikeType" name="bikeType" value="MERIDA Big Seven" hidden>
                  <input class="dateInput" type="text" id="dateValue" name="dateValue" value="1" hidden>
                  <label for="timeValue">Time:</label>
                  <select id="timeValue" name="timeValue">
                    <option value="none"></option>
                    <option value="9:00AM">9:00 AM</option>
                    <option value="10:00AM">10:00 AM</option>
                    <option value="11:00AM">11:00 AM</option>
                    <option value="12:00PM">12:00 PM</option>
                    <option value="1:00PM">1:00 PM</option>
                    <option value="2:00PM">2:00 PM</option>
                    <option value="3:00PM">3:00 PM</option>
                    <option value="4:00PM">4:00 PM</option>
                  </select>
                  <label for="durationValue">Duration:</label>
                  <select id="durationValue" name="durationValue">
                    <option value="none"></option>
                    <option value="2 Hours">2 Hours</option>
                    <option value="3 Hours">3 Hours</option>
                    <option value="4 Hours">4 Hours</option>
                    <option value="5 Hours">5 Hours</option>
                    <option value="6 Hours">6 Hours</option>
                    <option value="7 Hours">7 Hours</option>
                    <option value="Overnight">Overnight</option>
                  </select>
                  <br>
                  <br>
                  <label for="locationValue">Pick-Up Location:</label>
                  <select id="locationValue" name="locationValue">
                    <option value="none"></option>
                    <option value="Inverloch Pier">Inverloch Pier</option>
                    <option value="Inverloch Library">Inverloch Library</option>
                  </select>
                  <br>
                  <br>
                  <label for="quantityValue">Quantity:</label>
                  <select id="quantityValue" name="quantityValue">
                    <option value="none"></option>
                    <option value="1 Bike">1 Bike</option>
                    <option value="2 Bikes">2 Bikes</option>
                    <option value="3 Bikes">3 Bikes</option>
                    <option value="4 Bikes">4 Bikes</option>
                  </select>
                  <br>
                  <br>
                  <input type="checkbox" id="termsValue" name="termsValue" value="">
                  <label for="termsValue"> I have read and agreed to the <a href="">terms and conditions.</a></label>
                  <br>
                  <br>
                  <center><input type="submit" value="BOOK NOW" style="background-color:black;color:white;padding: 10px;text-align: center;font-size:24px;width: 100%;"></center>
                </form>


            </div>
        </div>
    </div>





        <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
        <script type = "text/javascript">
        $('.main-carousel').flickity({
        cellAlign: 'left',
        wrapAround:true,
        freeScroll:true
        });</script>
    </div>
    <?php include 'footer.php'?>
<script type="text/javascript">
// Run function on load 
document.onload = changeDate();
function changeDate(){
// Set variables
var dateContainer = document.getElementById("dateContainer");
var dates = dateContainer.getElementsByClassName("date");
// Loop through the buttons and add the active class to the clicked date
for (var i = 0; i < dates.length; i++) {
  dates[i].addEventListener("click", function() {
    var currentDate = document.getElementsByClassName("active");
    currentDate[0].className = currentDate[0].className.replace(" active", "");
    this.className += " active";
    // Set form value for date to clicked date
    document.getElementById("dateValue").value = document.getElementsByClassName("active")[0].innerHTML;
  });
}
}
</script>    
</body>
</html>