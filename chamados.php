<?php
session_start();
ob_start();

if (isset($_POST["normal"])){
    $_SESSION['n_chamado_normal'] +=1;
//    header('Location: http://localhost:63342/VisorLA/visor.php?res=01');
        header("Location: dashboard.php");
}

if (isset($_POST["prioritario"])){
    $_SESSION['n_chamado_prioritario'] +=1;
    header("Location: dashboard.php");
}
