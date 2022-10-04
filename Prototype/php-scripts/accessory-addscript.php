<?php
    session_start();
    include 'backend-connection.php';
    include("inventory-util.php");
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system");

     //temporary session variables are created to retain input data when performing validation checks
     $_SESSION["tempName"] = $_POST["name"];
     $_SESSION["tempAccessoryTypeId"] = explode("-",$_POST["accessoryTypeId"],2);
     $_SESSION["tempPrice"] = $_POST["price"];
     $_SESSION["tempSafetyInspect"] = $_POST["safetyInspect"];
    
    $accessoryId = $_POST["accessoryId"];
    //$name = $_POST["name"];
    //$accessoryTypeId = $_POST["accessoryTypeId"];
    //$price = $_POST["price"];
    $safetyInspect = $_POST["safetyInspect"];

    //$tempaccessoryTypeId = explode("-",$accessoryTypeId,2);
    
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
    if(isset($_POST['AddItem'])){
        /* Form validation for adding records*/
        //Check if all the fields are empty
        if(empty($_POST["name"]) && empty($_POST["accessoryTypeId"])&& empty($_POST["price"]))
        {
            header("Location: ../Accessory.php?insert=empty");
        }
        //Check if the name field is empty
        else if(empty($_POST["name"]))
        {
            header("Location: ../Accessory.php?insert=emptyName");
        }
        //Check if the accessory type id is empty
        else if (empty($_POST["accessoryTypeId"]))
        {
            header("Location: ../Accessory.php?insert=emptyType");
        }
        //Check if the price field is empty
        else if (empty($_POST["price"]))
        {
            header("Location: ../Accessory.php?insert=emptyPrice");
        }
        //Check if the name field has only alphabets
        else if (!validName($_POST["name"])) 
        {
           header("Location: ../Accessory.php?insert=invalidName");
        }
        //Check if the price field has only integers and decimals
        else if (!validPrice($_POST["price"]))
        {
            header("Location: ../Accessory.php?insert=invalidPrice");
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