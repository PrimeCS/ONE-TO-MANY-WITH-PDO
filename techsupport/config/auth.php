<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

function is_logged_in() {
  return isset($_SESSION['user_id']);
}

function is_admin() {
  return is_logged_in() && ($_SESSION['role'] ?? '') === 'admin';
}

// any logged in user
function require_login() {
  if (!is_logged_in()) {
    header('Location: /techsupport/login.php');
    exit;
  }
}

// admin only pages (clients, tickets management, dashboard)
function require_admin() {
  require_login();
  if (!is_admin()) {
    header('Location: /techsupport/customer/index.php');
    exit;
  }
}

// customer only pages (submit ticket, my tickets)
function require_customer() {
  require_login();
  if (is_admin()) {
    header('Location: /techsupport/dashboard.php');
    exit;
  }
}
