<?php
session_start();
unset($_SESSION['user_id']);
unset($_SESSION['username']);
session_destroy();
if ($_GET['logout'] == 1) {
    header('Location: index.php?logout=2');
} else
    header('Location: index.php?logout=1');
