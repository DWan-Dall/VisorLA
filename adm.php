<?php
include_once '../VisorLA/Application/core/Database.php';
include '../VisorLA/model/Visor.php';

session_start();
ob_start();

$visor = new Visor();

if (isset($_POST['zerar-normal'])){
    $id = $_POST['zerar-normal'];
    $visorNormal = $visor->carregarVisores($id);
    $zerarNormal = $visorNormal->getN_chamado_normal();
    $zerarNormal -= $zerarNormal;
    $visorNormal = intval($visorNormal->setN_chamado_normal($zerarNormal));

    $query_update = "UPDATE `acesso`
                        SET n_chamado_normal={$visorNormal}, ult_atualizacao_normal=now()
                        WHERE id={$id}";
    $result_update = $conn->prepare($query_update);
    $result_update->execute();

    header("Location: dashboard.php");
}

if (isset($_POST["editar-normal"])){


    header("Location: dashboard.php");
}

if (isset($_POST['zerar-prioritario'])){
    $id = $_POST['zerar-prioritario'];
    $visorPrioritario = $visor->carregarVisores($id);
    $zerarPrioritario = $visorPrioritario->getN_chamado_prioritario();
    $zerarPrioritario -= $zerarPrioritario;
    $visorPrioritario = intval($visorPrioritario->setN_chamado_prioritario($zerarPrioritario));
    var_dump($visorPrioritario);

    $query_update = "UPDATE `acesso`
                        SET n_chamado_prioritario={$visorPrioritario}, ult_atualizacao_prioritario=now()
                        WHERE id={$id}";
    $result_update = $conn->prepare($query_update);
    $result_update->execute();
    header("Location: dashboard.php");
}