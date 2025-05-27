<?php
include 'db.php';

$pet_id = $_POST['pet_id'];
$appointment_date = $_POST['appointment_date'];
$notes = $_POST['notes'];

$sql = "INSERT INTO checkups (pet_id, appointment_date, notes)
        VALUES ($pet_id, '$appointment_date', '$notes')";

if (mysqli_query($conn, $sql)) {
    $message = "<div class='success-box'>✅ Appointment booked successfully!</div>";
} else {
    $message = "<div class='error-box'>❌ Error: " . mysqli_error($conn) . "</div>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Appointment Booking Result</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <?php echo $message; ?>
    <a class="home-btn" href="index.php">🏠 Go Home</a>
</div>
</body>
</html>