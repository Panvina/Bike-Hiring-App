var date_picker = document.getElementById("date-picker");

date_picker.onchange= function()
{
    var date = date_picker.value;
    var dd = date.substr(8,2);
    var mm = date.substr(5,2);
    var yyyy = date.substr(0,4);
    window.location.replace(`dashboard.php?date=${dd}-${mm}-${yyyy}`);
    // window.location.reload();
};
