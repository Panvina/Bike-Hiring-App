<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="style/Jake_style.css">
    <head>
        <title> Admin dashboard </title>
        <h1 class="header"> <img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo" /> Admin Dashboard </h1>
    </head>
    <body>
        <nav>
            <div class = "sideNavigation">
                <a class="active" href= "Dashboard.php"> <img src= "img/icons/bulletin-board.png" alt="Dashboard Logo" /> Dashboard </a> <br>
                <a href = "Customer.php"> <img src= "img/icons/account-group.png" alt="Customer Logo" />  Customer  </a> <br>
                <a href= "Inventory.php"> <img src= "img/icons/bicycle.png" alt="Inventory Logo" />  Inventory </a> <br>
                <a href= "Bookings.php"> <img src= "img/icons/book-open-blank-variant.png" alt="Bookings Logo" /> Bookings </a> <br>
                <a href= "Block_Out_Date.php"> <img src= "img/icons/calendar.png" alt="Block out date Logo" /> Block Out Dates </a> <br>
                <a href= "Locations.php"> <img src= "img/icons/earth.png" alt="Locations Logo" /> Locations </a> <br>
            </div>
         </nav>

        <div class="Content">
            <div style="display: inline-block;">
                <label class="Date" for="dDate"> Tuesday 10th May 2022 </label>
                <img id="rightArrow" src="img/icons/arrow-right-bold.png"/> 
                <img id="calendar" src="img/icons/calendar-blank.png"/>
                <img id="leftArrow" src="img/icons/arrow-left-bold.png"/>
                <br>
             </div>
            <br>
            <h1 class="Headings"> Booking Summary: </h1>
            <h1 class="Headings"> Urgent: </h1>
            <h1 class="Headings"> Inventory Summary: </h1>
            <div class="DashboardInformationContainer"> 
                <div class="DashboardInformation">
                    <h2> Booking Summary </h2>
                    <h3> Total Bookings: </h3>
                    <h3> Total Cancellations: </h3>
                </div>
                <div class="DashboardInformation">
                    <h2>URGENT</h2>
                    <h3>Pending Replacements:</h3>
                </div>
                <div class="DashboardInformation">
                    <h2>Invetory Summary</h2>
                    <h3>Available Bikes:</h3>
                    <h3>Pending Inspections:</h3>
                </div>
            </div>  
            <br>
            <h1 style="line-height: 100px;"> Current Bookings: </h1>
            <div>

            </div>
        </div>
       
    </body>
</html>