<?php
require '../config/auth.php';
require_admin();
require '../config/db.php';
require '../config/layout.php';
head('Clients');
echo "<a href='create.php'>+ Add client</a><br><br>";
$rows = $pdo->query("SELECT c.*, a.username AS added_name, u.username AS updated_name
  FROM clients c
  LEFT JOIN users a ON c.added_by = a.user_id
  LEFT JOIN users u ON c.updated_by = u.user_id
  ORDER BY c.client_id DESC")->fetchAll();
echo "<table border='1' cellpadding='5'><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Added by</th><th>Last updated by</th><th>Last updated</th><th>Actions</th></tr>";
foreach ($rows as $r) {
  echo "<tr><td>" . e($r['client_id']) . "</td><td>" . e($r['full_name']) . "</td><td>" . e($r['email']) . "</td><td>" . e($r['phone']) . "</td>
  <td>" . e($r['added_name']) . "</td><td>" . e($r['updated_name']) . "</td><td>" . e($r['last_updated']) . "</td><td>
  <a href='edit.php?id=" . e($r['client_id']) . "'>Edit</a>
  <form method='post' action='delete.php' onsubmit=\"return confirm('Delete this client and all their tickets?')\">
    <input type='hidden' name='id' value='" . e($r['client_id']) . "'>
    <button>Delete</button>
  </form></td></tr>";
}
echo "</table>";
foot();
