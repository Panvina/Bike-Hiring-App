<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="style/Jake_style.css">
    <head>
        <title> Block Out Dates </title>
        <h1 class="header"> <img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo"/> Block Out Dates </h1>
    </head>
    <body>
        <nav>
            <div class = "sideNavigation">
                <a href = "Dashboard.php"> <img src= "img/icons/bulletin-board.png" alt="Dashboard Logo" /> Dashboard </a> <br>
                <a href = "Customer.php"> <img src= "img/icons/account-group.png" alt="Customer Logo" />  Customer  </a> <br>
                <a href= "Inventory.php"> <img src= "img/icons/bicycle.png" alt="Inventory Logo" />  Inventory </a> <br>
                <a href= "Bookings.php"> <img src= "img/icons/book-open-blank-variant.png" alt="Bookings Logo" /> Bookings </a> <br>
                <a class="active" href= "Block_Out_Date.php"> <img src= "img/icons/calendar.png" alt="Block out date Logo" /> Block Out Dates </a> <br>
                <a href= "Locations.php"> <img src= "img/icons/earth.png" alt="Locations Logo" /> Locations </a> <br>
            </div>
         </nav>

         <div class="Content">
            <h1> Block Out Dates </h1>
            <button type="button" style="left: 0%">+ Add Item</button> 
            <table class="TableContent">
                 <tr>
                     <th> From </th>
                     <th> To </th>
                     <th> Reason </th>
                 </tr>
                 <tr>
                     <td> 20th December, 2022 </td>
                     <td> 2nd January, 2023 </td>
                     <td> Christmas Period </td>
                 </tr>
            </table>
        </div>

    </body>
</html>