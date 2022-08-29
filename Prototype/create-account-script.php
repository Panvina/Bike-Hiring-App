//  Resources:
//      https://www.w3schools.com/php/php_form_url_email.asp

<?php
    require "utils.php";

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
            header("Location: login.php?ca=empty");
            exit();
        }
        elseif (!validName($first_name) || !validName($last_name))
        {
            header("Location: login.php?ca=names");
            exit();
        }
        elseif (!validEmail($email) || ($pwd != $pwd_confirm))
        {
            header("Location: login.php?ca=credentials");
            exit();
        }
        elseif (!isset($_POST["ca-privacy-policy"]))
        {
            header("Location: login.php?ca=privacy");
            exit();
        }
        else
        {
            header("Location: login.php?ca=success");
            exit();
        }
    }
    else
    {
        echo "5";
        exit();
    }
?>
