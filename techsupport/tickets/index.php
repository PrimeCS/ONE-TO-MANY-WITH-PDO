<?php
require '../config/auth.php';
require_admin();
require '../config/db.php';
require '../config/layout.php';
head('Support Tickets');
echo "<a href='create.php'>+ Add ticket</a><br><br>";
$rows = $pdo->query("SELECT t.*, c.full_name, a.username AS added_name, u.username AS updated_name
  FROM tickets t
  JOIN clients c ON t.client_id = c.client_id
  LEFT JOIN users a ON t.added_by = a.user_id
  LEFT JOIN users u ON t.updated_by = u.user_id
  ORDER BY t.ticket_id DESC")->fetchAll();
echo "<table border='1' cellpadding='5'><tr><th>ID</th><th>Client</th><th>Type</th><th>Issue</th><th>Status</th><th>Date</th><th>Added by</th><th>Last updated by</th><th>Last updated</th><th>Actions</th></tr>";
foreach ($rows as $r) {
  echo "<tr><td>" . e($r['ticket_id']) . "</td><td>" . e($r['full_name']) . "</td><td>" . e($r['type']) . "</td><td>" . e($r['issue']) . "</td><td>" . e($r['status']) . "</td><td>" . e($r['date_created']) . "</td>
  <td>" . e($r['added_name']) . "</td><td>" . e($r['updated_name']) . "</td><td>" . e($r['last_updated']) . "</td><td>
  <a href='edit.php?id=" . e($r['ticket_id']) . "'>Edit</a>
  <form method='post' action='delete.php' onsubmit=\"return confirm('Delete this ticket?')\">
    <input type='hidden' name='id' value='" . e($r['ticket_id']) . "'>
    <button>Delete</button>
  </form></td></tr>";
}
echo "</table>";
foot();
