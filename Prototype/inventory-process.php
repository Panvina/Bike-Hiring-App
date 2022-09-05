<?php
session_start();
include 'backend-connection.php';
$conn = new mysqli("localhost", "root", "", "bike_hiring_system") or die(mysqli_error($mysqli));


$bikeId = 0;
$name = "";
$bikeTypeId = "";
$helmetId = "";
$price = "";
$safetyInspect = "";
$description = "";

if (isset($_POST['save'])) {
    $bikeID = $_POST['bike_id'];
    $name = $_POST['name'];
    $bikeTypeId = $_POST['bikeTypeId'];
    $helmetId = $_POST['helmetId'];
    $price = $_POST['price'];
    $safetyInspect = $_POST['safetyInspect'];
    $description = $_POST['description'];

    $cols = "`BikeID`, `Name`, `BikeTypeID`, `HelmetID`, `Price p/h`, `Safety Inspect`, `Description`";
    $data = "'$bikeId', '$name', '$bikeTypeId', '$helmetId', '$price', '$safetyInspect', '$description'";

    $result = $conn->query("INSERT INTO bike_inventory_table ($cols) VALUES ($data)");
}

if (isset($_GET['delete'])) {
    $bikeId = $_GET["delete"];
    $query = "DELETE FROM bike_inventory_table WHERE bike_id=$bikeId";
    $results = mysqli_query($conn, $query);

    $_SESSION['message'] = "Record has been deleted!";
    $_SESSION['msg_type'] = "Success!";

    header("location: Inventory.php");
}

if (isset($_GET['update'])) {
    $bikeId = $_GET["update"];
    $result = $conn->query("SELECT * FROM bike_inventory_table WHERE BikeID=$bikeId");
    if ($result->num_rows) {
        $row = $result->fetch_array();
        $bikeId = $row['BikeID'];
        $name = $row['Name'];
        $bikeTypeId = $row['BikeTypeID'];
        $helmetId = $row['HelmetID'];
        $price = $row['Price p/h'];
        $safetyInspect = $row['Safety Inspect'];
        $description = $row['Description'];
    }
}

if (isset($_POST['modify'])) {
   
        $bikeId = $_POST['bikeId'];
        $name = $_POST['name'];
        $bikeTypeId = $_POST['bikeTypeId'];
        $helmetId = $_POST['helmetId'];
        $price = $_POST['price'];
        $safetyInspect = $_POST['safetyInspect'];
        $description = $_POST['description'];

        $cols = "`BikeID`, `Name`, `BikeTypeID`, `HelmetID`, `Price p/h`, `Safety Inspect`, `Description`";
        $data = "'$bikeId', '$name', '$bikeTypeId', '$helmetId', '$price', '$safetyInspect', '$description'";

        $conn->query("UPDATE bike_inventory_table 
        SET Name='$name', BikeTypeID = '$bikeTypeId', HelmetID='$helmetId', Description='$description', `Price p/h`='$price', `Safety Inspect`='$safetyInspect'
        WHERE BikeID=$bikeId");

        header("location:Inventory.php");

}

