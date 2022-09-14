<?php
    session_start();
    include_once("backend-connection.php");
    //include ("utils.php");
    include("inventory-util.php");
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system") or die(mysqli_error($mysqli));
    $ret = array();
  
    if (isset($_POST['updateItem']))
  {
        $primaryKey = $_POST['updateItem'];
    
        $cols = "accessory_id, name, accessory_type_id, price_ph, safety_inspect";

        $query = "SELECT * FROM accessory_inventory_table WHERE accessory_id=$primaryKey";

        $result = mysqli_query($conn, $query);
        $fetchData = $result->fetch_array();


        $_SESSION["accessory_id"] = $fetchData["accessory_id"];
        $_SESSION["name"] = $fetchData["name"];
        $_SESSION["accessory_type_id"] = $fetchData["accessory_type_id"];
        $_SESSION["price_ph"] = $fetchData["price_ph"];
        $_SESSION["safety_inspect"] = $fetchData["safety_inspect"];
        

        $name = $_SESSION['name'];
        $accessoryTypeId = $_SESSION['accessory_type_id'];       
        $price = $_SESSION['price_ph'];
        $safetyInspect = $_SESSION['safety_inspect'];

        header("location:../Accessory.php?update=notEmpty");
        /* if (!checkEmptyVariables([$name, $accessoryTypeId, $price, $safetyInspect]))
        {
            header("Location: ../Accessory.php?update=notEmpty");
            exit();
        }
        else
        {
            header("Location: ../Accessory.php?update=empty");
            exit();
        }  */
   }
   
   if (isset($_POST["submitUpdateItem"]))
   {
        $accessoryId = $_POST['accessoryId'];
        //$name = $_POST['name'];
        //$accessoryTypeId = $_POST['accessoryTypeId'];
        //$price = $_POST['price'];
        $safetyInspect = $_POST['safetyInspect'];

                /* Form validation for adding records*/
        //Check if all the fields are empty
        if(empty($_POST["name"]) && empty($_POST["accessoryTypeId"])&& empty($_POST["price"]))
        {
            header("Location: ../Accessory.php?update=empty");
        }
        //Check if the name field is empty
        else if(empty($_POST["name"]))
        {
            header("Location: ../Accessory.php?update=emptyName");
        }
        //Check if the accessory type id is empty
        else if (empty($_POST["accessoryTypeId"]))
        {
            header("Location: ../Accessory.php?update=emptyType");
        }
        //Check if the price field is empty
        else if (empty($_POST["price"]))
        {
            header("Location: ../Accessory.php?update=emptyPrice");
        }
        //Check if the name field has only alphabets
        else if (!validName($_POST["name"])) 
        {
           header("Location: ../Accessory.php?update=invalidName");
        }
        //Check if the price field has only integers and decimals
        else if (!validPrice($_POST["price"]))
        {
            header("Location: ../Accessory.php?update=invalidPrice");
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
            $data = "'$accessoryId', '$name', '$accessoryTypeId', '$helmetId', '$price', '$safetyInspect'";

            $conn->query("UPDATE accessory_inventory_table 
            SET name='$name', accessory_type_id = '$accessoryTypeId', `price_ph`='$price', `safety_inspect`='$safetyInspect'
            WHERE accessory_id=$accessoryId");
            //Check to see if query has been successful
            if($conn = true)
            {
                header("location:../Accessory.php?update=true");
            }
            else
            {
                header("location:../Accessory.php?update=false");
            }      
        }
    }
        
?>