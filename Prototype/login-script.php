<!-- This file is set up by Alex, futher developed by Vina Touch !--> 
<?php
    session_start();
    include 'person-dto.php';
    ?>
    
<?php
    $_SESSION['id'] = '123';
    if (isset($_POST["login-submit"]))
    {
        // Get variables
        $email = $_POST["login-email"];
        $pwd = $_POST["login-password"];

        $_SESSION["login-email"] = $email;

        // Validate variables
        if (empty($email) || empty($pwd))
        {
            header("Location: index.php?login=empty");
            exit();
        }

        else
        {
            $newUser = new PersonDTO($email);
            $role = $newUser->authenticateUser($pwd);  
            $newUser->getDetails();
            $license = $newUser->getLicence();  
            if($role == "3"){
                $_SESSION['login-type'] = 'customer';
                if ($license == "null"){
                    $_SESSION["user-details"] = "no";
                    $_SESSION['cusID'] = $email;
                    header("Location: no-user-details.php");
                    exit();
                }else{
                    $_SESSION["user-details"] = "yes";
                    header("Location: booking-summary.php?Customerlogin=$email");
                    exit();
                }  
            }else if ($role == "2"){
                $_SESSION['login-type'] = 'employee';
                header("Location: dashboard.php?Adminlogin=success");
                exit();
            }else if ($role == "1") {
                $_SESSION['login-type'] = 'owner';
                header("Location: dashboard.php?masterlogin=success");
                exit();
            }else{header("Location: index.php?login=userNotFound");
            }
        }
    }
    else
    {
        echo "5";
        exit();
    }
?>
