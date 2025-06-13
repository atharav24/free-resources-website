<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];
$is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome Page</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>

<div class="container">
    <h2>Welcome, <?= htmlspecialchars($email) ?>!</h2>

    <?php if ($is_admin): ?>
        <p>You are logged in as <strong>Admin</strong>.</p>
        <a href="dashboard.php">Go to Admin Dashboard</a><br>
    <?php else: ?>
        <p>You are logged in as a <strong>User</strong>.</p>
        <!-- You can add user-specific links here -->
    <?php endif; ?>

    <a href="logout.php">Logout</a>
</div>

</body>
</html>
