<?php
require '../config/auth.php';
require_admin();
require '../config/db.php';
require '../config/layout.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $pdo->prepare("UPDATE clients SET full_name=?, email=?, phone=?, updated_by=?, last_updated=NOW() WHERE client_id=?");
  $stmt->execute([$_POST['full_name'], $_POST['email'], $_POST['phone'], $_SESSION['user_id'], $_POST['id']]);
  header('Location: index.php');
  exit;
}
$stmt = $pdo->prepare("SELECT * FROM clients WHERE client_id=?");
$stmt->execute([$_GET['id'] ?? 0]);
$c = $stmt->fetch();
if (!$c) { die('Client not found'); }
head('Edit Client');
?>
<form method="post">
  <input type="hidden" name="id" value="<?= e($c['client_id']) ?>">
  <label>Full name</label><br><input name="full_name" value="<?= e($c['full_name']) ?>" required><br>
  <label>Email</label><br><input name="email" type="email" value="<?= e($c['email']) ?>"><br>
  <label>Phone</label><br><input name="phone" value="<?= e($c['phone']) ?>"><br>
  <button>Update</button>
</form>
<?php foot();
