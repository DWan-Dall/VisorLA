<?php
session_start();
ob_start();
unset($_SESSION['id'], $_SESSION['setor'], $_SESSION['nome_usuario']);

header("Location: index.php");
