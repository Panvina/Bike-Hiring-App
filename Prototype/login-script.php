//  Resources:
//      https://www.w3schools.com/php/php_form_url_email.asp

<?php
    function validEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    function validName($name)
    {
        return !preg_match("/^[a-zA-Z-' ]*$/",$name);
    }

    function checkEmpty($arr)
    {
        $ret = true;

        if (is_array($arr))
        {
            for($x = 0; $x < count($arr) || $ret; $x++)
            {
                $ret &= empty($arr[$x]);
            }
        }
        else
        {
            $ret = empty($arr);
        }

        return $ret;
    }

    echo '<p>test</p>';

    if (isset($_POST["login-submit"]))
    {
         echo "3";
        // Get variables
        $email = $_POST["email"];
        $pwd = $_POST["password"];

        // Validate variables
        if (checkEmpty([$email, $pwd]))
        {
            header("Location: login.php?login=empty&email=$email");
            exit();
        }
        elseif (!validEmail($email))
        {
            header("Location: login.php?login=email&email=$email");
            exit();
        }
        else
        {
            header("Location: login.php?login=success&email=$email");
            exit();
        }
    }
    else
    {
        echo "5";
        exit();
    }
?>
