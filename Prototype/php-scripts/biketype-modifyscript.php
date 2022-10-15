<?php
/* Code completed by Aadesh Jagannathan - 102072344*/
    session_start();
    include_once("backend-connection.php");
    //include ("utils.php");
    include("inventory-util.php");
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system") or die(mysqli_error($mysqli));

    //temporary variables to print error msg based on form validation
    $validName = "";
    $validDesc = "";
    $emptyPicId = "";
    $emptyForm = "";

    //Check to identify if the update record button has been set
    if (isset($_POST['updateItem']))
    {
        $primaryKey = $_POST['updateItem'];
    
        $cols = "bike_type_id, name, picture_id, description";

        $query = "SELECT * FROM bike_type_table WHERE bike_type_id=$primaryKey";

        $result = mysqli_query($conn, $query);
        $fetchData = $result->fetch_array();


        $_SESSION["bike_type_id"] = $fetchData["bike_type_id"];
        $_SESSION["name"] = $fetchData["name"];
        $_SESSION["pictureId"] = $fetchData["picture_id"];
        $_SESSION["description"] = $fetchData["description"];
        

        $name = $_SESSION['name'];
        $pictureId = $_SESSION["pictureId"];
        $description = $_SESSION['description'];
        
        header("location:../BikeTypes.php?update=notEmpty");
   }
   
   //Check to identify if the submit button in the update form has been set
   if (isset($_POST["submitUpdateItem"]))
   {
        //Manually assigning ID for the new record - Only used whilst testing
        $bike_type_id = $_POST['bikeId'];
        //Setting picture Id when updating record
        $pictureId = $_POST['pictureId'];


        /* Form validation for adding records*/
        //Check if all fields are empty
        if(empty($_POST["name"]) && empty($_POST["description"]) && empty($_POST["pictureId"]))
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

        //Check if only the picture id field is empty
        if (empty($_POST["pictureId"])) 
        {
            $emptyPicId = "empty";
        }

        //Check if only the description field is empty
        if (empty($_POST["description"])) 
        {
           $validDesc = "empty";
        }
        
        //Check to determine if any validation flags have been set
        if((!empty($validName)) || (!empty($validDesc)) || (!empty($emptyPicId)) || (!empty($emptyForm)))
        {
            header("Location: ../BikeTypes.php?update=$emptyForm&name=$validName&picId=$emptyPicId&desc=$validDesc");           
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
            $cols = "`bike_type_id`, `name`, `picture_id`, `description`";
            $data = "'$bike_type_id', '$name', '$pictureId', '$description'";

            $conn->query("UPDATE bike_type_table 
            SET name='$name', picture_id='$pictureId', `description`='$description' 
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

   // Check to retreive record ID when delete record button has been clicked
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

   // Check to delete item if the yes button has been clicked
   if (isset($_POST["submitDeleteItem"]))
   {
      
       $primaryKey = $_POST["submitDeleteItem"];
       $query = "DELETE FROM bike_type_table WHERE bike_type_id=$primaryKey";
       $results = mysqli_query($conn, $query);

       if(mysqli_affected_rows($conn) == 1)
        {
            header("Location: ../BikeTypes.php?delete=true");
            exit();

        }
        else
        {
            header("Location: ../BikeTypes.php?delete=false");
            exit();
        }
   }

   // Check to delete item if the yes button has been clicked
   if (isset($_POST["cancelDeleteItem"]))
   {
        header("Location: ../BikeTypes.php");
        exit();
   }
        
?>