<?php
    session_start();
    include_once("php-scripts/backend-connection.php");
    //include_once "php-scripts/utils.php";
    include("inventory-util.php");
    //$conn = new DBConnection("bike_inventory_table");
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system") or die(mysqli_error($mysqli));
    $ret = array();
    
    if (isset($_POST['updateItem']))
  {
        $pk = $_POST['updateItem'];
    
        $cols = "bike_id, name, bike_type_id, helmet_id, price_ph, safety_inspect, description";

        //$condition = "bike_id='$pk'";

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

        header("Location: Inventory.php?update=notEmpty");
        /* if (!checkEmptyVariables([$name, $bikeTypeId, $helmetId, $price, $safetyInspect , $description]))
        {
            exit();
        }
        else
        {
            header("Location: Inventory.php?update=empty");
            exit();
        }  */
   }
   
   if (isset($_POST["submitUpdateItem"]))
   {
        $bikeId = $_POST['bikeId'];
        //$name = $_POST['name'];
        //$bikeTypeId = $_POST['bikeTypeId'];
        //$helmetId = $_POST['helmetId'];
        //$price = $_POST['price'];
        $safetyInspect = $_POST['safetyInspect'];
        //$description = $_POST['description'];

        /* Form validation for adding records*/
        //Check if all the fields are empty
       if(empty($_POST["name"]) && empty($_POST["bikeTypeId"]) && empty($_POST["helmetId"]) && empty($_POST["price"]) && empty($_POST["description"]))
       {
           header("Location: Inventory.php?update=empty");
       }
       //Check if the name field is empty
       else if(empty($_POST["name"]))
       {
           header("Location: Inventory.php?update=emptyName");
       }
       //Check if the bike type id is empty
       else if (empty($_POST["bikeTypeId"]))
       {
           header("Location: Inventory.php?update=emptyType");
       }
       //Check if the helmet id is empty
       else if (empty($_POST["helmetId"]))
       {
           header("Location: Inventory.php?update=emptyHelmet");
       }
       //Check if the price field is empty
       else if (empty($_POST["price"]))
       {
           header("Location: Inventory.php?update=emptyPrice");
       }
       //Check if only the description field is empty
       else if (empty($_POST["description"])) 
       {
          header("Location: Inventory.php?update=emptyDescription");
       }
       //Check if the name field has only alphabets
       else if (!validName($_POST["name"])) 
       {
          header("Location: Inventory.php?update=invalidName");
       }
       //Check if the price field has only integers and decimals
       else if (!validPrice($_POST["price"]))
       {
           header("Location: Inventory.php?update=invalidPrice");
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

        header("location:Inventory.php?update=true");
       
   }
}
        
?>