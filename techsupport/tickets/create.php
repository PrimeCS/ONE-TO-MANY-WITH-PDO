<?php
require '../config/db.php';
require '../config/layout.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $pdo->prepare("INSERT INTO tickets (client_id, issue, status, date_created) VALUES (?, ?, ?, CURDATE())");
  $stmt->execute([$_POST['client_id'], $_POST['issue'], $_POST['status']]);
  header('Location: index.php');
  exit;
}
$clients = $pdo->query("SELECT client_id, full_name FROM clients ORDER BY full_name")->fetchAll();
head('Add Ticket');
?>
<form method="post">
  <label>Client</label>
  <select name="client_id" required>
    <option value="">-- choose client --</option>
    <?php foreach ($clients as $c): ?>
      <option value="<?= e($c['client_id']) ?>"><?= e($c['full_name']) ?></option>
    <?php endforeach; ?>
  </select>
  <label>Issue</label><input name="issue" required>
  <label>Status</label>
  <select name="status"><option>Open</option><option>In Progress</option><option>Resolved</option></select>
  <button>Save</button>
</form>
<?php foot();
