var left_arrow = document.getElementById("leftArrow");
var right_arrow = document.getElementById("rightArrow");

left_arrow.onclick = function()
{
    decrementDate();
}

right_arrow.onclick = function()
{
    incrementDate();
}

function decrementDate()
{
    // alert("Test");
    <?php
        // https://stackoverflow.com/questions/660501/simplest-way-to-increment-a-date-in-php
        $getDate = $_GET["date"];
        $prevDay=strftime("%d-%m-%Y", strtotime("$getDate -1 day"));
        // header("../dashboard.php?date=$prevDay");
    ?>
}

function incrementDate()
{
    // alert("Test");
    <?php
        // https://stackoverflow.com/questions/660501/simplest-way-to-increment-a-date-in-php
        $getDate = $_GET["date"];
        $nextDay=strftime("%d-%m-%Y", strtotime("$getDate +1 day"));
        // header("../dashboard.php?date=$nextDay");
    ?>
}

var date_picker = document.getElementById("date-picker");
date_picker.change(function() {
    window.location.assign(date_picker.value);
    window.location.reload();
});
