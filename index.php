<?php
session_start();
ob_start();

include_once '../VisorLA/Application/core/Database.php';

//Exemplo criptografia de senha
// echo password_hash('vila1234', PASSWORD_DEFAULT);

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (!empty($dados['SendLogin'])) {
//    var_dump($dados);
    $query_usuario = "SELECT id, email, setor, senha, nome_usuario, usuario_adm, n_chamado_normal, n_chamado_prioritario
                            FROM acesso
                            WHERE email =:email
                            LIMIT 1";
    $result_usuario = $conn->prepare($query_usuario);
    $result_usuario->bindParam(':email', $dados['email'], PDO::PARAM_STR);
    $result_usuario->execute();

    if (($result_usuario) and ($result_usuario->rowCount() != 0)) {
        $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
//        var_dump($row_usuario);
        if(password_verify($dados['senha'], $row_usuario['senha'])) {
            $_SESSION['id'] = $row_usuario['id'];
            $_SESSION['setor'] = $row_usuario['setor'];
            $_SESSION['nome_usuario'] = $row_usuario['nome_usuario'];
            $_SESSION['n_chamado_normal'] = $row_usuario['n_chamado_normal'];
            $_SESSION['n_chamado_prioritario'] = $row_usuario['n_chamado_prioritario'];
            header("Location: dashboard.php");

        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Usuário ou senha inválidos!</div>";
        }
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Usuário inválido!</div>";
    }
}

?>

<!DOCTYPE html>
<html lang="br">
<head>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="style.css" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <meta charset="UTF-8">
    <title>Login de Usuário</title>
</head>
<body>
<div class="wrapper fadeInDown" style="padding-top: 7% 0 1% 0;">
    <div id="formContent">
        <div class="fadeIn first" style="text-align: center; padding: 5%;">
            <img src="public/images/BRASAO_REDIMENSIONADO.jpg" id="icon" alt="Brasão Luiz Alves"/>
        </div>
        <div style="text-align: center; padding: 5%;">
            <form action="" method="POST">
                <input type="text" id="login" class="fadeIn second" name="email" placeholder="login" value="<?php if(isset($dados['email'])){echo $dados['email']; } ?>">
                <br>
                <input type="password" id="password" class="fadeIn third" name="senha" placeholder="senha" value="<?php if(isset($dados['senha'])){echo $dados['senha']; } ?>">
                <br>
                <input type="submit" class="fadeIn fourth" value="Acessar" name="SendLogin">
                <br>
                <?php
                if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }
                ?>
                <a class="underlineHover" href="cadastro.php">Esqueceu sua senha?</a>
            </form>
            <a class="underlineHover" href="visor.php">Acessar Visor</a>
        </div>
    </div>
</div>
<?php

include_once '../VisorLA/footer-externo.php';

?>