<?php
/* Code completed by Aadesh Jagannathan - 102072344*/
    session_start();
    include_once("backend-connection.php");
    //include ("utils.php");
    include("inventory-util.php");
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

        header("location:../BikeTypes.php?update=notEmpty");
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
        $bike_type_id = $_POST['bikeId'];
        //$name = $_POST["name"];
        //$description = $_POST["description"];


        /* Form validation for adding records*/
        //Check if all fields are empty
        if(empty($_POST["name"]) && empty($_POST["description"]))
        {
            header("Location: ../BikeTypes.php?update=empty");
        }
        //Check if only the name field is empty
        else if (empty($_POST["name"])) 
        {
           header("Location: ../BikeTypes.php?update=emptyName");
        }
        //Check if only the description field is empty
        else if (empty($_POST["description"])) 
        {
           header("Location: ../BikeTypes.php?update=emptyDescription");
        }
        //Check if the name field has only alphabets
        else if (!validName($_POST["name"])) 
        {
            header("Location: ../BikeTypes.php?update=invalidName");
        } 
        else 
        {
            //Cleaning the inputs before assigning to variables 
            $name = test_input($_POST["name"]);
            $description = test_input($_POST["description"]);
        }

        //Final check to ensure variables are not empty
        if(empty($name) && empty($description))
        {
            echo "<p>Failure</p>";
        }
        else
        {

        $cols = "`bike_type_id`, `name`, `description`";
        $data = "'$bike_type_id', '$name', '$description'";

        $conn->query("UPDATE bike_type_table 
        SET name='$name', `description`='$description'
        WHERE bike_type_id=$bike_type_id");

        //Check to see if query has been successful
        if($conn = true)
        {
        header("location:../BikeTypes.php?update=true");    
        }
        else
        {
        header("location:../BikeTypes.php?update=false");   
        }
        }
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

       header("Location: ../BikeTypes.php?delete=$primaryKey");
       exit();
   }

   if (isset($_POST["submitDeleteItem"]))
   {
      
       $primaryKey = $_POST["submitDeleteItem"];
       $query = "DELETE FROM bike_type_table WHERE bike_type_id=$primaryKey";
       $results = mysqli_query($conn, $query);
       header("Location: ../BikeTypes.php?delete=true");
   }

   if (isset($_POST["cancelDeleteItem"]))
   {
    header("Location: ../BikeTypes.php");
    exit();
   }
        
?>