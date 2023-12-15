<?php
include_once '../VisorLA/Application/core/Database.php';
include '../VisorLA/model/Visor.php';
include '../VisorLA/model/Admin.php';

session_start();
ob_start();

$visor = new Visor();
$admin = new Admin();



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

    $query_update = "UPDATE `acesso`
                        SET n_chamado_prioritario={$visorPrioritario}, ult_atualizacao_prioritario=now()
                        WHERE id={$id}";
    $result_update = $conn->prepare($query_update);
    $result_update->execute();

//    $usuario_adm = $visor->getUsuario_adm();
//    if ($_SESSION != $usuario_adm) {
//        ob_start();
//    }

    header("Location: dashboard.php");
}

$botao_ativar = $_POST['ligar_prioritario'];
var_dump($botao_ativar);

$administrador = $admin->carregarDados(1);
$visorPrioritario = $administrador->getAtivar_prioritario();

var_dump($visorPrioritario);

if (isset($_POST['ligar_prioritario'])) {
    $administrador = $admin->carregarDados(1);
    $visorPrioritario = $administrador->getAtivar_prioritario();


}

