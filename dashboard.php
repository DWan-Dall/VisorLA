<?php
session_start();
ob_start();
include_once '../VisorLA/Application/core/Database.php';

if ((!isset($_SESSION['id'])) AND (!isset($_SESSION['local']))) {
    $_SESSION['msg'] = "<p style='color: #ff0000'>Necessário estar logado para acessar essa página!</p>";
    header("Location: index.php");
}

$id = $_SESSION['id'];
$chamadoNormal = $_SESSION['n_chamado_normal'];
$chamadoPrioritario = $_SESSION['n_chamado_prioritario'];

    $query_update = "UPDATE `acesso`
                        SET n_chamado_normal={$chamadoNormal}, n_chamado_prioritario={$chamadoPrioritario}, ult_atualizacao=now()
                        WHERE id={$id}";
    $result_update = $conn->prepare($query_update);
    $result_update->execute();

?>
<!DOCTYPE html>
<html lang="br">
<head>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<style>
    h3 {
        color: #6c757d;
    }
</style>
<body>
<header>
    <div>
<!--            <div style="background-color: #cbd7c2; color: rgba(138,142,145,0.98)">-->
        <span style="display: inline;">
            <h1>Olá, <?php echo $_SESSION['local']; ?></h1>
            <a href="sair.php">Sair</a>
        </span>
    </div>
</header>
<div style="text-align: center; padding-top: 70px;">
    <h2 style="color: #28a645">Atendimento NORMAL</h2>
    <br>
    <h3>Número atual: <?php echo $chamadoNormal; ?></h3>
    <form method="post" action="chamados.php">
        <button type="button" class="btn btn-info">Chamar Novamente</button>
        <input type="hidden" name="contador" value="<?php echo $chamadoNormal ?? 1; ?>">
        <button type="submit" name="normal" class="btn btn-success">Chamar Próximo</button>
    </form>

</div>
<div style="text-align: center; padding-top: 70px;">
    <h2 style="color: #db3545">Atendimento PRIORITÁRIO</h2>
    <br>
    <h3>Número atual: <?php echo $chamadoPrioritario; ?></h3>
    <form method="post" action="chamados.php">
        <button type="button" class="btn btn-info">Chamar Novamente</button>
        <input type="hidden" name="contador" value="<?php echo $chamadoPrioritario ?? 1; ?>">
        <button type="submit" name="prioritario" class="btn btn-danger">Chamar Próximo</button>
    </form>
</div>

<?php
    if($_SESSION['local'] == 'ADMINISTRAÇÃO') {
        echo 'Administrador, ';
        echo 'criar zerador do visor';
        echo 'consegue ver e chamar ambos chamados';
    }

?>

<img src="public/images/Footer%20Luiz%20Alves.png" style="margin-left: 5%; opacity: 38%;">
<footer class="footer mt-4 pt-4 pt-md-4 border-top">
    <div class="col-12 col-md text-center">
        <small class="d-block mb-3 text-muted">
            &copy; <?php echo (new DateTime('now'))->format('Y'); ?> - Desenvolvido por Irmãos Wan-Dall
        </small>
    </div>
</footer>

<!--Esse som será apenas ao trocar qualquer dado no visor-->

<!--<script>-->
<!--    const sound = new Audio('public/sounds/chamada.mp3')-->
<!--    document.querySelector('button, submit').addEventListener('click', () => {-->
<!--        sound.play();-->
<!--    });-->
<!--</script>-->
</body>
</html>