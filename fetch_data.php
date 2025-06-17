<?php
$servername = "localhost"; // Update if necessary
$username = "wovenhos_patrick"; // Your MySQL username
$password = ".Kingkaveli1"; // Your MySQL password
$dbname = "wovenhos_the_sync"; // The database you created
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to generate random user data
function generateRandomUserData() {
    $firstNames = ['John', 'Jane', 'Alex', 'Chris', 'Katie'];
    $lastNames = ['Doe', 'Smith', 'Johnson', 'Brown', 'Davis'];
    $states = ['California', 'Texas', 'New York', 'Florida', 'Illinois'];
    $jobs = ['Engineer', 'Teacher', 'Doctor', 'Nurse', 'Artist'];
    $genders = ['Male', 'Female', 'Other'];

    $first_name = $firstNames[array_rand($firstNames)];
    $last_name = $lastNames[array_rand($lastNames)];
    $state = $states[array_rand($states)];
    $age = rand(18, 65);
    $job = $jobs[array_rand($jobs)];
    $gender = $genders[array_rand($genders)];

    return [
        'first_name' => $first_name,
        'last_name' => $last_name,
        'state' => $state,
        'age' => $age,
        'job' => $job,
        'gender' => $gender,
    ];
}

// Insert new user data into the database
$userData = generateRandomUserData();
$sql = "INSERT INTO users (first_name, last_name, state, age, job, gender) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("sssiss", $userData['first_name'], $userData['last_name'], $userData['state'], $userData['age'], $userData['job'], $userData['gender']);
if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
}

// Fetch all user data to return
$result = $conn->query("SELECT * FROM users ORDER BY created_at DESC");
$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($users);
?>