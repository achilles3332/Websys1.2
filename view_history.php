<?php 
include 'header.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Determine sort order
$sort = $_GET['sort'] ?? 'date_desc';
$order_by = match($sort) {
    'date_asc' => 'checkups.appointment_date ASC',
    'name_asc' => 'pets.name ASC',
    'name_desc' => 'pets.name DESC',
    'owner_asc' => 'pets.owner_name ASC',
    'owner_desc' => 'pets.owner_name DESC',
    default => 'checkups.appointment_date DESC'
};
?>
<!DOCTYPE html>
<html>
<head>
    <title>Checkup History</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        h2 {
            font-weight: 500;
            color: #333;
        }
        .sort-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin: 20px 0;
        }
        .sort-btn {
            padding: 8px 12px;
            background: #f0f0f0;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            color: #333;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        .sort-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .sort-btn.active {
            background: #4CAF50;
            color: white;
            border-color: #4CAF50;
        }
        .record {
            transition: all 0.3s ease;
            padding: 15px;
            margin: 15px 0;
            border-radius: 8px;
            background: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .record:hover {
            transform: scale(1.01);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .delete-btn {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        .delete-btn:hover {
            background-color: #d32f2f;
            transform: translateY(-2px);
        }
        .home-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background: #2196F3;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        .home-btn:hover {
            background: #0b7dda;
            transform: translateY(-2px);
        }
        hr {
            border: 0;
            height: 1px;
            background: #eee;
            margin: 15px 0;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>🩺 Checkup History</h2>

    <div class="sort-buttons">
        <a href="?sort=date_desc" class="sort-btn <?= $sort === 'date_desc' ? 'active' : '' ?>">⬇️ Newest First</a>
        <a href="?sort=date_asc" class="sort-btn <?= $sort === 'date_asc' ? 'active' : '' ?>">⬆️ Oldest First</a>
        <a href="?sort=name_asc" class="sort-btn <?= $sort === 'name_asc' ? 'active' : '' ?>">A-Z Pet Name</a>
        <a href="?sort=name_desc" class="sort-btn <?= $sort === 'name_desc' ? 'active' : '' ?>">Z-A Pet Name</a>
        <a href="?sort=owner_asc" class="sort-btn <?= $sort === 'owner_asc' ? 'active' : '' ?>">A-Z Owner Name</a>
        <a href="?sort=owner_desc" class="sort-btn <?= $sort === 'owner_desc' ? 'active' : '' ?>">Z-A Owner Name</a>
    </div>

    <?php
    include 'db.php';

    $sql = "SELECT checkups.id, pets.name, pets.species, pets.breed, pets.age, pets.owner_name, pets.owner_contact,
                   checkups.appointment_date, checkups.notes
            FROM checkups
            JOIN pets ON checkups.pet_id = pets.id
            ORDER BY $order_by";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='record'>";

            // Dynamic display order based on sort type
            if ($sort === 'name_asc' || $sort === 'name_desc') {
                echo "<strong>" . htmlspecialchars($row['name']) . "</strong> (" . htmlspecialchars($row['species']) . ")<br>";
                echo "Owner: " . htmlspecialchars($row['owner_name']) . "<br>";
            } elseif ($sort === 'owner_asc' || $sort === 'owner_desc') {
                echo "<strong>" . htmlspecialchars($row['owner_name']) . "</strong> — Owner of <strong>" . htmlspecialchars($row['name']) . " (" . htmlspecialchars($row['species']) . ")</strong><br>";
            } else {
                echo "<strong>" . htmlspecialchars($row['name']) . "</strong> (" . htmlspecialchars($row['species']) . ")<br>";
                echo "Owner: " . htmlspecialchars($row['owner_name']) . "<br>";
            }

            echo "Breed: " . htmlspecialchars($row['breed'] ?? 'N/A') . "<br>";
            echo "Age: " . htmlspecialchars($row['age'] ?? 'Unknown') . "<br>";
            echo "Contact: " . htmlspecialchars($row['owner_contact']) . "<br>";
            echo "Date: " . htmlspecialchars($row['appointment_date']) . "<br>";
            echo "Notes: " . htmlspecialchars($row['notes']) . "<br>";

            echo "<form action='delete_checkup.php' method='POST' onsubmit=\"return confirm('Are you sure you want to delete this checkup?');\">
                    <input type='hidden' name='checkup_id' value='{$row['id']}'>
                    <input type='submit' value='🗑 Delete' class='delete-btn'>
                  </form>";
            echo "</div><hr>";
        }
    } else {
        echo "<p>No checkup records found.</p>";
    }

    mysqli_close($conn);
    ?>

    <a class="home-btn" href="index.php">🏠 Go Home</a>
</div>
</body>
</html>
<?php include 'footer.php'; ?>
