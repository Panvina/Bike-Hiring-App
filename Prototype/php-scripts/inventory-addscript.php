<?php
    /* Code completed by Aadesh Jagannathan - 102072344*/
    /* Script responsible for adding records in inventory table*/
    session_start();
    include 'backend-connection.php';
    include("inventory-util.php");
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system");

    //temporary session variables are created to retain input data when performing validation checks
    $_SESSION["tempName"] = $_POST["name"];
    $_SESSION["tempBikeTypeId"] = explode("-",$_POST["bikeTypeId"],2);
    $_SESSION["tempHelmetId"] = explode("-",$_POST["helmetId"],2);
    $_SESSION["tempPrice"] = $_POST["price"];
    $_SESSION["tempSafetyInspect"] = $_POST["safetyInspect"];
    $_SESSION["tempDescription"] = $_POST["description"];

    //Manually assigning ID for the new record - Only used whilst testing
    $bikeId = $_POST["bikeId"];
    //Setting safety inspect when adding record
    $safetyInspect = $_POST["safetyInspect"];

    //temporary variables to print error msg based on form validation
    $validName = "";
    $validPrice = "";
    $validDesc = "";
    $emptyType = "";  
    $emptyHelmet = "";
    $emptyForm = "";

    //Search concept adapted from Alex
    if (isset($_POST['search-btn'])){
        $search = $_POST["search"];

        if (trim($search) != "")
        {
            header("Location: ..\Inventory.php?search=$search");
        }
        else
        {
            header("Location: ..\Inventory.php");
        }
    } 

    //Check to identify if the add record button has been set
    if(isset($_POST['AddItem'])){
        /* Form validation for adding records*/
        //Check if all the fields are empty
       if(empty($_POST["name"]) && empty($_POST["bikeTypeId"]) && empty($_POST["helmetId"]) && empty($_POST["price"]) && empty($_POST["description"]))
        {
            $emptyForm = "empty";
        }

        //Check if the name field is empty
        if(empty($_POST["name"]))
        {
            $validName = "empty";
        }
        ////Check if the name field has the alphabets, integers, _ or -
        else if (!validName($_POST["name"])) 
        {
            $validName = "invalid";
        }

        //Check if the bike type id is empty
        if (empty($_POST["bikeTypeId"]))
        {
            $emptyType = "empty";
        }

        //Check if the helmet id is empty
        if (empty($_POST["helmetId"]))
        {
            $emptyHelmet = "empty";
        }

        //Check if the price field is empty
        if (empty($_POST["price"]))
        {
            $validPrice = "empty";
        }
        //Check if the price field has only integers and decimals
        else if (!validPrice($_POST["price"]))
        {
            $validPrice = "invalid";
        }

        //Check if only the description field is empty
        if (empty($_POST["description"])) 
        {
            $validDesc = "empty";
        }
        
        //Check to determine if any validation flags have been set
        if((!empty($validName)) || (!empty($emptyType)) || (!empty($emptyHelmet)) || (!empty($validPrice)) || (!empty($validDesc)) || (!empty($emptyForm)))
        {
            header("Location: ../Inventory.php?insert=$emptyForm&name=$validName&type=$emptyType&helmet=$emptyHelmet&price=$validPrice&desc=$validDesc");           
        }
        else 
        {
            //Cleaning the inputs before assigning to variables 
            $name = test_input($_POST["name"]);
            $bikeTypeId = test_input($_POST["bikeTypeId"]);
            $helmetId = test_input($_POST["helmetId"]);
            $tempHelmetId = explode("-",$helmetId,2);
            $tempBikeTypeId = explode("-",$bikeTypeId,2);
            $price = test_input($_POST["price"]);
            $description = test_input($_POST["description"]);
        }

    //Final check to ensure variables are not empty
    if(empty($name) && empty($bikeTypeId) && empty($price))
    {
        echo "<p>Failure</p>";
    }
    else
    {
        $cols = "`bike_id`, `name`, `bike_type_id`, `helmet_id`, `price_ph`, `safety_inspect`, `description`";
        $data = "'$bikeId', '$name', '$tempBikeTypeId[0]', '$tempHelmetId[0]', '$price', '$safetyInspect', '$description'";
        
        $query = "INSERT INTO `bike_inventory_table` ($cols) VALUES ($data)";
        $results = mysqli_query($conn,$query);
        
        //unset all the temporary data stored during form validation
        unset($_SESSION["tempName"]);
        unset($_SESSION["tempBikeTypeId"]);
        unset($_SESSION["tempHelmetId"]);
        unset($_SESSION["tempPrice"]);
        unset($_SESSION["tempSafetyInspect"]);
        unset($_SESSION["tempDescription"]);

        if($results = true)
        {
            header("Location: ../Inventory.php?insert=true");
            exit();
        }
        else
        {
            header("Location: ../Inventory.php?insert=false");
            exit();
        }
    
        mysqli_close($conn);
    }
}
?>