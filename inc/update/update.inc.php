<?php // Filename: connect.inc.php

require_once __DIR__ . "/../db/db_connect.inc.php";
require_once __DIR__ . "/../app/config.inc.php";
// include the functions.inc.php file
require_once __DIR__ . "/../functions/functions.inc.php";
// set finacial aid radio input fields to false
$financial_aid_yes = false;
$financial_aid_no = false;
// if $_GET["id] is set, then assign its value to $id. This comes into play when the user clicks on the update button from the display records page
if (isset($_GET["id"])) {
    $id = $_GET["id"];
}
// if $_POST["id] is set, then assign its value to $id. This comes into play when the user clicks on the "Save Updated Record" button
if (isset($_POST["id"])) {
    $id = $_POST["id"];
}

// Build SQL for retrieving data with placeholder for id
$sql = "SELECT * FROM $db_table WHERE id=:id LIMIT 1";
// Prepare the statement
$stmt = $db->prepare($sql);
// Execute the query
$stmt->execute(["id" => $id]);
// fetch the record and assign it to $student_record
$student_record = $stmt->fetch();
//var_dump($student_record);

// assign each value from $student_record to it's corresponding variable
$first = $student_record->first_name;
$last = $student_record->last_name;
$student_id = $student_record->student_id;
$email = $student_record->email;
$phone = $student_record->phone;
$gpa = $student_record->gpa;
$financial_aid = $student_record->financial_aid;
if ($financial_aid == "1") {
    $financial_aid_yes = true;
} else {
    $financial_aid_no = true;
}
$degree = $student_record->degree_program;
$graduation_date = $student_record->graduation_date;

// create an array that will list required fields that have not been filled
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

    // if the number of elements in $error_bucket is zero, update the database record with updated values
    if (count($error_bucket) == 0) {
        // use an UPDATE Statement 
        $sql = "UPDATE $db_table SET first_name=:first_name,last_name=:last_name,email=:email,phone=:phone,student_id=:student_id,gpa=:gpa,financial_aid=:financial_aid,degree_program=:degree_program,graduation_date=:graduation_date WHERE id=:id";
        // Prepare the $sql variable and assign it to the $stmt variable. Then execute the $stmt variable.
        $stmt = $db->prepare($sql);
        try {
            $stmt->execute(["first_name" => $first, "last_name" => $last, "email" => $email, "phone" => $phone, "student_id" => $student_id, "gpa" => $gpa, "financial_aid" => $financial_aid, "degree_program" => $degree, "graduation_date" => $graduation_date, "id" => $id]);
            // if the row count equal to 0, then display message that the record could not be saved
            if ($stmt->rowCount() == 0) {
                echo '<div class="alert alert-danger" role="alert">
                I am sorry, but I could not save that record for you.</div>';
            } else {
                header("Location: display-records.php?message=The record for $first has been created.");
            }
        } catch (PDOException $e) {
            echo $e;
        }
    } else {
        display_error_bucket($error_bucket);
    }
}
