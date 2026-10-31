<?php
require_once __DIR__ . '/auth.php';

function e($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

function head($title) {
  echo "<!DOCTYPE html><html><head><meta charset='utf-8'><title>" . e($title) . "</title>
  <style>
    body { font-family: Helvetica, Arial, sans-serif; color: #222; max-width: 900px; margin: 0 auto; padding: 0 20px; }
    .top { display: flex; justify-content: space-between; align-items: center; padding: 20px 0; border-bottom: 1px solid #ddd; }
    .logo { letter-spacing: 3px; font-size: 12px; color: #888; text-decoration: none; margin-left: 0 !important; }
    .top a { color: #222; text-decoration: none; margin-left: 20px; font-size: 14px; }
    .top a:hover { text-decoration: underline; }
    .who { font-size: 14px; color: #888; margin-left: 20px; }
    h2 { font-weight: normal; margin: 30px 0 20px; }
    input, select, textarea { padding: 6px; margin: 4px 0 12px; width: 300px; font-family: inherit; }
    table { border-collapse: collapse; }
    th, td { font-size: 14px; }
    .error { color: #222; border: 1px solid #222; padding: 8px; width: 300px; }
    .step { border-top: 1px solid #ddd; padding: 12px 0; }
  </style></head><body>
  <div class='top'>
    <a class='logo' href='/techsupport/index.php'>SUPPORT DESK</a>
    <span>";
  if (is_admin()) {
    echo "<a href='/techsupport/dashboard.php'>Dashboard</a>
      <a href='/techsupport/tickets/index.php'>Tickets</a>
      <span class='who'>" . e($_SESSION['username']) . " (admin)</span>
      <a href='/techsupport/logout.php'>Logout</a>";
  } elseif (is_logged_in()) {
    echo "<a href='/techsupport/customer/index.php'>Home</a>
      <a href='/techsupport/customer/tickets.php'>My Tickets</a>
      <a href='/techsupport/customer/submit.php'>Submit</a>
      <span class='who'>" . e($_SESSION['username']) . "</span>
      <a href='/techsupport/logout.php'>Logout</a>";
  } else {
    echo "<a href='/techsupport/login.php'>Login</a>
      <a href='/techsupport/register.php'>Register</a>";
  }
  echo "</span>
  </div>
  <h2>" . e($title) . "</h2>";
}

function foot() {
  echo "<hr><small>Tech Support System</small></body></html>";
}
