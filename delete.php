<?php
session_start();
require 'config.php'; // Make sure this defines $conn (MySQLi)

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: adminlogin.php");
    exit;
}

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $conn->prepare("DELETE FROM users_info WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "User deleted successfully.";
    } else {
        $_SESSION['message'] = "Error deleting user: " . $stmt->error;
    }

    $stmt->close();
} else {
    $_SESSION['message'] = "No user ID specified.";
}

header("Location: dashboard.php");
exit;
?>
