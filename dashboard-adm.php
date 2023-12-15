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
$admin = New Admin();

$administrador = $admin->carregarDados('1');
$visores = $visor->listarVisores();

$valorVisor = $visor->carregarVisores($id);

if ($valorVisor->getUsuario_adm() == 0){
    $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>Você não tem permissão para acessar essa página!</div>";
    header("Location: dashboard.php");
}

$valorVisorNormal = $valorVisor->getN_chamado_normal();



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

<!--Cabeçalho-->


<div style="text-align: center; padding-top: 30px;">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#zerar-editar" role="tab" aria-controls="zerar" aria-selected="true">
                <i class="fa-solid fa-tv fa-xs"></i> Visor</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="gerar-tab" data-toggle="tab" href="#gerar-senhas" role="tab" aria-controls="profile" aria-selected="false">
                <i class="fa-solid fa-ticket fa-xs"></i> Senhas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="metricas-tab" data-toggle="tab" href="#metricas" role="tab" aria-controls="contact" aria-selected="false">
                <i class="fa-solid fa-chart-line fa-xs"></i> Métricas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="usuarios-tab" data-toggle="tab" href="#usuarios" role="tab" aria-controls="contact" aria-selected="false">
                <i class="fa-solid fa-users fa-xs"></i> Usuários</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="imagens-tab" data-toggle="tab" href="#imagens" role="tab" aria-controls="contact" aria-selected="false">
                <i class="fa-solid fa-person-booth fa-xs"></i> Aparência</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="historico-tab" data-toggle="tab" href="#historico" role="tab" aria-controls="contact" aria-selected="false">
                <i class="fa-solid fa-clock-rotate-left fa-xs"></i> Histórico</a>
        </li>
    </ul>

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="zerar-editar">
            <div style="padding-top: 30px;">

                <!--Aba Aparência Visor-->
                <div class="container" style="text-align: center; padding-top: 30px">
                    <div class="row justify-content-md-center">
                        <table class="table table-striped" >
                            <?php
                            foreach ($visores as $visor) {
                            $id = $visor->getId();
                            $setor = $visor->getSetor();
                            $senhaNormal = $visor->getN_chamado_normal();
                            $senhaPrioritario = $visor->getN_chamado_prioritario();
                            $ult_atualizacao_normal = $visor->getUlt_atualizacao_normal();
                            $ult_atualizacao_prioritario = $visor->getUlt_atualizacao_prioritario();

                            if ($setor != 'ADMINISTRAÇÃO') {
                            ?>
                            <thead>
                            <tr>
                                <th colspan="3"><?php echo $setor; ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <form method="post" action="adm.php">
                                <tr>
                                    <td>Atendimento Normal</td>
                                    <td><?php echo $senhaNormal; ?></td>
                                    <td>
                                        <!--                                            <button type="submit" name="zerar-normal" class="btn btn-outline-info" data-toggle="tooltip" data-placement="top" title="Zerar">-->
                                        <button type="submit" name="zerar-normal" value="<?php echo $id; ?>" class="btn btn-outline-info" title="Zerar">
                                            <i class="fa-solid fa-rotate-left" ></i>
                                        </button>

                                        <!--                                            Modal Editar-->
                                        <!--                                            <div class="modal fade" id="modalExemplo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">-->
                                        <!--                                                <div class="modal-dialog" role="document">-->
                                        <!--                                                    <div class="modal-content">-->
                                        <!--                                                        <div class="modal-header">-->
                                        <!--                                                            <h5 class="modal-title" id="exampleModalLabel">Editar</h5>-->
                                        <!--                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">-->
                                        <!--                                                                <span aria-hidden="true">&times;</span>-->
                                        <!--                                                            </button>-->
                                        <!--                                                        </div>-->
                                        <!--                                                        <div class="modal-body">-->
                                        <!---->
                                        <!--                                                        </div>-->
                                        <!--                                                        <div class="modal-footer">-->
                                        <!--                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>-->
                                        <!--                                                            <button type="button" class="btn btn-primary">Salvar</button>-->
                                        <!--                                                        </div>-->
                                        <!--                                                    </div>-->
                                        <!--                                                </div>-->
                                        <!--                                            </div>-->

                                        <!--                                            <button type="button" name="editar-normal" class="btn btn-outline-warning" data-toggle="tooltip" data-placement="bottom" title="Editar" disabled>-->
                                        <!--                                            <button type="button" name="editar-normal" class="btn btn-outline-warning" data-toggle="modal" data-target="#modalExemplo" title="Editar">-->
                                        <!--                                            <input type="number" name="valorNormal">-->
                                        <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target="#modalExemplo">
                                            <i class="fa-solid fa-pencil"></i>
                                        </button>
                                    </td>
                                </tr>

                                <?php
                                    if ($administrador->getAtivar_prioritario() == 1) {
                                ?>

                                <tr>
                                    <td>Atendimento Prioritário</td>
                                    <td><?php echo $senhaPrioritario; ?></td>
                                    <td>
                                        <!--                                            <button type="button" name="zerar-prioritario" class="btn btn-outline-info" data-toggle="tooltip" data-placement="top" title="Zerar">-->
                                        <button type="submit" name="zerar-prioritario" value="<?php echo $id; ?>" class="btn btn-outline-info" title="Zerar">
                                            <i class="fa-solid fa-rotate-left" ></i>
                                        </button>
                                        <!--                                            <button type="button" name="editar-prioritario" class="btn btn-outline-warning" data-toggle="tooltip" data-placement="bottom" title="Editar" disabled>-->
                                        <button type="button" name="editar-prioritario" class="btn btn-outline-warning" title="Editar" disabled>
                                            <i class="fa-solid fa-pencil"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php
                                    }
                                    ?>
                            </form>
                            <?php
                            }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="ligar_prioritario" name="ligar_prioritario" value="<?php echo $administrador->getAtivar_prioritario(); ?>" <?php if ($administrador->getAtivar_prioritario() == 1) { echo 'checked'; } ?>>
                    <label class="custom-control-label" for="ligar_prioritario"> Atendimento Prioritário</label>
                </div>

                <?php var_dump($administrador->getAtivar_prioritario()); ?>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="ligar_normal" <?php if ($administrador->getAtivar_prioritario() == 1) { echo 'disabled';} ?>>
                    <label class="custom-control-label" for="flexSwitchCheckDefault"> Renomear Atendimento Normal</label>
                </div>
                <div>
                    <input type="text" <?php if ($administrador->getAtivar_prioritario() == 1) { echo 'disabled'; } ?>>
                </div>
<!--                <div class="toggle">-->
<!--                    <div class="custom-control custom-switch">-->
<!--                        <input type="checkbox"-->
<!--                               class="custom-control-input"-->
<!--                               id="toggleSwitches">-->
<!--                        <label class="custom-control-label"-->
<!--                               for="toggleSwitches">-->
<!--                            TOGGLE</label>-->
<!--                    </div>-->
<!--                </div>-->
            </div>
        </div>


        <!--                Aba Senhas ADM-->
        <div role="tabpanel" class="tab-pane" id="gerar-senhas">
            <div style="padding-top: 30px;">
                <form>
                    <fieldset>
                        <legend>Gerador de Senhas</legend>
                        <p>
                            <input type="radio">
                            <label>Gerar a partir de métricas</label>
                        </p>
                        <p>
                            <input type="radio">
                            <label>Gerar a partir de valores informados</label>
                        </p>
                    </fieldset>
                    <p>
                        <label>Informe valores iniciais e final:</label>
                        <input type="number"> a <input type="number">
                    </p>
                </form>
            </div>
        </div>
        <!--                <div role="tabpanel" class="tab-pane" id="gerar-senhas">-->
        <!--                    <div style="padding-top: 30px;">-->
        <!--                        <div class="form-check form-switch">-->
        <!--                            <input class="form-check-input" type="radio" id="gerar-com-metricas">-->
        <!--                            <label class="custom-control-label" for="gerar-com-metricas">Gerar senhas a partir dos valores em métricas</label>-->
        <!--                        </div>-->
        <!--                        <div class="form-check form-switch">-->
        <!--                            <input class=form-check-input" type="radio" id="gerar-com-numeros">-->
        <!--                            <label class="custom-control-label" for="gerar-com-numeros">Gerar a partir dos valores informados abaixo</label>-->
        <!--                            <div>-->
        <!--                                <label>Informe o valor inicial e final:</label>-->
        <!--                                <div>-->
        <!--                                    <input type="number"> a <input type="number">-->
        <!--                                </div>-->
        <!--                            </div>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </div>-->



        <!--                Aba Métricas ADM-->
        <div role="tabpanel" class="tab-pane" id="metricas">
            <div style="padding-top: 30px;">
                <p>Análise de Métricas de Atendimento</p>
            </div>
        </div>

        <!--                Aba Usuários ADM-->
        <div role="tabpanel" class="tab-pane" id="usuarios">
            <div style="padding-top: 30px;">
                <div class="container" style="text-align: center">
                    <div class="row justify-content-md-center">
                        <table class="table table-striped" >
                            <thead>
                            <tr>
                                <th>LOCAL/SETOR</th>
                                <th>USUÁRIO</th>
                                <th>E-MAIL</th>
                                <th>AÇÃO</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($visores as $visor) {
                                $id = $visor->getId();
                                $email = $visor->getEmail();
                                $setor = $visor->getSetor();
                                $usuario = $visor->getNome_usuario();
                                $usuario_adm = $visor->getUsuario_adm();

                                ?>
                                <form method="post" action="adm.php">
                                    <tr>

                                        <td>
                                            <?php
                                            if($usuario_adm == 1) {
                                                echo "<i class='fa-solid fa-star-half-stroke'  style='color: #ffd75e;' title='Administrador'></i>";
                                            }
                                            echo $setor; ?>
                                        </td>
                                        <td><?php echo $usuario; ?></td>
                                        <td><?php echo $email; ?></td>
                                        <td>
                                            <!--                                            <button type="submit" name="zerar-normal" class="btn btn-outline-info" data-toggle="tooltip" data-placement="top" title="Zerar">-->
                                            <button type="submit" name="zerar-normal" value="<?php echo $id; ?>" class="btn btn-outline-info" title="Zerar">
                                                <i class="fa-solid fa-rotate-left" ></i>
                                            </button>

                                            <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target="#modalExemplo">
                                                <i class="fa-solid fa-pencil"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </form>
                                <?php

                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!--                Aba imagens ADM-->
        <div role="tabpanel" class="tab-pane" id="imagens">
            <div style="padding-top: 30px;">
                <p>Troca e inserção de imagens no visor, cabeçalho, rodapé e menu login</p>
            </div>
        </div>

        <!--                Aba Histórico-->
        <div role="tabpanel" class="tab-pane" id="historico">
            <div style="padding-top: 30px;">
                <p>Histórico de acontecimentos e mudanças realizadas no sistema.</p>
            </div>
        </div>
        <!--                termina aqui-->

    </div>
</div>
<script>
    document.getElementById("ligar_prioritario").onclick = function () {
        if (ligar_prioritario.checked) {
            alert('ATIVADO');
        } else {
            var resultado = confirm("Deseja realmente DESATIVAR a funcão de chamados Prioritários?");
            if (resultado == true) {
                alert("Função desativada com sucesso!");
            } else {
                alert("A função permanecerá ativa!");
                
        }
        }
    }
</script>
<!--Rodapé-->
<?php
include_once '../VisorLA/footer.php';

