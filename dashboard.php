<?php
session_start();
ob_start();
include_once '../VisorLA/Application/core/Database.php';
include '../VisorLA/model/Visor.php';

if ((!isset($_SESSION['id'])) AND (!isset($_SESSION['local']))) {
    $_SESSION['msg'] = "<p style='color: #ff0000'>Necessário estar logado para acessar essa página!</p>";
    header("Location: index.php");
}

$id = $_SESSION['id'];
$visor = New Visor();
$valorVisorNormal = $visor->carregarVisores($id);
$valorVisorNormal = $valorVisorNormal->getN_chamado_normal();

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
<!DOCTYPE html>
<html lang="br">
<head>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="style.css" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<!--    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<style>
    h3 {
        color: #6c757d;
    }
    nav {
        display: flex;
    }
</style>
<body>
<nav id="divHeader">
    <img src="public/images/BRASAO_REDIMENSIONADO.png" style="width: 8%;">
    <h1 style="padding: 30px 20px;">Olá, <?php echo $_SESSION['local']; ?></h1>
    <a class="underlineHover" id="sair-dashboard" href="sair.php">Sair</a>
</nav>
<div style="text-align: center; padding-top: 40px;">
    <h2 style="color: #28a645">Atendimento NORMAL</h2>
    <br>
    <h3>Número atual: <?php echo $chamadoNormal; ?></h3>
    <form method="post" action="chamados.php">
        <button type="button" class="btn btn-info" id="chamarNovamente">Chamar Novamente</button>
        <input type="hidden" name="contador" value="<?php echo $chamadoNormal ?? 1; ?>">
        <button type="submit" name="normal" class="btn btn-success" id="chamarProximo">Chamar Próximo</button>
    </form>

</div>
<div style="text-align: center; padding-top: 30px;">
    <h2 style="color: #db3545">Atendimento PRIORITÁRIO</h2>
    <br>
    <h3>Número atual: <?php echo $chamadoPrioritario; ?></h3>
    <form method="post" action="chamados.php">
        <button type="button" class="btn btn-info" id="chamarNovamente">Chamar Novamente</button>
        <input type="hidden" name="contador" value="<?php echo $chamadoPrioritario ?? 1; ?>">
        <button type="submit" name="prioritario" class="btn btn-danger" id="chamarProximoPrioritario">Chamar Próximo</button>
    </form>
</div>

<div id="conteudo"></div>

<?php
    if($_SESSION['local'] == 'ADMINISTRAÇÃO') {
        echo 'Administrador, ';
        echo 'criar zerador do visor';
        echo ' consegue ver e chamar ambos chamados';
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
<script>
    const sound = new Audio('public/sounds/chamada.mp3')
    document.querySelector('button, submit').addEventListener('click', () => {
        sound.play();
    });

    // //chamar novamente
    // $('.btn-info').click(function () {
    //     if (confirm('Deseja chamar novamente?')) {
    //         alert('chamando');
    //     }
    // });
    // // chamar a página visor.php
    // $('#chamarProximo').click(function () {
    //     alert('Próximo');
    //     $('#conteudo').load('visor.php');
    // });
    //
    // $('#chamarProximoPrioritario').click(function () {
    //     alert('Próximo Prioritário');
    //     $('#conteudo').load('visor.php');
    // });


</script>
</body>
</html>