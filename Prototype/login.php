// Example modified from
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            body, p
            {
                font-family: "Times New Roman", Helvetica, sans-serif;
            }

            .modal-overlay
            {
                display: none; /* Hidden by default */
                position: fixed; /* Stay in place */
                z-index: 1; /* Sit on top */
                padding-top: 100px; /* Location of the box */
                left: 0;
                top: 0;
                width: 100%; /* Full width */
                height: 100%; /* Full height */
                overflow: auto; /* Enable scroll if needed */
                background-color: rgb(0,0,0); /* Fallback color */
                background-color: rgba(0,0,0,0.6); /* Black w/ opacity */
            }

            .modal-content
            {
                /* background-color: #fefefe; */
                background-image:
                linear-gradient(to bottom, rgba(255,255,255,0.44), rgba(255,255,255,0.44)),
                url('img/backgrounds/login-background.jpg');
                background-size: cover;
                margin: auto;
                padding: 20px;
                border: 1px solid #888;
                width: 500px;
            }

            .close-btn
            {
                color: #aaaaaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
            }

            .close-btn:hover, .close-btn:focus
            {
                color: #000;
                text-decoration: none;
                cursor: pointer;
            }

            .centre-text
            {
                text-align: center;
            }

            .centre-element
            {
                position: relative;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%);
            }

            .decorated-lines
            {
                position: relative;
                z-index: 1;
                overflow: hidden;
                text-align: center;
            }

            .decorated-lines:before, .decorated-lines:after {
                position: absolute;
                top: 51%;
                overflow: hidden;
                width: 50%;
                height: 1px;
                content: '\a0';
                background-color: black;
            }

            .decorated-lines:before
            {
                margin-left: -50%;
            }

            .no-text-decoration
            {
                text-decoration: none;
            }

            .no-vertical-margins
            {
                margin-top: 0px;
            }

            .no-vertical-padding
            {
                padding-top: 0px;
                padding-bottom: 0px;
            }

            input, button
            {
                font-size: 20px;
            }

            input::placeholder
            {
                text-align: center;
            }

            .input-window-format
            {
                width: 75%;
                height: 40px;
                border: none;
            }

            .modal-content-header
            {
                font-size: 30px;
            }

            .modal-btn
            {
                width: 60%;
                height: 35px;
                border: none;
                display: inline-block;
            }

            .login-btn
            {
                background-color: #172026;
                color: white;
            }

            .create-account-option-btn
            {
                background-color: #eaf7f6;
                color: #172026;
            }

            .error
            {
                color: red;
                position: relative;
                transform: translate(12%, -15%);
            }

        </style>
    </head>
    <body>
        <h2>Modal Example</h2>

        <!-- Trigger/Open The Modal -->
        <button id="login-launch-btn">Login</button>
        <br/>
        <button style="margin-top: 10px;" id="create-account-launch-btn">Create Account</button>

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
                        elseif ($loginVar == "success")
                        {
                            echo '<p class="error">Login success</p>';
                        }
                    }
                ?>
                <form action="login-script.php" method="post">
                    <input
                        name="email"
                        class="centre-element input-window-format"
                        type="text"
                        placeholder="EMAIL ADDRESS"
                        style="margin-bottom: 7px;"
                        <?php
                            if (isset($_GET["email"]))
                            {
                                $email = $_GET["email"];
                                echo "value=$email";
                            }
                        ?>
                    />
                    <br>
                    <input
                        name="password"
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
                <form action="create-account.php" method="post">
                    <input
                        class="centre-element input-window-format"
                        type="text"
                        placeholder="FIRST NAME"
                        style="margin-bottom: 7px;"
                    />
                    <br>
                    <input
                        class="centre-element input-window-format"
                        type="text"
                        placeholder="LAST NAME"
                        style="margin-bottom: 7px;"
                    />
                    <br>
                    <input
                        class="centre-element input-window-format"
                        type="text"
                        placeholder="EMAIL ADDRESS"
                        style="margin-bottom: 7px;"
                    />
                    <br>
                    <input
                        class="centre-element input-window-format"
                        type="password"
                        placeholder="PASSWORD"
                        style="margin-bottom: 7px;"
                    />
                    <br>
                    <input
                        class="centre-element input-window-format"
                        type="password"
                        placeholder="CONFIRM PASSWORD"
                        style="margin-bottom: 0px;"
                    />
                    <br>
                    <label for="privacy-policy-checkbox" style="position: relative; left: 12%;">
                        <input type="checkbox"/> I agree to the <a href="https://www.blank.org">privacy policy</a>
                    </label>
                    <br>
                    <input type="submit" name="create-account-submit" class="centre-element modal-btn login-btn" style="position: relative; transform: translate(-50%, 15px)" value="LOGIN">
                </form>
            </div>
        </div>

        <script>
            // Get modals
            var login_modal = document.getElementById("login-overlay");
            var create_account_modal = document.getElementById("create-account-overlay");

            // Get popup buttons
            var login_popup_button = document.getElementById("login-launch-btn");
            var create_account_popup_button = document.getElementById("create-account-launch-btn");

            var login_create_account_button = document.getElementById("login-create-account-btn");

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close-btn");

            // When the user clicks the button, open the modal
            login_popup_button.onclick = function()
            {
                login_modal.style.display = "block";
            }

            create_account_popup_button.onclick = function()
            {
                create_account_modal.style.display = "block";
            }

            login_create_account_button.onclick = function()
            {
                login_modal.style.display = "none";
                create_account_modal.style.display = "block";
            }

            for (let i = 0; i < span.length; i++)
            {
                // When the user clicks on <span> (x), close the modal
                span[i].onclick = function()
                {
                    login_modal.style.display = "none";
                    create_account_modal.style.display = "none";
                }
            }

            <?php
                if (isset($_GET["login"]))
                {
                    echo 'login_modal.style.display = "block";';
                }
            ?>
        </script>
    </body>
</html>
