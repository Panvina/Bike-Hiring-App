<?php 
    include 'person-dto.php';

    $test = new PersonDTO("Vina", "Touch");
    echo $test->getName();
    echo $test->getUsername();
?>