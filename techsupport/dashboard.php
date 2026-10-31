<?php
require 'config/auth.php';
require_login();
if (!is_admin()) { header('Location: customer/index.php'); exit; }
require 'config/db.php';
require 'config/layout.php';
head('Admin Dashboard');

$clients = $pdo->query("SELECT COUNT(*) FROM clients")->fetchColumn();
$open = $pdo->query("SELECT COUNT(*) FROM tickets WHERE status <> 'Resolved' AND type <> 'Complaint'")->fetchColumn();
$complaints = $pdo->query("SELECT COUNT(*) FROM tickets WHERE status <> 'Resolved' AND type = 'Complaint'")->fetchColumn();
?>

<p>
  Welcome, <?= e($_SESSION['first_name']) ?>. This is the control center of the support desk.
  From here you manage every client and every request sent to the system.
</p>

<div style="max-width: 450px; display: flex; gap: 40px; border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; padding: 20px 0; margin: 20px 0;">
  <div>
    <div style="font-size: 32px;"><?= $clients ?></div>
    <div style="font-size: 12px; color: #888;">Clients</div>
  </div>
  <div>
    <div style="font-size: 32px;"><?= $open ?></div>
    <div style="font-size: 12px; color: #888;">Open tickets</div>
  </div>
  <div>
    <div style="font-size: 32px;"><?= $complaints ?></div>
    <div style="font-size: 12px; color: #888;">Open complaints</div>
  </div>
</div>

<p>
  <a href="clients/index.php"><button>Manage Clients</button></a>
  <a href="tickets/index.php"><button>Manage Tickets</button></a>
</p>

<h3 style="font-weight: normal; margin-top: 40px;">What is a client?</h3>

<p>
  A <b>client</b> is a person who receives support. In our database, clients are the
  <b>parent entity</b>: the &quot;one&quot; side of the one-to-many relationship. One client can
  have many tickets, and every ticket must belong to exactly one client.
</p>

<div class="step"><b>Customers:</b> every customer who registers on the website automatically gets a client record.</div>
<div class="step"><b>Walk-in clients:</b> you can also add clients yourself, for people who did not register.</div>
<div class="step"><b>Deleting a client</b> also deletes all of that client's tickets, so the database never keeps tickets without an owner.</div>
<div class="step"><b>Tracking:</b> every record shows who added it, who last updated it, and when.</div>

<h3 style="font-weight: normal; margin-top: 40px;">How this website works for you</h3>

<div class="step"><b>1.</b> Customers register and send tickets or complaints.</div>
<div class="step"><b>2.</b> Open <b>Manage Tickets</b> to read new requests and change their status: Open, In Progress, or Resolved.</div>
<div class="step"><b>3.</b> Use <b>Manage Clients</b> to add, edit, or delete client records (the parent entity).</div>
<div class="step"><b>4.</b> Admins have full access. Customers can only send and view their own requests.</div>

<?php foot(); ?>
