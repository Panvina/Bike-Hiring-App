<?php
    session_start();
    include_once("php-scripts\backend-connection.php");
    include ("php-scripts/utils.php");
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system") or die(mysqli_error($mysqli));
    $ret = array();
  
    if (isset($_POST['updateItem']))
  {
        $primaryKey = $_POST['updateItem'];
    
        $cols = "accessory_type_id, name, description";

        $query = "SELECT * FROM accessory_type_table WHERE accessory_type_id=$primaryKey";

        $result = mysqli_query($conn, $query);
        $fetchData = $result->fetch_array();


        $_SESSION["accessory_type_id"] = $fetchData["accessory_type_id"];
        $_SESSION["name"] = $fetchData["name"];
        $_SESSION["description"] = $fetchData["description"];
        

        $name = $_SESSION['name'];
        $description = $_SESSION['description'];

        header("location:AccessoryTypes.php?update=notEmpty");
        /* if (!checkEmptyVariables([$name, $accessoryTypeId, $price, $safetyInspect]))
        {
            header("Location: Accessory.php?update=notEmpty");
            exit();
        }
        else
        {
            header("Location: Accessory.php?update=empty");
            exit();
        }  */
   }
   
   if (isset($_POST["submitUpdateItem"]))
   {
        $accessory_type_id = $_POST['accessoryId'];
        $name = $_POST['name'];
        $description = $_POST['description'];

        $cols = "`accessory_type_id`, `name`, `description`";
        $data = "'$accessory_type_id', '$name', '$description'";

        $conn->query("UPDATE accessory_type_table 
        SET name='$name', `description`='$description'
        WHERE accessory_type_id=$accessory_type_id");

        header("location:AccessoryTypes.php?update=true");      
   }

   if (isset($_POST['deleteItem']))
   {
       $primaryKey = $_POST['deleteItem'];
   
       $cols = "accessory_type_id, name, description";

       $query = "SELECT * FROM accessory_type_table WHERE accessory_type_id=$primaryKey";

       $result = mysqli_query($conn, $query);
       $fetchData = $result->fetch_array();

       $_SESSION["accessory_type_id"] = $fetchData["accessory_type_id"];
       $primaryKey = $_SESSION["accessory_type_id"];

       header("Location: AccessoryTypes.php?delete=$primaryKey");
       exit();
   }

   if (isset($_POST["submitDeleteItem"]))
   {
      
       $primaryKey = $_POST["submitDeleteItem"];
       $query = "DELETE FROM accessory_type_table WHERE accessory_type_id=$primaryKey";
       $results = mysqli_query($conn, $query);
       header("Location: AccessoryTypes.php?delete=true");
   }

   if (isset($_POST["cancelDeleteItem"]))
   {
    header("Location: AccessoryTypes.php");
    exit();
   }
        
?>