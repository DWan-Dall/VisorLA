<?php

session_start();
ob_start();

if (isset($_POST["normal"])){
    $_SESSION['n_chamado_normal']+=1;
    echo $_SESSION['n_chamado_normal'];
    header("Location: dashboard.php");
}

if (isset($_POST["prioritario"])){
    $_SESSION['n_chamado_prioritario']+=1;
    echo $_SESSION['n_chamado_prioritario'];
    header("Location: dashboard.php");
}
