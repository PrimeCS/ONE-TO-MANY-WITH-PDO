<?php
require '../config/db.php';
require '../config/layout.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $pdo->prepare("UPDATE tickets SET client_id=?, issue=?, status=? WHERE ticket_id=?");
  $stmt->execute([$_POST['client_id'], $_POST['issue'], $_POST['status'], $_POST['id']]);
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
  <label>Client</label>
  <select name="client_id" required>
    <?php foreach ($clients as $c): ?>
      <option value="<?= e($c['client_id']) ?>" <?= $c['client_id'] == $t['client_id'] ? 'selected' : '' ?>><?= e($c['full_name']) ?></option>
    <?php endforeach; ?>
  </select>
  <label>Issue</label><input name="issue" value="<?= e($t['issue']) ?>" required>
  <label>Status</label>
  <select name="status">
    <?php foreach (['Open','In Progress','Resolved'] as $s): ?>
      <option <?= $t['status'] === $s ? 'selected' : '' ?>><?= $s ?></option>
    <?php endforeach; ?>
  </select>
  <button>Update</button>
</form>
<?php foot();
