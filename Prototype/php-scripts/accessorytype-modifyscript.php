<?php
/* Code completed by Aadesh Jagannathan - 102072344*/
    session_start();
    include_once("backend-connection.php");
    include("inventory-util.php");
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system") or die(mysqli_error($mysqli));

    //temporary variables to print error msg based on form validation
    $validName = "";
    $validDesc = "";
    $emptyForm = "";

    //Check to identify if the update record button has been set
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

        header("location:../AccessoryTypes.php?update=notEmpty");
    }
   
   //Check to identify if the submit button in the update form has been set
   if (isset($_POST["submitUpdateItem"]))
   {
        //Manually assigning ID for the new record - Only used whilst testing
        $accessory_type_id = $_POST['accessoryId'];

        //Check if all fields are empty
        if(empty($_POST["name"]) && empty($_POST["description"]))
        {
            $emptyForm = "empty";
        }

        //Check if only the name field is empty
        if (empty($_POST["name"])) 
        {
            $validName = "empty";
        }
        //Check if the name field has alphabets, integers, _ or -
        else if (!validName($_POST["name"])) 
        {
            $validName = "invalid";
        } 

        //Check if only the description field is empty
        if (empty($_POST["description"])) 
        {
           $validDesc = "empty";
        }
        
        //Check to determine if any validation flags have been set
        if((!empty($validName)) || (!empty($validDesc)) || (!empty($emptyForm)))
        {
            header("Location: ../AccessoryTypes.php?update=$emptyForm&name=$validName&desc=$validDesc");           
        }
        //Setting variables if validation has passed
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
        $cols = "`accessory_type_id`, `name`, `description`";
        $data = "'$accessory_type_id', '$name', '$description'";

        $conn->query("UPDATE accessory_type_table 
        SET name='$name', `description`='$description'
        WHERE accessory_type_id=$accessory_type_id");

        //Check to see if query has been successful
        if($conn = true)
        {
        header("location:../AccessoryTypes.php?update=true");  
        }
        else
        {
        header("location:../BikeTypes.php?update=false");   
        }  
        }  
   }

   // Check to retreive record ID when delete record button has been clicked
   if (isset($_POST['deleteItem']))
   {
       $primaryKey = $_POST['deleteItem'];
   
       $cols = "accessory_type_id, name, description";

       $query = "SELECT * FROM accessory_type_table WHERE accessory_type_id=$primaryKey";

       $result = mysqli_query($conn, $query);
       $fetchData = $result->fetch_array();

       $_SESSION["accessory_type_id"] = $fetchData["accessory_type_id"];
       $primaryKey = $_SESSION["accessory_type_id"];

       header("Location: ../AccessoryTypes.php?delete=$primaryKey");
       exit();
   }

   // Check to delete item if the yes button has been clicked
   if (isset($_POST["submitDeleteItem"]))
   {
      
       $primaryKey = $_POST["submitDeleteItem"];
       $query = "DELETE FROM accessory_type_table WHERE accessory_type_id=$primaryKey";
       $results = mysqli_query($conn, $query);

       if(mysqli_affected_rows($conn) == 1)
        {
            header("Location: ../AccessoryTypes.php?delete=true");
            exit();

        }
        else
        {
            header("Location: ../AccessoryTypes.php?delete=false");
            exit();
        }
       
   }

   // Check to delete item if the no button has been clicked
   if (isset($_POST["cancelDeleteItem"]))
   {
    header("Location: ../AccessoryTypes.php?delete=false");
    exit();
   }
        
?>