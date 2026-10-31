<?php
require '../config/auth.php';
require_admin();
require '../config/db.php';
require '../config/layout.php';
require '../config/types.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $pdo->prepare("INSERT INTO tickets (client_id, type, issue, status, date_created, added_by, updated_by, last_updated) VALUES (?, ?, ?, ?, CURDATE(), ?, ?, NOW())");
  $stmt->execute([$_POST['client_id'], $_POST['type'], $_POST['issue'], $_POST['status'], $_SESSION['user_id'], $_SESSION['user_id']]);
  header('Location: index.php');
  exit;
}
$clients = $pdo->query("SELECT client_id, full_name FROM clients ORDER BY full_name")->fetchAll();
head('Add Ticket');
?>
<form method="post">
  <label>Client</label><br>
  <select name="client_id" required>
    <option value="">-- choose client --</option>
    <?php foreach ($clients as $c): ?>
      <option value="<?= e($c['client_id']) ?>"><?= e($c['full_name']) ?></option>
    <?php endforeach; ?>
  </select><br>
  <label>Type</label><br>
  <select name="type">
    <?php foreach ($ticket_types as $ty): ?>
      <option><?= e($ty) ?></option>
    <?php endforeach; ?>
  </select><br>
  <label>Issue</label><br><input name="issue" required><br>
  <label>Status</label><br>
  <select name="status"><option>Open</option><option>In Progress</option><option>Resolved</option></select><br>
  <button>Save</button>
</form>
<?php foot();
