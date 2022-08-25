<?php // Filename: form.inc.php 
?>

<!-- Note the use of sticky fields below -->
<!-- Note the use of the PHP Ternary operator
Scroll down the page
http://php.net/manual/en/language.operators.comparison.php#language.operators.comparison.ternary
-->

<?php
// Button label logic
if (basename($_SERVER['PHP_SELF']) == 'create-record.php') {
    $button_label = "Save New Record";
} else if (basename($_SERVER['PHP_SELF']) == 'update-record.php') {
    $button_label = "Save Updated Record";
} else if (basename($_SERVER['PHP_SELF']) == 'advanced-search.php') {
    $button_label = "Search...";
}
?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
    <label class="col-form-label" for="first">First Name</label>
    <input class="form-control" type="text" id="first" name="first" value="<?= isset($first) ? $first : null ?>">
    <br>
    <label class="col-form-label" for="last">Last Name</label>
    <input class="form-control" type="text" id="last" name="last" value="<?= isset($last) ? $last : null ?>">
    <br>
    <label class=" col-form-label" for="id">Student ID </label>
    <input class="form-control" type="number" id="id" name="student_id" value="<?= isset($student_id) ? $student_id : null ?>">
    <br>
    <label class=" col-form-label" for="email">Email</label>
    <input class="form-control" type="text" id="email" name="email" value="<?= isset($email) ? $email : null ?>">
    <br>
    <label class=" col-form-label" for="phone">Phone</label>
    <input class="form-control" type="text" id="phone" name="phone" value="<?= isset($phone) ? $phone : null ?>">
    <br>
    <!-- create a label for GPA text field  -->
    <label class=" col-form-label" for="gpa">GPA</label>
    <!-- create text field for GPA. Field made to be sticky -->
    <input class="form-control" type="number" id="gpa" min="1" max="4" step=".01" name="gpa" value="<?= isset($gpa) ? $gpa : null ?>">
    <br>
    <!-- create radio buttons for Financial Aid information with the option of "Yes" or "No". The buttons are made to be sticky -->
    <p>Financial Aid?</p>
    <input type="radio" id="fin_aid_yes" name="financial_aid" value="1" <?= $financial_aid_yes ? 'checked' : null ?>>
    <label for="fin_aid_yes">Yes</label>
    <br>
    <input type="radio" id="fin_aid_no" name="financial_aid" value="0" <?= $financial_aid_no ? 'checked' : null ?>>
    <label for="fin_aid_no">No</label>
    <br>
    <br>
    <!-- create a label for Degree Program select field  -->
    <label class=" col-form-label" for="degree">Degree Program</label>
    <br>
    <!-- create a select element for Degree Program with 5 options. Each option is made to be sticky -->
    <select class="form-control" id="degree" name="degree">
        <option value="selectDegree" <?= ($degree == 'selectDegree') ? 'selected' : null ?>>--Select a Degree Program--</option>
        <option value="Computer Science" <?= ($degree == 'Computer Science') ? 'selected' : null ?>>Computer Science</option>
        <option value="Cybersecurity" <?= ($degree == 'Cybersecurity') ? 'selected' : null ?>>Cybersecurity</option>
        <option value="Electrical Engineering" <?= ($degree == 'Electrical Engineering') ? 'selected' : null ?>>Electrical Engineering</option>
        <option value="Mechanical Engineering" <?= ($degree == 'Mechanical Engineering') ? 'selected' : null ?>>Mechanical Engineering</option>
        <option value="Web Development" <?= ($degree == 'Web Development') ? 'selected' : null ?>>Web Development</option>
    </select>
    <br>
    <label class=" col-form-label" for="graduation_date">Graduation Date</label>
    <input class="form-control" type="date" id="graduation_date" name="graduation_date" value="<?= isset($graduation_date) ? $graduation_date : null ?>">
    <br>
    <br>
    <a href=" display-records.php">Cancel</a>&nbsp;&nbsp;
    <button class="btn btn-primary" type="submit"><?= $button_label ?></button>
    <input type="hidden" name="id" value="<?= $id ?>">
</form>