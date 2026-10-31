<?php
require '../config/auth.php';
require_customer();
require '../config/db.php';
require '../config/layout.php';
head('My Tickets');

if (isset($_GET['sent'])) { echo "<p>Your request was sent. We will get back to you soon.</p>"; }
echo "<a href='submit.php'>+ Submit a ticket or complaint</a><br><br>";

$stmt = $pdo->prepare("SELECT t.* FROM tickets t
  JOIN clients c ON t.client_id = c.client_id
  WHERE c.user_id = ?
  ORDER BY t.ticket_id DESC");
$stmt->execute([$_SESSION['user_id']]);
$rows = $stmt->fetchAll();

if (!$rows) {
  echo "<p>You have not sent anything yet.</p>";
} else {
  echo "<table border='1' cellpadding='5'><tr><th>ID</th><th>Type</th><th>Issue</th><th>Status</th><th>Date sent</th><th>Last updated</th></tr>";
  foreach ($rows as $r) {
    echo "<tr><td>" . e($r['ticket_id']) . "</td><td>" . e($r['type']) . "</td><td>" . e($r['issue']) . "</td><td>" . e($r['status']) . "</td><td>" . e($r['date_created']) . "</td><td>" . e($r['last_updated']) . "</td></tr>";
  }
  echo "</table>";
}
foot();
