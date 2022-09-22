<?php
    if (!isset($_SESSION)){
        session_start();
    }
    if(isset($_POST['logout'])==true){
        $_SESSION = array();
        session_destroy();
        header("location: index.php");
        exit;
    }

    function setOwnerDashboardPrivilege($staffActiveClass="", $accountActiveClass=""){
        if($_SESSION["login-type"] == "owner"){
            echo "<a class='$staffActiveClass' href='staff.php'> <img src='img/icons/staff.png' alt='Staff Logo' /> Staff </a> <br>";
            echo "<a class='$accountActiveClass' href='accounts.php'> <img src='img/icons/account.png' alt='Account logo'/> Accounts </a> <br>";
        }else if(!isset($_SESSION["login-type"]) || $_SESSION["login-type"] == "customer"){
            header("location: index.php?Error403:AccessDenied");
            exit;
        }
    }

    function setLogoutButton()
    {
        echo "<form action='user-privilege.php' method='post'>
        <input type='hidden' name='logout' value='logout'>
        <img src= 'img/icons/logout.png' alt='Log Out Logo' /><button class='logout' type='submit'>Logout</button>
        </form>";
    }
?>

<html>
    <style>
        .logout {
            background-color: #172026; /* Green */
            border: none;
            color: white;
            padding: 5px 26px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            margin-left: 10px;
            margin-top: 2px;
            font-size: 1.2vmax;
        }
        .logout:hover{
            background-color: #00b7b1;
        }
    </style>
</html>
