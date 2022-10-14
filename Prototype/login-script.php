<!------------------------------------------------------------------------------------------
File Description: Processing whether the user is authorised to access the system given their login details and their account privilege.
Contributor(s): Vina Touch 101928802
--------------------------------------------------------------------------------->
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
            $newUser = new PersonDTO($email);       //add initialise a new user
            $role = $newUser->authenticateUser($pwd);       //retrieve the role of that user
            $newUser->getDetails();     //retrieve the user details based on the login they entered
            $license = $newUser->getLicence();      //retrieve the licence from the user object  
            if($role == "3"){       //if the role of the user is 3 - it means they are a customer trying to log in
                $_SESSION['login-type'] = 'customer';      //assign the login-type session as a customer 
                if ($license == "null"){            //if the details of the user are missing in the database, redirect them to another page to fill those missing info
                    $_SESSION["user-details"] = "no";       //mark the user as 'missing information', permitting them from accessing the booking summary page.
                    $_SESSION['cusID'] = $email;
                    header("Location: no-user-details.php");
                    exit();
                }else{      //if the user's details are not missing in the database, redirect them to the booking-summary
                    $_SESSION["user-details"] = "yes";
                    header("Location: booking-summary.php?Customerlogin=$email");
                    exit();
                }  
            }else if ($role == "2"){        //if the role of the user is 2 - it means they are an employee trying to log in.
                $_SESSION['login-type'] = 'employee';  
                header("Location: dashboard.php?Adminlogin=success");       //redirect them to the dashboard/backend system
                exit();
            }else if ($role == "1") {   //if the role of the user is 2 - it means they are the owner/master of the system trying to log in.
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
