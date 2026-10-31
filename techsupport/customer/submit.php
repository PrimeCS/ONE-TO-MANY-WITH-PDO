<?php
require '../config/auth.php';
require_customer();
require '../config/db.php';
require '../config/layout.php';
require '../config/types.php';

$uid = $_SESSION['user_id'];
$error = '';
$type = '';
$issue = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $type = $_POST['type'] ?? '';
  $issue = trim($_POST['issue'] ?? '');

  // type must be chosen from the list and the issue must not be empty
  if (!in_array($type, $ticket_types, true) || $issue === '') {
    $error = 'Invalid type - please choose a type or issue.';
  } else {
    // find this customer's client record
    $stmt = $pdo->prepare("SELECT client_id FROM clients WHERE user_id = ?");
    $stmt->execute([$uid]);
    $client_id = $stmt->fetchColumn();

    // if it was deleted by the admin, make a new one
    if (!$client_id) {
      $u = $pdo->prepare("SELECT first_name, last_name, email FROM users WHERE user_id = ?");
      $u->execute([$uid]);
      $user = $u->fetch();
      $ins = $pdo->prepare("INSERT INTO clients (full_name, email, added_by, updated_by, last_updated, user_id) VALUES (?, ?, ?, ?, NOW(), ?)");
      $ins->execute([$user['first_name'] . ' ' . $user['last_name'], $user['email'], $uid, $uid, $uid]);
      $client_id = $pdo->lastInsertId();
    }

    $stmt = $pdo->prepare("INSERT INTO tickets (client_id, type, issue, status, date_created, added_by, updated_by, last_updated) VALUES (?, ?, ?, 'Open', CURDATE(), ?, ?, NOW())");
    $stmt->execute([$client_id, $type, $issue, $uid, $uid]);
    header('Location: tickets.php?sent=1');
    exit;
  }
}
head('Submit a Request');
if ($error) { echo "<p class='error'>" . e($error) . "</p>"; }
?>
<form method="post">
  <label>Type</label><br>
  <select name="type">
    <option value="">-- choose a type --</option>
    <?php foreach ($ticket_types as $t): ?>
      <option value="<?= e($t) ?>" <?= $type === $t ? 'selected' : '' ?>><?= e($t) ?></option>
    <?php endforeach; ?>
  </select><br>
  <label>Describe your issue</label><br>
  <textarea name="issue" rows="5" maxlength="255"><?= e($issue) ?></textarea><br>
  <button>Send</button>
</form>
<?php foot();
