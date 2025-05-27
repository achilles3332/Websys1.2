CREATE DATABASE IF NOT EXISTS pet checkup registration;
USE pet checkup registration;

-- Create pets table
CREATE TABLE IF NOT EXISTS pets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    species VARCHAR(50) NOT NULL,
    breed VARCHAR(100),
    age INT,
    owner_name VARCHAR(100) NOT NULL,
    owner_contact VARCHAR(100) NOT NULL
);

-- Create checkups table
CREATE TABLE IF NOT EXISTS checkups (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pet_id INT NOT NULL,
    appointment_date DATE NOT NULL,
    notes TEXT,
    FOREIGN KEY (pet_id) REFERENCES pets(id) ON DELETE CASCADE
);
