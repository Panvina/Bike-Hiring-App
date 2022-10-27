<?php
/*The entirety of this file is written by Vina Touch 101928802*/ 

include_once "../person-dto.php";
include_once "../booking-dto.php";
include_once "../backend-connection.php";
include_once "../bookings-db.php";
$successCount = 0;
$failedCount = 0;

//a test case, extracted from the login script, to test whether the user's role is authenticated correctly
function testUserLoginType($testUsername, $testPwd){
    $newUser = new PersonDTO($testUsername);
        $role = $newUser->authenticateUser($testPwd); 
        $newUser->getDetails();   
    if($role == "3"){      
        return 'customer';
    }else if ($role == "2"){  
        return 'employee';
    }else if ($role == "1") {
        return 'owner';
    }else{
        return 'invalid';
    }
}

//a test case to test whether the system is identifying a new or an existing user correctly
function testUserDetailType($testEmail, $testPwd){
    $newUser = new PersonDTO($testEmail);  
    $role = $newUser->authenticateUser($testPwd); 
    $newUser->getDetails();   
    $license = $newUser->getLicence();    
    if ($license == "null"){            
        return 'no details';
    }else{   
        return 'full details';
    }  
}

//a test case to test whether a user can create an account successfully
function testCreateAccount($testUsername, $first_name, $last_name,$pwd){
    $cus_conn = new DBConnection("customer_table");
    $acc_conn = new DBConnection("accounts_table");       
    $empty="null";
    $searchExistingUser = new PersonDTO($testUsername);
    $searchExistingUser->getDetails();
    $full_name= $first_name . " " .$last_name;
    $cols = "user_name, name, phone_number, email, street_address, suburb, post_code, licence_number, state";
    $customer_data = "'$testUsername','$full_name', '$empty', '$testUsername', '$empty', '$empty', '$empty', '$empty', '$empty'";

    $hashed_pwd = password_hash($pwd, PASSWORD_DEFAULT);
    $acc_cols= "user_name, role_id, password";
    $account_data= "'$testUsername', 3, '$hashed_pwd'";
    if ($searchExistingUser->getUsername() == null){
        $cus_conn->insert($cols ,  $customer_data);
        $acc_conn->insert($acc_cols, $account_data);
        return true;
    }else{
        return false;
    }
}

//a test case to test whether a user can update their details successfully
function testUpdateDetails($email,$name,$number,$street,$suburb, $pcode,$state){
    $userDetail = new PersonDTO($email);
    $msg = $userDetail->updateDetails($userDetail->getDetails(),$name,$number,$street,$suburb, $pcode,$state,$email);
    if ($msg=="true"){
        return true;
    }else{
        return false;
    }
}

//a test function to determine whether a test passes
function assertEqual ($expectedResult, $actualResult, $testType){
    global $successCount; 
    global $failedCount; 
    if($expectedResult == $actualResult){
        $successCount++;
        echo "<p>$testType: <span style='color:green;'>Test Passed</span></p>";
    }else{
        $failedCount++;
        echo "<p>$testType: <span style='color:red;'>Test Failed</span></p>";
    }
}

//a test function to determine whether a test passes
function assertTrue($expectedResult, $testType){
    global $successCount; 
    global $failedCount; 
    if($expectedResult == true){
        $successCount++;
        echo "<p>$testType: <span style='color:green;'>Test Passed</span></p>";
    }else{
        $failedCount++;
        echo "<p>$testType: <span style='color:red;'>Test Failed</span></p>";
    }
}

//a test function to determine whether a test passes
function assertFalse($expectedResult, $testType){
    global $successCount; 
    global $failedCount; 
    if($expectedResult == false){
        $successCount++;
        echo "<p>$testType: <span style='color:green;'>Test Passed</span></p>";
    }else{
        $failedCount++;
        echo "<p>$testType: <span style='color:red;'>Test Failed</span></p>";
    }
}

//a function to clean up test date from the database
function cleanUpTestData($conn, $tablename, $pkeyColName, $pkeyValue){
    $query = "DELETE FROM $tablename WHERE $pkeyColName=$pkeyValue";
    //echo $query;
    $ret = $conn->query($query);

    return $ret;
}
?>
<html>
    <body>
        <?php

        $cusUsername ='testy@gmail.com';
        $empUsername ='EM-Tess21';
        $ownerUsername ='OwnerTest555';

        $fname = 'Testy ';
        $lname = 'Test';
        $num = '0422222222';
        $email ='testy@gmail.com';
        $street = '11 test town street';
        $city = 'altona';
        $pcode = '6666';
        $licNum = '123456789';
        $state = 'VIC';
        $pwd = password_hash('12', PASSWORD_DEFAULT);

        /*Initialise a customer test data for the database*/
        $testCustomerDetails1 ="'$cusUsername', '$fname" . "$lname','$num','$email','$street','$city','$pcode','$licNum', '$state'";
        $testCustomerAccount1 ="'$cusUsername','3','$pwd'";
        /*Initialise an employee test data for the database*/
        $testEmployeeDetails1 ="'$empUsername', '$fname" . "$lname','$num','$email','$street','$city','$pcode', '$state'";
        $testEmployeeAccount1 ="'$empUsername','2','$pwd'";
        /*Initialise an owner test data for the database*/
        $testOwnerAccount1 ="'$ownerUsername','1','$pwd'";

        $conn = new mysqli("localhost",'root','',"bike_hiring_system");  
        
        /*Insert a customer test data in the database*/
        $conn->query("INSERT customer_table (user_name, name, phone_number, email, street_address, suburb, post_code, licence_number, state) 
                            VALUES ($testCustomerDetails1)");
        
        /*Insert an employee test data in the database*/
        $conn->query("INSERT employee_table (user_name, name, phone_number, email, address, suburb, post_code, state) 
                            VALUES ($testEmployeeDetails1)");

        /*Insert an test data in the database*/
        $conn->query("INSERT accounts_table (user_name, role_id, password) VALUES ($testCustomerAccount1), ($testEmployeeAccount1), ($testOwnerAccount1)"); 
        
        /* Checking type authorisation level of the user: test executions */
        $expectedResult = testUserLoginType($cusUsername, $pwd);  
        assertEqual($expectedResult, 'customer', 'Customer User Type Check');

        $expectedResult = testUserLoginType($empUsername, $pwd);  
        assertEqual($expectedResult, 'employee', 'Employee User Type Check');

        $expectedResult = testUserLoginType($ownerUsername, $pwd);  
        assertEqual($expectedResult, 'owner', 'Owner User Type Check');

        /* Checking whether the user is an existing customer: test execution */
        $expectedResult = testUserDetailType($email, $pwd);
        assertEqual($expectedResult, 'full details', 'Existing Customer Check');
        
        /*Cleaning up data to begin new test executions*/
        cleanUpTestData($conn, 'accounts_table', 'user_name',"'$cusUsername'");
        cleanUpTestData($conn, 'customer_table', 'user_name',"'$cusUsername'");

        /* Checking whether a customer account can be created: test executions */
        assertTrue(testCreateAccount($email, $fname, $lname,$pwd), 'Success Account Creation Check');
        assertFalse(testCreateAccount($email, $fname, $lname,$pwd), 'Fail Account Creation Check');

        /* Checking whether the user is a new customer: test execution */
        $expectedResult = testUserDetailType($email, $pwd);
        assertEqual($expectedResult, 'no details', 'Existing Customer Check');

        /* Checking whether the user details can be updated: test execution */
        assertTrue(testUpdateDetails($email,'Testy Two',$num,$street,$city, $pcode,$state), 'Success Update User Details Check');
        assertFalse(testUpdateDetails($email,'Testy T222o',$num,$street,$city, $pcode,$state), 'Fail Update User Details Check');

        /* Cleaning up the test data from the database*/
        cleanUpTestData($conn, 'accounts_table', 'user_name',"'$cusUsername'");
        cleanUpTestData($conn, 'customer_table', 'user_name',"'$cusUsername'");
        cleanUpTestData($conn, 'accounts_table', 'user_name',"'$ownerUsername'");
        cleanUpTestData($conn, 'accounts_table', 'user_name',"'$empUsername'");
        cleanUpTestData($conn, 'employee_table', 'user_name',"'$empUsername'");
        $conn->close(); //close the database connection
        echo "<p><strong>Successful Tests:</strong> $successCount</p>";
        echo "<p><strong>Failed Tests:</strong> $failedCount</p>";
        ?>
    </body>
</html>