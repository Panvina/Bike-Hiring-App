<?php
    /* Code completed by Aadesh Jagannathan - 102072344*/
    session_start();
    include 'backend-connection.php';
    include("inventory-util.php");
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system") or die(mysqli_error($mysqli));

    //temporary session variables are created to retain input data when performing validation checks
    $_SESSION["tempName"] = $_POST["name"];
    $_SESSION["tempDescription"] = $_POST["description"];
    
    $bikeId = $_POST["accessoryId"];
    //$name = $_POST["name"];
    //$description = $_POST["description"];

    //Search concept adapted from Alex
    if (isset($_POST['search-btn'])){
        $search = $_POST["search"];

        if (trim($search) != "")
        {
            header("Location: ..\AccessoryTypes.php?search=$search");
        }
        else
        {
            header("Location: ..\AccessoryTypes.php");
        }
    } 
    if(isset($_POST['AddItem'])){
        /* Form validation for adding records*/
        //Check if all fields are empty
        if(empty($_POST["name"]) && empty($_POST["description"]))
        {
            header("Location: ../AccessoryTypes.php?insert=empty");
        }
        //Check if only the name field is empty
        else if (empty($_POST["name"])) 
        {
           header("Location: ../AccessoryTypes.php?insert=emptyName");
        }
        //Check if only the description field is empty
        else if (empty($_POST["description"])) 
        {
           header("Location: ../AccessoryTypes.php?insert=emptyDescription");
        }
        //Check if the name field has only alphabets
        else if (!validName($_POST["name"])) 
        {
            header("Location: ../AccessoryTypes.php?insert=invalidName");
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
        $cols = "`accessory_type_id`, `name`, `description`";
        $data = "'$bikeId', '$name', '$description'";
        
        $query = "INSERT INTO `accessory_type_table` ($cols) VALUES ($data)";
        $results = mysqli_query($conn,$query);

        //unset all the temporary data stored during form validation
        unset($_SESSION["tempName"]);
        unset($_SESSION["tempDescription"]);
        
        if($results = true)
        {
            header("Location: ../AccessoryTypes.php?insert=true");
            exit();
        }
        else
        {
            header("Location: ../AccessoryTypes.php?insert=false");
            exit();
        }
    
        mysqli_close($conn);
    }
}

?>