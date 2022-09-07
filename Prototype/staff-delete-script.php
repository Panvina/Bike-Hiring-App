<!-- All code on this page has been completed by Jake.H 102090870 -->
<?php
    //start the session with the database
    session_start();
    //include database functions
    include_once("php-scripts/backend-connection.php");
    include_once "php-scripts/utils.php";
    //create the connection with the database
    $conn = new DBConnection("employee_table");

    //created a empty array to hold the fetched data
    $fetchData = array();
    //fetch the primary key from the displayed data
    $pk = $_POST['deleteButton'];

    //establish the columns of the database for querying
    $cols = "user_name, name, phone_number, email, address, suburb, post_code, state";
    //establish the where condition for the query
    $condition = "user_name='$pk'";
    //fetch the data and assign it to the array
    $fetchData = $conn->get($cols, $condition);
    $fetchData = $fetchData[0];

    //checks to see if the first button is pressed
    if (isset($_POST['deleteButton']))
    {
        //assigns session variable to the fetched array to be used to transfer data between forms
        $_SESSION["user_name"] = $fetchData["user_name"];
        //create variable for the session variable due to string errors when querying
        $pk = $_SESSION["user_name"];
        //redirects back to the form to double check user wants to delete data
        header("Location: staff.php?delete=$pk");
        exit();
    }

    //checks to see if the yes button in the delete form has been pressed
    if (isset($_POST["submitDeleteStaff"]))
    {
        //gets the primary key that was used in the row
        $pk = $_POST["submitDeleteStaff"];
        //deletes the data from the table and checks to see if it was successful
        if ($conn->delete("user_name", "'$pk'") == true)
        {
            header("Location: staff.php?delete=true");
        }
        else
        {
            header("Location: staff.php?delete=false");
        }
    }

    //If the no button was pressed, redirects back to the customer page
    if (isset($_POST["CancelDeleteStaff"]))
    {
     header("Location: staff.php?");
     exit();
    }
?> 