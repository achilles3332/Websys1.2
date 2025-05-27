<?php include 'header.php'; ?>
<style>
    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    form {
        width: 100%;
        max-width: 400px;
        margin: auto;
        display: flex;
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }

    select,
    input[type="date"],
    textarea,
    input[type="text"],
    input[type="number"] {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
        text-align: center;
    }

    input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        transition: all 0.3s ease;
    }
    
    input[type="submit"]:hover {
        background-color: #3e8e41;
    }
    
    select, input[type="date"], textarea {
        transition: all 0.3s ease;
        border: 1px solid #ddd;
    }
    
    select:focus, input[type="date"]:focus, textarea:focus {
        border-color: #4CAF50;
        box-shadow: 0 0 5px rgba(76, 175, 80, 0.3);
    }
    
    h2 {
        font-weight: 500;
    }

<!-- ... rest of your existing code ... -->

    textarea {
        resize: vertical;
        min-height: 80px;
    }

    input[type="submit"],
    .home-btn {
        margin-top: 10px;
        padding: 10px;
        text-align: center;
    }

    small {
        color: #555;
    }
</style>

<div class="container">
    <h2>📅 Book a Checkup Appointment</h2>
    <form action="insert_checkup.php" method="POST">
        <label>Select Pet:</label>
        <select name="pet_id" required>
            <?php
            include 'db.php';
            $result = mysqli_query($conn, "SELECT * FROM pets");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='{$row['id']}'>{$row['name']} ({$row['species']})</option>";
            }
            ?>
        </select>

        <label>Appointment Date:</label>
        <?php
        // Set date limits
        $today = date('Y-m-d');
        $maxDate = date('Y-m-d', strtotime('+30 days'));
        ?>
        <input type="date" name="appointment_date" min="<?= $today ?>" max="<?= $maxDate ?>" required>
        <small>
            📆 You can only book appointments within the next 30 days from today.
        </small>

        <label>Notes:</label>
        <textarea name="notes" placeholder="Any notes for the checkup..."></textarea>

        <input type="submit" value="Book Appointment">
        <a class="home-btn" href="index.php">🏠 Go Home</a>
    </form>
</div>
<?php include 'footer.php'; ?>
