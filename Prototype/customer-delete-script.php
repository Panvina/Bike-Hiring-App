<!-- All code on this page has been completed by Jake.H 102090870 -->
<?php
    //start the session with the database
    session_start();
    //include database functions
    include_once("php-scripts/backend-connection.php");
    include "php-scripts\customer-db.php";
    include_once "php-scripts/utils.php";
    //create the connection with the database
    $conn = new DBConnection("customer_table");

    //created a empty array to hold the fetched data
    $fetchData = array();
    //fetch the primary key from the displayed data
    $pk = $_POST['deleteButton'];

    //establish the columns of the database for querying
    $cols = "user_name, name, phone_number, email, street_address, suburb, post_code, licence_number, state";
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
        header("Location: Customer.php?delete=$pk");
        exit();
    }

    //checks to see if the yes button in the delete form has been pressed
    if (isset($_POST["submitDeleteCustomer"]))
    {

        //gets the primary key from the row selected
        $pk = $_POST["submitDeleteCustomer"];
        //creates the query to delete the same row in the account table
        $accountQuery = "DELETE FROM accounts_table WHERE user_name = '$pk'";
    
        //starts the transaction for the query for database security
        $conn->runQuery("START TRANSACTION;");

        //deletes the customer from the customer table
        if ($conn->delete("user_name", "'$pk'") == false)
        {
            header("Location: Customer.php?delete=false");
        }
        //deletes the customer from the accounts table
        else if ($conn->runQuery($accountQuery) == false)
        {
           header("Location: Customer.php?delete=false");
            exit();
        }
        //goes back to the customer page with a error
        else
        {
            // commit changes to database
            $conn->runQuery("COMMIT;");
            header("Location: Customer.php?delete=true");
            exit();
        }          

    }

    //If the no button was pressed, redirects back to the customer page
    if (isset($_POST["CancelDeleteCustomer"]))
    {
     header("Location: Customer.php?");
     exit();
    }
?> 