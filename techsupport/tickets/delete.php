<?php
require '../config/db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $pdo->prepare("DELETE FROM tickets WHERE ticket_id=?");
  $stmt->execute([$_POST['id']]);
}
header('Location: index.php');
exit;
