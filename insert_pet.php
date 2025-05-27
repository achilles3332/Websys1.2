<!DOCTYPE html>
<html>
<head>
    <title>Pet Registration Result</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <?php
    include 'db.php';

    $name = $_POST['name'];
    $species = $_POST['species'];
    $breed = $_POST['breed'];
    $age = $_POST['age'];
    $owner_name = $_POST['owner_name'];
    $owner_contact = $_POST['owner_contact'];

    $sql = "INSERT INTO pets (name, species, breed, age, owner_name, owner_contact)
            VALUES ('$name', '$species', '$breed', $age, '$owner_name', '$owner_contact')";

    if (mysqli_query($conn, $sql)) {
        echo "<div class='success-box'>🐾 Pet registered successfully!</div>";
    } else {
        echo "<div class='error-box'>❌ Error: " . mysqli_error($conn) . "</div>";
    }
    ?>
    <a class="home-btn" href="index.php">🏠 Go Home</a>
</div>
</body>
</html>
