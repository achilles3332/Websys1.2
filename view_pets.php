<?php 
include 'header.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<div class="container">
    <h2>🐾 Registered Pets</h2>
    <?php
    include 'db.php';
    
    // Verify connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Verify pets table exists
    $tableCheck = mysqli_query($conn, "SHOW TABLES LIKE 'pets'");
    if (mysqli_num_rows($tableCheck) == 0) {
        die("Error: 'pets' table doesn't exist. Please run pet.sql to create the database tables.");
    }

    // Fetch all pets with secure query
    $sql = "SELECT * FROM `pets` ORDER BY `name` ASC";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='record'>";
            echo "<strong>" . htmlspecialchars($row['name']) . " (" . htmlspecialchars($row['species']) . ")</strong><br>";
            echo "Breed: " . htmlspecialchars($row['breed'] ?? 'N/A') . "<br>";
            echo "Age: " . htmlspecialchars($row['age'] ?? 'Unknown') . "<br>";
            echo "Owner: " . htmlspecialchars($row['owner_name']) . "<br>";
            echo "Contact: " . htmlspecialchars($row['owner_contact']) . "<br>";
            
            // Delete form with confirmation
            echo "<form action='delete_pet.php' method='POST' 
                  onsubmit=\"return confirm('Are you sure you want to delete this pet?');\">
                    <input type='hidden' name='pet_id' value='" . htmlspecialchars($row['id']) . "'>
                    <input type='submit' value='🗑 Delete' class='delete-btn'>
                  </form>";
            echo "</div><hr>";
        }
    } else {
        echo "<p>No pets registered yet.</p>";
    }

    mysqli_close($conn);
    ?>
    <a class="home-btn" href="index.php">🏠 Go Home</a>
</div>
<?php include 'footer.php'; ?>