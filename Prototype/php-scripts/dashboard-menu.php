<?php
    //enabling the user privilege of certain tabs. Added by Vina Touch 101928802
    include_once "user-privilege.php";

    function getMenuActiveArray()
    {
        $classes = array(
            "dashboard"     => "",
            "customer"      => "",
            "staff"         => "",
            "account"       => "",
            "inventory"     => "",
            "accessory"     => "",
            "biketype"      => "",
            "accessorytype" => "",
            "bookings"      => "",
            "blockoutdate"  => "",
            "location"      => "",
            "editpage"      => "",
            ""              => ""
        );

        return $classes;
    }

    function printMenu($activeClass="", $activeClassName="active")
    {
        // get array of classes for menu and set active class to active
        $classes = getMenuActiveArray();
        $classes[$activeClass] = $activeClassName;

        echo "<a class='{$classes['dashboard']}' href= 'Dashboard.php'> <img src= 'img/icons/bulletin-board.png' alt='Dashboard Logo' /> Dashboard </a> <br>";
        echo "<a class='{$classes['customer']}' href='Customer.php'> <img src= 'img/icons/account-group.png' alt='Customer Logo' />  Customer  </a> <br>";
        setOwnerDashboardPrivilege($classes['staff'], $classes['account']);
        echo " <div class='dropDownNav'>
                    <a disabled> <img src= 'img/icons/bicycle.png' alt='Inventory Logo'/> Bikes</a>
                    <div class='dropdown-Navcontent'>
                        <a class='{$classes['inventory']}' href= 'Inventory.php'> <img src= 'img/icons/bicycle.png' alt='Inventory Logo' />  Bike Inventory </a>
                        <a class='{$classes['biketype']}' href='BikeTypes.php'> <img src='img/icons/biketypes.png' alt='Bike Types Logo' /> Bike Types </a>
                    </div>
               </div>";
        // echo "<a class='{$classes['inventory']}' href= 'Inventory.php'> <img src= 'img/icons/bicycle.png' alt='Inventory Logo' />  Bike Inventory </a> <br>";
        // echo "<a class='{$classes['biketype']}' href='BikeTypes.php'> <img src='img/icons/biketypes.png' alt='Bike Types Logo' /> Bike Types </a> <br>";
        echo " <div class='dropDownNav'>
                    <a disabled> <img src='img/icons/accessories.png' alt='Inventory Logo'/> Accessories</a>
                    <div class='dropdown-Navcontent'>
                        <a class='{$classes['accessory']}' href='Accessory.php'> <img src='img/icons/accessories.png' alt='Inventory Logo' />   Accessory Inventory </a>
                        <a class='{$classes['accessorytype']}' href='AccessoryTypes.php'> <img src='img/icons/accessorytypes.png' alt='Bike Types Logo' />  Accessory Types </a>
                    </div>
               </div>";
        // echo "<a class='{$classes['accessory']}' href='Accessory.php'> <img src='img/icons/accessories.png' alt='Inventory Logo' /> Accessory Inventory </a> <br>";
        // echo "<a class='{$classes['accessorytype']}' href='AccessoryTypes.php'> <img src='img/icons/accessorytypes.png' alt='Bike Types Logo' /> Accessory Types </a> <br>";
        echo "<a class='{$classes['bookings']}' href='bookings.php'> <img src= 'img/icons/book-open-blank-variant.png' alt='Bookings Logo' /> Bookings </a> <br>";
        echo "<a class='{$classes['blockoutdate']}' href='Block_Out_Date.php'> <img src= 'img/icons/calendar.png' alt='Block out date Logo' /> Block Out Dates </a> <br>";
        echo "<a class='{$classes['location']}' href='Locations.php'> <img src= 'img/icons/earth.png' alt='Locations Logo' /> Locations </a> <br>";
        echo "<a class='{$classes['editpage']}' href='editpages.php'> <img src= 'img/icons/bulletin-board.png' alt='Edit Pages Logo' /> Edit Page </a> <br>";
        setLogoutButton();
    }
?>
