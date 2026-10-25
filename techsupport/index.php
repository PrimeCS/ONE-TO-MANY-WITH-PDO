<?php
require 'config/db.php';
require 'config/layout.php';
head('');

$clients = $pdo->query("SELECT COUNT(*) FROM clients")->fetchColumn();
$open = $pdo->query("SELECT COUNT(*) FROM tickets WHERE status <> 'Resolved'")->fetchColumn();
?>

<div style="max-width: 400px; margin: 60px auto; font-family: Helvetica, Arial, sans-serif; color: #222;">

  <p style="letter-spacing: 3px; font-size: 24px; color: #888;">TECH SUPPORT DESK</p>

  <div style="display: flex; gap: 40px; border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; padding: 20px 0; margin: 20px 0;">
    <div>
      <div style="font-size: 32px;"><?= $clients ?></div>
      <div style="font-size: 12px; color: #888;">Clients</div>
    </div>
    <div>
      <div style="font-size: 32px;"><?= $open ?></div>
      <div style="font-size: 12px; color: #888;">Open tickets</div>
    </div>
  </div>

  <a href="clients/index.php" style="color: #222; margin-right: 20px;">Clients</a>
  <a href="tickets/index.php" style="color: #222;">Tickets</a>

</div>

<?php foot(); ?>