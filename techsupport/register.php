<?php
require 'config/db.php';
require 'config/layout.php';
if (is_logged_in()) { header('Location: dashboard.php'); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  if ($_POST['password'] !== $_POST['confirm']) {
    $error = 'Passwords do not match.';
  } elseif (strlen($_POST['password']) < 6) {
    $error = 'Password must be at least 6 characters.';
  } else {
    $check = $pdo->prepare("SELECT user_id FROM users WHERE username = ? OR email = ?");
    $check->execute([$username, $_POST['email']]);
    if ($check->fetch()) {
      $error = 'Username or email is already taken.';
    } else {
      $pdo->beginTransaction();
      // everyone who registers here is a customer
      $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, address, age, email, username, password, role) VALUES (?, ?, ?, ?, ?, ?, ?, 'customer')");
      $stmt->execute([
        $_POST['first_name'], $_POST['last_name'], $_POST['address'], $_POST['age'],
        $_POST['email'], $username, password_hash($_POST['password'], PASSWORD_DEFAULT)
      ]);
      $uid = $pdo->lastInsertId();

      // a client record is created for this customer so their tickets can be linked to it
      $stmt = $pdo->prepare("INSERT INTO clients (full_name, email, added_by, updated_by, last_updated, user_id) VALUES (?, ?, ?, ?, NOW(), ?)");
      $stmt->execute([$_POST['first_name'] . ' ' . $_POST['last_name'], $_POST['email'], $uid, $uid, $uid]);
      $pdo->commit();

      header('Location: login.php?registered=1');
      exit;
    }
  }
}
head('Register');
if ($error) { echo "<p class='error'>" . e($error) . "</p>"; }
?>
<form method="post">
  <label>First name</label><br><input name="first_name" required><br>
  <label>Last name</label><br><input name="last_name" required><br>
  <label>Address</label><br><input name="address"><br>
  <label>Age</label><br><input name="age" type="number" min="1" max="120"><br>
  <label>Email</label><br><input name="email" type="email" required><br>
  <label>Username</label><br><input name="username" required><br>
  <label>Password</label><br><input name="password" type="password" required><br>
  <label>Confirm password</label><br><input name="confirm" type="password" required><br>
  <button>Register</button>
</form>
<p>Already have an account? <a href="login.php">Login</a></p>
<?php foot();
