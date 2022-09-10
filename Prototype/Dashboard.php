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

            <!-- Current bookings section -->
            <h1 style="line-height: 50px;"><strong> Current Bookings: </strong></h1>
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
				<div class="event stage-bike start-900 end-1100 length-2">Danny</div>
				<div class="event stage-bike start-1200 end-1230 length-2">John</div>
				<div class="event stage-bike start-1200 end-1500 length-2">Callum</div>
				<div class="event stage-bike start-900 end-1130 length-2">Jonothan</div>
				<div class="event stage-bike start-900 end-1630 length-1">Joshua</div>
				<div class="event stage-bike start-1300 end-1500 length-2">Bill</div>
				<div class="event stage-bike start-930 end-1200 length-2">Meika</div>
				<div class="event stage-bike start-1300 end-1400 length-2">Roger</div>
				<div class="event stage-bike start-1030 end-1200 length-2">Daniel</div>
				<div class="event stage-bike start-1100 end-1330 length-2">Jane</div>
				<div class="event stage-bike start-900 end-1030 length-2">Carmen</div>
				<div class="event stage-bike start-1330 end-1530 length-2">Ash</div>
				<div class="event stage-bike start-1100 end-1400 length-2">Jessica</div>
				<div class="event stage-bike start-1430 end-1700 length-2">Rob</div>
				<div class="event stage-bike start-1500 end-1630 length-3">Steve</div>
				<div class="event stage-bike start-1000 end-1200 length-2">Cynthia</div>
			</div>
        </div>

    </body>
</html>
