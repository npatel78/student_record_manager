<?php
// create empty variable ($student_records) that will hold query results
$student_records = [];
// query string to be used to fetch data 
$sql = "SELECT * FROM student_v2 WHERE ";
// variable that will contain the database search conditions
$query = [];
// variable used to contain named parameter and field value
$params = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo '<h2>Search Results</h2>';
    // check to see if the fields contain any data
    if (!empty($_POST['first'])) {
        // if the field is not empty, add the corresponding database field name and named parameter to $query variable
        array_push($query, "first_name LIKE :first");
        // add the named parameter and field value to $params variable
        $params["first"] = $_POST["first"] . "%";
    }
    if (!empty($_POST['last'])) {
        array_push($query, "last_name LIKE :last");
        $params["last"] = $_POST["last"] . "%";
    }
    if (!empty($_POST['student_id'])) {
        array_push($query, "student_id LIKE :student_id");
        $params["student_id"] = $_POST["student_id"];
    }
    if (!empty($_POST['email'])) {
        array_push($query, "email LIKE :email");
        $params["email"] = $_POST["email"] . "%";
    }
    if (!empty($_POST['phone'])) {
        array_push($query, "phone LIKE :phone");
        $params["phone"] = $_POST["phone"] . "%";
    }
    if (!empty($_POST['gpa'])) {
        array_push($query, "gpa LIKE :gpa");
        $params["gpa"] = $_POST["gpa"] . "%";
    }
    if (isset($_POST["financial_aid"])) {
        array_push($query, "financial_aid = :financial_aid");
        $params["financial_aid"] = $_POST["financial_aid"];
    }
    if ($_POST["degree"] != 'selectDegree') {
        array_push($query, "degree_program = :degree_program");
        $params["degree_program"] = $_POST["degree"];
    }
    if (!empty($_POST['graduation_date'])) {
        array_push($query, "graduation_date = :graduation_date");
        $params["graduation_date"] = $_POST["graduation_date"];
    }
    // join $query elements with $sql string with "  and  " separator
    $sql = $sql . implode(" and ", $query);
    // prepare the statement
    $stmt = $db->prepare($sql);
    // execute the statement by passing the $params associative array
    $stmt->execute($params);
    $student_records = $stmt->fetchAll();
    // call display_record_table function and pass into it the $student_records array
    display_record_table($student_records);
    // if $stmt is set and contains 0 rows, then display message to user that no records were found
    if (isset($stmt)) {
        if ($stmt->rowCount() == 0) {
            echo "<h2 class=\"mt-4 alert alert-warning\">No Records found. Please perform a new search</h2>";
        }
    }
    // display to user where search results will appear
} else {
    echo '<div class="alert alert-info">';
    echo '<h2>Search results will appear here</h2>';
    echo '</div>';
}
