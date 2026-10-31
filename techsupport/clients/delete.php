<?php
require '../config/auth.php';
require_admin();
require '../config/db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $pdo->prepare("DELETE FROM clients WHERE client_id=?");
  $stmt->execute([$_POST['id']]);
}
header('Location: index.php');
exit;
