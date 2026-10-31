<?php
require '../config/auth.php';
require_admin();
require '../config/db.php';
require '../config/layout.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $pdo->prepare("INSERT INTO clients (full_name, email, phone, added_by, updated_by, last_updated) VALUES (?, ?, ?, ?, ?, NOW())");
  $stmt->execute([$_POST['full_name'], $_POST['email'], $_POST['phone'], $_SESSION['user_id'], $_SESSION['user_id']]);
  header('Location: index.php');
  exit;
}
head('Add Client');
?>
<form method="post">
  <label>Full name</label><br><input name="full_name" required><br>
  <label>Email</label><br><input name="email" type="email"><br>
  <label>Phone</label><br><input name="phone"><br>
  <button>Save</button>
</form>
<?php foot();
