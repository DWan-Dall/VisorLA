<?php
require_once '../VisorLA/model/Visor.php';
require_once '../VisorLA/model/Admin.php';

$visor = new Visor();
$visor = $visor->listarVisores();

$admin = new Admin();
$administrador = $admin->carregarDados('1');


//if (isset($_POST["normal"])){
//    $_SESSION['n_chamado_normal'] +=1;
////    header('Location: http://localhost:63342/VisorLA/visor.php?res=01');
//    header("Location: dashboard.php");
//}
//
//if (isset($_POST["prioritario"])){
//    $_SESSION['n_chamado_prioritario'] +=1;
//    header("Location: dashboard.php");
//}
//
//



//$post = $_REQUEST['res'];
////$get = $_GET;
//var_dump($post);
//var_dump($get);
//var_dump($_SESSION);


////Se funcionar, talvez tire o reload
//if ($_REQUEST['res'] == 01) {
//    echo "<script>
//
//          </script>";
//}



?>

<!DOCTYPE html>
<html lang="br">
<head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="style.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<!--    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>-->
<!--    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
    <meta charset="UTF-8">
    <title>Visor</title>
    <style>
        #numeracao {
            opacity: 1;
            transition-duration: 0.5s;
        }
    </style>
</head>
<body style="text-align: center; margin-top: 2%;">
<script>
    $(function () {
        setTimeout(function () {
            window.location.reload(1);
        }, 2000);

    });
</script>
<div style="text-align: center; inset-inline: 10px">
    <img src="public/images/BRASAO_REDIMENSIONADO.jpg" alt="Brasão Luiz Alves" style="width: 5%"/>
    <h3 class="secretaria">SECRETARIA MUNICIPAL DE SAÚDE</h3>
</div>
<div id="conteudo">
<?php
foreach ($visor as $visores) {
    $id = $visores->getId();
    $local = $visores->getSetor();
    $senhaNormal = $visores->getN_chamado_normal();
    $senhaPrioritario = $visores->getN_chamado_prioritario();
    $ult_atualizacao_normal = $visores->getUlt_atualizacao_normal();
    $ult_atualizacao_prioritario = $visores->getUlt_atualizacao_prioritario();

    if ($local != 'ADMINISTRAÇÃO') {
        if ($administrador->getAtivar_prioritario() == 1) {
?>
    <div  class="div-inline" style="text-align: center; margin-top: 5%;">
        <p class="setor"><?php echo $local; ?></p>
        <?php
            if ($ult_atualizacao_prioritario >= $ult_atualizacao_normal) {
        ?>
        <p class="prioridade"><?php echo  'PRIORITÁRIO'; ?></p>
        <p class="numeracao" id="numeracao"><?php echo $senhaPrioritario; ?></p>
                <?php
            } else {
                ?>
        <p class="prioridade-normal"><?php echo 'NORMAL'; ?></p>
        <p class="numeracao" id="numeracao"><?php echo $senhaNormal; ?></p>
        <?php
            }
            ?>
            </div>
    <?php
        } ?>

    <div  class="div-inline" style="text-align: center; margin-top: 5%;">
        <p class="setor"><?php echo $local; ?></p>

        <p class="prioridade-normal"><?php echo 'NORMAL'; ?></p>
        <p class="numeracao" id="numeracao"><?php echo $senhaNormal; ?></p>
    </div>
    <?php
    }

//    date_default_timezone_set('America/Sao_Paulo');
//    $now = date('Y-m-d H:i:s');
//    var_dump($ult_atualizacao_normal);
//    var_dump($ult_atualizacao_prioritario);
//    var_dump($now);
//    if (($ult_atualizacao_normal || $ult_atualizacao_prioritario) == $now) {
//        echo "<script type='text/javascript'>
//                var teste = 0;
//                setInterval(piscar, 400);
//                function piscar(){
//                    if(teste<1) {
//                        teste++;
//                        document.getElementById('numeracao').style.opacity = '1';
//                    } else {
//                        teste = 0;
//                        document.getElementById('numeracao').style.opacity = '0';
//                    }
//                }
//
//                var audio = new Audio('public/sounds/chamada.mp3');
//                    audio.play();
//              </script>";
//    }
}
    ?>
</div>
<img src="public/images/Footer%20Luiz%20Alves.png" alt="Rodapé-Luiz-Alves" style="margin-left: 5%; opacity: 38%;">
<footer class="footer mt-4 pt-4 pt-md-4 border-top">
    <div class="col-12 col-md text-center" style="padding-bottom: 5px;">
        <small class="d-block mb-3 text-muted">
            &copy; <?php echo (new DateTime('now'))->format('Y'); ?> - Desenvolvido por Irmãos Wan-Dall
            <br>
            <a class="underlineHover" href="index.php">Acessar Login</a>
        </small>
    </div>
</footer>
</body>
</html>