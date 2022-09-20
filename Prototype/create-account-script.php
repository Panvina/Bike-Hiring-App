<?php
    require "php-scripts/utils.php";
    include_once 'php-scripts/backend-connection.php';
    include_once 'person-dto.php';

    session_start();
    $_SESSION['id'] = '123';

    if (isset($_POST["ca-submit"]))
    {
        // Get variables
        $first_name = $_POST["ca-first-name"];
        $last_name = $_POST["ca-last-name"];
        $email = $_POST["ca-email"];
        $pwd = $_POST["ca-password"];
        $pwd_confirm = $_POST["ca-password-confirm"];

        $_SESSION["ca-first-name"] = $first_name;
        $_SESSION["ca-last-name"] = $last_name;
        $_SESSION["ca-email"] = $email;

        // Validate variables
        if (empty($first_name) || empty($last_name) || empty($email) || empty($pwd) || empty($pwd_confirm))
        {
            header("Location: index.php?ca=empty");
            exit();
        }
        elseif (!validName($first_name) || !validName($last_name))
        {
            header("Location: index.php?ca=names");
            exit();
        }
        elseif (($pwd != $pwd_confirm))
        {
            header("Location: index.php?ca=pwdsnomatch");
            exit();
        }elseif(!validEmail($email)){
            header("Location: index.php?ca=email");
            exit();
        }
        // elseif (!isset($_POST["ca-privacy-policy"]))
        // {
        //     header("Location: index.php?ca=privacy");
        //     exit();
        // }
        else
        {
             /* Inserting data into the customer table and the accounts table
                Vina Touch */
                $cus_conn = new DBConnection("customer_table");
                $acc_conn = new DBConnection("accounts_table");       
                $empty="null";
                $email = strtolower($email);
                $searchExistingUser = new PersonDTO($email);
                $searchExistingUser->getDetails();
                $full_name= $first_name . " " .$last_name;
                $cols = "user_name, name, phone_number, email, street_address, suburb, post_code, licence_number, state";
                $customer_data = "'$email','$full_name', '$empty', '$email', '$empty', '$empty', '$empty', '$empty', '$empty'";
    
                $hashed_pwd = password_hash($pwd, PASSWORD_DEFAULT);
                $acc_cols= "user_name, role_id, password";
                $account_data= "'$email', 3, '$hashed_pwd'";
                if ($searchExistingUser->getUsername() == null){
                    $cus_conn->insert($cols ,  $customer_data);
                    $acc_conn->insert($acc_cols, $account_data);
                    $_SESSION["user-details"] = "no";
                    header("Location: index.php?login=success");
                    exit();
                }else{
                    header("Location: index.php?ca=existinguser");
                    exit();
                }
                
        }
    }
    else
    {
        echo "5";
        exit();
    }
?>
