<?php
session_start();
require 'config.php';

// Only admin can access this page
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: login.php");
    exit;
}

// Fetch all users
$stmt = $conn->prepare("SELECT id, fullname, email, phone FROM users_info WHERE role != 'admin'");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - User Management</title>
  <link rel="stylesheet" href="dashboard.css">
</head>
<body>

<div class="dashboard-container">
  <div class="navbar">
    <h1>User Management</h1>
    <div class="nav-links">
      <a href="index.html">Go to Website</a>
      <a href="logout.php" class="logout-btn">Logout</a>
    </div>
  </div>

  <?php if (isset($_SESSION['message'])): ?>
    <div class="msg"><?php echo htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?></div>
  <?php endif; ?>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($user = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $user['id'] ?></td>
        <td><?= htmlspecialchars($user['fullname']) ?></td>
        <td><?= htmlspecialchars($user['email']) ?></td>
        <td><?= htmlspecialchars($user['phone']) ?></td>
        <td>
          <a href="update.php?id=<?= $user['id'] ?>">Edit</a> |
          <a href="delete.php?id=<?= $user['id'] ?>" onclick="return confirm('Delete this user?')">Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

</body>
</html>
