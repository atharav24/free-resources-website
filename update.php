<?php
session_start();
require 'config.php'; // should define $conn (MySQLi)

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: adminlogin.php");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "User ID is required.";
    exit;
}

// Fetch user data
$stmt = $conn->prepare("SELECT * FROM users_info WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    echo "User not found.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $update = $conn->prepare("UPDATE users_info SET fullname = ?, email = ?, phone = ? WHERE id = ?");
    $update->bind_param("sssi", $fullname, $email, $phone, $id);

    if ($update->execute()) {
        $_SESSION['message'] = "User updated successfully.";
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Update failed: " . $update->error;
    }

    $update->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
</head>
<body>
<h2>Update User</h2>
<form method="POST">
    <input type="text" name="fullname" value="<?= htmlspecialchars($user['fullname']) ?>" required><br><br>
    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required><br><br>
    <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required><br><br>
    <button type="submit">Update</button>
</form>
<a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
