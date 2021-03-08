<?php

include "include/DBRegister.php";

// Preparing arrays to store errors and return values
$errors = array();
$returnValue = array();

// Checking whether the input fiels are empty and/or valid

// First name validation using regex
if (empty($_POST["firstName"])) {
    array_push($errors, "First name is required");
} else {
    if (!preg_match("/^[a-zA-Z-' ]*$/", $_POST["firstName"])) {
        array_push($errors, "Invalid Characters in \"First Name\" input");
    }
}

// Last name validation using regex
if (empty($_POST["lastName"])) {
    array_push($errors, "Last name is required");
} else {
    if (!preg_match("/^[a-zA-Z-' ]*$/", $_POST["lastName"])) {
        array_push($errors, "Invalid Characters in \"Last Name\" input");
    }
}

// E-mail validation
if (empty($_POST["email"])) {
    array_push($errors, "E-mail is required");
} else {
    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "A valid E-mail is required");
    }
}

// Cbecking whether the there were any errors up until now and handling the input data
if (!empty($errors)) {
    $returnValue["success"] = false;
    $returnValue["errors"] = $errors;
} else {
    $returnValue["success"] = true;
    $returnValue["message"] = "Success!";

    // Using DBRegister class to connect to the MySQL database and add form data to it
    $registerToDB = new DBRegister();
    $returnValue["dbCallback"] = $registerToDB->Register($_POST["firstName"], $_POST["lastName"], $_POST["email"]);
}

echo json_encode($returnValue);
