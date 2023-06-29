<?php
session_start();
ob_start();
unset($_SESSION['id'], $_SESSION['local']);

header("Location: index.php");
