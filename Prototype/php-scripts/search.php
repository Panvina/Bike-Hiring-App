// By Alex
<?php
    //start the session with the database
    session_start();

    if (isset($_POST["search-btn"]))
    {
        $source = $_POST["source"];
        $searchText = $_POST["search-text"];

        if (trim($searchText) != "")
        {
            header("Location: ../$source?search=$searchText");
        }
        else
        {
            header("Location: ../$source");
        }
    }

    exit();
?>
