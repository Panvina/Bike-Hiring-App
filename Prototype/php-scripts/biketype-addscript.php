<?php
/* Code completed by Aadesh Jagannathan - 102072344*/
    session_start();
    include 'backend-connection.php';
    include("inventory-util.php");
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system") or die(mysqli_error($mysqli));

    //temporary session variables are created to retain input data when performing validation checks
    $_SESSION["tempName"] = $_POST["name"];
    $_SESSION["tempPictureId"] = $_POST["pictureId"];
    $_SESSION["tempDescription"] = $_POST["description"];

    //Manually assigning ID for the new record - Only used whilst testing
    $bikeId = $_POST["bikeId"];
    //Setting picture Id when adding record
    $pictureId = $_POST["pictureId"];

    //temporary variables to print error msg based on form validation
    $validName = "";
    $validDesc = "";
    $emptyPicId = "";
    $emptyForm = "";
    
    //Search concept adapted from Alex
    if (isset($_POST['search-btn'])){
        $search = $_POST["search"];

        if (trim($search) != "")
        {
            header("Location: ..\BikeTypes.php?search=$search");
        }
        else
        {
            header("Location: ..\BikeTypes.php");
        }
    } 
    if(isset($_POST['AddItem'])){
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
            header("Location: ../BikeTypes.php?insert=$emptyForm&name=$validName&picId=$emptyPicId&desc=$validDesc");           
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
        $data = "'$bikeId', '$name', '$pictureId', '$description'";
        
        $query = "INSERT INTO `bike_type_table` ($cols) VALUES ($data)";
        $results = mysqli_query($conn,$query);
        
        //unset all the temporary data stored during form validation
        unset($_SESSION["tempName"]);
        unset($_SESSION["tempPictureId"]);
        unset($_SESSION["tempDescription"]);

        //Check to see if query has been successful
        if($results = true)
        {
            header("Location: ../BikeTypes.php?insert=true");
            exit();
        }
        else
        {
            header("Location: ../BikeTypes.php?insert=false");
            exit();
        }
   
        mysqli_close($conn);
    }
}

?>