<?php
    session_start();
    include_once("php-scripts\backend-connection.php");
    include ("php-scripts/utils.php");
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system") or die(mysqli_error($mysqli));
    $ret = array();
  
    if (isset($_POST['updateItem']))
  {
        $primaryKey = $_POST['updateItem'];
    
        $cols = "bike_type_id, name, description";

        $query = "SELECT * FROM bike_type_table WHERE bike_type_id=$primaryKey";

        $result = mysqli_query($conn, $query);
        $fetchData = $result->fetch_array();


        $_SESSION["bike_type_id"] = $fetchData["bike_type_id"];
        $_SESSION["name"] = $fetchData["name"];
        $_SESSION["description"] = $fetchData["description"];
        

        $name = $_SESSION['name'];
        $description = $_SESSION['description'];

        header("location:BikeTypes.php?update=notEmpty");
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
        $bike_type_id = $_POST['bikeId'];
        $name = $_POST['name'];
        $description = $_POST['description'];

        $cols = "`bike_type_id`, `name`, `description`";
        $data = "'$bike_type_id', '$name', '$description'";

        $conn->query("UPDATE bike_type_table 
        SET name='$name', `description`='$description'
        WHERE bike_type_id=$bike_type_id");

        header("location:BikeTypes.php?update=true");      
   }

   if (isset($_POST['deleteItem']))
   {
       $primaryKey = $_POST['deleteItem'];
   
       $cols = "bike_type_id, name, description";

       $query = "SELECT * FROM bike_type_table WHERE bike_type_id=$primaryKey";

       $result = mysqli_query($conn, $query);
       $fetchData = $result->fetch_array();

       $_SESSION["bike_type_id"] = $fetchData["bike_type_id"];
       $primaryKey = $_SESSION["bike_type_id"];

       header("Location: BikeTypes.php?delete=$primaryKey");
       exit();
   }

   if (isset($_POST["submitDeleteItem"]))
   {
      
       $primaryKey = $_POST["submitDeleteItem"];
       $query = "DELETE FROM bike_type_table WHERE bike_type_id=$primaryKey";
       $results = mysqli_query($conn, $query);
       header("Location: BikeTypes.php?delete=true");
   }

   if (isset($_POST["cancelDeleteItem"]))
   {
    header("Location: BikeTypes.php");
    exit();
   }
        
?>