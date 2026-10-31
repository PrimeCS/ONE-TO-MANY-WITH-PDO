<?php
require '../config/auth.php';
require_admin();
require '../config/db.php';
require '../config/layout.php';
require '../config/types.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $pdo->prepare("UPDATE tickets SET client_id=?, type=?, issue=?, status=?, updated_by=?, last_updated=NOW() WHERE ticket_id=?");
  $stmt->execute([$_POST['client_id'], $_POST['type'], $_POST['issue'], $_POST['status'], $_SESSION['user_id'], $_POST['id']]);
  header('Location: index.php');
  exit;
}
$stmt = $pdo->prepare("SELECT * FROM tickets WHERE ticket_id=?");
$stmt->execute([$_GET['id'] ?? 0]);
$t = $stmt->fetch();
if (!$t) { die('Ticket not found'); }
$clients = $pdo->query("SELECT client_id, full_name FROM clients ORDER BY full_name")->fetchAll();
head('Edit Ticket');
?>
<form method="post">
  <input type="hidden" name="id" value="<?= e($t['ticket_id']) ?>">
  <label>Client</label><br>
  <select name="client_id" required>
    <?php foreach ($clients as $c): ?>
      <option value="<?= e($c['client_id']) ?>" <?= $c['client_id'] == $t['client_id'] ? 'selected' : '' ?>><?= e($c['full_name']) ?></option>
    <?php endforeach; ?>
  </select><br>
  <label>Type</label><br>
  <select name="type">
    <?php foreach ($ticket_types as $ty): ?>
      <option <?= $t['type'] === $ty ? 'selected' : '' ?>><?= $ty ?></option>
    <?php endforeach; ?>
  </select><br>
  <label>Issue</label><br><input name="issue" value="<?= e($t['issue']) ?>" required><br>
  <label>Status</label><br>
  <select name="status">
    <?php foreach (['Open','In Progress','Resolved'] as $s): ?>
      <option <?= $t['status'] === $s ? 'selected' : '' ?>><?= $s ?></option>
    <?php endforeach; ?>
  </select><br>
  <button>Update</button>
</form>
<?php foot();
