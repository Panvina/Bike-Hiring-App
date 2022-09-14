<?php
// $to_email = '102091323@student.swin.edu.au';
// $subject = 'Testing PHP Mail';
// $message = 'This mail is sent using the PHP mail function';
// $headers = 'From: notafakeaccout234@gmail.com';
// mail($to_email,$subject,$message,$headers);

$pwdH= password_hash("12", PASSWORD_DEFAULT);
$pwd = "12";
if(password_verify($pwd,$pwdH)){
    echo "true";
}
?>
