<?php
require '../config/db.php';
require '../config/layout.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $pdo->prepare("INSERT INTO clients (full_name, email, phone) VALUES (?, ?, ?)");
  $stmt->execute([$_POST['full_name'], $_POST['email'], $_POST['phone']]);
  header('Location: index.php');
  exit;
}
head('Add Client');
?>
<form method="post">
  <label>Full name</label><input name="full_name" required>
  <label>Email</label><input name="email" type="email">
  <label>Phone</label><input name="phone">
  <button>Save</button>
</form>
<?php foot();
