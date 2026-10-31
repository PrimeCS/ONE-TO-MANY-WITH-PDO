<?php
require 'config/db.php';
require 'config/layout.php';
if (is_logged_in()) { header('Location: dashboard.php'); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->execute([trim($_POST['username'])]);
  $user = $stmt->fetch();
  if ($user && password_verify($_POST['password'], $user['password'])) {
    session_regenerate_id(true);
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['first_name'] = $user['first_name'];
    $_SESSION['role'] = $user['role'];
    if ($user['role'] === 'admin') {
      header('Location: dashboard.php');
    } else {
      header('Location: customer/index.php');
    }
    exit;
  }
  $error = 'Wrong username or password.';
}
head('Login');
if (isset($_GET['registered'])) { echo "<p>Account created. You can log in now.</p>"; }
if ($error) { echo "<p class='error'>" . e($error) . "</p>"; }
?>
<form method="post">
  <label>Username</label><br><input name="username" required><br>
  <label>Password</label><br><input name="password" type="password" required><br>
  <button>Login</button>
</form>
<p>No account yet? <a href="register.php">Register</a></p>
<?php foot();
