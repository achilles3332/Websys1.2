<?php
$conn = mysqli_connect("localhost", "root", "", "pet checkup registration");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>