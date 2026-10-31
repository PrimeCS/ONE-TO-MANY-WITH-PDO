<?php
require '../config/auth.php';
require_customer();
require '../config/db.php';
require '../config/layout.php';
head('Welcome, ' . $_SESSION['first_name']);

$stmt = $pdo->prepare("SELECT COUNT(*) AS total, SUM(t.status <> 'Resolved') AS open_count
  FROM tickets t JOIN clients c ON t.client_id = c.client_id WHERE c.user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$count = $stmt->fetch();
$total = (int)$count['total'];
$open = (int)$count['open_count'];
?>

<p>
  This is your support page. If something is wrong with your computer, internet,
  or software, you can report it here and follow the progress until it is fixed.
</p>

<div style="max-width: 450px; display: flex; gap: 40px; border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; padding: 20px 0; margin: 20px 0;">
  <div>
    <div style="font-size: 32px;"><?= $total ?></div>
    <div style="font-size: 12px; color: #888;">Requests sent</div>
  </div>
  <div>
    <div style="font-size: 32px;"><?= $open ?></div>
    <div style="font-size: 12px; color: #888;">Still open</div>
  </div>
</div>

<p>
  <a href="submit.php"><button>Submit a request</button></a>
  <a href="tickets.php"><button>View my tickets</button></a>
</p>

<h3 style="font-weight: normal; margin-top: 40px;">What is a ticket?</h3>

<p>
  Every request you send is saved as a <b>ticket</b>. In our database, tickets are the
  <b>child entity</b>. Your account is linked to your own client record, and one client
  can have many tickets. That means you can send as many requests as you need, and
  each one belongs to you and shows up only in your list.
</p>

<div class="step"><b>Type:</b> what kind of problem it is: Hardware Failures, Software Crashes, Connectivity Issues, a Complaint, or Others.</div>
<div class="step"><b>Issue:</b> your own description of what happened.</div>
<div class="step"><b>Status:</b> Open (received), In Progress (being worked on), or Resolved (done).</div>
<div class="step"><b>Dates:</b> when you sent it and when it was last updated by our team.</div>

<h3 style="font-weight: normal; margin-top: 40px;">How this website works for you</h3>

<div class="step"><b>1.</b> Click <b>Submit a request</b> and choose a type.</div>
<div class="step"><b>2.</b> Describe your problem and send it. It is saved as a new ticket with the status Open.</div>
<div class="step"><b>3.</b> Our admin reads it and changes its status as the work moves forward.</div>
<div class="step"><b>4.</b> Check <b>My Tickets</b> any time to see the latest status.</div>

<p style="color: #888; font-size: 14px; margin-top: 30px;">
  Customers can only send and view their own requests. Editing and deleting records is done by the admin.
</p>

<?php foot(); ?>
