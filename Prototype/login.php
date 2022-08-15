<?php
    session_start();
    $_SESSION['id'] = '123';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style/style.css">
    </head>
    <body>
        <!-- Trigger/Open The Modal -->
        <button id="login-launch-btn">Account</button>
        <!--<br/>
        <button style="margin-top: 10px;" id="create-account-launch-btn">Create Account</button>-->

        <!-- Login Popup -->
        <div id="login-overlay" class="modal-overlay">
            <!-- Login Popup Content -->
            <div class="modal-content">
                <span class="close-btn">&times;</span>
                <p class="centre-text modal-content-header">SIGN IN</p>
                <?php
                    if (isset($_GET["login"]))
                    {
                        $loginVar = $_GET["login"];

                        if ($loginVar == "empty")
                        {
                            echo '<p class="error">Empty inputs</p>';
                        }
                        elseif ($loginVar == "email")
                        {
                            echo '<p class="error">Invalid email</p>';
                        }
                    }
                ?>
                <form action="login-script.php" method="POST">
                    <input
                        name="login-email"
                        class="centre-element input-window-format"
                        type="text"
                        placeholder="EMAIL ADDRESS"
                        style="margin-bottom: 7px;"
                        <?php
                            if (isset($_SESSION["login-email"]))
                            {
                                $email = $_SESSION["login-email"];
                                echo "value='$email'";
                            }
                        ?>
                    />
                    <br>
                    <input
                        name="login-password"
                        class="centre-element input-window-format"
                        type="password"
                        placeholder="PASSWORD"
                    />
                    <p style="margin-top: 0px; transform: translate(0, -15px);" class="centre-text"><a href="https://blank.org" class="no-text-decoration">Forgot Password</a></p>
                    <button type="submit" name="login-submit" class="centre-element modal-btn login-btn">LOGIN</button>
                </form>
                <p class="decorated-lines no-vertical-margins" style="transform: translate(0, -10px);">OR</p>
                <button id="login-create-account-btn" style="margin-top: 15px;" class="centre-element modal-btn create-account-option-btn">CREATE AN ACCOUNT</button>
            </div>
        </div>

        <!-- Create Account Popup -->
        <div id="create-account-overlay" class="modal-overlay">
            <!-- Create Account Popup Content -->
            <div class="modal-content">
                <span class="close-btn">&times;</span>
                <p class="centre-text modal-content-header">CREATE AN ACCOUNT</p>
                <form action="create-account-script.php" method="post">
                    <input
                        name="ca-first-name"
                        class="centre-element input-window-format"
                        type="text"
                        placeholder="FIRST NAME"
                        style="margin-bottom: 7px;"
                        <?php
                        if (isset($_SESSION["ca-first-name"]))
                        {
                            $first_name = $_SESSION["ca-first-name"];
                            echo "value='$first_name'";
                        }
                        ?>
                    />
                    <br>
                    <input
                        name="ca-last-name"
                        class="centre-element input-window-format"
                        type="text"
                        placeholder="LAST NAME"
                        style="margin-bottom: 7px;"
                        <?php
                        if (isset($_SESSION["ca-last-name"]))
                        {
                            $last_name = $_SESSION["ca-last-name"];
                            echo "value='$last_name'";
                        }
                        ?>
                    />
                    <br>
                    <input
                        name="ca-email"
                        class="centre-element input-window-format"
                        type="text"
                        placeholder="EMAIL ADDRESS"
                        style="margin-bottom: 7px;"
                        <?php
                        if (isset($_SESSION["ca-email"]))
                        {
                            $email = $_SESSION["ca-email"];
                            echo "value='$email'";
                        }
                        ?>
                    />
                    <br>
                    <input
                        name="ca-password"
                        class="centre-element input-window-format"
                        type="password"
                        placeholder="PASSWORD"
                        style="margin-bottom: 7px;"
                    />
                    <br>
                    <input
                        name="ca-password-confirm"
                        class="centre-element input-window-format"
                        type="password"
                        placeholder="CONFIRM PASSWORD"
                        style="margin-bottom: 0px;"
                    />
                    <br>
                    <label for="privacy-policy-checkbox" style="position: relative; left: 12%;">
                        <input name="ca-privacy-policy" type="checkbox"/> I agree to the <a href="https://www.blank.org">privacy policy</a>
                    </label>
                    <br>
                    <button type="submit" name="ca-submit" class="centre-element modal-btn login-btn" style="position: relative; transform: translate(-50%, 15px)">LOGIN</button>
                </form>
            </div>
        </div>
        <script src="scripts/login-js.php"></script>
        <scrip t>
            <?php
                if (isset($_GET["login"]))
                {
                    $loginVar = $_GET["login"];

                    if ($loginVar != "success")
                    {
                        echo 'var login_modal = document.getElementById("login-overlay");';
                        echo 'login_modal.style.display = "block";';
                    }
                }
                elseif (isset($_GET["ca"]))
                {
                    $caVar = $_GET["ca"];

                    if ($caVar != "success")
                    {
                        echo 'var create_account_modal = document.getElementById("create-account-overlay");';
                        echo 'create_account_modal.style.display = "block";';
                    }
                }
            ?>
        </script>
    </body>
</html>
