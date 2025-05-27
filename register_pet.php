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

    /* Add to existing styles */
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
    
    input[type="text"]:focus, 
    input[type="number"]:focus,
    select:focus {
        border-color: #4CAF50;
        box-shadow: 0 0 5px rgba(76, 175, 80, 0.3);
    }
    
    .phone-group input[type="text"]:focus {
        box-shadow: 0 0 5px rgba(76, 175, 80, 0.3);
    }
    
    h2 {
        font-weight: 500;
    }

    input[type="text"],
    input[type="number"],
    select {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
        text-align: center;
    }

    .phone-group {
        display: flex;
        gap: 5px;
        justify-content: center;
    }

    .phone-group select {
        width: 100px;
        text-align: center;
    }

    .phone-group input[type="text"] {
        flex: 1;
    }

    input[type="submit"],
    .home-btn {
        margin-top: 10px;
        padding: 10px;
        text-align: center;
    }
</style>

<div class="container">
    <h2>🐶 Register a Pet</h2>
    <form action="insert_pet.php" method="POST">
        <label>Pet Name:</label>
        <input type="text" name="name" required
            pattern="([A-Z][a-z]+)(\s[A-Z][a-z]+)*"
            placeholder="e.g. Fluffy"
            title="Start each word with a capital letter. Only English letters allowed. No Ññ or numbers.">

        <label>Species:</label>
        <input type="text" name="species" required
            pattern="([A-Z][a-z]+)(\s[A-Z][a-z]+)*"
            placeholder="e.g. Dog"
            title="Start each word with a capital letter. Only English letters allowed. No Ññ or numbers.">

        <label>Breed:</label>
        <input type="text" name="breed"
            pattern="([A-Z][a-z]+)(\s[A-Z][a-z]+)*"
            placeholder="e.g. Golden Retriever"
            title="Start each word with a capital letter. Only English letters allowed. No Ññ or numbers.">

        <label>Age:</label>
        <input type="number" name="age" min="0" placeholder="e.g. 3">

        <label>Owner Name:</label>
        <input type="text" name="owner_name" required
            pattern="([A-Z][a-z]+)(\s[A-Z][a-z]+)*"
            placeholder="e.g. John Doe"
            title="Start each word with a capital letter. Only English letters allowed. No Ññ or numbers.">

        <label>Owner Contact:</label>
        <div class="phone-group">
            <select name="country_code" id="countryCode" onchange="updatePhonePattern()">
                <option value="+63" selected>Philippines (+63)</option>
                <option value="+1">USA/Canada (+1)</option>
                <option value="+44">UK (+44)</option>
                <option value="+61">Australia (+61)</option>
                <option value="+81">Japan (+81)</option>
                <option value="+82">South Korea (+82)</option>
                <option value="+65">Singapore (+65)</option>
                <option value="+60">Malaysia (+60)</option>
                <option value="+84">Vietnam (+84)</option>
                <option value="+66">Thailand (+66)</option>
                <option value="+62">Indonesia (+62)</option>
                <option value="+971">UAE (+971)</option>
                <option value="+91">India (+91)</option>
            </select>
            <input type="text" name="owner_contact" id="phoneNumber" required
                pattern="9\d{9}"
                maxlength="10"
                placeholder="9123456789"
                title="Enter 10 digits starting with 9 (e.g. 9123456789)">
        </div>

        <input type="hidden" name="full_contact" id="fullContact">

        <input type="submit" value="Register Pet">
        <a class="home-btn" href="index.php">🏠 Go Home</a>
    </form>
</div>

<script>
    function updatePhonePattern() {
        const countryCode = document.getElementById('countryCode').value;
        const phoneInput = document.getElementById('phoneNumber');
        const fullContactInput = document.getElementById('fullContact');
        
        // Set default pattern for Philippines
        let pattern = "9\\d{9}";
        let maxLength = 10;
        let placeholder = "9123456789";
        let title = "Enter 10 digits starting with 9 (e.g. 9123456789)";
        
        // Adjust for other countries if needed
        if (countryCode === "+1") {
            pattern = "\\d{10}";
            placeholder = "1234567890";
            title = "Enter 10 digits (e.g. 1234567890)";
        } else if (countryCode === "+44") {
            pattern = "7\\d{9}";
            placeholder = "7123456789";
            title = "Enter 10 digits starting with 7 (e.g. 7123456789)";
        }
        
        phoneInput.pattern = pattern;
        phoneInput.maxLength = maxLength;
        phoneInput.placeholder = placeholder;
        phoneInput.title = title;
        phoneInput.value = "";
    }

    // Combine country code and number before form submission
    document.querySelector('form').addEventListener('submit', function(e) {
        const countryCode = document.getElementById('countryCode').value;
        const phoneNumber = document.getElementById('phoneNumber').value;
        document.getElementById('fullContact').value = countryCode + phoneNumber;
    });
</script>

<?php include 'footer.php'; ?>