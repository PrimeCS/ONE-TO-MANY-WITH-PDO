<?php
require '../config/db.php';
require '../config/layout.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $pdo->prepare("UPDATE clients SET full_name=?, email=?, phone=? WHERE client_id=?");
  $stmt->execute([$_POST['full_name'], $_POST['email'], $_POST['phone'], $_POST['id']]);
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
  <label>Full name</label><input name="full_name" value="<?= e($c['full_name']) ?>" required>
  <label>Email</label><input name="email" type="email" value="<?= e($c['email']) ?>">
  <label>Phone</label><input name="phone" value="<?= e($c['phone']) ?>">
  <button>Update</button>
</form>
<?php foot();
