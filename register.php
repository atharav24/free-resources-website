<?php
require 'config.php'; // Your DB connection ($conn)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password_raw = $_POST['password'];

    // Validations
    if (empty($fullname) || strlen($fullname) < 3) {
        die("❌ Full name must be at least 3 characters.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("❌ Invalid email format.");
    }

    if (!preg_match("/^[0-9]{10}$/", $phone)) {
        die("❌ Phone number must be 10 digits.");
    }

    if (strlen($password_raw) < 6) {
        die("❌ Password must be at least 6 characters long.");
    }

    // Check duplicate email
    $check = $conn->prepare("SELECT id FROM users_info WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $check->close();
        // Email exists - don't register again
        die("❌ This email is already registered. Please login instead.");
    }
    $check->close();

    // Hash password and insert user
    $password = password_hash($password_raw, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users_info (fullname, email, phone, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fullname, $email, $phone, $password);

    if ($stmt->execute()) {
        // Redirect to login page with registered=1
        header("Location: login.php?registered=1");
        exit;
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
<h2>Register</h2>
<form method="POST" action="">
    <input type="text" name="fullname" placeholder="Full Name" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="text" name="phone" placeholder="Phone (10 digits)" required><br><br>
    <input type="password" name="password" placeholder="Password (min 6 chars)" required><br><br>
    <button type="submit">Register</button>
</form>
<p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>
