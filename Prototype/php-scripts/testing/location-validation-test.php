<!--
Project Name: Inverloch Bike Hire
Project Description: A website for hiring bikes. Front-end accompanied
	   by an admin dashboard.
File Description: This file is mainly used for testing purposes
	- Clement Cheung @ 103076376@student.swin.edu.au
-->
<!-- This page is completely done by Clement-->
<?php
include("../Reusable.php");

//SetUp

//testdata for isItNull function
$testdataNull=NULL;
$testdataChecked="Checked";

//Test data for checkValue Function
$testdataNega="-1";
$testdata0="0";
$testdata1="1";

//test data for isempty fucntion
$testdataRandom="potatocat";
$testdataEmpty="";

//test data for postCodeSize and validVicPostCode function
$testdataPostcodePassSize="1234";
$testdataPostcodeLong="12345";
$testdataPostcodeShort="1";
$testdataPostcodePassVic="3123";

//test data for suburbValidation function
$testdataSuburbPass="Inverloch";
$testdataInvalidSuburb="12345";

//test data for validHomeAddress
$testdataPassHome="18 A'becket Street";
$testdataInvalidHome="Doncald street";

//test : isItNull
{
    $expectedresult1="0";
    $expectedresult2="1";
    
    //this will go through the tests, if it fails, an error message appear
    if(isItNull($testdataNull)!=$expectedresult1)
    {
        echo"isItNull failed. '$testdataNull' is inserted and should return a '0'.<br>";
    }
    else if (isItNull($testdataChecked)!=$expectedresult2)
    {
        echo"isItNull failed. '$testdataChecked' is inserted and should return a '1'.<br>";
    }
    else
    {
        echo "isItNull success.<br>";
    }
}

//test : checkValue
{
    $expectedresult3="";
    $expectedresult4="";
    $expectedresult5="checked";
    
    //this will go through the tests, if it fails, an error message appear
    if(checkValue($testdataNega)!=$expectedresult3)
    {
        echo"checkValue failed. '$testdataNega' is inserted and should return a ''.<br>";
    }
    else if (checkValue($testdata0)!=$expectedresult4)
    {
        echo"checkValue failed. '$testdata0' is inserted and should return a ''.<br>";
    } 
    else if (checkValue($testdata1)!=$expectedresult5)
    {
        echo"checkValue failed. '$testdata1' is inserted and should return a 'checked'.<br>";
    }
    else
    {
        echo "checkValue success.<br>";
    }
}

//test : isempty
{
    $expectedresult6=false;
    $expectedresult7=true;
    $expectedresult8=true;
    
    //this will go through the tests, if it fails, an error message appear
    if (isempty($testdataRandom)!=$expectedresult6)
    {
        echo"isempty failed. '$testdataRandom' is inserted and should return a true.<br>";
    }
    else if(isempty($testdataNull)!=$expectedresult7)
    {
        echo"isempty failed. '$testdataNull' is inserted and should return a false.<br>";
    }
    else if (isempty($testdataEmpty)!=$expectedresult8)
    {
        echo"isempty failed. '$testdataEmpty' is inserted and should return a false.<br>";
    }
    else
    {
        echo "isempty success.<br>";
    }
}
//test : postCodeSize
{
    $expectedresult9=true;
    $expectedresult10=false;
    $expectedresult11=false;
    $expectedresult12=true;
    
    //this will go through the tests, if it fails, an error message appear
    if (postCodeSize($testdataPostcodePassSize)!=$expectedresult9)
    {
        echo"postCodeSize failed. '$testdataPostcodePassSize' is inserted and should return a true.<br>";
    }
    else if(postCodeSize($testdataPostcodeLong)!=$expectedresult10)
    {
        echo"postCodeSize failed. '$testdataPostcodeLong' is inserted and should return a false.<br>";
    }
    else if (postCodeSize($testdataPostcodeShort)!=$expectedresult11)
    {
        echo"postCodeSize failed. '$testdataPostcodeShort' is inserted and should return a false.<br>";
    }
    else if (postCodeSize($testdataPostcodePassVic)!=$expectedresult12)
    {
        echo"postCodeSize failed. '$testdataPostcodePassVic' is inserted and should return a true.<br>";
    }
    else
    {
        echo "postCodeSize success.<br>";
    }
}

//test : validVicPostCode
{
    $expectedresult13=false;
    $expectedresult14=false;
    $expectedresult15=false;
    $expectedresult16=true;
    
    //this will go through the tests, if it fails, an error message appear
    if (validVicPostCode($testdataPostcodePassVic)!=$expectedresult16)
    {
        echo"validVicPostCode failed. '$testdataPostcodePassVic' is inserted and should return a true.<br>";
    }
    else if(validVicPostCode($testdataPostcodeLong)!=$expectedresult14)
    {
        echo"validVicPostCode failed. '$testdataPostcodeLong' is inserted and should return a false.<br>";
    }
    else if (validVicPostCode($testdataPostcodeShort)!=$expectedresult15)
    {
        echo"validVicPostCode failed. '$testdataPostcodeShort' is inserted and should return a false.<br>";
    }
    else if (validVicPostCode($testdataPostcodePassSize)!=$expectedresult13)
    {
        echo"validVicPostCode failed. '$testdataPostcodePassSize' is inserted and should return a false.<br>";
    }
    else
    {
        echo "validVicPostCode success.<br>";
    }
}

//test : suburbValidation
{
    $expectedresult17=true;
    $expectedresult18=false;
    $expectedresult19=false;
    $expectedresult20=false;
    
    //this will go through the tests, if it fails, an error message appear
    if (suburbValidate($testdataSuburbPass)!=$expectedresult17)
    {
        echo"suburbValidate failed. '$testdataSuburbPass' is inserted and should return a true.<br>";
    }
    else if(suburbValidate($testdataPostcodeLong)!=$expectedresult18)
    {
        echo"suburbValidate failed. '$testdataPostcodeLong' is inserted and should return a false.<br>";
    }
    else if (suburbValidate($testdataInvalidSuburb)!=$expectedresult19)
    {
        echo"suburbValidate failed. '$testdataInvalidSuburb' is inserted and should return a false.<br>";
    }
    else if (suburbValidate($testdataEmpty)!=$expectedresult20)
    {
        echo"suburbValidate failed. '$testdataEmpty' is inserted and should return a false.<br>";
    }
    else
    {
        echo "suburbValidate success.<br>";
    }
}

//test : validHomeAddress
{
    $expectedresult21=true;
    $expectedresult22=false;
    $expectedresult23=false;
    $expectedresult24=false;
    
    //this will go through the tests, if it fails, an error message appear
    if (validHomeAddress($testdataPassHome)!=$expectedresult21)
    {
        echo"validHomeAddress failed. '$testdataPassHome' is inserted and should return a true.<br>";
    }
    else if(validHomeAddress($testdataInvalidHome)!=$expectedresult22)
    {
        echo"validHomeAddress failed. '$testdataInvalidHome' is inserted and should return a false.<br>";
    }
    else if (validHomeAddress($testdataInvalidSuburb)!=$expectedresult23)
    {
        echo"validHomeAddress failed. '$testdataInvalidSuburb' is inserted and should return a false.<br>";
    }
    else if (validHomeAddress($testdataEmpty)!=$expectedresult24)
    {
        echo"validHomeAddress failed. '$testdataEmpty' is inserted and should return a false.<br>";
    }
    else
    {
        echo "validHomeAddress success.<br>";
    }
}

?>