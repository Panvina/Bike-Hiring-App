<!--
Project Name: Inverloch Bike Hire
Project Description: A website for hiring bikes. Front-end accompanied
	   by an admin dashboard.
File Description: Show both the functions and locations information
Contributor(s):
	- Clement Cheung @ 103076376@student.swin.edu.au
	- Vina Touch @ 101928802@student.swin.edu.au
	- Jake Hipworth @ 102090870@student.swin.edu.au (Navigation section and Styles)
-->
<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="style/Jake_style.css">
    <link rel="stylesheet" href="style/scheduleTimetableStyle.css">
    <head>
        <!-- header -->
        <title> Admin dashboard </title>
        <h1 class="header"> <img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo" /> Admin Dashboard </h1>
    </head>
    <body>
        <!-- Side navigation -->
        <nav>
            <div class = "sideNavigation">
                <a class="active" href= "Dashboard.php"> <img src= "img/icons/bulletin-board.png" alt="Dashboard Logo" /> Dashboard </a> <br>
                <a href = "Customer.php"> <img src= "img/icons/account-group.png" alt="Customer Logo" />  Customer  </a> <br>
                <a href= "Inventory.php"> <img src= "img/icons/bicycle.png" alt="Inventory Logo" />  Inventory </a> <br>
                <a href="Accessory.php"> <img src="img/icons/accessories.png" alt="Inventory Logo" /> Accessories </a> <br>
                <a href= "bookings.php"> <img src= "img/icons/book-open-blank-variant.png" alt="Bookings Logo" /> Bookings </a> <br>
                <a href= "Block_Out_Date.php"> <img src= "img/icons/calendar.png" alt="Block out date Logo" /> Block Out Dates </a> <br>
                <a href= "Locations.php"> <img src= "img/icons/earth.png" alt="Locations Logo" /> Locations </a> <br>
            </div>
         </nav>
        <!-- Block of content in center -->
        <div class="Content">
            <div style="display: inline-block;">
                <label class="Date" for="dDate"> Tuesd	ay 10th May 2022 </label>
                <img id="rightArrow" src="img/icons/arrow-right-bold.png"/>
                <img id="calendar" src="img/icons/calendar-blank.png"/>
                <img id="leftArrow" src="img/icons/arrow-left-bold.png"/>
                <br>
             </div>
            <br>
            <!-- Section headings -->
            <h1 class="Headings"> Booking Summary: </h1>
            <h1 class="Headings"> Urgent: </h1>
            <h1 class="Headings"> Inventory Summary: </h1>

            <div class="DashboardInformationContainer">
                <!-- Booking summary section -->
                <div class="DashboardInformation">
                    <h2> Booking Summary </h2>
                    <h3> Total Bookings: </h3>
                    <h3> Total Cancellations: </h3>
                </div>

                <!-- Urgent section -->
                <div class="DashboardInformation">
                    <h2>URGENT</h2>
                    <h3>Pending Replacements:</h3>
                </div>
                <!-- Inventory Summary section -->
                <div class="DashboardInformation">
                    <h2>Invetory Summary</h2>
                    <h3>Available Bikes:</h3>
                    <h3>Pending Inspections:</h3>
                </div>
            </div>
            <br>
			<!--This calendar section is done by Clement where it is showing the current bookings as an event scheduler and it is hard code since it is to demonstrate the potential type of thing-->
            <!-- Current bookings section -->
            <h1 style="line-height: 50px;"><strong> Current Bookings: </strong></h1>

            <!-- This is the key index to show the admins/users of what the color relating to the status of the ooking -->
			<div class="keyContainer"><div class="keys">Key:</div> 
				<div class="event stage-booked length-1 key">Booked</div>
				<div class="event stage-confirm length-1 key">Confirm</div>
				<div class="event stage-checkedOut length-1 key">Checkout</div>
				<div class="event stage-provisional length-1 key">Provisional</div>
				
			</div>
            
            <div class="background">
                <pre>
                    <!--keeping the schedule inside it-->
                    <div class="scheduleContainer">
				<!-- TIMES -->
				<div class="time start-900">9:00</div>
				<div class="time start-930">9:30</div>
				<div class="time start-1000">10:00</div>
				<div class="time start-1030">10:30</div>
				<div class="time start-1100">11:00</div>
				<div class="time start-1130">11:30</div>
				<div class="time start-1200">12:00</div>
				<div class="time start-1230">12:30</div>
				<div class="time start-1300">13:00</div>
				<div class="time start-1330">13:30</div>
				<div class="time start-1400">14:00</div>
				<div class="time start-1430">14:30</div>
				<div class="time start-1500">15:00</div>
				<div class="time start-1530">15:30</div>
				<div class="time start-1600">16:00</div>
				<div class="time start-1630">16:30</div>
				<div class="time start-1700">17:00</div>
                  
				<!-- EVENTS -->				
				<!--This is to sort in order of time start so the it can be shown cleanly-->
                <!-- From this line below, in the div area, the code can be changed from soft to hard code -->
				
				
				<!--Given the scenario where there is a lot of booking on this day-->
				<div class="event stage-checkedOut start-900 end-1700 length-1">Joshua<br/>9:00-<br/>17:00</div>
				<div class="event stage-checkedOut start-900 end-930 length-1">Josh<br/>9:00-<br/>9:30</div>
				<div class="event stage-provisional start-900 end-1000 length-1">Cynthia<br/>9:00-<br/>10:00</div>
				<div class="event stage-checkedOut start-900 end-1030 length-1">Carmen<br/>9:00-<br/>10:30</div>
				<div class="event stage-checkedOut start-900 end-1100 length-1">Danny<br/>9:00-<br/>11:00</div>
				<div class="event stage-checkedOut start-900 end-1130 length-1">David<br/>9:00-<br/>11:30</div>
				<div class="event stage-checkedOut start-900 end-1130 length-1">Jonothan<br/>9:00-<br/>11:30</div>
				<div class="event stage-checkedOut start-900 end-1700 length-1">Joshua<br/>9:00-<br/>17:00</div>
				<div class="event stage-checkedOut start-900 end-930 length-1">Josh<br/>9:00-<br/>9:30</div>
				<div class="event stage-provisional start-900 end-1000 length-1">Cynthia<br/>9:00-<br/>10:00</div>
				<div class="event stage-checkedOut start-900 end-1030 length-1">Carmen<br/>9:00-<br/>10:30</div>
				<div class="event stage-checkedOut start-900 end-1100 length-1">Danny<br/>9:00-<br/>11:00</div>
				<div class="event stage-checkedOut start-900 end-1130 length-1">David<br/>9:00-<br/>11:30</div>
				<div class="event stage-checkedOut start-900 end-1130 length-1">Jonothan<br/>9:00-<br/>11:30</div>
				<div class="event stage-provisional start-1330 end-1400 length-1">Mike<br/>13:30-<br/>14:00</div>
				<div class="event stage-checkedOut start-930 end-1200 length-1">Meika<br/>9:30-<br/>12:00</div>
				<div class="event stage-checkedOut start-930 end-1200 length-1">Meika<br/>9:30-<br/>12:00</div>
				<div class="event stage-checkedOut start-1000 end-1030 length-1">Rick<br/>10:00-<br/>10:30</div>
				<div class="event stage-confirm start-1030 end-1200 length-1">Daniel<br/>10:30-<br/>12:00</div>
				<div class="event stage-checkedOut start-1000 end-1030 length-1">Rick<br/>10:00-<br/>10:30</div>
				<div class="event stage-confirm start-1030 end-1200 length-1">Daniel<br/>10:30-<br/>12:00</div>
				<div class="event stage-confirm start-1100 end-1400 length-1">Jessica<br/>11:00-<br/>14:00</div>
				<div class="event stage-confirm start-1100 end-1400 length-1">Jessica<br/>11:00-<br/>14:00</div>
				<div class="event stage-booked start-1430 end-1630 length-1">Jane<br/>14:30-<br/>16:30</div>
				<div class="event stage-confirm start-1200 end-1300 length-1">Duncan<br/>12:00-<br/>13:00</div>
				<div class="event stage-provisional start-1200 end-1230 length-1">John<br/>12:00-<br/>12:30</div>
				<div class="event stage-confirm start-1230 end-1300 length-1">Albert<br/>12:30-<br/>13:00</div>
				<div class="event stage-provisional start-1200 end-1230 length-1">Billy<br/>12:00-<br/>12:30</div>
				<div class="event stage-confirm start-1200 end-1300 length-1">Duncan<br/>12:00-<br/>13:00</div>
				<div class="event stage-provisional start-1200 end-1230 length-1">John<br/>12:00-<br/>12:30</div>
				<div class="event stage-confirm start-1230 end-1300 length-1">Albert<br/>12:30-<br/>13:00</div>
				<div class="event stage-provisional start-1200 end-1230 length-1">Billy<br/>12:00-<br/>12:30</div>
				<div class="event stage-booked start-1300 end-1500 length-1">Bill<br/>13:00-<br/>15:00</div>
				<div class="event stage-booked start-1300 end-1400 length-1">Roger<br/>13:00-<br/>14:00</div>
				<div class="event stage-booked start-1300 end-1330 length-1">Daniella<br/>13:00-<br/>14:30</div>
				<div class="event stage-booked start-1300 end-1400 length-1">Courtney<br/>13:00-<br/>14:00</div>
				<div class="event stage-confirm start-1300 end-1500 length-1">Callum<br/>13:00-<br/>15:00</div>
				<div class="event stage-booked start-1300 end-1500 length-1">Bill<br/>13:00-<br/>15:00</div>
				<div class="event stage-booked start-1300 end-1400 length-1">Roger<br/>13:00-<br/>14:00</div>
				<div class="event stage-booked start-1300 end-1330 length-1">Daniella<br/>13:00-<br/>14:30</div>
				<div class="event stage-booked start-1300 end-1400 length-1">Courtney<br/>13:00-<br/>14:00</div>
				<div class="event stage-confirm start-1300 end-1500 length-1">Callum<br/>13:00-<br/>15:00</div>
				<div class="event stage-booked start-1330 end-1530 length-1">Ash<br/>13:30-<br/>15:30</div>
				<div class="event stage-confirm start-1330 end-1400 length-1">Mike<br/>13:30-<br/>14:00</div>
				<div class="event stage-booked start-1330 end-1530 length-1">Ash<br/>13:30-<br/>15:30</div>
				<div class="event stage-booked start-1400 end-1500 length-1">Donald<br/>14:00-<br/>15:00</div>
				<div class="event stage-booked start-1400 end-1500 length-1">Donald<br/>14:00-<br/>15:00</div>
				<div class="event stage-confirm start-1430 end-1630 length-1">Morty<br/>14:30-<br/>16:30</div>
				<div class="event stage-booked start-1430 end-1530 length-1">Trent<br/>14:30-<br/>15:30</div>
				<div class="event stage-provisional start-1430 end-1700 length-1">Rob<br/>14:30-<br/>17:00</div>
				<div class="event stage-confirm start-1430 end-1630 length-1">Morty<br/>14:30-<br/>16:30</div>
				<div class="event stage-booked start-1430 end-1530 length-1">Trent<br/>14:30-<br/>15:30</div>
				<div class="event stage-provisional start-1430 end-1700 length-1">Rob<br/>14:30-<br/>17:00</div>
				<div class="event stage-booked start-1430 end-1630 length-1">Jane<br/>14:30-<br/>16:30</div>
				<div class="event stage-provisional start-1530 end-1630 length-1">Bobby<br/>15:30-<br/>16:30</div>
				<div class="event stage-provisional start-1530 end-1700 length-1">Dave<br/>15:30-<br/>17:00</div>
				<div class="event stage-confirm start-1600 end-1630 length-1">Steve<br/>16:00-<br/>16:30</div>
				<div class="event stage-confirm start-1630 end-1700 length-1">Dean<br/>16:30-<br/>17:00</div>
				<div class="event stage-provisional start-1530 end-1630 length-1">Bobby<br/>15:30-<br/>16:30</div>
				<div class="event stage-provisional start-1530 end-1700 length-1">Dave<br/>15:30-<br/>17:00</div>
				<div class="event stage-confirm start-1600 end-1630 length-1">Steve<br/>16:00-<br/>16:30</div>
				<div class="event stage-confirm start-1630 end-1700 length-1">Dean<br/>16:30-<br/>17:00</div>
				

                <!-- From this line onwards, do not change the code, but can reformat it if needed -->
			</div>
        </pre>
		</div></div>

    </body>
</html>
