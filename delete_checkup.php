<?php
include 'db.php';

if (isset($_POST['checkup_id'])) {
    $id = $_POST['checkup_id'];
    $sql = "DELETE FROM checkups WHERE id = $id";
    mysqli_query($conn, $sql);
}

header("Location: view_history.php");
exit;
