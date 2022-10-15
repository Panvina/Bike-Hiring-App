<?php
    /* Code completed by Aadesh Jagannathan - 102072344*/
    /* Script responsible for updating records in accessory table*/
    session_start();
    include_once("backend-connection.php");
    include("inventory-util.php");
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system") or die(mysqli_error($mysqli));

    //temporary variables to print error msg based on form validation
    $validName = "";
    $validPrice = "";
    $emptyType = "";
    $emptyForm = "";

    //Check to identify if the update record button has been set
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
    }

    //Check to identify if the submit button in the update form has been set
   if (isset($_POST["submitUpdateItem"]))
    {
        //Manually assigning ID for the new record - Only used whilst testing
        $accessoryId = $_POST['accessoryId'];

        //Setting safety inspect when updating record
        $safetyInspect = $_POST['safetyInspect'];

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
        //Check if the name field has only alphabets
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
            header("Location: ../Accessory.php?update=$emptyForm&name=$validName&type=$emptyType&price=$validPrice");           
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