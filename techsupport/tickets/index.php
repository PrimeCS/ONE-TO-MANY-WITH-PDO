<?php
require '../config/db.php';
require '../config/layout.php';
head('Support Tickets');
echo "<a href='create.php'>+ Add ticket</a><br><br>";
$rows = $pdo->query("SELECT t.*, c.full_name FROM tickets t JOIN clients c ON t.client_id = c.client_id ORDER BY t.ticket_id DESC")->fetchAll();
echo "<table border='1' cellpadding='5'><tr><th>ID</th><th>Client</th><th>Issue</th><th>Status</th><th>Date</th><th>Actions</th></tr>";
foreach ($rows as $r) {
  echo "<tr><td>" . e($r['ticket_id']) . "</td><td>" . e($r['full_name']) . "</td><td>" . e($r['issue']) . "</td><td>" . e($r['status']) . "</td><td>" . e($r['date_created']) . "</td><td>
  <a href='edit.php?id=" . e($r['ticket_id']) . "'>Edit</a>
  <form method='post' action='delete.php' onsubmit=\"return confirm('Delete this ticket?')\">
    <input type='hidden' name='id' value='" . e($r['ticket_id']) . "'>
    <button>Delete</button>
  </form></td></tr>";
}
echo "</table>";
foot();
