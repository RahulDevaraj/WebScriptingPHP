<?php
// Rahul Devarajan Raj
require 'helpers.php';
session_start();
display_HTML_header('');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
if ($_POST['submit'] == 'Submit') {
$errors = validate_form();
if ($errors) {
display_form($errors);
} else {
confirm_form();
}
}
 elseif ($_POST['submit'] == 'Confirm') {
process_form();
} 
elseif ($_POST['submit'] == 'Edit') {
display_form();
}
} else {
display_form();
session_unset();
} 
display_HTML_footer();