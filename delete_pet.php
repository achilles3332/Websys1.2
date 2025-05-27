<?php
include 'db.php';

if (isset($_POST['pet_id'])) {
    $id = $_POST['pet_id'];

    // Optional: delete related checkups first to prevent foreign key error
    $stmt = $conn->prepare("DELETE FROM checkups WHERE pet_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    // Now delete pet
    $stmt = $conn->prepare("DELETE FROM pets WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

$conn->close();

// Redirect to absolute path
header("Location: /enhanced_pet_checkup_system/view_pets.php");
exit;
?>
