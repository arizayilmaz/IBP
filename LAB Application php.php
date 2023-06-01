<?php
// Connect to the database
$db = new PDO('mysql:host=localhost;dbname=my_database', 'username', 'password');

// Create the "students" table if it doesn't already exist
$sql = 'CREATE TABLE IF NOT EXISTS students (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(255),
  email VARCHAR(255),
  gender VARCHAR(10)
)';

$db->exec($sql);

// Validate the form data
if (empty($_POST['full_name'])) {
  echo 'Please enter your full name.';
  exit;
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  echo 'Please enter a valid email address.';
  exit;
}

// Insert the student's information into the database
$sql = 'INSERT INTO students (full_name, email, gender) VALUES (?, ?, ?)';
$stmt = $db->prepare($sql);
$stmt->execute(array($_POST['full_name'], $_POST['email'], $_POST['gender']));

// Display a success message
echo 'Your registration was successful!';

// List the information of the students registered from the database
$sql = 'SELECT * FROM students';
$results = $db->query($sql);

foreach ($results as $row) {
  echo '<p>Name: ' . $row['full_name'] . '</p>';
  echo '<p>Email: ' . $row['email'] . '</p>';
  echo '<p>Gender: ' . $row['gender'] . '</p>';
}