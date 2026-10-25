<?php
function e($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function head($title) {
  echo "<!DOCTYPE html><html><head><meta charset='utf-8'><title>" . e($title) . "</title></head><body>
  <a href='/techsupport/index.php'>Home</a> | <a href='/techsupport/tickets/index.php'>Tickets</a>
  <hr>
  <h2>" . e($title) . "</h2>";
}
function foot() { echo "</body></html>"; }
