<?php // Filename: connect.inc.php

require_once __DIR__ . "/../db/db_connect.inc.php";
require_once __DIR__ . "/../functions/functions.inc.php";
require_once __DIR__ . "/../app/config.inc.php";
// create $financial_aid_yes and $financial_aid_no variables and set them to false. This will allow the fields to 
// be unchecked when the page is loaded. Create $degree variable and set it to null.
$financial_aid_yes = false;
$financial_aid_no = false;
$degree = null;
$error_bucket = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // First insure that all required fields are filled in
    if (empty($_POST["first"])) {
        array_push($error_bucket, "<p>A first name is required.</p>");
    } else {
        $first = $_POST["first"];
    }
    if (empty($_POST["last"])) {
        array_push($error_bucket, "<p>A last name is required.</p>");
    } else {
        $last = $_POST["last"];
    }
    if (empty($_POST["student_id"])) {
        array_push($error_bucket, "<p>A student ID is required.</p>");
    } else {
        $student_id = intval($_POST["student_id"]);
    }
    if (empty($_POST["email"])) {
        array_push($error_bucket, "<p>An email address is required.</p>");
    } else {
        $email = $_POST["email"];
    }
    if (empty($_POST["phone"])) {
        array_push($error_bucket, "<p>A phone number is required.</p>");
    } else {
        $phone = $_POST["phone"];
    }
    // if gpa is empty then add a message to $error_bucket
    if (empty($_POST["gpa"])) {
        array_push($error_bucket, "<p>A GPA is required.</p>");
        // else assign the value of the gpa field to $gpa
    } else {
        $gpa = $_POST["gpa"];
    }
    // check to see if the financial aid option is set
    if (isset($_POST["financial_aid"])) {
        // if set, then check if the value is set to 1
        if ($_POST["financial_aid"] == "1") {
            // if value is set to 1, then assign the value to $financial_aid variable, set $financial_aid_yes variable to true
            // and set $financial_aid_no to false
            $financial_aid = $_POST["financial_aid"];
            $financial_aid_yes = true;
            $financial_aid_no = false;
            // if value is not set to 1, then assign the value $financial_aid varaiable, set $financial_aid_yes variable to false
            // and set $financial_aid_no to true
        } else {
            $financial_aid = $_POST["financial_aid"];
            $financial_aid_yes = false;
            $financial_aid_no = true;
        }
        // if financial aid option is not set, then add a message to $error_bucket variable
    } else {
        array_push($error_bucket, "<p>Please select a value for Financial Aid.</p>");
    }
    // if degree is set to "selectDegree", then add a message to $error_bucket variable and assign the value to $degree variable
    if (($_POST["degree"]) == "selectDegree") {
        array_push($error_bucket, "<p>Degree is required.</p>");
        $degree = $_POST["degree"];
        // if degree is not set to "selectDegree", then assign the value to $degree variable
    } else {
        $degree = $_POST["degree"];
    }
    if (empty($_POST["graduation_date"])) {
        array_push($error_bucket, "<p>A graduation date is required.</p>");
    } else {
        $graduation_date = $_POST["graduation_date"];
    }

    // If we have no errors than we can try and insert the data
    if (count($error_bucket) == 0) {
        // Time for some SQL.
        $sql = "INSERT INTO $db_table (first_name,last_name,email,phone,student_id,gpa,financial_aid,degree_program,graduation_date) ";
        $sql .= "VALUES (:first,:last,:email,:phone,:student_id,:gpa,:financial_aid,:degree,:graduation_date)";
        // Prepare the $sql variable and assign it to the $stmt variable. Then execute the $stmt variable.
        $stmt = $db->prepare($sql);
        $stmt->execute(["first" => $first, "last" => $last, "email" => $email, "phone" => $phone, "student_id" => $student_id, "gpa" => $gpa, "financial_aid" => $financial_aid, "degree" => $degree, "graduation_date" => $graduation_date]);
        // if the row count equal to 0, then display message that the record could not be saved
        if ($stmt->rowCount() == 0) {
            echo '<div class="alert alert-danger" role="alert">
            I am sorry, but I could not save that record for you.</div>';
        } else {
            header("Location: display-records.php?message=The record for $first has been created.");
        }
    } else {
        display_error_bucket($error_bucket);
    }
}
