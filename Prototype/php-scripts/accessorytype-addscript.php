<?php
    /* Code completed by Aadesh Jagannathan - 102072344*/
    session_start();
    include 'backend-connection.php';
    include("inventory-util.php");
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system") or die(mysqli_error($mysqli));

    //temporary session variables are created to retain input data when performing validation checks
    $_SESSION["tempName"] = $_POST["name"];
    $_SESSION["tempDescription"] = $_POST["description"];
    
    //Manually assigning ID for the new record - Only used whilst testing
    $bikeId = $_POST["accessoryId"];

    //temporary variables to print error msg based on form validation
    $validName = "";
    $validDesc = "";
    $emptyForm = "";
    
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

    //Check to identify if the add record button has been set
    if(isset($_POST['AddItem'])){
        /* Form validation for adding records*/
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
        //Check if the name field has the alphabets, integers, _ or -
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
            header("Location: ../AccessoryTypes.php?insert=$emptyForm&name=$validName&desc=$validDesc");           
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