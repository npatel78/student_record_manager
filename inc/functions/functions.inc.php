<?php // Filename: function.inc.php
function display_message()
{
    if (isset($_GET["message"])) {
        $message = $_GET["message"];
        echo '<div class="mt-4 alert alert-success" role="alert">';
        echo $message;
        echo '</div>';
    }
}

function display_letter_filters($filter)
{
    echo '<span class="d-inline-block mr-3">Filter by <strong>Last Name</strong></span> ';

    $letters = range('A', 'Z');

    for ($i = 0; $i < count($letters); $i++) {
        if ($filter == $letters[$i]) {
            $class = 'class="d-inline-block text-light font-weight-bold p-2 mr-3 bg-dark"';
        } else {
            $class = 'class="d-inline-block text-secondary p-2 mr-5 bg-light border rounded"';
        }
        echo "<u><a $class href='?filter=$letters[$i]' title='$letters[$i]'>$letters[$i]</a></u>";
    }
    echo '<a class="text-secondary p-2 mx-2 bg-primary text-light border rounded" href="?clearfilter" title="Reset Filter">Reset</a>&nbsp;&nbsp;';
}

function display_record_table($records)
{
    echo '<div class="table-responsive">';
    echo "<table class=\"table table-striped table-hover table-sm mt-3 table-bordered\">";
    echo '<thead class="table-dark"><tr><th class="bg-primary">Actions</th><th><a href="?sortby=student_id">Student ID</a></th><th><a href="?sortby=first_name">First Name</a></th><th><a href="?sortby=last_name">Last Name</a></th><th><a href="?sortby=email">Email</a></th><th><a href="?sortby=phone">Phone</a></th><th><a href="?sortby=degree_program">Degree Program</a></th><th><a href="?sortby=gpa">GPA</a></th><th><a href="?sortby=financial_aid">Financial Aid</a></th><th><a href="?sortby=graduation_date">Graduation Date</a></th></thead>';

    foreach ($records as $row) {
        // change text color to white and cell background to red if $row->gpa is <= 2.0
        if ($row->gpa <= 2.0) {
            $text_c = "text-white";
            $bg_c = "bg-danger";
            // change text color to white and cell background to green if $row->gpa is equal to  4.0    
        } elseif ($row->gpa == 4.0) {
            $text_c = "text-white";
            $bg_c = "bg-success";
            // keep standard white text and white cell background
        } else {
            $text_c = "text-dark";
            $bg_c = "bg-white";
        }

        # display rows and columns of data
        echo '<tr>';
        echo "<td><a href=\"update-record.php?id={$row->id}\">Update</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"delete-record.php?id={$row->id}\" onclick=\"return confirm('Are you sure?');\">Delete</a></td>";
        echo "<td>{$row->student_id}</td>";
        echo "<td><strong>{$row->first_name}</strong></td>";
        echo "<td><strong>{$row->last_name}</strong></td>";
        echo "<td>{$row->email}</td>";
        echo "<td>{$row->phone}</td>";
        echo "<td>{$row->degree_program}</td>";
        echo "<td class='$text_c $bg_c text-center fw-bold'>{$row->gpa}</td>";
        // if financial_aid is set to 1, then display "Yes", else display "No"
        if ($row->financial_aid == "1") {
            echo "<td class='text-center'>Yes</td>";
        } else {
            echo "<td class='text-center'>No</td>";
        }
        echo "<td class='text-center'>{$row->graduation_date}</td>";
        echo '</tr>';
    } // end while
    echo '</table>';
    echo '</div>';
}

function display_error_bucket($error_bucket)
{
    echo '<div class="pt-4 alert alert-warning" role="alert">';
    echo '<p>The following errors were detected:</p>';
    echo '<ul>';
    foreach ($error_bucket as $text) {
        echo '<li>' . $text . '</li>';
    }
    echo '</ul>';
    echo '</div>';
    echo '<p>All of these fields are required. Please fill them in.</p>';
}

function echoActiveClassIfRequestMatches($requestUri)
{
    $current_file_name = basename($_SERVER["REQUEST_URI"], ".php");
    if ($current_file_name == $requestUri)
        echo 'active';
}
