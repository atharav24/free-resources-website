<?php
session_start();

// Define your admin credentials here (replace with your real admin info)
define('ADMIN_USER', 'atharav_24');
define('ADMIN_EMAIL', 'atharavbadade24@gmail.com');
define('ADMIN_PHONE', '9689610209');
define('ADMIN_PASS', 'p@ss123'); // Plain text for demo; ideally hash this in production

// If admin is already logged in, redirect to dashboard
if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true) {
    header("Location: dashboard.php");
    exit;
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';

    if (
        $username === ADMIN_USER &&
        $email === ADMIN_EMAIL &&
        $phone === ADMIN_PHONE &&
        $password === ADMIN_PASS
    ) {
        $_SESSION['is_admin'] = true;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Access Denied. Invalid credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Admin Login</title>
    <link rel="stylesheet" href="admin.css" />
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>

        <?php if ($error): ?>
            <p class="error-msg"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required autofocus><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="text" name="phone" placeholder="Phone No" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
