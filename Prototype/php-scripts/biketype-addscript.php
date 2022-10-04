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


    $bikeId = $_POST["bikeId"];
    $pictureId = $_POST["pictureId"];
    //$name = $_POST["name"];
    //$description = $_POST["description"];

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
            header("Location: ../BikeTypes.php?insert=empty");
        }
        //Check if only the name field is empty
        else if (empty($_POST["name"])) 
        {
           header("Location: ../BikeTypes.php?insert=emptyName");
        }
        //Check if only the picture id field is empty
        else if (empty($_POST["pictureId"])) 
        {
           header("Location: ../BikeTypes.php?insert=emptyPictureId");
        }
        //Check if only the description field is empty
        else if (empty($_POST["description"])) 
        {
           header("Location: ../BikeTypes.php?insert=emptyDescription");
        }
        //Check if the name field has only alphabets
        else if (!validName($_POST["name"])) 
        {
            header("Location: ../BikeTypes.php?insert=invalidName");
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