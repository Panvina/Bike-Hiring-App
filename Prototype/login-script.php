//  Resources:
//      https://www.w3schools.com/php/php_form_url_email.asp
<?php include 'auth-script.php';?>

<?php
    session_start();
    $_SESSION['id'] = '123';

    function validEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    function validName($name)
    {
        return !preg_match("/^[a-zA-Z-' ]*$/",$name);
    }

    if (isset($_POST["login-submit"]))
    {
        // Get variables
        $email = $_POST["login-email"];
        $pwd = $_POST["login-password"];

        $_SESSION["login-email"] = $email;

        // Validate variables
        if (empty($email) || empty($pwd))
        {
            header("Location: login.php?login=empty");
            exit();
        }
        // elseif (!validEmail($email))
        // {
        //     header("Location: login.php?login=email");
        //     exit();
        // }
        else
        {
            $role = authUser($email, $pwd);      
            if($role == "C"){
                header("Location: index.php?Customerlogin=success");
            }else if ($role == "A"){
                header("Location: dashboard.php?Adminlogin=success");
            }else {
                header("Location: index.php?Error=$role");
            }
            exit();
        }
    }
    else
    {
        echo "5";
        exit();
    }
?>
