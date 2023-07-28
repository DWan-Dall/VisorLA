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
$visores = $visor->listarVisores();
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
    <link href="public/fontawesome/css/all.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link href="style.css" rel="stylesheet">
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
<?php if($_SESSION['local'] != 'ADMINISTRAÇÃO') {?>
<div style="text-align: center; padding-top: 40px;">
    <h2 style="color: #28a645">Atendimento NORMAL</h2>
    <br>
    <h3>Número atual: <?php echo $chamadoNormal; ?></h3>
    <form method="post" action="chamados.php">
        <button type="button" class="btn btn-info" id="chamarNovamente">Chamar Novamente</button>
<!--        <input type="hidden" name="contador" value="--><?php //echo $chamadoNormal ?? 1; ?><!--">-->
        <button type="submit" name="normal" class="btn btn-success" id="chamarProximo">Chamar Próximo</button>
    </form>

</div>
<div style="text-align: center; padding-top: 30px;">
    <h2 style="color: #db3545">Atendimento PRIORITÁRIO</h2>
    <br>
    <h3>Número atual: <?php echo $chamadoPrioritario; ?></h3>
    <form method="post" action="chamados.php">
        <button type="button" class="btn btn-info" id="chamarNovamente">Chamar Novamente</button>
<!--        <input type="hidden" name="contador" value="--><?php //echo $chamadoPrioritario ?? 1; ?><!--">-->
        <button type="submit" name="prioritario" class="btn btn-danger" id="chamarProximoPrioritario">Chamar Próximo</button>
    </form>
</div>

<!--<div id="conteudo"></div>-->

<?php
}
    if($_SESSION['local'] == 'ADMINISTRAÇÃO') { ?>

        <div style="text-align: center; padding-top: 30px;">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#zerar-editar" role="tab" aria-controls="zerar" aria-selected="true">Zerar/Editar Contadores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="gerar-tab" data-toggle="tab" href="#gerar-senhas" role="tab" aria-controls="profile" aria-selected="false">Gerar Senhas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="metricas-tab" data-toggle="tab" href="#metricas" role="tab" aria-controls="contact" aria-selected="false">Análise de Métricas de Atendimento</a>
                </li>
            </ul>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="zerar-editar">
                    <div style="padding-top: 30px;">
<!--                        Aba tabela para zerar/editar visor-->
                        <div class="container" style="text-align: center">
                            <div class="row justify-content-md-center">
                                <table class="table table-bordered" >

                                    <?php
                                    foreach ($visores as $visor) {
                                    $id = $visor->getId();
                                    $local = $visor->getLocal();
                                    $senhaNormal = $visor->getN_chamado_normal();
                                    $senhaPrioritario = $visor->getN_chamado_prioritario();
                                    $ult_atualizacao_normal = $visor->getUlt_atualizacao_normal();
                                    $ult_atualizacao_prioritario = $visor->getUlt_atualizacao_prioritario();

                                    if ($local != 'ADMINISTRAÇÃO') {
                                    ?>
                                    <thead>
                                    <tr>
                                        <th colspan="3"><?php echo $local; ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="table-active">
                                        <td>Atendimento Normal</td>
                                        <td><?php echo $senhaNormal; ?></td>
                                        <td>
                                            <button type="button" class="btn btn-outline-info" data-toggle="tooltip" data-placement="top" title="Zerar">
                                                <i class="fa-solid fa-rotate-left" ></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-warning" data-toggle="tooltip" data-placement="bottom" title="Editar" disabled>
                                                <i class="fa-solid fa-pencil"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Atendimento Prioritário</td>
                                        <td><?php echo $senhaPrioritario; ?></td>
                                        <td>
                                            <button type="button" class="btn btn-outline-info" data-toggle="tooltip" data-placement="top" title="Zerar">
                                                <i class="fa-solid fa-rotate-left" ></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-warning" data-toggle="tooltip" data-placement="bottom" title="Editar" disabled>
                                                <i class="fa-solid fa-pencil"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php
                        }
                        ?>

                    </div>
                </div>

<!--                Aba gerador de senhas ADM-->
                <div role="tabpanel" class="tab-pane" id="gerar-senhas">
                    <div style="padding-top: 30px;">
                        <p>Gerador de senhas</p>
                    </div>
                </div>

<!--                Aba informativo de métricas ADM-->
                <div role="tabpanel" class="tab-pane" id="metricas">
                    <div style="padding-top: 30px;">
                        <p>Metricas</p>
                    </div>
                </div>

            </div>
        </div>

<img src="public/images/Footer%20Luiz%20Alves.png" style="margin-left: 5%; opacity: 38%;">
<footer class="footer mt-4 pt-4 pt-md-4 border-top">
    <div class="col-12 col-md text-center">
        <small class="d-block mb-3 text-muted">
            &copy; <?php echo (new DateTime('now'))->format('Y'); ?> - Desenvolvido por Irmãos Wan-Dall
        </small>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="public/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    $('#btn-outline-info').tooltip(options)

    // const sound = new Audio('public/sounds/chamada.mp3')
    // document.querySelector('button, submit').addEventListener('click', () => {
    //     sound.play();
    // });

    //chamar novamente
    $('.btn-info').click(function () {
        if (confirm('Deseja chamar novamente?')) {
            // alert('chamando');
        }
    });
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