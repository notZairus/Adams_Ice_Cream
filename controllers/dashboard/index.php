<?php
session_start();

view('dashboard/dashboard.view.php', [
  'heading' => 'Dashboard'
]);