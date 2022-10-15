<?php
    /* Code completed by Aadesh Jagannathan - 102072344*/
    /* Script responsible for updating records in inventory table*/
    session_start();
    include_once("backend-connection.php");
    include("inventory-util.php");
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system") or die(mysqli_error($mysqli));

    //temporary variables to print error msg based on form validation
    $validName = "";
    $validPrice = "";
    $validDesc = "";
    $emptyType = "";  
    $emptyHelmet = "";
    $emptyForm = "";
    
    //Check to identify if the update record button has been set
    if (isset($_POST['updateItem']))
    {
        $pk = $_POST['updateItem'];
    
        $cols = "bike_id, name, bike_type_id, helmet_id, price_ph, safety_inspect, description";

        $query = "SELECT * FROM bike_inventory_table WHERE bike_id=$pk";

        $result = mysqli_query($conn, $query);
        $fetchData = $result->fetch_array();

        $_SESSION["bike_id"] = $fetchData["bike_id"];
        $_SESSION["name"] = $fetchData["name"];
        $_SESSION["bike_type_id"] = $fetchData["bike_type_id"];
        $_SESSION["helmet_id"] = $fetchData["helmet_id"];
        $_SESSION["price_ph"] = $fetchData["price_ph"];
        $_SESSION["safety_inspect"] = $fetchData["safety_inspect"];
        $_SESSION["description"] = $fetchData["description"];
        

        $name = $_SESSION['name'];
        $bikeTypeId = $_SESSION['bike_type_id'];
        $helmetId = $_SESSION['helmet_id'];
        $price = $_SESSION['price_ph'];
        $safetyInspect = $_SESSION['safety_inspect'];
        $description = $_SESSION['description'];

        header("Location:../Inventory.php?update=notEmpty");
    }
   
   //Check to identify if the submit button in the update form has been set
   if (isset($_POST["submitUpdateItem"]))
    {
        //Manually assigning ID for the new record - Only used whilst testing
        $bikeId = $_POST['bikeId'];
        
        //Setting safety inspect when updating record
        $safetyInspect = $_POST['safetyInspect'];
        
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
           header("Location: ../Inventory.php?update=$emptyForm&name=$validName&type=$emptyType&helmet=$emptyHelmet&price=$validPrice&desc=$validDesc");           
       }
       else 
       {
           //Cleaning the inputs before assigning to variables 
           $name = test_input($_POST["name"]);
           $bikeTypeId = test_input($_POST["bikeTypeId"]);
           $helmetId = test_input($_POST["helmetId"]);
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
        $data = "'$bikeId', '$name', '$bikeTypeId', '$helmetId', '$price', '$safetyInspect', '$description'";

        $conn->query("UPDATE bike_inventory_table 
        SET name='$name', bike_type_id = '$bikeTypeId', helmet_id='$helmetId', description='$description', `price_ph`='$price', `safety_inspect`='$safetyInspect'
        WHERE bike_id=$bikeId");

        //Check to see if query has been successful
        if($conn = true)
        {
            header("location:../Inventory.php?update=true");   
        }
        else
        {
            header("location:../Inventory.php?update=false");  
        } 
    }
}
        
?>