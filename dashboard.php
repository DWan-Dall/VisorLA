<?php
session_start();
ob_start();

include_once '../VisorLA/Application/core/Database.php';
include '../VisorLA/model/Visor.php';
include '../VisorLA/model/Admin.php';
include_once '../VisorLA/header.php';

if ((!isset($_SESSION['id'])) AND (!isset($_SESSION['setor']))) {
    $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Necessário estar logado para acessar essa página!</div>";
    header("Location: index.php");
}

$id = $_SESSION['id'];
$nome_usuario = $_SESSION['nome_usuario'];

$visor = New Visor();
$visores = $visor->listarVisores();
$valorVisorNormal = $visor->carregarVisores($id);
$valorVisorNormal = $valorVisorNormal->getN_chamado_normal();

$admin = New Admin();
$administrador = $admin->carregarDados('1');


$chamadoNormal = $_SESSION['n_chamado_normal'];
$chamadoPrioritario = $_SESSION['n_chamado_prioritario'];

if ($chamadoNormal != $valorVisorNormal) {
    $query_update = "UPDATE `acesso`
                        SET n_chamado_normal={$chamadoNormal}, ult_atualizacao_normal=now()
                        WHERE id={$id}";
    $result_update = $conn->prepare($query_update);
    $result_update->execute();
} else {
    $query_update = "UPDATE `acesso`
                        SET n_chamado_prioritario={$chamadoPrioritario}, ult_atualizacao_prioritario=now()
                        WHERE id={$id}";
    $result_update = $conn->prepare($query_update);
    $result_update->execute();
}

?>

<body>
<nav id="divHeader">
    <img src="public/images/BRASAO_REDIMENSIONADO.png" style="width: 8%">
    <h1 style="padding: 30px 20px;">Olá <?php echo $nome_usuario; ?>,</h1>
    <a class="underlineHover" id="sair-dashboard" href="sair.php">Sair</a>
</nav>

<?php
if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

if($_SESSION['setor'] != 'ADMINISTRAÇÃO') {?>
<div style="text-align: center; padding-top: 40px;">
<!--    <h2 style="color: #28a645">Atendimento NORMAL</h2>-->
    <h2>Atendimento NORMAL</h2>
    <br>
    <h3>Número atual: <?php echo $chamadoNormal; ?></h3>
    <form method="post" action="chamados.php">
        <button type="button" class="btn btn-info" id="chamarNovamente" style="color: white;">Chamar Novamente</button>
<!--        <input type="hidden" name="contador" value="--><?php //echo $chamadoNormal ?? 1; ?><!--">-->
        <button type="submit" name="normal" class="btn btn-success" id="chamarProximo">Chamar Próximo</button>
    </form>

</div>

    <?php
        if ($administrador->getAtivar_prioritario() == 1) {
            ?>
<div style="text-align: center; padding-top: 30px;">
<!--    <h2 style="color: #db3545">Atendimento PRIORITÁRIO</h2>-->
    <h2>Atendimento PRIORITÁRIO</h2>
    <br>
    <h3>Número atual: <?php echo $chamadoPrioritario; ?></h3>
    <form method="post" action="chamados.php">
        <button type="button" class="btn btn-info" id="chamarNovamentePrioritario" style="color: white;">Chamar Novamente</button>
<!--        <input type="hidden" name="contador" value="--><?php //echo $chamadoPrioritario ?? 1; ?><!--">-->
        <button type="submit" name="prioritario" class="btn btn-danger" id="chamarProximoPrioritario">Chamar Próximo</button>
    </form>
</div>
            <?php
            }
        ?>

<!--<div id="conteudo"></div>-->

<?php
}
    if($_SESSION['setor'] == 'ADMINISTRAÇÃO') {

        header("Location: dashboard-adm.php");
    }
    ?>

<!--Rodapé-->
<?php
include_once '../VisorLA/footer.php';
?>

