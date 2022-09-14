<!-- All code on this page has been completed by Jake.H 102090870 -->
<?php
    //start the session with the database
    session_start();
    //include database functions
    include_once("backend-connection.php");
    include_once "utils.php";
    //create the connection with the database
    $conn = new DBConnection("accounts_table");

    //created a empty array to hold the fetched data
    $fetchData = array();
    //fetch the primary key from the displayed data
    $pk = $_POST['deleteButton'];

    //establish the columns of the database for querying
    $cols = "user_name, role_id, password";
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
        header("Location: ../accounts.php?delete=$pk");
        exit();
    }

    //checks to see if the yes button in the delete form has been pressed
    if (isset($_POST["submitDeleteAccount"]))
    {
        //gets the primary key from the row selected
        $pk = $_POST["submitDeleteAccount"];

        $typeOfUser = substr($pk,0,2);

        //creates the query to delete the same row in the account table
        $accountQuery = "DELETE FROM accounts_table WHERE user_name = '$pk'";
        $employeeQuery = "DELETE FROM employee_table WHERE user_name = '$pk'";
        $customerQuery = "DELETE FROM customer_table WHERE user_name = '$pk'";
    

        //starts the transaction for the query for database security
        $conn->runQuery("START TRANSACTION;");

        if ($typeOfUser == "CU")
        {
            if ($conn->runQuery($customerQuery) == false)
            {
                header("Location: ../accounts.php?delete=false");
                exit();
            }
        }

        if ($typeOfUser == "EM")
        {
            if ($conn->runQuery($employeeQuery) == false)
            {
                header("Location: ../accounts.php?delete=false");
                exit();
            }
        }

        if ($conn->runQuery($accountQuery) == false)
        {
            header("Location: ../accounts.php?delete=false");
            exit();
        }
        
        // commit changes to database
        $conn->runQuery("COMMIT;");
        header("Location: ../accounts.php?delete=true");
        exit();
    
        //header("Location: ../accounts.php?delete=true");
        // //deletes the employee from the employee table
        // if ($conn->delete("user_name", "'$pk'") == false)
        // {
        //     header("Location: ../staff.php?delete=false");
        // }
        // //deletes the employee from the accounts table
        // else if ($conn->runQuery($accountQuery) == false)
        // {
        //    header("Location: ../staff.php?delete=false");
        //     exit();
        // }
        // //goes back to the employee page with a error
        // else
        // {
        //     // commit changes to database
        //     $conn->runQuery("COMMIT;");
        //     header("Location: ../staff.php?delete=true");
        //     exit();
        // }          
    }

    //If the no button was pressed, redirects back to the account page
    if (isset($_POST["CancelDeleteAccount"]))
    {
        header("Location: ../accounts.php?");
        exit();
    }
?> 