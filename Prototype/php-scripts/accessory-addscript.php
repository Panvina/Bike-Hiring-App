<?php
    /* Code completed by Aadesh Jagannathan - 102072344*/
    /* Script responsible for adding records in accessory types table*/
    session_start();
    include 'backend-connection.php';
    include("inventory-util.php");
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system");

     //temporary session variables are created to retain input data when performing validation checks
     $_SESSION["tempName"] = $_POST["name"];
     $_SESSION["tempAccessoryTypeId"] = explode("-",$_POST["accessoryTypeId"],2);
     $_SESSION["tempPrice"] = $_POST["price"];
     $_SESSION["tempSafetyInspect"] = $_POST["safetyInspect"];
    
    //Manually assigning ID for the new record - Only used whilst testing
    $accessoryId = $_POST["accessoryId"];
    //Setting safety inspect when adding record
    $safetyInspect = $_POST["safetyInspect"];

    //temporary variables to print error msg based on form validation
    $validName = "";
    $validPrice = "";
    $emptyType = "";
    $emptyForm = "";

    //Search concept adapted from Alex
    if (isset($_POST['search-btn'])){
        $search = $_POST["search"];

        if (trim($search) != "")
        {
            header("Location: ..\Accessory.php?search=$search");
        }
        else
        {
            header("Location: ..\Accessory.php");
        }
    } 

    //Check to identify if the add record button has been set
    if(isset($_POST['AddItem'])){
        /* Form validation for adding records*/
        //Check if all the fields are empty
        if(empty($_POST["name"]) && empty($_POST["accessoryTypeId"])&& empty($_POST["price"]))
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

        //Check if the accessory type id is empty
        if (empty($_POST["accessoryTypeId"]))
        {
            $emptyType = "empty";
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

        //Check to determine if any validation flags have been set
        if((!empty($validName)) || (!empty($emptyType)) || (!empty($validPrice)) || (!empty($emptyForm)))
        {
            header("Location: ../Accessory.php?insert=$emptyForm&name=$validName&type=$emptyType&price=$validPrice");           
        }
        else 
        {
            //Cleaning the inputs before assigning to variables 
            $name = test_input($_POST["name"]);
            $accessoryTypeId = test_input($_POST["accessoryTypeId"]);
            $tempaccessoryTypeId = explode("-",$accessoryTypeId,2);
            $price = test_input($_POST["price"]);
        }
    //Final check to ensure variables are not empty
    if(empty($name) && empty($accessoryTypeId) && empty($price))
    {
        echo "<p>Failure</p>";
    }
    else
    {
    
        $cols = "`accessory_id`, `name`, `accessory_type_id`, `price_ph`, `safety_inspect`";
        $data = "'$accessoryId', '$name', '$tempaccessoryTypeId[0]', '$price', '$safetyInspect'";
        
        $query = "INSERT INTO `accessory_inventory_table` ($cols) VALUES ($data)";
        $results = mysqli_query($conn,$query);

        //unset all the temporary data stored during form validation
        unset($_SESSION["tempName"]);
        unset($_SESSION["tempAccessoryTypeId"]);
        unset($_SESSION["tempPrice"]);
        unset($_SESSION["tempSafetyInspect"]);
        
        if($results = true)
        {
            header("Location: ../Accessory.php?insert=true");
            exit();
        }
        else
        {
            header("Location: ../Accessory.php?insert=false");
            exit();
        }
    
        mysqli_close($conn);
    }
}
?>